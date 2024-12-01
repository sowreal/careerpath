<?php
// careerpath/php/includes/career_progress_tracking/teaching/fetch_criterion_a.php
header('Content-Type: application/json');
session_start();
require_once '../../../connection.php'; // Include your DB connection

$response = ['status' => 'error', 'message' => 'Invalid request'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $request_id = $_GET['request_id'] ?? null;
    $evaluation_number = $_GET['evaluation_number'] ?? null;

    if (!$request_id || !$evaluation_number) {
        echo json_encode($response);
        exit;
    }

    try {
        // Fetch Metadata
        $stmt = $pdo->prepare("SELECT * FROM kra1_a_metadata WHERE request_id = ?");
        $stmt->execute([$request_id]);
        $metadata = $stmt->fetch(PDO::FETCH_ASSOC);

        // Fetch Student Evaluations
        $stmt = $pdo->prepare("SELECT * FROM kra1_a_student_evaluation WHERE request_id = ?");
        $stmt->execute([$request_id]);
        $student_evaluations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetch Supervisor Evaluations
        $stmt = $pdo->prepare("SELECT * FROM kra1_a_supervisor_evaluation WHERE request_id = ?");
        $stmt->execute([$request_id]);
        $supervisor_evaluations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = [
            'student_semesters_to_deduct' => $metadata['student_semesters_to_deduct'] ?? 0,
            'student_reason_for_reduction' => $metadata['student_reason_for_reduction'] ?? '',
            'student_evidence_link' => $metadata['student_evidence_link'] ?? '',
            'student_evaluations' => $student_evaluations,
            'supervisor_semesters_to_deduct' => $metadata['supervisor_semesters_to_deduct'] ?? 0,
            'supervisor_reason_for_reduction' => $metadata['supervisor_reason_for_reduction'] ?? '',
            'supervisor_evidence_link' => $metadata['supervisor_evidence_link'] ?? '',
            'supervisor_evaluations' => $supervisor_evaluations
        ];

        $response = ['status' => 'success', 'data' => $data];
    } catch (Exception $e) {
        $response = ['status' => 'error', 'message' => $e->getMessage()];
    }
}

echo json_encode($response);
?>
