<?php
require_once '../../../connection.php';
require_once '../../../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = $_POST['request_id'];
    $table = $_POST['table'];
    $row_id = $_POST['row_id'];

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

    // Fetch the file path from the database
    $stmt = $conn->prepare("SELECT evidence_file FROM $table WHERE $primary_key = ? AND request_id = ?");
    $stmt->execute([$row_id, $request_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $filePath = $result['evidence_file'];

        // Delete the file from the server
        if (!empty($filePath) && file_exists(BASE_PATH . $filePath)) {
            unlink(BASE_PATH . $filePath);
        }

        // Update the database to remove the file path
        $stmt = $conn->prepare("UPDATE $table SET evidence_file = NULL WHERE $primary_key = ? AND request_id = ?");
        if ($stmt->execute([$row_id, $request_id])) {
            echo json_encode(['status' => 'success', 'message' => 'Evidence deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error deleting evidence from database']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Evidence not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>