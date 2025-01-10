<?php
// careerpath/php/includes/career_progress_tracking/research/kra2_upload_evidence_criterion_a.php
header('Content-Type: application/json');
require_once '../../../session.php';
require_once '../../../connection.php';
require_once '../../../config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

try {
    $userID = $_SESSION['user_id'];
    $requestID = isset($_POST['a_modal_request_id']) ? intval($_POST['a_modal_request_id']) : 0;
    $recordID = isset($_POST['a_modal_record_id']) ? intval($_POST['a_modal_record_id']) : 0;
    $subcriterion = isset($_POST['a_modal_subcriterion']) ? trim($_POST['a_modal_subcriterion']) : '';
    $oldFilePath = isset($_POST['a_existing_file_path']) ? trim($_POST['a_existing_file_path']) : '';

    if ($requestID <= 0 || $recordID <= 0 || !$subcriterion) {
        throw new Exception('Invalid input data for uploading evidence (Criterion A).');
    }

    // Determine the DB table to update based on subcriterion
    switch ($subcriterion) {
        case 'sole_authorship':
            $tableName = 'kra2_a_sole_authorship';
            $idColumn = 'sole_authorship_id';
            break;
        case 'co_authorship':
            $tableName = 'kra2_a_co_authorship';
            $idColumn = 'co_authorship_id';
            break;
        case 'lead_researcher':
            $tableName = 'kra2_a_lead_researcher';
            $idColumn = 'lead_researcher_id';
            break;
        case 'contributor':
            $tableName = 'kra2_a_contributor';
            $idColumn = 'contributor_id';
            break;
        case 'local_authors':
            $tableName = 'kra2_a_local_authors';
            $idColumn = 'local_author_id';
            break;
        case 'international_authors':
            $tableName = 'kra2_a_international_authors';
            $idColumn = 'international_author_id';
            break;
        default:
            throw new Exception('Invalid sub-criterion specified.');
    }

    // Check if the record exists
    $stmt = $conn->prepare("SELECT 1 FROM $tableName WHERE $idColumn = :recordId AND request_id = :requestId");
    $stmt->execute([':recordId' => $recordID, ':requestId' => $requestID]);
    if (!$stmt->fetchColumn()) {
        throw new Exception('No matching record found for the given ID and request ID.');
    }

    // File validation
    $file = $_FILES['singleAFileInput'] ?? null;
    if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('No file was uploaded or an upload error occurred.');
    }

    $allowedExtensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'xlsx', 'xls'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExtensions)) {
        throw new Exception("Invalid file type. Allowed types: " . implode(', ', $allowedExtensions));
    }

    // Prepare upload directory
    $uploadDir = BASE_PATH . '/uploads/career_progress_tracking/kra2_research/criterion_a/';
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            throw new Exception("Failed to create directory: $uploadDir");
        }
    }

    // Create unique file name 
    $uniqueName = $userID . '_A_' . $recordID . '_' . time() . '.' . $ext;
    $targetPath = $uploadDir . $uniqueName;

    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        throw new Exception('Failed to move the uploaded file.');
    }

    // Relative path for storing in DB
    $relativePath = 'uploads/career_progress_tracking/kra2_research/criterion_a/' . $uniqueName;

    // Delete old file if applicable
    if ($oldFilePath && $oldFilePath !== $relativePath) {
        $fullOldPath = BASE_PATH . '/' . $oldFilePath;
        if (file_exists($fullOldPath)) {
            unlink($fullOldPath);
        }
    }

    // Update database record
    $stmt = $conn->prepare("UPDATE $tableName SET evidence_file = :file WHERE $idColumn = :recordId AND request_id = :requestId");
    $stmt->execute([':file' => $relativePath, ':recordId' => $recordID, ':requestId' => $requestID]);

    echo json_encode([
        'success' => true,
        'path' => $relativePath
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>