<?php
/**
 * File: upload_evidence_criterion_a.php
 * This file handles uploading 1st/2nd semester evidence for Criterion A.
 * It updates the corresponding DB row (student or supervisor table).
 * 
 * Logic:
 * - If a file for the given user, request, evaluation, and semester exists, it will be replaced.
 * - If no file exists, a new one will be created.
 */

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

    // Check if evaluation ID is valid
    if (!$evaluationID) {
        throw new Exception('Invalid Evaluation ID.');
    }

    // Prepare file info
    $file1 = $_FILES['fileFirstSemester']  ?? null;
    $file2 = $_FILES['fileSecondSemester'] ?? null;

    // --- Using BASE_PATH for the uploads directory ---
    $uploadDir = BASE_PATH . '/uploads/career_progress_tracking/kra1_teaching/criterion_a/';
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            throw new Exception("Failed to create directory: " . $uploadDir);
        }
    }

    // Function to generate or retrieve the file path (modified to use BASE_PATH)
    function getFilePath($userID, $requestID, $evaluationID, $semester, $file, $uploadDir) {
        // Use the evaluation ID in the filename
        $baseName = "{$userID}_{$requestID}_{$evaluationID}_{$semester}";

        // Check if a file with this base name already exists (regardless of extension)
        $existingFiles = glob("{$uploadDir}{$baseName}.*");
        if (!empty($existingFiles)) {
            // If a file exists, return its path (we'll overwrite it later)
            return $existingFiles[0];
        }

        // If no file exists and a new file is provided, generate a new path with the extension of the uploaded file
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $uniqueName = "{$baseName}.{$ext}";
            return "{$uploadDir}/{$uniqueName}";
        }

        return null;
    }

    // Process files and get their paths (now absolute paths)
    $absolutePaths = [
        'sem1' => getFilePath($userID, $requestID, $evaluationID, 'sem1', $file1, $uploadDir),
        'sem2' => getFilePath($userID, $requestID, $evaluationID, 'sem2', $file2, $uploadDir)
    ];

    // Move uploaded files to their respective paths (overwriting if necessary)
    if ($file1 && $file1['error'] === UPLOAD_ERR_OK) {
        if (!move_uploaded_file($file1['tmp_name'], $absolutePaths['sem1'])) {
            throw new Exception('Failed to move first semester file.');
        }
    }

    if ($file2 && $file2['error'] === UPLOAD_ERR_OK) {
        if (!move_uploaded_file($file2['tmp_name'], $absolutePaths['sem2'])) {
            throw new Exception('Failed to move second semester file.');
        }
    }

    // --- Using BASE_URL for relative paths in the database ---
    $relativePaths = [
        'sem1' => $absolutePaths['sem1'] ? str_replace(BASE_PATH, '', $absolutePaths['sem1']) : null,
        'sem2' => $absolutePaths['sem2'] ? str_replace(BASE_PATH, '', $absolutePaths['sem2']) : null
    ];

    // Decide which table to update based on $tableType
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