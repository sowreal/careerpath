<?php
// careerpath/php/includes/career_progress_tracking/teaching/fetch_criterion_a.php
require_once '../../../connection.php';

header('Content-Type: application/json');

try {
    // Assume request_id is passed via GET or session
    $request_id = $_GET['request_id'];

    // Fetch Student Evaluations
    $stmt = $conn->prepare("SELECT * FROM kra1_a_student_evaluation WHERE request_id = ?");
    $stmt->execute([$request_id]);
    $student_evaluations = $stmt->fetchAll();

    // Fetch Supervisor Evaluations
    $stmt = $conn->prepare("SELECT * FROM kra1_a_supervisor_evaluation WHERE request_id = ?");
    $stmt->execute([$request_id]);
    $supervisor_evaluations = $stmt->fetchAll();

    // Fetch Metadata
    $stmt = $conn->prepare("SELECT * FROM kra1_a_metadata 
        JOIN kra1_a_student_evaluation ON kra1_a_metadata.student_evaluation_id = kra1_a_student_evaluation.evaluation_id 
        JOIN kra1_a_supervisor_evaluation ON kra1_a_metadata.supervisor_evaluation_id = kra1_a_supervisor_evaluation.evaluation_id 
        WHERE kra1_a_student_evaluation.request_id = ?");
    $stmt->execute([$request_id]);
    $metadata = $stmt->fetchAll();

    echo json_encode([
        'status' => 'success',
        'student_evaluations' => $student_evaluations,
        'supervisor_evaluations' => $supervisor_evaluations,
        'metadata' => $metadata
    ]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
