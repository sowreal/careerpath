<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Include the database connection
include('connection.php');

// Initialize variables to avoid undefined variable warnings
$formattedCreatedAt = 'Unknown';  // Default value if not set
$formattedLastUpdated = 'Unknown'; // Default value if not set
$membercreation = 'Unknown';

// Fetch user data if not already stored in session
if (!isset($_SESSION['first_name']) || !isset($_SESSION['last_name'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch all relevant data, including created_at and last_updated
    $query = "SELECT first_name, middle_name, last_name, employee_id, role, department, email, career_goals, profile_picture, created_at, last_updated, phone_number, alt_email, faculty_rank 
              FROM users 
              WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch user data as an associative array

    if ($user) {
        // Store user data in session variables
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['middle_name'] = $user['middle_name']; // Optional
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['employee_id'] = $user['employee_id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['department'] = $user['department'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['alt_email'] = $user['alt_email'];
        $_SESSION['phone_number'] = $user['phone_number'];
        $_SESSION['faculty_rank'] = $user['faculty_rank'];
        $_SESSION['career_goals'] = $user['career_goals']; // Optional for career tracking
        $_SESSION['profile_picture'] = $user['profile_picture']; // Optional for profile display
        $_SESSION['created_at'] = $user['created_at'];
        $_SESSION['last_updated'] = $user['last_updated'];
    } else {
        // If user data not found, force logout
        header('Location: logout.php');
        exit();
    }
}

// Check if created_at exists before formatting
if (!empty($_SESSION['created_at'])) {
    $createdAt = new DateTime($_SESSION['created_at']);
    $formattedCreatedAt = $createdAt->format('M. Y'); // Example: "Oct. 2023"
    $membercreation = $createdAt->format('F d, Y');
}

// Check if last_updated exists before formatting
if (!empty($_SESSION['last_updated'])) {
    $lastUpdated = new DateTime($_SESSION['last_updated']);
    $formattedLastUpdated = $lastUpdated->format('M d, Y'); // Example: "Oct 15, 2023"
}
?>
