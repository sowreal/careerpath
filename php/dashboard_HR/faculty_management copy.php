<?php
include('../session.php'); // Ensure the user is logged in
include('../connection.php'); // Include the database connection

// Define variables for Page Titles and Sidebar Active effects
$pageTitle = 'Career Path | Faculty Profiles';
$activePage = 'Faculty Management';

// Check user role
if ($_SESSION['role'] != 'Human Resources') {
    // Check if the user is a Faculty Member
    if ($_SESSION['role'] != 'Permanent Instructor' && $_SESSION['role'] != 'Contract of Service Instructor') {
        // **Start of Session Destruction**
        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        // **End of Session Destruction**

        // Notify the user and redirect to the login page
        echo "<script>
                alert('Your account is not authorized. Redirecting to login page.');
                window.location.href = '../login.php';
              </script>";
        exit();
    }
    // If the user is a Faculty Member, they should not access HR's Faculty Management
    // Redirect them to their own Profile Management page
    header('Location: ../dashboard/profile_management.php'); // Adjust if necessary
    exit();
}

// Pagination settings for Faculty List (not related to new containers)
$limit = 10; // Number of entries per page

// Determine the current page from GET parameter; default is 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Handle Search and Filter Parameters
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$departmentFilter = isset($_GET['department']) ? trim($_GET['department']) : '';
$facultyRankFilter = isset($_GET['faculty_rank']) ? trim($_GET['faculty_rank']) : '';

// Base SQL query
$sql = "SELECT id, first_name, middle_name, last_name, department, faculty_rank, email FROM users WHERE role IN ('Permanent Instructor', 'Contract of Service Instructor')";
$count_sql = "SELECT COUNT(*) FROM users WHERE role IN ('Permanent Instructor', 'Contract of Service Instructor')";

// Parameters array for prepared statements
$params = [];

// Apply search filter if provided
if ($searchTerm !== '') {
    $sql .= " AND (first_name LIKE :search OR last_name LIKE :search OR email LIKE :search)";
    $count_sql .= " AND (first_name LIKE :search OR last_name LIKE :search OR email LIKE :search)";
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
    echo "Error counting faculty data: " . $e->getMessage();
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
    echo "Error fetching faculty data: " . $e->getMessage();
    exit();
}

// Helper function to build pagination links
function build_pagination_link($page, $search, $department, $faculty_rank) {
    $params = [];
    
    if ($search !== '') {
        $params['search'] = $search;
    }
    
    if ($department !== '') {
        $params['department'] = $department;
    }
    
    if ($faculty_rank !== '') {
        $params['faculty_rank'] = $faculty_rank;
    }
    
    $params['page'] = $page;
    
    return '?' . http_build_query($params);
}
?>



<!DOCTYPE html>
<html lang="en"> <!--begin::Head-->

<head>
    <?php require_once('../includes/header.php') ?>
    
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
    <div class="app-wrapper"> 
        <!--begin::Header-->
        <?php require_once('../includes/navbar.php');?>
        <!--end::Header--> 
        
        <!--begin::Sidebar-->
        <?php require_once('../includes/sidebar_HR.php');?>
        <!--end::Sidebar--> 
        
        <!--begin::App Main-->
        <!-- Main Content -->
        <main class="app-main">
            <!-- Faculty Management -->
            <div class="container-fluid">
                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center my-4">
                    <h1 class="h3 mb-0 text-gray-800">Faculty Management</h1>
                </div>

                <!-- Search and Filter Section -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form class="row g-3" id="searchForm" method="GET" action="">
                            <!-- Search Bar -->
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="search" id="searchInput" placeholder="Search by name or email" value="<?php echo htmlspecialchars($searchTerm); ?>">
                            </div>
                            
                            <!-- Department Filter -->
                            <div class="col-md-3">
                                <select class="form-select" name="department" id="departmentFilter">
                                    <option value="">All Departments</option>
                                    <option value="College of Agriculture" <?php if($departmentFilter == 'College of Agriculture') echo 'selected'; ?>>College of Agriculture</option>
                                    <option value="College of Allied Medicine" <?php if($departmentFilter == 'College of Allied Medicine') echo 'selected'; ?>>College of Allied Medicine</option>
                                    <option value="College of Arts and Sciences" <?php if($departmentFilter == 'College of Arts and Sciences') echo 'selected'; ?>>College of Arts and Sciences</option>
                                    <option value="College of Engineering" <?php if($departmentFilter == 'College of Engineering') echo 'selected'; ?>>College of Engineering</option>
                                    <option value="College of Industrial Technology" <?php if($departmentFilter == 'College of Industrial Technology') echo 'selected'; ?>>College of Industrial Technology</option>
                                    <option value="College of Teacher Education" <?php if($departmentFilter == 'College of Teacher Education') echo 'selected'; ?>>College of Teacher Education</option>
                                    <option value="College of Administration, Business, Hospitality, and Accountancy" <?php if($departmentFilter == 'College of Administration, Business, Hospitality, and Accountancy') echo 'selected'; ?>>College of Administration, Business, Hospitality, and Accountancy</option>
                                </select>
                            </div>
                            
                            <!-- Faculty Rank Filter -->
                            <div class="col-md-3">
                                <select class="form-select" name="faculty_rank" id="facultyRankFilter">
                                    <option value="">All Ranks</option>
                                    <option value="Instructor I" <?php if($facultyRankFilter == 'Instructor I') echo 'selected'; ?>>Instructor I</option>
                                    <option value="Instructor II" <?php if($facultyRankFilter == 'Instructor II') echo 'selected'; ?>>Instructor II</option>
                                    <option value="Instructor III" <?php if($facultyRankFilter == 'Instructor III') echo 'selected'; ?>>Instructor III</option>
                                    <option value="Assistant Professor I" <?php if($facultyRankFilter == 'Assistant Professor I') echo 'selected'; ?>>Assistant Professor I</option>
                                    <option value="Assistant Professor II" <?php if($facultyRankFilter == 'Assistant Professor II') echo 'selected'; ?>>Assistant Professor II</option>
                                    <option value="Assistant Professor III" <?php if($facultyRankFilter == 'Assistant Professor III') echo 'selected'; ?>>Assistant Professor III</option>
                                    <option value="Assistant Professor IV" <?php if($facultyRankFilter == 'Assistant Professor IV') echo 'selected'; ?>>Assistant Professor IV</option>
                                    <option value="Associate Professor I" <?php if($facultyRankFilter == 'Associate Professor I') echo 'selected'; ?>>Associate Professor I</option>
                                    <option value="Associate Professor II" <?php if($facultyRankFilter == 'Associate Professor II') echo 'selected'; ?>>Associate Professor II</option>
                                    <option value="Associate Professor III" <?php if($facultyRankFilter == 'Associate Professor III') echo 'selected'; ?>>Associate Professor III</option>
                                    <option value="Associate Professor IV" <?php if($facultyRankFilter == 'Associate Professor IV') echo 'selected'; ?>>Associate Professor IV</option>
                                    <option value="Associate Professor V" <?php if($facultyRankFilter == 'Associate Professor V') echo 'selected'; ?>>Associate Professor V</option>
                                    <option value="Professor I" <?php if($facultyRankFilter == 'Professor I') echo 'selected'; ?>>Professor I</option>
                                    <option value="Professor II" <?php if($facultyRankFilter == 'Professor II') echo 'selected'; ?>>Professor II</option>
                                    <option value="Professor III" <?php if($facultyRankFilter == 'Professor III') echo 'selected'; ?>>Professor III</option>
                                    <option value="Professor IV" <?php if($facultyRankFilter == 'Professor IV') echo 'selected'; ?>>Professor IV</option>
                                    <option value="Professor V" <?php if($facultyRankFilter == 'Professor V') echo 'selected'; ?>>Professor V</option>
                                    <option value="Professor VI" <?php if($facultyRankFilter == 'Professor VI') echo 'selected'; ?>>Professor VI</option>
                                    <option value="College Professor" <?php if($facultyRankFilter == 'College Professor') echo 'selected'; ?>>College Professor</option>
                                    <option value="University Professor" <?php if($facultyRankFilter == 'University Professor') echo 'selected'; ?>>University Professor</option>
                                </select>
                            </div>
                            
                            <!-- Search Button -->
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success w-100">Search</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Faculty List Table -->
                <div class="card">
                    <div class="card-body">
                        <?php if($total_results > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-hover" id="facultyTable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Department</th>
                                            <th>Position/Rank</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($facultyMembers as $faculty): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($faculty['first_name'] . ' ' . ($faculty['middle_name'] ? $faculty['middle_name'] . ' ' : '') . $faculty['last_name']); ?></td>
                                                <td><?php echo htmlspecialchars($faculty['department']); ?></td>
                                                <td><?php echo htmlspecialchars($faculty['faculty_rank']); ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-success view-profile-btn" data-bs-toggle="modal" data-bs-target="#profileModal" data-faculty-id="<?php echo $faculty['id']; ?>">View Profile</button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <!-- Previous Page Link -->
                                    <li class="page-item <?php if($page <= 1) echo 'disabled'; ?>">
                                        <a class="page-link" href="<?php echo build_pagination_link($page - 1, $searchTerm, $departmentFilter, $facultyRankFilter); ?>" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>

                                    <!-- Page Number Links -->
                                    <?php
                                        for($i = 1; $i <= $total_pages; $i++):
                                            if($i == $page):
                                    ?>
                                        <li class="page-item active"><a class="page-link" href="#"><?php echo $i; ?></a></li>
                                    <?php else: ?>
                                        <li class="page-item"><a class="page-link" href="<?php echo build_pagination_link($i, $searchTerm, $departmentFilter, $facultyRankFilter); ?>"><?php echo $i; ?></a></li>
                                    <?php
                                            endif;
                                        endfor;
                                    ?>

                                    <!-- Next Page Link -->
                                    <li class="page-item <?php if($page >= $total_pages) echo 'disabled'; ?>">
                                        <a class="page-link" href="<?php echo build_pagination_link($page + 1, $searchTerm, $departmentFilter, $facultyRankFilter); ?>" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        <?php else: ?>
                            <p class="text-center">No faculty members found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Containers for Profile Change Requests and Logs -->
            <div class="container-fluid">
                <div class="row mt-4">
                    <!-- Left Container: Profile Change Requests -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Profile Change Requests</h5>
                                <!-- Filter and Sort Controls -->
                                <div class="d-flex">
                                    <select class="form-select form-select-sm me-2" id="requestFilter">
                                        <option value="">All</option>
                                        <option value="date">Date</option>
                                        <option value="rank">Rank</option>
                                        <option value="department">Department</option>
                                    </select>
                                    <select class="form-select form-select-sm" id="requestSort">
                                        <option value="desc" selected>Descending</option>
                                        <option value="asc">Ascending</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover m-0" id="requestsTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Department</th>
                                                <th>Rank</th>
                                                <th>Date of Request</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Dynamic Content via JavaScript -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Pagination Controls -->
                            <div class="card-footer clearfix">
                                <ul class="pagination pagination-sm m-0 float-end" id="requestsPagination">
                                    <!-- Dynamic Pagination Links -->
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Right Container: Logs -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Profile Change Logs</h5>
                                <!-- Filter and Sort Controls -->
                                <div class="d-flex">
                                    <select class="form-select form-select-sm me-2" id="logFilter">
                                        <option value="">All</option>
                                        <option value="date">Date</option>
                                        <option value="rank">Rank</option>
                                        <option value="department">Department</option>
                                    </select>
                                    <select class="form-select form-select-sm" id="logSort">
                                        <option value="desc" selected>Descending</option>
                                        <option value="asc">Ascending</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover m-0" id="logsTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Department</th>
                                                <th>Rank</th>
                                                <th>Date of Change</th>
                                                <th>Changed By</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Dynamic Content via JavaScript -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Pagination Controls -->
                            <div class="card-footer clearfix">
                                <ul class="pagination pagination-sm m-0 float-end" id="logsPagination">
                                    <!-- Dynamic Pagination Links -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <!-- Faculty Profile Modal -->
            <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered"> <!-- Increased modal size and centered vertically -->
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="profileModalLabel">Faculty Profile</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editFacultyForm" class="needs-validation" novalidate>
                                <!-- Hidden ID Field -->
                                <input type="hidden" id="facultyId" name="id">
                                <div class="row justify-content-center"> <!-- Center the row -->
                                    <!-- Profile Picture -->
                                    <div class="col-md-4 text-center mb-3">
                                        <img src="../../img/cropped-SLSU_Logo-1.png" alt="Profile Picture" id="facultyProfilePicture" class="img-fluid mb-3" style="width: 200px; height: 200px; object-fit: cover;">
                                        <!-- Display Faculty ID below the picture -->
                                        <p class="mt-2"><strong>ID:</strong> <span id="facultyEmployeeIdText">EMP12345</span></p>
                                    </div>
                                    <!-- Profile Details -->
                                    <div class="col-md-8">
                                        <div class="row">
                                            <!-- First Name Field -->
                                            <div class="col-md-4 mb-3">
                                                <label for="facultyFirstName" class="form-label"><strong>First Name:</strong></label>
                                                <input type="text" class="form-control" id="facultyFirstName" name="first_name" required>
                                                <div class="invalid-feedback">
                                                    Please provide a first name.
                                                </div>
                                            </div>
                                            
                                            <!-- Middle Name Field -->
                                            <div class="col-md-4 mb-3">
                                                <label for="facultyMiddleName" class="form-label"><strong>Middle Name:</strong></label>
                                                <input type="text" class="form-control" id="facultyMiddleName" name="middle_name">
                                            </div>
                                            
                                            <!-- Last Name Field -->
                                            <div class="col-md-4 mb-3">
                                                <label for="facultyLastName" class="form-label"><strong>Last Name:</strong></label>
                                                <input type="text" class="form-control" id="facultyLastName" name="last_name" required>
                                                <div class="invalid-feedback">
                                                    Please provide a last name.
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="facultyEmail" class="form-label"><strong>Email Address:</strong></label>
                                                <input type="email" class="form-control" id="facultyEmail" name="email" readonly>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="facultyRole" class="form-label"><strong>Role:</strong></label>
                                                <select class="form-select" id="facultyRole" name="role" required>
                                                    <option value="">Select Role</option>
                                                    <option value="Permanent Instructor">Permanent Instructor</option>
                                                    <option value="Contract of Service Instructor">Contract of Service Instructor</option>
                                                    <option value="Human Resources">Human Resources</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Please select a role.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="facultyPhone" class="form-label"><strong>Phone Number:</strong></label>
                                                <input type="text" class="form-control" id="facultyPhone" name="phone_number" required>
                                                <div class="invalid-feedback">
                                                    Please provide a valid phone number.
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="facultyAltEmail" class="form-label"><strong>Alternate Email:</strong></label>
                                                <input type="email" class="form-control" id="facultyAltEmail" name="alt_email">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="facultyEmployeeId" class="form-label"><strong>Employee ID:</strong></label>
                                                <input type="text" class="form-control" id="facultyEmployeeId" name="employee_id" required>
                                                <div class="invalid-feedback">
                                                    Please provide an employee ID.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="facultyDepartment" class="form-label"><strong>Department:</strong></label>
                                                <select class="form-select" id="facultyDepartment" name="department" required>
                                                    <option value="">Select Department</option>
                                                    <option value="College of Agriculture">College of Agriculture</option>
                                                    <option value="College of Allied Medicine">College of Allied Medicine</option>
                                                    <option value="College of Arts and Sciences">College of Arts and Sciences</option>
                                                    <option value="College of Engineering">College of Engineering</option>
                                                    <option value="College of Industrial Technology">College of Industrial Technology</option>
                                                    <option value="College of Teacher Education">College of Teacher Education</option>
                                                    <option value="College of Administration, Business, Hospitality, and Accountancy">College of Administration, Business, Hospitality, and Accountancy</option>
                                                    <!-- <option value="Human Resources Management Office">Human Resources Management Office</option> -->
                                                </select>
                                                <div class="invalid-feedback">
                                                    Please select a department.
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="facultyPosition" class="form-label"><strong>Faculty Rank:</strong></label>
                                                <select class="form-select" id="facultyPosition" name="faculty_rank" required>
                                                    <option value="">Select Faculty Rank</option>
                                                    <option value="Instructor I">Instructor I</option>
                                                    <option value="Instructor II">Instructor II</option>
                                                    <option value="Instructor III">Instructor III</option>
                                                    <option value="Assistant Professor I">Assistant Professor I</option>
                                                    <option value="Assistant Professor II">Assistant Professor II</option>
                                                    <option value="Assistant Professor III">Assistant Professor III</option>
                                                    <option value="Assistant Professor IV">Assistant Professor IV</option>
                                                    <option value="Associate Professor I">Associate Professor I</option>
                                                    <option value="Associate Professor II">Associate Professor II</option>
                                                    <option value="Associate Professor III">Associate Professor III</option>
                                                    <option value="Associate Professor IV">Associate Professor IV</option>
                                                    <option value="Associate Professor V">Associate Professor V</option>
                                                    <option value="Professor I">Professor I</option>
                                                    <option value="Professor II">Professor II</option>
                                                    <option value="Professor III">Professor III</option>
                                                    <option value="Professor IV">Professor IV</option>
                                                    <option value="Professor V">Professor V</option>
                                                    <option value="Professor VI">Professor VI</option>
                                                    <option value="College Professor">College Professor</option>
                                                    <option value="University Professor">University Professor</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Please select a faculty rank.
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Commented Out Career Goals -->
                                        <!--
                                        <div class="mb-3">
                                            <label for="facultyCareerGoals" class="form-label"><strong>Career Goals:</strong></label>
                                            <textarea class="form-control" id="facultyCareerGoals" name="career_goals" rows="4"></textarea>
                                        </div>
                                        -->
                                        
                                        <div class="row">
                                            <!-- Created At Field -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label"><strong>Created At:</strong></label>
                                                <p id="facultyCreatedAt">N/A</p>
                                            </div>
                                            <!-- Last Updated Field -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label"><strong>Last Updated:</strong></label>
                                                <p id="facultyLastUpdated">N/A</p>
                                            </div>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-success float-end">Save Changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Change Request Modal -->
            <div class="modal fade" id="requestModal" tabindex="-1" aria-labelledby="requestModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="requestModalLabel">Profile Change Request Details</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Request ID:</strong> <span id="modalRequestId"></span></p>
                            <p><strong>Faculty Name:</strong> <span id="modalFacultyName"></span></p>
                            <p><strong>Department:</strong> <span id="modalDepartment"></span></p>
                            <p><strong>Rank:</strong> <span id="modalRank"></span></p>
                            <p><strong>Date of Request:</strong> <span id="modalSubmittedAt"></span></p>
                            <p><strong>Status:</strong> <span id="modalStatus"></span></p>
                            <hr>
                            <h6>Requested Changes:</h6>
                            <div id="modalRequestedChanges">
                                <!-- Dynamic Content -->
                            </div>
                            <hr>
                            <h6>HR Comments:</h6>
                            <p id="modalAdminMessage"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" id="approveRequestBtn">Approve</button>
                            <button type="button" class="btn btn-danger" id="denyRequestBtn">Deny</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Logs Modal -->
            <div class="modal fade" id="logModal" tabindex="-1" aria-labelledby="logModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-secondary text-white">
                            <h5 class="modal-title" id="logModalLabel">Profile Change Log Details</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Log ID:</strong> <span id="modalLogId"></span></p>
                            <p><strong>Faculty Name:</strong> <span id="modalLogFacultyName"></span></p>
                            <p><strong>Department:</strong> <span id="modalLogDepartment"></span></p>
                            <p><strong>Rank:</strong> <span id="modalLogRank"></span></p>
                            <p><strong>Date of Change:</strong> <span id="modalLogChangedAt"></span></p>
                            <p><strong>Changed By:</strong> <span id="modalLogChangedBy"></span></p>
                            <hr>
                            <h6>Changes:</h6>
                            <div id="modalLogChanges">
                                <!-- Dynamic Content -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </main>

                <!--end::App Main--> 
                
                <!--begin::Footer-->
                <?php require_once('../includes/footer.php'); ?>
                <!--end::Footer-->
    </div> 
        <!--end::App Wrapper--> 
        
        
        <!--begin::Script--> 
        <!--begin::Third Party Plugin(OverlayScrollbars)-->
        <?php require_once('../includes/dashboard_default_scripts.php');?>
        
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Bootstrap's validation
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    form.classList.add('was-validated');
                }, false);
            });

        // Event listener for "View Profile" buttons
        document.querySelectorAll('.view-profile-btn').forEach(function (button) {
            button.addEventListener('click', function () {
                const facultyId = this.getAttribute('data-faculty-id');
                // Fetch faculty data from backend
                fetch(`faculty_management/get_faculty_details.php?faculty_id=${facultyId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            alert(data.error);
                            return;
                        }

                        // Populate faculty details in Profile Modal
                        const faculty = data.faculty;
                        document.getElementById('facultyId').value = faculty.id; // Populate hidden id field
                        document.getElementById('facultyFirstName').value = faculty.first_name;
                        document.getElementById('facultyMiddleName').value = faculty.middle_name || '';
                        document.getElementById('facultyLastName').value = faculty.last_name;
                        document.getElementById('facultyEmail').value = faculty.email;
                        document.getElementById('facultyEmployeeId').value = faculty.employee_id;
                        document.getElementById('facultyEmployeeIdText').textContent = faculty.employee_id; // Display in modal
                        document.getElementById('facultyPhone').value = faculty.phone_number || '';
                        document.getElementById('facultyAltEmail').value = faculty.alt_email || '';
                        document.getElementById('facultyDepartment').value = faculty.department;
                        document.getElementById('facultyPosition').value = faculty.faculty_rank;
                        document.getElementById('facultyRole').value = faculty.role || '';
                        document.getElementById('facultyLastUpdated').textContent = faculty.last_updated || 'N/A';
                        document.getElementById('facultyCreatedAt').textContent = faculty.created_at || 'N/A';
                        // document.getElementById('facultyCareerGoals').value = faculty.career_goals || ''; // Commented out

                        // Handle profile picture
                        const profilePic = document.getElementById('facultyProfilePicture');
                        if (faculty.profile_picture && faculty.profile_picture.trim() !== '') {
                            profilePic.src = faculty.profile_picture;
                        } else {
                            profilePic.src = '../../img/cropped-SLSU_Logo-1.png'; // Placeholder image path
                        }

                        // Reset form validation states
                        const editFacultyForm = document.getElementById('editFacultyForm');
                        editFacultyForm.classList.remove('was-validated');
                    })
                    .catch(error => {
                        console.error('Error fetching faculty data:', error);
                        alert('Failed to load faculty profile.');
                    });
            });
        });

        // Handle Edit Faculty Form Submission
        document.getElementById('editFacultyForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const form = this;

            if (!form.checkValidity()) {
                e.stopPropagation();
                form.classList.add('was-validated');
                return;
            }

            const formData = new FormData(form);

            fetch('faculty_management/edit_faculty_profile.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.success);
                    location.reload();
                } else {
                    alert(data.error);
                }
            })
            .catch(error => {
                console.error('Error editing faculty profile:', error);
                alert('Failed to edit faculty profile.');
            });
        });
    });
    </script>


    <!-- Profile Change Requests and Logs -->
    <script>
        $(document).ready(function() {
        // Initialize variables
        let requestCurrentPage = 1;
        let requestTotalPages = 1;
        let logCurrentPage = 1;
        let logTotalPages = 1;

        // Function to fetch Profile Change Requests
        function fetchRequests(page = 1, filter = '', sort = 'desc') {
            $.ajax({
                url: 'faculty_management/get_profile_change_requests.php',
                type: 'GET',
                data: {
                    page: page,
                    filter: filter,
                    sort: sort
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        populateRequestsTable(response.data);
                        setupRequestsPagination(response.total_pages, page);
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('An error occurred while fetching profile change requests.');
                }
            });
        }

        // Function to populate Profile Change Requests table
        function populateRequestsTable(data) {
            const tbody = $('#requestsTable tbody');
            tbody.empty();

            if (data.length === 0) {
                tbody.append('<tr><td colspan="5" class="text-center">No requests found.</td></tr>');
                return;
            }

            data.forEach(function(request) {
                tbody.append(`
                    <tr data-request-id="${request.request_id}" class="request-row">
                        <td>${request.faculty_name}</td>
                        <td>${request.department}</td>
                        <td>${request.rank}</td>
                        <td>${request.submitted_at}</td>
                        <td>${request.status}</td>
                    </tr>
                `);
            });
        }

        // Function to setup Profile Change Requests pagination with dynamic display
        function setupRequestsPagination(totalPages, currentPage) {
            requestTotalPages = totalPages;
            requestCurrentPage = currentPage;
            const pagination = $('#requestsPagination');
            pagination.empty();

            if (totalPages <= 1) return;

            // Define the range of pages to display
            let start = Math.max(currentPage - 2, 1);
            let end = Math.min(currentPage + 2, totalPages);

            // Adjust if we're near the start or end
            if (currentPage <= 3) {
                start = 1;
                end = Math.min(5, totalPages);
            } else if (currentPage >= totalPages - 2) {
                start = Math.max(totalPages - 4, 1);
                end = totalPages;
            }

            // Previous button
            if (currentPage > 1) {
                pagination.append(`
                    <li class="page-item">
                        <a class="page-link request-page-link" href="#" data-page="${currentPage - 1}">&laquo;</a>
                    </li>
                `);
            } else {
                pagination.append(`
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                    </li>
                `);
            }

            // Page numbers
            if (start > 1) {
                pagination.append(`
                    <li class="page-item">
                        <a class="page-link request-page-link" href="#" data-page="1">1</a>
                    </li>
                    ${start > 2 ? '<li class="page-item disabled"><span class="page-link">...</span></li>' : ''}
                `);
            }

            for (let i = start; i <= end; i++) {
                pagination.append(`
                    <li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link request-page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `);
            }

            if (end < totalPages) {
                pagination.append(`
                    ${end < totalPages - 1 ? '<li class="page-item disabled"><span class="page-link">...</span></li>' : ''}
                    <li class="page-item">
                        <a class="page-link request-page-link" href="#" data-page="${totalPages}">${totalPages}</a>
                    </li>
                `);
            }

            // Next button
            if (currentPage < totalPages) {
                pagination.append(`
                    <li class="page-item">
                        <a class="page-link request-page-link" href="#" data-page="${currentPage + 1}">&raquo;</a>
                    </li>
                `);
            } else {
                pagination.append(`
                    <li class="page-item disabled">
                        <span class="page-link">&raquo;</span>
                    </li>
                `);
            }
        }

        // Event listener for Profile Change Requests pagination
        $(document).on('click', '.request-page-link', function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            const filter = $('#requestFilter').val();
            const sort = $('#requestSort').val();
            fetchRequests(page, filter, sort);
        });

        // Event listener for Profile Change Requests filter and sort
        $('#requestFilter, #requestSort').on('change', function() {
            const filter = $('#requestFilter').val();
            const sort = $('#requestSort').val();
            fetchRequests(1, filter, sort);
        });

        // Function to fetch Logs
        function fetchLogs(page = 1, filter = '', sort = 'desc') {
            $.ajax({
                url: 'faculty_management/get_logs.php',
                type: 'GET',
                data: {
                    page: page,
                    filter: filter,
                    sort: sort
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        populateLogsTable(response.data);
                        setupLogsPagination(response.total_pages, page);
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('An error occurred while fetching logs.');
                }
            });
        }

        // Function to populate Logs table
        function populateLogsTable(data) {
            const tbody = $('#logsTable tbody');
            tbody.empty();

            if (data.length === 0) {
                tbody.append('<tr><td colspan="5" class="text-center">No logs found.</td></tr>');
                return;
            }

            data.forEach(function(log) {
                tbody.append(`
                    <tr data-log-id="${log.log_id}" class="log-row">
                        <td>${log.faculty_name}</td>
                        <td>${log.department}</td>
                        <td>${log.rank}</td>
                        <td>${log.changed_at}</td>
                        <td>${log.changed_by}</td>
                    </tr>
                `);
            });
        }

        // Function to setup Logs pagination with dynamic display
        function setupLogsPagination(totalPages, currentPage) {
            logTotalPages = totalPages;
            logCurrentPage = currentPage;
            const pagination = $('#logsPagination');
            pagination.empty();

            if (totalPages <= 1) return;

            // Define the range of pages to display
            let start = Math.max(currentPage - 2, 1);
            let end = Math.min(currentPage + 2, totalPages);

            // Adjust if we're near the start or end
            if (currentPage <= 3) {
                start = 1;
                end = Math.min(5, totalPages);
            } else if (currentPage >= totalPages - 2) {
                start = Math.max(totalPages - 4, 1);
                end = totalPages;
            }

            // Previous button
            if (currentPage > 1) {
                pagination.append(`
                    <li class="page-item">
                        <a class="page-link log-page-link" href="#" data-page="${currentPage - 1}">&laquo;</a>
                    </li>
                `);
            } else {
                pagination.append(`
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                    </li>
                `);
            }

            // Page numbers
            if (start > 1) {
                pagination.append(`
                    <li class="page-item">
                        <a class="page-link log-page-link" href="#" data-page="1">1</a>
                    </li>
                    ${start > 2 ? '<li class="page-item disabled"><span class="page-link">...</span></li>' : ''}
                `);
            }

            for (let i = start; i <= end; i++) {
                pagination.append(`
                    <li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link log-page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `);
            }

            if (end < totalPages) {
                pagination.append(`
                    ${end < totalPages - 1 ? '<li class="page-item disabled"><span class="page-link">...</span></li>' : ''}
                    <li class="page-item">
                        <a class="page-link log-page-link" href="#" data-page="${totalPages}">${totalPages}</a>
                    </li>
                `);
            }

            // Next button
            if (currentPage < totalPages) {
                pagination.append(`
                    <li class="page-item">
                        <a class="page-link log-page-link" href="#" data-page="${currentPage + 1}">&raquo;</a>
                    </li>
                `);
            } else {
                pagination.append(`
                    <li class="page-item disabled">
                        <span class="page-link">&raquo;</span>
                    </li>
                `);
            }
        }

        // Event listener for Logs pagination
        $(document).on('click', '.log-page-link', function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            const filter = $('#logFilter').val();
            const sort = $('#logSort').val();
            fetchLogs(page, filter, sort);
        });

        // Event listener for Logs filter and sort
        $('#logFilter, #logSort').on('change', function() {
            const filter = $('#logFilter').val();
            const sort = $('#logSort').val();
            fetchLogs(1, filter, sort);
        });

        // Initial fetch
        fetchRequests();
        fetchLogs();

        // Handle click on Profile Change Request row to open modal
        $(document).on('click', '.request-row', function() {
            const requestId = $(this).data('request-id');
            fetchRequestDetails(requestId);
        });

        // Function to fetch Profile Change Request details
        function fetchRequestDetails(requestId) {
            $.ajax({
                url: 'faculty_management/get_request_details.php',
                type: 'GET',
                data: { request_id: requestId },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        populateRequestModal(response.data);
                        const requestModal = new bootstrap.Modal(document.getElementById('requestModal'));
                        requestModal.show();
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('An error occurred while fetching request details.');
                }
            });
        }

        // Function to populate Profile Change Request modal
        function populateRequestModal(data) {
            $('#modalRequestId').text(data.request_id);
            $('#modalFacultyName').text(data.faculty_name);
            $('#modalDepartment').text(data.department);
            $('#modalRank').text(data.rank);
            $('#modalSubmittedAt').text(data.submitted_at);
            $('#modalStatus').text(data.status);
            $('#modalAdminMessage').text(data.admin_message || 'N/A');

            // Populate Requested Changes
            const changesDiv = $('#modalRequestedChanges');
            changesDiv.empty();
            const changes = JSON.parse(data.requested_changes);
            for (const [field, value] of Object.entries(changes)) {
                changesDiv.append(`<p><strong>${capitalizeFirstLetter(field.replace('_', ' '))}:</strong> ${value}</p>`);
            }

            // Set data attribute for approve/deny buttons
            $('#approveRequestBtn, #denyRequestBtn').data('request-id', data.request_id);
        }

        // Handle Approve button click
        $('#approveRequestBtn').on('click', function() {
            const requestId = $(this).data('request-id');
            handleRequestAction(requestId, 'approve');
        });

        // Handle Deny button click
        $('#denyRequestBtn').on('click', function() {
            const requestId = $(this).data('request-id');
            handleRequestAction(requestId, 'deny');
        });

        // Function to handle Approve/Deny actions
        function handleRequestAction(requestId, action) {
            let adminMessage = '';
            if (action === 'deny') {
                adminMessage = prompt('Please provide a reason for denying the request:');
                if (adminMessage === null) return; // User cancelled
                if (adminMessage.trim() === '') {
                    alert('Reason is required to deny the request.');
                    return;
                }
            }

            $.ajax({
                url: 'faculty_management/manage_change_request.php',
                type: 'POST',
                data: {
                    request_id: requestId,
                    action: action,
                    admin_message: adminMessage
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        // Refresh the tables
                        fetchRequests(requestCurrentPage, $('#requestFilter').val(), $('#requestSort').val());
                        fetchLogs(logCurrentPage, $('#logFilter').val(), $('#logSort').val());
                        // Hide the modal
                        $('#requestModal').modal('hide');
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('An error occurred while processing the request.');
                }
            });
        }

        // Handle click on Log row to open modal
        $(document).on('click', '.log-row', function() {
            const logId = $(this).data('log-id');
            fetchLogDetails(logId);
        });

        // Function to fetch Log details
        function fetchLogDetails(logId) {
            $.ajax({
                url: 'faculty_management/get_log_details.php',
                type: 'GET',
                data: { log_id: logId },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        populateLogModal(response.data);
                        const logModal = new bootstrap.Modal(document.getElementById('logModal'));
                        logModal.show();
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('An error occurred while fetching log details.');
                }
            });
        }

        // Function to populate Logs modal
        function populateLogModal(data) {
            $('#modalLogId').text(data.log_id);
            $('#modalLogFacultyName').text(data.faculty_name);
            $('#modalLogDepartment').text(data.department);
            $('#modalLogRank').text(data.rank);
            $('#modalLogChangedAt').text(data.changed_at);
            $('#modalLogChangedBy').text(data.changed_by);

            // Populate Changes
            const changesDiv = $('#modalLogChanges');
            changesDiv.empty();
            const changes = JSON.parse(data.changed_fields);
            if (changes && changes.fields) {
                for (const [field, change] of Object.entries(changes.fields)) {
                    changesDiv.append(`<p><strong>${capitalizeFirstLetter(field.replace('_', ' '))}:</strong> ${change.old} &rarr; ${change.new}</p>`);
                }
            } else if (changes && changes.action === 'Approved') {
                changesDiv.append('<p><em>Request Approved.</em></p>');
            } else if (changes && changes.action === 'Denied') {
                changesDiv.append('<p><em>Request Denied.</em></p>');
            } else {
                changesDiv.append('<p>No detailed changes available.</p>');
            }
        }

        // Helper function to capitalize first letter
        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    });
    </script>

    </body><!--end::Body-->
</html>
