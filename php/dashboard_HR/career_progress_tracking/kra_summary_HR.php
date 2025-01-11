<?php
// kra_summary_HR.php

require_once '../../session.php'; 
require_once '../../connection.php';
require_once '../../config.php';

// Define variables for Page Titles and Sidebar Active effects
$pageTitle = 'Career Path | KRA Summary';
$activePage = 'KRA Summary';

// Check if the user is HR
if ($_SESSION['role'] != 'Human Resources') {
    header("Location: ../../login.php");
    exit();
}

// Get faculty ID from URL
$faculty_id = isset($_GET['faculty_id']) ? intval($_GET['faculty_id']) : 0;

if ($faculty_id <= 0) {
    echo "Invalid faculty member.";
    exit;
}

// Fetch faculty information
try {
    $stmt = $conn->prepare("SELECT first_name, middle_name, last_name, department, faculty_rank FROM users WHERE id = :id AND role IN ('Permanent Instructor', 'Contract of Service Instructor')");
    $stmt->bindParam(':id', $faculty_id, PDO::PARAM_INT);
    $stmt->execute();
    $faculty = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$faculty) {
        echo "Faculty member not found.";
        exit;
    }
} catch (PDOException $e) {
    echo "Error fetching faculty data: " . $e->getMessage();
    exit;
}

// Fetch KRA summaries (Replace these with actual database queries)


// echo $faculty_id;
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
                                    <?php if ($_SESSION['role'] == 'Human Resources'): ?>
                                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/php/dashboard_HR/dashboard_HR.php">Home</a></li>
                                    <?php else: ?>
                                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/php/dashboard_faculty.php">Home</a></li>
                                    <?php endif; ?>
                                    <li class="breadcrumb-item"><a href="../faculty_management.php">Faculty Management</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">KRA Summary</li>
                                </ol>
                            </div>
                        </div> <!--end::Row-->
                    </div> <!--end::Container-->
                </div> 


                <!-- KRA Summary Contents -->
                <?php require_once BASE_PATH . '/php/includes/career_progress_tracking_hr/teaching/kra1.php';?>


                <!-- Container for Criteria -->
                <div class="card mt-4">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="kra-tabs" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active bg-success text-white" id="tab-criterion-a" data-bs-toggle="tab" data-bs-target="#criterion-a" type="button" role="tab">
                                    Criterion A: Teaching Effectiveness
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="tab-criterion-b" data-bs-toggle="tab" data-bs-target="#criterion-b" type="button" role="tab">
                                    Criterion B: Curriculum & Material Development
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="tab-criterion-c" data-bs-toggle="tab" data-bs-target="#criterion-c" type="button" role="tab">
                                    Criterion C: Thesis & Mentorship Services
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Criterions section -->
                    <div class="card-body">
                        <div class="tab-content" id="kra-tab-content">
                            <!-- Tab 1: Criterion A: Teaching Effectiveness -->
                            <?php require_once BASE_PATH . '/php/includes/career_progress_tracking/teaching/criterion_a.php'; ?> 
                            <!-- Tab 2: Criterion B: Curriculum & Material Development -->
                            <?php require_once BASE_PATH . '/php/includes/career_progress_tracking/teaching/criterion_b.php'; ?> 
                            <!-- Tab 3: Criterion C: Thesis & Mentorship Services -->
                            <?php require_once BASE_PATH . '/php/includes/career_progress_tracking/teaching/criterion_c.php'; ?>
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
    <?php require_once BASE_PATH . '/php/includes/dashboard_default_scripts.php'; ?> 

    <!-- Script Links for Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Career Progress Teaching Scripts -->
    <script src="<?php echo BASE_URL; ?>/php/includes/career_progress_tracking/teaching/js/teaching.js"></script>
    <!-- Include Criterion A-specific JS -->
    <script src="<?php echo BASE_URL; ?>/php/includes/career_progress_tracking/teaching/js/criterion_a.js"></script>

</body>
</html>
