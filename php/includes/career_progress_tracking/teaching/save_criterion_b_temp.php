<?php
include_once '../../../session.php';
header('Content-Type: application/json');
include_once '../../../connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

$request_id = isset($data['request_id']) ? intval($data['request_id']) : 0;

// Validate request_id
if ($request_id <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Please select an evaluation ID']);
    exit();
}

try {
    $conn->beginTransaction();

    // Handle Sole Authorship Entries
    if (isset($data['sole_authorship']) && is_array($data['sole_authorship'])) {
        foreach ($data['sole_authorship'] as $entry) {
            if (isset($entry['entry_id']) && $entry['entry_id'] > 0) {
                // Update existing entry
                $update_stmt = $conn->prepare("UPDATE kra1_b_sole_authorship SET 
                    title = :title,
                    type = :type,
                    reviewer = :reviewer,
                    date_published = :date_published,
                    date_approved = :date_approved,
                    faculty_score = :faculty_score,
                    evidence_link = :evidence_link
                    WHERE entry_id = :entry_id");
                $update_stmt->execute([
                    ':title' => $entry['title'],
                    ':type' => $entry['type'],
                    ':reviewer' => $entry['reviewer'],
                    ':date_published' => $entry['date_published'],
                    ':date_approved' => $entry['date_approved'],
                    ':faculty_score' => $entry['faculty_score'],
                    ':evidence_link' => $entry['evidence_link'],
                    ':entry_id' => $entry['entry_id']
                ]);
            } else {
                // Insert new entry
                $insert_stmt = $conn->prepare("INSERT INTO kra1_b_sole_authorship 
                    (request_id, title, type, reviewer, date_published, date_approved, faculty_score, evidence_link) 
                    VALUES 
                    (:request_id, :title, :type, :reviewer, :date_published, :date_approved, :faculty_score, :evidence_link)");
                $insert_stmt->execute([
                    ':request_id' => $request_id,
                    ':title' => $entry['title'],
                    ':type' => $entry['type'],
                    ':reviewer' => $entry['reviewer'],
                    ':date_published' => $entry['date_published'],
                    ':date_approved' => $entry['date_approved'],
                    ':faculty_score' => $entry['faculty_score'],
                    ':evidence_link' => $entry['evidence_link']
                ]);
            }
        }
    }

    // Handle Co-Authorship Entries
    if (isset($data['co_authorship']) && is_array($data['co_authorship'])) {
        foreach ($data['co_authorship'] as $entry) {
            if (isset($entry['entry_id']) && $entry['entry_id'] > 0) {
                // Update existing entry
                $update_stmt = $conn->prepare("UPDATE kra1_b_co_authorship SET 
                    title = :title,
                    type = :type,
                    reviewer = :reviewer,
                    date_published = :date_published,
                    date_approved = :date_approved,
                    contribution_percentage = :contribution_percentage,
                    faculty_score = :faculty_score,
                    evidence_link = :evidence_link
                    WHERE entry_id = :entry_id");
                $update_stmt->execute([
                    ':title' => $entry['title'],
                    ':type' => $entry['type'],
                    ':reviewer' => $entry['reviewer'],
                    ':date_published' => $entry['date_published'],
                    ':date_approved' => $entry['date_approved'],
                    ':contribution_percentage' => $entry['contribution_percentage'],
                    ':faculty_score' => $entry['faculty_score'],
                    ':evidence_link' => $entry['evidence_link'],
                    ':entry_id' => $entry['entry_id']
                ]);
            } else {
                // Insert new entry
                $insert_stmt = $conn->prepare("INSERT INTO kra1_b_co_authorship 
                    (request_id, title, type, reviewer, date_published, date_approved, contribution_percentage, faculty_score, evidence_link) 
                    VALUES 
                    (:request_id, :title, :type, :reviewer, :date_published, :date_approved, :contribution_percentage, :faculty_score, :evidence_link)");
                $insert_stmt->execute([
                    ':request_id' => $request_id,
                    ':title' => $entry['title'],
                    ':type' => $entry['type'],
                    ':reviewer' => $entry['reviewer'],
                    ':date_published' => $entry['date_published'],
                    ':date_approved' => $entry['date_approved'],
                    ':contribution_percentage' => $entry['contribution_percentage'],
                    ':faculty_score' => $entry['faculty_score'],
                    ':evidence_link' => $entry['evidence_link']
                ]);
            }
        }
    }

    // Handle Academic Programs Entries
    if (isset($data['academic_programs']) && is_array($data['academic_programs'])) {
        foreach ($data['academic_programs'] as $entry) {
            if (isset($entry['entry_id']) && $entry['entry_id'] > 0) {
                // Update existing entry
                $update_stmt = $conn->prepare("UPDATE kra1_b_academic_programs SET 
                    program_name = :program_name,
                    program_type = :program_type,
                    board_approval = :board_approval,
                    year_implemented = :year_implemented,
                    role = :role,
                    faculty_score = :faculty_score,
                    evidence_link = :evidence_link
                    WHERE entry_id = :entry_id");
                $update_stmt->execute([
                    ':program_name' => $entry['program_name'],
                    ':program_type' => $entry['program_type'],
                    ':board_approval' => $entry['board_approval'],
                    ':year_implemented' => $entry['year_implemented'],
                    ':role' => $entry['role'],
                    ':faculty_score' => $entry['faculty_score'],
                    ':evidence_link' => $entry['evidence_link'],
                    ':entry_id' => $entry['entry_id']
                ]);
            } else {
                // Insert new entry
                $insert_stmt = $conn->prepare("INSERT INTO kra1_b_academic_programs 
                    (request_id, program_name, program_type, board_approval, year_implemented, role, faculty_score, evidence_link) 
                    VALUES 
                    (:request_id, :program_name, :program_type, :board_approval, :year_implemented, :role, :faculty_score, :evidence_link)");
                $insert_stmt->execute([
                    ':request_id' => $request_id,
                    ':program_name' => $entry['program_name'],
                    ':program_type' => $entry['program_type'],
                    ':board_approval' => $entry['board_approval'],
                    ':year_implemented' => $entry['year_implemented'],
                    ':role' => $entry['role'],
                    ':faculty_score' => $entry['faculty_score'],
                    ':evidence_link' => $entry['evidence_link']
                ]);
            }
        }
    }

    $conn->commit();
    echo json_encode(['success' => 'Criterion B saved successfully']);
} catch (Exception $e) {
    $conn->rollBack();
    http_response_code(500);
    echo json_encode(['error' => 'Failed to save data: ' . $e->getMessage()]);
}
?>
