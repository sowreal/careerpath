<?php
require_once '../../session.php';
require_once '../../connection.php';
require_once '../../config.php';

// Define variables for Page Titles and Sidebar Active effects
$pageTitle = 'Career Path | Career Tracking';
$activePage = 'CPT_Research';

// Check if the user is a Faculty Member
if ($_SESSION['role'] != 'Regular Instructor' && $_SESSION['role'] != 'Contract of Service Instructor') {
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
    <?php require_once('../../includes/header.php') ?>
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
                                <h3 class="mb-2"><strong>KRA II:</strong> Research, Innovation, and Creative Work<br></h3>
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
                

                <!-- KRA II Content ======== REMOVED FOR NOW-->
                <?php // require_once BASE_PATH . '/php/includes/career_progress_tracking/research/kra2.php';?> 

                <!-- Container for Criteria -->
                <div class="card mt-4">
                    <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="kra-tabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active bg-success text-white" id="tab-criterion-a" data-bs-toggle="tab" data-bs-target="#criterion-a" type="button" role="tab">
                                Criterion A
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="tab-criterion-b" data-bs-toggle="tab" data-bs-target="#criterion-b" type="button" role="tab" data-navigation="true">
                                Criterion B
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="tab-criterion-c" data-bs-toggle="tab" data-bs-target="#criterion-c" type="button" role="tab">
                                Criterion C
                            </button>
                        </li>
                    </ul>

                    </div>

                    <!-- Criterions section -->
                    <div class="card-body">
                        <div class="tab-content" id="kra-tab-content">
                            <!-- Tab 1: Criterion A: RESEARCH OUTPUTS -->
                            <?php require_once BASE_PATH . '/php/includes/career_progress_tracking/research/kra2_criterion_a.php'; ?> 
                            <!-- Tab 2: Criterion B: INVENTIONS  -->
                            <?php require_once BASE_PATH . '/php/includes/career_progress_tracking/research/kra2_criterion_b.php'; ?> 
                            <!-- Tab 3: Criterion C: Creative Works -->
                            <?php require_once BASE_PATH . '/php/includes/career_progress_tracking/research/kra2_criterion_c.php'; ?> 
                        </div>
                    </div>

                </div>

                <!-- MODAL SECTION -->
                <?php require_once BASE_PATH . '/php/includes/career_progress_tracking/research/kra2_modals.php'; ?>

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

    
    <!-- Career Progress Research Scripts -->
    <!-- Career Progress Research Scripts -->
    
    <!-- Include Criterion A-specific JS -->
     <!-- Include research.js LAST -->
    <script src="<?php echo BASE_URL; ?>/php/includes/career_progress_tracking/research/js/research.js"></script>
    <script src="<?php echo BASE_URL; ?>/php/includes/career_progress_tracking/research/js/kra2_criterion_a.js"></script>
    <!-- Include Criterion B-specific JS (Corrected Path) -->

    <!-- Include Criterion C-specific JS -->
     
    <script>
        // Initialize CriterionA in the global scope
        window.CriterionA = {
            fetchCriterionA: function(requestId) {
                // Your logic here to fetch and display data for Criterion A
                console.log("Fetching data for Criterion A, Request ID:", requestId);
                // You can use AJAX to fetch data from the server
            }
        };
    </script>
    

</body>
</html>


