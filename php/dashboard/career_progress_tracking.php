<?php
include('../session.php'); // Ensure the user is logged in
include('../connection.php'); // Include the database connection
require_once '../config.php';

// Define variables for Page Titles and Sidebar Active effects
$pageTitle = 'Career Path | Career Tracking';
$activePage = 'CPT';

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
                window.location.href = '../login.php';
              </script>";
        exit();
    }
    // If the user is part of Human Resources, redirect to their dashboard
    header('Location: dashboard_HR.php'); // Redirect to HR dashboard if not a faculty member
    exit();
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once('../includes/header.php') ?>
</head>


<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
    <div class="app-wrapper"> 
        <!--begin::Header-->
        <?php require_once('../includes/navbar.php'); ?>
        <!--end::Header--> 
        
        <!--begin::Sidebar-->
        <?php require_once('../includes/sidebar_faculty.php'); ?> 
        <!--end::Sidebar--> 
        

        <!--begin::App Main-->
        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Career Progress Tracking</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Career Progress Tracking</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Two Column Layout -->
            <div class="container-fluid mt-4">
                <div class="row">
                    <!-- First Column: Career Goals & Milestone Achievements -->
                    <div class="col-md-6">
                        <!-- Career Goals Section -->
                        <div class="card mb-4">
                            <div class="card-header bg-success text-white">
                                <h5>Career Goals</h5>
                            </div>
                            <div class="card-body">
                                <div class="progress-group">
                                    Research Papers Published
                                    <span class="float-end"><b>2</b>/5</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-primary" style="width: 40%;"></div>
                                    </div>
                                </div>

                                <div class="progress-group">
                                    Training Sessions Completed
                                    <span class="float-end"><b>3</b>/4</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-danger" style="width: 75%;"></div>
                                    </div>
                                </div>

                                <div class="progress-group">
                                    Evaluations Completed
                                    <span class="float-end"><b>1</b>/3</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" style="width: 33%;"></div>
                                    </div>
                                </div>

                                <div class="progress-group">
                                    Workshops Attended
                                    <span class="float-end"><b>2</b>/4</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-warning" style="width: 50%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Milestone Achievements Section -->
                        <div class="col-md-12">
                            <div class="card mb-4">
                                <div class="card-header bg-success text-white">
                                    <h5>Milestone Achievements</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        <a href="#" class="text-decoration-none text-dark" data-bs-toggle="modal" data-bs-target="#achievementModal"
                                            data-title="Published Research Paper"
                                            data-date="October 2024"
                                            data-summary="Advances in AI Research. A comprehensive study on the future of AI in education and healthcare.">
                                            <li class="list-group-item achievement-item bg-light-hover cursor-pointer">
                                                <strong>Published Research Paper</strong> - Advances in AI Research (October 2024)
                                            </li>
                                        </a>
                                        <a href="#" class="text-decoration-none text-dark" data-bs-toggle="modal" data-bs-target="#achievementModal"
                                            data-title="Completed Training Session"
                                            data-date="September 2024"
                                            data-summary="Completed an advanced training session on teaching techniques in higher education.">
                                            <li class="list-group-item achievement-item bg-light-hover cursor-pointer">
                                                <strong>Completed Training Session</strong> - Advanced Teaching Techniques (September 2024)
                                            </li>
                                        </a>
                                        <a href="#" class="text-decoration-none text-dark" data-bs-toggle="modal" data-bs-target="#achievementModal"
                                            data-title="Received Performance Evaluation"
                                            data-date="July 2024"
                                            data-summary="Received annual performance evaluation based on teaching and research activities.">
                                            <li class="list-group-item achievement-item bg-light-hover cursor-pointer">
                                                <strong>Received Performance Evaluation</strong> - Annual Performance Review (July 2024)
                                            </li>
                                        </a>
                                        <a href="#" class="text-decoration-none text-dark" data-bs-toggle="modal" data-bs-target="#achievementModal"
                                            data-title="Attended Workshop"
                                            data-date="June 2024"
                                            data-summary="Attended a workshop focused on data science applications in education.">
                                            <li class="list-group-item achievement-item bg-light-hover cursor-pointer">
                                                <strong>Attended Workshop</strong> - Data Science for Education (June 2024)
                                            </li>
                                        </a>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="achievementModal" tabindex="-1" aria-labelledby="achievementModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title" id="achievementModalLabel"></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Date:</strong> <span id="achievementDate"></span></p>
                                        <p id="achievementSummary"></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                    <!-- Second Column: Performance Overview -->
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header bg-success text-white">
                                <h5>Performance Overview</h5>
                            </div>
                            <div class="card-body">
                                <p class="text-center"><strong>Career Performance Over Time</strong></p>
                                <div class="chart-container" style="position: relative; width: 100%; height: 300px;">
                                    <canvas id="performanceChart" style="width: 100%; height: 100%;"></canvas>
                                </div>
                            </div>
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
    <?php require_once('../includes/dashboard_default_scripts.php'); ?> 

    <!-- JavaScript to enable hover effect -->
    <script>
        document.querySelectorAll('.achievement-item').forEach(function (item) {
            item.addEventListener('mouseenter', function () {
                item.classList.add('shadow', 'bg-light');
            });
            item.addEventListener('mouseleave', function () {
                item.classList.remove('shadow', 'bg-light');
            });
        });
    </script>

    <!-- Script to render chart.js for Performance Overview -->
    <script>
        // Script to render chart.js for Performance Overview
        const ctx = document.getElementById('performanceChart').getContext('2d');
        const performanceChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Career Goals Completed',
                    data: [2, 3, 4, 5, 6, 7, 8, 10, 12, 15, 16, 18],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Allow chart to adjust to container size
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Career Goals Completed Over Time'
                    }
                }
            }
        });
    </script>

    <!-- JavaScript for populating the single dynamic modal -->
    <script>
        // Event listener for francesca populating modal based on the clicked item
        document.querySelectorAll('a[data-bs-toggle="modal"]').forEach(function(element) {
            element.addEventListener('click', function() {
                const title = this.getAttribute('data-title');
                const date = this.getAttribute('data-date');
                const summary = this.getAttribute('data-summary');

                document.getElementById('achievementModalLabel').textContent = title;
                document.getElementById('achievementDate').textContent = date;
                document.getElementById('achievementSummary').textContent = summary;
            });
        });
    </script>
</body>
</html>


