<?php
// get_kra1_details.php

header('Content-Type: application/json');

require_once '../../session.php';
require_once '../../connection.php';
require_once '../../config.php';

// **Removed Local Evaluator Role Check**

$facultyId = isset($_GET['faculty_id']) ? (int)$_GET['faculty_id'] : 0;

if ($facultyId <= 0) {
    echo json_encode(['error' => 'Invalid faculty ID.']);
    exit();
}

try {
    // Fetch KRA1 details based on faculty ID
    $stmt = $conn->prepare("
    SELECT
        u.first_name, u.middle_name, u.last_name, u.department, u.faculty_rank,
        rf.evaluation_period,
        kam.student_divisor, kam.student_reason, kam.supervisor_divisor, kam.supervisor_reason,
        kam.student_overall_rating, kam.student_faculty_rating, kam.supervisor_overall_rating, kam.supervisor_faculty_rating,
        kase.first_semester_rating AS student_first_sem, kase.second_semester_rating AS student_second_sem,
        kase.remarks_first AS student_remarks_first, kase.remarks_second AS student_remarks_second,
        kase.evidence_file_1 AS student_evidence_1, kase.evidence_file_2 AS student_evidence_2,
        kasue.first_semester_rating AS supervisor_first_sem, kasue.second_semester_rating AS supervisor_second_sem,
        kasue.remarks_first AS supervisor_remarks_first, kasue.remarks_second AS supervisor_remarks_second,
        kasue.evidence_file_1 AS supervisor_evidence_1, kasue.evidence_file_2 AS supervisor_evidence_2
    FROM users u
    INNER JOIN request_form rf ON u.id = rf.faculty_id
    INNER JOIN kra1_a_metadata kam ON rf.request_id = kam.request_id
    LEFT JOIN kra1_a_student_evaluation kase ON rf.request_id = kase.request_id
    LEFT JOIN kra1_a_supervisor_evaluation kasue ON rf.request_id = kasue.request_id
    WHERE u.id = :facultyId
    ORDER BY rf.request_id DESC
    LIMIT 1
    ");
    $stmt->bindParam(':facultyId', $facultyId, PDO::PARAM_INT);
    $stmt->execute();
    $kra1Details = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$kra1Details) {
        echo json_encode(['error' => 'KRA1 details not found.']);
        exit();
    }

    // Build HTML for displaying KRA1 details
    $html = '<div class="container">';
    $html .= '<h4 class="mb-3">Faculty: ' . htmlspecialchars($kra1Details['first_name'] . ' ' . $kra1Details['last_name']) . '</h4>';
    $html .= '<p><strong>Department:</strong> ' . htmlspecialchars($kra1Details['department']) . '</p>';
    $html .= '<p><strong>Faculty Rank:</strong> ' . htmlspecialchars($kra1Details['faculty_rank']) . '</p>';
    $html .= '<p><strong>Evaluation Period:</strong> ' . htmlspecialchars($kra1Details['evaluation_period']) . '</p>';
    $html .= '<div class="row mt-4">';
    $html .= '<div class="col-md-6">';
    $html .= '<h5>Student Evaluation</h5>';
    $html .= '<p><strong>Divisor:</strong> ' . htmlspecialchars($kra1Details['student_divisor']) . '</p>';
    $html .= '<p><strong>Reason:</strong> ' . htmlspecialchars($kra1Details['student_reason']) . '</p>';
    $html .= '<p><strong>Overall Rating:</strong> ' . htmlspecialchars($kra1Details['student_overall_rating']) . '</p>';
    $html .= '<p><strong>Faculty Rating:</strong> ' . htmlspecialchars($kra1Details['student_faculty_rating']) . '</p>';
    $html .= '<p><strong>First Semester Rating:</strong> ' . htmlspecialchars($kra1Details['student_first_sem']) . '</p>';
    $html .= '<p><strong>Second Semester Rating:</strong> ' . htmlspecialchars($kra1Details['student_second_sem']) . '</p>';
    $html .= '<p><strong>Remarks (First Semester):</strong> ' . htmlspecialchars($kra1Details['student_remarks_first']) . '</p>';
    $html .= '<p><strong>Remarks (Second Semester):</strong> ' . htmlspecialchars($kra1Details['student_remarks_second']) . '</p>';
    $html .= '<p><strong>Evidence File 1:</strong> ' . ($kra1Details['student_evidence_1'] ? '<a href="' . htmlspecialchars($kra1Details['student_evidence_1']) . '" target="_blank">View</a>' : 'N/A') . '</p>';
    $html .= '<p><strong>Evidence File 2:</strong> ' . ($kra1Details['student_evidence_2'] ? '<a href="' . htmlspecialchars($kra1Details['student_evidence_2']) . '" target="_blank">View</a>' : 'N/A') . '</p>';
    $html .= '</div>';
    $html .= '<div class="col-md-6">';
    $html .= '<h5>Supervisor Evaluation</h5>';
    $html .= '<p><strong>Divisor:</strong> ' . htmlspecialchars($kra1Details['supervisor_divisor']) . '</p>';
    $html .= '<p><strong>Reason:</strong> ' . htmlspecialchars($kra1Details['supervisor_reason']) . '</p>';
    $html .= '<p><strong>Overall Rating:</strong> ' . htmlspecialchars($kra1Details['supervisor_overall_rating']) . '</p>';
    $html .= '<p><strong>Faculty Rating:</strong> ' . htmlspecialchars($kra1Details['supervisor_faculty_rating']) . '</p>';
    $html .= '<p><strong>First Semester Rating:</strong> ' . htmlspecialchars($kra1Details['supervisor_first_sem']) . '</p>';
    $html .= '<p><strong>Second Semester Rating:</strong> ' . htmlspecialchars($kra1Details['supervisor_second_sem']) . '</p>';
    $html .= '<p><strong>Remarks (First Semester):</strong> ' . htmlspecialchars($kra1Details['supervisor_remarks_first']) . '</p>';
    $html .= '<p><strong>Remarks (Second Semester):</strong> ' . htmlspecialchars($kra1Details['supervisor_remarks_second']) . '</p>';
    $html .= '<p><strong>Evidence File 1:</strong> ' . ($kra1Details['supervisor_evidence_1'] ? '<a href="' . htmlspecialchars($kra1Details['supervisor_evidence_1']) . '" target="_blank">View</a>' : 'N/A') . '</p>';
    $html .= '<p><strong>Evidence File 2:</strong> ' . ($kra1Details['supervisor_evidence_2'] ? '<a href="' . htmlspecialchars($kra1Details['supervisor_evidence_2']) . '" target="_blank">View</a>' : 'N/A') . '</p>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';

    echo json_encode(['html' => $html]);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Error fetching KRA1 details: ' . $e->getMessage()]);
}