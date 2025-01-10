<!-- php/includes/career_progress_tracking/research/kra2_upload_evidence_criterion_a.php -->
<?php
require_once '../../../connection.php';
require_once '../../../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['evidence_file'])) {
    $request_id = $_POST['request_id'];
    $table = $_POST['table']; // e.g., 'kra2_a_sole_authorship'
    $row_id = $_POST['row_id']; // Primary key value of the row
    $file = $_FILES['evidence_file'];

    // Determine the primary key column name based on the table
    switch ($table) {
        case 'kra2_a_sole_authorship':
            $primary_key = 'sole_authorship_id';
            break;
        case 'kra2_a_co_authorship':
            $primary_key = 'co_authorship_id';
            break;
        case 'kra2_a_lead_researcher':
            $primary_key = 'lead_researcher_id';
            break;
        case 'kra2_a_contributor':
            $primary_key = 'contributor_id';
            break;
        case 'kra2_a_local_authors':
            $primary_key = 'local_author_id';
            break;
        case 'kra2_a_international_authors':
            $primary_key = 'international_author_id';
            break;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid table name']);
            exit;
    }

    $uploadDir = '/uploads/research_evidence/';
    $uploadPath = BASE_PATH . $uploadDir; // Using BASE_PATH
    $originalFileName = $file['name'];
    $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
    $uniqueFileName = uniqid('evidence_' . $request_id . '_' . $row_id . '_') . '.' . $fileExtension;
    $targetFilePath = $uploadPath . $uniqueFileName;

    if (!file_exists($uploadPath)) {
        mkdir($uploadPath, 0777, true);
    }

    if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
        // Get the old file path
        $stmt = $conn->prepare("SELECT evidence_file FROM $table WHERE $primary_key = ? AND request_id = ?");
        $stmt->execute([$row_id, $request_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Delete the old file if it exists
        if ($result && !empty($result['evidence_file']) && file_exists(BASE_PATH . $result['evidence_file'])) {
            unlink(BASE_PATH . $result['evidence_file']);
        }

        // Update the database with the new file path
        $relativePath = $uploadDir . $uniqueFileName;
        $stmt = $conn->prepare("UPDATE $table SET evidence_file = ? WHERE $primary_key = ? AND request_id = ?");
        if ($stmt->execute([$relativePath, $row_id, $request_id])) {
            echo json_encode(['status' => 'success', 'message' => 'File uploaded successfully', 'file_path' => $relativePath]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error updating database']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error uploading file']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>