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
    $userID      = $_SESSION['user_id'];
    $requestID   = isset($_POST['modal_request_id']) ? intval($_POST['modal_request_id']) : 0;
    $recordID    = isset($_POST['modal_record_id'])  ? intval($_POST['modal_record_id'])  : 0;
    $subcriterion= isset($_POST['modal_subcriterion']) ? trim($_POST['modal_subcriterion']) : '';
    $oldFilePath = isset($_POST['existing_file_path']) ? trim($_POST['existing_file_path']) : '';

    if ($requestID <= 0 || $recordID < 0 || !$subcriterion) {
        throw new Exception('Invalid input data for uploading evidence (Criterion B).');
    }

    // Determine the DB table to update
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

    // Check if the record actually exists (must be an existing row)
    if ($recordID === 0) {
        throw new Exception('Please save the row before uploading evidence (row must have a valid ID).');
    }
    $stmt = $conn->prepare("SELECT 1 FROM $tableName WHERE $idColumn = :rid AND request_id = :reqid");
    $stmt->execute([':rid' => $recordID, ':reqid' => $requestID]);
    if (!$stmt->fetchColumn()) {
        throw new Exception('No matching record found; please save the row first.');
    }

    // File validation
    $fileKey = 'singleFileInput'; 
    $file = $_FILES['singleFileInput'] ?? null;
    if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('No file was uploaded or an upload error occurred.');
    }

    $allowedExtensions = ['pdf','doc','docx','jpg','jpeg','png','xlsx','xls'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExtensions)) {
        throw new Exception("Invalid file type. Allowed types: " . implode(', ', $allowedExtensions));
    }

    // Prepare upload directory
    $uploadDir = BASE_PATH . '/uploads/career_progress_tracking/kra1_teaching/criterion_b/';
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            throw new Exception("Failed to create directory: $uploadDir");
        }
    }

    // Create unique file name. In practice, you might want to prefix with userID, requestID, recordID, etc.
    $uniqueName = $userID . '_B_' . $recordID . '_' . time() . '.' . $ext;
    $targetPath = $uploadDir . $uniqueName;

    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        throw new Exception('Failed to move the uploaded file.');
    }

    // The relative path for storing in DB
    $relativePath = 'uploads/career_progress_tracking/kra1_teaching/criterion_b/' . $uniqueName;

    // Delete old file if any
    if ($oldFilePath && $oldFilePath !== $relativePath) {
        $fullOldPath = BASE_PATH . '/' . $oldFilePath;
        if (is_file($fullOldPath)) {
            @unlink($fullOldPath);
        }
    }

    // Update DB
    $stmt = $conn->prepare("UPDATE $tableName
                            SET evidence_file = :file
                            WHERE $idColumn = :rid AND request_id = :reqid");
    $stmt->execute([
        ':file' => $relativePath,
        ':rid'  => $recordID,
        ':reqid'=> $requestID
    ]);

    echo json_encode([
        'success' => true,
        'path'    => $relativePath
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
