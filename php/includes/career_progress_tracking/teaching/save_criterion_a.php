<?php
// Ensure no extra output
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 0);

header('Content-Type: application/json');
require_once '../../../session.php';
require_once '../../../connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success'=>false,'error'=>'Unauthorized']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

// Validate request_id
$request_id = isset($data['request_id']) ? intval($data['request_id']) : 0;
if ($request_id <= 0) {
    echo json_encode(['success'=>false,'error'=>'Please select an evaluation ID']);
    exit();
}

// Ensure arrays exist to avoid PHP notices
$student_evaluations = isset($data['student_evaluations']) && is_array($data['student_evaluations']) ? $data['student_evaluations'] : [];
$supervisor_evaluations = isset($data['supervisor_evaluations']) && is_array($data['supervisor_evaluations']) ? $data['supervisor_evaluations'] : [];

// Extract new overall/faculty ratings from metadata fields
$student_overall_rating = isset($data['student_overall_rating']) ? $data['student_overall_rating'] : null;
$student_faculty_rating = isset($data['student_faculty_rating']) ? $data['student_faculty_rating'] : null;
$supervisor_overall_rating = isset($data['supervisor_overall_rating']) ? $data['supervisor_overall_rating'] : null;
$supervisor_faculty_rating = isset($data['supervisor_faculty_rating']) ? $data['supervisor_faculty_rating'] : null;

try {
    $conn->beginTransaction();

    // Check if metadata row exists
    $meta_check = $conn->prepare("SELECT metadata_id FROM kra1_a_metadata WHERE request_id = :request_id");
    $meta_check->execute([':request_id' => $request_id]);
    $metadata = $meta_check->fetch();

    if ($metadata) {
        // Update metadata including new rating fields
        $update_meta = $conn->prepare("UPDATE kra1_a_metadata SET 
            student_divisor = :student_divisor, 
            student_reason = :student_reason, 
            student_evidence_link = :student_evidence_link,
            supervisor_divisor = :supervisor_divisor, 
            supervisor_reason = :supervisor_reason, 
            supervisor_evidence_link = :supervisor_evidence_link,
            student_overall_rating = :student_overall_rating,
            student_faculty_rating = :student_faculty_rating,
            supervisor_overall_rating = :supervisor_overall_rating,
            supervisor_faculty_rating = :supervisor_faculty_rating
            WHERE metadata_id = :metadata_id");
        $update_meta->execute([
            ':student_divisor' => $data['student_divisor'],
            ':student_reason' => $data['student_reason'],
            ':student_evidence_link' => $data['student_evidence_link'],
            ':supervisor_divisor' => $data['supervisor_divisor'],
            ':supervisor_reason' => $data['supervisor_reason'],
            ':supervisor_evidence_link' => $data['supervisor_evidence_link'],
            ':student_overall_rating' => $student_overall_rating,
            ':student_faculty_rating' => $student_faculty_rating,
            ':supervisor_overall_rating' => $supervisor_overall_rating,
            ':supervisor_faculty_rating' => $supervisor_faculty_rating,
            ':metadata_id' => $metadata['metadata_id']
        ]);
    } else {
        // Insert new metadata row with the new rating fields
        $insert_meta = $conn->prepare("INSERT INTO kra1_a_metadata 
            (request_id, student_divisor, student_reason, student_evidence_link, 
             supervisor_divisor, supervisor_reason, supervisor_evidence_link,
             student_overall_rating, student_faculty_rating, supervisor_overall_rating, supervisor_faculty_rating) 
            VALUES 
            (:request_id, :student_divisor, :student_reason, :student_evidence_link, 
             :supervisor_divisor, :supervisor_reason, :supervisor_evidence_link,
             :student_overall_rating, :student_faculty_rating, :supervisor_overall_rating, :supervisor_faculty_rating)");
        $insert_meta->execute([
            ':request_id' => $request_id,
            ':student_divisor' => $data['student_divisor'],
            ':student_reason' => $data['student_reason'],
            ':student_evidence_link' => $data['student_evidence_link'],
            ':supervisor_divisor' => $data['supervisor_divisor'],
            ':supervisor_reason' => $data['supervisor_reason'],
            ':supervisor_evidence_link' => $data['supervisor_evidence_link'],
            ':student_overall_rating' => $student_overall_rating,
            ':student_faculty_rating' => $student_faculty_rating,
            ':supervisor_overall_rating' => $supervisor_overall_rating,
            ':supervisor_faculty_rating' => $supervisor_faculty_rating
        ]);
    }

    // Upsert Student Evaluations
    // Remove references to overall_average_rating and faculty_rating since these no longer exist in kra1_a_student_evaluation
    foreach ($student_evaluations as $eval) {
        if (!isset($eval['evaluation_period'])) {
            continue; // Skip invalid rows
        }
        if (isset($eval['evaluation_id']) && $eval['evaluation_id'] > 0) {
            $update_student = $conn->prepare("UPDATE kra1_a_student_evaluation SET 
                evaluation_period = :evaluation_period,
                first_semester_rating = :first_semester_rating,
                second_semester_rating = :second_semester_rating,
                evidence_link_first = :evidence_link_first,
                evidence_link_second = :evidence_link_second,
                remarks_first = :remarks_first,
                remarks_second = :remarks_second
                WHERE evaluation_id = :evaluation_id AND request_id = :request_id");
            $update_student->execute([
                ':evaluation_period' => $eval['evaluation_period'],
                ':first_semester_rating' => $eval['first_semester_rating'],
                ':second_semester_rating' => $eval['second_semester_rating'],
                ':evidence_link_first' => $eval['evidence_link_first'],
                ':evidence_link_second' => $eval['evidence_link_second'],
                ':remarks_first' => $eval['remarks_first'],
                ':remarks_second' => $eval['remarks_second'],
                ':evaluation_id' => $eval['evaluation_id'],
                ':request_id' => $request_id
            ]);
        } else {
            $insert_student = $conn->prepare("INSERT INTO kra1_a_student_evaluation 
                (request_id, evaluation_period, first_semester_rating, second_semester_rating, 
                 evidence_link_first, evidence_link_second, remarks_first, remarks_second) 
                VALUES 
                (:request_id, :evaluation_period, :first_semester_rating, :second_semester_rating, 
                 :evidence_link_first, :evidence_link_second, :remarks_first, :remarks_second)");
            $insert_student->execute([
                ':request_id' => $request_id,
                ':evaluation_period' => $eval['evaluation_period'],
                ':first_semester_rating' => $eval['first_semester_rating'],
                ':second_semester_rating' => $eval['second_semester_rating'],
                ':evidence_link_first' => $eval['evidence_link_first'],
                ':evidence_link_second' => $eval['evidence_link_second'],
                ':remarks_first' => $eval['remarks_first'],
                ':remarks_second' => $eval['remarks_second']
            ]);
        }
    }

    // Upsert Supervisor Evaluations
    // Remove references to overall_average_rating and faculty_rating since these no longer exist in kra1_a_supervisor_evaluation
    foreach ($supervisor_evaluations as $eval) {
        if (!isset($eval['evaluation_period'])) {
            continue; // Skip invalid rows
        }
        if (isset($eval['evaluation_id']) && $eval['evaluation_id'] > 0) {
            $update_supervisor = $conn->prepare("UPDATE kra1_a_supervisor_evaluation SET 
                evaluation_period = :evaluation_period,
                first_semester_rating = :first_semester_rating,
                second_semester_rating = :second_semester_rating,
                evidence_link_first = :evidence_link_first,
                evidence_link_second = :evidence_link_second,
                remarks_first = :remarks_first,
                remarks_second = :remarks_second
                WHERE evaluation_id = :evaluation_id AND request_id = :request_id");
            $update_supervisor->execute([
                ':evaluation_period' => $eval['evaluation_period'],
                ':first_semester_rating' => $eval['first_semester_rating'],
                ':second_semester_rating' => $eval['second_semester_rating'],
                ':evidence_link_first' => $eval['evidence_link_first'],
                ':evidence_link_second' => $eval['evidence_link_second'],
                ':remarks_first' => $eval['remarks_first'],
                ':remarks_second' => $eval['remarks_second'],
                ':evaluation_id' => $eval['evaluation_id'],
                ':request_id' => $request_id
            ]);
        } else {
            $insert_supervisor = $conn->prepare("INSERT INTO kra1_a_supervisor_evaluation 
                (request_id, evaluation_period, first_semester_rating, second_semester_rating, 
                 evidence_link_first, evidence_link_second, remarks_first, remarks_second) 
                VALUES 
                (:request_id, :evaluation_period, :first_semester_rating, :second_semester_rating, 
                 :evidence_link_first, :evidence_link_second, :remarks_first, :remarks_second)");
            $insert_supervisor->execute([
                ':request_id' => $request_id,
                ':evaluation_period' => $eval['evaluation_period'],
                ':first_semester_rating' => $eval['first_semester_rating'],
                ':second_semester_rating' => $eval['second_semester_rating'],
                ':evidence_link_first' => $eval['evidence_link_first'],
                ':evidence_link_second' => $eval['evidence_link_second'],
                ':remarks_first' => $eval['remarks_first'],
                ':remarks_second' => $eval['remarks_second']
            ]);
        }
    }

    $conn->commit();
    echo json_encode(['success'=>true, 'message'=>'Criterion A saved successfully']);
} catch (Exception $e) {
    $conn->rollBack();
    echo json_encode(['success'=>false,'error'=>'Failed to save data: '.$e->getMessage()]);
}
