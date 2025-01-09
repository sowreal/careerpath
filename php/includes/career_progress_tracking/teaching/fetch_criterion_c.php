<?php
header('Content-Type: application/json');

try {
    require_once '../../../connection.php';

    // Retrieve request_id from GET or POST parameters
    $request_id = isset($_GET['request_id']) ? intval($_GET['request_id']) :
                 (isset($_POST['request_id']) ? intval($_POST['request_id']) : 0);

    if ($request_id <= 0) {
        throw new Exception("Invalid request ID.");
    }

    // Fetch kra1_c_metadata
    $stmt = $conn->prepare("SELECT * FROM kra1_c_metadata WHERE request_id = ?");
    $stmt->execute([$request_id]);
    $metadata = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch Adviser Evaluations
    $stmt = $conn->prepare("SELECT * FROM kra1_c_adviser WHERE request_id = ?");
    $stmt->execute([$request_id]);
    $adviser_evaluations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch Panel Evaluations
    $stmt = $conn->prepare("SELECT * FROM kra1_c_panel WHERE request_id = ?");
    $stmt->execute([$request_id]);
    $panel_evaluations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch Mentor Evaluations
    $stmt = $conn->prepare("SELECT * FROM kra1_c_mentor WHERE request_id = ?");
    $stmt->execute([$request_id]);
    $mentor_evaluations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response = [
        'success' => true,
        'metadata' => $metadata,
        'adviser' => $adviser_evaluations,
        'panel' => $panel_evaluations,
        'mentor' => $mentor_evaluations
    ];

    echo json_encode($response);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
