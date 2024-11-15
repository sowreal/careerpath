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
            <div class="container-fluid">

                <!-- Standalone Header -->
                <div class="app-content-header">
                    <div class="container-fluid">
                        <div class="row align-items-top">
                            <div class="col-sm-6 mb-6">
                                <!-- Change Evaluation Number dynamically-->
                                <h3 class="mb-0">Teaching Performance (KRA I) - <span id="evaluation-number">Evaluation #: 2024-047</span></h3> 
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 pe-4 mt-4">
                        <div class="d-flex">
                            <!-- MODAL: Button Trigger -->
                            <button id="select-evaluation-btn" class="btn btn-success" data-toggle="modal" data-target="#evaluationModal">
                                Select Evaluation
                            </button>
                        </div>
                    </div>
                </div>

                <!-- KRA I Content -->
                <div class="card mt-4">
                    <div class="card-header d-flex bg-success justify-content-between align-items-center text-white">
                        <h5 class="mb-0">Summary of KRA I</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Summary Table for KRA I -->
                            <div class="col-md-6">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Criterion</th>
                                                <th>Average Score</th>
                                                <th>Total Points</th>
                                                <th>Overall Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody id="kra-summary-body">
                                            <!-- Dynamic Rows Will Be Injected Here -->
                                            <tr>
                                                <td>Teaching Effectiveness</td>
                                                <td>85%</td>
                                                <td>60 / 60</td>
                                                <td>Excellent performance in Teaching Effectiveness.</td>
                                            </tr>
                                            <tr>
                                                <td>Curriculum & Material Development</td>
                                                <td>70%</td>
                                                <td>21 / 30</td>
                                                <td>Good development and contribution to instructional materials.</td>
                                            </tr>
                                            <tr>
                                                <td>Thesis & Mentorship Services</td>
                                                <td>90%</td>
                                                <td>9 / 10</td>
                                                <td>Outstanding performance in mentorship and advisory roles.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Placeholder for Graphs -->
                            <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">
                                <!-- <h5 class="text-center mb-4">Performance Visualization</h5> -->
                                <div class="d-flex justify-content-center" style="width: 100%; max-width: 400px;">
                                    <!-- Doughnut Chart for Overall Performance -->
                                    <canvas id="kraDoughnutChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs for Criteria -->
                <div class="card mt-4">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="kra-tabs" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" id="tab-criterion-a" data-bs-toggle="tab" data-bs-target="#criterion-a" type="button" role="tab">
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
                    <div class="card-body">
                        <div class="tab-content" id="kra-tab-content">


                            <!-- Tab 1: Criterion A: Teaching Effectiveness -->
                            <div class="tab-pane fade show active" id="criterion-a" role="tabpanel" aria-labelledby="tab-criterion-a">
                                <h5>Teaching Effectiveness (Max = 60 Points)</h5>
                                <p>FACULTY PERFORMANCE. Enter average rating received by the faculty/semester.<br>  
                                    For newly appointed faculty from private HEI, LUCs, TESDA/DepEd schools 
                                    who still decided to proceed with the evaluation, put "0" in semesters with no student and supervisor's evaluation.</p>
                                <div class="row">
                                    <!-- Student Evaluation Section -->
                                    <div class="col-md-12 mt-4">
                                        <h5>1.1 Student Evaluation (60%)</h5>
                                        <div class="mb-3 d-flex align-items-center">
                                            <label for="student-divisor" class="form-label me-2 mb-0 align-self-center">Number of Semesters to Deduct from Divisor (if applicable):</label>
                                            <select class="form-select col-auto w-auto" id="student-divisor">
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 d-flex align-items-center">
                                            <label for="student-reason" class="form-label me-2 mb-0 align-self-center">Reason for Reducing the Divisor:</label>
                                            <select class="form-select col-auto w-auto" id="student-reason">
                                                <option value="">Select Option</option>
                                                <option value="not_applicable">Not Applicable</option>
                                                <option value="on_approved_study_leave">On Approved Study Leave</option>
                                                <option value="on_approved_sabbatical_leave">On Approved Sabbatical Leave</option>
                                                <option value="on_approved_maternity_leave">On Approved Maternity Leave</option>
                                            </select>
                                        </div>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Evaluation Period</th>
                                                    <th>1st Semester Rating</th>
                                                    <th>2nd Semester Rating</th>
                                                    <th>Link to Evidence</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>AY 2019-2020</td>
                                                    <td><input type="number" class="form-control" value="0.00"></td>
                                                    <td><input type="number" class="form-control" value="0.00"></td>
                                                    <td><a href="#" target="_blank">Link to Evidence</a></td>
                                                    <td>
                                                        <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#remarksModal" 
                                                                data-remarks1="Excellent performance in 1st semester of AY 2019-2020."
                                                                data-remarks2="Good progress in 2nd semester of AY 2019-2020.">
                                                            View Remarks
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>AY 2020-2021</td>
                                                    <td><input type="number" class="form-control" value="0.00"></td>
                                                    <td><input type="number" class="form-control" value="0.00"></td>
                                                    <td><a href="#" target="_blank">Link to Evidence</a></td>
                                                    <td>
                                                        <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#remarksModal" 
                                                                data-remarks1="Solid foundation in 1st semester of AY 2020-2021."
                                                                data-remarks2="Significant improvement in 2nd semester of AY 2020-2021.">
                                                            View Remarks
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>AY 2021-2022</td>
                                                    <td><input type="number" class="form-control" value="0.00"></td>
                                                    <td><input type="number" class="form-control" value="0.00"></td>
                                                    <td><a href="#" target="_blank">Link to Evidence</a></td>
                                                    <td>
                                                        <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#remarksModal" 
                                                                data-remarks1="Strong performance in 1st semester of AY 2021-2022."
                                                                data-remarks2="Exceptional progress in 2nd semester of AY 2021-2022.">
                                                            View Remarks
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>AY 2022-2023</td>
                                                    <td><input type="number" class="form-control" value="0.00"></td>
                                                    <td><input type="number" class="form-control" value="0.00"></td>
                                                    <td><a href="#" target="_blank">Link to Evidence</a></td>
                                                    <td>
                                                        <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#remarksModal" 
                                                                data-remarks1="Good start in 1st semester of AY 2022-2023."
                                                                data-remarks2="Continued success in 2nd semester of AY 2022-2023.">
                                                            View Remarks
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <!-- Modal for Viewing Remarks -->
                                        <div class="modal fade" id="remarksModal" tabindex="-1" aria-labelledby="remarksModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="remarksModalLabel">Semester Remarks</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h6>1st Semester Remarks:</h6>
                                                        <p id="remarks1Content"></p>
                                                        <hr>
                                                        <h6>2nd Semester Remarks:</h6>
                                                        <p id="remarks2Content"></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="container-fluid">
                                            <div class="d-flex flex-column align-items-end">
                                                <div class="mb-3 d-flex align-items-center">
                                                    <label for="student-overall-score" class="form-label me-2 mb-0 align-self-center">Overall Average Rating:</label>
                                                    <input type="number" class="form-control w-auto" id="student-overall-score" value="0.00">
                                                </div>
                                                <div class="mb-3 d-flex align-items-center">
                                                    <label for="faculty-overall-score" class="form-label me-2 mb-0 align-self-center">Faculty Score:</label>
                                                    <input type="number" class="form-control w-auto" id="faculty-overall-score" value="0.00">
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                    <!-- Supervisor's Evaluation Section -->
                                    <div class="col-md-12 mt-4">
                                        <h5>1.2 Supervisor's Evaluation (40%)</h5>
                                        <div class="mb-3 d-flex align-items-center">
                                            <label for="supervisor-divisor" class="form-label me-2 mb-0 align-self-center">Number of Semesters to Deduct from Divisor (if applicable):</label>
                                            <select class="form-select col-auto w-auto" id="supervisor-divisor">
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 d-flex align-items-center">
                                            <label for="supervisor-reason" class="form-label me-2 mb-0 align-self-center">Reason for Reducing the Divisor:</label>
                                            <select class="form-control col-auto w-auto" id="supervisor-reason">
                                                <option value="">Select Option</option>
                                                <option value="not_applicable">Not Applicable</option>
                                                <option value="on_approved_study_leave">On Approved Study Leave</option>
                                                <option value="on_approved_sabbatical_leave">On Approved Sabbatical Leave</option>
                                                <option value="on_approved_maternity_leave">On Approved Maternity Leave</option>
                                            </select>
                                        </div>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Evaluation Period</th>
                                                    <th>1st Semester Rating</th>
                                                    <th>2nd Semester Rating</th>
                                                    <th>Link to Evidence</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>AY 2019-2020</td>
                                                    <td><input type="number" class="form-control" value="0.00"></td>
                                                    <td><input type="number" class="form-control" value="0.00"></td>
                                                    <td><a href="#" target="_blank">Link to Evidence</a></td>
                                                </tr>
                                                <tr>
                                                    <td>AY 2020-2021</td>
                                                    <td><input type="number" class="form-control" value="0.00"></td>
                                                    <td><input type="number" class="form-control" value="0.00"></td>
                                                    <td><a href="#" target="_blank">Link to Evidence</a></td>
                                                </tr>
                                                <tr>
                                                    <td>AY 2021-2022</td>
                                                    <td><input type="number" class="form-control" value="0.00"></td>
                                                    <td><input type="number" class="form-control" value="0.00"></td>
                                                    <td><a href="#" target="_blank">Link to Evidence</a></td>
                                                </tr>
                                                <tr>
                                                    <td>AY 2022-2023</td>
                                                    <td><input type="number" class="form-control" value="0.00"></td>
                                                    <td><input type="number" class="form-control" value="0.00"></td>
                                                    <td><a href="#" target="_blank">Link to Evidence</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="container-fluid">
                                            <div class="d-flex flex-column align-items-end">
                                                <div class="mb-3 d-flex align-items-center">
                                                    <label for="supervisor-overall-score" class="form-label me-2 mb-0 align-self-center">Overall Average Rating:</label>
                                                    <input type="number" class="form-control w-auto" id="supervisor-overall-score" value="0.00">
                                                </div>
                                                <div class="mb-3 d-flex align-items-center">
                                                    <label for="faculty-overall-score" class="form-label me-2 mb-0 align-self-center">Faculty Score:</label>
                                                    <input type="number" class="form-control w-auto" id="supervisor-faculty-overall-score" value="0.00">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Save Button -->
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="button" class="btn btn-success" id="save-criterion-a">Save Criterion A</button>
                                </div>
                            </div>


                            <!-- Tab 2: Criterion B: Curriculum & Material Development -->
                            <div class="tab-pane fade" id="criterion-b" role="tabpanel" aria-labelledby="tab-criterion-b">
                                <p>Details related to Curriculum & Instructional Material Development will appear here, including metrics like instructional materials developed, co-authorship, and program implementation. This section should be view-only for faculty members, while HR can make edits.</p>
                            
                                <!-- Save Button for Tab 2 -->
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="button" class="btn btn-success" id="save-criterion-b">Save Criterion B</button>
                                </div>
                            </div>


                            <!-- Tab 3: Criterion C: Thesis & Mentorship Services -->
                            <div class="tab-pane fade" id="criterion-c" role="tabpanel" aria-labelledby="tab-criterion-c">
                                <p>Details related to Thesis, Dissertation, and Mentorship Services will appear here, including metrics for services rendered as adviser, panel member, and mentor. This section should be view-only for faculty members, while HR can make edits.</p>
                                
                                <!-- Save Button for Tab 3 -->
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="button" class="btn btn-success" id="save-criterion-c">Save Criterion C</button>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>





                <!-- MODAL SECTION -->

                <!-- Modal: Evaluation selection -->
                <div class="modal fade" id="evaluationModal" tabindex="-1" role="dialog" aria-labelledby="evaluationModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="evaluationModalLabel">Select Evaluation Cycle</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <ul id="evaluation-list" class="list-group">
                            <!-- Dynamically populated list of evaluations -->
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

    <!-- Script Links for Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <!-- For populating MODAL: Evaluation selection -->

    <!--  -->


    <!-- Enable/Disable KRA Sections Based on Selection -->
    <!-- Initially disable KRA sections until an evaluation is selected -->

    <!--  -->


    <!-- Visualization scripts -->
    <script>
        // Doughnut Chart for Overall Performance
        var ctxDoughnut = document.getElementById('kraDoughnutChart').getContext('2d');
        var kraDoughnutChart = new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: ['Teaching Effectiveness', 'Curriculum & Material Development', 'Thesis & Mentorship Services'],
                datasets: [{
                    label: 'Performance',
                    data: [85, 70, 90],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });
    </script>


    <!-- Event listener to load remarks into modal when triggered -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const remarksModal = document.getElementById('remarksModal');
            const remarks1Content = document.getElementById('remarks1Content');
            const remarks2Content = document.getElementById('remarks2Content');

            remarksModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // Button that triggered the modal
                const remarks1 = button.getAttribute('data-remarks1'); // 1st semester remarks
                const remarks2 = button.getAttribute('data-remarks2'); // 2nd semester remarks
                remarks1Content.textContent = remarks1; // Set 1st semester content
                remarks2Content.textContent = remarks2; // Set 2nd semester content
            });
        });
    </script>

    <!-- Save Button Functionality for each Criterion -->
    <script>
    document.getElementById('save-criterion-a').addEventListener('click', function() {
        // Save logic for Criterion A
        alert('Criterion A saved!');
    });

    document.getElementById('save-criterion-b').addEventListener('click', function() {
        // Save logic for Criterion B
        alert('Criterion B saved!');
    });

    document.getElementById('save-criterion-c').addEventListener('click', function() {
        // Save logic for Criterion C
        alert('Criterion C saved!');
    });
    </script>


</body>
</html>


