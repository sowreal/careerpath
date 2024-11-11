<?php
// process_reset_password.php
session_start();
require 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['reset_email']) || !isset($_SESSION['reset_token'])) {
        echo "Session expired. Please try the reset process again.";
        exit();
    }

    $email = $_SESSION['reset_email'];
    $token = $_SESSION['reset_token'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate passwords
    if ($password !== $confirmPassword) {
        echo "Passwords do not match.";
        exit();
    }

    // Validate password strength (optional but recommended)
    if (strlen($password) < 8) {
        echo "Password must be at least 8 characters long.";
        exit();
    }

    // Hash the new password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Update password in users table
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->execute([$hashedPassword, $email]);

    // Delete the reset token
    $stmt = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
    $stmt->execute([$email]);

    // Destroy the session variables
    unset($_SESSION['reset_email']);
    unset($_SESSION['reset_token']);

    echo "Your password has been reset successfully. You will be redirected to the login page.";
} else {
    echo "Invalid request.";
}
?>
