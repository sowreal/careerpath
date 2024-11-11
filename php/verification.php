<?php
session_start();  // Make sure session is started

require 'connection.php';  // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $verificationCode = $_POST['verification_code'];

    // Check if the session has a verification code
    if (isset($_SESSION['verification_code'])) {
        $storedCode = $_SESSION['verification_code'];

        // Compare the entered code with the stored session code
        if ($verificationCode === $storedCode) {
            echo "Verification successful";

            // Retrieve user data from session
            $firstName = $_SESSION['first_name'];
            $middleName = $_SESSION['middle_name'];  // If middle name is optional, ensure you set it correctly
            $lastName = $_SESSION['last_name'];
            $employeeID = $_SESSION['employee_id'];  // Make sure this is stored in the session during registration
            $role = $_SESSION['role'];  // Ensure this is collected and stored
            $department = $_SESSION['department'];  // Ensure this is collected and stored
            $email = $_SESSION['email'];
            $password = $_SESSION['password'];  // Assuming this is already hashed

            // Insert into database
            $query = "INSERT INTO users (first_name, middle_name, last_name, employee_id, role, department, email, password, is_verified, faculty_rank) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Not Yet Assigned')";
            $stmt = $conn->prepare($query);

            if ($stmt->execute([$firstName, $middleName, $lastName, $employeeID, $role, $department, $email, $password, 1])) {
                unset($_SESSION['verification_code']);  // Clear the verification code from the session
                echo "<script>window.location.href = 'php/success.php';</script>";
            } else {
                echo "Database error: Unable to store user information.";
            }
        } else {
            echo "Invalid verification code. Please try again.";
        }
    } else {
        echo "No verification code found. Please request a new verification code.";
    }
} else {
    echo "Invalid request method.";
}
?>
