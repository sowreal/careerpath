<?php
// get_logs.php
include('../../session.php');
include('../../connection.php');
include('../../includes/functions.php');

// Ensure the user has HR role
if ($_SESSION['role'] != 'Human Resources') {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access.']);
    exit();
}

// Get parameters
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 10; // Number of entries per page
$filter = isset($_GET['filter']) ? trim($_GET['filter']) : '';
$sort = isset($_GET['sort']) && in_array($_GET['sort'], ['asc', 'desc']) ? $_GET['sort'] : 'desc';

// Calculate offset
$offset = ($page - 1) * $limit;

// Base SQL
$base_sql = "SELECT l.log_id, u.first_name, u.middle_name, u.last_name, u.department, u.faculty_rank, l.changed_at, ch.first_name AS changed_by_first, ch.last_name AS changed_by_last, l.changed_fields
            FROM profile_change_logs l
            JOIN users u ON l.user_id = u.id
            JOIN users ch ON l.changed_by = ch.id";

// Apply filter if any
if ($filter === 'date') {
    $base_sql .= " ORDER BY l.changed_at $sort";
} elseif ($filter === 'rank') {
    $base_sql .= " ORDER BY u.faculty_rank $sort";
} elseif ($filter === 'department') {
    $base_sql .= " ORDER BY u.department $sort";
} else {
    $base_sql .= " ORDER BY l.changed_at $sort";
}

// Pagination
$pagination_sql = "SELECT COUNT(*) FROM profile_change_logs l
                   JOIN users u ON l.user_id = u.id
                   JOIN users ch ON l.changed_by = ch.id";
$stmt_count = $conn->prepare($pagination_sql);
$stmt_count->execute();
$total_results = $stmt_count->fetchColumn();
$total_pages = ceil($total_results / $limit);

// Fetch data
$data_sql = "$base_sql LIMIT :limit OFFSET :offset";
$stmt = $conn->prepare($data_sql);

// Bind parameters
$stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
$stmt->execute();
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Format data
$formatted_logs = array_map(function($log) {
    return [
        'log_id' => $log['log_id'],
        'faculty_name' => htmlspecialchars($log['first_name'] . ' ' . $log['middle_name'] . ' ' . $log['last_name']),
        'department' => htmlspecialchars($log['department']),
        'rank' => htmlspecialchars($log['faculty_rank']),
        'changed_at' => htmlspecialchars(date('Y-m-d H:i', strtotime($log['changed_at']))),
        'changed_by' => htmlspecialchars($log['changed_by_first'] . ' ' . $log['changed_by_last'])
    ];
}, $logs);

// Return JSON response
echo json_encode(['status' => 'success', 'data' => $formatted_logs, 'total_pages' => $total_pages]);

