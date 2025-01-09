<?php
// php/includes/career_progress_tracking/research/fetch_kra2_evaluations.php
session_start();
include '../../../connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    $sql = "SELECT request_id, created_at FROM request_form WHERE user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    $evaluations = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $request_id = $row['request_id'];
        $created_at = $row['created_at'];

        // Format the evaluation number and date
        $formatted_date = date("F j, Y, g:i a", strtotime($created_at)); // Adjust date format as needed
        $evaluation_number = "Evaluation #: " . $request_id . " (Created: " . $formatted_date . ")";

        $evaluations[] = [
            'request_id' => $request_id,
            'created_at' => $created_at,
            'display' => $evaluation_number
        ];
    }

    echo json_encode($evaluations);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>