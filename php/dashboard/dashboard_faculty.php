<?php
include('../session.php'); // Ensure the user is logged in
include('../connection.php'); // Include the database connection
include '../config.php';

// Define variables for Page Titles and Sidebar Active effects
$pageTitle = 'Career Path | Faculty Dashboard';
$activePage = 'Dashboard';

// Check if the user is a Faculty Member
if ($_SESSION['role'] != 'Regular Instructor' && $_SESSION['role'] != 'Contract of Service Instructor') {
    // If the user is not a faculty member, check if they are Human Resources
    if ($_SESSION['role'] == 'Human Resources') {
        // Redirect to HR dashboard
        header('Location: ../dashboard_HR/dashboard_HR.php');
        exit();
    } else {
        // Unauthorized role, force logout
        header('Location: ../logout.php');
        exit();
    }
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
            <?php require_once('../includes/navbar.php');?>
        <!--end::Header--> 
        
        <!--begin::Sidebar-->
            <?php require_once('../includes/sidebar_faculty.php');?>
        <!--end::Sidebar--> 
        

        <!--begin::App Main-->
        <main class="app-main"><!--begin::App Content Header-->
            <div class="app-content-header"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Dashboard</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Dashboard
                                </li>
                            </ol>
                        </div>
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div>
            <div class="app-content"> <!--begin::Container-->
                <div class="container-fluid"> 
                    <!-- Info boxes -->
                    <div class="row">

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon text-bg-primary shadow-sm"><i class="bi bi-calendar-check"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Upcoming Evaluations</span>
                                    <span class="info-box-number">2</span>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon text-bg-success shadow-sm"><i class="bi bi-file-earmark-arrow-up"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Documents Uploaded</span>
                                    <span class="info-box-number">5/7</span>
                                </div>
                            </div>
                        </div>
                        <!-- /.col --> 
                        <!-- fix for small devices only --> <!-- <div class="clearfix hidden-md-up"></div> -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon text-bg-warning shadow-sm"><i class="bi bi-list-check"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Pending Tasks</span>
                                    <span class="info-box-number">3</span>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon text-bg-danger shadow-sm"><i class="bi bi-mortarboard-fill"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Upcoming Training</span>
                                    <span class="info-box-number">1</span>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div> 
                    <!-- /.row --> 
                     
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-4">
                                <!-- Card HEADER -->
                                <div class="card-header bg-success text-white">
                                    <h5 class="card-title">Career Progress Overview</h5>
                                    <div class="card-tools"> 
                                        <button type="button" class="btn btn-tool text-white" data-lte-toggle="card-collapse"> 
                                            <i data-lte-icon="expand" class="bi bi-plus-lg"></i> 
                                            <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> 
                                        </button>
                                        <div class="btn-group"> 
                                            <button type="button" class="btn btn-tool dropdown-toggle text-white" data-bs-toggle="dropdown"> 
                                                <i class="bi bi-wrench"></i> 
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end" role="menu"> 
                                                <a href="#" class="dropdown-item">Action</a> 
                                                <a href="#" class="dropdown-item">Another action</a> 
                                                <a href="#" class="dropdown-item">Something else here</a> 
                                                <a class="dropdown-divider"></a> 
                                                <a href="#" class="dropdown-item">Separated link</a> 
                                            </div>
                                        </div> 

                                        <!-- Close Button -->
                                        <!-- <button type="button" class="btn btn-tool" data-lte-toggle="card-remove"> 
                                            <i class="bi bi-x-lg"></i> 
                                        </button> -->
                                    </div>
                                </div> 
                                <!-- /.card-header -->
                                <div class="card-body "><!--begin::Row-->
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p class="text-center"><strong>Career Goals: Jan, 2023 - Dec, 2023</strong></p>
                                            <canvas id="career-progress-chart"></canvas> <!-- Correct canvas element -->
                                        </div>

                                        <!-- /.col -->
                                        <div class="col-md-4">
                                            <p class="text-center"><strong>Career Goal Completion</strong></p>
                                            
                                            <div class="progress-group">
                                                <a href="#" class="text-decoration-none text-auto">Research Papers Published</a>
                                                <span class="float-end"><b>2</b>/5</span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar text-bg-primary" style="width: 40%"></div>
                                                </div>
                                            </div>

                                            <div class="progress-group">
                                                <!-- <a href="career_goals.php#training_sessions" class="text-decoration-none">Training Sessions Completed</a> -->
                                                <a href="#" class="text-decoration-none">Training Sessions Completed</a>
                                                <span class="float-end"><b>3</b>/4</span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar text-bg-danger" style="width: 75%"></div>
                                                </div>
                                            </div>

                                            <div class="progress-group">
                                                <a href="#" class="text-decoration-none">Evaluations Completed</a>
                                                <span class="float-end"><b>1</b>/3</span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar text-bg-success" style="width: 33%"></div>
                                                </div>
                                            </div>

                                            <div class="progress-group">
                                                <a href="#" class="text-decoration-none">Workshops Attended</a>
                                                <span class="float-end"><b>2</b>/4</span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar text-bg-warning" style="width: 50%"></div>
                                                </div>
                                            </div>
                                        </div><!-- /.col -->
                                    </div> <!--end::Row-->
                                </div> <!-- ./card-body -->
                                
                                <!-- CARD FOOTER: Original -->
                                <!-- <div class="card-footer"> 
                                    <div class="row">
                                        <div class="col-md-3 col-6">
                                            <div class="text-center border-end"> <span class="text-success"> <i class="bi bi-caret-up-fill"></i> 17%
                                                </span>
                                                <h5 class="fw-bold mb-0">$35,210.43</h5> <span class="text-uppercase">TOTAL REVENUE</span>
                                            </div>
                                        </div> 
                                        <div class="col-md-3 col-6">
                                            <div class="text-center border-end"> <span class="text-info"> <i class="bi bi-caret-left-fill"></i> 0%
                                                </span>
                                                <h5 class="fw-bold mb-0">$10,390.90</h5> <span class="text-uppercase">TOTAL COST</span>
                                            </div>
                                        </div> 
                                        <div class="col-md-3 col-6">
                                            <div class="text-center border-end"> <span class="text-success"> <i class="bi bi-caret-up-fill"></i> 20%
                                                </span>
                                                <h5 class="fw-bold mb-0">$24,813.53</h5> <span class="text-uppercase">TOTAL PROFIT</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="text-center"> <span class="text-danger"> <i class="bi bi-caret-down-fill"></i> 18%
                                                </span>
                                                <h5 class="fw-bold mb-0">1200</h5> <span class="text-uppercase">GOAL COMPLETIONS</span>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <!-- CARD FOOTER: Original END -->

                                <!-- CARD FOOTER: PLACEHOLDER -->
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="text-center">
                                                <h5 class="fw-bold mb-0">7</h5>
                                                <span class="text-uppercase">Total Career Goals Completed</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="text-center">
                                                <h5 class="fw-bold mb-0">12</h5>
                                                <span class="text-uppercase">Training Hours Accumulated</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- CARD FOOTER: PLACEHOLDER END -->

                            </div> <!-- /.card -->
                        </div> <!-- /.col -->
                    </div> 
                    <!--end::Row--> 
                    
                    <!--begin::Row-->
                    <div class="row"> <!-- Start col -->
                        <div class="col-md-8"> <!--begin::Row-->
                            <div class="row g-4 mb-4">
                                <div class="col-md-6"> <!-- Important Updates Section -->
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            <h3 class="card-title">Important Updates</h3>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <i class="bi bi-exclamation-circle-fill text-warning"></i> 
                                                    <a href="notifications.php#evaluation" class="text-decoration-none">Upcoming Evaluation on October 25, 2024</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <i class="bi bi-file-earmark-text-fill text-danger"></i> 
                                                    <a href="notifications.php#submission" class="text-decoration-none">Document Submission Deadline: October 20, 2024</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <i class="bi bi-award-fill text-success"></i> 
                                                    <a href="notifications.php#training" class="text-decoration-none">Training Opportunity: "Advanced Research Methods" on November 1, 2024</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div> 
                                <!-- /.col -->
                                <div class="col-md-6"> <!-- USERS LIST -->
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            <h3 class="card-title">Latest Members</h3>
                                            <div class="card-tools"> <span class="badge text-bg-danger">
                                                    8 New Members
                                                </span> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg text-white"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg text-white"></i> </button> </div>
                                        </div> <!-- /.card-header -->
                                        <div class="card-body p-0">
                                            <div class="row text-center m-1">
                                                <div class="col-3 p-2"> <img class="img-fluid rounded-circle" src="" alt="User Image"> <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                                                        Alexander
                                                    </a>
                                                    <div class="fs-8">Today</div>
                                                </div>
                                                <div class="col-3 p-2"> <img class="img-fluid rounded-circle" src="../../AdminLTE/dist/assets/img/user1-128x128.jpg" alt="User Image"> <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                                                        Norman
                                                    </a>
                                                    <div class="fs-8">Yesterday</div>
                                                </div>
                                                <div class="col-3 p-2"> <img class="img-fluid rounded-circle" src="../../AdminLTE/dist/assets/img/user7-128x128.jpg" alt="User Image"> <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                                                        Jane
                                                    </a>
                                                    <div class="fs-8">12 Jan</div>
                                                </div>
                                                <div class="col-3 p-2"> <img class="img-fluid rounded-circle" src="../../AdminLTE/dist/assets/img/user6-128x128.jpg" alt="User Image"> <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                                                        John
                                                    </a>
                                                    <div class="fs-8">12 Jan</div>
                                                </div>
                                                <div class="col-3 p-2"> <img class="img-fluid rounded-circle" src="../../AdminLTE/dist/assets/img/user2-160x160.jpg" alt="User Image"> <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                                                        Alexander
                                                    </a>
                                                    <div class="fs-8">13 Jan</div>
                                                </div>
                                                <div class="col-3 p-2"> <img class="img-fluid rounded-circle" src="../../AdminLTE/dist/assets/img/user5-128x128.jpg" alt="User Image"> <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                                                        Sarah
                                                    </a>
                                                    <div class="fs-8">14 Jan</div>
                                                </div>
                                                <div class="col-3 p-2"> <img class="img-fluid rounded-circle" src="../../AdminLTE/dist/assets/img/user4-128x128.jpg" alt="User Image"> <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                                                        Nora
                                                    </a>
                                                    <div class="fs-8">15 Jan</div>
                                                </div>
                                                <div class="col-3 p-2"> <img class="img-fluid rounded-circle" src="../../AdminLTE/dist/assets/img/user3-128x128.jpg" alt="User Image"> <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                                                        Nadia
                                                    </a>
                                                    <div class="fs-8">15 Jan</div>
                                                </div>
                                            </div> <!-- /.users-list -->
                                        </div> <!-- /.card-body -->
                                        <div class="card-footer text-center"> <a href="javascript:" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">View All Users</a> </div> <!-- /.card-footer -->
                                    </div> <!-- /.card -->
                                </div> <!-- /.col -->
                            </div> <!--end::Row--> <!--begin::Latest Order Widget-->
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h3 class="card-title">Recent Document Uploads</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Document ID</th>
                                                <th>Title</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><a href="documents_view.php?id=DOC123" class="text-decoration-none">DOC123</a></td>
                                                <td>Research Paper</td>
                                                <td><span class="badge bg-success">Approved</span></td>
                                                <td>Oct 14, 2024</td>
                                            </tr>
                                            <tr>
                                                <td><a href="documents_view.php?id=DOC456" class="text-decoration-none">DOC456</a></td>
                                                <td>Training Certificate</td>
                                                <td><span class="badge bg-warning">Pending</span></td>
                                                <td>Oct 12, 2024</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div> <!-- /.card -->
                        </div> <!-- /.col -->
                        <div class="col-md-4"> <!-- Info Boxes Style 2 -->

                            <a href="#" class="text-decoration-none">
                                <div class="info-box mb-3 text-bg-primary">
                                    <span class="info-box-icon"><i class="bi bi-clipboard-check"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text text-light">Pending Evaluations</span>
                                        <span class="info-box-number text-light">3</span>
                                    </div>
                                </div>
                            </a>

                            <a href="#" class="text-decoration-none">
                                <div class="info-box mb-3 text-bg-success">
                                    <span class="info-box-icon"><i class="bi bi-file-earmark-arrow-up"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Documents Submitted</span>
                                        <span class="info-box-number">7</span>
                                    </div>
                                </div>
                             </a>

                            <a href="#" class="text-decoration-none">
                                <div class="info-box mb-3 text-bg-warning">
                                    <span class="info-box-icon"><i class="bi bi-mortarboard-fill"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Upcoming Training</span>
                                        <span class="info-box-number">2</span>
                                    </div>
                                </div>
                            </a> 
                            <!-- /.info-box -->


                            <div class="card mb-4">
                                <div class="card-header bg-success text-white">
                                    <h3 class="card-title">Evaluation History</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                            <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                            <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!-- Pie chart for completed vs pending evaluations -->
                                    <canvas id="evaluation-pie-chart"></canvas>
                                    <!-- Mock pie chart data here -->
                                </div>
                                <div class="card-footer p-0">
                                    <ul class="nav nav-pills flex-column">
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                                October 2024 Evaluation
                                                <span class="float-end text-success">
                                                    Completed
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                                July 2024 Evaluation
                                                <span class="float-end text-warning">
                                                    Pending
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div><!-- /.card --> 
                            
                            <!-- Recent Career Activities -->
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h3 class="card-title">Recent Career Activities</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                            <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                            <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="px-2">
                                        <div class="d-flex border-top py-2 px-1">
                                            <div class="col-10">
                                                <a href="javascript:void(0)" class="fw-bold">
                                                    Research Paper Published
                                                    <span class="badge text-bg-success float-end">
                                                        October 10, 2024
                                                    </span>
                                                </a>
                                                <div class="text-truncate">
                                                    "Advances in AI Research"
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex border-top py-2 px-1">
                                            <div class="col-10">
                                                <a href="javascript:void(0)" class="fw-bold">
                                                    Completed Training Session
                                                    <span class="badge text-bg-warning float-end">
                                                        October 5, 2024
                                                    </span>
                                                </a>
                                                <div class="text-truncate">
                                                    "Advanced Teaching Techniques"
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex border-top py-2 px-1">
                                            <div class="col-10">
                                                <a href="javascript:void(0)" class="fw-bold">
                                                    Evaluation Completed
                                                    <span class="badge text-bg-success float-end">
                                                        September 30, 2024
                                                    </span>
                                                </a>
                                                <div class="text-truncate">
                                                    Annual Performance Review
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <a href="javascript:void(0)" class="uppercase">View All Activities</a>
                                </div>
                            </div> <!-- /.card -->
                        </div> <!-- /.col -->
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div> <!--end::App Content-->
        </main> 
        <!--end::App Main-->
        
        
        
        <!--begin::Footer-->   
        <?php require_once('../includes/footer.php'); ?>
        <!--end::Footer-->
    </div>
    <!--end::App Wrapper--> 
    
    <!-- JAVA SCRIPTS --> 
    <?php require_once('../includes/dashboard_default_scripts.php');?>


    <!-- Chart for Career Progress -->
    <script>
        // Mock data for Career Progress
        const careerLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const careerData = {
            labels: careerLabels,
            datasets: [{
                label: 'Career Goals Completed',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                data: [0, 2, 3, 4, 6, 8, 10, 11, 13, 15, 16, 18], // Mock progress data
                fill: true,
                tension: 0.3 // Smooth curves
            }]
        };

        const careerConfig = {
            type: 'line', // Line chart
            data: careerData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'Career Goals Completed Over Time'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 20 // Max career goals, adjust as necessary
                    }
                }
            }
        };

        // Render the chart
        const careerCtx = document.getElementById('career-progress-chart').getContext('2d');
        new Chart(careerCtx, careerConfig);
    </script>

    <!-- Chart for Evaluation History -->
    <script>
        // Data for the pie chart (mock data)
        const evaluationData = {
            labels: ['Completed Evaluations', 'Pending Evaluations'],
            datasets: [{
                label: 'Evaluation Status',
                data: [1, 1],  // Replace with real data later (completed vs pending evaluations)
                backgroundColor: [
                    'rgba(54, 162, 235, 0.5)',  // Blue for completed
                    'rgba(255, 206, 86, 0.5)'   // Yellow for pending
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Config for the pie chart
        const evaluationConfig = {
            type: 'pie',
            data: evaluationData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        enabled: true
                    }
                }
            }
        };

        // Rendering the chart
        const evaluationCtx = document.getElementById('evaluation-pie-chart').getContext('2d');
        new Chart(evaluationCtx, evaluationConfig);
    </script>
</body>
</html>


