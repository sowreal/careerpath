<?php
include('../session.php'); // Ensure the user is logged in
include('../connection.php'); // Include the database connection

// Define variables for Page Titles and Sidebar Active effects
$pageTitle = 'Career Path | Announcements';
$activePage = 'Announcements';

// Check if the user is a Human Resources
if ($_SESSION['role'] != 'Human Resources') {
    // Check if the user is a Faculty Member
    if ($_SESSION['role'] != 'Permanent Instructor' && $_SESSION['role'] != 'Contract of Service Instructor') {
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
                    <h1 class="h3 mb-0">Announcements</h1>
                    <!-- Button to create a new announcement -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAnnouncementModal">
                        <i class="fas fa-plus"></i> Create Announcement
                    </button>
                </div>

                <!-- Announcements List -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Manage Announcements</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover" id="announcementsTable">
                        <thead>
                            <tr>
                            <th>Title</th>
                            <th>Date Published</th>
                            <th>Priority</th>
                            <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Example Announcement Row -->
                            <tr>
                            <td>Upcoming Faculty Workshop</td>
                            <td>October 30, 2023</td>
                            <td><span class="badge bg-warning">Important</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary edit-announcement-btn" data-bs-toggle="modal" data-bs-target="#editAnnouncementModal" data-announcement-id="1">
                                <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-sm btn-danger delete-announcement-btn" data-announcement-id="1">
                                <i class="fas fa-trash-alt"></i>Delete
                                </button>
                            </td>
                            </tr>
                            <!-- Repeat for each announcement -->
                            <!-- Data should be dynamically populated from the backend -->
                        </tbody>
                        </table>
                    </div>
                </div>

                <!-- Create Announcement Modal -->
                <div class="modal fade" id="createAnnouncementModal" tabindex="-1" aria-labelledby="createAnnouncementModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form class="modal-content" id="createAnnouncementForm">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createAnnouncementModalLabel">Create Announcement</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Announcement Title -->
                            <div class="mb-3">
                            <label for="announcementTitle" class="form-label">Title</label>
                            <input type="text" class="form-control" id="announcementTitle" name="title" required>
                            </div>
                            <!-- Announcement Content -->
                            <div class="mb-3">
                            <label for="announcementContent" class="form-label">Content</label>
                            <textarea class="form-control" id="announcementContent" name="content" rows="5" required></textarea>
                            </div>
                            <!-- Priority Level -->
                            <div class="mb-3">
                            <label for="priorityLevel" class="form-label">Priority Level</label>
                            <select class="form-select" id="priorityLevel" name="priority">
                                <option value="Normal" selected>Normal</option>
                                <option value="Important">Important</option>
                            </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Publish</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                        </form>
                    </div>
                </div>

                <!-- Edit Announcement Modal -->
                <div class="modal fade" id="editAnnouncementModal" tabindex="-1" aria-labelledby="editAnnouncementModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form class="modal-content" id="editAnnouncementForm">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editAnnouncementModalLabel">Edit Announcement</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Announcement Title -->
                            <div class="mb-3">
                            <label for="editAnnouncementTitle" class="form-label">Title</label>
                            <input type="text" class="form-control" id="editAnnouncementTitle" name="title" value="Upcoming Faculty Workshop"required>
                            </div>
                            <!-- Announcement Content -->
                            <div class="mb-3">
                            <label for="editAnnouncementContent" class="form-label">Content</label>
                                <textarea class="form-control" id="editAnnouncementContent" name="content" rows="5" required>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
                                    Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
                                    Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                </textarea>
                            </div>
                            <!-- Priority Level -->
                            <div class="mb-3">
                            <label for="editPriorityLevel" class="form-label">Priority Level</label>
                            <select class="form-select" id="editPriorityLevel" name="priority">
                                <option value="Normal">Normal</option>
                                <option value="Important">Important</option>
                            </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="deleteConfirmationModalLabel"><i class="fas fa-exclamation-triangle"></i> Confirm Deletion</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this announcement?</p>
                            <p class="text-muted"><small>This action cannot be undone.</small></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                        </div>
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


    <!-- Modals and Actions Handle -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Handle Create Announcement Form Submission
        document.getElementById('createAnnouncementForm').addEventListener('submit', function (e) {
        e.preventDefault();
        // Collect form data
        const title = document.getElementById('announcementTitle').value;
        const content = document.getElementById('announcementContent').value;
        const priority = document.getElementById('priorityLevel').value;

        // Send data to backend via AJAX (replace with your actual endpoint)
        $.ajax({
            url: '/api/announcements/create',
            method: 'POST',
            data: {
            title: title,
            content: content,
            priority: priority,
            },
            success: function (response) {
            // Close the modal
            $('#createAnnouncementModal').modal('hide');
            // Refresh the announcements table or append the new announcement
            // For example:
            // location.reload();
            },
            error: function (error) {
            alert('Error creating announcement.');
            },
        });
        });

        // Handle Edit Announcement Button Click
        $('.edit-announcement-btn').on('click', function () {
        const announcementId = $(this).data('announcement-id');
        // Fetch announcement data from backend
        $.ajax({
            url: `/api/announcements/${announcementId}`,
            method: 'GET',
            success: function (data) {
            // Populate the edit form fields
            $('#editAnnouncementTitle').val(data.title);
            $('#editAnnouncementContent').val(data.content);
            $('#editPriorityLevel').val(data.priority);
            // Store the announcement ID for submission
            $('#editAnnouncementForm').data('announcement-id', announcementId);
            },
            error: function (error) {
            alert('Error fetching announcement data.');
            },
        });
        });

        // Handle Edit Announcement Form Submission
        $('#editAnnouncementForm').on('submit', function (e) {
        e.preventDefault();
        const announcementId = $(this).data('announcement-id');
        const title = $('#editAnnouncementTitle').val();
        const content = $('#editAnnouncementContent').val();
        const priority = $('#editPriorityLevel').val();

        // Send updated data to backend
        $.ajax({
            url: `/api/announcements/${announcementId}/update`,
            method: 'POST',
            data: {
            title: title,
            content: content,
            priority: priority,
            },
            success: function (response) {
            // Close the modal
            $('#editAnnouncementModal').modal('hide');
            // Refresh the announcements table
            // location.reload();
            },
            error: function (error) {
            alert('Error updating announcement.');
            },
        });
        });

        // Handle Delete Announcement
        $(document).ready(function () {
            let announcementIdToDelete = null;

            // Handle Delete Announcement Button Click
            $(document).on('click', '.delete-announcement-btn', function () {
                announcementIdToDelete = $(this).data('announcement-id');
                // Show the delete confirmation modal
                $('#deleteConfirmationModal').modal('show');
            });

            // Handle Confirm Delete Button Click
            $('#confirmDeleteBtn').on('click', function () {
                if (announcementIdToDelete) {
                // Send delete request to backend
                $.ajax({
                    url: `/api/announcements/${announcementIdToDelete}/delete`,
                    method: 'POST',
                    success: function (response) {
                    // Remove the announcement row from the table
                    $(`button[data-announcement-id="${announcementIdToDelete}"]`).closest('tr').remove();
                    // Hide the modal
                    $('#deleteConfirmationModal').modal('hide');
                    // Reset the variable
                    announcementIdToDelete = null;
                    },
                    error: function (error) {
                    alert('Error deleting announcement.');
                    // Hide the modal
                    $('#deleteConfirmationModal').modal('hide');
                    // Reset the variable
                    announcementIdToDelete = null;
                    },
                });
                }
            });
            });

    });
    </script>



    </body><!--end::Body-->
</html>
