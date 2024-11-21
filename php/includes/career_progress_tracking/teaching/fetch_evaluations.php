<?php
session_start();
include('../../../connection.php'); // Include your database connection using PDO

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    // Prepare the SQL statement using PDO
    $sql = "SELECT request_id, created_at FROM request_form WHERE user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    $evaluations = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $request_id = $row['request_id'];
        $created_at = $row['created_at'];

        // Generate evaluation number as per your format: concatenate 'created_at', 'user_id' and 'request_id'
        $evaluation_number = $created_at . '_' . $user_id . '_' . $request_id;

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
