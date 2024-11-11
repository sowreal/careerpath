<?php
session_start();
include('../connection.php');

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_photo'])) {
    // Fetch the current profile picture from the database
    $stmt = $conn->prepare("SELECT profile_picture FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && !empty($user['profile_picture'])) {
        $profile_picture = $user['profile_picture'];
        $file_path = "../../uploads/" . $profile_picture;

        // Delete the file from the server
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Update the database to set profile_picture to NULL
        $stmt = $conn->prepare("UPDATE users SET profile_picture = NULL WHERE id = ?");
        $stmt->execute([$user_id]);

        // Update session variable
        $_SESSION['profile_picture'] = NULL;

        // Redirect to profile management page with success message
        header('Location: ../dashboard/profile_management.php?delete=success');
        exit();
    } else {
        // Redirect with error message
        header('Location: ../dashboard/profile_management.php?delete=error');
        exit();
    }
}
?>
