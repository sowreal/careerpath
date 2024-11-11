<?php
include('../session.php'); // Ensure the user is logged in
include('../connection.php'); // Include the database connection

// Define variables for Page Titles and Sidebar Active effects
$pageTitle = 'Career Path | Notifications';
$activePage = 'Notifications';

// Check if the user is a Human Resources
if ($_SESSION['role'] != 'Human Resources') {
    // Check if the user is a Faculty Member
    if ($_SESSION['role'] != 'Regular Instructor' && $_SESSION['role'] != 'Contract of Service Instructor') {
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
    header('Location: dashboard_faculty.php'); // Redirect to HR dashboard if not a faculty member
    exit();
}

?>

<!DOCTYPE html>
<html lang="en"> <!--begin::Head-->

<head>
<?php require_once('../includes/header.php') ?>
<style>
  .list-group-item.unread {
    background-color: #f5f5f5;
    font-weight: bold;
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
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center my-4">
            <h1 class="h3 mb-0">Notifications</h1>
            <!-- Optional: Notification Settings Button -->
            <!-- <button class="btn btn-outline-secondary">
                <i class="fas fa-cog"></i> Settings
            </button> -->
            </div>

            <!-- Notifications List -->
            <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recent Notifications</h3>
                <!-- Filter Dropdown (Optional) -->
                <div class="card-tools">
                <div class="input-group input-group-sm">
                    <select class="form-select" id="notificationTypeFilter">
                    <option value="">All Notifications</option>
                    <option value="profile">Profile Changes</option>
                    <option value="document">Document Submissions</option>
                    <option value="system">System Announcements</option>
                    </select>
                </div>
                </div>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush" id="notificationsList">
                <!-- Mocked Notification Item -->
                <li class="list-group-item">
                    <div class="d-flex align-items-start">
                    <div class="flex-grow-1">
                        <strong>Profile Change Request</strong> from <em>Dr. Jane Smith</em>
                        <p class="mb-1 text-muted">Submitted on October 28, 2023</p>
                    </div>
                    <div>
                        <a href="#" class="btn btn-sm btn-primary">View Details</a>
                        <button class="btn btn-sm btn-link text-secondary mark-as-read-btn" title="Mark as read">
                        <i class="far fa-circle"></i>
                        </button>
                    </div>
                    </div>
                </li>
                <!-- Repeat for each notification -->
                <li class="list-group-item">
                    <div class="d-flex align-items-start">
                    <div class="flex-grow-1">
                        <strong>New Document Submission</strong> by <em>Prof. John Doe</em>
                        <p class="mb-1 text-muted">Submitted on October 27, 2023</p>
                    </div>
                    <div>
                        <a href="#" class="btn btn-sm btn-primary">Review Document</a>
                        <button class="btn btn-sm btn-link text-secondary mark-as-read-btn" title="Mark as read">
                        <i class="far fa-circle"></i>
                        </button>
                    </div>
                    </div>
                </li>
                <!-- Another Notification -->
                <li class="list-group-item bg-light">
                    <div class="d-flex align-items-start">
                    <div class="flex-grow-1">
                        <strong>System Maintenance Scheduled</strong>
                        <p class="mb-1 text-muted">Scheduled for October 30, 2023</p>
                    </div>
                    <div>
                        <a href="#" class="btn btn-sm btn-primary">Read Announcement</a>
                        <button class="btn btn-sm btn-link text-secondary mark-as-read-btn" title="Mark as read">
                        <i class="far fa-circle"></i>
                        </button>
                    </div>
                    </div>
                </li>
                <!-- Additional mocked notifications -->
                </ul>
            </div>
            <!-- Pagination (if needed) -->
            <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                <!-- Pagination items (mocked) -->
                <li class="page-item disabled">
                    <a class="page-link" href="#">&laquo;</a>
                </li>
                <li class="page-item active">
                    <a class="page-link" href="#">1</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">&raquo;</a>
                </li>
                </ul>
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

    <!-- Optional JavaScript for interactivity -->
    <script>
            // Mocked event listeners for "Mark as read" buttons
            document.querySelectorAll('.mark-as-read-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                // Toggle read/unread state (for frontend demonstration)
                const icon = this.querySelector('i');
                if (icon.classList.contains('far')) {
                icon.classList.remove('far', 'fa-circle');
                icon.classList.add('fas', 'fa-circle');
                this.closest('.list-group-item').classList.add('text-muted');
                } else {
                icon.classList.remove('fas', 'fa-circle');
                icon.classList.add('far', 'fa-circle');
                this.closest('.list-group-item').classList.remove('text-muted');
                }
            });
            });

            // Mocked filter functionality
            document.getElementById('notificationTypeFilter').addEventListener('change', function() {
            // Filter notifications based on the selected type (frontend mock)
            const selectedType = this.value;
            const notifications = document.querySelectorAll('#notificationsList .list-group-item');
            notifications.forEach(function(notification) {
                // For demonstration, show all notifications
                notification.style.display = '';
            });
            });
        </script>



    </body><!--end::Body-->
</html>
