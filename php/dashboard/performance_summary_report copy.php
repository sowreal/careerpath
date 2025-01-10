<?php
include('../session.php'); // Ensure the user is logged in
include('../connection.php'); // Include the database connection
require_once '../config.php';

// Define variables for Page Titles and Sidebar Active effects
$pageTitle = 'Career Path | Performance Report';
$activePage = 'PSR';

// Check if the user is a Faculty Member
if ($_SESSION['role'] != 'Permanent Instructor' && $_SESSION['role'] != 'Contract of Service Instructor') { 
    // Check if the user is Human Resources
    if ($_SESSION['role'] == 'Human Resources') { 
        // Redirect to HR dashboard
        header('Location: ' . BASE_URL . '/php/dashboard_HR/dashboard_HR.php'); 
        exit(); 
    } else { 
            // **Start of Session Destruction** 
            // Unset all session variables 
            $_SESSION = array(); 

            // Kill the session, also delete the session cookie. 
            if (ini_get("session.use_cookies")) { 
                $params = session_get_cookie_params(); 
                setcookie(session_name(), '', time() - 42000, 
                $params["path"], $params["domain"], 
                $params["secure"], $params["httponly"] 
            ); 
        } 
        
        // Finally, destroy the session. 
        session_destroy(); 
        // Notify the user and redirect to the login page 
        echo "<script> 
        alert('Your account is not authorized. Redirecting to login page.'); 
        window.location.href = '" . BASE_URL . "/php/login.php';
        </script>"; 
        exit(); 
    } 
} else { 
    // Faculty member's sidebar is set, proceed with their dashboard logic 
    $sidebarFile = BASE_URL . 'php/includes/sidebar_faculty.php'; 
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once('../includes/header.php');?>
</head>


<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
    <div class="app-wrapper"> 
        <!--begin::Header-->
            <?php require_once('../includes/navbar.php');?>
        <!--end::Header--> 
        
        <!--begin::Sidebar-->
            <?php require_once('../includes/sidebar_faculty.php');?>
        <!--end::Sidebar--> 
        

        <!--begin::App Main-->
        <main class="app-main">
            <!--begin::App Content Header-->
            <div class="app-content-header">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Performance Summary Reports</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Performance Summary
                                </li>
                            </ol>
                        </div>
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div> 
            <!--end::App Content Header-->

            <!--begin::App Content-->
            <div class="app-content">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!-- Performance Summary Content Goes Here -->
                    <!--begin::Row-->
                    <div class="row g-4 mb-4">
                        <!-- Career Goals Section -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h5 class="card-title">Career Goals Completed</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            Research Papers Published
                                            <span class="badge text-bg-success float-end">3/5</span>
                                        </li>
                                        <li class="list-group-item">
                                            Training Sessions Completed
                                            <span class="badge text-bg-warning float-end">4/6</span>
                                        </li>
                                        <li class="list-group-item">
                                            Evaluations Completed
                                            <span class="badge text-bg-danger float-end">2/4</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Evaluation History Section -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h5 class="card-title">Evaluation History</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="evaluationChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div> <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row g-4 mb-4">
                        <!-- Training History Section -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h5 class="card-title">Training History</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            Advanced Research Methods
                                            <span class="badge text-bg-success float-end">Completed</span>
                                        </li>
                                        <li class="list-group-item">
                                            Digital Teaching Tools
                                            <span class="badge text-bg-warning float-end">In Progress</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Publications Section -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h5 class="card-title">Publications</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            Artificial Intelligence in Education
                                            <span class="badge text-bg-success float-end">Published</span>
                                        </li>
                                        <li class="list-group-item">
                                            Machine Learning for Beginners
                                            <span class="badge text-bg-warning float-end">In Review</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div> <!--end::App Content-->
        </main>

        <!--end::App Main-->
        
        
        
        <!--begin::Footer-->   
        <?php require_once('../includes/footer.php');?>
        <!--end::Footer-->
    </div> 
    <!--end::App Wrapper--> 
    
        
    <!--begin::Script--> 
    <!--begin::Third Party Plugin(OverlayScrollbars)-->       
        <?php require_once('../includes/dashboard_default_scripts.php');?>

    <!-- Mock Data For Evaluation History -->
    <script>
        // Mock data for Evaluation History
        const evalLabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July'];
        const evalData = {
            labels: evalLabels,
            datasets: [{
                label: 'Completed Evaluations',
                backgroundColor: 'rgba(75, 192, 192, 0.5)', // Green shades
                borderColor: 'rgba(75, 192, 192, 1)',
                data: [2, 3, 4, 2, 5, 3, 4],
                fill: true
            }, {
                label: 'Pending Evaluations',
                backgroundColor: 'rgba(255, 99, 132, 0.5)', // Red shades
                borderColor: 'rgba(255, 99, 132, 1)',
                data: [1, 1, 2, 3, 1, 2, 3],
                fill: true
            }]
        };

        const evalConfig = {
            type: 'bar', // Bar chart for evaluations
            data: evalData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Evaluation History Over Time'
                    }
                }
            }
        };

        // Render the chart
        const ctx = document.getElementById('evaluationChart').getContext('2d');
        new Chart(ctx, evalConfig);
    </script>

</body>
</html>


