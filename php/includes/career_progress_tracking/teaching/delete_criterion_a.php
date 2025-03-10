<!--  -->
<!--  -->
<!-- THIS FILE IS NO LONGER NEEDED. KEEP FOR BACKUP. -->
<!--  -->
<!--  -->
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
if (!isset($data['evaluation_id']) || !is_numeric($data['evaluation_id']) || intval($data['evaluation_id']) <= 0) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid Evaluation ID provided.']);
    exit();
}

if (!isset($data['table']) || !in_array($data['table'], ['student', 'supervisor'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid table specified.']);
    exit();
}

$evaluation_id = intval($data['evaluation_id']);
$table = $data['table'];

try {
    // Begin Transaction
    $conn->beginTransaction();

    if ($table === 'student') {
        // Delete from Student Evaluations Table
        $stmt = $conn->prepare("DELETE FROM kra1_a_student_evaluation WHERE evaluation_id = :evaluation_id");
        $stmt->bindParam(':evaluation_id', $evaluation_id, PDO::PARAM_INT);
        $stmt->execute();
    } elseif ($table === 'supervisor') {
        // Delete from Supervisor Evaluations Table
        $stmt = $conn->prepare("DELETE FROM kra1_a_supervisor_evaluation WHERE evaluation_id = :evaluation_id");
        $stmt->bindParam(':evaluation_id', $evaluation_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Commit Transaction
    $conn->commit();

    // Respond with Success
    echo json_encode(['success' => 'Evaluation deleted successfully.']);
} catch (Exception $e) {
    // Rollback Transaction in Case of Error
    $conn->rollBack();
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Failed to delete evaluation. Please try again later.']);
}
?>
 