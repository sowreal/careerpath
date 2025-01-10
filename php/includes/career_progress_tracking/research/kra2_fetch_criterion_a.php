<?php
// php/dashboard/career_progress_tracking/research/kra2_fetch_criterion_a.php
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
    $stmt = $conn->prepare("SELECT * FROM kra2_a_sole_authorship WHERE request_id = ?");
    $stmt->execute([$request_id]);
    $sole_authorship = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 2) Fetch Co-Authorship
    $stmt = $conn->prepare("SELECT * FROM kra2_a_co_authorship WHERE request_id = ?");
    $stmt->execute([$request_id]);
    $co_authorship = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 3) Fetch Lead Researcher
    $stmt = $conn->prepare("SELECT * FROM kra2_a_lead_researcher WHERE request_id = ?");
    $stmt->execute([$request_id]);
    $lead_researcher = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 4) Fetch Contributor
    $stmt = $conn->prepare("SELECT * FROM kra2_a_contributor WHERE request_id = ?");
    $stmt->execute([$request_id]);
    $contributor = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 5) Fetch Local Authors
    $stmt = $conn->prepare("SELECT * FROM kra2_a_local_authors WHERE request_id = ?");
    $stmt->execute([$request_id]);
    $local_authors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 6) Fetch International Authors
    $stmt = $conn->prepare("SELECT * FROM kra2_a_international_authors WHERE request_id = ?");
    $stmt->execute([$request_id]);
    $international_authors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 7) Fetch Metadata (totals)
    $stmt = $conn->prepare("SELECT * FROM kra2_a_metadata WHERE request_id = ?");
    $stmt->execute([$request_id]);
    $metadata = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'sole_authorship'    => $sole_authorship,
        'co_authorship'      => $co_authorship,
        'lead_researcher'    => $lead_researcher,
        'contributor'        => $contributor,
        'local_authors'      => $local_authors,
        'international_authors' => $international_authors,
        'metadata'           => $metadata
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>