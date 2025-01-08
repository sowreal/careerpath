<?php
header('Content-Type: application/json');
require_once '../../../session.php';
require_once '../../../connection.php';
require_once '../../../config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

try {
    $userID       = $_SESSION['user_id'];
    $requestID    = isset($_POST['request_id']) ? intval($_POST['request_id']) : 0;
    $recordID     = isset($_POST['record_id'])  ? intval($_POST['record_id'])  : 0;
    $subcriterion = isset($_POST['subcriterion']) ? trim($_POST['subcriterion']) : '';

    if ($requestID <= 0 || $recordID <= 0 || !$subcriterion) {
        throw new Exception('Invalid input for deleting Criterion B evidence.');
    }

    // Determine table/column
    switch ($subcriterion) {
        case 'sole':
            $tableName = 'kra1_b_sole_authorship';
            $idColumn  = 'sole_authorship_id';
            break;
        case 'co':
            $tableName = 'kra1_b_co_authorship';
            $idColumn  = 'co_authorship_id';
            break;
        case 'acad':
            $tableName = 'kra1_b_academic_programs';
            $idColumn  = 'academic_prog_id';
            break;
        default:
            throw new Exception('Invalid sub-criterion specified.');
    }

    // Fetch existing file path
    $stmt = $conn->prepare("SELECT evidence_file FROM $tableName WHERE $idColumn = :rid AND request_id = :reqid");
    $stmt->execute([':rid' => $recordID, ':reqid' => $requestID]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        throw new Exception('No matching record found for the given ID.');
    }

    $filePath = $row['evidence_file'];
    if ($filePath) {
        $fullPath = BASE_PATH . '/' . $filePath;
        if (is_file($fullPath)) {
            if (!unlink($fullPath)) {
                throw new Exception("Failed to delete file: $fullPath");
            }
        }
    }

    // Set evidence_file = NULL in DB
    $stmt = $conn->prepare("UPDATE $tableName SET evidence_file = NULL
                           WHERE $idColumn = :rid AND request_id = :reqid");
    $stmt->execute([':rid' => $recordID, ':reqid' => $requestID]);

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
