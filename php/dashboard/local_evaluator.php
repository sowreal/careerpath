<?php
require_once '../session.php';
require_once '../connection.php';
require_once '../config.php';

// Define variables for Page Titles and Sidebar Active effects
$pageTitle = 'Career Path | Local Evaluator';
$activePage = 'LocalEvaluatorTools';

// Check if the user is a Faculty Member
if ($_SESSION['role'] != 'Permanent Instructor' && $_SESSION['role'] != 'Contract of Service Instructor') {
    // Check if the user is Human Resources
    if ($_SESSION['role'] != 'Human Resources') {
        // **Start of Session Destruction**
        // Unset all session variables
        $_SESSION = array();

        // Kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        // Finally, destroy the session.
        session_destroy();
        // **End of Session Destruction**

        // Notify the user and redirect to the login page
        echo "<script>
                alert('Your account is not authorized. Redirecting to login page.');
                window.location.href = '../login.php';
              </script>";
        exit();
    }
    // If the user is part of Human Resources, redirect to their dashboard
    header('Location: ../dashboard_HR/dashboard_HR.php'); // Redirect to HR dashboard if not a faculty member
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
<html lang="en">
<head>
    <?php require_once BASE_PATH . '/php/includes/header.php'; ?>
    <!-- Pass user ID to JavaScript -->
    <script>
        const userId = <?php echo json_encode($_SESSION['user_id']); ?>;
    </script>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
    <div class="app-wrapper"> 
        <!--begin::Header-->
        <?php require_once BASE_PATH . '/php/includes/navbar.php'; ?>
        <!--end::Header--> 
        
        <!--begin::Sidebar-->
        <?php require_once BASE_PATH . '/php/includes/sidebar_faculty.php'; ?> 
        <!--end::Sidebar--> 

        <!--begin::App Main-->
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
                                        
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success">Save Changes</button>
                                        </div>
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
            <?php require_once BASE_PATH . '/php/includes/footer.php'; ?> 
        <!--end::Footer-->
    </div> 
    <!--end::App Wrapper--> 

    <!--begin::Script--> 
    <?php require_once BASE_PATH . '/php/includes/dashboard_default_scripts.php'; ?> 

    <!-- Script Links for Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    
    <!-- Career Progress Teaching Scripts -->
    <script src="<?php echo BASE_URL; ?>/php/includes/career_progress_tracking/teaching/js/teaching.js"></script>
    <!-- Include Criterion A-specific JS -->
    <script src="<?php echo BASE_URL; ?>/php/includes/career_progress_tracking/teaching/js/criterion_a.js"></script>
    <!-- Local eval scripts -->

    <!-- Faculty Management Section -->
    <script src="<?php echo BASE_URL; ?>/php/dashboard_HR/js/faculty_management.js"></script>
</body>
</html>
