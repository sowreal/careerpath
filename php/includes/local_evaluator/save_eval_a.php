<?php
// save_remarks.php
session_start();
require '../connection.php'; // Ensure this file establishes a PDO connection as $pdo

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $evaluation_id = $_POST['evaluation_id'] ?? '';
    $table_type = $_POST['table_type'] ?? '';
    $first_remark = $_POST['first_remark'] ?? '';
    $second_remark = $_POST['second_remark'] ?? '';
    $user_id = $_SESSION['user_id'] ?? null; // Ensure user is authenticated

    if (!$evaluation_id || !$table_type || !$user_id) {
        http_response_code(400);
        echo 'Invalid data.';
        exit;
    }

    try {
        // Determine the table based on table_type
        if ($table_type === 'student') {
            $tableName = 'student_evaluations'; // Replace with your actual table name
        } elseif ($table_type === 'supervisor') {
            $tableName = 'supervisor_evaluations'; // Replace with your actual table name
        } else {
            throw new Exception('Invalid table type.');
        }

        // Prepare the SQL statement
        $stmt = $pdo->prepare("UPDATE `$tableName` SET first_remark = :first_remark, second_remark = :second_remark WHERE evaluation_id = :evaluation_id AND user_id = :user_id");
        $stmt->execute([
            ':first_remark' => $first_remark,
            ':second_remark' => $second_remark,
            ':evaluation_id' => $evaluation_id,
            ':user_id' => $user_id
        ]);

        echo 'Success';
    } catch (Exception $e) {
        // Log the error message $e->getMessage() as needed
        http_response_code(500);
        echo 'Error';
    }
}
?>
