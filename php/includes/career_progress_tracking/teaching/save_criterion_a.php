<?php
// save_criterion_a.php

// Start session if not already started
require_once '../../../session.php';
// Include database connection
require_once '../../../connection.php';

header('Content-Type: application/json');

try {
    // Start transaction
    $conn->beginTransaction();

    // Retrieve and sanitize POST data
    $request_id = $_POST['request_id']; // Ensure this is passed securely, e.g., via session

    // Student Evaluation Data
    $student_evaluations = $_POST['student_evaluation_period'];
    $student_ratings1 = $_POST['student_rating_1'];
    $student_ratings2 = $_POST['student_rating_2'];
    $student_evidence_links = $_POST['student_evidence_link'];

    // Supervisor Evaluation Data
    $supervisor_evaluations = $_POST['supervisor_evaluation_period'];
    $supervisor_ratings1 = $_POST['supervisor_rating_1'];
    $supervisor_ratings2 = $_POST['supervisor_rating_2'];
    $supervisor_evidence_links = $_POST['supervisor_evidence_link'];

    // Metadata
    $student_divisor = $_POST['student_divisor'];
    $student_reason = $_POST['student_reason'];
    $supervisor_divisor = $_POST['supervisor_divisor'];
    $supervisor_reason = $_POST['supervisor_reason'];

    // Insert Student Evaluations
    $stmt = $conn->prepare("INSERT INTO kra1_a_student_evaluation 
        (request_id, evaluation_period, first_semester_rating, second_semester_rating, evidence_link_first, evidence_link_second) 
        VALUES (?, ?, ?, ?, ?, ?)");

    foreach ($student_evaluations as $index => $period) {
        $stmt->execute([
            $request_id,
            htmlspecialchars($period),
            $student_ratings1[$index],
            $student_ratings2[$index],
            htmlspecialchars($student_evidence_links[$index]),
            htmlspecialchars($student_evidence_links[$index]) // Assuming same link for both semesters
        ]);
        $student_eval_id = $conn->lastInsertId();

        // Insert Metadata
        $metaStmt = $conn->prepare("INSERT INTO kra1_a_metadata 
            (student_evaluation_id, supervisor_evaluation_id, student_semesters_to_deduct, student_reason_for_reduction, supervisor_semesters_to_deduct, supervisor_reason_for_reduction, student_evidence_link, supervisor_evidence_link) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        // Placeholder for supervisor_evaluation_id, will update later
        $metaStmt->execute([
            $student_eval_id,
            0, // Temporary, update after supervisor eval insertion
            $student_divisor,
            htmlspecialchars($student_reason),
            $supervisor_divisor,
            htmlspecialchars($supervisor_reason),
            htmlspecialchars($student_evidence_links[$index]),
            htmlspecialchars($supervisor_evidence_links[$index])
        ]);
    }

    // Insert Supervisor Evaluations
    $stmt = $conn->prepare("INSERT INTO kra1_a_supervisor_evaluation 
        (request_id, evaluation_period, first_semester_rating, second_semester_rating, evidence_link_first, evidence_link_second) 
        VALUES (?, ?, ?, ?, ?, ?)");

    foreach ($supervisor_evaluations as $index => $period) {
        $stmt->execute([
            $request_id,
            htmlspecialchars($period),
            $supervisor_ratings1[$index],
            $supervisor_ratings2[$index],
            htmlspecialchars($supervisor_evidence_links[$index]),
            htmlspecialchars($supervisor_evidence_links[$index]) // Assuming same link for both semesters
        ]);
        $supervisor_eval_id = $conn->lastInsertId();

        // Update Metadata with supervisor_evaluation_id
        $updateMetaStmt = $conn->prepare("UPDATE kra1_a_metadata SET supervisor_evaluation_id = ? WHERE student_evaluation_id = ?");
        $updateMetaStmt->execute([
            $supervisor_eval_id,
            $student_eval_id // Assuming 1-to-1 correspondence
        ]);
    }

    // Commit transaction
    $conn->commit();

    echo json_encode(['status' => 'success', 'message' => 'Criterion A saved successfully.']);
} catch (Exception $e) {
    $conn->rollBack();
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
