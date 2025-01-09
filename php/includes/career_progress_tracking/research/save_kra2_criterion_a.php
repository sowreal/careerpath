<?php
// php/includes/career_progress_tracking/research/save_kra2_criterion_a.php

session_start();
include '../../../connection.php';

// Authentication Check
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit();
}

// Method Check
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method Not Allowed']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

// Basic Validation
if (!$data || !isset($data['action']) || $data['action'] !== 'save') {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid Request']);
    exit();
}

$request_id = $data['request_id'];
$user_id = $_SESSION['user_id']; // Get the user_id from the session

// --- Handle File Uploads (When "Save Criterion A" is clicked) ---
$uploadDir = '../../../../evidences/research/kra2_a/'; // Define the upload directory
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
}

$filesToUpload = $data['filesToUpload'] ?? [];
$uploadSuccess = true;
$errorMessages = [];

foreach ($filesToUpload as $fileIndex => $fileData) {
    $file = $_FILES['file_' . $fileIndex] ?? null;

    // Check if a file was selected in the modal (if not, it remains an index)
    if (is_numeric($fileData['file'])) {
        continue; // Skip this file as it wasn't updated
    }

    $record_id = $fileData['record_id'];
    $subcriterion = $fileData['subcriterion'];

    // **Security:** Validate file type and size here (important!)
    // ... (Add your validation logic based on allowed types and size limits) ...

    // Use user_id, request_id, and other details to create a unique file name
    $uniqueFileName = $user_id . '_' . $request_id . '_' . $subcriterion . '_' . $record_id . '_' . time() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
    $targetFilePath = $uploadDir . $uniqueFileName;

    // Move the uploaded file
    if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
        // File uploaded successfully, update the database record with the file path
        $table = 'kra2_a_' . $subcriterion;
        $idColumn = $subcriterion . '_id';

        $sql = "UPDATE $table SET evidence_file = :evidence_file WHERE $idColumn = :record_id AND request_id = :request_id";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            $errorInfo = $conn->errorInfo();
            $errorMessages[] = 'Database prepare error: ' . $errorInfo[2];
            $uploadSuccess = false;
            break;
        }

        $stmt->bindParam(':evidence_file', $uniqueFileName);
        $stmt->bindParam(':record_id', $record_id);
        $stmt->bindParam(':request_id', $request_id);

        if (!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            $errorMessages[] = 'Database update error: ' . $errorInfo[2];
            $uploadSuccess = false;
            break;
        }
    } else {
        $errorMessages[] = 'File upload failed for file index: ' . $fileIndex;
        $uploadSuccess = false;
        break;
    }
}

// Stop saving if any file upload failed
if (!$uploadSuccess) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'File upload failed: ' . implode('; ', $errorMessages)]);
    exit();
}

// --- Save Data to Database ---
$conn->beginTransaction(); // Start a transaction

try {
    // 1. Save data to the sub-criterion tables (sole_authorship, co_authorship, etc.)
    $subcriteria = [
        'sole_authorship', 'co_authorship', 'lead_researcher', 'contributor', 'local_authors', 'international_authors'
    ];

    foreach ($subcriteria as $sub) {
        if (!isset($data[$sub]) || !is_array($data[$sub])) continue;

        foreach ($data[$sub] as $row) {
            $record_id = $row[$sub . '_id'];
            $isNew = ($record_id == '0' || $record_id == '' || is_null($record_id));
            $fileIndex = $row['evidence_file']; // Index of the file in selectedFiles array

            // Determine the file path based on whether it's a new upload or an existing file
            if (isset($filesToUpload[$fileIndex])) {
                $fileData = $filesToUpload[$fileIndex];
                $fileName = $user_id . '_' . $request_id . '_' . $sub . '_' . $fileData['record_id'] . '_' . time() . '.' . pathinfo($fileData['file']['name'], PATHINFO_EXTENSION);
                $evidence_file = $fileName; // Update with the new file name
            } else {
                // Existing file, get the current evidence_file value
                $selectSql = "SELECT evidence_file FROM kra2_a_{$sub} WHERE {$sub}_id = :record_id AND request_id = :request_id";
                $selectStmt = $conn->prepare($selectSql);
                $selectStmt->bindParam(':record_id', $record_id);
                $selectStmt->bindParam(':request_id', $request_id);
                $selectStmt->execute();
                $result = $selectStmt->fetch(PDO::FETCH_ASSOC);
                $evidence_file = $result['evidence_file'] ?? null;
            }

            $table = "kra2_a_" . $sub;
            $fields = [];
            $values = [];
            $updates = [];
            $params = [':request_id' => $request_id];

            foreach ($row as $key => $value) {
                if ($key == $sub . '_id') continue;
                
                $fields[] = $key;
                $values[] = ':' . $key;
                $updates[] = "$key = :$key";

                // Handle NULL for date_published if empty
                if ($key === 'date_published' && empty($value)) {
                    $params[':' . $key] = null;
                } elseif ($key === 'evidence_file') {
                    $params[':' . $key] = $evidence_file; // Use the determined file path
                } else {
                    $params[':' . $key] = $value;
                }
            }

            if ($isNew) {
                // INSERT new row
                $fields[] = 'request_id';
                $values[] = ':request_id';
                $sql = "INSERT INTO $table (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $values) . ")";
            } else {
                // UPDATE existing row
                $params[':' . $sub . '_id'] = $record_id;
                $sql = "UPDATE $table SET " . implode(', ', $updates) . " WHERE {$sub}_id = :{$sub}_id AND request_id = :request_id";
            }

            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                $errorInfo = $conn->errorInfo();
                throw new Exception('Database prepare error: ' . $errorInfo[2]);
            }

            $stmt->execute($params);

            // If it's a new record, get the last inserted ID and update filesToUpload index
            if ($isNew) {
                $lastInsertedId = $conn->lastInsertId();
                foreach ($filesToUpload as &$fileData) {
                    if ($fileData['subcriterion'] === $sub && $fileData['record_id'] == $record_id) {
                        $fileData['record_id'] = $lastInsertedId;
                    }
                }
                unset($fileData); // Unset reference
            }
        }
    }

    // 2. Delete rows that were marked for deletion
    if (isset($data['deleted_records']) && is_array($data['deleted_records'])) {
        foreach ($data['deleted_records'] as $sub => $recordIds) {
            if (empty($recordIds)) continue;

            $table = "kra2_a_" . $sub;
            $placeholders = implode(',', array_fill(0, count($recordIds), '?'));
            $sql = "DELETE FROM $table WHERE {$sub}_id IN ($placeholders) AND request_id = ?";

            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                $errorInfo = $conn->errorInfo();
                throw new Exception('Database prepare error: ' . $errorInfo[2]);
            }

            $stmt->execute(array_merge($recordIds, [$request_id]));
        }
    }

    // 3. Update metadata table
    $metadata = $data['metadata'];
    $sql = "INSERT INTO kra2_a_metadata (request_id, sole_authorship_total, co_authorship_total, lead_researcher_total, contributor_total, local_authors_total, international_authors_total) 
            VALUES (:request_id, :sole_authorship_total, :co_authorship_total, :lead_researcher_total, :contributor_total, :local_authors_total, :international_authors_total)
            ON DUPLICATE KEY UPDATE
            sole_authorship_total = :sole_authorship_total,
            co_authorship_total = :co_authorship_total,
            lead_researcher_total = :lead_researcher_total,
            contributor_total = :contributor_total,
            local_authors_total = :local_authors_total,
            international_authors_total = :international_authors_total";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        $errorInfo = $conn->errorInfo();
        throw new Exception('Database prepare error: ' . $errorInfo[2]);
    }

    $stmt->bindParam(':request_id', $request_id);
    $stmt->bindParam(':sole_authorship_total', $metadata['sole_authorship_total']);
    $stmt->bindParam(':co_authorship_total', $metadata['co_authorship_total']);
    $stmt->bindParam(':lead_researcher_total', $metadata['lead_researcher_total']);
    $stmt->bindParam(':contributor_total', $metadata['contributor_total']);
    $stmt->bindParam(':local_authors_total', $metadata['local_authors_total']);
    $stmt->bindParam(':international_authors_total', $metadata['international_authors_total']);

    if (!$stmt->execute()) {
        $errorInfo = $stmt->errorInfo();
        throw new Exception('Database update error: ' . $errorInfo[2]);
    }

    $conn->commit(); // Commit the transaction

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    $conn->rollBack(); // Roll back the transaction on error
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}