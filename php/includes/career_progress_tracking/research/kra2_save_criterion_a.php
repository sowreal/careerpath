<?php
// careerpath/php/includes/career_progress_tracking/research/kra2_save_criterion_a.php
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

$data = json_decode(file_get_contents('php://input'), true);
$request_id = isset($data['request_id']) ? intval($data['request_id']) : 0;

if ($request_id <= 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid Request ID']);
    exit();
}

// Arrays of new/updated data
$sole_authorship        = isset($data['sole_authorship'])          ? $data['sole_authorship']          : [];
$co_authorship          = isset($data['co_authorship'])            ? $data['co_authorship']            : [];
$lead_researcher        = isset($data['lead_researcher'])          ? $data['lead_researcher']          : [];
$contributor            = isset($data['contributor'])              ? $data['contributor']              : [];
$local_authors          = isset($data['local_authors'])            ? $data['local_authors']            : [];
$international_authors  = isset($data['international_authors'])    ? $data['international_authors']    : [];

// Deleted record IDs
$deleted_records = isset($data['deleted_records']) ? $data['deleted_records'] : [
    'sole' => [], 'co' => [], 'lead' => [], 'contributor' => [], 'local' => [], 'international' => []
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
    if (!empty($deleted_records['contributor'])) {
        $delStmt = $conn->prepare(
            "DELETE FROM kra2_a_contributor
             WHERE contributor_id = :record_id AND request_id = :request_id"
        );
        foreach ($deleted_records['contributor'] as $record_id) {
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
            (request_id, title, type, journal_publisher, reviewer, international, date_published, score, evidence_file)
        VALUES
            (:request_id, :title, :type, :journal_publisher, :reviewer, :international, :date_published, :score, :evidence_file)
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
            evidence_file = :evidence_file
        WHERE sole_authorship_id = :sole_authorship_id
        AND request_id = :request_id
    ");

    foreach ($sole_authorship as $row) {
        $id                 = isset($row['sole_authorship_id'])     ? intval($row['sole_authorship_id'])       : 0;
        $title              = trim($row['title'] ?? '');
        $type               = trim($row['type'] ?? '');
        $journal_publisher  = trim($row['journal_publisher'] ?? '');
        $reviewer           = trim($row['reviewer'] ?? '');
        $international      = trim($row['international'] ?? '');
        $date_published     = $row['date_published']     ?? null;
        $score              = floatval($row['score'] ?? 0); // We'll recalculate this later
        $evidence_file      = $row['evidence_file']      ?? '';

        if ($id === 0) {
            // Insert new row
            $stmtInsertSole->execute([
                ':request_id'           => $request_id,
                ':title'                => $title,
                ':type'                 => $type,
                ':journal_publisher'    => $journal_publisher,
                ':reviewer'             => $reviewer,
                ':international'        => $international,
                ':date_published'       => $date_published,
                ':score'                => $score,
                ':evidence_file'        => $evidence_file
            ]);
        } else {
            // Update existing row
            $stmtUpdateSole->execute([
                ':sole_authorship_id'   => $id,
                ':request_id'           => $request_id,
                ':title'                => $title,
                ':type'                 => $type,
                ':journal_publisher'    => $journal_publisher,
                ':reviewer'             => $reviewer,
                ':international'        => $international,
                ':date_published'       => $date_published,
                ':score'                => $score,
                ':evidence_file'        => $evidence_file
            ]);
        }
    }

    // ======= UPSERT Co-Authorship =======
    $stmtInsertCo = $conn->prepare("
        INSERT INTO kra2_a_co_authorship
            (request_id, title, type, journal_publisher, reviewer, international, date_published, contribution_percentage, score, evidence_file)
        VALUES
            (:request_id, :title, :type, :journal_publisher, :reviewer, :international, :date_published, :contribution_percentage, :score, :evidence_file)
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
            evidence_file = :evidence_file
        WHERE co_authorship_id = :co_authorship_id
        AND request_id = :request_id
    ");

    foreach($co_authorship as $row) {
        $id                         = isset($row['co_authorship_id'])       ? intval($row['co_authorship_id'])                  : 0;
        $title                      = trim($row['title']                    ?? '');
        $type                       = trim($row['type']                     ?? '');
        $journal_publisher          = trim($row['journal_publisher']        ?? '');
        $reviewer                   = trim($row['reviewer']                 ?? '');
        $international              = trim($row['international']            ?? '');
        $date_published             = $row['date_published']               ?? null;
        $contribution_percentage    = floatval($row['contribution_percentage'] ?? 0);
        $score                      = floatval($row['score'] ?? 0); // Recalculate later
        $evidence_file              = $row['evidence_file']                ?? '';

        if ($id === 0) {
            // Insert
            $stmtInsertCo->execute([
                ':request_id'               => $request_id,
                ':title'                    => $title,
                ':type'                     => $type,
                ':journal_publisher'        => $journal_publisher,
                ':reviewer'                 => $reviewer,
                ':international'            => $international,
                ':date_published'           => $date_published,
                ':contribution_percentage'  => $contribution_percentage,
                ':score'                    => $score,
                ':evidence_file'            => $evidence_file
            ]);
        } else {
            // Update
            $stmtUpdateCo->execute([
                ':co_authorship_id'         => $id,
                ':request_id'               => $request_id,
                ':title'                    => $title,
                ':type'                     => $type,
                ':journal_publisher'        => $journal_publisher,
                ':reviewer'                 => $reviewer,
                ':international'            => $international,
                ':date_published'           => $date_published,
                ':contribution_percentage'  => $contribution_percentage,
                ':score'                    => $score,
                ':evidence_file'            => $evidence_file
            ]);
        }
    }

    // ======= UPSERT Lead Researcher =======
    $stmtInsertLead = $conn->prepare("
        INSERT INTO kra2_a_lead_researcher
            (request_id, title, date_completed, project_name, funding_source, date_implemented, score, evidence_file)
        VALUES
            (:request_id, :title, :date_completed, :project_name, :funding_source, :date_implemented, :score, :evidence_file)
    ");

    $stmtUpdateLead = $conn->prepare("
        UPDATE kra2_a_lead_researcher
        SET title = :title,
            date_completed = :date_completed,
            project_name = :project_name,
            funding_source = :funding_source,
            date_implemented = :date_implemented,
            score = :score,
            evidence_file = :evidence_file
        WHERE lead_researcher_id = :lead_researcher_id
        AND request_id = :request_id
    ");

    foreach ($lead_researcher as $row) {
        $id                 = isset($row['lead_researcher_id']) ? intval($row['lead_researcher_id']) : 0;
        $title              = trim($row['title'] ?? '');
        $date_completed     = $row['date_completed'] ?? null;
        $project_name       = trim($row['project_name'] ?? '');
        $funding_source     = trim($row['funding_source'] ?? '');
        $date_implemented   = $row['date_implemented'] ?? null;
        $score              = floatval($row['score'] ?? 0); // Recalculate later
        $evidence_file      = $row['evidence_file'] ?? '';

        if ($id === 0) {
            // Insert
            $stmtInsertLead->execute([
                ':request_id'       => $request_id,
                ':title'            => $title,
                ':date_completed'   => $date_completed,
                ':project_name'     => $project_name,
                ':funding_source'   => $funding_source,
                ':date_implemented' => $date_implemented,
                ':score'            => $score,
                ':evidence_file'    => $evidence_file
            ]);
        } else {
            // Update
            $stmtUpdateLead->execute([
                ':lead_researcher_id' => $id,
                ':request_id'       => $request_id,
                ':title'            => $title,
                ':date_completed'   => $date_completed,
                ':project_name'     => $project_name,
                ':funding_source'   => $funding_source,
                ':date_implemented' => $date_implemented,
                ':score'            => $score,
                ':evidence_file'    => $evidence_file
            ]);
        }
    }

    // ======= UPSERT Contributor =======
    $stmtInsertContributor = $conn->prepare("
        INSERT INTO kra2_a_contributor
            (request_id, title, date_completed, project_name, funding_source, date_implemented, contribution_percentage, score, evidence_file)
        VALUES
            (:request_id, :title, :date_completed, :project_name, :funding_source, :date_implemented, :contribution_percentage, :score, :evidence_file)
    ");

    $stmtUpdateContributor = $conn->prepare("
        UPDATE kra2_a_contributor
        SET title = :title,
            date_completed = :date_completed,
            project_name = :project_name,
            funding_source = :funding_source,
            date_implemented = :date_implemented,
            contribution_percentage = :contribution_percentage,
            score = :score,
            evidence_file = :evidence_file
        WHERE contributor_id = :contributor_id
        AND request_id = :request_id
    ");

    foreach ($contributor as $row) {
        $id                     = isset($row['contributor_id']) ? intval($row['contributor_id']) : 0;
        $title                  = trim($row['title'] ?? '');
        $date_completed         = $row['date_completed'] ?? null;
        $project_name           = trim($row['project_name'] ?? '');
        $funding_source         = trim($row['funding_source'] ?? '');
        $date_implemented       = $row['date_implemented'] ?? null;
        $contribution_percentage = floatval($row['contribution_percentage'] ?? 0);
        $score                  = floatval($row['score'] ?? 0); // Recalculate later
        $evidence_file          = $row['evidence_file'] ?? '';

        if ($id === 0) {
            // Insert
            $stmtInsertContributor->execute([
                ':request_id'               => $request_id,
                ':title'                    => $title,
                ':date_completed'           => $date_completed,
                ':project_name'             => $project_name,
                ':funding_source'           => $funding_source,
                ':date_implemented'         => $date_implemented,
                ':contribution_percentage'  => $contribution_percentage,
                ':score'                    => $score,
                ':evidence_file'            => $evidence_file
            ]);
        } else {
            // Update
            $stmtUpdateContributor->execute([
                ':contributor_id'           => $id,
                ':request_id'               => $request_id,
                ':title'                    => $title,
                ':date_completed'           => $date_completed,
                ':project_name'             => $project_name,
                ':funding_source'           => $funding_source,
                ':date_implemented'         => $date_implemented,
                ':contribution_percentage'  => $contribution_percentage,
                ':score'                    => $score,
                ':evidence_file'            => $evidence_file
            ]);
        }
    }

    // ======= UPSERT Local Authors =======
    $stmtInsertLocal = $conn->prepare("
        INSERT INTO kra2_a_local_authors
            (request_id, title, date_published, journal_name, citation_count, citation_index, citation_year, score, evidence_file)
        VALUES
            (:request_id, :title, :date_published, :journal_name, :citation_count, :citation_index, :citation_year, :score, :evidence_file)
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
            evidence_file = :evidence_file
        WHERE local_author_id = :local_author_id
        AND request_id = :request_id
    ");

    foreach ($local_authors as $row) {
        $id             = isset($row['local_author_id']) ? intval($row['local_author_id']) : 0;
        $title          = trim($row['title'] ?? '');
        $date_published = $row['date_published'] ?? null;
        $journal_name   = trim($row['journal_name'] ?? '');
        $citation_count = intval($row['citation_count'] ?? 0);
        $citation_index = trim($row['citation_index'] ?? '');
        $citation_year  = $row['citation_year'] ?? null; // Assuming this is a year value
        $score          = floatval($row['score'] ?? 0); // Recalculate later
        $evidence_file  = $row['evidence_file'] ?? '';

        if ($id === 0) {
            // Insert
            $stmtInsertLocal->execute([
                ':request_id'       => $request_id,
                ':title'            => $title,
                ':date_published'   => $date_published,
                ':journal_name'     => $journal_name,
                ':citation_count'   => $citation_count,
                ':citation_index'   => $citation_index,
                ':citation_year'    => $citation_year,
                ':score'            => $score,
                ':evidence_file'    => $evidence_file
            ]);
        } else {
            // Update
            $stmtUpdateLocal->execute([
                ':local_author_id'  => $id,
                ':request_id'       => $request_id,
                ':title'            => $title,
                ':date_published'   => $date_published,
                ':journal_name'     => $journal_name,
                ':citation_count'   => $citation_count,
                ':citation_index'   => $citation_index,
                ':citation_year'    => $citation_year,
                ':score'            => $score,
                ':evidence_file'    => $evidence_file
            ]);
        }
    }

    // ======= UPSERT International Authors =======
    $stmtInsertInternational = $conn->prepare("
        INSERT INTO kra2_a_international_authors
            (request_id, title, date_published, journal_name, citation_count, citation_index, citation_year, score, evidence_file)
        VALUES
            (:request_id, :title, :date_published, :journal_name, :citation_count, :citation_index, :citation_year, :score, :evidence_file)
    ");

    $stmtUpdateInternational = $conn->prepare("
        UPDATE kra2_a_international_authors
        SET title = :title,
            date_published = :date_published,
            journal_name = :journal_name,
            citation_count = :citation_count,
            citation_index = :citation_index,
            citation_year = :citation_year,
            score = :score,
            evidence_file = :evidence_file
        WHERE international_author_id = :international_author_id
        AND request_id = :request_id
    ");

    foreach ($international_authors as $row) {
        $id             = isset($row['international_author_id']) ? intval($row['international_author_id']) : 0;
        $title          = trim($row['title'] ?? '');
        $date_published = $row['date_published'] ?? null;
        $journal_name   = trim($row['journal_name'] ?? '');
        $citation_count = intval($row['citation_count'] ?? 0);
        $citation_index = trim($row['citation_index'] ?? '');
        $citation_year  = $row['citation_year'] ?? null; // Assuming this is a year value
        $score          = floatval($row['score'] ?? 0); // Recalculate later
        $evidence_file  = $row['evidence_file'] ?? '';

        if ($id === 0) {
            // Insert
            $stmtInsertInternational->execute([
                ':request_id'           => $request_id,
                ':title'                => $title,
                ':date_published'       => $date_published,
                ':journal_name'         => $journal_name,
                ':citation_count'       => $citation_count,
                ':citation_index'       => $citation_index,
                ':citation_year'        => $citation_year,
                ':score'                => $score,
                ':evidence_file'        => $evidence_file
            ]);
        } else {
            // Update
            $stmtUpdateInternational->execute([
                ':international_author_id' => $id,
                ':request_id'           => $request_id,
                ':title'                => $title,
                ':date_published'       => $date_published,
                ':journal_name'         => $journal_name,
                ':citation_count'       => $citation_count,
                ':citation_index'       => $citation_index,
                ':citation_year'        => $citation_year,
                ':score'                => $score,
                ':evidence_file'        => $evidence_file
            ]);
        }
    }

    // ======= COMPUTE OFFICIAL SCORES (using the provided rules) =======

    // Function to calculate Sole Authorship score
    function calculateSoleAuthorshipScore($type, $international, $title, $journal_publisher, $reviewer, $date_published) {
        if (empty($title) || empty($date_published) || empty($journal_publisher) || empty($reviewer)) {
            return 0; // Not qualified if title, date published, journal/publisher, or reviewer is missing
        }

        $score = 0;
        switch (strtolower($type)) {
            case 'book':
            case 'monograph':
                $score = 100;
                break;
            case 'journal article':
                $score = ($international === 'Yes') ? 50 : 0;
                break;
            case 'book chapter':
                $score = 35;
                break;
            case 'other peer-reviewed output':
                $score = 10;
                break;
            default:
                $score = 0;
        }
        return $score;
    }

    // Function to calculate Co-Authorship score
    function calculateCoAuthorshipScore($type, $international, $title, $date_published, $contribution_percentage) {
        if (empty($title) || empty($date_published)) {
            return 0;
        }
    
        $baseScore = 0;
        switch (strtolower($type)) {
            case 'book':
            case 'monograph':
                $baseScore = 100;
                break;
            case 'journal article':
                $baseScore = ($international === 'Yes') ? 50 : 0;
                break;
            case 'book chapter':
                $baseScore = 35;
                break;
            case 'other peer-reviewed output':
                $baseScore = 10;
                break;
        }
    
        return $baseScore * ($contribution_percentage / 100);
    }
    

    // Function to calculate Lead Researcher score
    function calculateLeadResearcherScore($title, $date_completed, $project_name, $funding_source, $date_implemented) {
        if (empty($title) || empty($date_completed) || empty($project_name) || empty($funding_source) || empty($date_implemented)) {
            return 0; // Not qualified if any of the required fields are missing
        }
        return 35;
    }

    // Function to calculate Contributor score
    function calculateContributorScore($title, $date_completed, $project_name, $funding_source, $date_implemented, $contribution_percentage) {
        if (empty($title) || empty($date_completed) || empty($project_name) || empty($funding_source) || empty($date_implemented)) {
            return 0; // Not qualified if any of the required fields are missing
        }
        return 35 * ($contribution_percentage / 100);
    }

    // Function to calculate Local Authors score
    function calculateLocalAuthorsScore($citation_count) {
        return $citation_count * 5;
    }

    // Function to calculate International Authors score
    function calculateInternationalAuthorsScore($citation_count) {
        return $citation_count * 10;
    }

    // 1) Sole Authorship
    $soleSum = 0;
    $stmt = $conn->prepare("SELECT * FROM kra2_a_sole_authorship WHERE request_id = :request_id");
    $stmt->execute([':request_id' => $request_id]);
    $soleRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($soleRows as $row) {
        $score = calculateSoleAuthorshipScore($row['type'], $row['international'], $row['title'], $row['journal_publisher'], $row['reviewer'], $row['date_published']);
        $soleSum += $score;

        $updateStmt = $conn->prepare("UPDATE kra2_a_sole_authorship SET score = :score WHERE sole_authorship_id = :id");
        $updateStmt->execute([':score' => $score, ':id' => $row['sole_authorship_id']]);
    }

    // 2) Co-Authorship
    $coSum = 0;
    $stmt = $conn->prepare("SELECT * FROM kra2_a_co_authorship WHERE request_id = :request_id");
    $stmt->execute([':request_id' => $request_id]);
    $coRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($coRows as $row) {
        $score = calculateCoAuthorshipScore($row['type'], $row['international'], $row['title'], $row['date_published'], $row['contribution_percentage']);
        $coSum += $score;

        $updateStmt = $conn->prepare("UPDATE kra2_a_co_authorship SET score = :score WHERE co_authorship_id = :id");
        $updateStmt->execute([':score' => $score, ':id' => $row['co_authorship_id']]);
    }

    // 3) Lead Researcher
    $leadSum = 0;
    $stmt = $conn->prepare("SELECT * FROM kra2_a_lead_researcher WHERE request_id = :request_id");
    $stmt->execute([':request_id' => $request_id]);
    $leadRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($leadRows as $row) {
        $score = calculateLeadResearcherScore($row['title'], $row['date_completed'], $row['project_name'], $row['funding_source'], $row['date_implemented']);
        $leadSum += $score;

        $updateStmt = $conn->prepare("UPDATE kra2_a_lead_researcher SET score = :score WHERE lead_researcher_id = :id");
        $updateStmt->execute([':score' => $score, ':id' => $row['lead_researcher_id']]);
    }

    // 4) Contributor
    $contributorSum = 0;
    $stmt = $conn->prepare("SELECT * FROM kra2_a_contributor WHERE request_id = :request_id");
    $stmt->execute([':request_id' => $request_id]);
    $contributorRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($contributorRows as $row) {
        $score = calculateContributorScore($row['title'], $row['date_completed'], $row['project_name'], $row['funding_source'], $row['date_implemented'], $row['contribution_percentage']);
        $contributorSum += $score;

        $updateStmt = $conn->prepare("UPDATE kra2_a_contributor SET score = :score WHERE contributor_id = :id");
        $updateStmt->execute([':score' => $score, ':id' => $row['contributor_id']]);
    }

    // 5) Local Authors
    $localSum = 0;
    $stmt = $conn->prepare("SELECT * FROM kra2_a_local_authors WHERE request_id = :request_id");
    $stmt->execute([':request_id' => $request_id]);
    $localRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($localRows as $row) {
        $score = calculateLocalAuthorsScore($row['citation_count']);
        $localSum += $score;

        $updateStmt = $conn->prepare("UPDATE kra2_a_local_authors SET score = :score WHERE local_author_id = :id");
        $updateStmt->execute([':score' => $score, ':id' => $row['local_author_id']]);
    }

    // 6) International Authors
    $internationalSum = 0;
    $stmt = $conn->prepare("SELECT * FROM kra2_a_international_authors WHERE request_id = :request_id");
    $stmt->execute([':request_id' => $request_id]);
    $internationalRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($internationalRows as $row) {
        $score = calculateInternationalAuthorsScore($row['citation_count']);
        $internationalSum += $score;

        $updateStmt = $conn->prepare("UPDATE kra2_a_international_authors SET score = :score WHERE international_author_id = :id");
        $updateStmt->execute([':score' => $score, ':id' => $row['international_author_id']]);
    }

    // ======= UPDATE METADATA =======
    $stmtMeta = $conn->prepare("SELECT kra2_a_metadata_id FROM kra2_a_metadata WHERE request_id = :request_id");
    $stmtMeta->execute([':request_id' => $request_id]);
    $existingMeta = $stmtMeta->fetch(PDO::FETCH_ASSOC);

    if ($existingMeta) {
        // Update
        $upd = $conn->prepare("
            UPDATE kra2_a_metadata
            SET sole_authorship_total = :sole_total,
                co_authorship_total = :co_total,
                lead_researcher_total = :lead_total,
                contributor_total = :contributor_total,
                local_authors_total = :local_total,
                international_authors_total = :international_total,
                overall_score = :overall_total
            WHERE kra2_a_metadata_id = :meta_id
        ");
        $upd->execute([
            ':sole_total'           => $soleSum,
            ':co_total'             => $coSum,
            ':lead_total'           => $leadSum,
            ':contributor_total'    => $contributorSum,
            ':local_total'          => $localSum,
            ':international_total'  => $internationalSum,
            ':overall_total'        => $soleSum + $coSum + $leadSum + $contributorSum + $localSum + $internationalSum,
            ':meta_id'              => $existingMeta['kra2_a_metadata_id']
        ]);
    } else {
        // Insert
        $ins = $conn->prepare("
            INSERT INTO kra2_a_metadata
                (request_id, sole_authorship_total, co_authorship_total, lead_researcher_total, contributor_total, local_authors_total, international_authors_total, overall_score)
            VALUES
                (:request_id, :sole_total, :co_total, :lead_total, :contributor_total, :local_total, :international_total, :overall_total)
        ");
        $ins->execute([
            ':request_id'           => $request_id,
            ':sole_total'           => $soleSum,
            ':co_total'             => $coSum,
            ':lead_total'           => $leadSum,
            ':contributor_total'    => $contributorSum,
            ':local_total'          => $localSum,
            ':international_total'  => $internationalSum,
            ':overall_total'        => $soleSum + $coSum + $leadSum + $contributorSum + $localSum + $internationalSum
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