<?php
// submit_change_request.php
include('../../session.php');
include('../../connection.php');
include('../../includes/functions.php');

// Ensure the user is a faculty member
if ($_SESSION['role'] != 'Permanent Instructor' && $_SESSION['role'] != 'Contract of Service Instructor') {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access.']);
    exit();
}

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit();
}

// Get POST data
$user_id = $_SESSION['user_id'];
$requested_changes = [];

// Collect requested changes
if (isset($_POST['department']) && !empty(trim($_POST['department']))) {
    $requested_changes['department'] = trim($_POST['department']);
}
if (isset($_POST['faculty_rank']) && !empty(trim($_POST['faculty_rank']))) {
    $requested_changes['faculty_rank'] = trim($_POST['faculty_rank']);
}
// Add other fields as necessary

if (empty($requested_changes)) {
    echo json_encode(['status' => 'error', 'message' => 'No changes were submitted.']);
    exit();
}

// Encode changes as JSON
$requested_changes_json = json_encode($requested_changes);

// Insert into profile_change_requests table
$sql = "INSERT INTO profile_change_requests (user_id, requested_changes) VALUES (:user_id, :requested_changes)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindParam(':requested_changes', $requested_changes_json, PDO::PARAM_STR);

if ($stmt->execute()) {
    // Optionally, notify HR via email or push notification here

    // Log the submission
    logChange($conn, $user_id, $user_id, $requested_changes, 'Submitted Change Request');

    echo json_encode(['status' => 'success', 'message' => 'Your change request has been submitted and is pending approval.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to submit change request. Please try again.']);
}
