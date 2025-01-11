<?php
include('../../session.php');
include('../../connection.php');

header('Content-Type: application/json');

$facultyId = isset($_GET['faculty_id']) ? (int) $_GET['faculty_id'] : 0;

if ($facultyId <= 0) {
    echo json_encode(['error' => 'Invalid faculty ID.']);
    exit();
}

try {
    $stmt = $conn->prepare("
        SELECT 
            id, 
            first_name, 
            middle_name, 
            last_name, 
            email, 
            phone_number, 
            alt_email, 
            employee_id, 
            department, 
            faculty_rank, 
            role, 
            last_updated, 
            created_at, 
            profile_picture 
        FROM users 
        WHERE id = :id 
          AND role IN ('Permanent Instructor', 'Contract of Service Instructor', 'Human Resources')
    ");
    $stmt->bindParam(':id', $facultyId, PDO::PARAM_INT);
    $stmt->execute();
    $faculty = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($faculty) {
        // Send the profile_picture as is (filename only)
        echo json_encode(['faculty' => $faculty]);
    } else {
        echo json_encode(['error' => 'Faculty member not found.']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error fetching faculty details: ' . $e->getMessage()]);
}
?>
