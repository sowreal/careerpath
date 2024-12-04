<?php
header('Content-Type: application/json');

try {
    // Include the database connection
    require_once '../../../connection.php';

    // Get request_id from GET or POST
    $request_id = isset($_GET['request_id']) ? intval($_GET['request_id']) :
                 (isset($_POST['request_id']) ? intval($_POST['request_id']) : 0);

    if ($request_id <= 0) {
        throw new Exception("Invalid request ID.");
    }

    // Fetch Sole Authorship Entries
    $stmt = $conn->prepare("SELECT * FROM kra1_b_sole_authorship WHERE request_id = ?");
    $stmt->execute([$request_id]);
    $sole_authorship = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch Co-Authorship Entries
    $stmt = $conn->prepare("SELECT * FROM kra1_b_co_authorship WHERE request_id = ?");
    $stmt->execute([$request_id]);
    $co_authorship = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch Academic Programs Entries
    $stmt = $conn->prepare("SELECT * FROM kra1_b_academic_programs WHERE request_id = ?");
    $stmt->execute([$request_id]);
    $academic_programs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare response
    $response = [
        'success' => true,
        'sole_authorship' => $sole_authorship,
        'co_authorship' => $co_authorship,
        'academic_programs' => $academic_programs
    ];

    echo json_encode($response);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
