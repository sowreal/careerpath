<?php
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../../session.php');
include('../../connection.php');
require_once '../../config.php';


$projectRoot = __DIR__ . '/../../../'; // Go up three levels from generate_pdf.php
$autoloadPath = $projectRoot . 'vendor/autoload.php';
require_once $autoloadPath;          


// Determine how to get the request_id (from GET or POST)
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['request_id'])) {
    $request_id = $_GET['request_id'];
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pdf_request_id'])) {
    $request_id = $_POST['pdf_request_id'];
} else {
    die("Request ID is missing.");
}

// Fetch data from the database based on $request_id
try {
    // 1. Fetch request data
    $stmt = $conn->prepare("SELECT * FROM request_form WHERE request_id = :request_id");
    $stmt->bindValue(':request_id', $request_id, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        die("Request not found for request_id: " . $request_id);
    }

    // 2. Fetch user data using user_id from $data
    $userStmt = $conn->prepare("SELECT first_name, middle_name, last_name, email FROM users WHERE id = :user_id");
    $userStmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
    $userStmt->execute();
    $userData = $userStmt->fetch(PDO::FETCH_ASSOC);

    if (!$userData) {
        die("User not found for user_id: " . $data['user_id']);
    }

} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($userData['first_name'] . ' ' . $userData['last_name']);
$pdf->SetTitle('Career Progress Request Form- ' . $request_id);
$pdf->SetSubject('Career Progress Request');
$pdf->SetKeywords('Career, Progress, Request, ' . $request_id);

// Set default header data
$pdf->SetHeaderData('', 0, 'Career Progress Request Form', 'Request ID: ' . $request_id, array(0,0,0), array(255,255,255));

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// Convert mode_of_appointment to human-readable format
$mode_of_appointment_text = '';
switch ($data['mode_of_appointment']) {
    case 'new_appointment':
        $mode_of_appointment_text = 'New Appointment';
        break;
    case 'institutional_promotion':
        $mode_of_appointment_text = 'Institutional Promotion';
        break;
    case 'nbc461':
        $mode_of_appointment_text = 'NBC 461';
        break;
    default:
        $mode_of_appointment_text = 'Unknown';
        break;
}

// Add content to the PDF
// Function to create a table with gridlines and grouped data
function createGroupedTable($pdf, $groupName, $data) {
    $html = '<table style="width: 100%; border: 1px solid black; border-collapse: collapse;">';
    $html .= '<tr><td colspan="2" style="border: 1px solid black; background-color: #f2f2f2; font-weight: bold;">' . $groupName . '</td></tr>';

    foreach ($data as $label => $value) {
        $html .= '<tr>';
        $html .= '<td style="border: 1px solid black; font-weight: bold; width: 40%;">' . $label . '</td>';
        $html .= '<td style="border: 1px solid black; width: 60%;">' . (!empty($value) ? $value : ' ') . '</td>';
        $html .= '</tr>';
    }

    $html .= '</table>';
    $pdf->writeHTML($html, true, false, true, false, '');
}

// --- Build the PDF content ---

// Add h1 and h2 headings first
$headings = "
    <h1 style='text-align: center;'>SUC FACULTY POSITION RECLASSIFICATION</h1>
    <h2 style='text-align: center;'>REQUEST FORM</h2>
";
$pdf->writeHTML($headings, true, false, true, false, '');

// Grouped Data
$personalInfo = [
    'Last Name' => $userData['last_name'],
    'First Name' => $userData['first_name'],
    'Middle Name' => $userData['middle_name'],
    'Email' => $userData['email']
];

$educationalAttainment = [
    'Name of Degree' => $data['degree_name'],
    'Name of HEI' => $data['name_of_hei'],
    'Year Graduated' => $data['year_graduated']
];

$employmentStatus = [
    'Current Faculty Rank' => $data['current_rank'],
    'Mode of Appointment' => $mode_of_appointment_text,
    'Date of Appointment' => ($data['date_of_appointment'] ? date('F j, Y', strtotime($data['date_of_appointment'])) : 'N/A'),
    'Name of SUC' => $data['suc_name'],
    'Campus' => $data['campus'],
    'Address' => $data['address']
];

// Output the grouped tables
createGroupedTable($pdf, 'PERSONAL INFORMATION', $personalInfo);
createGroupedTable($pdf, 'HIGHEST EDUCATIONAL ATTAINMENT', $educationalAttainment);
createGroupedTable($pdf, 'CURRENT EMPLOYMENT STATUS', $employmentStatus);

// Statement of Agreement
$statementOfAgreement = "
    <h4>Statement of Agreement</h4>
    <p>Attached to this request form are my self-accomplished Individual Summary Sheet (ISS) and its attached forms; checklist of evidence submitted; and photocopy of the sets of evidence based on my ISS. The electronic copies of the ISS and the evidence are available in my Google Drive that I will willingly share with the Evaluation Committees for the validation of the information submitted.</p>
    <p>I attest that all information provided in this request for position reclassification are true, accurate, and complete. I understand that any falsification of these documents may lead to my disqualification from position reclassification for this evaluation cycle.</p>
";

// Signature line (adjust styling as needed)
$signatureLine = "
    <p style='text-align: center;'><strong>__________________________________________</strong></p>
    <p style='text-align: center;'><strong>Signature over printed name of faculty</strong></p>
";

// Combine the content into one string
$htmlContent = $statementOfAgreement . $signatureLine;

// Write the combined HTML content
$pdf->writeHTML($htmlContent, true, false, true, false, '');


ob_end_clean();

// Output the PDF
$pdf->Output('career_progress_request_' . $request_id . '.pdf', 'I');
exit;
?>

