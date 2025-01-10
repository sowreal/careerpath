<?php
require_once '../../../connection.php';

if (isset($_GET['request_id'])) {
    $request_id = $_GET['request_id'];

    // Fetch Sole Authorship Data
    $stmt = $conn->prepare("SELECT * FROM kra2_a_sole_authorship WHERE request_id = ?");
    $stmt->execute([$request_id]);
    $sole_authorship = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch Co-Authorship Data
    $stmt = $conn->prepare("SELECT * FROM kra2_a_co_authorship WHERE request_id = ?");
    $stmt->execute([$request_id]);
    $co_authorship = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch Lead Researcher Data
    $stmt = $conn->prepare("SELECT * FROM kra2_a_lead_researcher WHERE request_id = ?");
    $stmt->execute([$request_id]);
    $lead_researcher = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch Contributor Data
    $stmt = $conn->prepare("SELECT * FROM kra2_a_contributor WHERE request_id = ?");
    $stmt->execute([$request_id]);
    $contributor = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch Local Authors Data
    $stmt = $conn->prepare("SELECT * FROM kra2_a_local_authors WHERE request_id = ?");
    $stmt->execute([$request_id]);
    $local_authors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch International Authors Data
    $stmt = $conn->prepare("SELECT * FROM kra2_a_international_authors WHERE request_id = ?");
    $stmt->execute([$request_id]);
    $international_authors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch Metadata
    $stmt = $conn->prepare("SELECT * FROM kra2_a_metadata WHERE request_id = ?");
    $stmt->execute([$request_id]);
    $metadata = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'sole_authorship' => $sole_authorship,
        'co_authorship' => $co_authorship,
        'lead_researcher' => $lead_researcher,
        'contributor' => $contributor,
        'local_authors' => $local_authors,
        'international_authors' => $international_authors,
        'metadata' => $metadata
    ]);
} else {
    echo json_encode(['error' => 'Request ID not provided']);
}
?>