<?php
include('../session.php'); // Ensure the user is logged in
include('../connection.php'); // Include the database connection

// Define variables for Page Titles and Sidebar Active effects
$pageTitle = 'Career Path | Faculty Profiles';
$activePage = 'Faculty Management';

// Check user role
if ($_SESSION['role'] != 'Human Resources') {
    // Check if the user is a Faculty Member
    if ($_SESSION['role'] != 'Regular Instructor' && $_SESSION['role'] != 'Contract of Service Instructor') {
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
$sql = "SELECT id, first_name, middle_name, last_name, department, faculty_rank, email FROM users WHERE role IN ('Regular Instructor', 'Contract of Service Instructor')";
$count_sql = "SELECT COUNT(*) FROM users WHERE role IN ('Regular Instructor', 'Contract of Service Instructor')";

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
    <style>
        #profileChangeRequestsTable tbody tr:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }
    </style>
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
            <!-- Faculty Management Section-->
            <div class="container-fluid">
                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center my-4">
                    <h1 class="h3 mb-0 text-gray-800">Faculty Management</h1>
                </div>

                <!-- Search and Filter Section -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Search Bar -->
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="searchInput" placeholder="Search by name or email">
                            </div>

                            
                            <!-- Department Filter -->
                            <div class="col-md-3">
                                <select class="form-select" id="departmentFilter">
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
                                <select class="form-select" id="facultyRankFilter">
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
                            <!-- <div class="col-md-2">
                                <button type="submit" class="btn btn-success w-100">Search</button>
                            </div> -->
                        </div>
                    </div>
                </div>

                <!-- Faculty List Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="facultyMembersTable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Rank</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Faculty data will be injected here via AJAX -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <nav aria-label="Page navigation" class="faculty-pagination-container">
                            <ul class="pagination faculty-pagination" id="facultyPagination">
                                <!-- Pagination items will be injected here via AJAX -->
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Profile Change Requests Section -->
            <div class="container-fluid">
                <div class="card mt-4">
                    <div class="card-header">
                        <h3>Profile Change Requests</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <!-- Name Search -->
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="nameSearch" placeholder="Search by Name">
                            </div>
                            <!-- Department Filter -->
                            <div class="col-md-3">
                                <select class="form-select" id="requestDepartmentFilter">
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
                            <div class="col-md-2">
                                <select class="form-select" id="requestFacultyRankFilter">
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
                            <!-- Date/Time Filter (Date Sort Filter) -->
                            <div class="col-md-2">
                                <select class="form-select" id="dateSortFilter">
                                    <option value="oldest">Oldest First</option>
                                    <option value="newest">Newest First</option>
                                </select>
                            </div>
                            <!-- Status Filter -->
                            <div class="col-md-2">
                                <select class="form-select" id="statusFilter">
                                    <option value="">All Statuses</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Approved">Approved</option>
                                    <option value="Denied">Denied</option>
                                </select>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-hover" id="profileChangeRequestsTable">
                                <thead>
                                    <tr>
                                        <th>Request ID</th>
                                        <th>Faculty Name</th>
                                        <th>Department</th>
                                        <th>Rank</th>
                                        <th>Date of Request</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be inserted here via AJAX -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination" id="pagination">
                                <!-- Pagination items will be inserted here via AJAX -->
                            </ul>
                        </nav>
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
                                                <div class="invalid-feedback">Please provide a first name.</div>
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
                                                <div class="invalid-feedback">Please provide a last name.</div>
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
                                                    <option value="Regular Instructor">Regular Instructor</option>
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
                                                        <option value="Human Resources Management Office">Human Resources Management Office</option>
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

            <!-- Modal for Request Details -->
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
                            <textarea id="modalAdminMessage" class="form-control" rows="3"></textarea>
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
        
    <!-- Faculty Management Section -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Function to fetch faculty members based on filters
        function fetchFacultyMembers(page = 1) {
            const searchInput = document.getElementById('searchInput');
            const departmentFilter = document.getElementById('departmentFilter');
            const facultyRankFilter = document.getElementById('facultyRankFilter');

            const search = searchInput ? searchInput.value : '';
            const department = departmentFilter ? departmentFilter.value : '';
            const faculty_rank = facultyRankFilter ? facultyRankFilter.value : '';

            const params = new URLSearchParams({
                search: search,
                department: department,
                faculty_rank: faculty_rank,
                page: page
            });

            fetch('faculty_management/get_faculty_members.php?' + params.toString())
                .then(response => response.json())
                .then(data => {
                    // Update the faculty members table
                    const tableBody = document.querySelector('#facultyMembersTable tbody');
                    if (tableBody) {
                        tableBody.innerHTML = data.table_data;
                    }

                    // Update the pagination
                    const paginationContainer = document.getElementById('facultyPagination');
                    if (paginationContainer) {
                        paginationContainer.innerHTML = data.pagination;
                    }

                    // Re-attach event listeners for "View Profile" buttons
                    attachViewProfileButtons();
                })
                .catch(error => {
                    console.error('Error fetching faculty members:', error);
                });
        }

        // Function to attach event listeners to "View Profile" buttons
        function attachViewProfileButtons() {
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
                            document.getElementById('facultyId').value = faculty.id; // Hidden input
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

                            // Handle profile picture
                            const profilePic = document.getElementById('facultyProfilePicture');
                            if (faculty.profile_picture && faculty.profile_picture.trim() !== '') {
                                // Construct the correct path to the profile picture
                                profilePic.src = '../../uploads/' + faculty.profile_picture;
                            } else {
                                profilePic.src = '../../img/cropped-SLSU_Logo-1.png'; // Placeholder image path
                            }

                            // Reset form validation states
                            const editFacultyForm = document.getElementById('editFacultyForm');
                            editFacultyForm.classList.remove('was-validated');

                            // Show the modal
                            $('#profileModal').modal('show');
                        })
                        .catch(error => {
                            console.error('Error fetching faculty data:', error);
                            alert('Failed to load faculty profile.');
                        });
                });
            });
        }

        // Attach event listeners to filters
        const searchInput = document.getElementById('searchInput');
        const departmentFilter = document.getElementById('departmentFilter');
        const facultyRankFilter = document.getElementById('facultyRankFilter');

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                fetchFacultyMembers(1);
            });
        }

        if (departmentFilter) {
            departmentFilter.addEventListener('change', function () {
                fetchFacultyMembers(1);
            });
        }

        if (facultyRankFilter) {
            facultyRankFilter.addEventListener('change', function () {
                fetchFacultyMembers(1);
            });
        }

        // Handle pagination clicks using event delegation
        document.addEventListener('click', function (e) {
            if (e.target.matches('.faculty-pagination a')) {
                e.preventDefault();
                const page = e.target.getAttribute('data-page');
                fetchFacultyMembers(page);
            }
        });

        // Fetch initial faculty members
        fetchFacultyMembers();

        // Attach initial event listeners to "View Profile" buttons
        attachViewProfileButtons();

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
                    // Refresh the faculty list
                    fetchFacultyMembers();
                    // Close the modal
                    $('#profileModal').modal('hide');
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



    <!-- Profile Change Requests -->
    <script>
    $(document).ready(function() {
        // Fetch initial data with default sorting by oldest
        fetchProfileChangeRequests(1);

        // Event handlers for filters and search
        $('#nameSearch, #requestDepartmentFilter, #requestFacultyRankFilter, #statusFilter, #dateSortFilter').on('input change', function() {
            fetchProfileChangeRequests(1);
        });

        // Handle pagination clicks using event delegation
        $(document).on('click', '.pagination a.page-link', function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            fetchProfileChangeRequests(page);
        });

        // Function to fetch data
        function fetchProfileChangeRequests(page) {
            var name = $('#nameSearch').val();
            var department = $('#requestDepartmentFilter').val();
            var faculty_rank = $('#requestFacultyRankFilter').val();
            var status = $('#statusFilter').val();
            var date_sort = $('#dateSortFilter').val(); // Get the date_sort value

            $.ajax({
                url: 'faculty_management/get_profile_change_requests.php',
                type: 'GET',
                data: {
                    name: name,
                    department: department,
                    faculty_rank: faculty_rank,
                    status: status,
                    date_sort: date_sort,
                    page: page
                },
                dataType: 'json',
                success: function(response) {
                    // Update table
                    $('#profileChangeRequestsTable tbody').html(response.table_data);
                    // Update pagination
                    $('#pagination').html(response.pagination);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        // Event handler for table row click
        $(document).on('click', '#profileChangeRequestsTable tbody tr', function() {
            var requestId = $(this).data('request-id');
            // Fetch request details and show modal
            fetchRequestDetails(requestId);
        });

        // Function to fetch request details
        function fetchRequestDetails(requestId) {
            $.ajax({
                url: 'faculty_management/get_request_details.php',
                type: 'GET',
                data: {
                    request_id: requestId
                },
                dataType: 'json',
                success: function(response) {
                    if (!response.success) {
                        alert(response.message);
                        return;
                    }
                    // Populate modal fields
                    $('#modalRequestId').text(response.request_id);
                    $('#modalFacultyName').text(response.faculty_name);
                    $('#modalDepartment').text(response.department);
                    $('#modalRank').text(response.rank);
                    $('#modalSubmittedAt').text(response.submitted_at);
                    $('#modalStatus').text(response.status);
                    $('#modalAdminMessage').val(response.admin_message);

                    // Display requested changes
                    var requestedChangesHtml = '';
                    $.each(response.requested_changes, function(field, values) {
                        requestedChangesHtml += '<p><strong>' + field.replace('_', ' ') + ':</strong> ' + values.old_value + ' &rarr; ' + values.new_value + '</p>';
                    });
                    $('#modalRequestedChanges').html(requestedChangesHtml);

                    // Disable buttons and textarea if request is processed
                    if (response.status != 'Pending') {
                        $('#approveRequestBtn').prop('disabled', true);
                        $('#denyRequestBtn').prop('disabled', true);
                        $('#modalAdminMessage').prop('disabled', true);
                    } else {
                        $('#approveRequestBtn').prop('disabled', false);
                        $('#denyRequestBtn').prop('disabled', false);
                        $('#modalAdminMessage').prop('disabled', false);
                    }

                    // Show modal
                    $('#requestModal').modal('show');

                    // Set data attribute for approve/deny buttons
                    $('#approveRequestBtn').data('request-id', requestId);
                    $('#denyRequestBtn').data('request-id', requestId);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        // Event handler for Approve button
        $('#approveRequestBtn').click(function() {
            var requestId = $(this).data('request-id');
            processRequest(requestId, 'Approved');
        });

        // Event handler for Deny button
        $('#denyRequestBtn').click(function() {
            var requestId = $(this).data('request-id');
            processRequest(requestId, 'Denied');
        });

        // Function to process request (approve/deny)
        function processRequest(requestId, action) {
            var adminMessage = $('#modalAdminMessage').val();

            $.ajax({
                url: 'faculty_management/process_change_request.php',
                type: 'POST',
                data: {
                    request_id: requestId,
                    action: action,
                    admin_message: adminMessage
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('Request ' + action.toLowerCase() + ' successfully.');
                        $('#requestModal').modal('hide');
                        // Refresh data
                        fetchProfileChangeRequests(1);
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });
    </script>


    </body><!--end::Body-->
</html>
