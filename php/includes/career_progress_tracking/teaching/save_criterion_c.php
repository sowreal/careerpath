<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 0);

header('Content-Type: application/json');
require_once '../../../session.php';
require_once '../../../connection.php';
require_once '../../../config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit();
}

// Retrieve and decode JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate request_id
$request_id = isset($data['request_id']) ? intval($data['request_id']) : 0;
if ($request_id <= 0) {
    echo json_encode(['success' => false, 'error' => 'Please select a valid evaluation ID.']);
    exit();
}

// Retrieve Adviser, Panel, and Mentor evaluations
$advisers = isset($data['advisers']) && is_array($data['advisers']) ? $data['advisers'] : [];
$panels = isset($data['panels']) && is_array($data['panels']) ? $data['panels'] : [];
$mentors = isset($data['mentors']) && is_array($data['mentors']) ? $data['mentors'] : [];

// Retrieve overall scores
$adviser_total = isset($data['adviser_total']) ? floatval($data['adviser_total']) : 0;
$panel_total = isset($data['panel_total']) ? floatval($data['panel_total']) : 0;
$mentor_total = isset($data['mentor_total']) ? floatval($data['mentor_total']) : 0;

// Retrieve deleted evaluations
$deletedAdvisers = isset($data['deletedAdvisers']) && is_array($data['deletedAdvisers']) ? $data['deletedAdvisers'] : [];
$deletedPanels = isset($data['deletedPanels']) && is_array($data['deletedPanels']) ? $data['deletedPanels'] : [];
$deletedMentors = isset($data['deletedMentors']) && is_array($data['deletedMentors']) ? $data['deletedMentors'] : [];

try {
    $conn->beginTransaction();

    // === Handle Deletions ===
    // Delete Advisers
    if (!empty($deletedAdvisers)) {
        $stmt = $conn->prepare("DELETE FROM kra1_c_adviser WHERE adviser_id = :adviser_id AND request_id = :request_id");
        foreach ($deletedAdvisers as $adviser_id) {
            $stmt->execute([
                ':adviser_id' => intval($adviser_id),
                ':request_id' => $request_id
            ]);
        }
    }

    // Delete Panels
    if (!empty($deletedPanels)) {
        $stmt = $conn->prepare("DELETE FROM kra1_c_panel WHERE panel_id = :panel_id AND request_id = :request_id");
        foreach ($deletedPanels as $panel_id) {
            $stmt->execute([
                ':panel_id' => intval($panel_id),
                ':request_id' => $request_id
            ]);
        }
    }

    // Delete Mentors
    if (!empty($deletedMentors)) {
        $stmt = $conn->prepare("DELETE FROM kra1_c_mentor WHERE mentor_id = :mentor_id AND request_id = :request_id");
        foreach ($deletedMentors as $mentor_id) {
            $stmt->execute([
                ':mentor_id' => intval($mentor_id),
                ':request_id' => $request_id
            ]);
        }
    }

    // === Update/Insert Metadata ===
    $stmt = $conn->prepare("SELECT kra1_c_metadata_id FROM kra1_c_metadata WHERE request_id = ?");
    $stmt->execute([$request_id]);
    $metadata = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($metadata) {
        // Update existing metadata
        $update_meta = $conn->prepare("UPDATE kra1_c_metadata SET 
            adviser_total = :adviser_total, 
            panel_total = :panel_total, 
            mentor_total = :mentor_total,
            updated_at = CURRENT_TIMESTAMP
            WHERE kra1_c_metadata_id = :metadata_id");
        $update_meta->execute([
            ':adviser_total' => $adviser_total,
            ':panel_total' => $panel_total,
            ':mentor_total' => $mentor_total,
            ':metadata_id' => $metadata['kra1_c_metadata_id']
        ]);
    } else {
        // Insert new metadata
        $insert_meta = $conn->prepare("INSERT INTO kra1_c_metadata 
            (request_id, adviser_total, panel_total, mentor_total) 
            VALUES 
            (:request_id, :adviser_total, :panel_total, :mentor_total)");
        $insert_meta->execute([
            ':request_id' => $request_id,
            ':adviser_total' => $adviser_total,
            ':panel_total' => $panel_total,
            ':mentor_total' => $mentor_total
        ]);
    }

    // === Upsert Adviser Evaluations ===
    $stmt = $conn->prepare("SELECT adviser_id FROM kra1_c_adviser WHERE adviser_id = :adviser_id AND request_id = :request_id");
    $update_adviser = $conn->prepare("UPDATE kra1_c_adviser SET
        requirement = :requirement,
        ay_2019 = :ay_2019,
        ay_2020 = :ay_2020,
        ay_2021 = :ay_2021,
        ay_2022 = :ay_2022,
        score = :score,
        evidence_file = :evidence_file,
        remarks = :remarks,
        updated_at = CURRENT_TIMESTAMP
        WHERE adviser_id = :adviser_id AND request_id = :request_id");
    $insert_adviser = $conn->prepare("INSERT INTO kra1_c_adviser 
        (request_id, requirement, ay_2019, ay_2020, ay_2021, ay_2022, score, evidence_file, remarks) 
        VALUES 
        (:request_id, :requirement, :ay_2019, :ay_2020, :ay_2021, :ay_2022, :score, :evidence_file, :remarks)");

    foreach ($advisers as $adviser) {
        $adviser_id = isset($adviser['adviser_id']) ? intval($adviser['adviser_id']) : 0;

        if ($adviser_id > 0) {
            // Check if Adviser exists
            $stmt->execute([
                ':adviser_id' => $adviser_id,
                ':request_id' => $request_id
            ]);
            if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                // Update existing Adviser
                $update_adviser->execute([
                    ':requirement' => $adviser['requirement'],
                    ':ay_2019' => intval($adviser['ay_2019']),
                    ':ay_2020' => intval($adviser['ay_2020']),
                    ':ay_2021' => intval($adviser['ay_2021']),
                    ':ay_2022' => intval($adviser['ay_2022']),
                    ':score' => floatval($adviser['score']),
                    ':evidence_file' => $adviser['evidence_file'],
                    ':remarks' => $adviser['remarks'],
                    ':adviser_id' => $adviser_id,
                    ':request_id' => $request_id
                ]);
                continue;
            }
        }

        // Insert new Adviser
        $insert_adviser->execute([
            ':request_id' => $request_id,
            ':requirement' => $adviser['requirement'],
            ':ay_2019' => intval($adviser['ay_2019']),
            ':ay_2020' => intval($adviser['ay_2020']),
            ':ay_2021' => intval($adviser['ay_2021']),
            ':ay_2022' => intval($adviser['ay_2022']),
            ':score' => floatval($adviser['score']),
            ':evidence_file' => $adviser['evidence_file'],
            ':remarks' => $adviser['remarks']
        ]);
    }

    // === Upsert Panel Evaluations ===
    $stmt = $conn->prepare("SELECT panel_id FROM kra1_c_panel WHERE panel_id = :panel_id AND request_id = :request_id");
    $update_panel = $conn->prepare("UPDATE kra1_c_panel SET
        requirement = :requirement,
        ay_2019 = :ay_2019,
        ay_2020 = :ay_2020,
        ay_2021 = :ay_2021,
        ay_2022 = :ay_2022,
        score = :score,
        evidence_file = :evidence_file,
        remarks = :remarks,
        updated_at = CURRENT_TIMESTAMP
        WHERE panel_id = :panel_id AND request_id = :request_id");
    $insert_panel = $conn->prepare("INSERT INTO kra1_c_panel 
        (request_id, requirement, ay_2019, ay_2020, ay_2021, ay_2022, score, evidence_file, remarks) 
        VALUES 
        (:request_id, :requirement, :ay_2019, :ay_2020, :ay_2021, :ay_2022, :score, :evidence_file, :remarks)");

    foreach ($panels as $panel) {
        $panel_id = isset($panel['panel_id']) ? intval($panel['panel_id']) : 0;

        if ($panel_id > 0) {
            // Check if Panel exists
            $stmt->execute([
                ':panel_id' => $panel_id,
                ':request_id' => $request_id
            ]);
            if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                // Update existing Panel
                $update_panel->execute([
                    ':requirement' => $panel['requirement'],
                    ':ay_2019' => intval($panel['ay_2019']),
                    ':ay_2020' => intval($panel['ay_2020']),
                    ':ay_2021' => intval($panel['ay_2021']),
                    ':ay_2022' => intval($panel['ay_2022']),
                    ':score' => floatval($panel['score']),
                    ':evidence_file' => $panel['evidence_file'],
                    ':remarks' => $panel['remarks'],
                    ':panel_id' => $panel_id,
                    ':request_id' => $request_id
                ]);
                continue;
            }
        }

        // Insert new Panel
        $insert_panel->execute([
            ':request_id' => $request_id,
            ':requirement' => $panel['requirement'],
            ':ay_2019' => intval($panel['ay_2019']),
            ':ay_2020' => intval($panel['ay_2020']),
            ':ay_2021' => intval($panel['ay_2021']),
            ':ay_2022' => intval($panel['ay_2022']),
            ':score' => floatval($panel['score']),
            ':evidence_file' => $panel['evidence_file'],
            ':remarks' => $panel['remarks']
        ]);
    }

    // === Upsert Mentor Evaluations ===
    $stmt = $conn->prepare("SELECT mentor_id FROM kra1_c_mentor WHERE mentor_id = :mentor_id AND request_id = :request_id");
    $update_mentor = $conn->prepare("UPDATE kra1_c_mentor SET
        competition = :competition,
        organization = :organization,
        award = :award,
        date_awarded = :date_awarded,
        score = :score,
        evidence_file = :evidence_file,
        remarks = :remarks,
        updated_at = CURRENT_TIMESTAMP
        WHERE mentor_id = :mentor_id AND request_id = :request_id");
    $insert_mentor = $conn->prepare("INSERT INTO kra1_c_mentor 
        (request_id, competition, organization, award, date_awarded, score, evidence_file, remarks) 
        VALUES 
        (:request_id, :competition, :organization, :award, :date_awarded, :score, :evidence_file, :remarks)");

    foreach ($mentors as $mentor) {
        $mentor_id = isset($mentor['mentor_id']) ? intval($mentor['mentor_id']) : 0;

        if ($mentor_id > 0) {
            // Check if Mentor exists
            $stmt->execute([
                ':mentor_id' => $mentor_id,
                ':request_id' => $request_id
            ]);
            if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                // Update existing Mentor
                $update_mentor->execute([
                    ':competition' => $mentor['competition'],
                    ':organization' => $mentor['organization'],
                    ':award' => $mentor['award'],
                    ':date_awarded' => $mentor['date_awarded'],
                    ':score' => floatval($mentor['score']),
                    ':evidence_file' => $mentor['evidence_file'],
                    ':remarks' => $mentor['remarks'],
                    ':mentor_id' => $mentor_id,
                    ':request_id' => $request_id
                ]);
                continue;
            }
        }

        // Insert new Mentor
        $insert_mentor->execute([
            ':request_id' => $request_id,
            ':competition' => $mentor['competition'],
            ':organization' => $mentor['organization'],
            ':award' => $mentor['award'],
            ':date_awarded' => $mentor['date_awarded'],
            ':score' => floatval($mentor['score']),
            ':evidence_file' => $mentor['evidence_file'],
            ':remarks' => $mentor['remarks']
        ]);
    }

    // === Recalculate and Update Metadata ===
    // Adviser Total is already provided, similarly for Panel and Mentor
    // If additional calculations are needed based on database entries, implement them here

    // If you need to perform any additional calculations or validations, do so here

    $conn->commit();
    echo json_encode(['success' => true, 'message' => 'Criterion C saved successfully.']);
} catch (Exception $e) {
    $conn->rollBack();
    echo json_encode(['success' => false, 'error' => 'Failed to save data: ' . $e->getMessage()]);
}
?>
