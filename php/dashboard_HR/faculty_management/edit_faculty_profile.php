<?php
include('../../session.php'); // Ensure the user is logged in
include('../../connection.php'); // Include the database connection

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request method.']);
    exit();
}

// Collect and sanitize POST data
$facultyId = isset($_POST['id']) ? (int) $_POST['id'] : 0;
$firstName = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
$middleName = isset($_POST['middle_name']) ? trim($_POST['middle_name']) : '';
$lastName = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
$employeeId = isset($_POST['employee_id']) ? trim($_POST['employee_id']) : '';
$phoneNumber = isset($_POST['phone_number']) ? trim($_POST['phone_number']) : '';
$altEmail = isset($_POST['alt_email']) ? trim($_POST['alt_email']) : '';
$department = isset($_POST['department']) ? trim($_POST['department']) : '';
$facultyRank = isset($_POST['faculty_rank']) ? trim($_POST['faculty_rank']) : '';
$role = isset($_POST['role']) ? trim($_POST['role']) : '';
// $careerGoals = isset($_POST['career_goals']) ? trim($_POST['career_goals']) : ''; // Commented out

// Validate required fields
if (empty($facultyId) || empty($firstName) || empty($lastName) || empty($employeeId) || empty($phoneNumber) || empty($department) || empty($facultyRank) || empty($role)) {
    echo json_encode(['error' => 'Please fill in all required fields.']);
    exit();
}

try {
    // Check if the new employee_id already exists for a different user
    $checkStmt = $conn->prepare("SELECT id FROM users WHERE employee_id = :employee_id AND id != :current_id");
    $checkStmt->bindParam(':employee_id', $employeeId, PDO::PARAM_STR);
    $checkStmt->bindParam(':current_id', $facultyId, PDO::PARAM_INT);
    $checkStmt->execute();
    if ($checkStmt->rowCount() > 0) {
        echo json_encode(['error' => 'Employee ID already exists. Please choose a different one.']);
        exit();
    }

    // Update faculty details
    $updateStmt = $conn->prepare("
        UPDATE users 
        SET 
            first_name = :first_name,
            middle_name = :middle_name,
            last_name = :last_name,
            employee_id = :employee_id,
            phone_number = :phone_number, 
            alt_email = :alt_email, 
            department = :department, 
            faculty_rank = :faculty_rank, 
            role = :role,
            last_updated = NOW()
        WHERE id = :id
    ");
    $updateStmt->bindParam(':first_name', $firstName, PDO::PARAM_STR);
    $updateStmt->bindParam(':middle_name', $middleName, PDO::PARAM_STR);
    $updateStmt->bindParam(':last_name', $lastName, PDO::PARAM_STR);
    $updateStmt->bindParam(':employee_id', $employeeId, PDO::PARAM_STR);
    $updateStmt->bindParam(':phone_number', $phoneNumber, PDO::PARAM_STR);
    $updateStmt->bindParam(':alt_email', $altEmail, PDO::PARAM_STR);
    $updateStmt->bindParam(':department', $department, PDO::PARAM_STR);
    $updateStmt->bindParam(':faculty_rank', $facultyRank, PDO::PARAM_STR);
    $updateStmt->bindParam(':role', $role, PDO::PARAM_STR);
    $updateStmt->bindParam(':id', $facultyId, PDO::PARAM_INT);
    $updateStmt->execute();

    echo json_encode(['success' => 'Faculty profile updated successfully.']);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error updating faculty profile: ' . $e->getMessage()]);
}
?>
