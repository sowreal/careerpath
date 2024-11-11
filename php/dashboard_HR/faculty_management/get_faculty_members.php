<?php
// get_faculty_members.php

include('../../session.php'); // Ensure the user is logged in
include('../../connection.php'); // Include the database connection

// Check user role
if ($_SESSION['role'] != 'Human Resources') {
    // Handle unauthorized access
    exit();
}

// Get parameters
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$departmentFilter = isset($_GET['department']) ? trim($_GET['department']) : '';
$facultyRankFilter = isset($_GET['faculty_rank']) ? trim($_GET['faculty_rank']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10; // Number of entries per page
$offset = ($page - 1) * $limit;

// Build the query
$sql = "SELECT id, first_name, middle_name, last_name, department, faculty_rank FROM users WHERE role IN ('Regular Instructor', 'Contract of Service Instructor', 'Human Resources')";
$count_sql = "SELECT COUNT(*) FROM users WHERE role IN ('Regular Instructor', 'Contract of Service Instructor', 'Human Resources')";

// Parameters array for prepared statements
$params = [];

// Apply search filter if provided
if ($searchTerm !== '') {
    $sql .= " AND (first_name LIKE :search OR last_name LIKE :search)";
    $count_sql .= " AND (first_name LIKE :search OR last_name LIKE :search)";
    $params[':search'] = '%' . $searchTerm . '%';
}

// Apply department filter if provided
if ($departmentFilter !== '') {
    $sql .= " AND department = :department";
    $count_sql .= " AND department = :department";
    $params[':department'] = $departmentFilter;
}

// Apply faculty rank filter if provided
if ($facultyRankFilter !== '') {
    $sql .= " AND faculty_rank = :faculty_rank";
    $count_sql .= " AND faculty_rank = :faculty_rank";
    $params[':faculty_rank'] = $facultyRankFilter;
}

// Count total matching records
try {
    $count_stmt = $conn->prepare($count_sql);
    foreach ($params as $key => &$val) {
        $count_stmt->bindParam($key, $val, PDO::PARAM_STR);
    }
    $count_stmt->execute();
    $total_results = $count_stmt->fetchColumn();
    $total_pages = ceil($total_results / $limit);
} catch (PDOException $e) {
    echo json_encode(['error' => "Error counting faculty data: " . $e->getMessage()]);
    exit();
}

// Append ORDER BY and LIMIT clauses for pagination
$sql .= " ORDER BY last_name ASC, first_name ASC LIMIT :limit OFFSET :offset";

try {
    $stmt = $conn->prepare($sql);

    // Bind search, department, and faculty rank parameters
    foreach ($params as $key => &$val) {
        $stmt->bindParam($key, $val, PDO::PARAM_STR);
    }

    // Bind limit and offset for pagination
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

    $stmt->execute();
    $facultyMembers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo json_encode(['error' => "Error fetching faculty data: " . $e->getMessage()]);
    exit();
}

// Build the table data HTML
$table_data = '';
if ($facultyMembers) {
    foreach ($facultyMembers as $member) {
        $fullName = htmlspecialchars($member['first_name'] . ' '. $member['middle_name'] .' ' . $member['last_name']);
        $department = htmlspecialchars($member['department']);
        $facultyRank = htmlspecialchars($member['faculty_rank']);
        $facultyId = $member['id'];

        $table_data .= '<tr>';
        $table_data .= '<td>' . $fullName . '</td>';
        $table_data .= '<td>' . $department . '</td>';
        $table_data .= '<td>' . $facultyRank . '</td>';
        $table_data .= '<td>';
        $table_data .= '<button type="button" class="btn btn-success view-profile-btn" data-faculty-id="' . $facultyId . '">View Profile</button>';
        $table_data .= '</td>';
        $table_data .= '</tr>';
    }
} else {
    $table_data .= '<tr><td colspan="4" class="text-center">No faculty members found.</td></tr>';
}

// Build the pagination HTML
$pagination = '';
if ($total_pages > 1) {
    $pagination .= '<nav aria-label="Page navigation"><ul class="pagination faculty-pagination">';
    // Previous page
    $prev_disabled = $page <= 1 ? ' disabled' : '';
    $prev_page = max(1, $page - 1);
    $pagination .= '<li class="page-item' . $prev_disabled . '"><a class="page-link" href="#" data-page="' . $prev_page . '">Previous</a></li>';

    // Maximum number of page links to show
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
        $active = $page == $i ? ' active' : '';
        $pagination .= '<li class="page-item' . $active . '"><a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a></li>';
    }

    if ($end < $total_pages) {
        if ($end < $total_pages - 1) {
            $pagination .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
        $pagination .= '<li class="page-item"><a class="page-link" href="#" data-page="' . $total_pages . '">' . $total_pages . '</a></li>';
    }

    // Next page
    $next_disabled = $page >= $total_pages ? ' disabled' : '';
    $next_page = min($total_pages, $page + 1);
    $pagination .= '<li class="page-item' . $next_disabled . '"><a class="page-link" href="#" data-page="' . $next_page . '">Next</a></li>';

    $pagination .= '</ul></nav>';
}


// Return the data as JSON
header('Content-Type: application/json');
echo json_encode([
    'table_data' => $table_data,
    'pagination' => $pagination
]);
?>
