<!-- 
 In each of main PHP pages, define the $activePage variable before including the sidebar. 
 -->
 <?php
// Example: dashboard.php
$activePage = 'dashboard';
include 'includes/header.php';
include 'includes/sidebar.php';
?>
<!--  -->

<!-- Make sure session.php is called in every script that needs to access session variables -->

<!-- Determine user's role after sign in -->
<!-- Inside sidebar.php, access user's role -->
<?php
include '../session.php';
$userRole = $_SESSION['role']; // 'faculty' or 'HR'
?>


<!-- Modify Sidebar to include conditional menu items using PHP's conditional statements-->
<!-- sidebar.php -->
<aside class="main-sidebar">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
        <!-- Common menu items for all users -->
        <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?php echo ($activePage == 'dashboard') ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <!-- Faculty-specific menu items -->

        <?php if ($userRole == 'faculty'): ?>
            <li class="nav-item">
                <a href="career_goals.php" class="nav-link <?php echo ($activePage == 'career_goals') ? 'active' : ''; ?>">
                    <i class="nav-icon fas fa-bullseye"></i>
                    <p>Career Goals</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="performance_tracking.php" class="nav-link <?php echo ($activePage == 'performance_tracking') ? 'active' : ''; ?>">
                    <i class="nav-icon fas fa-chart-line"></i>
                    <p>Performance Tracking</p>
                </a>
            </li>
            <!-- More faculty menu items -->
        <?php endif; ?>


        <!-- HR-specific menu items -->
        <?php if ($userRole == 'HR'): ?>
            <li class="nav-item">
                <a href="manage_faculty.php" class="nav-link <?php echo ($activePage == 'manage_faculty') ? 'active' : ''; ?>">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Manage Faculty</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="reports.php" class="nav-link <?php echo ($activePage == 'reports') ? 'active' : ''; ?>">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>Reports</p>
                </a>
            </li>
            <!-- More HR menu items -->
        <?php endif; ?>
        <!-- Additional common menu items -->
        <li class="nav-item">
            <a href="settings.php" class="nav-link <?php echo ($activePage == 'settings') ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-cogs"></i>
                <p>Settings</p>
            </a>
        </li>
    </ul>
</aside>
