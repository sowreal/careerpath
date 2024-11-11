<?php
include('../session.php'); // Ensure the user is logged in
include('../connection.php'); // Include the database connection

// Define variables for Page Titles and Sidebar Active effects
$pageTitle = 'Career Path | Documents';
$activePage = 'Document Management';

// Check if the user is a Human Resources
if ($_SESSION['role'] != 'Human Resources') {
    // Check if the user is a Faculty Member
    if ($_SESSION['role'] != 'Regular Instructor' && $_SESSION['role'] != 'Contract of Service Instructor') {
        // **Start of Session Destruction**
        // Unset all session variables
        $_SESSION = array();

        // Kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        // Finally, destroy the session.
        session_destroy();
        // **End of Session Destruction**

        // Notify the user and redirect to the login page
        echo "<script>
                alert('Your account is not authorized. Redirecting to login page.');
                window.location.href = '../login.php';
              </script>";
        exit();
    }
    // If the user is part of Human Resources, redirect to their dashboard
    header('Location: dashboard_faculty.php'); // Redirect to HR dashboard if not a faculty member
    exit();
}

?>

<!DOCTYPE html>
<html lang="en"> <!--begin::Head-->

<head>
<?php require_once('../includes/header.php') ?>
</head>


<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
    <div class="app-wrapper"> 
        <!--begin::Header-->
        <?php require_once('../includes/navbar.php');?>
        <!--end::Header--> 
        

        <!--begin::Sidebar-->
        <?php require_once('../includes/sidebar_HR.php');?>
        <!--end::Sidebar--> 
        
        <!--begin::App Main-->
        <!-- Main Content -->
        <main class="app-main">
            <div class="container-fluid">
                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center my-4">
                    <h1 class="h3 mb-0 text-gray-800">Document Management</h1>
                    <!-- Notifications for New Submissions -->
                    <div>
                        <span class="badge bg-primary" id="newSubmissionsBadge">New Submissions: 5</span>
                        <!-- The number 5 is a placeholder; replace with dynamic data -->
                    </div>
                </div>

                <!-- Search and Filter Section -->
                <div class="card mb-4">
                <div class="card-body">
                    <form class="row g-3" id="searchForm">
                    <!-- Search Bar -->
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="searchInput" placeholder="Search by faculty name or document title">
                    </div>
                    <!-- Document Type Filter (optional) -->
                    <div class="col-md-3">
                        <select class="form-select" id="documentTypeFilter">
                        <option value="">All Document Types</option>
                        <!-- Options populated dynamically or statically -->
                        <option value="Research Paper">Research Paper</option>
                        <option value="Certification">Certification</option>
                        <!-- Add more document types as needed -->
                        </select>
                    </div>
                    <!-- Search Button -->
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary w-100">Search</button>
                    </div>
                    </form>
                </div>
                </div>

                <!-- Document List Table -->
                <div class="card">
                <div class="card-body">
                    <table class="table table-hover" id="documentTable">
                    <thead>
                        <tr>
                        <th>Submission Date</th>
                        <th>Faculty Name</th>
                        <th>Document Title</th>
                        <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example Row -->
                        <tr>
                        <td>Oct 25, 2023</td>
                        <td>Dr. Jane Smith</td>
                        <td>Advanced Research Paper</td>
                        <td>
                            <button class="btn btn-sm btn-primary view-document-btn" data-bs-toggle="modal" data-bs-target="#documentModal" data-document-id="1">View Document</button>
                            <button class="btn btn-sm btn-success approve-btn" data-document-id="1">Approve</button>
                            <button class="btn btn-sm btn-danger reject-btn" data-document-id="1">Reject</button>
                        </td>
                        </tr>
                        <!-- Repeat for each document submission -->
                        <!-- Data can be dynamically populated using a templating engine or JavaScript -->
                    </tbody>
                    </table>
                    <!-- Pagination (if needed) -->
                    <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <!-- Pagination items generated dynamically -->
                        <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">&laquo;</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <!-- Add more page items as needed -->
                        <li class="page-item">
                        <a class="page-link" href="#">&raquo;</a>
                        </li>
                    </ul>
                    </nav>
                </div>
                </div>
            </div>

            <!-- Document Modal -->
            <div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="documentModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title">Document Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <!-- Document Metadata -->
                    <h5>Document Information</h5>
                    <div class="row mb-3">
                        <div class="col-md-6">
                        <p><strong>Faculty Name:</strong> <span id="facultyName">Dr. Jane Smith</span></p>
                        <p><strong>Submission Date:</strong> <span id="submissionDate">Oct 25, 2023</span></p>
                        </div>
                        <div class="col-md-6">
                        <p><strong>Document Title:</strong> <span id="documentTitle">Advanced Research Paper</span></p>
                        <p><strong>Document Type:</strong> <span id="documentType">Research Paper</span></p>
                        </div>
                    </div>

                    <!-- Document Download Link -->
                    <div class="mb-3">
                        <a href="#" class="btn btn-outline-primary" id="downloadDocumentBtn">Download Document</a>
                        <!-- Replace href with the actual document URL -->
                    </div>

                    <!-- Approve/Reject Buttons -->
                    <div class="d-flex gap-2 justify-content-end">
                        <button class="btn btn-success" id="approveModalBtn">Approve</button>
                        <button class="btn btn-danger" id="rejectModalBtn">Reject</button>
                    </div>
                    </div>
                </div>
                </div>
            </div>

            <!-- Reject Reason Modal -->
            <div class="modal fade" id="rejectReasonModal" tabindex="-1" aria-labelledby="rejectReasonModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title">Reject Document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form id="rejectForm">
                        <div class="mb-3">
                        <label for="rejectReason" class="form-label">Reason for Rejection</label>
                        <textarea class="form-control" id="rejectReason" rows="4" required></textarea>
                        </div>
                        <div class="d-flex gap-2 justify-content-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Submit Rejection</button>
                        </div>
                    </form>
                    </div>
                </div>
                </div>
            </div>
        </main>

        <!--end::App Main--> 
        
        <!--begin::Footer-->
        <?php require_once('../includes/footer.php'); ?>
        <!--end::Footer-->
    </div> 
    <!--end::App Wrapper--> 
    
    
    <!--begin::Script--> 
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <?php require_once('../includes/dashboard_default_scripts.php');?>

    <!-- View Document Handle -->
     <script>
        document.querySelectorAll('.view-document-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                const documentId = this.getAttribute('data-document-id');
                // Fetch document data from backend (using AJAX)
                fetch(`/api/documents/${documentId}`)
                .then(response => response.json())
                .then(data => {
                    // Populate modal fields
                    document.getElementById('facultyName').textContent = data.facultyName;
                    document.getElementById('submissionDate').textContent = data.submissionDate;
                    document.getElementById('documentTitle').textContent = data.documentTitle;
                    document.getElementById('documentType').textContent = data.documentType;
                    document.getElementById('downloadDocumentBtn').href = data.documentUrl;
                    // Store document ID for approval/rejection actions
                    document.getElementById('approveModalBtn').setAttribute('data-document-id', documentId);
                    document.getElementById('rejectModalBtn').setAttribute('data-document-id', documentId);
                });
            });
        });

     </script>

    <!-- Approve Actions Handle -->
    <script>
        // Approve from the table
        document.querySelectorAll('.approve-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                const documentId = this.getAttribute('data-document-id');
                // Call backend API to approve the document
                // Update UI accordingly
                alert('Document approved.');
            });
            });

            // Approve from the modal
            document.getElementById('approveModalBtn').addEventListener('click', function() {
            const documentId = this.getAttribute('data-document-id');
            // Call backend API to approve the document
            // Update UI accordingly
            alert('Document approved.');
            // Close the modal
            $('#documentModal').modal('hide');
        });
    </script>

    <!-- Reject Actions Handle -->
    <script>
        // Open Reject Reason Modal from the table
        document.querySelectorAll('.reject-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                const documentId = this.getAttribute('data-document-id');
                document.getElementById('rejectForm').setAttribute('data-document-id', documentId);
                // Open the reject reason modal
                var rejectModal = new bootstrap.Modal(document.getElementById('rejectReasonModal'));
                rejectModal.show();
            });
            });

            // Open Reject Reason Modal from the modal
            document.getElementById('rejectModalBtn').addEventListener('click', function() {
            const documentId = this.getAttribute('data-document-id');
            document.getElementById('rejectForm').setAttribute('data-document-id', documentId);
            // Close the document modal
            $('#documentModal').modal('hide');
            // Open the reject reason modal
            var rejectModal = new bootstrap.Modal(document.getElementById('rejectReasonModal'));
            rejectModal.show();
            });

            // Submit the rejection
            document.getElementById('rejectForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const documentId = this.getAttribute('data-document-id');
            const reason = document.getElementById('rejectReason').value;
            // Call backend API to reject the document with the reason
            // Update UI accordingly
            alert('Document rejected.');
            // Close the reject reason modal
            $('#rejectReasonModal').modal('hide');
        });
    </script>

    <!-- Search and FIlter Handle -->
    <script>
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const query = document.getElementById('searchInput').value;
            const documentType = document.getElementById('documentTypeFilter').value;
            // Implement search functionality via AJAX
            // Fetch filtered document list from backend and update the table
        });
    </script>

    </body><!--end::Body-->
</html>
