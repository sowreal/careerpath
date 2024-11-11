<?php
include('../session.php'); // Ensure the user is logged in
include('../connection.php'); // Include the database connection

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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Career Path | Performance Report</title>
    
    <!-- Meta Tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="AdminLTE v4 | Dashboard">
    <meta name="author" content="ColorlibHQ">
    <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS.">
    <meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous">

    <!-- Third Party Plugins -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous">

    <!-- Required Plugin (AdminLTE) -->
    <link rel="stylesheet" href="../../AdminLTE/dist/css/adminlte.min.css">

    <!-- apexcharts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css" integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous">

    <!-- jsvectormap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css" integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4=" crossorigin="anonymous">


    <!-- Your Custom Global Styles -->
    <link rel="stylesheet" href="../../css/global.css">
    <!-- Sidebar BG Override -->
    <link rel="stylesheet" href="../../css/dashboard/faculty_overrides.css">
    <link rel="stylesheet" href="../../css/dashboard/faculty_sidebar_footer.css">

</head>


<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
    <div class="app-wrapper"> <!--begin::Header-->
        <nav class="app-header navbar navbar-expand bg-body"> 
            <!--begin::Container-->
            <div class="container-fluid"> 
                <!--begin::Start Navbar Links-->
                <ul class="navbar-nav">
                    <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="bi bi-list"></i> </a> </li>
                    <li class="nav-item d-none d-md-block"> <a href="#" class="nav-link">Home</a> </li>
                    <li class="nav-item d-none d-md-block"> <a href="#" class="nav-link">Contact</a> </li>
                </ul> <!--end::Start Navbar Links--> <!--begin::End Navbar Links-->
                
                <ul class="navbar-nav ms-auto"> 
                    <!--begin::Navbar Search-->
                    <li class="nav-item"> <a class="nav-link" data-widget="navbar-search" href="#" role="button"> <i class="bi bi-search"></i> </a> </li> <!--end::Navbar Search--> <!--begin::Messages Dropdown Menu-->
                    <li class="nav-item dropdown"> <a class="nav-link" data-bs-toggle="dropdown" href="#"> <i class="bi bi-chat-text"></i> <span class="navbar-badge badge text-bg-danger">3</span> </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end"> <a href="#" class="dropdown-item"> <!--begin::Message-->
                                <div class="d-flex">
                                    <div class="flex-shrink-0"> <img src="../../AdminLTE/dist/assets/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 rounded-circle me-3"> </div>
                                    <div class="flex-grow-1">
                                        <h3 class="dropdown-item-title">
                                            Brad Diesel
                                            <span class="float-end fs-7 text-danger"><i class="bi bi-star-fill"></i></span>
                                        </h3>
                                        <p class="fs-7">Call me whenever you can...</p>
                                        <p class="fs-7 text-secondary"> <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                                        </p>
                                    </div>
                                </div> <!--end::Message-->
                            </a>
                            <div class="dropdown-divider"></div> <a href="#" class="dropdown-item"> <!--begin::Message-->
                                <div class="d-flex">
                                    <div class="flex-shrink-0"> <img src="../../AdminLTE/dist/assets/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 rounded-circle me-3"> </div>
                                    <div class="flex-grow-1">
                                        <h3 class="dropdown-item-title">
                                            John Pierce
                                            <span class="float-end fs-7 text-secondary"> <i class="bi bi-star-fill"></i> </span>
                                        </h3>
                                        <p class="fs-7">I got your message bro</p>
                                        <p class="fs-7 text-secondary"> <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                                        </p>
                                    </div>
                                </div> <!--end::Message-->
                            </a>
                            <div class="dropdown-divider"></div> <a href="#" class="dropdown-item"> <!--begin::Message-->
                                <div class="d-flex">
                                    <div class="flex-shrink-0"> <img src="../../AdminLTE/dist/assets/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 rounded-circle me-3"> </div>
                                    <div class="flex-grow-1">
                                        <h3 class="dropdown-item-title">
                                            Nora Silvester
                                            <span class="float-end fs-7 text-warning"> <i class="bi bi-star-fill"></i> </span>
                                        </h3>
                                        <p class="fs-7">The subject goes here</p>
                                        <p class="fs-7 text-secondary"> <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                                        </p>
                                    </div>
                                </div> <!--end::Message-->
                            </a>
                            <div class="dropdown-divider"></div> <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                        </div>
                    </li> <!--end::Messages Dropdown Menu--> <!--begin::Notifications Dropdown Menu-->
                    <li class="nav-item dropdown"> <a class="nav-link" data-bs-toggle="dropdown" href="#"> <i class="bi bi-bell-fill"></i> <span class="navbar-badge badge text-bg-warning">15</span> </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end"> <span class="dropdown-item dropdown-header">15 Notifications</span>
                            <div class="dropdown-divider"></div> <a href="notifications.php#" class="dropdown-item"> <i class="bi bi-envelope me-2"></i> 4 new messages
                                <span class="float-end text-secondary fs-7">3 mins</span> </a>
                            <div class="dropdown-divider"></div> <a href="notifications.php" class="dropdown-item"> <i class="bi bi-people-fill me-2"></i> 8 friend requests
                                <span class="float-end text-secondary fs-7">12 hours</span> </a>
                            <div class="dropdown-divider"></div> <a href="notifications.php" class="dropdown-item"> <i class="bi bi-file-earmark-fill me-2"></i> 3 new reports
                                <span class="float-end text-secondary fs-7">2 days</span> </a>
                            <div class="dropdown-divider"></div> <a href="notifications.php" class="dropdown-item dropdown-footer">
                                See All Notifications
                            </a>
                        </div>
                    </li> <!--end::Notifications Dropdown Menu--> <!--begin::Fullscreen Toggle-->
                    <li class="nav-item"> <a class="nav-link" href="#" data-lte-toggle="fullscreen"> <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i> <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i> </a> </li> <!--end::Fullscreen Toggle--> <!--begin::User Menu Dropdown-->
                    <li class="nav-item dropdown user-menu"> 
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"> 
                            <img src="<?php echo (!empty($_SESSION['profile_picture'])) ? '../../uploads/' . $_SESSION['profile_picture'] : '../../img/cropped-SLSU_Logo-1.png'; ?>" class="user-image rounded-circle shadow" alt="User Image"> 
                            <span class="d-none d-md-inline"><?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end"> 
                            <!--begin::User Image-->
                            <li class="user-header text-bg-success"> <img src="<?php echo (!empty($_SESSION['profile_picture'])) ? '../../uploads/' . $_SESSION['profile_picture'] : '../../img/cropped-SLSU_Logo-1.png'; ?>" class="rounded-circle shadow" alt="User Image">
                                <p>
                                <?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];?> - <?php echo $_SESSION['role'] . '<br>' . $_SESSION['department'];?>
                                    <small>Member since <?php echo $formattedCreatedAt; ?></small>
                                </p>
                            </li> 
                            <!--end::User Image--> 

                            <!--begin::Menu Body-->
                            <li class="user-body"> 
                                <!--begin::Row-->
                                <div class="row">
                                    <div class="col-4 text-center"> <a href="#">Followers</a> </div>
                                    <div class="col-4 text-center"> <a href="#">Sales</a> </div>
                                    <div class="col-4 text-center"> <a href="#">Friends</a> </div>
                                </div> 
                                <!--end::Row-->
                            </li> 
                            <!--end::Menu Body--> 
                            
                            <!--begin::Menu Footer-->
                            <li class="user-footer"> <a href="#" class="btn btn-default btn-flat">Profile</a> <a href="../logout.php" class="btn btn-default btn-flat float-end">Sign out</a> </li> <!--end::Menu Footer-->
                        </ul>
                    </li> 
                    <!--end::User Menu Dropdown-->

                    <!-- TOGGLE DARK MODE START -->
                    <li class="nav-item dropdown">
                        <button
                            class="btn btn-link nav-link py-2 px-0 px-lg-2 dropdown-toggle d-flex align-items-center"
                            id="bd-theme"
                            type="button"
                            aria-expanded="false"
                            data-bs-toggle="dropdown"
                            data-bs-display="static"
                            >
                            <span class="theme-icon-active">
                                <i class="my-1"></i>
                            </span>
                            <span class="d-lg-none ms-2" id="bd-theme-text"></span>
                        </button>
                        <ul
                            class="dropdown-menu dropdown-menu-end"
                            aria-labelledby="bd-theme-text"
                            style="--bs-dropdown-min-width: 8rem;"
                            >
                            <li>
                                <button
                                type="button"
                                class="dropdown-item d-flex align-items-center active"
                                data-bs-theme-value="light"
                                aria-pressed="false"
                                >
                                <i class="bi bi-sun-fill me-2"></i>
                                Light
                                <i class="bi bi-check-lg ms-auto d-none"></i>
                                </button>
                            </li>
                            <li>
                                <button
                                type="button"
                                class="dropdown-item d-flex align-items-center"
                                data-bs-theme-value="dark"
                                aria-pressed="false"
                                >
                                <i class="bi bi-moon-fill me-2"></i>
                                Dark
                                <i class="bi bi-check-lg ms-auto d-none"></i>
                                </button>
                            </li>
                            <li>
                                <button
                                type="button"
                                class="dropdown-item d-flex align-items-center"
                                data-bs-theme-value="auto"
                                aria-pressed="true"
                                >
                                <i class="bi bi-circle-fill-half-stroke me-2"></i>
                                Auto
                                <i class="bi bi-check-lg ms-auto d-none"></i>
                                </button>
                            </li>
                        </ul>
                    </li>
                    <!-- TOGGLE DARK MODE END -->
                </ul> 
                <!--end::End Navbar Links-->
            </div> 
            <!--end::Container-->
        </nav> 
        <!--end::Header--> 
        
        <!--begin::Sidebar-->
        <aside class="app-sidebar sidebar-bg shadow" data-bs-theme="dark"> 
            <!--begin::Sidebar Brand-->
            <div class="sidebar-brand sidebar-bg-top"> 
                <!--begin::Brand Link--> 
                <a href="dashboard_faculty.php" class="brand-link"> 
                    <!--begin::Brand Image--> 
                    <img src="../../img/cropped-SLSU_Logo-1.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow"> <!--end::Brand Image--> 

                    <!--begin::Brand Text--> 
                    <span class="brand-text fw-light">SLSU Career Path</span>
                    <!--end::Brand Text--> 
                </a><!--end::Brand Link--> 
            </div><!--end::Sidebar Brand--> 
            
            <!--begin::Sidebar Wrapper-->
            <div class="sidebar-wrapper">
                <nav class="mt-2"> 
                    <!--begin::Sidebar Menu-->
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                        <li class="nav-item"> <a href="dashboard_faculty.php" class="nav-link"> <i class="nav-icon bi bi-speedometer2"></i>
                                <p><strong>Dashboard</strong>
                                <!-- <i class="nav-arrow bi bi-chevron-right"></i> -->
                                </p>
                            </a>
                        </li>

                        <li class="nav-item"> <a href="profile_management.php" class="nav-link"> <i class="nav-icon bi bi-person-circle"></i>
                                <p><strong>Profile Management</strong></p>
                            </a> 
                        </li>

                        <li class="nav-item"> <a href="career_progress_tracking.php" class="nav-link"> <i class="nav-icon bi bi-box-seam"></i>
                                <p><strong>Career Progress Tracking</strong></p>
                            </a>
                            <!-- <ul class="nav nav-treeview">
                                <li class="nav-item"> francesca <a href="#" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Career Goals</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Milestone Achievements</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Performance Overview</p>
                                    </a> 
                                </li>
                            </ul> -->
                        </li>
                        
                        <li class="nav-item"> <a href="document_management.php" class="nav-link"> <i class="nav-icon bi bi-folder"></i>
                                <p><strong>Document Management</strong></p>
                            </a>
                        </li>

                        <li class="nav-item"> <a href="notifications.php" class="nav-link"> <i class="nav-icon bi bi-bell"></i>
                                <p><strong>Notifications</strong>
                                </p>
                            </a>
                            <!-- <ul class="nav nav-treeview">
                                <li class="nav-item"> <a href="./UI/general.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>General</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="./UI/icons.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Icons</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="./UI/timeline.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Timeline</p>
                                    </a> </li>
                            </ul> -->
                        </li>

                        <li class="nav-item"> <a href="opportunities.php" class="nav-link active"> <i class="nav-icon bi bi-briefcase"></i>
                                <p><strong>Job/Promotion Opportunities</strong>
                                </p>
                            </a>
                        </li>

                        <li class="nav-item"> <a href="performance_summary_report.php" class="nav-link"> <i class="nav-icon bi bi-bar-chart"></i>
                                <p><strong>Performance Summary Reports</strong>
                                </p>
                            </a>
                        </li>

                        <li class="nav-item"> <a href="resources_training.php" class="nav-link"> <i class="nav-icon bi bi-book"></i>
                                <p><strong>Resources and Training</strong></p>
                            </a>
                        </li>
                    </ul> <!--end::Sidebar Menu-->
                </nav>
            </div> <!--end::Sidebar Wrapper-->

            <!-- Sidebar Footer -->
            <div class="sidebar-footer">
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-gear"></i>
                                <p><strong>Settings</strong>
                                </p><i class="nav-arrow bi bi-chevron-right"></i>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-box-arrow-in-right"></i>
                                        <p>
                                        Account Settings
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-box-arrow-in-right"></i>
                                        <p>
                                        Privacy Settings
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item"> <a href="../logout.php" class="nav-link"> <i class="nav-icon bi bi-box-arrow-right"></i>
                                <p><strong>Logout</strong></p> </a>
                        </li>
                    </ul>
                </nav>
            </div>

        </aside> 
        <!--end::Sidebar--> 
        

        <!--begin::App Main-->
        <main class="app-main"><!--begin::App Content Header-->
        </main> 
        <!--end::App Main-->
        
        
        
        <!--begin::Footer-->   
        <footer class="app-footer"> 
            <!--begin::To the end-->
            <div class="float-end d-none d-sm-inline">Anything you want</div> <!--end::To the end--> <!--begin::Copyright--> <strong>
                Copyright &copy; 2014-2024&nbsp;
                <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.
            </strong>
            All rights reserved.
            <!--end::Copyright-->
        </footer> 
        <!--end::Footer-->
    </div> 
    <!--end::App Wrapper--> 
    
        
    <!--begin::Script--> 
    <!--begin::Third Party Plugin(OverlayScrollbars)-->       
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script> <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script> <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script> <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="../../dist/js/adminlte.js"></script> <!--end::Required Plugin(AdminLTE)-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart script -->
    
    
    <!--begin::OverlayScrollbars Configure-->
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
        const Default = {
            scrollbarTheme: "os-theme-light",
            scrollbarAutoHide: "leave",
            scrollbarClickScroll: true,
        };
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (
                sidebarWrapper &&
                typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined"
            ) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>



    <!-- TOTTGLE DARK MODE -->
    <script src="../../js/dashboards/color_mode.js"></script>


    <!-- AdminLTE JS -->
    <script src="../../AdminLTE/dist/js/jquery.min.js"></script>
    <script src="../../AdminLTE/dist/js/adminlte.min.js"></script>
</body>
</html>


