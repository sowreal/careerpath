<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
header('Content-Type: application/json; charset=utf-8');

include('../../../connection.php'); // Adjust the path as necessary

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit();
}

// Get the POSTed data
$data = json_decode(file_get_contents('php://input'), true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'error' => 'Invalid JSON input']);
    exit();
}

// Log data received
file_put_contents('debug_data.log', print_r($data, true));

// Extract data
$user_id = $_SESSION['user_id'];
$request_id = isset($data['request_id']) ? $data['request_id'] : null;

// Validate required fields
if (!$request_id) {
    echo json_encode(['success' => false, 'error' => 'Invalid request. Request ID is missing.']);
    exit();
}

// Now, process the data
$student_evaluation_periods = isset($data['evaluation_period']) ? $data['evaluation_period'] : [];
$student_rating_1 = isset($data['student_rating_1']) ? $data['student_rating_1'] : [];
$student_rating_2 = isset($data['student_rating_2']) ? $data['student_rating_2'] : [];
$student_evidence_link = isset($data['student_evidence_link']) ? $data['student_evidence_link'] : [];
$student_remarks = isset($data['student_remarks']) ? $data['student_remarks'] : [];

$supervisor_evaluation_periods = isset($data['supervisor_evaluation_period']) ? $data['supervisor_evaluation_period'] : [];
$supervisor_rating_1 = isset($data['supervisor_rating_1']) ? $data['supervisor_rating_1'] : [];
$supervisor_rating_2 = isset($data['supervisor_rating_2']) ? $data['supervisor_rating_2'] : [];
$supervisor_evidence_link = isset($data['supervisor_evidence_link']) ? $data['supervisor_evidence_link'] : [];

// Begin transaction
$conn->beginTransaction();

try {
    // First, delete any existing data for this user and request_id in the tables
    // Delete student evaluations
    $stmt = $conn->prepare("DELETE FROM kra1_a_student_evaluation WHERE user_id = :user_id AND request_id = :request_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':request_id', $request_id, PDO::PARAM_INT);
    $stmt->execute();

    // Delete supervisor evaluations
    $stmt = $conn->prepare("DELETE FROM kra1_a_supervisor_evaluation WHERE user_id = :user_id AND request_id = :request_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':request_id', $request_id, PDO::PARAM_INT);
    $stmt->execute();

    // Insert student evaluations
    $stmt = $conn->prepare("
        INSERT INTO kra1_a_student_evaluation (
            user_id, request_id, evaluation_period,
            first_semester_rating, second_semester_rating,
            evidence_link_first_semester, evidence_link_second_semester,
            remarks_first_semester, remarks_second_semester,
            overall_average_rating, faculty_score
        ) VALUES (
            :user_id, :request_id, :evaluation_period,
            :first_semester_rating, :second_semester_rating,
            :evidence_link_first, :evidence_link_second,
            :remarks_first, :remarks_second,
            :overall_average_rating, :faculty_score
        )
    ");


    if (is_array($student_evaluation_periods)) {
        for ($i = 0; $i < count($student_evaluation_periods); $i++) {
            $evaluation_period = $student_evaluation_periods[$i];
            $rating1 = $student_rating_1[$i];
            $rating2 = $student_rating_2[$i];
            $evidence_link1 = $student_evidence_link[$i]; // Assuming same link can be used for both semesters
            $evidence_link2 = $student_evidence_link[$i];
            $remarks1 = isset($student_remarks[$i]) ? $student_remarks[$i] : '';
            $remarks2 = isset($student_remarks[$i]) ? $student_remarks[$i] : '';
        
            // Calculate overall_average_rating and faculty_score
            $overall_average_rating = ($rating1 + $rating2) / 2;
            $faculty_score = $overall_average_rating * 0.36;
        
            // Bind parameters
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':request_id', $request_id, PDO::PARAM_INT);
            $stmt->bindParam(':evaluation_period', $evaluation_period, PDO::PARAM_STR);
            $stmt->bindParam(':first_semester_rating', $rating1);
            $stmt->bindParam(':second_semester_rating', $rating2);
            $stmt->bindParam(':evidence_link_first', $evidence_link1, PDO::PARAM_STR);
            $stmt->bindParam(':evidence_link_second', $evidence_link2, PDO::PARAM_STR);
            $stmt->bindParam(':remarks_first', $remarks1, PDO::PARAM_STR);
            $stmt->bindParam(':remarks_second', $remarks2, PDO::PARAM_STR);
            $stmt->bindParam(':overall_average_rating', $overall_average_rating);
            $stmt->bindParam(':faculty_score', $faculty_score);
        
            $stmt->execute();
        }
        
    }

    // Insert supervisor evaluations
    $stmt = $conn->prepare("
        INSERT INTO kra1_a_supervisor_evaluation (
            user_id, request_id, evaluation_period,
            first_semester_rating, second_semester_rating,
            evidence_link_first_semester, evidence_link_second_semester,
            remarks_first_semester, remarks_second_semester,
            overall_average_rating, faculty_score
        ) VALUES (
            :user_id, :request_id, :evaluation_period,
            :first_semester_rating, :second_semester_rating,
            :evidence_link_first, :evidence_link_second,
            :remarks_first, :remarks_second,
            :overall_average_rating, :faculty_score
        )
    ");


    if (is_array($supervisor_evaluation_periods)) {
        for ($i = 0; $i < count($supervisor_evaluation_periods); $i++) {
            $evaluation_period = $supervisor_evaluation_periods[$i];
            $rating1 = $supervisor_rating_1[$i];
            $rating2 = $supervisor_rating_2[$i];
            $evidence_link1 = $supervisor_evidence_link[$i];
            $evidence_link2 = $supervisor_evidence_link[$i];
            $remarks1 = isset($supervisor_remarks[$i]) ? $supervisor_remarks[$i] : '';
            $remarks2 = isset($supervisor_remarks[$i]) ? $supervisor_remarks[$i] : '';

            // Calculate overall_average_rating and faculty_score as needed
            $overall_average_rating = ($rating1 + $rating2) / 2;
            $faculty_score = $overall_average_rating * 0.36; // As per your calculation

            // Bind parameters
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':request_id', $request_id, PDO::PARAM_INT);
            $stmt->bindParam(':evaluation_period', $evaluation_period, PDO::PARAM_STR);
            $stmt->bindParam(':first_semester_rating', $rating1);
            $stmt->bindParam(':second_semester_rating', $rating2);
            $stmt->bindParam(':evidence_link_first', $evidence_link1, PDO::PARAM_STR);
            $stmt->bindParam(':evidence_link_second', $evidence_link2, PDO::PARAM_STR);
            $stmt->bindParam(':remarks_first', $remarks1, PDO::PARAM_STR);
            $stmt->bindParam(':remarks_second', $remarks2, PDO::PARAM_STR);
            $stmt->bindParam(':overall_average_rating', $overall_average_rating);
            $stmt->bindParam(':faculty_score', $faculty_score);

            $stmt->execute();
        }
    }

    // Commit transaction
    $conn->commit();

    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    // Rollback transaction
    $conn->rollBack();
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}
?>
