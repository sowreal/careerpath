<?php
header('Content-Type: application/json');
require_once '../../../session.php';
require_once '../../../connection.php';
require_once '../../../config.php'; // Include your config file

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

try {
    // Gather POST data
    $userID       = $_SESSION['user_id'];
    $requestID    = isset($_POST['request_id'])    ? intval($_POST['request_id'])    : 0;
    $evaluationID = isset($_POST['evaluation_id']) ? trim($_POST['evaluation_id']) : '';
    $tableType    = isset($_POST['table_type'])    ? trim($_POST['table_type'])      : 'student';
    $semester     = isset($_POST['semester'])       ? trim($_POST['semester'])         : ''; // 'sem1' or 'sem2'

    // Validate input
    if (!$evaluationID || !$semester) {
        throw new Exception('Invalid input data.');
    }

    // Determine the table and column to update based on $tableType and $semester
    if ($tableType === 'student') {
        $table = 'kra1_a_student_evaluation';
    } else if ($tableType === 'supervisor') {
        $table = 'kra1_a_supervisor_evaluation';
    } else {
        throw new Exception('Invalid table type.');
    }

    $column = ($semester === 'sem1') ? 'evidence_file_1' : 'evidence_file_2';

    // Construct the file path (similar logic to getFilePath)
    $baseName = "{$userID}_{$requestID}_{$evaluationID}_{$semester}";
    $uploadDir = BASE_PATH . '/uploads/career_progress_tracking/kra1_teaching/criterion_a/';
    $existingFiles = glob("{$uploadDir}{$baseName}.*");

    // Delete the file if it exists
    if (!empty($existingFiles)) {
        $filePath = $existingFiles[0]; // Full path to the file
        if (is_file($filePath)) {
            if (!unlink($filePath)) {
                throw new Exception("Failed to delete file: {$filePath}");
            }
        }

        // Update the database record to set the corresponding column to NULL
        $sql = "UPDATE {$table} SET {$column} = NULL WHERE evaluation_id = :evaluation_id AND request_id = :request_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':evaluation_id' => $evaluationID,
            ':request_id'    => $requestID
        ]);

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'File not found.']);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>