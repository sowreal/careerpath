<?php
header('Content-Type: application/json');

try {
    // Include the database connection
    require_once '../../../connection.php';

    // Get request_id from GET or POST
    $request_id = isset($_GET['request_id']) ? intval($_GET['request_id']) :
                 (isset($_POST['request_id']) ? intval($_POST['request_id']) : 0);

    if ($request_id <= 0) {
        throw new Exception("Invalid request ID.");
    }

    // Fetch kra1_a_metadata
    $stmt = $conn->prepare("SELECT * FROM kra1_a_metadata WHERE request_id = ?");
    $stmt->execute([$request_id]);
    // Fetch a single row from the result set as an associative array where the keys are column names
    $metadata = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch Student Evaluations
    $stmt = $conn->prepare("SELECT * FROM kra1_a_student_evaluation WHERE request_id = ?");
    $stmt->execute([$request_id]);
    // Fetch all rows from the result set as an array of associative arrays, with each row's keys being column names
    $student_evaluations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch Supervisor Evaluations
    $stmt = $conn->prepare("SELECT * FROM kra1_a_supervisor_evaluation WHERE request_id = ?");
    $stmt->execute([$request_id]);
    // Fetch all rows from the result set as an array of associative arrays, with each row's keys being column names
    $supervisor_evaluations = $stmt->fetchAll(PDO::FETCH_ASSOC);


    // Prepare response
    $response = [
        'success' => true,
        'metadata' => $metadata,
        'student_evaluations' => $student_evaluations,
        'supervisor_evaluations' => $supervisor_evaluations
    ];

    echo json_encode($response);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
