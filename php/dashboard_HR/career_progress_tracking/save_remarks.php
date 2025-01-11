<?php
require_once '../../session.php';
require_once '../../connection.php';
require_once '../../config.php';

header('Content-Type: application/json');

// Add these lines for debugging (temporarily)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $evaluationId = $_POST['evaluationId'];
    $tableType = $_POST['tableType'];
    $remarksFirst = $_POST['remarksFirst'];
    $remarksSecond = $_POST['remarksSecond'];

    try {
        // Use a dynamic table name based on $tableType
        $tableName = ($tableType === 'student') ? 'kra1_a_student_evaluation' : 'kra1_a_supervisor_evaluation';

        // Fetch the request_id from the table based on evaluation_id
        $stmt = $conn->prepare("SELECT request_id FROM {$tableName} WHERE evaluation_id = :evaluationId");
        $stmt->bindParam(':evaluationId', $evaluationId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $request_id = $row['request_id'];

            // Update remarks using the fetched request_id
            $stmt = $conn->prepare("UPDATE {$tableName} SET remarks_first = :remarks_first, remarks_second = :remarks_second WHERE evaluation_id = :evaluationId AND request_id = :request_id");

            // Bind parameters
            $stmt->bindParam(':remarks_first', $remarksFirst, PDO::PARAM_STR);
            $stmt->bindParam(':remarks_second', $remarksSecond, PDO::PARAM_STR);
            $stmt->bindParam(':evaluationId', $evaluationId, PDO::PARAM_INT);
            $stmt->bindParam(':request_id', $request_id, PDO::PARAM_INT); // Now using fetched request_id

            // Execute the statement
            if ($stmt->execute()) {
                // Check if any rows were affected
                if ($stmt->rowCount() > 0) {
                    echo json_encode(['status' => 'success']);
                } else {
                    // Handle case where no rows were updated
                    echo json_encode(['status' => 'error', 'message' => "No rows updated. Check evaluationId and request_id. Table: {$tableName}, Evaluation ID: {$evaluationId}, Request ID: {$request_id}"]);
                }
            } else {
                // Handle execution error
                $errorInfo = $stmt->errorInfo();
                echo json_encode(['status' => 'error', 'message' => "Failed to execute SQL statement: " . $errorInfo[2]]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => "No matching request_id found for evaluation_id: {$evaluationId} in table: {$tableName}"]);
        }
    } catch (PDOException $e) {
        // Catch any PDO exceptions
        echo json_encode(['status' => 'error', 'message' => "PDO Exception: " . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>