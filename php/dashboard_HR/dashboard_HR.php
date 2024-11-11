<?php
include('../session.php'); // Ensure the user is logged in
include('../connection.php'); // Include the database connection

// Define variables for Page Titles and Sidebar Active effects
$pageTitle = 'Career Path | HR Dashboard';
$activePage = 'DashboardHR';

// Check if the user is Human Resources
if ($_SESSION['role'] != 'Human Resources') {
    // If the user is not HR, check if they are Faculty
    if ($_SESSION['role'] == 'Regular Instructor' || $_SESSION['role'] == 'Contract of Service Instructor') {
        // Redirect to Faculty dashboard
        header('Location: ../dashboard/dashboard_faculty.php');
        exit();
    } else {
        // Unauthorized role, force logout
        header('Location: ../logout.php');
        exit();
    }
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
        <main class="app-main">
            <div class="app-content"> <!--begin::Container-->
                <div class="container-fluid"> 
                    <!-- Page Header -->
                    <div class="d-flex justify-content-between align-items-center my-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>
                
                <!-- Info boxes -->
                    <div class="row">
                        <!-- Key Metrics Section -->
                        <div class="col-12 col-sm-6 col-md-4">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#facultyModal" style="text-decoration: none; transition: all 0.3s;">
                                <div class="info-box mb-4">
                                    <span class="info-box-icon bg-primary elevation-1"><i class="bi bi-people"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text" id="facultyStatusText">Total Faculty Members</span>
                                        <span class="info-box-number" id="facultyCountText">42 Faculty Members</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Modal for Faculty Summary -->
                        <div class="modal fade" id="facultyModal" tabindex="-1" aria-labelledby="facultyModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="facultyModalLabel">Faculty Members Overview</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="list-group mb-3">
                                            <li class="list-group-item">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span>Dr. Alice Smith - Joined on Oct 10</span>
                                                    <button class="btn btn-sm btn-link text-decoration-none" data-bs-toggle="collapse" data-bs-target="#facultyDetails1" aria-expanded="false" aria-controls="facultyDetails1" onclick="toggleDetails('#facultyDetails1')">View Details</button>
                                                </div>
                                                <div class="collapse mt-2" id="facultyDetails1">
                                                    <div class="card card-body">
                                                        <p><strong>Department:</strong> Mathematics</p>
                                                        <p><strong>Date Joined:</strong> Oct 10</p>
                                                        <div class="d-flex gap-2 justify-content-end">
                                                            <button class="btn btn-success btn-sm">Acknowledge</button>
                                                            <button class="btn btn-danger btn-sm">Dismiss</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span>Prof. John Doe - Joined on Oct 8</span>
                                                    <button class="btn btn-sm btn-link text-decoration-none" data-bs-toggle="collapse" data-bs-target="#facultyDetails2" aria-expanded="false" aria-controls="facultyDetails2" onclick="toggleDetails('#facultyDetails2')">View Details</button>
                                                </div>
                                                <div class="collapse mt-2" id="facultyDetails2">
                                                    <div class="card card-body">
                                                        <p><strong>Department:</strong> Physics</p>
                                                        <p><strong>Date Joined:</strong> Oct 8</p>
                                                        <div class="d-flex gap-2 justify-content-end">
                                                            <button class="btn btn-success btn-sm">Acknowledge</button>
                                                            <button class="btn btn-danger btn-sm">Dismiss</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- Add more faculty members here -->
                                        </ul>
                                        <div class="d-flex justify-content-end">
                                            <a href="faculty_management.php" class="btn btn-link">Go to Faculty Management Page</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-4">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#pendingDocumentsModal" style="text-decoration: none; transition: all 0.3s;">
                                <div class="info-box mb-4">
                                    <span class="info-box-icon bg-success elevation-1"><i class="bi bi-file-earmark-check"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Pending Document Approvals</span>
                                        <span class="info-box-number">15 Documents Pending</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Modal for Pending Document Approvals -->
                        <div class="modal fade" id="pendingDocumentsModal" tabindex="-1" aria-labelledby="pendingDocumentsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="pendingDocumentsModalLabel">Pending Document Approvals</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="list-group mb-3">
                                            <li class="list-group-item">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span>Dr. Jane Doe - Annual Report</span>
                                                    <button class="btn btn-sm btn-link text-decoration-none" data-bs-toggle="collapse" data-bs-target="#docDetails1" aria-expanded="false" aria-controls="docDetails1" onclick="toggleDetails('#docDetails1')">View Details</button>
                                                </div>
                                                <div class="collapse mt-2" id="docDetails1">
                                                    <div class="card card-body">
                                                        <p><strong>Document Title:</strong> Annual Report</p>
                                                        <p><strong>Submission Date:</strong> Oct 18</p>
                                                        <div class="d-flex gap-2 justify-content-end">
                                                            <button class="btn btn-success btn-sm" onclick="confirmAction('Approve this document?')">Approve</button>
                                                            <button class="btn btn-danger btn-sm" onclick="confirmAction('Reject this document?')">Reject</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span>Prof. John Smith - Research Proposal</span>
                                                    <button class="btn btn-sm btn-link text-decoration-none" data-bs-toggle="collapse" data-bs-target="#docDetails2" aria-expanded="false" aria-controls="docDetails2" onclick="toggleDetails('#docDetails2')">View Details</button>
                                                </div>
                                                <div class="collapse mt-2" id="docDetails2">
                                                    <div class="card card-body">
                                                        <p><strong>Document Title:</strong> Research Proposal</p>
                                                        <p><strong>Submission Date:</strong> Oct 18</p>
                                                        <div class="d-flex gap-2 justify-content-end">
                                                            <button class="btn btn-success btn-sm" onclick="confirmAction('Approve this document?')">Approve</button>
                                                            <button class="btn btn-danger btn-sm" onclick="confirmAction('Reject this document?')">Reject</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- Add more pending documents here -->
                                        </ul>
                                        <div class="d-flex justify-content-end">
                                            <a href="document_management.php" class="btn btn-link">Go to Document Management</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- Notifications Summary Section -->
                        <div class="col-12 col-sm-6 col-md-4">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#notificationsModal" style="text-decoration: none; transition: all 0.3s;">
                                <div class="info-box mb-4">
                                    <span class="info-box-icon bg-warning elevation-1"><i class="bi bi-bell"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Unread Notifications</span>
                                        <span class="info-box-number">8 Unread Notifications</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Modal for Notifications Summary -->
                        <div class="modal fade" id="notificationsModal" tabindex="-1" aria-labelledby="notificationsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="notificationsModalLabel">Unread Notifications</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="list-group mb-3">
                                            <li class="list-group-item">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span>Contract renewal reminder for Prof. John Smith</span>
                                                    <button class="btn btn-sm btn-link text-decoration-none" data-bs-toggle="collapse" data-bs-target="#notificationDetails1" aria-expanded="false" aria-controls="notificationDetails1" onclick="toggleDetails('#notificationDetails1')">View Details</button>
                                                </div>
                                                <div class="collapse mt-2" id="notificationDetails1">
                                                    <div class="card card-body">
                                                        <p>Details about the contract renewal reminder for Prof. John Smith.</p>
                                                        <div class="d-flex gap-2 justify-content-end">
                                                            <button class="btn btn-success btn-sm">Acknowledge</button>
                                                            <button class="btn btn-danger btn-sm">Dismiss</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span>Annual leave request submitted by Dr. Jane Doe</span>
                                                    <button class="btn btn-sm btn-link text-decoration-none" data-bs-toggle="collapse" data-bs-target="#notificationDetails2" aria-expanded="false" aria-controls="notificationDetails2" onclick="toggleDetails('#notificationDetails2')">View Details</button>
                                                </div>
                                                <div class="collapse mt-2" id="notificationDetails2">
                                                    <div class="card card-body">
                                                        <p>Details about the annual leave request submitted by Dr. Jane Doe.</p>
                                                        <div class="d-flex gap-2 justify-content-end">
                                                            <button class="btn btn-success btn-sm">Acknowledge</button>
                                                            <button class="btn btn-danger btn-sm">Dismiss</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span>New training session available: "Advanced Teaching Methods"</span>
                                                    <button class="btn btn-sm btn-link text-decoration-none" data-bs-toggle="collapse" data-bs-target="#notificationDetails3" aria-expanded="false" aria-controls="notificationDetails3" onclick="toggleDetails('#notificationDetails3')">View Details</button>
                                                </div>
                                                <div class="collapse mt-2" id="notificationDetails3">
                                                    <div class="card card-body">
                                                        <p>Details about the new training session available: "Advanced Teaching Methods".</p>
                                                        <div class="d-flex gap-2 justify-content-end">
                                                            <button class="btn btn-success btn-sm">Acknowledge</button>
                                                            <button class="btn btn-danger btn-sm">Dismiss</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- Add more notifications here -->
                                        </ul>
                                        <div class="d-flex justify-content-end">
                                            <a href="notifications.php" class="btn btn-link">Go to Notifications Page</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activities Section -->
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header bg-success shadow text-light">
                                    <h3 class="card-title">Recent Activities</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="bi bi-dash-lg"></i></button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-3">
                                        <div class="btn-group" role="group" aria-label="Activity Filters">
                                            <button type="button" class="btn btn-outline-primary">Submissions</button>
                                            <button type="button" class="btn btn-outline-primary">Updates</button>
                                            <button type="button" class="btn btn-outline-primary">Approvals</button>
                                            <button type="button" class="btn btn-outline-primary">Evaluations</button>
                                        </div>
                                        <div class="btn-group" role="group" aria-label="Time Frame Filters">
                                            <button type="button" class="btn btn-outline-secondary">Today</button>
                                            <button type="button" class="btn btn-outline-secondary">This Week</button>
                                            <button type="button" class="btn btn-outline-secondary">This Month</button>
                                        </div>
                                    </div>
                                    <ul class="list-group" id="recentActivitiesList">
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>Dr. Jane Doe submitted 'Research Paper' on Oct 18.</span>
                                                <button class="btn btn-sm btn-link text-decoration-none" data-bs-toggle="collapse" data-bs-target="#activityDetails1" aria-expanded="false" aria-controls="activityDetails1">View Details</button>
                                            </div>
                                            <div class="collapse mt-2" id="activityDetails1">
                                                <div class="card card-body">
                                                    <p><strong>Document Title:</strong> Research Paper</p>
                                                    <p><strong>Submission Date:</strong> Oct 18</p>
                                                    <div class="d-flex gap-2 justify-content-end">
                                                        <button class="btn btn-success btn-sm">Acknowledge</button>
                                                        <button class="btn btn-danger btn-sm">Mark as Important</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>Prof. John Smith updated his career goal 'Complete Ph.D.' on Oct 19.</span>
                                                <button class="btn btn-sm btn-link text-decoration-none" data-bs-toggle="collapse" data-bs-target="#activityDetails2" aria-expanded="false" aria-controls="activityDetails2">View Details</button>
                                            </div>
                                            <div class="collapse mt-2" id="activityDetails2">
                                                <div class="card card-body">
                                                    <p><strong>Updated Goal:</strong> Complete Ph.D.</p>
                                                    <p><strong>Update Date:</strong> Oct 19</p>
                                                    <div class="d-flex gap-2 justify-content-end">
                                                        <button class="btn btn-success btn-sm">Acknowledge</button>
                                                        <button class="btn btn-danger btn-sm">Mark as Important</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>Document 'Project Proposal' was approved on Oct 20.</span>
                                                <button class="btn btn-sm btn-link text-decoration-none" data-bs-toggle="collapse" data-bs-target="#activityDetails3" aria-expanded="false" aria-controls="activityDetails3">View Details</button>
                                            </div>
                                            <div class="collapse mt-2" id="activityDetails3">
                                                <div class="card card-body">
                                                    <p><strong>Document Title:</strong> Project Proposal</p>
                                                    <p><strong>Approval Date:</strong> Oct 20</p>
                                                    <div class="d-flex gap-2 justify-content-end">
                                                        <button class="btn btn-success btn-sm">Acknowledge</button>
                                                        <button class="btn btn-danger btn-sm">Mark as Important</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>Evaluation for 'Prof. Emily Johnson' completed on Oct 21.</span>
                                                <button class="btn btn-sm btn-link text-decoration-none" data-bs-toggle="collapse" data-bs-target="#activityDetails4" aria-expanded="false" aria-controls="activityDetails4">View Details</button>
                                            </div>
                                            <div class="collapse mt-2" id="activityDetails4">
                                                <div class="card card-body">
                                                    <p><strong>Faculty Name:</strong> Prof. Emily Johnson</p>
                                                    <p><strong>Evaluation Date:</strong> Oct 21</p>
                                                    <div class="d-flex gap-2 justify-content-end">
                                                        <button class="btn btn-success btn-sm">Acknowledge</button>
                                                        <button class="btn btn-danger btn-sm">Mark as Important</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>Dr. Anne White submitted 'Performance Review' on Oct 22.</span>
                                                <button class="btn btn-sm btn-link text-decoration-none" data-bs-toggle="collapse" data-bs-target="#activityDetails5" aria-expanded="false" aria-controls="activityDetails5">View Details</button>
                                            </div>
                                            <div class="collapse mt-2" id="activityDetails5">
                                                <div class="card card-body">
                                                    <p><strong>Document Title:</strong> Performance Review</p>
                                                    <p><strong>Submission Date:</strong> Oct 22</p>
                                                    <div class="d-flex gap-2 justify-content-end">
                                                        <button class="btn btn-success btn-sm">Acknowledge</button>
                                                        <button class="btn btn-danger btn-sm">Mark as Important</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>Evaluation for "Prof. Triz Circulado" on Oct 27.</span>
                                                <button class="btn btn-sm btn-link text-decoration-none" data-bs-toggle="collapse" data-bs-target="#activityDetails5" aria-expanded="false" aria-controls="activityDetails5">View Details</button>
                                            </div>
                                            <div class="collapse mt-2" id="activityDetails5">
                                                <div class="card card-body">
                                                    <p><strong>Faculty Name:</strong> Prof. Triz Circulado</p>
                                                    <p><strong>Evaluation Date:</strong> Oct 27</p>
                                                    <div class="d-flex gap-2 justify-content-end">
                                                        <button class="btn btn-success btn-sm">Acknowledge</button>
                                                        <button class="btn btn-danger btn-sm">Mark as Important</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>Prof. Mina Myoui updated her career goal 'Complete Ph.D.' on Oct 24.</span>
                                                <button class="btn btn-sm btn-link text-decoration-none" data-bs-toggle="collapse" data-bs-target="#activityDetails2" aria-expanded="false" aria-controls="activityDetails2">View Details</button>
                                            </div>
                                            <div class="collapse mt-2" id="activityDetails2">
                                                <div class="card card-body">
                                                    <p><strong>Updated Goal:</strong> Complete Ph.D.</p>
                                                    <p><strong>Update Date:</strong> Oct 24</p>
                                                    <div class="d-flex gap-2 justify-content-end">
                                                        <button class="btn btn-success btn-sm">Acknowledge</button>
                                                        <button class="btn btn-danger btn-sm">Mark as Important</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>Prof. Yeji Hwang requested a profile update.</span>
                                                <button class="btn btn-sm btn-link text-decoration-none" data-bs-toggle="collapse" data-bs-target="#activityDetails3" aria-expanded="false" aria-controls="activityDetails3">View Details</button>
                                            </div>
                                            <div class="collapse mt-2" id="activityDetails3">
                                                <div class="card card-body">
                                                    <p><h5>Proposed Changes</h5></p>
                                                    <p><strong>Employee ID:</strong>From 018-093 to 018-094</p>
                                                    <p><strong>Department:</strong>From Department of Science to Department of Information Technology </p>
                                                    <div class="d-flex gap-2 justify-content-end">
                                                        <button class="btn btn-success btn-sm">Acknowledge</button>
                                                        <button class="btn btn-danger btn-sm">Mark as Important</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>Dr. Sana Minatozaki submitted 'Research Paper' on Oct 18.</span>
                                                <button class="btn btn-sm btn-link text-decoration-none" data-bs-toggle="collapse" data-bs-target="#activityDetails1" aria-expanded="false" aria-controls="activityDetails1">View Details</button>
                                            </div>
                                            <div class="collapse mt-2" id="activityDetails1">
                                                <div class="card card-body">
                                                    <p><strong>Document Title:</strong> Research Paper</p>
                                                    <p><strong>Submission Date:</strong> Oct 18</p>
                                                    <div class="d-flex gap-2 justify-content-end">
                                                        <button class="btn btn-success btn-sm">Acknowledge</button>
                                                        <button class="btn btn-danger btn-sm">Mark as Important</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>Prof. Katarina Yu submitted 'Research Paper' on Oct 18.</span>
                                                <button class="btn btn-sm btn-link text-decoration-none" data-bs-toggle="collapse" data-bs-target="#activityDetails1" aria-expanded="false" aria-controls="activityDetails1">View Details</button>
                                            </div>
                                            <div class="collapse mt-2" id="activityDetails1">
                                                <div class="card card-body">
                                                    <p><strong>Document Title:</strong> Research Paper</p>
                                                    <p><strong>Submission Date:</strong> Oct 18</p>
                                                    <div class="d-flex gap-2 justify-content-end">
                                                        <button class="btn btn-success btn-sm">Acknowledge</button>
                                                        <button class="btn btn-danger btn-sm">Mark as Important</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>Dr. Jane Doe submitted 'Research Paper' on Oct 18.</span>
                                                <button class="btn btn-sm btn-link text-decoration-none" data-bs-toggle="collapse" data-bs-target="#activityDetails1" aria-expanded="false" aria-controls="activityDetails1">View Details</button>
                                            </div>
                                            <div class="collapse mt-2" id="activityDetails1">
                                                <div class="card card-body">
                                                    <p><strong>Document Title:</strong> Research Paper</p>
                                                    <p><strong>Submission Date:</strong> Oct 18</p>
                                                    <div class="d-flex gap-2 justify-content-end">
                                                        <button class="btn btn-success btn-sm">Acknowledge</button>
                                                        <button class="btn btn-danger btn-sm">Mark as Important</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>


                                    <div class="d-flex justify-content-between mt-3">
                                        <nav>
                                            <ul class="pagination mb-0">
                                                <li class="page-item disabled"><a class="page-link" href="#">&lt;</a></li>
                                                <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a></li>
                                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                                <li class="page-item"><a class="page-link" href="#">4</a></li>
                                                <li class="page-item"><a class="page-link" href="#">5</a></li>
                                                <li class="page-item"><a class="page-link" href="#">...</a></li>
                                                <li class="page-item"><a class="page-link" href="#">&gt;</a></li>
                                            </ul>
                                        </nav>
                                        <a href="#" class="btn btn-link" id="viewMoreButton">View More</a>
                                        <a href="#" class="btn btn-link" id="viewLessButton" style="display: none;">View Less</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Access Actions Section -->
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header bg-success shadow text-light">
                                    <h3 class="card-title">Quick Access Actions</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="bi bi-dash-lg"></i></button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <a href="document_management.php" class="btn btn-primary mb-2">Review Pending Documents</a>
                                    <a href="faculty_management.php" class="btn btn-secondary mb-2">View Faculty List</a>
                                </div>
                            </div>
                        </div>
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
    
    
    <!--begin::Script--> 
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <?php require_once('../includes/dashboard_default_scripts.php');?>

    <!-- For faculty -->
    <script>
    function updateFacultyInfo(hasNewMembers, newMembersCount, totalMembersCount) {
        const facultyStatusText = document.getElementById('facultyStatusText');
        const facultyCountText = document.getElementById('facultyCountText');

        if (hasNewMembers) {
            facultyStatusText.textContent = 'New Faculty Members';
            facultyCountText.textContent = `${newMembersCount} New Members This Week`;
        } else {
            facultyStatusText.textContent = 'Total Faculty Members';
            facultyCountText.textContent = `${totalMembersCount} Faculty Members`;
        }
    }

    function toggleDetails(targetId) {
        // Close all other open collapses except the target
        document.querySelectorAll('.collapse').forEach(function(collapse) {
            if (collapse.id !== targetId.substring(1) && collapse.classList.contains('show')) {
                bootstrap.Collapse.getOrCreateInstance(collapse).hide();
            }
        });
        // Toggle the targeted collapse
        var targetCollapse = document.querySelector(targetId);
        bootstrap.Collapse.getOrCreateInstance(targetCollapse).toggle();
    }
    </script>


    <!-- For documents -->
    <script>
        function confirmAction(message) {
            if (confirm(message)) {
                // Perform the action here, like making an API call or redirecting
                console.log('Action confirmed: ' + message);
            } else {
                console.log('Action canceled');
            }
        }

        function toggleDetails(targetId) {
            // Close all other open collapses except the target
            document.querySelectorAll('.collapse').forEach(function(collapse) {
                if (collapse.id !== targetId.substring(1) && collapse.classList.contains('show')) {
                    bootstrap.Collapse.getOrCreateInstance(collapse).hide();
                }
            });
            // Toggle the targeted collapse
            var targetCollapse = document.querySelector(targetId);
            bootstrap.Collapse.getOrCreateInstance(targetCollapse).toggle();
        }
    </script>

    <!-- For notifications -->
    <script>
    function toggleDetails(targetId) {
        // Close all other open collapses except the target
        document.querySelectorAll('.collapse').forEach(function(collapse) {
            if (collapse.id !== targetId.substring(1) && collapse.classList.contains('show')) {
                bootstrap.Collapse.getOrCreateInstance(collapse).hide();
            }
        });
        // Toggle the targeted collapse
        var targetCollapse = document.querySelector(targetId);
        bootstrap.Collapse.getOrCreateInstance(targetCollapse).toggle();
    }
    </script>

    <!-- For recent activities -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const items = document.querySelectorAll('#recentActivitiesList .list-group-item');
            const viewMoreButton = document.getElementById('viewMoreButton');
            const viewLessButton = document.getElementById('viewLessButton');
            let defaultItemsPerPage = 5;
            let expandedItemsPerPage = 10;
            let itemsPerPage = defaultItemsPerPage;
            let currentPage = 1;
            let totalPages = Math.ceil(items.length / itemsPerPage);

            function renderPage(page) {
                items.forEach((item, index) => {
                    item.style.display = (index >= (page - 1) * itemsPerPage && index < page * itemsPerPage) ? 'block' : 'none';
                });
            }

            function updatePagination() {
                const pagination = document.querySelector('.pagination');
                pagination.innerHTML = '';

                // Previous button
                const prevPageItem = document.createElement('li');
                prevPageItem.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
                prevPageItem.innerHTML = `<a class="page-link" href="#">&lt;</a>`;
                pagination.appendChild(prevPageItem);

                // Page numbers
                for (let i = 1; i <= totalPages; i++) {
                    const pageItem = document.createElement('li');
                    pageItem.className = `page-item ${currentPage === i ? 'active' : ''}`;
                    pageItem.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                    pagination.appendChild(pageItem);
                }

                // Next button
                const nextPageItem = document.createElement('li');
                nextPageItem.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
                nextPageItem.innerHTML = `<a class="page-link" href="#">&gt;</a>`;
                pagination.appendChild(nextPageItem);
            }

            document.querySelector('.pagination').addEventListener('click', function (e) {
                if (e.target.tagName === 'A') {
                    e.preventDefault();
                    const selectedPage = e.target.textContent;
                    if (selectedPage === '<' && currentPage > 1) {
                        currentPage--;
                    } else if (selectedPage === '>' && currentPage < totalPages) {
                        currentPage++;
                    } else if (!isNaN(selectedPage)) {
                        currentPage = parseInt(selectedPage);
                    }
                    renderPage(currentPage);
                    updatePagination();
                }
            });

            // "View More" button
            viewMoreButton.addEventListener('click', function (e) {
                e.preventDefault();
                itemsPerPage = expandedItemsPerPage;
                currentPage = 1; // Reset to the first page
                totalPages = Math.ceil(items.length / itemsPerPage);
                renderPage(currentPage);
                updatePagination();
                viewMoreButton.style.display = 'none'; // Hide "View More" button
                viewLessButton.style.display = 'inline'; // Show "View Less" button
            });

            // "View Less" button
            viewLessButton.addEventListener('click', function (e) {
                e.preventDefault();
                itemsPerPage = defaultItemsPerPage;
                currentPage = 1; // Reset to the first page
                totalPages = Math.ceil(items.length / itemsPerPage);
                renderPage(currentPage);
                updatePagination();
                viewLessButton.style.display = 'none'; // Hide "View Less" button
                viewMoreButton.style.display = 'inline'; // Show "View More" button
            });

            // Initial render
            renderPage(currentPage);
            updatePagination();
        });
    </script>





    </body><!--end::Body-->
</html>
