<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 0);

header('Content-Type: application/json');
require_once '../../../session.php';
require_once '../../../connection.php';
require_once '../../../config.php';

// Check user authentication
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit();
}

// Helper function to convert 'Yes'/'No' to 1/0
function convertYesNoToBoolean($value) {
    $value = strtolower(trim($value));
    if ($value === 'yes') {
        return 1;
    } elseif ($value === 'no') {
        return 0;
    } else {
        return null; // or a default value like 0
    }
}
$data = json_decode(file_get_contents('php://input'), true);
$request_id = isset($data['request_id']) ? intval($data['request_id']) : 0;

if ($request_id <= 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid Request ID']);
    exit();
}

// Arrays of new/updated data
$sole_authorship       = isset($data['sole_authorship'])       ? $data['sole_authorship']       : [];
$co_authorship         = isset($data['co_authorship'])         ? $data['co_authorship']         : [];
$lead_researcher       = isset($data['lead_researcher'])       ? $data['lead_researcher']       : [];
$contributor           = isset($data['contributor'])           ? $data['contributor']           : [];
$local_authors         = isset($data['local_authors'])         ? $data['local_authors']         : [];
$international_authors = isset($data['international_authors']) ? $data['international_authors'] : [];

// Deleted record IDs
$deleted_records = isset($data['deleted_records']) ? $data['deleted_records'] : [
    'sole' => [], 
    'co' => [], 
    'lead' => [], 
    'contrib' => [], 
    'local' => [], 
    'international' => []
];

try {
    $conn->beginTransaction();

    // ======= Handle DELETIONS first =======
    // 1) Sole Authorship
    if (!empty($deleted_records['sole'])) {
        $delStmt = $conn->prepare(
            "DELETE FROM kra2_a_sole_authorship
             WHERE sole_authorship_id = :record_id AND request_id = :request_id"
        );
        foreach ($deleted_records['sole'] as $record_id) {
            $delStmt->execute([
                ':record_id'  => $record_id,
                ':request_id' => $request_id
            ]);
        }
    }
    // 2) Co Authorship
    if (!empty($deleted_records['co'])) {
        $delStmt = $conn->prepare(
            "DELETE FROM kra2_a_co_authorship
             WHERE co_authorship_id = :record_id AND request_id = :request_id"
        );
        foreach ($deleted_records['co'] as $record_id) {
            $delStmt->execute([
                ':record_id'  => $record_id,
                ':request_id' => $request_id
            ]);
        }
    }
    // 3) Lead Researcher
    if (!empty($deleted_records['lead'])) {
        $delStmt = $conn->prepare(
            "DELETE FROM kra2_a_lead_researcher
             WHERE lead_researcher_id = :record_id AND request_id = :request_id"
        );
        foreach ($deleted_records['lead'] as $record_id) {
            $delStmt->execute([
                ':record_id'  => $record_id,
                ':request_id' => $request_id
            ]);
        }
    }
    // 4) Contributor
    if (!empty($deleted_records['contrib'])) {
        $delStmt = $conn->prepare(
            "DELETE FROM kra2_a_contributor
             WHERE contributor_id = :record_id AND request_id = :request_id"
        );
        foreach ($deleted_records['contrib'] as $record_id) {
            $delStmt->execute([
                ':record_id'  => $record_id,
                ':request_id' => $request_id
            ]);
        }
    }
    // 5) Local Authors
    if (!empty($deleted_records['local'])) {
        $delStmt = $conn->prepare(
            "DELETE FROM kra2_a_local_authors
             WHERE local_author_id = :record_id AND request_id = :request_id"
        );
        foreach ($deleted_records['local'] as $record_id) {
            $delStmt->execute([
                ':record_id'  => $record_id,
                ':request_id' => $request_id
            ]);
        }
    }
    // 6) International Authors
    if (!empty($deleted_records['international'])) {
        $delStmt = $conn->prepare(
            "DELETE FROM kra2_a_international_authors
             WHERE international_author_id = :record_id AND request_id = :request_id"
        );
        foreach ($deleted_records['international'] as $record_id) {
            $delStmt->execute([
                ':record_id'  => $record_id,
                ':request_id' => $request_id
            ]);
        }
    }

    // ======= UPSERT Sole Authorship =======
    $stmtInsertSole = $conn->prepare("
        INSERT INTO kra2_a_sole_authorship
            (request_id, title, type, journal_publisher, reviewer,
             international, date_published, score, evidence_file, remarks)
        VALUES
            (:request_id, :title, :type, :journal_publisher, :reviewer,
             :international, :date_published, :score, :evidence_file, :remarks)
    ");
    $stmtUpdateSole = $conn->prepare("
        UPDATE kra2_a_sole_authorship
           SET title = :title,
               type = :type,
               journal_publisher = :journal_publisher,
               reviewer = :reviewer,
               international = :international,
               date_published = :date_published,
               score = :score,
               evidence_file = :evidence_file,
               remarks = :remarks
         WHERE sole_authorship_id = :sole_authorship_id
           AND request_id = :request_id
    ");

    foreach ($sole_authorship as $row) {
        $id = isset($row['sole_authorship_id']) ? intval($row['sole_authorship_id']) : 0;
        $title = trim($row['title'] ?? '');
        $type  = trim($row['type'] ?? '');
        $journal_publisher = trim($row['journal_publisher'] ?? '');
        $reviewer = trim($row['reviewer'] ?? '');
        $international = convertYesNoToBoolean($row['international'] ?? '');
        $date_published = $row['date_published'] ?? null;
        $evidence_file  = $row['evidence_file'] ?? '';
        $remarks = trim($row['remarks'] ?? '');

        // Calculate score based on Criterion A rules
        $score = 0;
        if ($title !== '' && $journal_publisher !== '' && $reviewer !== '' && $date_published !== '') {
            switch ($type) {
                case 'Book':
                    $score = 100;
                    break;
                case 'Journal Article':
                    $score = ($international !== '') ? 50 : 0;
                    break;
                case 'Book Chapter':
                    $score = 35;
                    break;
                case 'Monograph':
                    $score = 100;
                    break;
                case 'Other Peer-Reviewed Output':
                    $score = 10;
                    break;
                default:
                    $score = 0;
            }
        }

        // Insert or update
        if ($id === 0) {
            // Insert new row
            $stmtInsertSole->execute([
                ':request_id'        => $request_id,
                ':title'             => $title,
                ':type'              => $type,
                ':journal_publisher' => $journal_publisher,
                ':reviewer'          => $reviewer,
                ':international'     => $international, // Converted value
                ':date_published'    => $date_published ?: null,
                ':score'             => $score,
                ':evidence_file'     => $evidence_file,
                ':remarks'           => $remarks
            ]);
        } else {
            // Update existing row
            $stmtUpdateSole->execute([
                ':title'             => $title,
                ':type'              => $type,
                ':journal_publisher' => $journal_publisher,
                ':reviewer'          => $reviewer,
                ':international'     => $international, // Converted value
                ':date_published'    => $date_published ?: null,
                ':score'             => $score,
                ':evidence_file'     => $evidence_file,
                ':remarks'           => $remarks,
                ':sole_authorship_id'=> $id,
                ':request_id'        => $request_id
            ]);
        }
    }

    // ======= UPSERT Co Authorship =======
    $stmtInsertCo = $conn->prepare("
        INSERT INTO kra2_a_co_authorship
            (request_id, title, type, journal_publisher, reviewer,
             international, date_published, contribution_percentage,
             score, evidence_file, remarks)
        VALUES
            (:request_id, :title, :type, :journal_publisher, :reviewer,
             :international, :date_published, :contribution_percentage,
             :score, :evidence_file, :remarks)
    ");
    $stmtUpdateCo = $conn->prepare("
        UPDATE kra2_a_co_authorship
           SET title = :title,
               type = :type,
               journal_publisher = :journal_publisher,
               reviewer = :reviewer,
               international = :international,
               date_published = :date_published,
               contribution_percentage = :contribution_percentage,
               score = :score,
               evidence_file = :evidence_file,
               remarks = :remarks
         WHERE co_authorship_id = :co_authorship_id
           AND request_id = :request_id
    ");

    foreach ($co_authorship as $row) {
        $id = isset($row['co_authorship_id']) ? intval($row['co_authorship_id']) : 0;
        $title = trim($row['title'] ?? '');
        $type  = trim($row['type'] ?? '');
        $journal_publisher = trim($row['journal_publisher'] ?? '');
        $reviewer = trim($row['reviewer'] ?? '');
        $international = trim($row['international'] ?? '');
        $date_published = $row['date_published'] ?? null;
        $contribution_percentage = isset($row['contribution_percentage']) ? floatval($row['contribution_percentage']) : 0;
        $evidence_file  = $row['evidence_file'] ?? '';
        $remarks = trim($row['remarks'] ?? '');

        // Calculate score based on Criterion A rules
        $score = 0;
        if ($title !== '' && $date_published !== '') {
            switch ($type) {
                case 'Book':
                    $score = 100;
                    break;
                case 'Journal Article':
                    $score = ($international === '') ? 50 : 0;
                    break;
                case 'Book Chapter':
                    $score = 35;
                    break;
                case 'Monograph':
                    $score = 100;
                    break;
                case 'Other Peer-Reviewed Output':
                    $score = 10;
                    break;
                default:
                    $score = 0;
            }

            // Multiply by contribution percentage
            $score *= ($contribution_percentage / 100);
        }

        // Insert or update
        if ($id === 0) {
            // Insert new row
            $stmtInsertCo->execute([
                ':request_id'             => $request_id,
                ':title'                  => $title,
                ':type'                   => $type,
                ':journal_publisher'      => $journal_publisher,
                ':reviewer'               => $reviewer,
                ':international'          => $international,
                ':date_published'         => $date_published ?: null,
                ':contribution_percentage'=> $contribution_percentage,
                ':score'                  => $score,
                ':evidence_file'          => $evidence_file,
                ':remarks'                => $remarks
            ]);
        } else {
            // Update existing row
            $stmtUpdateCo->execute([
                ':title'                  => $title,
                ':type'                   => $type,
                ':journal_publisher'      => $journal_publisher,
                ':reviewer'               => $reviewer,
                ':international'          => $international,
                ':date_published'         => $date_published ?: null,
                ':contribution_percentage'=> $contribution_percentage,
                ':score'                  => $score,
                ':evidence_file'          => $evidence_file,
                ':remarks'                => $remarks,
                ':co_authorship_id'       => $id,
                ':request_id'             => $request_id
            ]);
        }
    }

    // ======= UPSERT Lead Researcher =======
    $stmtInsertLead = $conn->prepare("
        INSERT INTO kra2_a_lead_researcher
            (request_id, title, date_completed, project_name, funding_source,
             date_implemented, score, evidence_file, remarks)
        VALUES
            (:request_id, :title, :date_completed, :project_name, :funding_source,
             :date_implemented, :score, :evidence_file, :remarks)
    ");
    $stmtUpdateLead = $conn->prepare("
        UPDATE kra2_a_lead_researcher
           SET title = :title,
               date_completed = :date_completed,
               project_name = :project_name,
               funding_source = :funding_source,
               date_implemented = :date_implemented,
               score = :score,
               evidence_file = :evidence_file,
               remarks = :remarks
         WHERE lead_researcher_id = :lead_researcher_id
           AND request_id = :request_id
    ");

    foreach ($lead_researcher as $row) {
        $id = isset($row['lead_researcher_id']) ? intval($row['lead_researcher_id']) : 0;
        $title = trim($row['title'] ?? '');
        $date_completed = $row['date_completed'] ?? null;
        $project_name = trim($row['project_name'] ?? '');
        $funding_source = trim($row['funding_source'] ?? '');
        $date_implemented = $row['date_implemented'] ?? null;
        $evidence_file  = $row['evidence_file'] ?? '';
        $remarks = trim($row['remarks'] ?? '');

        // Calculate score based on Criterion A rules
        $score = 0;
        if ($title !== '' && $date_completed !== '' && $project_name !== '' && $funding_source !== '' && $date_implemented !== '') {
            $score = 35;
        }

        // Insert or update
        if ($id === 0) {
            // Insert new row
            $stmtInsertLead->execute([
                ':request_id'        => $request_id,
                ':title'             => $title,
                ':date_completed'    => $date_completed ?: null,
                ':project_name'      => $project_name,
                ':funding_source'    => $funding_source,
                ':date_implemented'  => $date_implemented ?: null,
                ':score'             => $score,
                ':evidence_file'     => $evidence_file,
                ':remarks'           => $remarks
            ]);
        } else {
            // Update existing row
            $stmtUpdateLead->execute([
                ':title'             => $title,
                ':date_completed'    => $date_completed ?: null,
                ':project_name'      => $project_name,
                ':funding_source'    => $funding_source,
                ':date_implemented'  => $date_implemented ?: null,
                ':score'             => $score,
                ':evidence_file'     => $evidence_file,
                ':remarks'           => $remarks,
                ':lead_researcher_id'=> $id,
                ':request_id'        => $request_id
            ]);
        }
    }

    // ======= UPSERT Contributor =======
    $stmtInsertContrib = $conn->prepare("
        INSERT INTO kra2_a_contributor
            (request_id, title, date_completed, project_name, funding_source,
             date_implemented, contribution_percentage, score, evidence_file, remarks)
        VALUES
            (:request_id, :title, :date_completed, :project_name, :funding_source,
             :date_implemented, :contribution_percentage, :score, :evidence_file, :remarks)
    ");
    $stmtUpdateContrib = $conn->prepare("
        UPDATE kra2_a_contributor
           SET title = :title,
               date_completed = :date_completed,
               project_name = :project_name,
               funding_source = :funding_source,
               date_implemented = :date_implemented,
               contribution_percentage = :contribution_percentage,
               score = :score,
               evidence_file = :evidence_file,
               remarks = :remarks
         WHERE contributor_id = :contributor_id
           AND request_id = :request_id
    ");

    foreach ($contributor as $row) {
        $id = isset($row['contributor_id']) ? intval($row['contributor_id']) : 0;
        $title = trim($row['title'] ?? '');
        $date_completed = $row['date_completed'] ?? null;
        $project_name = trim($row['project_name'] ?? '');
        $funding_source = trim($row['funding_source'] ?? '');
        $date_implemented = $row['date_implemented'] ?? null;
        $contribution_percentage = isset($row['contribution_percentage']) ? floatval($row['contribution_percentage']) : 0;
        $evidence_file  = $row['evidence_file'] ?? '';
        $remarks = trim($row['remarks'] ?? '');

        // Calculate score based on Criterion A rules
        $score = 0;
        if ($title !== '' && $date_completed !== '' && $project_name !== '' && $funding_source !== '' && $date_implemented !== '') {
            $score = 35 * ($contribution_percentage / 100);
        }

        // Insert or update
        if ($id === 0) {
            // Insert new row
            $stmtInsertContrib->execute([
                ':request_id'             => $request_id,
                ':title'                  => $title,
                ':date_completed'         => $date_completed ?: null,
                ':project_name'           => $project_name,
                ':funding_source'         => $funding_source,
                ':date_implemented'       => $date_implemented ?: null,
                ':contribution_percentage'=> $contribution_percentage,
                ':score'                  => $score,
                ':evidence_file'          => $evidence_file,
                ':remarks'                => $remarks
            ]);
        } else {
            // Update existing row
            $stmtUpdateContrib->execute([
                ':title'                  => $title,
                ':date_completed'         => $date_completed ?: null,
                ':project_name'           => $project_name,
                ':funding_source'         => $funding_source,
                ':date_implemented'       => $date_implemented ?: null,
                ':contribution_percentage'=> $contribution_percentage,
                ':score'                  => $score,
                ':evidence_file'          => $evidence_file,
                ':remarks'                => $remarks,
                ':contributor_id'         => $id,
                ':request_id'             => $request_id
            ]);
        }
    }

    // ======= UPSERT Local Authors =======
    $stmtInsertLocal = $conn->prepare("
        INSERT INTO kra2_a_local_authors
            (request_id, title, date_published, journal_name, citation_count,
             citation_index, citation_year, score, evidence_file, remarks)
        VALUES
            (:request_id, :title, :date_published, :journal_name, :citation_count,
             :citation_index, :citation_year, :score, :evidence_file, :remarks)
    ");
    $stmtUpdateLocal = $conn->prepare("
        UPDATE kra2_a_local_authors
           SET title = :title,
               date_published = :date_published,
               journal_name = :journal_name,
               citation_count = :citation_count,
               citation_index = :citation_index,
               citation_year = :citation_year,
               score = :score,
               evidence_file = :evidence_file,
               remarks = :remarks
         WHERE local_author_id = :local_author_id
           AND request_id = :request_id
    ");

    foreach ($local_authors as $row) {
        $id = isset($row['local_author_id']) ? intval($row['local_author_id']) : 0;
        $title = trim($row['title'] ?? '');
        $date_published = $row['date_published'] ?? null;
        $journal_name = trim($row['journal_name'] ?? '');
        $citation_count = isset($row['citation_count']) ? intval($row['citation_count']) : 0;
        $citation_index = trim($row['citation_index'] ?? '');
        $citation_year = $row['citation_year'] ?? null;
        $evidence_file  = $row['evidence_file'] ?? '';
        $remarks = trim($row['remarks'] ?? '');

        // Calculate score based on Criterion A rules
        $score = $citation_count * 5;

        // Insert or update
        if ($id === 0) {
            // Insert new row
            $stmtInsertLocal->execute([
                ':request_id'        => $request_id,
                ':title'             => $title,
                ':date_published'    => $date_published ?: null,
                ':journal_name'      => $journal_name,
                ':citation_count'    => $citation_count,
                ':citation_index'    => $citation_index,
                ':citation_year'     => $citation_year ?: null,
                ':score'             => $score,
                ':evidence_file'     => $evidence_file,
                ':remarks'           => $remarks
            ]);
        } else {
            // Update existing row
            $stmtUpdateLocal->execute([
                ':title'             => $title,
                ':date_published'    => $date_published ?: null,
                ':journal_name'      => $journal_name,
                ':citation_count'    => $citation_count,
                ':citation_index'    => $citation_index,
                ':citation_year'     => $citation_year ?: null,
                ':score'             => $score,
                ':evidence_file'     => $evidence_file,
                ':remarks'           => $remarks,
                ':local_author_id'   => $id,
                ':request_id'        => $request_id
            ]);
        }
    }

    // ======= UPSERT International Authors =======
    $stmtInsertIntl = $conn->prepare("
        INSERT INTO kra2_a_international_authors
            (request_id, title, date_published, journal_name, citation_count,
             citation_index, citation_year, score, evidence_file, remarks)
        VALUES
            (:request_id, :title, :date_published, :journal_name, :citation_count,
             :citation_index, :citation_year, :score, :evidence_file, :remarks)
    ");
    $stmtUpdateIntl = $conn->prepare("
        UPDATE kra2_a_international_authors
           SET title = :title,
               date_published = :date_published,
               journal_name = :journal_name,
               citation_count = :citation_count,
               citation_index = :citation_index,
               citation_year = :citation_year,
               score = :score,
               evidence_file = :evidence_file,
               remarks = :remarks
         WHERE international_author_id = :international_author_id
           AND request_id = :request_id
    ");

    foreach ($international_authors as $row) {
        $id = isset($row['international_author_id']) ? intval($row['international_author_id']) : 0;
        $title = trim($row['title'] ?? '');
        $date_published = $row['date_published'] ?? null;
        $journal_name = trim($row['journal_name'] ?? '');
        $citation_count = isset($row['citation_count']) ? intval($row['citation_count']) : 0;
        $citation_index = trim($row['citation_index'] ?? '');
        $citation_year = $row['citation_year'] ?? null;
        $evidence_file  = $row['evidence_file'] ?? '';
        $remarks = trim($row['remarks'] ?? '');

        // Calculate score based on Criterion A rules
        $score = $citation_count * 10;

        // Insert or update
        if ($id === 0) {
            // Insert new row
            $stmtInsertIntl->execute([
                ':request_id'        => $request_id,
                ':title'             => $title,
                ':date_published'    => $date_published ?: null,
                ':journal_name'      => $journal_name,
                ':citation_count'    => $citation_count,
                ':citation_index'    => $citation_index,
                ':citation_year'     => $citation_year ?: null,
                ':score'             => $score,
                ':evidence_file'     => $evidence_file,
                ':remarks'           => $remarks
            ]);
        } else {
            // Update existing row
            $stmtUpdateIntl->execute([
                ':title'                 => $title,
                ':date_published'        => $date_published ?: null,
                ':journal_name'          => $journal_name,
                ':citation_count'        => $citation_count,
                ':citation_index'        => $citation_index,
                ':citation_year'         => $citation_year ?: null,
                ':score'                 => $score,
                ':evidence_file'         => $evidence_file,
                ':remarks'               => $remarks,
                ':international_author_id'=> $id,
                ':request_id'            => $request_id
            ]);
        }
    }

    // ======= COMPUTE METADATA =======
    // Calculate totals for each sub-criterion
    // 1) Sole Authorship Total
    $stmt = $conn->prepare("
        SELECT SUM(score) as sole_total
        FROM kra2_a_sole_authorship
        WHERE request_id = :request_id
    ");
    $stmt->execute([':request_id' => $request_id]);
    $sole_total = floatval($stmt->fetch(PDO::FETCH_ASSOC)['sole_total'] ?? 0);

    // 2) Co Authorship Total
    $stmt = $conn->prepare("
        SELECT SUM(score) as co_total
        FROM kra2_a_co_authorship
        WHERE request_id = :request_id
    ");
    $stmt->execute([':request_id' => $request_id]);
    $co_total = floatval($stmt->fetch(PDO::FETCH_ASSOC)['co_total'] ?? 0);

    // 3) Lead Researcher Total
    $stmt = $conn->prepare("
        SELECT SUM(score) as lead_total
        FROM kra2_a_lead_researcher
        WHERE request_id = :request_id
    ");
    $stmt->execute([':request_id' => $request_id]);
    $lead_total = floatval($stmt->fetch(PDO::FETCH_ASSOC)['lead_total'] ?? 0);

    // 4) Contributor Total
    $stmt = $conn->prepare("
        SELECT SUM(score) as contrib_total
        FROM kra2_a_contributor
        WHERE request_id = :request_id
    ");
    $stmt->execute([':request_id' => $request_id]);
    $contrib_total = floatval($stmt->fetch(PDO::FETCH_ASSOC)['contrib_total'] ?? 0);

    // 5) Local Authors Total
    $stmt = $conn->prepare("
        SELECT SUM(score) as local_total
        FROM kra2_a_local_authors
        WHERE request_id = :request_id
    ");
    $stmt->execute([':request_id' => $request_id]);
    $local_total = floatval($stmt->fetch(PDO::FETCH_ASSOC)['local_total'] ?? 0);

    // 6) International Authors Total
    $stmt = $conn->prepare("
        SELECT SUM(score) as international_total
        FROM kra2_a_international_authors
        WHERE request_id = :request_id
    ");
    $stmt->execute([':request_id' => $request_id]);
    $international_total = floatval($stmt->fetch(PDO::FETCH_ASSOC)['international_total'] ?? 0);

    // Calculate Overall Score
    $overall_score = $sole_total + $co_total + $lead_total + $contrib_total + $local_total + $international_total;

    // Update or Insert Metadata
    $stmtMeta = $conn->prepare("SELECT metadata_id FROM kra2_a_metadata WHERE request_id = :request_id");
    $stmtMeta->execute([':request_id' => $request_id]);
    $existingMeta = $stmtMeta->fetch(PDO::FETCH_ASSOC);

    if ($existingMeta) {
        // Update existing metadata
        $stmtUpdateMeta = $conn->prepare("
            UPDATE kra2_a_metadata
               SET sole_authorship_total = :sole_total,
                   co_authorship_total   = :co_total,
                   lead_researcher_total = :lead_total,
                   contributor_total     = :contrib_total,
                   local_authors_total   = :local_total,
                   international_authors_total = :international_total,
                   overall_score         = :overall_score
             WHERE metadata_id = :metadata_id
        ");
        $stmtUpdateMeta->execute([
            ':sole_total'                => $sole_total,
            ':co_total'                  => $co_total,
            ':lead_total'                => $lead_total,
            ':contrib_total'             => $contrib_total,
            ':local_total'               => $local_total,
            ':international_total'       => $international_total,
            ':overall_score'             => $overall_score,
            ':metadata_id'               => $existingMeta['metadata_id']
        ]);
    } else {
        // Insert new metadata
        $stmtInsertMeta = $conn->prepare("
            INSERT INTO kra2_a_metadata
                (request_id, sole_authorship_total, co_authorship_total, 
                 lead_researcher_total, contributor_total, local_authors_total, 
                 international_authors_total, overall_score)
            VALUES
                (:request_id, :sole_total, :co_total, 
                 :lead_total, :contrib_total, :local_total, 
                 :international_total, :overall_score)
        ");
        $stmtInsertMeta->execute([
            ':request_id'                => $request_id,
            ':sole_total'                => $sole_total,
            ':co_total'                  => $co_total,
            ':lead_total'                => $lead_total,
            ':contrib_total'             => $contrib_total,
            ':local_total'               => $local_total,
            ':international_total'       => $international_total,
            ':overall_score'             => $overall_score
        ]);
    }

    $conn->commit();
    echo json_encode([
        'success' => true,
        'message' => 'Criterion A saved and recalculated successfully.'
    ]);

} catch (Exception $e) {
    $conn->rollBack();
    echo json_encode([
        'success' => false,
        'error'   => 'Failed to save Criterion A: ' . $e->getMessage()
    ]);
}
?>
