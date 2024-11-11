<?php

// Include necessary files and start session
include('../session.php');
include('../connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $hr_protected_fields = ['email', 'employee_id', 'faculty_rank', 'role', 'department'];
    $changes = [];

    foreach ($hr_protected_fields as $field) {
        if (isset($_POST[$field]) && $_POST[$field] != $_SESSION[$field]) {
            $changes[$field] = $_POST[$field];
        }
    }

    if (!empty($changes)) {
        // Encode changes to JSON
        $requested_changes = json_encode($changes);

        // Insert into profile_change_requests
        $stmt = $conn->prepare("INSERT INTO profile_change_requests (user_id, requested_changes) VALUES (?, ?)");
        $stmt->execute([$user_id, $requested_changes]);

        // Redirect back with success message
        header('Location: ../dashboard/profile_management.php?request=success');
        exit();
    } else {
        // No changes made
        header('Location: ../dashboard/profile_management.php?request=none');
        exit();
    }
}

?>
