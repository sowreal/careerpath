<?php
// kra_summary_HR.php

require_once '../../session.php'; 
require_once '../../connection.php';
require_once '../../config.php';

// Define variables for Page Titles and Sidebar Active effects
$pageTitle = 'Career Path | KRA Summary';
$activePage = 'KRA Summary';

// Check user authorization
if ($_SESSION['role'] != 'Human Resources') {
    // Handle unauthorized users
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();

    echo "<script>
            alert('Your account is not authorized. Redirecting to login page.');
            window.location.href = '../../login.php';
          </script>";
    exit();
}

// Retrieve GET parameters and sanitize them
$faculty_id = isset($_GET['faculty_id']) ? intval($_GET['faculty_id']) : 0;
$request_id = isset($_GET['request_id']) ? intval($_GET['request_id']) : 0;

// Validate GET parameters
if ($faculty_id <= 0 || $request_id <= 0) {
    echo "<script>
            alert('Invalid faculty or request ID.');
            window.location.href = '../faculty_management.php';
          </script>";
    exit();
}

// Fetch faculty details from the database
$stmt = $conn->prepare("SELECT faculty_name, department, date_joined FROM faculty WHERE faculty_id = :faculty_id");
$stmt->execute([':faculty_id' => $faculty_id]);
$faculty = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$faculty) {
    echo "<script>
            alert('Faculty member not found.');
            window.location.href = '../faculty_management.php';
          </script>";
    exit();
}

// Fetch request details from the database
$stmt = $conn->prepare("SELECT request_date, status FROM requests WHERE request_id = :request_id AND faculty_id = :faculty_id");
$stmt->execute([':request_id' => $request_id, ':faculty_id' => $faculty_id]);
$request = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$request) {
    echo "<script>
            alert('Request not found.');
            window.location.href = 'faculty_management.php';
          </script>";
    exit();
}

$faculty_name = $faculty['faculty_name'];
$department = $faculty['department'];
$date_joined = $faculty['date_joined'];
$request_date = $request['request_date'];
$request_status = $request['status'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once '../../includes/header.php' ?>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> 
    <!--begin::App Wrapper-->
    <div class="app-wrapper"> 
        <!--begin::Header-->
        <?php require_once('../../includes/navbar.php'); ?>
        <!--end::Header--> 
        
        <!--begin::Sidebar-->
        <?php require_once('../../includes/sidebar_HR.php'); ?> 
        <!--end::Sidebar--> 

        <!--begin::App Main-->
        <main class="app-main">
            <section class="content">
                <div class="container-fluid">
                    <!-- Standalone Header -->
                    <div class="app-content-header"> 
                        <!--begin::Container-->
                        <div class="container-fluid"> 
                            <!--begin::Row-->
                            <div class="row">
                                <div class="col-sm-6">
                                    <h3 class="mb-0">KRA Summary</h3>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-end">
                                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                                        <li class="breadcrumb-item"><a href="faculty_management.php">Faculty Management</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            KRA Summary
                                        </li>
                                    </ol>
                                </div>
                            </div> <!--end::Row-->
                        </div> <!--end::Container-->
                    </div> 

                    <div class="container my-4">
                        <!-- Breadcrumb or Back Link -->
                        <div class="mb-3">
                            <a href="faculty_management.php" class="btn btn-sm btn-outline-secondary">&laquo; Back to Faculty Management</a>
                        </div>

                        <!-- Faculty and Request Info -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h4 class="card-title mb-3">Career Progress Summary</h4>
                                <p><strong>Faculty Name:</strong> <?php echo htmlspecialchars($faculty_name); ?></p>
                                <p><strong>Department:</strong> <?php echo htmlspecialchars($department); ?></p>
                                <p><strong>Date Joined:</strong> <?php echo htmlspecialchars($date_joined); ?></p>
                                <p><strong>Request ID:</strong> <?php echo htmlspecialchars($request_id); ?></p>
                                <p><strong>Request Date:</strong> <?php echo htmlspecialchars($request_date); ?></p>
                                <p><strong>Request Status:</strong> <?php echo htmlspecialchars($request_status); ?></p>
                                <!-- Add more summary info as needed -->
                            </div>
                        </div>

                        <!-- Tabs for KRAs -->
                        <ul class="nav nav-tabs" id="kraTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="kra1-tab" data-bs-toggle="tab" data-bs-target="#kra1" type="button" role="tab" aria-controls="kra1" aria-selected="true">KRA I (Teaching)</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="kra2-tab" data-bs-toggle="tab" data-bs-target="#kra2" type="button" role="tab" aria-controls="kra2" aria-selected="false">KRA II (Research)</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="kra3-tab" data-bs-toggle="tab" data-bs-target="#kra3" type="button" role="tab" aria-controls="kra3" aria-selected="false">KRA III (Extension)</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="kra4-tab" data-bs-toggle="tab" data-bs-target="#kra4" type="button" role="tab" aria-controls="kra4" aria-selected="false">KRA IV (Prof. Development)</button>
                            </li>
                        </ul>

                        <div class="tab-content border border-top-0 p-3 bg-white" id="kraTabsContent">
                            <!-- KRA 1 Content -->
                            <div class="tab-pane fade show active" id="kra1" role="tabpanel" aria-labelledby="kra1-tab">
                                <h5>KRA I (Teaching) Summary</h5>
                                <p>Summary metrics here, e.g., overall ratings, hours taught, etc.</p>
                                <a href="kra1_HR.php?faculty_id=<?php echo $faculty_id; ?>&request_id=<?php echo $request_id; ?>" class="btn btn-sm btn-primary">View KRA I Details</a>
                            </div>

                            <!-- KRA 2 Content -->
                            <div class="tab-pane fade" id="kra2" role="tabpanel" aria-labelledby="kra2-tab">
                                <h5>KRA II (Research, Innovation, & Creative Works) Summary</h5>
                                <p>Summary of research outputs, publications, etc.</p>
                                <a href="kra2_HR.php?faculty_id=<?php echo $faculty_id; ?>&request_id=<?php echo $request_id; ?>" class="btn btn-sm btn-primary">View KRA II Details</a>
                            </div>

                            <!-- KRA 3 Content -->
                            <div class="tab-pane fade" id="kra3" role="tabpanel" aria-labelledby="kra3-tab">
                                <h5>KRA III (Extension Services) Summary</h5>
                                <p>Summary of extension services, community engagement, etc.</p>
                                <a href="kra3_HR.php?faculty_id=<?php echo $faculty_id; ?>&request_id=<?php echo $request_id; ?>" class="btn btn-sm btn-primary">View KRA III Details</a>
                            </div>

                            <!-- KRA 4 Content -->
                            <div class="tab-pane fade" id="kra4" role="tabpanel" aria-labelledby="kra4-tab">
                                <h5>KRA IV (Professional Development) Summary</h5>
                                <p>Summary of trainings, certifications, conferences, etc.</p>
                                <a href="kra4_HR.php?faculty_id=<?php echo $faculty_id; ?>&request_id=<?php echo $request_id; ?>" class="btn btn-sm btn-primary">View KRA IV Details</a>
                            </div>
                        </div>

                        <!-- Back to Faculty Management link at bottom as well -->
                        <div class="mt-4">
                            <a href="faculty_management.php" class="btn btn-sm btn-outline-secondary">&laquo; Back to Faculty Management</a>
                        </div>
                    </div>
                </div>  
            </section>
        </main>
        <!--end::App Main-->

        <!--begin::Footer-->   
            <?php require_once('../../includes/footer.php'); ?> 
        <!--end::Footer-->
    </div> 
    <!--end::App Wrapper--> 
        
        
    <!--begin::Script--> 
    <?php require_once('../../includes/dashboard_default_scripts.php'); ?> 

    <!-- Remove Unnecessary JS -->
    <!--
    <script>
        document.querySelector('#submitRequestButton').addEventListener('click', function(event) {
            // Reference the form element
            const form = document.querySelector('form');
            
            // Check if the form is valid using the HTML5 checkValidity method
            if (form.checkValidity()) {
                // If valid, prevent the default action and show the confirmation modal
                event.preventDefault();
                $('#confirmationModal').modal('show');
            } else {
                // If not valid, let the browser display the validation messages
                form.reportValidity();
            }
        });

        // Event listener for the Agree and Submit button inside the modal
        document.querySelector('#confirmSubmitButton').addEventListener('click', function() {
            // Submit the form when the user clicks "Agree and Submit" in the modal
            document.querySelector('form').submit();
        });
    </script>
    -->
</body>
</html>
