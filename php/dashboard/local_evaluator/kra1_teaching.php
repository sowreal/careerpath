<?php
include '../../session.php';
include '../../connection.php';
require_once '../../config.php';

// Define variables for Page Titles and Sidebar Active effects
$pageTitle = 'Career Path | KRA1: Teaching';
$activePage = 'LocalEvaluatorTools'; // To highlight in the sidebar

// **Removed Local Evaluator Role Check**

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once '../../includes/header.php'; ?>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="../../AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <!-- Header -->
        <?php require_once '../../includes/navbar.php'; ?>

        <!-- Sidebar -->
        <?php require_once '../../includes/sidebar_faculty.php'; ?>

        <!-- Main Content -->
        <main class="app-main">
            <div class="container-fluid">
                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center my-4">
                    <h1 class="h3 mb-0 text-gray-800">KRA1: Teaching</h1>
                </div>

                <!-- Search and Filter Section -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="searchInput" placeholder="Search by name or email">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="departmentFilter">
                                    <option value="">All Departments</option>
                                    <option value="College of Agriculture">College of Agriculture</option>
                                    <option value="College of Allied Medicine">College of Allied Medicine</option>
                                    <option value="College of Arts and Sciences">College of Arts and Sciences</option>
                                    <option value="College of Engineering">College of Engineering</option>
                                    <option value="College of Industrial Technology">College of Industrial Technology</option>
                                    <option value="College of Teacher Education">College of Teacher Education</option>
                                    <option value="College of Administration, Business, Hospitality, and Accountancy">College of Administration, Business, Hospitality, and Accountancy</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="facultyRankFilter">
                                    <option value="">All Ranks</option>
                                    <option value="Instructor I">Instructor I</option>
                                    <option value="Instructor II">Instructor II</option>
                                    <option value="Instructor III">Instructor III</option>
                                    <option value="Assistant Professor I">Assistant Professor I</option>
                                    <option value="Assistant Professor II">Assistant Professor II</option>
                                    <option value="Assistant Professor III">Assistant Professor III</option>
                                    <option value="Assistant Professor IV">Assistant Professor IV</option>
                                    <option value="Associate Professor I">Associate Professor I</option>
                                    <option value="Associate Professor II">Associate Professor II</option>
                                    <option value="Associate Professor III">Associate Professor III</option>
                                    <option value="Associate Professor IV">Associate Professor IV</option>
                                    <option value="Associate Professor V">Associate Professor V</option>
                                    <option value="Professor I">Professor I</option>
                                    <option value="Professor II">Professor II</option>
                                    <option value="Professor III">Professor III</option>
                                    <option value="Professor IV">Professor IV</option>
                                    <option value="Professor V">Professor V</option>
                                    <option value="Professor VI">Professor VI</option>
                                    <option value="College Professor">College Professor</option>
                                    <option value="University Professor">University Professor</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KRA1 Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="kra1EvaluationsTable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Rank</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be inserted here by AJAX -->
                                </tbody>
                            </table>
                        </div>
                        <nav aria-label="Page navigation" class="kra1-pagination-container">
                            <ul class="pagination kra1-pagination" id="kra1Pagination">
                                <!-- Pagination will be inserted here by AJAX -->
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- KRA1 Details Modal -->
            <div class="modal fade" id="kra1DetailsModal" tabindex="-1" aria-labelledby="kra1DetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="kra1DetailsModalLabel">KRA1: Teaching Details</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="kra1DetailsContent">
                                <!-- KRA1 details will be loaded here -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <?php require_once '../../includes/footer.php'; ?>
    </div>

    <!-- Scripts -->
    <?php require_once '../../includes/dashboard_default_scripts.php'; ?>
    <script src="<?php echo BASE_URL; ?>/php/dashboard/local_evaluator/js/kra1_teaching.js"></script>
    <!-- DataTables JS -->
    <script src="../../AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
</body>

</html>