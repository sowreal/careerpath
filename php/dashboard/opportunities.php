<?php
include('../session.php'); // Ensure the user is logged in
include('../connection.php'); // Include the database connection
require_once '../config.php';

// Define variables for Page Titles and Sidebar Active effects
$pageTitle = 'Career Path | Opportunities';
$activePage = 'Opportunities';

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
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Job & Promotion Opportunities</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Job Opportunities</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header bg-success bg-gradient text-white">
                                    <h5>Available Opportunities</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        <!-- Mocked Job Opportunity 1 -->
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6>Assistant Professor - Computer Science Department</h6>
                                                <p class="mb-0">A tenure-track position with a focus on research in AI and machine learning.</p>
                                            </div>
                                            <div>
                                                <span class="badge bg-info">Deadline: Oct 30, 2024</span>
                                                <a href="#" class="btn btn-link view-details" data-title="Assistant Professor - Computer Science Department" data-description="A tenure-track position focusing on research in AI and machine learning." data-deadline="Oct 30, 2024" data-requirements="PhD in Computer Science, research publications in AI, and experience in teaching AI courses.">View Details</a>
                                            </div>
                                        </li>
                                        
                                        <!-- Mocked Job Opportunity 2 -->
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6><!--FDG-->Head of Research - Engineering Department</h6>
                                                <p class="mb-0">Oversee research projects and mentor faculty in research methodologies.</p>
                                            </div>
                                            <div>
                                                <span class="badge bg-info">Deadline: Nov 15, 2024</span>
                                                <a href="#" class="btn btn-link view-details" data-title="Head of Research - Engineering Department" data-description="Oversee research projects and mentor faculty in research methodologies." data-deadline="Nov 15, 2024" data-requirements="PhD in Engineering, 5+ years of research leadership, and a track record of research publications.">View Details</a>
                                            </div>
                                        </li>
                                        
                                        <!-- Mocked Job Opportunity 3 -->
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6>Promotion to Associate Professor</h6>
                                                <p class="mb-0">Eligible for faculty with outstanding teaching and research contributions.</p>
                                            </div>
                                            <div>
                                                <span class="badge bg-info">Deadline: Dec 1, 2024</span>
                                                <a href="#" class="btn btn-link view-details" data-title="Promotion to Associate Professor" data-description="Eligible for faculty with outstanding teaching and research contributions." data-deadline="Dec 1, 2024" data-requirements="Minimum 5 years of service, research publications, and teaching excellence awards.">View Details</a>
                                            </div>
                                        </li>
                                        
                                        <!-- Add more opportunities here as needed -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for Viewing Job Details -->
            <div class="modal fade" id="jobDetailsModal" tabindex="-1" aria-labelledby="jobDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-success-subtle">
                            <h5 class="modal-title" id="jobDetailsModalLabel">Job Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h6><strong>Title:</strong> <span id="jobTitle"></span></h6>
                            <p><strong>Description:</strong> <span id="jobDescription"></span></p>
                            <p><strong>Application Deadline:</strong> <span id="jobDeadline"></span></p>
                            <p><strong>Requirements:</strong> <span id="jobRequirements"></span></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
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

    <!-- MODAL For View -->
    <script>
        document.querySelectorAll('.view-details').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                
                // Get the data from the button's data attributes
                const title = this.getAttribute('data-title');
                const description = this.getAttribute('data-description');
                const deadline = this.getAttribute('data-deadline');
                const requirements = this.getAttribute('data-requirements');
                
                // Populate the modal with francesca job details
                document.getElementById('jobTitle').innerText = title;
                document.getElementById('jobDescription').innerText = description;
                document.getElementById('jobDeadline').innerText = deadline;
                document.getElementById('jobRequirements').innerText = requirements;
                
                // Show the modal
                const modal = new bootstrap.Modal(document.getElementById('jobDetailsModal'));
                modal.show();
            });
        });
    </script>

</body>
</html>


