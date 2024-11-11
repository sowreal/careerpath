<?php
include('../session.php'); // Ensure the user is logged in
include('../connection.php'); // Include the database connection

// Define variables for Page Titles and Sidebar Active effects
$pageTitle = 'Career Path | Notifications';
$activePage = 'Notifs';

// Check if the user is a faculty member
if ($_SESSION['role'] != 'Regular Instructor' && $_SESSION['role'] != 'Contract of Service Instructor') {
    // If the user is not a faculty member, redirect to their appropriate dashboard
    header('Location: ../dashboard_HR/dashboard_HR.php'); // Redirect to HR dashboard if not a faculty member
    exit();
}
// Your dashboard content goes here
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
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Notifications</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Notifications</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notification Filter Navigation -->
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-12">
                    <button id="showAll" class="btn btn-outline-primary me-2">All Notifications</button>
                    <button id="showUnread" class="btn btn-outline-success me-2">Unread Notifications</button>
                    <button id="showRead" class="btn btn-outline-secondary">Read Notifications</button>
                </div>
            </div>
        </div>

        <!-- Notification List -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- High-Priority Notification (Unread) -->
                    <div class="card mb-3 shadow-sm border-danger bg-light" data-read="false">
                        <div class="card-body" data-bs-toggle="collapse" href="#collapseHighPriority" role="button" aria-expanded="false" aria-controls="collapseHighPriority">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="bi bi-exclamation-circle text-danger"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1 text-dark fw-bold notification-title">Urgent: Document Submission Required</h5>
                                        <p>Please submit your documents by October 20, 2024, for your evaluation.</p>
                                        <small class="text-muted">1 day ago</small>
                                    </div>
                                </div>
                                <div>
                                    <button class="btn btn-danger btn-sm">Submit Now</button>
                                </div>
                            </div>
                        </div>
                        <div class="collapse" id="collapseHighPriority">
                            <div class="card-footer">
                                <p>Please submit your documents by October 20, 2024, for your evaluation.</p>
                                <p>
                                Contrary to popular belief, Lorem Ipsum is not simply random text. 
                                It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. 
                                Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, 
                                consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. 
                                Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. 
                                This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, 
                                "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

                                The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. 
                                Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, 
                                accompanied by English versions from the 1914 translation by H. Rackham.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Regular Notification (Unread) -->
                    <div class="card mb-3 shadow-sm bg-light" data-read="false">
                        <div class="card-body" data-bs-toggle="collapse" href="#collapseEvaluation" role="button" aria-expanded="false" aria-controls="collapseEvaluation">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="bi bi-bell text-success"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1 text-dark fw-bold notification-title">Performance Evaluation Reminder</h5>
                                        <p>You have a scheduled performance evaluation on October 25, 2024. Please ensure your documents are up to date.</p>
                                        <small class="text-muted">3 days ago</small>
                                    </div>
                                </div>
                                <div>
                                    <button class="btn btn-outline-success btn-sm mark-read-btn">Mark as Read</button>
                                </div>
                            </div>
                        </div>
                        <div class="collapse" id="collapseEvaluation">
                            <div class="card-footer">
                                <p>You have a scheduled performance evaluation on October 25, 2024. Please ensure your documents are up to date.</p>
                                <p>
                                Contrary to popular belief, Lorem Ipsum is not simply random text. 
                                It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. 
                                Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, 
                                consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. 
                                Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" 

                                The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. 
                                Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, 
                                accompanied by English versions from the 1914 translation by H. Rackham.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Notification Example for Read Notification -->
                    <div class="card mb-3 shadow-sm" data-read="true">
                        <div class="card-body" data-bs-toggle="collapse" href="#collapseConference" role="button" aria-expanded="false" aria-controls="collapseConference">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="bi bi-check-circle text-success"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1 text-dark notification-title">Goal Completed: International Conference</h5>
                                            <p>You successfully attended the International Research Conference.</p>
                                        <small class="text-muted">2 weeks ago</small>
                                    </div>
                                </div>
                                <div>
                                    <button class="btn btn-outline-success btn-sm">Dismiss</button>
                                </div>
                            </div>
                        </div>
                        <div class="collapse" id="collapseConference">
                            <div class="card-footer">
                                <p>You successfully attended the International Research Conference.</p>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                                    when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                    It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    

    
    <!-- JavaScript for NOTIFICATIONS Read/Unread Handling -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Mark notification as read when "Mark as Read" button is clicked
            document.querySelectorAll('.mark-read-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    let card = this.closest('.card');
                    card.classList.remove('bg-light');  // Remove unread styling
                    card.querySelector('.notification-title').classList.remove('fw-bold');  // Remove bold for title
                    card.dataset.read = "true";  // Mark it as read in the dataset attribute
                });
            });

            // Show all notifications
            document.getElementById('showAll').addEventListener('click', function () {
                document.querySelectorAll('.card').forEach(function (card) {
                    card.style.display = 'block';
                });
            });

            // Show only unread notifications
            document.getElementById('showUnread').addEventListener('click', function () {
                document.querySelectorAll('.card').forEach(function (card) {
                    if (card.dataset.read === "true") {
                        card.style.display = 'none';  // Hide read notifications
                    } else {
                        card.style.display = 'block';  // Show unread notifications
                    }
                });
            });

            // Show only read notifications
            document.getElementById('showRead').addEventListener('click', function () {
                document.querySelectorAll('.card').forEach(function (card) {
                    if (card.dataset.read === "true") {
                        card.style.display = 'block';  // Show read notifications
                    } else {
                        card.style.display = 'none';  // Hide unread notifications
                    }
                });
            });
        });
    </script>
</body>
</html>


