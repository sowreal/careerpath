<?php
/**
 * File: upload_evidence_criterion_a.php
 * Handles uploading 1st/2nd semester evidence for Criterion A.
 */
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
    $requestID    = isset($_POST['request_id'])    ? intval($_POST['request_id'])    : 0;
    $evaluationID = isset($_POST['evaluation_id']) ? trim($_POST['evaluation_id'])   : '';
    $tableType    = isset($_POST['table_type'])    ? trim($_POST['table_type'])      : 'student';

    if (!$evaluationID) {
        throw new Exception('Invalid Evaluation ID.');
    }

    // Check if the evaluation ID exists in the database
    if ($tableType === 'student') {
        $sql = "SELECT 1 FROM kra1_a_student_evaluation WHERE evaluation_id = :evaluation_id AND request_id = :request_id";
    } else {
        $sql = "SELECT 1 FROM kra1_a_supervisor_evaluation WHERE evaluation_id = :evaluation_id AND request_id = :request_id";
    }
    $stmt = $conn->prepare($sql);
    $stmt->execute([':evaluation_id' => $evaluationID, ':request_id' => $requestID]);
    $exists = $stmt->fetchColumn();

    if (!$exists) {
        throw new Exception('Please save the row before uploading evidence.');
    }

    $file1 = $_FILES['fileFirstSemester']  ?? null;
    $file2 = $_FILES['fileSecondSemester'] ?? null;

    $allowedExtensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'xlsx', 'xls'];

    $uploadDir = BASE_PATH . '/uploads/career_progress_tracking/kra1_teaching/criterion_a/';
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            throw new Exception("Failed to create directory: " . $uploadDir);
        }
    }

    function getFilePath($file, $uploadDir, $allowedExtensions) {
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, $allowedExtensions)) {
                throw new Exception("Invalid file type. Allowed types: " . implode(", ", $allowedExtensions));
            }
            $uniqueName = $file['name'];
            return "uploads/career_progress_tracking/kra1_teaching/criterion_a/{$uniqueName}";
        }
        return null;
    }

    $relativePaths = [
        'sem1' => getFilePath($file1, $uploadDir, $allowedExtensions),
        'sem2' => getFilePath($file2, $uploadDir, $allowedExtensions)
    ];

    if ($file1 && $file1['error'] === UPLOAD_ERR_OK) {
        $targetPath = BASE_PATH . '/' . $relativePaths['sem1'];
        if (!move_uploaded_file($file1['tmp_name'], $targetPath)) {
            throw new Exception('Failed to move first semester file.');
        }
    }
    if ($file2 && $file2['error'] === UPLOAD_ERR_OK) {
        $targetPath = BASE_PATH . '/' . $relativePaths['sem2'];
        if (!move_uploaded_file($file2['tmp_name'], $targetPath)) {
            throw new Exception('Failed to move second semester file.');
        }
    }

    if ($tableType === 'student') {
        $sql = "UPDATE kra1_a_student_evaluation
                SET evidence_file_1 = COALESCE(:sem1, evidence_file_1),
                    evidence_file_2 = COALESCE(:sem2, evidence_file_2)
                WHERE evaluation_id = :evaluation_id AND request_id = :request_id";
    } else {
        $sql = "UPDATE kra1_a_supervisor_evaluation
                SET evidence_file_1 = COALESCE(:sem1, evidence_file_1),
                    evidence_file_2 = COALESCE(:sem2, evidence_file_2)
                WHERE evaluation_id = :evaluation_id AND request_id = :request_id";
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':sem1'          => $relativePaths['sem1'],
        ':sem2'          => $relativePaths['sem2'],
        ':evaluation_id' => $evaluationID,
        ':request_id'    => $requestID
    ]);

    echo json_encode(['success' => true, 'paths' => $relativePaths]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>