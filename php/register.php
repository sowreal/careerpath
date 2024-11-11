<?php
session_start();
require 'connection.php';  // Include the DB connection
require 'send-verification.php';  // Ensure send-verification.php is included before calling the function

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Step 1: Collect and sanitize the form data
    if (empty($_POST['first_name']) || empty($_POST['email']) || empty($_POST['password'])) {
        echo "Required form data is missing!";
        exit();
    }

    $_SESSION['first_name'] = htmlspecialchars($_POST['first_name']);
    $_SESSION['middle_name'] = htmlspecialchars($_POST['middle_name']);
    $_SESSION['last_name'] = htmlspecialchars($_POST['last_name']);
    $_SESSION['employee_id'] = htmlspecialchars($_POST['employee_id']);
    $_SESSION['role'] = htmlspecialchars($_POST['role']);
    $_SESSION['department'] = htmlspecialchars($_POST['department']);
    $_SESSION['email'] = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Step 2: Validate the data
    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
        exit();
    }

    // Check if the email already exists
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$_SESSION['email']]);
    if ($stmt->rowCount() > 0) {
        echo "Email already registered!";
        exit();
    }

    // Step 3: Hash the password and store it in session temporarily
    $_SESSION['password'] = password_hash($password, PASSWORD_DEFAULT);

    // Step 4: Create a unique verification code and store it in the session
    $_SESSION['verification_code'] = generateVerificationCode(6);  // Generate verification code using function

    // Step 5: Send verification email
    if (sendVerificationEmail($_SESSION['email'], $_SESSION['first_name'], $_SESSION['last_name'], $_SESSION['verification_code'])) {
        // Set email_sent flag in session
        $_SESSION['email_sent'] = true;
        // Respond with success message
        echo 'Verification email sent';
    } else {
        echo 'Failed to send verification email. Please try again later.';
    }
} else {
    echo "Form not submitted!";
}
