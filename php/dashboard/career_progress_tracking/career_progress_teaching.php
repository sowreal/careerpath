<?php
require_once '../../session.php';
require_once '../../connection.php';
require_once '../../config.php';

// Define variables for Page Titles and Sidebar Active effects
$pageTitle = 'Career Path | Career Tracking';
$activePage = 'CPT_Teaching';

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
                window.location.href = '../../login.php';
              </script>";
        exit();
    }
    // If the user is part of Human Resources, redirect to their dashboard
    header('Location: ../../dashboard_HR/dashboard_HR.php'); // Redirect to HR dashboard if not a faculty member
    exit();
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
            <div class="container-fluid">

                <!-- Standalone Header -->
                <div class="app-content-header">
                    <div class="container-fluid">
                        <div class="row align-items-start">
                            <div class="col-sm-6 mb-5">
                                <!-- Change Evaluation Number dynamically-->
                                <h3 class="mb-2"><strong>KRA I:</strong> Teaching Performance<br></h3>
                                <h4 class="mb-0"><span id="evaluation-number">Evaluation #: <small><i class="text-danger">Please select evaluation number.</i></small></span></h4>
                            </div>
                            <div class="col-sm-6 pe-4 mt-4">
                                <div class="d-flex justify-content-end">
                                    <!-- Button for Select Evaluation Modal -->
                                    <button id="select-evaluation-btn" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#evaluationModal">
                                        Select Evaluation
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hidden input to store request_id -->
                <input type="hidden" id="request-id" name="request_id" value="">

                <!-- KRA I Content -->
                <?php //require_once BASE_PATH . '/php/includes/career_progress_tracking/teaching/kra1.php';?> <!-- Removed KRA 1 Summary for now-->

                <!-- Container for Criteria -->
                <div class="card mt-4">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="kra-tabs" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active bg-success text-white" id="tab-criterion-a" data-bs-toggle="tab" data-bs-target="#criterion-a" type="button" role="tab" data-navigation="true">
                                    Criterion A
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="tab-criterion-b" data-bs-toggle="tab" data-bs-target="#criterion-b" type="button" role="tab" data-navigation="true">
                                    Criterion B
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="tab-criterion-c" data-bs-toggle="tab" data-bs-target="#criterion-c" type="button" role="tab" data-navigation="true">
                                    Criterion C
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Criterions section -->
                    <div class="card-body">
                        <div class="tab-content" id="kra-tab-content">
                            <!-- Tab 1: Criterion A: Teaching Effectiveness -->
                            <?php require_once BASE_PATH . '/php/includes/career_progress_tracking/teaching/criterion_a.php'; ?> 
                            <!-- Tab 2: Criterion B: Curriculum & Material Development -->
                            <?php require_once BASE_PATH . '/php/includes/career_progress_tracking/teaching/criterion_b.php'; ?> 
                            <!-- Tab 3: Criterion C: Thesis & Mentorship Services -->
                            <?php require_once BASE_PATH . '/php/includes/career_progress_tracking/teaching/criterion_c.php'; ?> 
                        </div>
                    </div>

                </div>

                <!-- MODAL SECTION -->
                <?php require_once BASE_PATH . '/php/includes/career_progress_tracking/teaching/modals.php'; ?>

            </div>
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
    <!-- Include Criterion B-specific JS -->
    <script src="<?php echo BASE_URL; ?>/php/includes/career_progress_tracking/teaching/js/criterion_b.js"></script>
    <!-- Include Criterion C-specific JS -->
    <script src="<?php echo BASE_URL; ?>/php/includes/career_progress_tracking/teaching/js/criterion_c.js"></script>

</body>
</html>
