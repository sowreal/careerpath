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
    exit();
}

// Fetch faculty information
try {
    $stmt = $conn->prepare("SELECT first_name, middle_name, last_name, department, faculty_rank FROM users WHERE id = :id AND role IN ('Regular Instructor', 'Contract of Service Instructor')");
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

// Fetch KRA summaries
$kra_summaries = [];

try {
    // Fetch metadata first to get divisor and reason values
    $stmt = $conn->prepare("
        SELECT m.student_divisor, m.student_reason, m.supervisor_divisor, m.supervisor_reason
        FROM kra1_a_metadata m
        WHERE m.request_id IN (SELECT request_id FROM request_form WHERE user_id = :faculty_id)
    ");
    $stmt->bindParam(':faculty_id', $faculty_id, PDO::PARAM_INT);
    $stmt->execute();
    $metadata = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Store metadata in $kra_summaries
    $kra_summaries['metadata'] = $metadata;

    // Fetch distinct evaluation periods from the student evaluation table
    $stmt = $conn->prepare("
        SELECT DISTINCT se.evaluation_period
        FROM kra1_a_student_evaluation se
        WHERE se.request_id IN (SELECT request_id FROM request_form WHERE user_id = :faculty_id)
        ORDER BY se.evaluation_period
    ");
    $stmt->bindParam(':faculty_id', $faculty_id, PDO::PARAM_INT);
    $stmt->execute();
    $evaluationPeriods = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // If no evaluation periods are found in the student table, try the supervisor table
    if (empty($evaluationPeriods)) {
        $stmt = $conn->prepare("
            SELECT DISTINCT se.evaluation_period
            FROM kra1_a_supervisor_evaluation se
            WHERE se.request_id IN (SELECT request_id FROM request_form WHERE user_id = :faculty_id)
            ORDER BY se.evaluation_period
        ");
        $stmt->bindParam(':faculty_id', $faculty_id, PDO::PARAM_INT);
        $stmt->execute();
        $evaluationPeriods = $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // Fetch data for Criterion A (Student Evaluation)
    $stmt = $conn->prepare("
        SELECT se.*, m.student_overall_rating, m.student_faculty_rating 
        FROM kra1_a_student_evaluation se
        JOIN kra1_a_metadata m ON se.request_id = m.request_id
        WHERE se.request_id IN (SELECT request_id FROM request_form WHERE user_id = :faculty_id)
    ");
    $stmt->bindParam(':faculty_id', $faculty_id, PDO::PARAM_INT);
    $stmt->execute();
    $kra_summaries['criterion_a']['student_evaluations'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch data for Criterion A (Supervisor Evaluation)
    $stmt = $conn->prepare("
        SELECT se.*, m.supervisor_overall_rating, m.supervisor_faculty_rating
        FROM kra1_a_supervisor_evaluation se
        JOIN kra1_a_metadata m ON se.request_id = m.request_id
        WHERE se.request_id IN (SELECT request_id FROM request_form WHERE user_id = :faculty_id)
    ");
    $stmt->bindParam(':faculty_id', $faculty_id, PDO::PARAM_INT);
    $stmt->execute();
    $kra_summaries['criterion_a']['supervisor_evaluations'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error fetching KRA summary data: " . $e->getMessage();
    exit;
}
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
                            <!-- careerpath/php/includes/career_progress_tracking/teaching/criterion_a.php -->
                            <div class="tab-pane fade show active criterion-tab" id="criterion-a" role="tabpanel" aria-labelledby="tab-kra1-criterion-a">
                                <h4 class="mb-4 pb-2 border-bottom border-3 border-success">
                                    <strong>CRITERION A: Teaching Effectiveness (Max = 60 Points)</strong>
                                </h4>

                                <h5>
                                    <strong>1. FACULTY PERFORMANCE:</strong> Enter the average rating received by the faculty per semester.<br>
                                    For newly appointed faculty from private HEI, LUCs, TESDA/DepEd schools who decide to proceed with the evaluation,
                                    enter "0" for semesters without student and supervisor evaluations.
                                </h5>

                                <form id="criterion-a-form" enctype="multipart/form-data" method="POST">
                                    <div class="row">
                                        <!-- Hidden Input for request_id -->
                                        <input type="hidden" id="request_id" name="request_id" value="<?php echo isset($_GET['request_id']) ? htmlspecialchars($_GET['request_id']) : ''; ?>" readonly>

                                        <!-- Student Evaluation Section -->
                                        <div class="col-12 mt-5">
                                            <h5 class="mb-4 pb-2 border-bottom border-2 border-success">1.1 Student Evaluation (60%)</h5>

                                            <!-- Divisor Selection -->
                                            <div class="row g-4 align-items-center mb-4">
                                                <div class="col-md-4">
                                                    <label for="student-divisor" class="form-label">Number of Semesters to Deduct from Divisor (if applicable):</label>
                                                    <select class="form-select" id="student-divisor" name="student-divisor">
                                                        <?php
                                                        $selectedDivisor = $kra_summaries['metadata'][0]['student_divisor'] ?? 0;
                                                        for ($i = 0; $i <= 7; $i++) :
                                                            $selected = ($selectedDivisor == $i) ? 'selected' : '';
                                                            echo "<option value=\"$i\" $selected>$i</option>";
                                                        endfor;
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="student-reason" class="form-label">Reason for Reducing the Divisor:</label>
                                                    <select class="form-select" id="student-reason" name="student-reason" required>
                                                        <?php
                                                        $selectedReason = $kra_summaries['metadata'][0]['student_reason'] ?? '';
                                                        $reasons = [
                                                            '' => 'Select Option',
                                                            'not_applicable' => 'Not Applicable',
                                                            'study_leave' => 'On Approved Study Leave',
                                                            'sabbatical_leave' => 'On Approved Sabbatical Leave',
                                                            'maternity_leave' => 'On Approved Maternity Leave'
                                                        ];
                                                        foreach ($reasons as $value => $label) :
                                                            $selected = ($selectedReason === $value) ? 'selected' : '';
                                                            echo "<option value=\"$value\" $selected>$label</option>";
                                                        endforeach;
                                                        ?>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please select a valid option.
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Responsive Table -->
                                            <div class="table-responsive mt-3">
                                                <!-- Student Evaluation Table -->
                                                <table class="table table-striped table-sm align-middle" id="student-evaluation-table">
                                                    <thead class="table-light text-center">
                                                        <tr>
                                                            <th scope="col">Evaluation Period</th>
                                                            <th scope="col">1st Semester Rating</th>
                                                            <th scope="col">2nd Semester Rating</th>
                                                            <th scope="col">Evidence</th>
                                                            <th scope="col">Remarks</th>
                                                            <th scope="col">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $student_evaluations = $kra_summaries['criterion_a']['student_evaluations'] ?? [];

                                                        // Use the dynamically fetched evaluation periods
                                                        foreach ($evaluationPeriods as $period) :
                                                            $student_evaluation_data = null; // Use a different variable name here
                                                            foreach ($student_evaluations as $eval) {
                                                                if ($eval['evaluation_period'] === $period) {
                                                                    $student_evaluation_data = $eval; // Assign to the new variable
                                                                    break;
                                                                }
                                                            }

                                                            // Use different variable names for student evaluations
                                                            $student_evaluation_id = $student_evaluation_data ? $student_evaluation_data['evaluation_id'] : '0';
                                                            $student_rating_1 = $student_evaluation_data ? $student_evaluation_data['first_semester_rating'] : '';
                                                            $student_rating_2 = $student_evaluation_data ? $student_evaluation_data['second_semester_rating'] : '';
                                                            $student_evidence_file_1 = $student_evaluation_data ? $student_evaluation_data['evidence_file_1'] : '';
                                                            $student_evidence_file_2 = $student_evaluation_data ? $student_evaluation_data['evidence_file_2'] : '';
                                                            $student_remarks_first = $student_evaluation_data ? $student_evaluation_data['remarks_first'] : '';
                                                            $student_remarks_second = $student_evaluation_data ? $student_evaluation_data['remarks_second'] : '';
                                                            ?>
                                                            <tr data-evaluation-id="<?php echo htmlspecialchars($student_evaluation_id); ?>">
                                                                <td>
                                                                    <input type="text" class="form-control" name="student_evaluation_period[]" value="<?php echo htmlspecialchars($period); ?>" readonly>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control rating-input" name="student_rating_1[]" placeholder="0.00" required value="<?php echo htmlspecialchars($student_rating_1); ?>">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control rating-input" name="student_rating_2[]" placeholder="0.00" required value="<?php echo htmlspecialchars($student_rating_2); ?>">
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-request-id="<?php echo $request_id; ?>" data-evaluation-id="<?php echo htmlspecialchars($student_evaluation_id); ?>" data-table-type="student" data-file-path-1="<?php echo htmlspecialchars($student_evidence_file_1); ?>" data-file-path-2="<?php echo htmlspecialchars($student_evidence_file_2); ?>">
                                                                        Upload Evidence
                                                                    </button>
                                                                    <input type="hidden" name="evaluation_id[]" value="<?php echo htmlspecialchars($student_evaluation_id); ?>">
                                                                    <input type="hidden" name="evidence_file_1[]" value="<?php echo htmlspecialchars($student_evidence_file_1); ?>">
                                                                    <input type="hidden" name="evidence_file_2[]" value="<?php echo htmlspecialchars($student_evidence_file_2); ?>">
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="btn btn-success btn-sm add-remarks" data-bs-toggle="modal" data-bs-target="#remarksModal" data-evaluation-id="<?php echo htmlspecialchars($student_evaluation_id); ?>" data-table-type="student" data-mode="add">
                                                                        Add Remarks
                                                                    </button>
                                                                    <button type="button" class="btn btn-secondary btn-sm view-remarks" data-bs-toggle="modal" data-bs-target="#remarksModal" data-first-remark="<?php echo htmlspecialchars($student_remarks_first); ?>" data-second-remark="<?php echo htmlspecialchars($student_remarks_second); ?>" data-evaluation-id="<?php echo htmlspecialchars($student_evaluation_id); ?>" data-table-type="student" data-mode="view" style="display: none;">
                                                                        View Remarks
                                                                    </button>
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!-- Add Row Button -->
                                            <button type="button" class="btn btn-success mt-3 add-row" data-table-id="student-evaluation-table">Add Row</button>

                                            <!-- Overall Scores -->
                                            <div class="mt-5">
                                                <div class="row g-3 justify-content-end">
                                                    <div class="col-md-4">
                                                        <label for="student_overall_score" class="form-label"><strong>Overall Average Rating:</strong></label>
                                                        <input type="text" class="form-control" id="student_overall_score" name="student_overall_score" value="<?php echo htmlspecialchars($kra_summaries['criterion_a']['student_overall_rating'] ?? ''); ?>" readonly>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="student_faculty_overall_score" class="form-label"><strong>Faculty Score:</strong></label>
                                                        <input type="text" class="form-control" id="student_faculty_overall_score" name="student_faculty_overall_score" value="<?php echo htmlspecialchars($kra_summaries['criterion_a']['student_faculty_rating'] ?? ''); ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Supervisor's Evaluation Section -->
                                        <div class="col-12 mt-5">
                                            <h5 class="mb-4 pb-2 border-bottom border-2 border-success">1.2 Supervisor's Evaluation (40%)</h5>

                                            <!-- Divisor Selection -->
                                            <div class="row g-4 align-items-center mb-4">
                                                <div class="col-md-4">
                                                    <label for="supervisor-divisor" class="form-label">Number of Semesters to Deduct from Divisor (if applicable):</label>
                                                    <select class="form-select" id="supervisor-divisor" name="supervisor-divisor">
                                                        <?php
                                                        $selectedDivisor = $kra_summaries['metadata'][0]['supervisor_divisor'] ?? 0;
                                                        for ($i = 0; $i <= 7; $i++) : ?>
                                                            <option value="<?php echo $i; ?>" <?php echo ($selectedDivisor == $i) ? 'selected' : ''; ?>>
                                                                <?php echo $i; ?>
                                                            </option>
                                                        <?php endfor; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="supervisor-reason" class="form-label">Reason for Reducing the Divisor:</label>
                                                    <select class="form-select" id="supervisor-reason" name="supervisor-reason" required>
                                                        <?php
                                                        $selectedReason = $kra_summaries['metadata'][0]['supervisor_reason'] ?? '';
                                                        $reasons = [
                                                            '' => 'Select Option',
                                                            'not_applicable' => 'Not Applicable',
                                                            'study_leave' => 'On Approved Study Leave',
                                                            'sabbatical_leave' => 'On Approved Sabbatical Leave',
                                                            'maternity_leave' => 'On Approved Maternity Leave'
                                                        ];
                                                        foreach ($reasons as $value => $label) :
                                                            $selected = ($selectedReason === $value) ? 'selected' : '';
                                                            echo "<option value=\"$value\" $selected>$label</option>";
                                                        endforeach;
                                                        ?>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please select a valid option.
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Responsive Table -->
                                            <div class="table-responsive">
                                                <!-- Supervisor Evaluation Table -->
                                                <table class="table table-bordered align-middle" id="supervisor-evaluation-table">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th scope="col">Evaluation Period</th>
                                                            <th scope="col">1st Semester Rating</th>
                                                            <th scope="col">2nd Semester Rating</th>
                                                            <th scope="col">Evidence</th>
                                                            <th scope="col">Remarks</th>
                                                            <th scope="col">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $supervisor_evaluations = $kra_summaries['criterion_a']['supervisor_evaluations'] ?? [];

                                                        // Use the dynamically fetched evaluation periods
                                                        foreach ($evaluationPeriods as $period) :
                                                            $supervisor_evaluation_data = null; // Use a different variable name here
                                                            foreach ($supervisor_evaluations as $eval) {
                                                                if ($eval['evaluation_period'] === $period) {
                                                                    $supervisor_evaluation_data = $eval; // Assign to the new variable
                                                                    break;
                                                                }
                                                            }

                                                            // Use different variable names for supervisor evaluations
                                                            $supervisor_evaluation_id = $supervisor_evaluation_data ? $supervisor_evaluation_data['evaluation_id'] : '0';
                                                            $supervisor_rating_1 = $supervisor_evaluation_data ? $supervisor_evaluation_data['first_semester_rating'] : '';
                                                            $supervisor_rating_2 = $supervisor_evaluation_data ? $supervisor_evaluation_data['second_semester_rating'] : '';
                                                            $supervisor_evidence_file_1 = $supervisor_evaluation_data ? $supervisor_evaluation_data['evidence_file_1'] : '';
                                                            $supervisor_evidence_file_2 = $supervisor_evaluation_data ? $supervisor_evaluation_data['evidence_file_2'] : '';
                                                            $supervisor_remarks_first = $supervisor_evaluation_data ? $supervisor_evaluation_data['remarks_first'] : '';
                                                            $supervisor_remarks_second = $supervisor_evaluation_data ? $supervisor_evaluation_data['remarks_second'] : '';
                                                            ?>
                                                            <tr data-evaluation-id="<?php echo htmlspecialchars($supervisor_evaluation_id); ?>">
                                                                <td>
                                                                    <input type="text" class="form-control" name="supervisor_evaluation_period[]" value="<?php echo htmlspecialchars($period); ?>" readonly>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control rating-input" name="supervisor_rating_1[]" placeholder="0.00" required value="<?php echo htmlspecialchars($supervisor_rating_1); ?>">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control rating-input" name="supervisor_rating_2[]" placeholder="0.00" required value="<?php echo htmlspecialchars($supervisor_rating_2); ?>">
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-request-id="<?php echo $request_id; ?>" data-evaluation-id="<?php echo htmlspecialchars($supervisor_evaluation_id); ?>" data-table-type="supervisor" data-file-path-1="<?php echo htmlspecialchars($supervisor_evidence_file_1); ?>" data-file-path-2="<?php echo htmlspecialchars($supervisor_evidence_file_2); ?>">
                                                                        Upload Evidence
                                                                    </button>
                                                                    <input type="hidden" name="evaluation_id[]" value="<?php echo htmlspecialchars($supervisor_evaluation_id); ?>">
                                                                    <input type="hidden" name="evidence_file_1[]" value="<?php echo htmlspecialchars($supervisor_evidence_file_1); ?>">
                                                                    <input type="hidden" name="evidence_file_2[]" value="<?php echo htmlspecialchars($supervisor_evidence_file_2); ?>">
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="btn btn-success btn-sm add-remarks" data-bs-toggle="modal" data-bs-target="#remarksModal" data-evaluation-id="<?php echo htmlspecialchars($supervisor_evaluation_id); ?>" data-table-type="supervisor" data-mode="add">
                                                                        Add Remarks
                                                                    </button>
                                                                    <button type="button" class="btn btn-secondary btn-sm view-remarks" data-bs-toggle="modal" data-bs-target="#remarksModal" data-first-remark="<?php echo htmlspecialchars($supervisor_remarks_first); ?>" data-second-remark="<?php echo htmlspecialchars($supervisor_remarks_second); ?>" data-evaluation-id="<?php echo htmlspecialchars($supervisor_evaluation_id); ?>" data-table-type="supervisor" data-mode="view" style="display: none;">
                                                                        View Remarks
                                                                    </button>
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!-- Add Row Button -->
                                            <button type="button" class="btn btn-success mt-3 add-row" data-table-id="supervisor-evaluation-table">Add Row</button>

                                            <!-- Overall Scores -->
                                            <div class="mt-5">
                                                <div class="row g-3 justify-content-end">
                                                    <div class="col-md-4">
                                                        <label for="supervisor-overall-score" class="form-label"><strong>Overall Average Rating:</strong></label>
                                                        <input type="text" class="form-control" id="supervisor-overall-score" name="supervisor-overall-score" value="<?php echo htmlspecialchars($kra_summaries['criterion_a']['supervisor_overall_rating'] ?? ''); ?>" readonly>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="supervisor-faculty-overall-score" class="form-label"><strong>Faculty Score:</strong></label>
                                                        <input type="text" class="form-control" id="supervisor-faculty-overall-score" name="supervisor-faculty-overall-score" value="<?php echo htmlspecialchars($kra_summaries['criterion_a']['supervisor_faculty_rating'] ?? ''); ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Save Button -->
                                    <div class="d-flex justify-content-end mt-3">
                                        <button type="button" class="btn btn-success" id="save-kra3-criterion-a">Save Criterion A</button>
                                    </div>
                                </form>

                                <!-- MODALS -->
                                <!-- Remarks Modal -->
                                <div class="modal fade" id="remarksModal" tabindex="-1" aria-labelledby="remarksModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="remarksModalLabel">Add Remarks</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="remarksForm">
                                                    <input type="hidden" id="evaluationId" name="evaluationId">
                                                    <input type="hidden" id="tableType" name="tableType">
                                                    <div class="mb-3">
                                                        <label for="remarksFirst" class="form-label">Remarks First</label>
                                                        <textarea class="form-control" id="remarksFirst" name="remarksFirst" rows="3"></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="remarksSecond" class="form-label">Remarks Second</label>
                                                        <textarea class="form-control" id="remarksSecond" name="remarksSecond" rows="3"></textarea>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary" id="saveRemarks">Save Remarks</button>
                                                <button type="button" class="btn btn-danger" id="deleteRemarks">Delete Remarks</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade" id="deleteRowModal" tabindex="-1" aria-labelledby="deleteRowModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-danger" id="deleteRowModalLabel">Confirm Deletion</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this row? This action cannot be undone.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-danger" id="confirm-delete-row">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Success Modal -->
                                <div class="modal fade" id="deleteSuccessModal" tabindex="-1" aria-labelledby="deleteSuccessModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-success text-white">
                                                <h5 class="modal-title" id="deleteSuccessModalLabel">Deletion Successful</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                The row has been successfully deleted.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Error Modal -->
                                <div class="modal fade" id="deleteErrorModal" tabindex="-1" aria-labelledby="deleteErrorModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-danger" id="deleteErrorModalLabel">Deletion Failed</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Error message will be injected here -->
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Save Confirmation Modal -->
                                <div class="modal fade" id="saveConfirmationModal" tabindex="-1" aria-labelledby="saveConfirmationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-success text-white">
                                                <h5 class="modal-title" id="saveConfirmationModalLabel">Save Successful</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                KRA3 Criterion A has been saved successfully!
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Save Error Modal -->
                                <div class="modal fade" id="saveErrorModal" tabindex="-1" aria-labelledby="saveErrorModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-danger" id="saveErrorModalLabel">Save Failed</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Dynamic error message will be inserted here -->
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
    <script>
        $(document).ready(function() {
            // Updated JavaScript for Add/View Remarks
            // Show "Add Remarks" and hide "View Remarks" initially if no remarks exist
            $('tr[data-evaluation-id]').each(function() {
                var firstRemark = $(this).find('.view-remarks').data('first-remark');
                var secondRemark = $(this).find('.view-remarks').data('second-remark');

                if (!firstRemark && !secondRemark) {
                    $(this).find('.add-remarks').show();
                    $(this).find('.view-remarks').hide();
                } else {
                    $(this).find('.add-remarks').hide();
                    $(this).find('.view-remarks').show();
                }
            });

            // When the "Add Remarks" button is clicked
            $(document).on('click', '.add-remarks', function() {
                var evaluationId = $(this).data('evaluation-id');
                var tableType = $(this).data('table-type');

                // Clear the remarks fields
                $('#remarksFirst').val('');
                $('#remarksSecond').val('');
                $('#evaluationId').val(evaluationId);
                $('#tableType').val(tableType);
                $('#remarksModalLabel').text('Add Remarks'); // Set modal title for adding
                $('#saveRemarks').show(); // Ensure save button is visible
            });

            // When the "View Remarks" button is clicked
            $(document).on('click', '.view-remarks', function() {
                var firstRemark = $(this).data('first-remark');
                var secondRemark = $(this).data('second-remark');
                var evaluationId = $(this).data('evaluation-id');
                var tableType = $(this).data('table-type');

                $('#remarksFirst').val(firstRemark);
                $('#remarksSecond').val(secondRemark);
                $('#evaluationId').val(evaluationId);
                $('#tableType').val(tableType);
                $('#remarksModalLabel').text('View Remarks'); // Set modal title for viewing
                $('#saveRemarks').hide(); // Hide save button in view mode

                // Disable input fields for viewing only
                $('#remarksFirst').prop('disabled', true);
                $('#remarksSecond').prop('disabled', true);
            });

            // When the modal is hidden, re-enable the textareas
            $('#remarksModal').on('hidden.bs.modal', function () {
                $('#remarksFirst').prop('disabled', false);
                $('#remarksSecond').prop('disabled', false);
            });


            // When the "Save Remarks" button in the modal is clicked
            $('#saveRemarks').click(function() {
                var evaluationId = $('#evaluationId').val();
                var tableType = $('#tableType').val();
                var remarksFirst = $('#remarksFirst').val();
                var remarksSecond = $('#remarksSecond').val();
                var request_id = $('#request_id').val(); // Get request_id

                // Log values to console for debugging
                console.log("evaluationId:", evaluationId);
                console.log("tableType:", tableType);
                console.log("remarksFirst:", remarksFirst);
                console.log("remarksSecond:", remarksSecond);
                console.log("request_id:", request_id);

                $.ajax({
                    url: 'save_remarks.php', 
                    type: 'POST',
                    dataType: 'json', // Expect a JSON response (This was missing before)
                    data: {
                        evaluationId: evaluationId,
                        tableType: tableType,
                        remarksFirst: remarksFirst,
                        remarksSecond: remarksSecond,
                        request_id: request_id
                    },
                    success: function(response) {
                        // Handle the response
                        if (response.status === 'success') {
                            // Update the button's data attributes (Corrected)
                            var addButton = $(`button.add-remarks[data-evaluation-id='${evaluationId}'][data-table-type='${tableType}']`);
                            var viewButton = addButton.closest('td').find('.view-remarks');

                            // Set the data attributes for the view button
                            viewButton.data('first-remark', remarksFirst);
                            viewButton.data('second-remark', remarksSecond);

                            // Show "View Remarks" and hide "Add Remarks"
                            addButton.hide();
                            viewButton.show();

                            // Show success message or update the UI as needed
                            alert('Remarks saved successfully!');
                            $('#remarksModal').modal('hide');
                        } else {
                            alert('Failed to save remarks: ' + response.message); // Display error message from server
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error); // Log the error to the console
                        alert('An error occurred while saving remarks.');
                    }
                });
            });

            
            // When the "Delete Remarks" button in the modal is clicked
$(document).on('click', '#deleteRemarks', function() {
    var evaluationId = $('#evaluationId').val();
    var tableType = $('#tableType').val();

    if (confirm("Are you sure you want to delete the remarks for this evaluation?")) {
        $.ajax({
            url: 'delete_remarks.php',
            type: 'POST',
            dataType: 'json',
            data: {
                evaluationId: evaluationId,
                tableType: tableType
            },
            success: function(response) {
                if (response.status === 'success') {
                    // Update UI: Hide "View Remarks", show "Add Remarks"
                    var addButton = $(`button.add-remarks[data-evaluation-id='${evaluationId}'][data-table-type='${tableType}']`);
                    var viewButton = addButton.closest('td').find('.view-remarks');
                    addButton.show();
                    viewButton.hide();

                    // Clear the data attributes
                    viewButton.data('first-remark', '');
                    viewButton.data('second-remark', '');

                    alert('Remarks deleted successfully!');
                    $('#remarksModal').modal('hide');
                } else {
                    alert('Failed to delete remarks: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                alert('An error occurred while deleting remarks.');
            }
        });
    }
});

        });
    </script>
</body>
</html>