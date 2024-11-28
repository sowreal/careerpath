<?php
// save_criterion_a.php

/**
 * Handles AJAX submission from criterion_a.php.
 * Saves user inputs into the database tables:
 * - kra1_a_student_evaluation
 * - kra1_a_supervisor_evaluation
 * - kra1_a_metadata
 * Uses PDO for database interactions with proper error handling.
 */

// Start session if not already started
require_once '../../../session.php';
// Include database connection
require_once '../../../connection.php';

// Set header for JSON response
header('Content-Type: application/json');



try {
    // Get raw POST data
    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true);

    if (!$data) {
        throw new Exception('No data received.');
    }

    // Begin transaction to ensure data integrity
    $conn->beginTransaction();

    // Retrieve the request_id (ensure it's provided)
    $request_id = $_SESSION['request_id'] ?? $data['request_id'] ?? null;

    if (!$request_id) {
        throw new Exception('Request ID is missing.');
    }

    /**
     * Process and Insert Student Evaluations
     */
    // Prepare SQL statement for student evaluations
    $student_stmt = $conn->prepare("
        INSERT INTO kra1_a_student_evaluation (
            request_id,
            evaluation_period,
            first_semester_rating,
            second_semester_rating,
            evidence_link_first,
            evidence_link_second,
            overall_average_rating,
            faculty_rating
        ) VALUES (
            :request_id,
            :evaluation_period,
            :first_semester_rating,
            :second_semester_rating,
            :evidence_link_first,
            :evidence_link_second,
            :overall_average_rating,
            :faculty_rating
        )
    ");

    // Loop through student evaluation entries
    $student_evaluation_periods = $data['student_evaluation_period'] ?? [];
    foreach ($student_evaluation_periods as $index => $period) {
        // Validate and sanitize inputs
        $evaluation_period = htmlspecialchars($period);
        $first_semester_rating = isset($data['student_rating_1'][$index]) ? floatval($data['student_rating_1'][$index]) : null;
        $second_semester_rating = isset($data['student_rating_2'][$index]) ? floatval($data['student_rating_2'][$index]) : null;
        $evidence_link_first = isset($data['student_evidence_link'][$index]) ? filter_var($data['student_evidence_link'][$index], FILTER_SANITIZE_URL) : null;
        $evidence_link_second = null; // Adjust if you have separate links
        $overall_average_rating = isset($data['student_overall_average'][$index]) ? floatval($data['student_overall_average'][$index]) : null;
        $faculty_rating = isset($data['student_faculty_rating'][$index]) ? floatval($data['student_faculty_rating'][$index]) : null;

        // Execute the prepared statement
        $student_stmt->execute([
            ':request_id' => $request_id,
            ':evaluation_period' => $evaluation_period,
            ':first_semester_rating' => $first_semester_rating,
            ':second_semester_rating' => $second_semester_rating,
            ':evidence_link_first' => $evidence_link_first,
            ':evidence_link_second' => $evidence_link_second,
            ':overall_average_rating' => $overall_average_rating,
            ':faculty_rating' => $faculty_rating
        ]);
    }

    /**
     * Process and Insert Supervisor Evaluations
     */
    // Prepare SQL statement for supervisor evaluations
    $supervisor_stmt = $conn->prepare("
        INSERT INTO kra1_a_supervisor_evaluation (
            request_id,
            evaluation_period,
            first_semester_rating,
            second_semester_rating,
            evidence_link_first,
            evidence_link_second,
            overall_average_rating,
            faculty_rating
        ) VALUES (
            :request_id,
            :evaluation_period,
            :first_semester_rating,
            :second_semester_rating,
            :evidence_link_first,
            :evidence_link_second,
            :overall_average_rating,
            :faculty_rating
        )
    ");

    // Loop through supervisor evaluation entries
    $supervisor_evaluation_periods = $data['supervisor_evaluation_period'] ?? [];
    foreach ($supervisor_evaluation_periods as $index => $period) {
        // Validate and sanitize inputs
        $evaluation_period = htmlspecialchars($period);
        $first_semester_rating = isset($data['supervisor_rating_1'][$index]) ? floatval($data['supervisor_rating_1'][$index]) : null;
        $second_semester_rating = isset($data['supervisor_rating_2'][$index]) ? floatval($data['supervisor_rating_2'][$index]) : null;
        $evidence_link_first = isset($data['supervisor_evidence_link'][$index]) ? filter_var($data['supervisor_evidence_link'][$index], FILTER_SANITIZE_URL) : null;
        $evidence_link_second = null; // Adjust if you have separate links
        $overall_average_rating = isset($data['supervisor_overall_average'][$index]) ? floatval($data['supervisor_overall_average'][$index]) : null;
        $faculty_rating = isset($data['supervisor_faculty_rating'][$index]) ? floatval($data['supervisor_faculty_overall_score'][$index]) : null;

        // Execute the prepared statement
        $supervisor_stmt->execute([
            ':request_id' => $request_id,
            ':evaluation_period' => $evaluation_period,
            ':first_semester_rating' => $first_semester_rating,
            ':second_semester_rating' => $second_semester_rating,
            ':evidence_link_first' => $evidence_link_first,
            ':evidence_link_second' => $evidence_link_second,
            ':overall_average_rating' => $overall_average_rating,
            ':faculty_rating' => $faculty_rating
        ]);
    }

    // Get the last inserted evaluation_ids for metadata linkage
    $student_evaluation_id = $conn->lastInsertId(); // After student evaluations
    $supervisor_evaluation_id = $conn->lastInsertId(); // After supervisor evaluations

    /**
     * Process and Insert Metadata
     */
    // Prepare SQL statement for metadata
    $metadata_stmt = $conn->prepare("
        INSERT INTO kra1_a_metadata (
            student_evaluation_id,
            supervisor_evaluation_id,
            student_semesters_to_deduct,
            student_reason_for_reduction,
            supervisor_semesters_to_deduct,
            supervisor_reason_for_reduction,
            student_evidence_link,
            supervisor_evidence_link
        ) VALUES (
            :student_evaluation_id,
            :supervisor_evaluation_id,
            :student_semesters_to_deduct,
            :student_reason_for_reduction,
            :supervisor_semesters_to_deduct,
            :supervisor_reason_for_reduction,
            :student_evidence_link,
            :supervisor_evidence_link
        )
    ");

    // Sanitize and validate metadata inputs
    $student_semesters_to_deduct = intval($data['student_divisor'] ?? 0);
    $student_reason_for_reduction = htmlspecialchars($data['student_reason'] ?? '');
    $supervisor_semesters_to_deduct = intval($data['supervisor_divisor'] ?? 0);
    $supervisor_reason_for_reduction = htmlspecialchars($data['supervisor_reason'] ?? '');
    $student_evidence_link_main = filter_var($data['student_evidence_link_main'] ?? '', FILTER_SANITIZE_URL);
    $supervisor_evidence_link_main = filter_var($data['supervisor_evidence_link_main'] ?? '', FILTER_SANITIZE_URL);

    // Execute the prepared statement
    $metadata_stmt->execute([
        ':student_evaluation_id' => $student_evaluation_id,
        ':supervisor_evaluation_id' => $supervisor_evaluation_id,
        ':student_semesters_to_deduct' => $student_semesters_to_deduct,
        ':student_reason_for_reduction' => $student_reason_for_reduction,
        ':supervisor_semesters_to_deduct' => $supervisor_semesters_to_deduct,
        ':supervisor_reason_for_reduction' => $supervisor_reason_for_reduction,
        ':student_evidence_link' => $student_evidence_link_main,
        ':supervisor_evidence_link' => $supervisor_evidence_link_main
    ]);

    // Commit the transaction after all inserts
    $conn->commit();

    // Return success response
    echo json_encode(['success' => true]);
    exit();

} catch (Exception $e) {
    // Rollback the transaction on any error
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    // Log the error
    error_log("Error saving Criterion A data: " . $e->getMessage());
    // Return error response
    echo json_encode(['success' => false, 'error' => 'Failed to save data. Please try again.']);
    exit();
}
?>
