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

$data = json_decode(file_get_contents('php://input'), true);
$request_id = isset($data['request_id']) ? intval($data['request_id']) : 0;

if ($request_id <= 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid Request ID']);
    exit();
}

// Arrays of new/updated data
$sole_authorship   = isset($data['sole_authorship'])   ? $data['sole_authorship']   : [];
$co_authorship     = isset($data['co_authorship'])     ? $data['co_authorship']     : [];
$academic_programs = isset($data['academic_programs']) ? $data['academic_programs'] : [];

// Deleted record IDs
$deleted_records = isset($data['deleted_records']) ? $data['deleted_records'] : [
    'sole' => [], 'co' => [], 'acad' => []
];

try {
    $conn->beginTransaction();

    // ======= Handle DELETIONS first =======
    // 1) Sole Authorship
    if (!empty($deleted_records['sole'])) {
        $delStmt = $conn->prepare(
            "DELETE FROM kra1_b_sole_authorship
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
            "DELETE FROM kra1_b_co_authorship
             WHERE co_authorship_id = :record_id AND request_id = :request_id"
        );
        foreach ($deleted_records['co'] as $record_id) {
            $delStmt->execute([
                ':record_id'  => $record_id,
                ':request_id' => $request_id
            ]);
        }
    }
    // 3) Academic Programs
    if (!empty($deleted_records['acad'])) {
        $delStmt = $conn->prepare(
            "DELETE FROM kra1_b_academic_programs
             WHERE academic_prog_id = :record_id AND request_id = :request_id"
        );
        foreach ($deleted_records['acad'] as $record_id) {
            $delStmt->execute([
                ':record_id'  => $record_id,
                ':request_id' => $request_id
            ]);
        }
    }

    // ======= UPSERT Sole Authorship =======
    $stmtInsertSole = $conn->prepare("
        INSERT INTO kra1_b_sole_authorship
            (request_id, title, type, reviewer, publisher,
             date_published, date_approved, score, evidence_file)
        VALUES
            (:request_id, :title, :type, :reviewer, :publisher,
             :date_published, :date_approved, :score, :evidence_file)
    ");
    $stmtUpdateSole = $conn->prepare("
        UPDATE kra1_b_sole_authorship
           SET title = :title,
               type = :type,
               reviewer = :reviewer,
               publisher = :publisher,
               date_published = :date_published,
               date_approved = :date_approved,
               score = :score,
               evidence_file = :evidence_file
         WHERE sole_authorship_id = :sole_authorship_id
           AND request_id = :request_id
    ");

    foreach ($sole_authorship as $row) {
        $id = isset($row['sole_authorship_id']) ? intval($row['sole_authorship_id']) : 0;
        $title = trim($row['title'] ?? '');
        $type  = trim($row['type'] ?? '');
        $reviewer = trim($row['reviewer'] ?? '');
        $publisher = trim($row['publisher'] ?? '');
        $date_published = $row['date_published'] ?? null;
        $date_approved  = $row['date_approved'] ?? null;
        $evidence_file  = $row['evidence_file'] ?? '';

        // We'll calculate score in the next step, but for storage, we just keep the user-supplied "score" field or 0
        // You can also store the official computed score if you prefer. For now, let's store as is:
        $userScore = floatval($row['score'] ?? 0);

        // Insert or update:
        if ($id === 0) {
            // Insert new row
            $stmtInsertSole->execute([
                ':request_id'     => $request_id,
                ':title'          => $title,
                ':type'           => $type,
                ':reviewer'       => $reviewer,
                ':publisher'      => $publisher,
                ':date_published' => $date_published ?: null,
                ':date_approved'  => $date_approved  ?: null,
                ':score'          => $userScore,
                ':evidence_file'  => $evidence_file
            ]);
        } else {
            // Update existing
            $stmtUpdateSole->execute([
                ':title'          => $title,
                ':type'           => $type,
                ':reviewer'       => $reviewer,
                ':publisher'      => $publisher,
                ':date_published' => $date_published ?: null,
                ':date_approved'  => $date_approved  ?: null,
                ':score'          => $userScore,
                ':evidence_file'  => $evidence_file,
                ':sole_authorship_id' => $id,
                ':request_id'     => $request_id
            ]);
        }
    }

    // ======= UPSERT Co-Authorship =======
    $stmtInsertCo = $conn->prepare("
        INSERT INTO kra1_b_co_authorship
            (request_id, title, type, reviewer, publisher,
             date_published, date_approved, contribution_percentage,
             score, evidence_file)
        VALUES
            (:request_id, :title, :type, :reviewer, :publisher,
             :date_published, :date_approved, :contribution_percentage,
             :score, :evidence_file)
    ");
    $stmtUpdateCo = $conn->prepare("
        UPDATE kra1_b_co_authorship
           SET title = :title,
               type = :type,
               reviewer = :reviewer,
               publisher = :publisher,
               date_published = :date_published,
               date_approved = :date_approved,
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
        $reviewer  = trim($row['reviewer'] ?? '');
        $publisher = trim($row['publisher'] ?? '');
        $date_published = $row['date_published'] ?? null;
        $date_approved  = $row['date_approved'] ?? null;
        $contrib = floatval($row['contribution_percentage'] ?? 0);
        $evidence_file = $row['evidence_file'] ?? '';
        $userScore = floatval($row['score'] ?? 0);

        if ($id === 0) {
            $stmtInsertCo->execute([
                ':request_id'    => $request_id,
                ':title'         => $title,
                ':type'          => $type,
                ':reviewer'      => $reviewer,
                ':publisher'     => $publisher,
                ':date_published'=> $date_published ?: null,
                ':date_approved' => $date_approved  ?: null,
                ':contribution_percentage' => $contrib,
                ':score'         => $userScore,
                ':evidence_file' => $evidence_file
            ]);
        } else {
            $stmtUpdateCo->execute([
                ':title'         => $title,
                ':type'          => $type,
                ':reviewer'      => $reviewer,
                ':publisher'     => $publisher,
                ':date_published'=> $date_published ?: null,
                ':date_approved' => $date_approved  ?: null,
                ':contribution_percentage' => $contrib,
                ':score'         => $userScore,
                ':evidence_file' => $evidence_file,
                ':co_authorship_id' => $id,
                ':request_id'       => $request_id
            ]);
        }
    }

    // ======= UPSERT Academic Programs =======
    $stmtInsertAcad = $conn->prepare("
        INSERT INTO kra1_b_academic_programs
            (request_id, program_name, program_type, board_approval,
             academic_year, role, score, evidence_file)
        VALUES
            (:request_id, :program_name, :program_type, :board_approval,
             :academic_year, :role, :score, :evidence_file)
    ");
    $stmtUpdateAcad = $conn->prepare("
        UPDATE kra1_b_academic_programs
           SET program_name = :program_name,
               program_type = :program_type,
               board_approval = :board_approval,
               academic_year = :academic_year,
               role = :role,
               score = :score,
               evidence_file = :evidence_file
         WHERE academic_prog_id = :academic_prog_id
           AND request_id = :request_id
    ");

    foreach ($academic_programs as $row) {
        $id = isset($row['academic_prog_id']) ? intval($row['academic_prog_id']) : 0;
        $pname     = trim($row['program_name'] ?? '');
        $ptype     = trim($row['program_type'] ?? '');
        $board     = trim($row['board_approval'] ?? '');
        $ayear     = trim($row['academic_year'] ?? '');
        $role      = trim($row['role'] ?? '');
        $userScore = floatval($row['score'] ?? 0);
        $evidence_file = $row['evidence_file'] ?? '';

        if ($id === 0) {
            $stmtInsertAcad->execute([
                ':request_id'     => $request_id,
                ':program_name'   => $pname,
                ':program_type'   => $ptype,
                ':board_approval' => $board,
                ':academic_year'  => $ayear,
                ':role'           => $role,
                ':score'          => $userScore,
                ':evidence_file'  => $evidence_file
            ]);
        } else {
            $stmtUpdateAcad->execute([
                ':program_name'   => $pname,
                ':program_type'   => $ptype,
                ':board_approval' => $board,
                ':academic_year'  => $ayear,
                ':role'           => $role,
                ':score'          => $userScore,
                ':evidence_file'  => $evidence_file,
                ':academic_prog_id' => $id,
                ':request_id'       => $request_id
            ]);
        }
    }

    // ======= COMPUTE OFFICIAL SCORES PER YOUR RULES =======
    //  1) Sole Authorship
    //     - Must have (title + reviewer) to be valid, else 0
    //     - Score by type: see the table in your instructions
    $sqlSole = "SELECT sole_authorship_id, title, type, reviewer, publisher,
                date_published, date_approved, score, evidence_file
                FROM kra1_b_sole_authorship
                WHERE request_id = :request_id";
    $stmt = $conn->prepare($sqlSole);
    $stmt->execute([':request_id' => $request_id]);
    $soleRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $soleSum = 0;
    foreach ($soleRows as $sr) {
        $title    = trim($sr['title']);
        $type     = trim($sr['type']);
        $reviewer = trim($sr['reviewer']);

        // Check completeness
        if ($title === '' || $reviewer === '') {
            $scoreComputed = 0;
        } else {
            // Score by type
            switch (strtolower($type)) {
                case 'textbook':
                    $scoreComputed = 30;
                    break;
                case 'textbook chapter':
                    $scoreComputed = 10;
                    break;
                case 'manual/module':
                    $scoreComputed = 16;
                    break;
                case 'multimedia teaching material':
                    $scoreComputed = 16;
                    break;
                case 'testing material':
                    $scoreComputed = 10;
                    break;
                default:
                    $scoreComputed = 0;
                    break;
            }
        }
        $soleSum += $scoreComputed;

        // Update that row’s "score" column to the computed value
        $upd = $conn->prepare("UPDATE kra1_b_sole_authorship
                               SET score = :score
                               WHERE sole_authorship_id = :id");
        $upd->execute([
            ':score' => $scoreComputed,
            ':id'    => $sr['sole_authorship_id']
        ]);
    }

    //  2) Co-Authorship
    //     - Must have (title + reviewer + type) to be valid, else 0
    //     - Same base score as Sole, multiply by contribution_percentage
    $sqlCo = "SELECT co_authorship_id, title, type, reviewer, publisher,
              date_published, date_approved, contribution_percentage, score, evidence_file
              FROM kra1_b_co_authorship
              WHERE request_id = :request_id";
    $stmt = $conn->prepare($sqlCo);
    $stmt->execute([':request_id' => $request_id]);
    $coRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $coSum = 0;
    foreach ($coRows as $cr) {
        $title    = trim($cr['title']);
        $type     = trim($cr['type']);
        $reviewer = trim($cr['reviewer']);
        $contrib  = floatval($cr['contribution_percentage'] ?? 0);

        if ($title === '' || $reviewer === '' || $type === '') {
            $scoreBase = 0;
        } else {
            switch (strtolower($type)) {
                case 'textbook':
                    $scoreBase = 30; 
                    break;
                case 'textbook chapter':
                    $scoreBase = 10;
                    break;
                case 'manual/module':
                    $scoreBase = 16;
                    break;
                case 'multimedia teaching material':
                    $scoreBase = 16;
                    break;
                case 'testing material':
                    $scoreBase = 10;
                    break;
                default:
                    $scoreBase = 0;
                    break;
            }
        }

        $scoreComputed = $scoreBase * $contrib; // multiply by % contribution
        $coSum += $scoreComputed;

        // Update that row’s "score"
        $upd = $conn->prepare("UPDATE kra1_b_co_authorship
                               SET score = :score
                               WHERE co_authorship_id = :id");
        $upd->execute([
            ':score' => $scoreComputed,
            ':id'    => $cr['co_authorship_id']
        ]);
    }

    //  3) Academic Programs
    //     - Must have (program_type + academic_year) not empty => else 0
    //     - Score by role: Lead=10, Contributor=5, else=0
    $sqlAcad = "SELECT academic_prog_id, program_name, program_type, board_approval,
                academic_year, role, score, evidence_file
                FROM kra1_b_academic_programs
                WHERE request_id = :request_id";
    $stmt = $conn->prepare($sqlAcad);
    $stmt->execute([':request_id' => $request_id]);
    $acadRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $acadSum = 0;
    foreach ($acadRows as $ar) {
        $ptype = trim($ar['program_type']);
        $ay    = trim($ar['academic_year']);
        $role  = trim($ar['role']);

        if ($ptype === '' || $ay === '' || $ptype === 'SELECT OPTION') {
            $scoreComputed = 0;
        } else {
            switch (strtolower($role)) {
                case 'lead':
                    $scoreComputed = 10;
                    break;
                case 'contributor':
                    $scoreComputed = 5;
                    break;
                default:
                    $scoreComputed = 0;
                    break;
            }
        }
        $acadSum += $scoreComputed;

        // Update the row’s "score"
        $upd = $conn->prepare("UPDATE kra1_b_academic_programs
                               SET score = :score
                               WHERE academic_prog_id = :id");
        $upd->execute([
            ':score' => $scoreComputed,
            ':id'    => $ar['academic_prog_id']
        ]);
    }

    // Summaries in metadata
    // Check if there's an existing row in kra1_b_metadata
    $stmtMeta = $conn->prepare("SELECT kra1_b_metadata_id FROM kra1_b_metadata WHERE request_id = :request_id");
    $stmtMeta->execute([':request_id' => $request_id]);
    $existingMeta = $stmtMeta->fetch(PDO::FETCH_ASSOC);

    if ($existingMeta) {
        // Update
        $upd = $conn->prepare("
            UPDATE kra1_b_metadata
               SET sole_authorship_total   = :sole_total,
                   co_authorship_total     = :co_total,
                   academic_programs_total = :acad_total
             WHERE kra1_b_metadata_id = :meta_id
        ");
        $upd->execute([
            ':sole_total'  => $soleSum,
            ':co_total'    => $coSum,
            ':acad_total'  => $acadSum,
            ':meta_id'     => $existingMeta['kra1_b_metadata_id']
        ]);
    } else {
        // Insert
        $ins = $conn->prepare("
            INSERT INTO kra1_b_metadata
                (request_id, sole_authorship_total, co_authorship_total, academic_programs_total)
            VALUES
                (:request_id, :sole_total, :co_total, :acad_total)
        ");
        $ins->execute([
            ':request_id' => $request_id,
            ':sole_total' => $soleSum,
            ':co_total'   => $coSum,
            ':acad_total' => $acadSum
        ]);
    }

    $conn->commit();
    echo json_encode([
        'success' => true,
        'message' => 'Criterion B saved and recalculated successfully.'
    ]);

} catch (Exception $e) {
    $conn->rollBack();
    echo json_encode([
        'success' => false,
        'error'   => 'Failed to save Criterion B: ' . $e->getMessage()
    ]);
}
?>
