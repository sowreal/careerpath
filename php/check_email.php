<?php
require 'connection.php';  // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Check if email exists in the database
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        // Email exists, return JSON indicating it
        echo json_encode(['exists' => true]);
    } else {
        // Email does not exist, return JSON indicating it
        echo json_encode(['exists' => false]);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
