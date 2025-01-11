<?php
// careerpath/php/includes/career_progress_tracking/research/kra2_delete_evidence_criterion_a.php
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
    $requestID = isset($_POST['request_id']) ? intval($_POST['request_id']) : 0;
    $recordID = isset($_POST['record_id']) ? intval($_POST['record_id']) : 0;
    $subcriterion = isset($_POST['subcriterion']) ? trim($_POST['subcriterion']) : '';

    if ($requestID <= 0 || $recordID <= 0 || !$subcriterion) {
        throw new Exception('Invalid input data for deleting evidence (Criterion A).');
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

    // Get the file path from the database
    $stmt = $conn->prepare("SELECT evidence_file FROM $tableName WHERE $idColumn = :recordId AND request_id = :requestId");
    $stmt->execute([':recordId' => $recordID, ':requestId' => $requestID]);
    $filePath = $stmt->fetchColumn();

    if (!$filePath) {
        throw new Exception('No evidence file found for the given record.');
    }

    // Construct the full file path
    $fullFilePath = BASE_PATH . '/' . $filePath;

    // Check if the file exists and is readable
    if (is_file($fullFilePath) && is_readable($fullFilePath)) {
        // Attempt to delete the file
        if (!unlink($fullFilePath)) {
            throw new Exception('Failed to delete the evidence file.');
        }
    } else {
        throw new Exception('Evidence file not found or not readable.');
    }

    // Update the database record to remove the file path
    $stmt = $conn->prepare("UPDATE $tableName SET evidence_file = NULL WHERE $idColumn = :recordId AND request_id = :requestId");
    $stmt->execute([':recordId' => $recordID, ':requestId' => $requestID]);

    echo json_encode([
        'success' => true,
        'message' => 'Evidence file deleted successfully.'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>