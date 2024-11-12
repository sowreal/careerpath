<?php
// get_log_details.php
include('../../session.php');
include('../../connection.php');
include('../../includes/functions.php');

// Ensure the user has HR role
if ($_SESSION['role'] != 'Human Resources') {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access.']);
    exit();
}

// Get log_id
if (!isset($_GET['log_id']) || !is_numeric($_GET['log_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid log ID.']);
    exit();
}

$log_id = (int) $_GET['log_id'];

// Fetch log details
$sql = "SELECT l.log_id, u.first_name, u.middle_name, u.last_name, u.department, u.faculty_rank, l.changed_at, ch.first_name AS changed_by_first, ch.last_name AS changed_by_last, l.changed_fields
        FROM profile_change_logs l
        JOIN users u ON l.user_id = u.id
        JOIN users ch ON l.changed_by = ch.id
        WHERE l.log_id = :log_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':log_id', $log_id, PDO::PARAM_INT);
$stmt->execute();
$log = $stmt->fetch(PDO::FETCH_ASSOC);

if ($log) {
    $formatted_log = [
        'log_id' => $log['log_id'],
        'faculty_name' => htmlspecialchars($log['first_name'] . ' ' . $log['middle_name'] . ' ' . $log['last_name']),
        'department' => htmlspecialchars($log['department']),
        'rank' => htmlspecialchars($log['faculty_rank']),
        'changed_at' => htmlspecialchars(date('Y-m-d H:i', strtotime($log['changed_at']))),
        'changed_by' => htmlspecialchars($log['changed_by_first'] . ' ' . $log['changed_by_last']),
        'changed_fields' => $log['changed_fields']
    ];
    echo json_encode(['status' => 'success', 'data' => $formatted_log]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Log entry not found.']);
}

