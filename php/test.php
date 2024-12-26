<?php
// Example: kra_summary_HR.php
// Assume we have faculty_id and request_id from GET parameters
$faculty_id = isset($_GET['faculty_id']) ? intval($_GET['faculty_id']) : 0;
$request_id = isset($_GET['request_id']) ? intval($_GET['request_id']) : 0;

// Normally, you'd fetch faculty name and request details from the database here
// For demonstration, let's use placeholder values
$faculty_name = "Dr. Jane Doe";
$request_date = "Oct 18, 2023";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>KRA Summary (HR View)</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">
    <nav class="navbar navbar-expand navbar-dark bg-success">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">CareerPath (HR)</a>
            <!-- You could add logout or profile links on the right side if needed -->
        </div>
    </nav>

    <div class="container my-4">
        <!-- Breadcrumb or Back Link -->
        <div class="mb-3">
            <a href="faculty_management.php" class="btn btn-sm btn-outline-secondary">&laquo; Back to Faculty Management</a>
        </div>

        <!-- Faculty and Request Info -->
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title mb-3">Career Progress Summary</h4>
                <p><strong>Faculty Name:</strong> <?php echo htmlspecialchars($faculty_name); ?></p>
                <p><strong>Request ID:</strong> <?php echo $request_id; ?></p>
                <p><strong>Request Date:</strong> <?php echo htmlspecialchars($request_date); ?></p>
                <!-- Add more summary info as needed -->
            </div>
        </div>

        <!-- Tabs for KRAs -->
        <ul class="nav nav-tabs" id="kraTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="kra1-tab" data-bs-toggle="tab" data-bs-target="#kra1" type="button" role="tab" aria-controls="kra1" aria-selected="true">KRA I (Teaching)</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="kra2-tab" data-bs-toggle="tab" data-bs-target="#kra2" type="button" role="tab" aria-controls="kra2" aria-selected="false">KRA II (Research)</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="kra3-tab" data-bs-toggle="tab" data-bs-target="#kra3" type="button" role="tab" aria-controls="kra3" aria-selected="false">KRA III (Extension)</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="kra4-tab" data-bs-toggle="tab" data-bs-target="#kra4" type="button" role="tab" aria-controls="kra4" aria-selected="false">KRA IV (Prof. Development)</button>
            </li>
        </ul>

        <div class="tab-content border border-top-0 p-3 bg-white" id="kraTabsContent">
            <!-- KRA 1 Content -->
            <div class="tab-pane fade show active" id="kra1" role="tabpanel" aria-labelledby="kra1-tab">
                <h5>KRA I (Teaching) Summary</h5>
                <p>Show summary metrics here, e.g., overall ratings, hours taught, etc.</p>
                <p>For detailed Criterion A, B, C, etc., you can add sub-links:</p>
                <a href="kra1_HR.php?faculty_id=<?php echo $faculty_id; ?>&request_id=<?php echo $request_id; ?>" class="btn btn-sm btn-primary">View KRA I Details</a>
            </div>

            <!-- KRA 2 Content -->
            <div class="tab-pane fade" id="kra2" role="tabpanel" aria-labelledby="kra2-tab">
                <h5>KRA II (Research, Innovation, & Creative Works) Summary</h5>
                <p>Summary of research outputs, publications, etc.</p>
                <a href="kra2_HR.php?faculty_id=<?php echo $faculty_id; ?>&request_id=<?php echo $request_id; ?>" class="btn btn-sm btn-primary">View KRA II Details</a>
            </div>

            <!-- KRA 3 Content -->
            <div class="tab-pane fade" id="kra3" role="tabpanel" aria-labelledby="kra3-tab">
                <h5>KRA III (Extension Services) Summary</h5>
                <p>Summary of extension services, community engagement, etc.</p>
                <a href="kra3_HR.php?faculty_id=<?php echo $faculty_id; ?>&request_id=<?php echo $request_id; ?>" class="btn btn-sm btn-primary">View KRA III Details</a>
            </div>

            <!-- KRA 4 Content -->
            <div class="tab-pane fade" id="kra4" role="tabpanel" aria-labelledby="kra4-tab">
                <h5>KRA IV (Professional Development) Summary</h5>
                <p>Summary of trainings, certifications, conferences, etc.</p>
                <a href="kra4_HR.php?faculty_id=<?php echo $faculty_id; ?>&request_id=<?php echo $request_id; ?>" class="btn btn-sm btn-primary">View KRA IV Details</a>
            </div>
        </div>

        <!-- Back to Faculty Management link at bottom as well -->
        <div class="mt-4">
            <a href="faculty_management.php" class="btn btn-sm btn-outline-secondary">&laquo; Back to Faculty Management</a>
        </div>
    </div> <!-- .container -->

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Optional: If needed, you can handle some tab logic here, but Bootstrap's JS handles toggling already.
        // This is just a placeholder if you want to do something special on tab change.
        // document.getElementById('kraTabs').addEventListener('shown.bs.tab', function (event) {
        //     console.log('Active tab changed to:', event.target);
        // });
    </script>
</body>
</html>
