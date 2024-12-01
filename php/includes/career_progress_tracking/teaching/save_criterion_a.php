<?php
include_once '../../../session.php';
header('Content-Type: application/json');
include_once '../../../connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

$request_id = isset($data['request_id']) ? intval($data['request_id']) : 0;

// Validate request_id
if ($request_id <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid Request ID']);
    exit();
}

try {
    $conn->beginTransaction();

    // Upsert kra1_a_metadata
    $stmt = $conn->prepare("SELECT metadata_id FROM kra1_a_metadata WHERE request_id = :request_id");
    $stmt->execute([':request_id' => $request_id]);
    $metadata = $stmt->fetch();

    if ($metadata) {
        $metadata_id = $metadata['metadata_id'];
        $update_meta = $conn->prepare("UPDATE kra1_a_metadata SET 
            student_divisor = :student_divisor, 
            student_reason = :student_reason, 
            student_evidence_link = :student_evidence_link,
            supervisor_divisor = :supervisor_divisor, 
            supervisor_reason = :supervisor_reason, 
            supervisor_evidence_link = :supervisor_evidence_link 
            WHERE metadata_id = :metadata_id");
        $update_meta->execute([
            ':student_divisor' => $data['student_divisor'],
            ':student_reason' => $data['student_reason'],
            ':student_evidence_link' => $data['student_evidence_link'],
            ':supervisor_divisor' => $data['supervisor_divisor'],
            ':supervisor_reason' => $data['supervisor_reason'],
            ':supervisor_evidence_link' => $data['supervisor_evidence_link'],
            ':metadata_id' => $metadata_id
        ]);
    } else {
        $insert_meta = $conn->prepare("INSERT INTO kra1_a_metadata 
            (request_id, student_divisor, student_reason, student_evidence_link, 
             supervisor_divisor, supervisor_reason, supervisor_evidence_link) 
             VALUES 
            (:request_id, :student_divisor, :student_reason, :student_evidence_link, 
             :supervisor_divisor, :supervisor_reason, :supervisor_evidence_link)");
        $insert_meta->execute([
            ':request_id' => $request_id,
            ':student_divisor' => $data['student_divisor'],
            ':student_reason' => $data['student_reason'],
            ':student_evidence_link' => $data['student_evidence_link'],
            ':supervisor_divisor' => $data['supervisor_divisor'],
            ':supervisor_reason' => $data['supervisor_reason'],
            ':supervisor_evidence_link' => $data['supervisor_evidence_link']
        ]);
    }

    // Handle Student Evaluations
    foreach ($data['student_evaluations'] as $eval) {
        if (isset($eval['evaluation_id']) && $eval['evaluation_id'] > 0) {
            $update_student = $conn->prepare("UPDATE kra1_a_student_evaluation SET 
                evaluation_period = :evaluation_period,
                first_semester_rating = :first_semester_rating,
                second_semester_rating = :second_semester_rating,
                evidence_link_first = :evidence_link_first,
                evidence_link_second = :evidence_link_second,
                remarks_first = :remarks_first,
                remarks_second = :remarks_second,
                overall_average_rating = :overall_average_rating,
                faculty_rating = :faculty_rating
                WHERE evaluation_id = :evaluation_id");
            $update_student->execute([
                ':evaluation_period' => $eval['evaluation_period'],
                ':first_semester_rating' => $eval['first_semester_rating'],
                ':second_semester_rating' => $eval['second_semester_rating'],
                ':evidence_link_first' => $eval['evidence_link_first'],
                ':evidence_link_second' => $eval['evidence_link_second'],
                ':remarks_first' => $eval['remarks_first'],
                ':remarks_second' => $eval['remarks_second'],
                ':overall_average_rating' => $eval['overall_average_rating'],
                ':faculty_rating' => $eval['faculty_rating'],
                ':evaluation_id' => $eval['evaluation_id']
            ]);
        } else {
            $insert_student = $conn->prepare("INSERT INTO kra1_a_student_evaluation 
                (request_id, evaluation_period, first_semester_rating, second_semester_rating, 
                 evidence_link_first, evidence_link_second, remarks_first, remarks_second, 
                 overall_average_rating, faculty_rating) 
                 VALUES 
                (:request_id, :evaluation_period, :first_semester_rating, :second_semester_rating, 
                 :evidence_link_first, :evidence_link_second, :remarks_first, :remarks_second, 
                 :overall_average_rating, :faculty_rating)");
            $insert_student->execute([
                ':request_id' => $request_id,
                ':evaluation_period' => $eval['evaluation_period'],
                ':first_semester_rating' => $eval['first_semester_rating'],
                ':second_semester_rating' => $eval['second_semester_rating'],
                ':evidence_link_first' => $eval['evidence_link_first'],
                ':evidence_link_second' => $eval['evidence_link_second'],
                ':remarks_first' => $eval['remarks_first'],
                ':remarks_second' => $eval['remarks_second'],
                ':overall_average_rating' => $eval['overall_average_rating'],
                ':faculty_rating' => $eval['faculty_rating']
            ]);
        }
    }

    // Handle Supervisor Evaluations
    foreach ($data['supervisor_evaluations'] as $eval) {
        if (isset($eval['evaluation_id']) && $eval['evaluation_id'] > 0) {
            $update_supervisor = $conn->prepare("UPDATE kra1_a_supervisor_evaluation SET 
                evaluation_period = :evaluation_period,
                first_semester_rating = :first_semester_rating,
                second_semester_rating = :second_semester_rating,
                evidence_link_first = :evidence_link_first,
                evidence_link_second = :evidence_link_second,
                remarks_first = :remarks_first,
                remarks_second = :remarks_second,
                overall_average_rating = :overall_average_rating,
                faculty_rating = :faculty_rating
                WHERE evaluation_id = :evaluation_id");
            $update_supervisor->execute([
                ':evaluation_period' => $eval['evaluation_period'],
                ':first_semester_rating' => $eval['first_semester_rating'],
                ':second_semester_rating' => $eval['second_semester_rating'],
                ':evidence_link_first' => $eval['evidence_link_first'],
                ':evidence_link_second' => $eval['evidence_link_second'],
                ':remarks_first' => $eval['remarks_first'],
                ':remarks_second' => $eval['remarks_second'],
                ':overall_average_rating' => $eval['overall_average_rating'],
                ':faculty_rating' => $eval['faculty_rating'],
                ':evaluation_id' => $eval['evaluation_id']
            ]);
        } else {
            $insert_supervisor = $conn->prepare("INSERT INTO kra1_a_supervisor_evaluation 
                (request_id, evaluation_period, first_semester_rating, second_semester_rating, 
                 evidence_link_first, evidence_link_second, remarks_first, remarks_second, 
                 overall_average_rating, faculty_rating) 
                 VALUES 
                (:request_id, :evaluation_period, :first_semester_rating, :second_semester_rating, 
                 :evidence_link_first, :evidence_link_second, :remarks_first, :remarks_second, 
                 :overall_average_rating, :faculty_rating)");
            $insert_supervisor->execute([
                ':request_id' => $request_id,
                ':evaluation_period' => $eval['evaluation_period'],
                ':first_semester_rating' => $eval['first_semester_rating'],
                ':second_semester_rating' => $eval['second_semester_rating'],
                ':evidence_link_first' => $eval['evidence_link_first'],
                ':evidence_link_second' => $eval['evidence_link_second'],
                ':remarks_first' => $eval['remarks_first'],
                ':remarks_second' => $eval['remarks_second'],
                ':overall_average_rating' => $eval['overall_average_rating'],
                ':faculty_rating' => $eval['faculty_rating']
            ]);
        }
    }

    $conn->commit();
    echo json_encode(['success' => 'Criterion A saved successfully']);
} catch (Exception $e) {
    $conn->rollBack();
    http_response_code(500);
    echo json_encode(['error' => 'Failed to save data: ' . $e->getMessage()]);
}
?>
