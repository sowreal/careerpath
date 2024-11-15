<?php
include('../../session.php'); // Ensure the user is logged in
include('../../connection.php'); // Include the database connection
require_once '../../config.php';

// Define variables for Page Titles and Sidebar Active effects
$pageTitle = 'Career Path | Career Tracking';
$activePage = 'CPT_Teaching';

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
        <?php require_once('../../includes/navbar.php'); ?>
        <!--end::Header--> 
        
        <!--begin::Sidebar-->
        <?php require_once('../../includes/sidebar_faculty.php'); ?> 
        <!--end::Sidebar--> 
        

        <!--begin::App Main-->
        <main class="app-main">
            <div class="container-fluid mt-4">

                <!-- Standalone Header -->
                <div class="app-content-header">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3 class="mb-0">Teaching Performance (KRA I)</h3>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-end">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Teaching Performance Metrics</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Section -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-success text-white">
                                <h5 class="card-title mb-0">Teaching Metrics Input</h5>
                            </div>
                            <div class="card-body bg-white">
                                <form>
                                    <!-- Faculty Information -->
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="lastName" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="lastName" placeholder="Enter last name">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="firstName" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="firstName" placeholder="Enter first name">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="middleName" class="form-label">Middle Name</label>
                                            <input type="text" class="form-control" id="middleName" placeholder="Enter middle name">
                                        </div>
                                    </div>

                                    <!-- Teaching Activity Input -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="teachingMaterial" class="form-label">Teaching Material</label>
                                            <select class="form-select" id="teachingMaterial">
                                                <option selected>Choose...</option>
                                                <option value="Textbook">Textbook</option>
                                                <option value="Textbook Chapter">Textbook Chapter</option>
                                                <option value="Manual/Module">Manual/Module</option>
                                                <option value="Multimedia Material">Multimedia Teaching Material</option>
                                                <option value="Testing Material">Testing Material</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="pointsEarned" class="form-label">Points Earned</label>
                                            <input type="number" class="form-control" id="pointsEarned" placeholder="Enter points">
                                        </div>
                                    </div>

                                    <!-- Submission Status -->
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select" id="status">
                                                <option selected>Choose...</option>
                                                <option value="Not Applicable">Not Applicable</option>
                                                <option value="Study Leave">On Approved Study Leave</option>
                                                <option value="Sabbatical Leave">On Approved Sabbatical Leave</option>
                                                <option value="Maternity Leave">On Approved Maternity Leave</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="row">
                                        <div class="col-md-12 text-end">
                                            <button type="submit" class="btn btn-success">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Summary Section -->
                <div class="row mt-5">
                    <div class="col-lg-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-success text-white">
                                <h5 class="card-title mb-0">Teaching Summary</h5>
                            </div>
                            <div class="card-body bg-white">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Material Type</th>
                                            <th>Points</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Example row, to be dynamically generated -->
                                        <tr>
                                            <td>1</td>
                                            <td>Textbook</td>
                                            <td>5</td>
                                            <td>Approved</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Manual/Module</td>
                                            <td>10</td>
                                            <td>Pending</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

<!--end::App Main-->
        
        
        
        <!--begin::Footer-->   
            <?php require_once('../../includes/footer.php'); ?> 
        <!--end::Footer-->
    </div> 
    <!--end::App Wrapper--> 
    
        
    <!--begin::Script--> 
    <?php require_once('../../includes/dashboard_default_scripts.php'); ?> 


</body>
</html>


