<?php
// Start output buffering to prevent accidental output
ob_start();

// Include necessary files and start session
include('../session.php');
include('../connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate inputs
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $phone_number = $_POST['phone_number'];
    $alt_email = $_POST['alt_email'];
    $email = $_POST['email'];
    $employee_id = $_POST['employee_id'];
    $faculty_rank = $_POST['faculty_rank'];
    $role = $_POST['role'];
    $department = $_POST['department'];
    $user_id = $_SESSION['user_id'];

    // Update users table
    $stmt = $conn->prepare("UPDATE users SET
        first_name = ?,
        middle_name = ?,
        last_name = ?,
        phone_number = ?,
        alt_email = ?,
        email = ?,
        employee_id = ?,
        faculty_rank = ?,
        role = ?,
        department = ?
        WHERE id = ?");

    $stmt->execute([
        $first_name,
        $middle_name,
        $last_name,
        $phone_number,
        $alt_email,
        $email,
        $employee_id,
        $faculty_rank,
        $role,
        $department,
        $user_id
    ]);

    // Update session variables
    $_SESSION['first_name'] = $first_name;
    $_SESSION['middle_name'] = $middle_name;
    $_SESSION['last_name'] = $last_name;
    $_SESSION['phone_number'] = $phone_number;
    $_SESSION['alt_email'] = $alt_email;
    $_SESSION['email'] = $email;
    $_SESSION['employee_id'] = $employee_id;
    $_SESSION['faculty_rank'] = $faculty_rank;
    $_SESSION['role'] = $role;
    $_SESSION['department'] = $department;

    // Redirect back with success message
    header('Location: ../dashboard/profile_management.php?update=success');
    exit();
}
// Flush the output buffer
ob_end_flush();
?>