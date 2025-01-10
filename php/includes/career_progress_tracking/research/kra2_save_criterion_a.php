<?php
require_once '../../../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = $_POST['request_id'];

    // --- 1. Save Sole Authorship Data ---
    $sole_authorship_data = $_POST['kra2_a_sole_authorship'];
    $sole_authorship_total = 0;

    foreach ($sole_authorship_data as $item) {
        // Calculate the score based on the conditions
        $score = 0;
        if (
            !empty($item['title']) &&
            !empty($item['journal_publisher']) &&
            !empty($item['reviewer']) &&
            !empty($item['date_published'])
        ) {
            switch ($item['type']) {
                case 'Book':
                case 'Monograph':
                    $score = 100;
                    break;
                case 'Journal Article':
                    if (!empty($item['international'])) {
                        $score = 50;
                    }
                    break;
                case 'Book Chapter':
                    $score = 35;
                    break;
                case 'Other Peer-Reviewed Output':
                    $score = 10;
                    break;
            }
        }
        $item['score'] = $score;
        $sole_authorship_total += $score;
        $stmt = $conn->prepare("INSERT INTO kra2_a_sole_authorship (request_id, title, type, journal_publisher, reviewer, international, date_published, score, evidence_file) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE title = VALUES(title), type = VALUES(type), journal_publisher = VALUES(journal_publisher), reviewer = VALUES(reviewer), international = VALUES(international), date_published = VALUES(date_published), score = VALUES(score), evidence_file = VALUES(evidence_file)");
        $stmt->execute([$request_id, $item['title'], $item['type'], $item['journal_publisher'], $item['reviewer'], $item['international'], $item['date_published'], $item['score'], $item['evidence_file']]);
    }

    // --- 2. Save Co-Authorship Data ---
    $co_authorship_data = $_POST['kra2_a_co_authorship'];
    $co_authorship_total = 0;

    foreach ($co_authorship_data as $item) {
        $score = 0;
        if (
            !empty($item['title']) &&
            !empty($item['date_published'])
        ) {
            switch ($item['type']) {
                case 'Book':
                case 'Monograph':
                    $score = 100;
                    break;
                case 'Journal Article':
                    if (!empty($item['international'])) {
                        $score = 50;
                    }
                    break;
                case 'Book Chapter':
                    $score = 35;
                    break;
                case 'Other Peer-Reviewed Output':
                    $score = 10;
                    break;
            }
        }
        $score = $score * ($item['contribution_percentage'] / 100);
        $item['score'] = $score;
        $co_authorship_total += $score;
        $stmt = $conn->prepare("INSERT INTO kra2_a_co_authorship (request_id, title, type, journal_publisher, reviewer, international, date_published, contribution_percentage, score, evidence_file) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE title = VALUES(title), type = VALUES(type), journal_publisher = VALUES(journal_publisher), reviewer = VALUES(reviewer), international = VALUES(international), date_published = VALUES(date_published), contribution_percentage = VALUES(contribution_percentage), score = VALUES(score), evidence_file = VALUES(evidence_file)");
        $stmt->execute([$request_id, $item['title'], $item['type'], $item['journal_publisher'], $item['reviewer'], $item['international'], $item['date_published'], $item['contribution_percentage'], $item['score'], $item['evidence_file']]);
    }

    // --- 3. Save Lead Researcher Data ---
    $lead_researcher_data = $_POST['kra1_a_lead_researcher'];
    $lead_researcher_total = 0;

    foreach ($lead_researcher_data as $item) {
        $score = 0;
        if (
            !empty($item['title']) &&
            !empty($item['date_completed']) &&
            !empty($item['project_name']) &&
            !empty($item['funding_source']) &&
            !empty($item['date_implemented'])
        ) {
            $score = 35;
        }
        $item['score'] = $score;
        $lead_researcher_total += $score;

        $stmt = $conn->prepare("INSERT INTO kra2_a_lead_researcher (request_id, title, date_completed, project_name, funding_source, date_implemented, score, evidence_file) VALUES (?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE title = VALUES(title), date_completed = VALUES(date_completed), project_name = VALUES(project_name), funding_source = VALUES(funding_source), date_implemented = VALUES(date_implemented), score = VALUES(score), evidence_file = VALUES(evidence_file)");
        $stmt->execute([$request_id, $item['title'], $item['date_completed'], $item['project_name'], $item['funding_source'], $item['date_implemented'], $item['score'], $item['evidence_file']]);
    }

    // --- 4. Save Contributor Data ---
    $contributor_data = $_POST['kra1_a_contributor'];
    $contributor_total = 0;

    foreach ($contributor_data as $item) {
        $score = 0;
        if (
            !empty($item['title']) &&
            !empty($item['date_completed']) &&
            !empty($item['project_name']) &&
            !empty($item['funding_source']) &&
            !empty($item['date_implemented'])
        ) {
            $score = 35;
        }

        $score = $score * ($item['contribution_percentage'] / 100);
        $item['score'] = $score;
        $contributor_total += $score;
        $stmt = $conn->prepare("INSERT INTO kra2_a_contributor (request_id, title, date_completed, project_name, funding_source, date_implemented, contribution_percentage, score, evidence_file) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE title = VALUES(title), date_completed = VALUES(date_completed), project_name = VALUES(project_name), funding_source = VALUES(funding_source), date_implemented = VALUES(date_implemented), contribution_percentage = VALUES(contribution_percentage), score = VALUES(score), evidence_file = VALUES(evidence_file)");
        $stmt->execute([$request_id, $item['title'], $item['date_completed'], $item['project_name'], $item['funding_source'], $item['date_implemented'], $item['contribution_percentage'], $item['score'], $item['evidence_file']]);
    }

    // --- 5. Save Local Authors Data ---
    $local_authors_data = $_POST['kra1_a_local_authors'];
    $local_authors_total = 0;

    foreach ($local_authors_data as $item) {
        $score = !empty($item['citation_count']) ? $item['citation_count'] * 5 : 0;
        $item['score'] = $score;
        $local_authors_total += $score;

        $stmt = $conn->prepare("INSERT INTO kra2_a_local_authors (request_id, title, date_published, journal_name, citation_count, citation_index, citation_year, score, evidence_file) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE title = VALUES(title), date_published = VALUES(date_published), journal_name = VALUES(journal_name), citation_count = VALUES(citation_count), citation_index = VALUES(citation_index), citation_year = VALUES(citation_year), score = VALUES(score), evidence_file = VALUES(evidence_file)");
        $stmt->execute([$request_id, $item['title'], $item['date_published'], $item['journal_name'], $item['citation_count'], $item['citation_index'], $item['citation_year'], $item['score'], $item['evidence_file']]);
    }

    // --- 6. Save International Authors Data ---
    $international_authors_data = $_POST['kra1_a_international_authors'];
    $international_authors_total = 0;

    foreach ($international_authors_data as $item) {
        $score = !empty($item['citation_count']) ? $item['citation_count'] * 10 : 0;
        $item['score'] = $score;
        $international_authors_total += $score;
        $stmt = $conn->prepare("INSERT INTO kra2_a_international_authors (request_id, title, date_published, journal_name, citation_count, citation_index, citation_year, score, evidence_file) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE title = VALUES(title), date_published = VALUES(date_published), journal_name = VALUES(journal_name), citation_count = VALUES(citation_count), citation_index = VALUES(citation_index), citation_year = VALUES(citation_year), score = VALUES(score), evidence_file = VALUES(evidence_file)");
        $stmt->execute([$request_id, $item['title'], $item['date_published'], $item['journal_name'], $item['citation_count'], $item['citation_index'], $item['citation_year'], $item['score'], $item['evidence_file']]);
    }

    // --- 7. Update Metadata ---
    $overall_score = $sole_authorship_total + $co_authorship_total + $lead_researcher_total + $contributor_total + $local_authors_total + $international_authors_total;

    $stmt = $conn->prepare("INSERT INTO kra2_a_metadata (request_id, sole_authorship_total, co_authorship_total, lead_researcher_total, contributor_total, local_authors_total, international_authors_total, overall_score) VALUES (?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE sole_authorship_total = VALUES(sole_authorship_total), co_authorship_total = VALUES(co_authorship_total), lead_researcher_total = VALUES(lead_researcher_total), contributor_total = VALUES(contributor_total), local_authors_total = VALUES(local_authors_total), international_authors_total = VALUES(international_authors_total), overall_score = VALUES(overall_score)");
    $stmt->execute([$request_id, $sole_authorship_total, $co_authorship_total, $lead_researcher_total, $contributor_total, $local_authors_total, $international_authors_total, $overall_score]);

    // --- 8. Respond with success ---
    echo json_encode(['status' => 'success', 'message' => 'Data saved successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>