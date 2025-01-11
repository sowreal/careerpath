<?php
include('../session.php'); // Ensure the user is logged in
include('../connection.php'); // Include the database connection
require_once '../config.php';

// Define variables for Page Titles and Sidebar Active effects
$pageTitle = 'Career Path | Documents';
$activePage = 'Documents';

// Check if the user is a Faculty Member
if ($_SESSION['role'] != 'Permanent Instructor' && $_SESSION['role'] != 'Contract of Service Instructor') { 
    // Check if the user is Human Resources
    if ($_SESSION['role'] == 'Human Resources') { 
        // Redirect to HR dashboard
        header('Location: ' . BASE_URL . '/php/dashboard_HR/dashboard_HR.php'); 
        exit(); 
    } else { 
            // **Start of Session Destruction** 
            // Unset all session variables 
            $_SESSION = array(); 

            // Kill the session, also delete the session cookie. 
            if (ini_get("session.use_cookies")) { 
                $params = session_get_cookie_params(); 
                setcookie(session_name(), '', time() - 42000, 
                $params["path"], $params["domain"], 
                $params["secure"], $params["httponly"] 
            ); 
        } 
        
        // Finally, destroy the session. 
        session_destroy(); 
        // Notify the user and redirect to the login page 
        echo "<script> 
        alert('Your account is not authorized. Redirecting to login page.'); 
        window.location.href = '" . BASE_URL . "/php/login.php';
        </script>"; 
        exit(); 
    } 
} else { 
    // Faculty member's sidebar is set, proceed with their dashboard logic 
    $sidebarFile = BASE_URL . 'php/includes/sidebar_faculty.php'; 
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

                    <!-- View Uploaded Documents Section -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-success">
                                <div class="card-header bg-success">
                                    <h3 class="card-title">Uploaded Documents</h3>
                                </div>
                                <div class="card-body">
                                   <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="filter-type">Filter by Type:</label>
                                                    <select class="form-control" id="filter-type">
                                                    <option value="all" selected>All</option>
                                                    <option value="KRA 1 - Teaching">KRA 1 - Teaching</option>
                                                    <option value="KRA 2 - Research">KRA 2 - Research</option>
                                                    <option value="KRA 3 - Extension">KRA 3 - Extension</option>
                                                    <option value="KRA 4 - Professional Dev">KRA 4 - Professional Development</option>
                                                    <option value="other">Other Documents</option>
                                                    </select>
                                            </div>
                                        </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="filter-status">Filter by Status:</label>
                                                    <select class="form-control" id="filter-status">
                                                    <option value="all" selected>All</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="approved">Approved</option>
                                                    <option value="rejected">Rejected</option>
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Document ID</th>
                                                    <th>Title</th>
                                                    <th>Type</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="documents-table-body">
                                                <!-- Document Rows to be dynamically loaded here -->
                                            </tbody>
                                        </table>
                                     </div>

                                    <ul class="pagination">
                                        <li class="page-item" id="previous-page"><a class="page-link" href="#">Previous</a></li>
                                        <li class="page-item" id="current-page"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item" id="next-page"><a class="page-link" href="#">Next</a></li>
                                    </ul>

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
                                    <p><strong>Type:</strong> <span id="modalDocumentType"></span></p>
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
         $(document).ready(function() {
            const documentTableBody = $('#documents-table-body');
            const filterType = $('#filter-type');
            const filterStatus = $('#filter-status');
            const previousPage = $('#previous-page');
            const nextPage = $('#next-page');
            const currentPage = $('#current-page');
            const itemsPerPage = 5;
            let documents = [];
            let currentPageNumber = 1;

            function fetchDocuments() {
                $.ajax({
                    url: 'get_documents.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                    documents = data;
                    updateTable();
                    },
                    error: function(xhr, status, error) {
                    console.error("Failed to fetch documents:", error);
                    }
                });
            }

            function updateTable(){
                const filteredDocuments = filterDocuments();
                 const totalPages = Math.ceil(filteredDocuments.length / itemsPerPage);
                 currentPageNumber = Math.min(currentPageNumber, totalPages); // Adjust the page if necessary.

                 const startIndex = (currentPageNumber - 1) * itemsPerPage;
                 const endIndex = Math.min(startIndex + itemsPerPage, filteredDocuments.length);
                 const paginatedDocuments = filteredDocuments.slice(startIndex, endIndex);

                documentTableBody.empty();
                if(paginatedDocuments.length > 0) {
                paginatedDocuments.forEach(doc => {
                    let statusClass = '';
                    switch(doc.status){
                        case 'approved':
                            statusClass = 'badge badge-success';
                            break;
                        case 'pending':
                            statusClass = 'badge badge-warning';
                            break;
                        case 'rejected':
                            statusClass = 'badge badge-danger';
                            break;
                        default:
                          statusClass = 'badge badge-secondary'
                    }
                    documentTableBody.append(`
                    <tr>
                      <td>${doc.id}</td>
                      <td>${doc.filename}</td>
                      <td>${doc.type}</td>
                      <td><span class="${statusClass}">${doc.status}</span></td>
                      <td>${doc.date}</td>
                      <td>
                        <button class="btn btn-sm btn-info view-button" data-id="${doc.id}">View</button>
                        <button class="btn btn-sm btn-secondary download-button" data-id="${doc.id}">Download</button>
                        <button class="btn btn-sm btn-danger delete-button" data-id="${doc.id}">Delete</button>
                      </td>
                    </tr>
                `);
                });

                   currentPage.text(currentPageNumber);
                   previousPage.toggleClass('disabled', currentPageNumber === 1);
                   nextPage.toggleClass('disabled', currentPageNumber === totalPages || totalPages === 0);
                }else {
                    documentTableBody.append('<tr><td colspan="6" class="text-center">No documents found.</td></tr>');
                    currentPage.text("1");
                    previousPage.addClass('disabled');
                     nextPage.addClass('disabled');

                }
            }

            function filterDocuments() {
                const typeFilter = filterType.val();
                const statusFilter = filterStatus.val();

                return documents.filter(doc => {
                     const typeMatch = typeFilter === 'all' || doc.type === typeFilter;
                     const statusMatch = statusFilter === 'all' || doc.status === statusFilter;
                     return typeMatch && statusMatch;
                });
            }

            filterType.on('change', function(){
               currentPageNumber = 1;
               updateTable();
            });

            filterStatus.on('change', function(){
                currentPageNumber = 1;
               updateTable();
            });

            previousPage.on('click', function(e) {
                e.preventDefault();
                if (currentPageNumber > 1) {
                    currentPageNumber--;
                    updateTable();
                }
            });

            nextPage.on('click', function(e) {
               e.preventDefault();
               const totalPages = Math.ceil(filterDocuments().length / itemsPerPage);
                if (currentPageNumber < totalPages) {
                    currentPageNumber++;
                    updateTable();
                 }
            });


          documentTableBody.on('click', '.view-button', function() {
                const docId = $(this).data('id');
                $.ajax({
                   url: 'view_document.php',
                    type: 'GET',
                   dataType: 'json',
                     data: { id: docId },
                   success: function(doc){
                    document.getElementById('modalDocumentId').innerText = doc.id;
                    document.getElementById('modalDocumentTitle').innerText = doc.filename;
                    document.getElementById('modalDocumentType').innerText = doc.type;
                     document.getElementById('modalDocumentStatus').innerText = doc.status;
                    document.getElementById('modalDocumentDate').innerText = doc.date;

                       var viewModal = new bootstrap.Modal(document.getElementById('viewDocumentModal'));
                      viewModal.show();
                    },
                   error: function(xhr, status, error) {
                     console.error("Failed to fetch document:", error);
                    }
                   });
            });

            documentTableBody.on('click', '.download-button', function(){
                const docId = $(this).data('id');
                   $.ajax({
                     url: 'download_document.php',
                    type: 'GET',
                    dataType: 'json',
                     data: { id: docId },
                   success: function(doc){
                        document.getElementById('downloadDocumentTitle').innerText = doc.filename;
                        var downloadModal = new bootstrap.Modal(document.getElementById('downloadModal'));
                         downloadModal.show();

                        document.getElementById('confirmDownloadButton').addEventListener('click', function() {
                            window.location.href = `download_document_file.php?id=${docId}`;
                           downloadModal.hide();
                        });
                   },
                   error: function(xhr, status, error) {
                     console.error("Failed to fetch document:", error);
                    }
                   });
            });

            documentTableBody.on('click', '.delete-button', function(){
                 const docId = $(this).data('id');
                  $.ajax({
                     url: 'delete_document.php',
                    type: 'GET',
                   dataType: 'json',
                     data: { id: docId },
                   success: function(doc){
                       document.getElementById('deleteDocumentTitle').innerText = doc.filename;
                      var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                    deleteModal.show();
                      document.getElementById('confirmDeleteButton').addEventListener('click', function() {
                            $.ajax({
                                url: 'delete_document_file.php',
                                type: 'POST',
                                dataType: 'json',
                                data: { id: docId },
                                success: function(response) {
                                      if(response.success) {
                                            fetchDocuments();
                                      } else {
                                          alert('Failed to delete document');
                                      }
                                     deleteModal.hide();
                                },
                                  error: function(xhr, status, error) {
                                    console.error("Failed to delete document:", error);
                                   }
                            });
                        });
                   },
                   error: function(xhr, status, error) {
                     console.error("Failed to fetch document:", error);
                    }
                });

            });

           fetchDocuments();

        });
     </script>
</body>
</html>