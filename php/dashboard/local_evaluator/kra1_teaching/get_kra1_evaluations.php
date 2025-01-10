<?php
// get_kra1_evaluations.php
ob_start();
header('Content-Type: application/json');

$response = [
    'table_data' => '',
    'pagination' => ''
];

require_once '../../session.php';
require_once '../../connection.php';
require_once '../../config.php';

// **Removed Local Evaluator Role Check**

// Get parameters
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$departmentFilter = isset($_GET['department']) ? trim($_GET['department']) : '';
$facultyRankFilter = isset($_GET['faculty_rank']) ? trim($_GET['faculty_rank']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Base query (fetch faculty members who have submitted KRA1 evaluations)
$sql = "SELECT DISTINCT u.id, u.first_name, u.middle_name, u.last_name, u.department, u.faculty_rank
        FROM users u
        INNER JOIN request_form rf ON u.id = rf.faculty_id
        INNER JOIN kra1_a_metadata kam ON rf.request_id = kam.request_id
        WHERE u.role IN ('Permanent Instructor', 'Contract of Service Instructor')";

$count_sql = "SELECT COUNT(DISTINCT u.id)
              FROM users u
              INNER JOIN request_form rf ON u.id = rf.faculty_id
              INNER JOIN kra1_a_metadata kam ON rf.request_id = kam.request_id
              WHERE u.role IN ('Permanent Instructor', 'Contract of Service Instructor')";

$params = [];

// Apply filters (if provided)
if ($searchTerm !== '') {
    $sql .= " AND (u.first_name LIKE :search OR u.last_name LIKE :search OR u.email LIKE :search)";
    $count_sql .= " AND (u.first_name LIKE :search OR u.last_name LIKE :search OR u.email LIKE :search)";
    $params[':search'] = '%' . $searchTerm . '%';
}
if ($departmentFilter !== '') {
    $sql .= " AND u.department = :department";
    $count_sql .= " AND u.department = :department";
    $params[':department'] = $departmentFilter;
}
if ($facultyRankFilter !== '') {
    $sql .= " AND u.faculty_rank = :faculty_rank";
    $count_sql .= " AND u.faculty_rank = :faculty_rank";
    $params[':faculty_rank'] = $facultyRankFilter;
}

// Count total matching records for pagination
try {
    $count_stmt = $conn->prepare($count_sql);
    foreach ($params as $key => &$val) {
        $count_stmt->bindParam($key, $val, PDO::PARAM_STR);
    }
    $count_stmt->execute();
    $total_results = $count_stmt->fetchColumn();
    $total_pages = ceil($total_results / $limit);
} catch (PDOException $e) {
    $response['error'] = "Error counting KRA1 data: " . $e->getMessage();
    echo json_encode($response);
    ob_end_clean();
    exit();
}

// Ensure requested page is valid
if ($page > $total_pages && $total_pages > 0) {
    $page = $total_pages;
    $offset = ($page - 1) * $limit;
}

// Add pagination to query
$sql .= " ORDER BY u.last_name ASC, u.first_name ASC LIMIT :limit OFFSET :offset";

try {
    $stmt = $conn->prepare($sql);
    foreach ($params as $key => &$val) {
        $stmt->bindParam($key, $val, PDO::PARAM_STR);
    }
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $facultyMembers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $response['error'] = "Error fetching KRA1 data: " . $e->getMessage();
    echo json_encode($response);
    ob_end_clean();
    exit();
}

// Build table data HTML
$table_data = '';
if ($facultyMembers) {
    foreach ($facultyMembers as $member) {
        $fullName = htmlspecialchars($member['first_name'] . ' ' . ($member['middle_name'] ? $member['middle_name'] . ' ' : '') . $member['last_name']);
        $department = htmlspecialchars($member['department']);
        $facultyRank = htmlspecialchars($member['faculty_rank']);
        $facultyId = $member['id'];

        $table_data .= '<tr>';
        $table_data .= '<td>' . $fullName . '</td>';
        $table_data .= '<td>' . $department . '</td>';
        $table_data .= '<td>' . $facultyRank . '</td>';
        $table_data .= '<td>';
        $table_data .= '<button type="button" class="btn btn-success btn-sm view-kra1-btn" data-faculty-id="' . $facultyId . '">View KRA1</button>';
        $table_data .= '</td>';
        $table_data .= '</tr>';
    }
} else {
    $table_data .= '<tr><td colspan="4" class="text-center">No KRA1 evaluations found.</td></tr>';
}

// Build pagination HTML
$pagination = '';
if ($total_pages > 1) {
    $pagination .= '<nav aria-label="Page navigation"><ul class="pagination kra1-pagination">';
    $prev_disabled = ($page <= 1) ? ' disabled' : '';
    $prev_page = max(1, $page - 1);
    $pagination .= '<li class="page-item' . $prev_disabled . '"><a class="page-link" href="#" data-page="' . $prev_page . '">Previous</a></li>';
    $max_links = 5;
    $start = max(1, $page - 2);
    $end = min($total_pages, $page + 2);
    if ($start > 1) {
        $pagination .= '<li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>';
        if ($start > 2) {
            $pagination .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
    }
    for ($i = $start; $i <= $end; $i++) {
        $active = ($page == $i) ? ' active' : '';
        $pagination .= '<li class="page-item' . $active . '"><a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a></li>';
    }
    if ($end < $total_pages) {
        if ($end < $total_pages - 1) {
            $pagination .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
        $pagination .= '<li class="page-item"><a class="page-link" href="#" data-page="' . $total_pages . '">' . $total_pages . '</a></li>';
    }
    $next_disabled = ($page >= $total_pages) ? ' disabled' : '';
    $next_page = min($total_pages, $page + 1);
    $pagination .= '<li class="page-item' . $next_disabled . '"><a class="page-link" href="#" data-page="' . $next_page . '">Next</a></li>';
    $pagination .= '</ul></nav>';
}

// Set response data
$response['table_data'] = $table_data;
$response['pagination'] = $pagination;

// Send response
ob_clean();
echo json_encode($response);
exit();
?>