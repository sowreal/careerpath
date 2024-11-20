<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
header('Content-Type: application/json; charset=utf-8');

include('../../connection.php'); // Adjust the path as necessary

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit();
}

$user_id = $_SESSION['user_id'];
$request_id = isset($_GET['request_id']) ? $_GET['request_id'] : null;

if (!$request_id) {
    echo json_encode(['success' => false, 'error' => 'Invalid request. Request ID is missing.']);
    exit();
}

try {
    // Fetch student evaluations
    $stmt = $conn->prepare("SELECT * FROM kra1_a_student_evaluation WHERE user_id = :user_id AND request_id = :request_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':request_id', $request_id, PDO::PARAM_INT);
    $stmt->execute();
    $student_evaluations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch supervisor evaluations
    $stmt = $conn->prepare("SELECT * FROM kra1_a_supervisor_evaluation WHERE user_id = :user_id AND request_id = :request_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':request_id', $request_id, PDO::PARAM_INT);
    $stmt->execute();
    $supervisor_evaluations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'criterion_data' => [
            'student_evaluations' => $student_evaluations,
            'supervisor_evaluations' => $supervisor_evaluations
        ]
    ]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}
?>
