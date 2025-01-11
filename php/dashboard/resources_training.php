<?php
include('../session.php'); // Ensure the user is logged in
include('../connection.php'); // Include the database connection
require_once '../config.php';

// Define variables for Page Titles and Sidebar Active effects
$pageTitle = 'Career Path | Resources & Training';
$activePage = 'Training';

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
            <div class="container-fluid">
                <!-- Page Header -->
                <div class="app-content-header">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3 class="mb-0">Resources and Training</h3>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-end">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Resources and Training</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Row 1: Resources Section -->
                <div class="row">
                    <!-- Available Resources Section -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h5>Available Resources</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#resourcesModal"
                                    data-title="Teaching and Learning Materials"
                                    data-description="Access to all necessary teaching and learning materials including guides, lecture slides, and video tutorials.">
                                        <li class="list-group-item list-group-item-action bg-light-hover">Teaching and Learning Materials</li>
                                    </a>
                                    <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#resourcesModal"
                                    data-title="Research Publications"
                                    data-description="Get access to the latest research publications, papers, and journals.">
                                        <li class="list-group-item list-group-item-action bg-secondary-hover">Research Publications</li>
                                    </a>
                                    <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#resourcesModal"
                                    data-title="Policy Guidelines"
                                    data-description="University and departmental policy guidelines on teaching, research, and academic management.">
                                        <li class="list-group-item list-group-item-action bg-light-hover">Policy Guidelines</li>
                                    </a>
                                    <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#resourcesModal"
                                    data-title="E-Books"
                                    data-description="Access to a large collection of e-books across various subjects.">
                                        <li class="list-group-item list-group-item-action bg-secondary-hover">E-Books</li>
                                    </a>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Training and Workshops Section -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h5>Training and Workshops</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#trainingModal"
                                    data-title="Pedagogical Workshops"
                                    data-description="Hands-on workshops for improving teaching techniques and classroom management.">
                                        <li class="list-group-item list-group-item-action bg-light-hover">Pedagogical Workshops</li>
                                    </a>
                                    <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#trainingModal"
                                    data-title="Technical Skills Development"
                                    data-description="Training on the latest technical tools and software relevant to your field.">
                                        <li class="list-group-item list-group-item-action bg-secondary-hover">Technical Skills Development</li>
                                    </a>
                                    <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#trainingModal"
                                    data-title="Research Methodology"
                                    data-description="Advanced research methodology training for faculty members.">
                                        <li class="list-group-item list-group-item-action bg-light-hover">Research Methodology</li>
                                    </a>
                                    <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#trainingModal"
                                    data-title="Leadership Training"
                                    data-description="Leadership skills development for faculty management and academic leadership.">
                                        <li class="list-group-item list-group-item-action bg-secondary-hover">Leadership Training</li>
                                    </a>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Content Row 2: Upcoming Training Events Section -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h5>Upcoming Training Events</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Event</th>
                                            <th>Date</th>
                                            <th>Location</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr data-bs-toggle="modal" data-bs-target="#eventModal"
                                            data-title="Teaching with Technology Workshop"
                                            data-date="October 25, 2024"
                                            data-location="Virtual"
                                            data-status="Open for Registration">
                                            <td>Teaching with Technology Workshop</td>
                                            <td>October 25, 2024</td>
                                            <td>Virtual</td>
                                            <td><span class="badge bg-success">Open for Registration</span></td>
                                        </tr>
                                        <tr data-bs-toggle="modal" data-bs-target="#eventModal"
                                            data-title="Advanced Research Seminar"
                                            data-date="November 10, 2024"
                                            data-location="Campus Auditorium"
                                            data-status="Almost Full">
                                            <td>Advanced Research Seminar</td>
                                            <td>November 10, 2024</td>
                                            <td>Campus Auditorium</td>
                                            <td><span class="badge bg-warning text-dark">Almost Full</span></td>
                                        </tr>
                                        <tr data-bs-toggle="modal" data-bs-target="#eventModal"
                                            data-title="Leadership Skills for Educators"
                                            data-date="December 5, 2024"
                                            data-location="Conference Room B"
                                            data-status="Full">
                                            <td>Leadership Skills for Educators</td>
                                            <td>December 5, 2024</td>
                                            <td>Conference Room B</td>
                                            <td><span class="badge bg-danger">Full</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modals -->
            <!-- Resource Modal -->
            <div class="modal fade" id="resourcesModal" tabindex="-1" aria-labelledby="resourcesModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="resourcesModalLabel">Resource Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p id="resourcesDescription"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Training Modal -->
            <div class="modal fade" id="trainingModal" tabindex="-1" aria-labelledby="trainingModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="trainingModalLabel">Training Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p id="trainingDescription"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Event Modal -->
            <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="eventModalLabel">Event Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Date:</strong> <span id="eventDate"></span></p>
                            <p><strong>Location:</strong> <span id="eventLocation"></span></p>
                            <p><strong>Status:</strong> <span id="eventStatus"></span></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

    <!-- MODAL -->
    <script>
        // For resources
        document.querySelectorAll('a[data-bs-target="#resourcesModal"]').forEach(function(element) {
            element.addEventListener('click', function() {
                const title = this.getAttribute('data-title');
                const description = this.getAttribute('data-description');
                
                document.getElementById('resourcesModalLabel').textContent = title;
                document.getElementById('resourcesDescription').textContent = description;
            });
        });
        // Francesca
        document.querySelectorAll('a[data-bs-target="#trainingModal"]').forEach(function(element) {
            element.addEventListener('click', function() {
                const title = this.getAttribute('data-title');
                const description = this.getAttribute('data-description');
                
                document.getElementById('trainingModalLabel').textContent = title;
                document.getElementById('trainingDescription').textContent = description;
            });
        });
        // For events
        document.querySelectorAll('tr[data-bs-target="#eventModal"]').forEach(function(element) {
            element.addEventListener('click', function() {
                const title = this.getAttribute('data-title');
                const date = this.getAttribute('data-date');
                const location = this.getAttribute('data-location');
                const status = this.getAttribute('data-status');
                
                document.getElementById('eventModalLabel').textContent = title;
                document.getElementById('eventDate').textContent = date;
                document.getElementById('eventLocation').textContent = location;
                document.getElementById('eventStatus').textContent = status;
            });
        });
    </script>

</body>
</html>


