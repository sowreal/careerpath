<?php
// get_request_details.php

// Include database connection and session
include '../../connection.php';
include '../../session.php';

$request_id = isset($_GET['request_id']) ? (int)$_GET['request_id'] : 0;

if ($request_id <= 0) {
    echo json_encode(array('success' => false, 'message' => 'Invalid request ID.'));
    exit;
}

// Fetch request details
$sql = "SELECT pcr.*, u.first_name, u.last_name, u.department, u.faculty_rank
        FROM profile_change_requests pcr
        INNER JOIN users u ON pcr.user_id = u.id
        WHERE pcr.request_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$request_id]);
$request = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$request) {
    echo json_encode(array('success' => false, 'message' => 'Request not found.'));
    exit;
}

// Decode the requested_changes JSON
$requested_changes = json_decode($request['requested_changes'], true);

// Prepare the requested changes array
$changes = array();
foreach ($requested_changes as $field => $new_value) {
    // Fetch the old value from the users table
    $sql_old = "SELECT $field FROM users WHERE id = ?";
    $stmt_old = $conn->prepare($sql_old);
    $stmt_old->execute([$request['user_id']]);
    $old_value = $stmt_old->fetchColumn();

    $changes[$field] = array(
        'old_value' => $old_value,
        'new_value' => $new_value
    );
}

// Prepare the response
$response = array(
    'success' => true,
    'request_id' => $request['request_id'],
    'faculty_name' => $request['first_name'] . ' ' . $request['last_name'],
    'department' => $request['department'],
    'rank' => $request['faculty_rank'],
    'submitted_at' => $request['submitted_at'],
    'status' => $request['status'],
    'admin_message' => $request['admin_message'],
    'requested_changes' => $changes
);

echo json_encode($response);
?>
