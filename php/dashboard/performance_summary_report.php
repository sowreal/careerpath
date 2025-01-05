<?php
include('../session.php');
include('../connection.php');
require_once '../config.php';

// Define variables for Page Titles and Sidebar Active effects
$pageTitle = 'Career Path | Performance Report';
$activePage = 'PSR';

// Authorization checks (omitted here for brevity)...
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once('../includes/header.php'); ?>
    <!-- <style>
        /* Optional: Some basic styling to resemble the spreadsheet layout */
        .kra-table th, .kra-table td {
            vertical-align: middle;
            text-align: center;
        }
        .kra-table td input[type="text"] {
            width: 80px;
            margin: 0 auto;
        }
    </style> -->
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
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
                        <h3 class="mb-0">Individual Summary Sheet</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Performance Summary</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                
                <!-- Basic Info -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">Faculty Information</h5>
                    </div>
                    <div class="card-body row">
                        <div class="col-sm-4 mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" placeholder="Last Name" readonly>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label class="form-label">First Name, Ext.</label>
                            <input type="text" class="form-control" placeholder="First Name" readonly>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label class="form-label">Middle Name</label>
                            <input type="text" class="form-control" placeholder="Middle Name" readonly>
                        </div>
                    </div>
                </div>

                <!-- KRA I -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">KRA I - Instruction (100 POINTS)</h5>
                    </div>
                    <div class="card-body p-2">
                        <table class="table table-bordered kra-table mb-0">
                            <thead class="table-secondary">
                            <tr>
                                <th>Criteria</th>
                                <th>Points</th>
                                <th>Faculty Score</th>
                                <th>Remarks</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Criterion A – Teaching Effectiveness</td>
                                <td>60</td>
                                <td><input type="text"></td>
                                <td><input type="text"></td>
                            </tr>
                            <tr>
                                <td>Criterion B – Curriculum / Instructional Materials Dev</td>
                                <td>30</td>
                                <td><input type="text"></td>
                                <td><input type="text"></td>
                            </tr>
                            <tr>
                                <td>Criterion C – Special Projects, Thesis, Dissertation &amp; Mentorship</td>
                                <td>10</td>
                                <td><input type="text"></td>
                                <td><input type="text"></td>
                            </tr>
                            <tr class="table-light">
                                <th colspan="3" class="text-end">TOTAL</th>
                                <th><input type="text" readonly></th>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- KRA II -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">KRA II – Research, Innovation and/or Creative Work (100 POINTS)</h5>
                    </div>
                    <div class="card-body p-2">
                        <table class="table table-bordered kra-table mb-0">
                            <thead class="table-secondary">
                            <tr>
                                <th>Criteria</th>
                                <th>Points</th>
                                <th>Faculty Score</th>
                                <th>Remarks</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Criterion A – Research Outputs Published</td>
                                <td>100</td>
                                <td><input type="text"></td>
                                <td><input type="text"></td>
                            </tr>
                            <tr>
                                <td>Criterion B – Inventions</td>
                                <td>100</td>
                                <td><input type="text"></td>
                                <td><input type="text"></td>
                            </tr>
                            <tr>
                                <td>Criterion C – Creative Works</td>
                                <td>100</td>
                                <td><input type="text"></td>
                                <td><input type="text"></td>
                            </tr>
                            <tr class="table-light">
                                <th colspan="3" class="text-end">TOTAL</th>
                                <th><input type="text" readonly></th>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- KRA III -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">KRA III – Extension Services (100 POINTS)</h5>
                    </div>
                    <div class="card-body p-2">
                        <table class="table table-bordered kra-table mb-0">
                            <thead class="table-secondary">
                            <tr>
                                <th>Criteria</th>
                                <th>Points</th>
                                <th>Faculty Score</th>
                                <th>Remarks</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Criterion A – Service to the Institution</td>
                                <td>30</td>
                                <td><input type="text"></td>
                                <td><input type="text"></td>
                            </tr>
                            <tr>
                                <td>Criterion B – Service to the Community</td>
                                <td>50</td>
                                <td><input type="text"></td>
                                <td><input type="text"></td>
                            </tr>
                            <tr>
                                <td>Criterion C – Quality of Extension Service</td>
                                <td>20</td>
                                <td><input type="text"></td>
                                <td><input type="text"></td>
                            </tr>
                            <tr>
                                <td>Criterion D – Bonus Criterion</td>
                                <td>20</td>
                                <td><input type="text"></td>
                                <td><input type="text"></td>
                            </tr>
                            <tr class="table-light">
                                <th colspan="3" class="text-end">TOTAL</th>
                                <th><input type="text" readonly></th>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- KRA IV -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">KRA IV – Professional Development (100 POINTS)</h5>
                    </div>
                    <div class="card-body p-2">
                        <table class="table table-bordered kra-table mb-0">
                            <thead class="table-secondary">
                            <tr>
                                <th>Criteria</th>
                                <th>Points</th>
                                <th>Faculty Score</th>
                                <th>Remarks</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Criterion A – Involvement in Professional Organization</td>
                                <td>20</td>
                                <td><input type="text"></td>
                                <td><input type="text"></td>
                            </tr>
                            <tr>
                                <td>Criterion B – Continuing Development</td>
                                <td>60</td>
                                <td><input type="text"></td>
                                <td><input type="text"></td>
                            </tr>
                            <tr>
                                <td>Criterion C – Awards and Recognition</td>
                                <td>20</td>
                                <td><input type="text"></td>
                                <td><input type="text"></td>
                            </tr>
                            <tr>
                                <td>Criterion D – Bonus Criterion</td>
                                <td>20</td>
                                <td><input type="text"></td>
                                <td><input type="text"></td>
                            </tr>
                            <tr class="table-light">
                                <th colspan="3" class="text-end">TOTAL</th>
                                <th><input type="text" readonly></th>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Consolidated Score & Rank -->
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="card-title mb-0">Consolidated Score and Faculty Rank</h5>
                    </div>
                    <div class="card-body p-2">
                        <table class="table table-bordered kra-table mb-4">
                            <thead class="table-secondary">
                            <tr>
                                <th>Faculty Rank</th>
                                <th>KRA 1</th>
                                <th>KRA 2</th>
                                <th>KRA 3</th>
                                <th>KRA 4</th>
                                <th>Total Points</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Instructor (I-III)</td>
                                <td>60%</td>
                                <td>0%</td>
                                <td>0%</td>
                                <td>10%</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>Asst. Professor (I-IV)</td>
                                <td>50%</td>
                                <td>20%</td>
                                <td>0%</td>
                                <td>10%</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>Assoc. Professor (I-V)</td>
                                <td>40%</td>
                                <td>30%</td>
                                <td>20%</td>
                                <td>10%</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>Professor (I-VI)</td>
                                <td>30%</td>
                                <td>40%</td>
                                <td>20%</td>
                                <td>10%</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>College/Univ Prof.</td>
                                <td>20%</td>
                                <td>50%</td>
                                <td>0%</td>
                                <td>0%</td>
                                <td>0</td>
                            </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered kra-table">
                            <thead class="table-secondary">
                            <tr>
                                <th>Score Bracket</th>
                                <th>No. of Sub-rank Increment</th>
                                <th>Current Faculty Rank</th>
                                <th>Base Rank</th>
                                <th>Final Recommended Faculty Rank</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>41-50</td>
                                <td>1 sub-rank</td>
                                <td>Associate Professor V</td>
                                <td>NO</td>
                                <td>
                                    <select class="form-select">
                                        <option>SELECT OPTION</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>51-60</td>
                                <td>2 sub-rank</td>
                                <td>Associate Professor V</td>
                                <td>0</td>
                                <td>
                                    <select class="form-select">
                                        <option>SELECT OPTION</option>
                                    </select>
                                </td>
                            </tr>
                            <!-- ...repeat rows as needed... -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Evaluation Signatures -->
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="card-title mb-0">Evaluation Signatures</h5>
                    </div>
                    <div class="card-body row">
                        <div class="col-sm-6">
                            <label>Name and Signature of IEC Member</label>
                            <input type="text" class="form-control mb-3" placeholder="IEC Member 1">
                            <input type="text" class="form-control mb-3" placeholder="IEC Member 2">
                            <input type="text" class="form-control mb-3" placeholder="IEC Member 3">
                            <input type="text" class="form-control mb-3" placeholder="IEC Chair">
                        </div>
                        <div class="col-sm-6">
                            <label>Name and Signature of Faculty</label>
                            <input type="text" class="form-control mb-3" placeholder="Faculty Signature">
                            <label>Acknowledgment</label>
                            <input type="text" class="form-control" placeholder="Acknowledged By">
                        </div>
                    </div>
                </div>

            </div> <!--end container-fluid-->
        </div> <!--end app-content-->
    </main>
    <!--end::App Main-->

    <!--begin::Footer-->   
    <?php require_once('../includes/footer.php');?>
    <!--end::Footer-->

</div>

<!-- Required scripts -->
<?php require_once('../includes/dashboard_default_scripts.php'); ?>

</body>
</html>
