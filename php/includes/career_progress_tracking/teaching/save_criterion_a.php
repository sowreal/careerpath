<?php
// Ensure no extra output
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 0);

header('Content-Type: application/json');
require_once '../../../session.php';
require_once '../../../connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
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
$student_overall_rating = isset($data['student_overall_rating']) ? floatval($data['student_overall_rating']) : 0;
$student_faculty_rating = isset($data['student_faculty_rating']) ? floatval($data['student_faculty_rating']) : 0;
$supervisor_overall_rating = isset($data['supervisor_overall_rating']) ? floatval($data['supervisor_overall_rating']) : 0;
$supervisor_faculty_rating = isset($data['supervisor_faculty_rating']) ? floatval($data['supervisor_faculty_rating']) : 0;

// Extract deletions
$deleted_evaluations = isset($data['deleted_evaluations']) && is_array($data['deleted_evaluations']) ? $data['deleted_evaluations'] : [
    'student' => [],
    'supervisor' => []
];

try {
    $conn->beginTransaction();

    // === Handle Deletions ===
    foreach ($deleted_evaluations as $table => $ids) {
        if ($table === 'student') {
            $stmt = $conn->prepare("DELETE FROM kra1_a_student_evaluation WHERE evaluation_id = :evaluation_id AND request_id = :request_id");
        } elseif ($table === 'supervisor') {
            $stmt = $conn->prepare("DELETE FROM kra1_a_supervisor_evaluation WHERE evaluation_id = :evaluation_id AND request_id = :request_id");
        } else {
            continue; // Skip invalid tables
        }

        foreach ($ids as $eval_id) {
            $stmt->execute([
                ':evaluation_id' => intval($eval_id),
                ':request_id' => $request_id
            ]);
        }
    }

    // === Update or Insert Metadata ===
    // Check if metadata row exists
    $meta_check = $conn->prepare("SELECT metadata_id, student_divisor, student_reason, supervisor_divisor, supervisor_reason FROM kra1_a_metadata WHERE request_id = :request_id");
    $meta_check->execute([':request_id' => $request_id]);
    $metadata = $meta_check->fetch(PDO::FETCH_ASSOC);

    if ($metadata) {
        // Update existing metadata
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
        // Insert new metadata row
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

    // === Upsert Student Evaluations ===
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

    // === Upsert Supervisor Evaluations ===
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

    // === Recalculate and Update Metadata ===
    // Fetch divisor and reason from metadata
    $student_divisor = isset($data['student_divisor']) ? intval($data['student_divisor']) : 0;
    $student_reason = isset($data['student_reason']) ? strtolower(trim($data['student_reason'])) : '';
    $supervisor_divisor = isset($data['supervisor_divisor']) ? intval($data['supervisor_divisor']) : 0;
    $supervisor_reason = isset($data['supervisor_reason']) ? strtolower(trim($data['supervisor_reason'])) : '';

    // Fetch updated student evaluations
    $stmt = $conn->prepare("SELECT first_semester_rating, second_semester_rating FROM kra1_a_student_evaluation WHERE request_id = :request_id");
    $stmt->execute([':request_id' => $request_id]);
    $student_evals = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculate student ratings
    $student_total = 0;
    $student_count = 0;
    foreach ($student_evals as $eval) {
        $student_total += floatval($eval['first_semester_rating']);
        $student_count++;
        $student_total += floatval($eval['second_semester_rating']);
        $student_count++;
    }

    // Calculate Overall Average Rating based on divisor and reason
    if ($student_reason === '' || $student_reason === 'not_applicable' || $student_divisor === 0) {
        $student_overall_rating = ($student_count > 0) ? ($student_total / $student_count) : 0;
    } else {
        $denominator = 8 - $student_divisor;
        $student_overall_rating = ($denominator > 0) ? ($student_total / $denominator) : 0;
    }

    $student_faculty_rating = $student_overall_rating * 0.36;

    // Fetch updated supervisor evaluations
    $stmt = $conn->prepare("SELECT first_semester_rating, second_semester_rating FROM kra1_a_supervisor_evaluation WHERE request_id = :request_id");
    $stmt->execute([':request_id' => $request_id]);
    $supervisor_evals = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculate supervisor ratings
    $supervisor_total = 0;
    $supervisor_count = 0;
    foreach ($supervisor_evals as $eval) {
        $supervisor_total += floatval($eval['first_semester_rating']);
        $supervisor_count++;
        $supervisor_total += floatval($eval['second_semester_rating']);
        $supervisor_count++;
    }

    // Calculate Overall Average Rating based on divisor and reason
    if ($supervisor_reason === '' || $supervisor_reason === 'not_applicable' || $supervisor_divisor === 0) {
        $supervisor_overall_rating = ($supervisor_count > 0) ? ($supervisor_total / $supervisor_count) : 0;
    } else {
        $denominator = 8 - $supervisor_divisor;
        $supervisor_overall_rating = ($denominator > 0) ? ($supervisor_total / $denominator) : 0;
    }

    $supervisor_faculty_rating = $supervisor_overall_rating * 0.24;

    // Update metadata with recalculated ratings
    if ($metadata) {
        $stmt = $conn->prepare("UPDATE kra1_a_metadata SET 
            student_overall_rating = :student_overall_rating,
            student_faculty_rating = :student_faculty_rating,
            supervisor_overall_rating = :supervisor_overall_rating,
            supervisor_faculty_rating = :supervisor_faculty_rating
            WHERE metadata_id = :metadata_id");
        $stmt->execute([
            ':student_overall_rating' => $student_overall_rating,
            ':student_faculty_rating' => $student_faculty_rating,
            ':supervisor_overall_rating' => $supervisor_overall_rating,
            ':supervisor_faculty_rating' => $supervisor_faculty_rating,
            ':metadata_id' => $metadata['metadata_id']
        ]);
    }

    $conn->commit();
    echo json_encode(['success'=>true, 'message'=>'Criterion A saved successfully']);
} catch (Exception $e) {
    $conn->rollBack();
    echo json_encode(['success'=>false,'error'=>'Failed to save data: '.$e->getMessage()]);
}
?>
