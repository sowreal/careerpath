<?php
header('Content-Type: application/json');

try {
    require_once '../../../connection.php';

    // Get request_id
    $request_id = isset($_GET['request_id']) ? intval($_GET['request_id']) :
                 (isset($_POST['request_id']) ? intval($_POST['request_id']) : 0);

    if ($request_id <= 0) {
        throw new Exception("Invalid request ID.");
    }

    // 1) Fetch Sole Authorship
    $stmt = $conn->prepare("SELECT * FROM kra1_b_sole_authorship WHERE request_id = ?");
    $stmt->execute([$request_id]);
    $sole_authorship = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 2) Fetch Co-Authorship
    $stmt = $conn->prepare("SELECT * FROM kra1_b_co_authorship WHERE request_id = ?");
    $stmt->execute([$request_id]);
    $co_authorship = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 3) Fetch Academic Programs
    $stmt = $conn->prepare("SELECT * FROM kra1_b_academic_programs WHERE request_id = ?");
    $stmt->execute([$request_id]);
    $academic_programs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 4) Fetch Metadata (scores)
    $stmt = $conn->prepare("SELECT * FROM kra1_b_metadata WHERE request_id = ?");
    $stmt->execute([$request_id]);
    $metadata = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'sole_authorship'    => $sole_authorship,
        'co_authorship'      => $co_authorship,
        'academic_programs'  => $academic_programs,
        'metadata'           => $metadata
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
