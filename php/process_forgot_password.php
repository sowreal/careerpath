<?php
// process_forgot_password.php
session_start();
require 'connection.php';  // Include your database connection
require 'send_email.php';  // Include your email sending function

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address!";
        exit();
    }

    // Generate a generic response message
    // Note: Adjust this message based on your security preference
    // $responseMessage = "If an account with that email exists, a password reset link has been sent.";

    // Check if the email exists in the users table
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $currentTime = time();
        $requestLimitSeconds = 30; // 30 seconds

        // Check for existing password reset requests
        $stmt = $conn->prepare("SELECT * FROM password_resets WHERE email = ?");
        $stmt->execute([$email]);
        $existingRequest = $stmt->fetch();

        if ($existingRequest) {
            $timeSinceLastRequest = $currentTime - $existingRequest['request_time'];

            if ($timeSinceLastRequest < $requestLimitSeconds) {
                // Log the event for monitoring
                error_log("Password reset requested too soon for email: $email");
            
                // Respond with the generic message
                echo "A password reset link has been sent to your email address. Please check your inbox. 
                If you do not receive the email within a few minutes, you can resend the link.";
                exit();
            }
             else {
                // Delete the old request if it's expired
                $stmt = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
                $stmt->execute([$email]);
            }
        }

        // Generate a secure token
        $token = bin2hex(random_bytes(32));
        $expires = $currentTime + 3600;  // Token expires in 1 hour

        // Store the token in the database
        $stmt = $conn->prepare("INSERT INTO password_resets (email, token, expires, request_time) VALUES (?, ?, ?, ?)");
        $stmt->execute([$email, $token, $expires, $currentTime]);

        // Send reset email
        $resetLink = "http://localhost/careerpath/php/reset_password.php?token=$token";
        $subject = "Password Reset Request";
        $message = "Hello,

                    We received a request to reset your password. Click the link below to reset your password:

                    $resetLink

                    If you did not request a password reset, please ignore this email.

                    Thank you.";

        // Use your sendEmail function
        sendEmail($email, $subject, $message);

        // Inform the user that the reset link has been sent
        echo "A password reset link has been sent to your email address. Please check your inbox.
        If you do not receive the email within a few minutes, you can resend the link.";
    } else {
        // Respond with the same message to prevent email enumeration
        echo "A password reset link has been sent to your email address. Please check your inbox. 
        If you do not receive the email within a few minutes, you can resend the link.";
    }
} else {
    echo "Invalid request.";
}
?>
