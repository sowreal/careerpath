<?php
// get_profile_change_requests.php

// Include database connection and session
include '../../connection.php';
include '../../session.php';

// Set default time zone
date_default_timezone_set('Asia/Manila'); // Adjust to your local time zone

// Get filters and page number from GET parameters
$name = isset($_GET['name']) ? $_GET['name'] : '';
$department = isset($_GET['department']) ? $_GET['department'] : '';
$faculty_rank = isset($_GET['faculty_rank']) ? $_GET['faculty_rank'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
$date_sort = isset($_GET['date_sort']) ? $_GET['date_sort'] : 'oldest'; // Default to 'oldest'
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$records_per_page = 10; // Increased from 5 to 10

// Build the WHERE clause
$where_clauses = array("1");
$params = array();

if ($name != '') {
    $where_clauses[] = "(u.first_name LIKE ? OR u.last_name LIKE ?)";
    $params[] = '%' . $name . '%';
    $params[] = '%' . $name . '%';
}

if ($department != '') {
    $where_clauses[] = "u.department = ?";
    $params[] = $department;
}

if ($faculty_rank != '') {
    $where_clauses[] = "u.faculty_rank = ?";
    $params[] = $faculty_rank;
}

if ($status != '') {
    $where_clauses[] = "pcr.status = ?";
    $params[] = $status;
}

// Build the ORDER BY clause
$status_order = "
    CASE
        WHEN pcr.status = 'Pending' THEN 1
        WHEN pcr.status = 'Approved' THEN 2
        WHEN pcr.status = 'Denied' THEN 3
        ELSE 4
    END ASC
";

if ($date_sort == 'oldest') {
    $date_order = "pcr.submitted_at ASC";
} else {
    $date_order = "pcr.submitted_at DESC";
}

$order_by = "$status_order, $date_order";

// Calculate total records
$sql_total = "SELECT COUNT(*) as total FROM profile_change_requests pcr
              INNER JOIN users u ON pcr.user_id = u.id
              WHERE " . implode(' AND ', $where_clauses);
$stmt_total = $conn->prepare($sql_total);
$stmt_total->execute($params);
$total_records = $stmt_total->fetchColumn();

// Calculate total pages
$total_pages = ceil($total_records / $records_per_page);

// Calculate offset
$offset = max(0, ($page - 1) * $records_per_page);

// Fetch records
$sql = "SELECT pcr.*, u.first_name, u.last_name, u.department, u.faculty_rank
        FROM profile_change_requests pcr
        INNER JOIN users u ON pcr.user_id = u.id
        WHERE " . implode(' AND ', $where_clauses) . "
        ORDER BY $order_by
        LIMIT $offset, $records_per_page";
$stmt = $conn->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Generate table rows
$table_data = '';
if (count($results) > 0) {
    foreach ($results as $row) {
        $full_name = $row['first_name'] . ' ' . $row['last_name'];
        $formatted_date = date('Y M d - g:i A', strtotime($row['submitted_at']));
        $table_data .= '<tr data-request-id="' . $row['request_id'] . '" style="cursor:pointer;">';
        $table_data .= '<td>' . $row['request_id'] . '</td>';
        $table_data .= '<td>' . htmlspecialchars($full_name) . '</td>';
        $table_data .= '<td>' . htmlspecialchars($row['department']) . '</td>';
        $table_data .= '<td>' . htmlspecialchars($row['faculty_rank']) . '</td>';
        $table_data .= '<td>' . htmlspecialchars($formatted_date) . '</td>';
        $table_data .= '<td>' . htmlspecialchars($row['status']) . '</td>';
        $table_data .= '</tr>';
    }
} else {
    $table_data = '<tr><td colspan="6" class="text-center">No profile change requests found.</td></tr>';
}

// Generate pagination HTML
$pagination = '';

if ($total_pages > 1) {
    $pagination .= '<nav aria-label="Page navigation"><ul class="pagination">';

    // Previous page button
    if ($page > 1) {
        $prev_page = $page - 1;
        $pagination .= '<li class="page-item"><a class="page-link" href="#" data-page="' . $prev_page . '">Previous</a></li>';
    } else {
        $pagination .= '<li class="page-item disabled"><span class="page-link">Previous</span></li>';
    }

    // Page number links
    $max_links = 5;
    $start_page = max(1, $page - 2);
    $end_page = min($total_pages, $page + 2);

    if ($start_page > 1) {
        $pagination .= '<li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>';
        if ($start_page > 2) {
            $pagination .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
    }

    for ($i = $start_page; $i <= $end_page; $i++) {
        $active = $page == $i ? ' active' : '';
        $pagination .= '<li class="page-item' . $active . '"><a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a></li>';
    }

    if ($end_page < $total_pages) {
        if ($end_page < $total_pages - 1) {
            $pagination .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
        $pagination .= '<li class="page-item"><a class="page-link" href="#" data-page="' . $total_pages . '">' . $total_pages . '</a></li>';
    }

    // Next page button
    if ($page < $total_pages) {
        $next_page = $page + 1;
        $pagination .= '<li class="page-item"><a class="page-link" href="#" data-page="' . $next_page . '">Next</a></li>';
    } else {
        $pagination .= '<li class="page-item disabled"><span class="page-link">Next</span></li>';
    }

    $pagination .= '</ul></nav>';
}

// Return JSON response
echo json_encode(array(
    'table_data' => $table_data,
    'pagination' => $pagination
));
?>
