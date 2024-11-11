<?php
session_start();
include('../connection.php');

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_picture'])) {
    // Check if a file was uploaded without errors
    if ($_FILES['profile_picture']['error'] !== UPLOAD_ERR_OK) {
        echo "<script>alert('An error occurred during file upload. Please try again.'); window.history.back();</script>";
        exit();
    }

    // Validate file type using MIME type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES["profile_picture"]["tmp_name"]);
    finfo_close($finfo);

    $allowed_mimes = ['image/jpeg', 'image/png'];
    if (!in_array($mime, $allowed_mimes)) {
        echo "<script>alert('Invalid file type. Only JPG, JPEG, PNG files are allowed.'); window.history.back();</script>";
        exit();
    }

    // Check file size (2MB)
    if ($_FILES["profile_picture"]["size"] > 2097152) {
        echo "<script>alert('Sorry, your file is too large. Maximum size is 2MB.'); window.history.back();</script>";
        exit();
    }

    // Define upload directory
    $target_dir = "../../uploads/";

    // Ensure the upload directory exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // Fetch the current profile picture to delete it
    $stmt = $conn->prepare("SELECT profile_picture FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && !empty($user['profile_picture'])) {
        $old_file = $target_dir . $user['profile_picture'];
        if (file_exists($old_file)) {
            unlink($old_file); // Delete the old profile picture
        }
    }

    // Generate a unique file name to prevent overwriting
    $new_file_name = uniqid('profile_', true) . '.png'; // Since we're sending as PNG
    $target_file = $target_dir . $new_file_name;

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
        // Set appropriate file permissions
        chmod($target_file, 0644);

        // Save the file name in the database
        $stmt = $conn->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
        $stmt->execute([$new_file_name, $user_id]);

        // Update session with new profile picture
        $_SESSION['profile_picture'] = $new_file_name;

        // Redirect to profile management page with success message
        header('Location: ../dashboard/profile_management.php?upload=success');
        exit();
    } else {
        echo "<script>alert('Sorry, there was an error uploading your file.'); window.history.back();</script>";
    }
}
?>
