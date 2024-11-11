<?php
include('../session.php'); // Ensure the user is logged in
include('../connection.php'); // Include the database connection

// Define variables for Page Titles and Sidebar Active effects
$pageTitle = 'Career Path | Documents';
$activePage = 'Documents';

// Check if the user is a Faculty Member
if ($_SESSION['role'] != 'Regular Instructor' && $_SESSION['role'] != 'Contract of Service Instructor') {
    // Check if the user is Human Resources
    if ($_SESSION['role'] != 'Human Resources') {
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
    header('Location: dashboard_HR.php'); // Redirect to HR dashboard if not a faculty member
    exit();
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once('../includes/header.php') ?>
</head>


<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
    <div class="app-wrapper"> 
        <!--begin::Header-->
            <?php require_once('../includes/navbar.php');?>
        <!--end::Header--> 
        
        <!--begin::Sidebar-->
            <?php require_once('../includes/sidebar_faculty.php');?>
        <!--end::Sidebar--> 
        

        <!--begin::App Main-->
        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Document Management</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Document Management</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">

                    <!-- Upload Documents Section -->
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header bg-success bg-gradient text-white">
                                    <h5>Upload Document</h5>
                                </div>
                                <div class="card-body">
                                    <form id="uploadForm">
                                        <div class="mb-3">
                                            <label for="document" class="form-label"><strong>Choose Document</strong></label>
                                            <input type="file" class="form-control" id="document" name="document" required>
                                        </div>
                                        <button type="submit" class="btn btn-success">Upload</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- View Uploaded Documents Section -->
                    <!-- View Uploaded Documents Section -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header bg-success bg-gradient text-white">
                                    <h5>Uploaded Documents</h5>
                                </div>
                                <div class="card-body">

                                    <!-- Filter Section -->
                                    <div class="mb-3">
                                        <label for="filterStatus" class="form-label"><strong>Filter by Status</strong></label>
                                        <select id="filterStatus" class="form-select">
                                            <option value="all">All</option>
                                            <option value="approved">Approved</option>
                                            <option value="pending">Pending</option>
                                            <option value="rejected">Rejected</option>
                                        </select>
                                    </div>

                                    <!-- Table of Uploaded Documents -->
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Document ID</th>
                                                <th>Title</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="documentTable">
                                            <!-- Mock Data for Uploaded Documents -->
                                            <tr data-status="approved">
                                                <td>DOC001</td>
                                                <td>Research Paper on AI</td>
                                                <td><span class="badge bg-success">Approved</span></td>
                                                <td>Oct 10, 2024</td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm">View</button>
                                                    <button class="btn btn-secondary btn-sm">Download</button>
                                                    <button class="btn btn-danger btn-sm">Delete</button>
                                                </td>
                                            </tr>
                                            <tr data-status="pending">
                                                <td>DOC002</td>
                                                <td>Teaching Certificate</td>
                                                <td><span class="badge bg-warning">Pending</span></td>
                                                <td>Oct 12, 2024</td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm">View</button>
                                                    <button class="btn btn-secondary btn-sm">Download</button>
                                                    <button class="btn btn-danger btn-sm">Delete</button>
                                                </td>
                                            </tr>
                                            <tr data-status="rejected">
                                                <td>DOC003</td>
                                                <td>Research Paper on Climate Change</td>
                                                <td><span class="badge bg-danger">Rejected</span></td>
                                                <td>Oct 14, 2024</td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm">View</button>
                                                    <button class="btn btn-secondary btn-sm">Download</button>
                                                    <button class="btn btn-danger btn-sm">Delete</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <!-- Pagination Section (Mock) -->
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination">
                                            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Mock Upload Notification Modal -->
                    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-success-subtle">
                                    <h5 class="modal-title" id="uploadModalLabel">Document Upload Successful</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Your document has been uploaded successfully. It will be reviewed by the administration shortly.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Viewing Document Details -->
                    <div class="modal fade" id="viewDocumentModal" tabindex="-1" aria-labelledby="viewDocumentModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-success-subtle">
                                    <h5 class="modal-title" id="viewDocumentModalLabel">Document Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Dynamic content will be inserted here via JS -->
                                    <p><strong>Document ID:</strong> <span id="modalDocumentId"></span></p>
                                    <p><strong>Title:</strong> <span id="modalDocumentTitle"></span></p>
                                    <p><strong>Status:</strong> <span id="modalDocumentStatus"></span></p>
                                    <p><strong>Date:</strong> <span id="modalDocumentDate"></span></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Download Confirmation -->
                    <div class="modal fade" id="downloadModal" tabindex="-1" aria-labelledby="downloadModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-success-subtle">
                                    <h5 class="modal-title" id="downloadModalLabel">Confirm Download</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to download <strong><span id="downloadDocumentTitle"></span></strong>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary" id="confirmDownloadButton">Download</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Delete Confirmation -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-success-subtle">
                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete <strong><span id="deleteDocumentTitle"></span></strong>? This action cannot be undone.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </main>

        <!--end::App Main-->
        
        
        
        
        <!--begin::Footer-->   
            <?php require_once('../includes/footer.php');?>
        <!--end::Footer-->
    </div> 
    <!--end::App Wrapper--> 
    
        
    <!--begin::Script--> 
    <!--begin::Third Party Plugin(OverlayScrollbars)-->       
    <?php require_once('../includes/dashboard_default_scripts.php');?>

    <script>
        // Listen for the form submission
        document.getElementById('uploadForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent actual form submission

            // Trigger the modal
            var uploadModal = new bootstrap.Modal(document.getElementById('uploadModal'));
            uploadModal.show();

            // Optionally reset the form after showing the modal
            document.getElementById('uploadForm').reset();
        });
    </script>

    <script>
        // Filter by document status
        document.getElementById('filterStatus').addEventListener('change', function() {
            var filterValue = this.value;
            var rows = document.querySelectorAll('#documentTable tr');

            rows.forEach(function(row) {
                if (filterValue === 'all') {
                    row.style.display = '';
                } else {
                    if (row.getAttribute('data-status') === filterValue) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });
    </script>

    <!-- ACTION MODALS -->
    <script>
        // Mock "View" button functionality
        document.querySelectorAll('.btn-primary').forEach(function(button) {
            button.addEventListener('click', function() {
                var row = this.closest('tr');
                var docId = row.children[0].innerText;
                var docTitle = row.children[1].innerText;
                var docStatus = row.children[2].innerText;
                var docDate = row.children[3].innerText;

                document.getElementById('modalDocumentId').innerText = docId;
                document.getElementById('modalDocumentTitle').innerText = docTitle;
                document.getElementById('modalDocumentStatus').innerText = docStatus;
                document.getElementById('modalDocumentDate').innerText = docDate;

                var viewModal = new bootstrap.Modal(document.getElementById('viewDocumentModal'));
                viewModal.show();
            });
        });

        // Mock "Download" button functionality
        document.querySelectorAll('.btn-secondary').forEach(function(button) {
            button.addEventListener('click', function() {
                var row = this.closest('tr');
                var docTitle = row.children[1].innerText;

                document.getElementById('downloadDocumentTitle').innerText = docTitle;

                var downloadModal = new bootstrap.Modal(document.getElementById('downloadModal'));
                downloadModal.show();

                document.getElementById('confirmDownloadButton').addEventListener('click', function() {
                    // Simulate download confirmation (mock functionality)
                    alert('Downloading: ' + docTitle);
                    downloadModal.hide();
                });
            });
        });

        // Mock "Delete" button functionality
        document.querySelectorAll('.btn-danger').forEach(function(button) {
            button.addEventListener('click', function() {
                var row = this.closest('tr');
                var docTitle = row.children[1].innerText;

                document.getElementById('deleteDocumentTitle').innerText = docTitle;

                var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                deleteModal.show();

                document.getElementById('confirmDeleteButton').addEventListener('click', function() {
                    // Simulate deletion (mock functionality)
                    row.remove();
                    deleteModal.hide();
                });
            });
        });
    </script>

</body>
</html>


