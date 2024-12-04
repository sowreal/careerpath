<?php
include_once '../../../session.php';
// Set the response header to JSON
header('Content-Type: application/json');
include_once '../../../connection.php';

// Check if the user is authenticated
if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(['error' => 'Unauthorized access. Please log in.']);
    exit();
}

// Retrieve the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

// Validate the input
if (!isset($data['entry_id']) || !is_numeric($data['entry_id']) || intval($data['entry_id']) <= 0) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid Entry ID provided.']);
    exit();
}

if (!isset($data['table']) || !in_array($data['table'], ['sole_authorship', 'co_authorship', 'academic_programs'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid table specified.']);
    exit();
}

$entry_id = intval($data['entry_id']);
$table = $data['table'];

try {
    // Begin Transaction
    $conn->beginTransaction();

    if ($table === 'sole_authorship') {
        // Delete from Sole Authorship Table
        $stmt = $conn->prepare("DELETE FROM kra1_b_sole_authorship WHERE entry_id = :entry_id");
        $stmt->bindParam(':entry_id', $entry_id, PDO::PARAM_INT);
        $stmt->execute();
    } elseif ($table === 'co_authorship') {
        // Delete from Co-Authorship Table
        $stmt = $conn->prepare("DELETE FROM kra1_b_co_authorship WHERE entry_id = :entry_id");
        $stmt->bindParam(':entry_id', $entry_id, PDO::PARAM_INT);
        $stmt->execute();
    } elseif ($table === 'academic_programs') {
        // Delete from Academic Programs Table
        $stmt = $conn->prepare("DELETE FROM kra1_b_academic_programs WHERE entry_id = :entry_id");
        $stmt->bindParam(':entry_id', $entry_id, PDO::PARAM_INT);
        $stmt->execute();
    } else {
        // If table is not recognized
        throw new Exception('Invalid table specified.');
    }

    // Commit Transaction
    $conn->commit();

    // Respond with Success
    echo json_encode(['success' => 'Entry deleted successfully.']);
} catch (Exception $e) {
    // Rollback Transaction in Case of Error
    $conn->rollBack();
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Failed to delete entry. Please try again later.']);
}
?>
