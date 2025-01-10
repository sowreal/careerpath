<?php
// php/dashboard/career_progress_tracking/research/kra2_save_criterion_a.php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 0);

header('Content-Type: application/json');
require_once '../../../../session.php';
require_once '../../../../connection.php';
require_once '../../../../config.php';

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
$sole_authorship   = isset($data['sole_authorship'])   ? $data['sole_authorship']   : [];
$co_authorship     = isset($data['co_authorship'])     ? $data['co_authorship']     : [];
$lead_researcher   = isset($data['lead_researcher'])   ? $data['lead_researcher']   : [];
$contributor       = isset($data['contributor'])       ? $data['contributor']       : [];
$local_authors     = isset($data['local_authors'])     ? $data['local_authors']     : [];
$international_authors = isset($data['international_authors']) ? $data['international_authors'] : [];

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
            (request_id, title, type, journal_publisher, reviewer, international,
             date_published, score, evidence_file)
        VALUES
            (:request_id, :title, :type, :journal_publisher, :reviewer, :international,
             :date_published, :score, :evidence_file)
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
        $id = isset($row['sole_authorship_id']) ? intval($row['sole_authorship_id']) : 0;
        $title = trim($row['title'] ?? '');
        $type  = trim($row['type'] ?? '');
        $journal_publisher = trim($row['journal_publisher'] ?? '');
        $reviewer = trim($row['reviewer'] ?? '');
        $international = trim($row['international'] ?? '');
        $date_published = $row['date_published'] ?? null;
        $evidence_file  = $row['evidence_file'] ?? '';
        $userScore = floatval($row['score'] ?? 0);

        if ($id === 0) {
            $stmtInsertSole->execute([
                ':request_id'     => $request_id,
                ':title'          => $title,
                ':type'           => $type,
                ':journal_publisher' => $journal_publisher,
                ':reviewer'       => $reviewer,
                ':international'  => $international,
                ':date_published' => $date_published ?: null,
                ':score'          => $userScore,
                ':evidence_file'  => $evidence_file
            ]);
        } else {
            $stmtUpdateSole->execute([
                ':title'          => $title,
                ':type'           => $type,
                ':journal_publisher' => $journal_publisher,
                ':reviewer'       => $reviewer,
                ':international'  => $international,
                ':date_published' => $date_published ?: null,
                ':score'          => $userScore,
                ':evidence_file'  => $evidence_file,
                ':sole_authorship_id' => $id,
                ':request_id'     => $request_id
            ]);
        }
    }

    // ======= UPSERT Co-Authorship =======
    $stmtInsertCo = $conn->prepare("
        INSERT INTO kra2_a_co_authorship
            (request_id, title, type, journal_publisher, reviewer, international,
             date_published, contribution_percentage, score, evidence_file)
        VALUES
            (:request_id, :title, :type, :journal_publisher, :reviewer, :international,
             :date_published, :contribution_percentage, :score, :evidence_file)
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

    foreach ($co_authorship as $row) {
        $id = isset($row['co_authorship_id']) ? intval($row['co_authorship_id']) : 0;
        $title = trim($row['title'] ?? '');
        $type  = trim($row['type'] ?? '');
        $journal_publisher = trim($row['journal_publisher'] ?? '');
        $reviewer = trim($row['reviewer'] ?? '');
        $international = trim($row['international'] ?? '');
        $date_published = $row['date_published'] ?? null;
        $contrib = floatval($row['contribution_percentage'] ?? 0);
        $evidence_file = $row['evidence_file'] ?? '';
        $userScore = floatval($row['score'] ?? 0);

        if ($id === 0) {
            $stmtInsertCo->execute([
                ':request_id'    => $request_id,
                ':title'         => $title,
                ':type'          => $type,
                ':journal_publisher' => $journal_publisher,
                ':reviewer'      => $reviewer,
                ':international' => $international,
                ':date_published'=> $date_published ?: null,
                ':contribution_percentage' => $contrib,
                ':score'         => $userScore,
                ':evidence_file' => $evidence_file
            ]);
        } else {
            $stmtUpdateCo->execute([
                ':title'         => $title,
                ':type'          => $type,
                ':journal_publisher' => $journal_publisher,
                ':reviewer'      => $reviewer,
                ':international' => $international,
                ':date_published'=> $date_published ?: null,
                ':contribution_percentage' => $contrib,
                ':score'         => $userScore,
                ':evidence_file' => $evidence_file,
                ':co_authorship_id' => $id,
                ':request_id'       => $request_id
            ]);
        }
    }

    // ======= UPSERT Lead Researcher =======
    $stmtInsertLead = $conn->prepare("
        INSERT INTO kra2_a_lead_researcher
            (request_id, title, date_completed, project_name, funding_source,
             date_implemented, score, evidence_file)
        VALUES
            (:request_id, :title, :date_completed, :project_name, :funding_source,
             :date_implemented, :score, :evidence_file)
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
        $id = isset($row['lead_researcher_id']) ? intval($row['lead_researcher_id']) : 0;
        $title = trim($row['title'] ?? '');
        $date_completed = $row['date_completed'] ?? null;
        $project_name = trim($row['project_name'] ?? '');
        $funding_source = trim($row['funding_source'] ?? '');
        $date_implemented = $row['date_implemented'] ?? null;
        $evidence_file = $row['evidence_file'] ?? '';
        $userScore = floatval($row['score'] ?? 0);

        if ($id === 0) {
            $stmtInsertLead->execute([
                ':request_id'     => $request_id,
                ':title'          => $title,
                ':date_completed' => $date_completed ?: null,
                ':project_name'   => $project_name,
                ':funding_source' => $funding_source,
                ':date_implemented' => $date_implemented ?: null,
                ':score'          => $userScore,
                ':evidence_file'  => $evidence_file
            ]);
        } else {
            $stmtUpdateLead->execute([
                ':title'          => $title,
                ':date_completed' => $date_completed ?: null,
                ':project_name'   => $project_name,
                ':funding_source' => $funding_source,
                ':date_implemented' => $date_implemented ?: null,
                ':score'          => $userScore,
                ':evidence_file'  => $evidence_file,
                ':lead_researcher_id' => $id,
                ':request_id'     => $request_id
            ]);
        }
    }

    // ======= UPSERT Contributor =======
    $stmtInsertContributor = $conn->prepare("
        INSERT INTO kra2_a_contributor
            (request_id, title, date_completed, project_name, funding_source,
             date_implemented, contribution_percentage, score, evidence_file)
        VALUES
            (:request_id, :title, :date_completed, :project_name, :funding_source,
             :date_implemented, :contribution_percentage, :score, :evidence_file)
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
        $id = isset($row['contributor_id']) ? intval($row['contributor_id']) : 0;
        $title = trim($row['title'] ?? '');
        $date_completed = $row['date_completed'] ?? null;
        $project_name = trim($row['project_name'] ?? '');
        $funding_source = trim($row['funding_source'] ?? '');
        $date_implemented = $row['date_implemented'] ?? null;
        $contrib = floatval($row['contribution_percentage'] ?? 0);
        $evidence_file = $row['evidence_file'] ?? '';
        $userScore = floatval($row['score'] ?? 0);

        if ($id === 0) {
            $stmtInsertContributor->execute([
                ':request_id'     => $request_id,
                ':title'          => $title,
                ':date_completed' => $date_completed ?: null,
                ':project_name'   => $project_name,
                ':funding_source' => $funding_source,
                ':date_implemented' => $date_implemented ?: null,
                ':contribution_percentage' => $contrib,
                ':score'          => $userScore,
                ':evidence_file'  => $evidence_file
            ]);
        } else {
            $stmtUpdateContributor->execute([
                ':title'          => $title,
                ':date_completed' => $date_completed ?: null,
                ':project_name'   => $project_name,
                ':funding_source' => $funding_source,
                ':date_implemented' => $date_implemented ?: null,
                ':contribution_percentage' => $contrib,
                ':score'          => $userScore,
                ':evidence_file'  => $evidence_file,
                ':contributor_id' => $id,
                ':request_id'     => $request_id
            ]);
        }
    }

    // ======= UPSERT Local Authors =======
    $stmtInsertLocal = $conn->prepare("
        INSERT INTO kra2_a_local_authors
            (request_id, title, date_published, journal_name, citation_count,
             citation_index, citation_year, score, evidence_file)
        VALUES
            (:request_id, :title, :date_published, :journal_name, :citation_count,
             :citation_index, :citation_year, :score, :evidence_file)
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
        $id = isset($row['local_author_id']) ? intval($row['local_author_id']) : 0;
        $title = trim($row['title'] ?? '');
        $date_published = $row['date_published'] ?? null;
        $journal_name = trim($row['journal_name'] ?? '');
        $citation_count = intval($row['citation_count'] ?? 0);
        $citation_index = trim($row['citation_index'] ?? '');
        $citation_year = $row['citation_year'] ?? null;
        $evidence_file = $row['evidence_file'] ?? '';
        $userScore = floatval($row['score'] ?? 0);

        if ($id === 0) {
            $stmtInsertLocal->execute([
                ':request_id'     => $request_id,
                ':title'          => $title,
                ':date_published' => $date_published ?: null,
                ':journal_name'   => $journal_name,
                ':citation_count' => $citation_count,
                ':citation_index' => $citation_index,
                ':citation_year'  => $citation_year ?: null,
                ':score'          => $userScore,
                ':evidence_file'  => $evidence_file
            ]);
        } else {
            $stmtUpdateLocal->execute([
                ':title'          => $title,
                ':date_published' => $date_published ?: null,
                ':journal_name'   => $journal_name,
                ':citation_count' => $citation_count,
                ':citation_index' => $citation_index,
                ':citation_year'  => $citation_year ?: null,
                ':score'          => $userScore,
                ':evidence_file'  => $evidence_file,
                ':local_author_id' => $id,
                ':request_id'     => $request_id
            ]);
        }
    }

    // ======= UPSERT International Authors =======
    $stmtInsertInternational = $conn->prepare("
        INSERT INTO kra2_a_international_authors
            (request_id, title, date_published, journal_name, citation_count,
             citation_index, citation_year, score, evidence_file)
        VALUES
            (:request_id, :title, :date_published, :journal_name, :citation_count,
             :citation_index, :citation_year, :score, :evidence_file)
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
        $id = isset($row['international_author_id']) ? intval($row['international_author_id']) : 0;
        $title = trim($row['title'] ?? '');
        $date_published = $row['date_published'] ?? null;
        $journal_name = trim($row['journal_name'] ?? '');
        $citation_count = intval($row['citation_count'] ?? 0);
        $citation_index = trim($row['citation_index'] ?? '');
        $citation_year = $row['citation_year'] ?? null;
        $evidence_file = $row['evidence_file'] ?? '';
        $userScore = floatval($row['score'] ?? 0);

        if ($id === 0) {
            $stmtInsertInternational->execute([
                ':request_id'     => $request_id,
                ':title'          => $title,
                ':date_published' => $date_published ?: null,
                ':journal_name'   => $journal_name,
                ':citation_count' => $citation_count,
                ':citation_index' => $citation_index,
                ':citation_year'  => $citation_year ?: null,
                ':score'          => $userScore,
                ':evidence_file'  => $evidence_file
            ]);
        } else {
            $stmtUpdateInternational->execute([
                ':title'          => $title,
                ':date_published' => $date_published ?: null,
                ':journal_name'   => $journal_name,
                ':citation_count' => $citation_count,
                ':citation_index' => $citation_index,
                ':citation_year'  => $citation_year ?: null,
                ':score'          => $userScore,
                ':evidence_file'  => $evidence_file,
                ':international_author_id' => $id,
                ':request_id'     => $request_id
            ]);
        }
    }

    // ======= COMPUTE OFFICIAL SCORES PER YOUR RULES =======
    //  1) Sole Authorship
    $sqlSole = "SELECT sole_authorship_id, title, type, journal_publisher, reviewer, international, date_published, score, evidence_file
            FROM kra2_a_sole_authorship
            WHERE request_id = :request_id";
    $stmt = $conn->prepare($sqlSole);
    $stmt->execute([':request_id' => $request_id]);
    $soleRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $soleSum = 0;
    foreach ($soleRows as $sr) {
        $title    = trim($sr['title']);
        $type     = trim($sr['type']);
        $journal_publisher = trim($sr['journal_publisher']);
        $reviewer = trim($sr['reviewer']);
        $date_published = $sr['date_published'];
        $international = trim($sr['international']);

        if ($title === '' || $journal_publisher === '' || $reviewer === '' || $date_published === '') {
            $scoreComputed = 0;
        } else {
            switch (strtolower($type)) {
                case 'book':
                case 'monograph':
                    $scoreComputed = 100;
                    break;
                case 'journal article':
                    $scoreComputed = ($international === 'yes') ? 50 : 0;
                    break;
                case 'book chapter':
                    $scoreComputed = 35;
                    break;
                case 'other peer-reviewed output':
                    $scoreComputed = 10;
                    break;
                default:
                    $scoreComputed = 0;
                    break;
            }
        }
        $soleSum += $scoreComputed;

        $upd = $conn->prepare("UPDATE kra2_a_sole_authorship
                                SET score = :score
                                WHERE sole_authorship_id = :id");
        $upd->execute([
            ':score' => $scoreComputed,
            ':id'    => $sr['sole_authorship_id']
        ]);
    }

    //  2) Co-Authorship
    $sqlCo = "SELECT co_authorship_id, title, type, journal_publisher, reviewer, international, date_published, contribution_percentage, score, evidence_file
              FROM kra2_a_co_authorship
              WHERE request_id = :request_id";
    $stmt = $conn->prepare($sqlCo);
    $stmt->execute([':request_id' => $request_id]);
    $coRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $coSum = 0;
    foreach ($coRows as $cr) {
        $title    = trim($cr['title']);
        $type     = trim($cr['type']);
        $journal_publisher = trim($cr['journal_publisher']);
        $reviewer = trim($cr['reviewer']);
        $date_published = $cr['date_published'];
        $international = trim($cr['international']);
        $contrib  = floatval($cr['contribution_percentage'] ?? 0);

        if ($title === '' || $date_published === '') {
            $scoreBase = 0;
        } else {
            switch (strtolower($type)) {
                case 'book':
                case 'monograph':
                    $scoreBase = 100;
                    break;
                case 'journal article':
                    $scoreBase = ($international === 'yes') ? 50 : 0;
                    break;
                case 'book chapter':
                    $scoreBase = 35;
                    break;
                case 'other peer-reviewed output':
                    $scoreBase = 10;
                    break;
                default:
                    $scoreBase = 0;
                    break;
            }
        }

        $scoreComputed = $scoreBase * ($contrib / 100); 
        $coSum += $scoreComputed;

        $upd = $conn->prepare("UPDATE kra2_a_co_authorship
                                SET score = :score
                                WHERE co_authorship_id = :id");
        $upd->execute([
            ':score' => $scoreComputed,
            ':id'    => $cr['co_authorship_id']
        ]);
    }

    // 3) Lead Researcher
    $sqlLead = "SELECT lead_researcher_id, title, date_completed, project_name, funding_source, date_implemented, score
                FROM kra2_a_lead_researcher
                WHERE request_id = :request_id";
    $stmt = $conn->prepare($sqlLead);
    $stmt->execute([':request_id' => $request_id]);
    $leadRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $leadSum = 0;
    foreach ($leadRows as $lr) {
        $title = trim($lr['title']);
        $date_completed = $lr['date_completed'];
        $project_name = trim($lr['project_name']);
        $funding_source = trim($lr['funding_source']);
        $date_implemented = $lr['date_implemented'];

        $scoreComputed = ($title !== '' && $date_completed !== '' && $project_name !== '' && $funding_source !== '' && $date_implemented !== '') ? 35 : 0;
        $leadSum += $scoreComputed;

        $upd = $conn->prepare("UPDATE kra2_a_lead_researcher
                                SET score = :score
                                WHERE lead_researcher_id = :id");
        $upd->execute([
            ':score' => $scoreComputed,
            ':id'    => $lr['lead_researcher_id']
        ]);
    }

    // 4) Contributor
    $sqlContributor = "SELECT contributor_id, title, date_completed, project_name, funding_source, date_implemented, contribution_percentage, score
                        FROM kra2_a_contributor
                        WHERE request_id = :request_id";
    $stmt = $conn->prepare($sqlContributor);
    $stmt->execute([':request_id' => $request_id]);
    $contributorRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $contributorSum = 0;
    foreach ($contributorRows as $cr) {
        $title = trim($cr['title']);
        $date_completed = $cr['date_completed'];
        $project_name = trim($cr['project_name']);
        $funding_source = trim($cr['funding_source']);
        $date_implemented = $cr['date_implemented'];
        $contrib = floatval($cr['contribution_percentage'] ?? 0);

        $scoreComputed = ($title !== '' && $date_completed !== '' && $project_name !== '' && $funding_source !== '' && $date_implemented !== '') ? (35 * ($contrib / 100)) : 0;
        $contributorSum += $scoreComputed;

        $upd = $conn->prepare("UPDATE kra2_a_contributor
                                SET score = :score
                                WHERE contributor_id = :id");
        $upd->execute([
            ':score' => $scoreComputed,
            ':id'    => $cr['contributor_id']
        ]);
    }

    // 5) Local Authors
    $sqlLocal = "SELECT local_author_id, citation_count, score
                 FROM kra2_a_local_authors
                 WHERE request_id = :request_id";
    $stmt = $conn->prepare($sqlLocal);
    $stmt->execute([':request_id' => $request_id]);
    $localRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $localSum = 0;
    foreach ($localRows as $lr) {
        $citation_count = intval($lr['citation_count'] ?? 0);

        $scoreComputed = $citation_count * 5;
        $localSum += $scoreComputed;

        $upd = $conn->prepare("UPDATE kra2_a_local_authors
                                SET score = :score
                                WHERE local_author_id = :id");
        $upd->execute([
            ':score' => $scoreComputed,
            ':id'    => $lr['local_author_id']
        ]);
    }

    // 6) International Authors
    $sqlInternational = "SELECT international_author_id, citation_count, score
                          FROM kra2_a_international_authors
                          WHERE request_id = :request_id";
    $stmt = $conn->prepare($sqlInternational);
    $stmt->execute([':request_id' => $request_id]);
    $internationalRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $internationalSum = 0;
    foreach ($internationalRows as $ir) {
        $citation_count = intval($ir['citation_count'] ?? 0);

        $scoreComputed = $citation_count * 10;
        $internationalSum += $scoreComputed;

        $upd = $conn->prepare("UPDATE kra2_a_international_authors
                                SET score = :score
                                WHERE international_author_id = :id");
        $upd->execute([
            ':score' => $scoreComputed,
            ':id'    => $ir['international_author_id']
        ]);
    }

    // Metadata
    $stmtMeta = $conn->prepare("SELECT metadata_id FROM kra2_a_metadata WHERE request_id = :request_id");
    $stmtMeta->execute([':request_id' => $request_id]);
    $existingMeta = $stmtMeta->fetch(PDO::FETCH_ASSOC);

    if ($existingMeta) {
        $upd = $conn->prepare("
            UPDATE kra2_a_metadata
               SET sole_authorship_total   = :sole_total,
                   co_authorship_total     = :co_total,
                   lead_researcher_total   = :lead_total,
                   contributor_total       = :contributor_total,
                   local_authors_total     = :local_total,
                   international_authors_total = :international_total
             WHERE metadata_id = :meta_id
        ");
        $upd->execute([
            ':sole_total' => $soleSum,
            ':co_total'   => $coSum,
            ':lead_total' => $leadSum,
            ':contributor_total' => $contributorSum,
            ':local_total' => $localSum,
            ':international_total' => $internationalSum,
            ':meta_id'    => $existingMeta['metadata_id']
        ]);
    } else {
        $ins = $conn->prepare("
            INSERT INTO kra2_a_metadata
                (request_id, sole_authorship_total, co_authorship_total, lead_researcher_total,
                 contributor_total, local_authors_total, international_authors_total)
            VALUES
                (:request_id, :sole_total, :co_total, :lead_total,
                 :contributor_total, :local_total, :international_total)");
        $ins->execute([
            ':request_id' => $request_id,
            ':sole_total' => $soleSum,
            ':co_total'   => $coSum,
            ':lead_total' => $leadSum,
            ':contributor_total' => $contributorSum,
            ':local_total' => $localSum,
            ':international_total' => $internationalSum
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
