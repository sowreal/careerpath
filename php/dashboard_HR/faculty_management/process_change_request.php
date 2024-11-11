<?php
// process_change_request.php

// Include database connection and session
include '../../connection.php';
include '../../session.php';

$hr_user_id = $_SESSION['user_id'];

// Get data from POST
$request_id = isset($_POST['request_id']) ? (int)$_POST['request_id'] : 0;
$action = isset($_POST['action']) ? $_POST['action'] : '';
$admin_message = isset($_POST['admin_message']) ? $_POST['admin_message'] : '';

if ($request_id <= 0 || !in_array($action, array('Approved', 'Denied'))) {
    echo json_encode(array('success' => false, 'message' => 'Invalid data.'));
    exit;
}

// Fetch the request
$sql = "SELECT * FROM profile_change_requests WHERE request_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$request_id]);
$request = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$request) {
    echo json_encode(array('success' => false, 'message' => 'Request not found.'));
    exit;
}

if ($request['status'] != 'Pending') {
    echo json_encode(array('success' => false, 'message' => 'Request has already been processed.'));
    exit;
}

// Begin transaction
$conn->beginTransaction();

try {
    // Update the request status
    $sql_update = "UPDATE profile_change_requests SET status = ?, hr_reviewed_at = NOW(), hr_reviewed_by = ?, admin_message = ? WHERE request_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->execute([$action, $hr_user_id, $admin_message, $request_id]);

    if ($action == 'Approved') {
        // Apply the changes to the user's profile
        $requested_changes = json_decode($request['requested_changes'], true);

        // Fetch the old values before updating
        $user_id = $request['user_id'];
        $old_values = [];
        $fields = array_keys($requested_changes);
        $fields_list = implode(", ", $fields);

        $sql_old = "SELECT $fields_list FROM users WHERE id = ?";
        $stmt_old = $conn->prepare($sql_old);
        $stmt_old->execute([$user_id]);
        $old_values = $stmt_old->fetch(PDO::FETCH_ASSOC);

        // Update the user's profile
        $update_fields = [];
        $params = [];

        foreach ($requested_changes as $field => $new_value) {
            $update_fields[] = "$field = ?";
            $params[] = $new_value;
        }
        $params[] = $user_id;

        $sql_user_update = "UPDATE users SET " . implode(', ', $update_fields) . ", last_updated = NOW() WHERE id = ?";
        $stmt_user_update = $conn->prepare($sql_user_update);
        $stmt_user_update->execute($params);

        // Prepare changed_fields with old and new values
        $changed_fields = [];
        foreach ($requested_changes as $field => $new_value) {
            $changed_fields[$field] = [
                'old_value' => $old_values[$field],
                'new_value' => $new_value
            ];
        }
        $changed_fields_json = json_encode($changed_fields);

        // Record in profile_change_logs
        $sql_log = "INSERT INTO profile_change_logs (user_id, changed_by, changed_at, changed_fields) VALUES (?, ?, NOW(), ?)";
        $stmt_log = $conn->prepare($sql_log);
        $stmt_log->execute([$user_id, $hr_user_id, $changed_fields_json]);
    }

    // Commit transaction
    $conn->commit();

    echo json_encode(array('success' => true));
} catch (Exception $e) {
    // Rollback transaction
    $conn->rollBack();
    echo json_encode(array('success' => false, 'message' => 'An error occurred.'));
}
?>
