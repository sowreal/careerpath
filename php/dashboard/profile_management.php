<?php
include('../session.php'); // Ensure the user is logged in
include('../connection.php'); // Include the database connection
require_once '../config.php';

// Define variables for Page Titles and Sidebar Active effects
$pageTitle = 'Career Path | Profile';
$activePage = 'Profile';

// Check if the user is a Faculty Member
$sidebarFile = '../includes/sidebar_faculty.php';
if ($_SESSION['role'] != 'Regular Instructor' && $_SESSION['role'] != 'Contract of Service Instructor') {
    // Check if the user is Human Resources
    if ($_SESSION['role'] == 'Human Resources') {
        $sidebarFile = '../includes/sidebar_HR.php';
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
}

// Display messages based on URL parameters
$showUploadSuccess = false;
$showDeleteSuccess = false;
$showDeleteError = false;
$showUpdateSuccess = false;
$showRequestSuccess = false;
$showRequestNone = false;

if (isset($_GET['upload']) && $_GET['upload'] == 'success') {
    $showUploadSuccess = true;
}

if (isset($_GET['delete']) && $_GET['delete'] == 'success') {
    $showDeleteSuccess = true;
}

if (isset($_GET['delete']) && $_GET['delete'] == 'error') {
    $showDeleteError = true;
}
if (isset($_GET['update']) && $_GET['update'] == 'success') {
    $showUpdateSuccess = true;
}

if (isset($_GET['request'])) {
    if ($_GET['request'] == 'success') {
        $showRequestSuccess = true;
    } elseif ($_GET['request'] == 'none') {
        $showRequestNone = true;
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once('../includes/header.php') ?>

    <!-- Cropper.js CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">


</head>


<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
    <div class="app-wrapper"> 
        <!--begin::Header-->
        <?php require_once('../includes/navbar.php');?>
        <!--end::Header--> 
        
        <!--begin::Sidebar-->
        <?php require_once($sidebarFile);?>
        <!--end::Sidebar--> 
        

        <!--begin::App Main-->
        <main class="app-main"> 
            <!--begin::App Content Header-->
            <div class="app-content-header"> 
                <!--begin::Container-->
                <div class="container-fluid"> 
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Profile Management</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Profile Management
                                </li>
                            </ol>
                        </div>
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div> 
            <!--end::App Content Header--> 
            
            <!--begin::App Content-->
            <!-- Profile Management Page -->
            <div class="app-content">
                <!--begin::Container-->
                <div class="container-fluid">
                    
                    <!-- Profile Form Section -->
                    <div class="row" style="padding: 2rem 0px;">
                        <div class="col-md-8">
                            <!-- User Info Form -->
                            <div class="card d-flex flex-column h-100">
                                <div class="card-header bg-success text-white">
                                    <h5>Personal Information</h5>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <div class="row">
                                        <!-- Editable Information Form -->
                                        <div class="col-md-6 d-flex flex-column">
                                            <form id="editableFieldsForm" action="../profile/update_profile.php" method="POST" class="d-flex flex-column h-100">
                                                <!-- First Name -->
                                                <div class="mb-3">
                                                    <label for="first_name" class="form-label"><strong>First Name</strong></label>
                                                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $_SESSION['first_name'];?>">
                                                </div>

                                                <!-- Middle Name -->
                                                <div class="mb-3">
                                                    <label for="middle_name" class="form-label"><strong>Middle Name(Optional)</strong></label>
                                                    <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?php echo $_SESSION['middle_name'];?>">
                                                </div>

                                                <!-- Last Name -->
                                                <div class="mb-3">
                                                    <label for="last_name" class="form-label"><strong>Last Name</strong></label>
                                                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $_SESSION['last_name'];?>">
                                                </div>

                                                <!-- Phone/Telephone Number -->
                                                <div class="mb-3">
                                                    <label for="phone_number" class="form-label"><strong>Phone Number</strong></label>
                                                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo $_SESSION['phone_number'];?>">
                                                </div>

                                                <!-- Altenative Email -->
                                                <div class="mb-3">
                                                    <label for="alt_email" class="form-label"><strong>Alternate Email(Optional)</strong></label>
                                                    <input type="text" class="form-control" id="alt_email" name="alt_email" value="<?php echo $_SESSION['alt_email'];?>">
                                                </div>

                                                <!-- Department -->
                                                <!-- <div class="mb-3">
                                                    <label for="department" class="form-label"><strong>Department</strong></label>
                                                    <input type="text" class="form-control" id="department" name="department" value="<?php echo $_SESSION['department'];?>">
                                                </div> -->

                                                <!-- Buttons Section for Editable Info -->
                                                <div class="mt-auto d-flex gap-2 justify-content-md-end">
                                                    <!-- <button type="button" class="btn btn-warning flex-grow-1">Edit</button> -->
                                                    <button type="button" class="btn btn-success mt-3" id="updateProfileButton">Update Profile</button>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- HR Confirmed Information Form -->
                                        <div class="col-md-6 d-flex flex-column">
                                            <form id="hrProtectedFieldsForm" action="../profile/submit_hr_changes.php" method="POST" class="d-flex flex-column h-100">
                                                <!-- Email -->
                                                <div class="mb-3">
                                                    <label for="email" class="form-label"><strong>Email:</strong></label>
                                                    <p id="email-display"><?php echo $_SESSION['email']?></p> <!-- Visible text -->
                                                    <input type="text" class="form-control d-none" id="email" name="email" value="<?php echo $_SESSION['email']?>" required> <!-- Hidden input -->
                                                </div>

                                                <!-- Employee ID -->
                                                <div class="mb-3">
                                                    <label for="employee_id" class="form-label"><strong>Employee ID:</strong></label>
                                                    <p id="employee_id_display"><?php echo $_SESSION['employee_id'] ?></p>
                                                    <input type="text" 
                                                        class="form-control d-none" 
                                                        id="employee_id" 
                                                        name="employee_id" 
                                                        value="<?php echo $_SESSION['employee_id'] ?>" 
                                                        pattern="\d{3}-\d{3}" 
                                                        title="Employee ID must be in the format 123-456" 
                                                        required>
                                                </div>

                                                <!-- Faculty Rank -->
                                                <div class="mb-3">
                                                    <label for="faculty_rank" class="form-label"><strong>Faculty Rank:</strong></label>
                                                    
                                                    <!-- Display Mode with Placeholder for Empty Value -->
                                                    <p id="faculty_rank_display">
                                                        <?php 
                                                        if (!empty($_SESSION['faculty_rank'])) {
                                                            echo $_SESSION['faculty_rank']; 
                                                        } else {
                                                            echo "<em>Not yet assigned</em>"; // Placeholder text for empty rank
                                                        }
                                                        ?>
                                                    </p>

                                                    <!-- Dropdown for Editing Mode -->
                                                    <select class="form-control d-none" id="faculty_rank" name="faculty_rank" required>
                                                        <option value="Instructor I" <?php if($_SESSION['faculty_rank'] == 'Instructor I') echo 'selected'; ?>>Instructor I</option>
                                                        <option value="Instructor II" <?php if($_SESSION['faculty_rank'] == 'Instructor II') echo 'selected'; ?>>Instructor II</option>
                                                        <option value="Instructor III" <?php if($_SESSION['faculty_rank'] == 'Instructor III') echo 'selected'; ?>>Instructor III</option>
                                                        <option value="Assistant Professor I" <?php if($_SESSION['faculty_rank'] == 'Assistant Professor I') echo 'selected'; ?>>Assistant Professor I</option>
                                                        <option value="Assistant Professor II" <?php if($_SESSION['faculty_rank'] == 'Assistant Professor II') echo 'selected'; ?>>Assistant Professor II</option>
                                                        <option value="Assistant Professor III" <?php if($_SESSION['faculty_rank'] == 'Assistant Professor III') echo 'selected'; ?>>Assistant Professor III</option>
                                                        <option value="Assistant Professor IV" <?php if($_SESSION['faculty_rank'] == 'Assistant Professor IV') echo 'selected'; ?>>Assistant Professor IV</option>
                                                        <option value="Associate Professor I" <?php if($_SESSION['faculty_rank'] == 'Associate Professor I') echo 'selected'; ?>>Associate Professor I</option>
                                                        <option value="Associate Professor II" <?php if($_SESSION['faculty_rank'] == 'Associate Professor II') echo 'selected'; ?>>Associate Professor II</option>
                                                        <option value="Associate Professor III" <?php if($_SESSION['faculty_rank'] == 'Associate Professor III') echo 'selected'; ?>>Associate Professor III</option>
                                                        <option value="Associate Professor IV" <?php if($_SESSION['faculty_rank'] == 'Associate Professor IV') echo 'selected'; ?>>Associate Professor IV</option>
                                                        <option value="Associate Professor V" <?php if($_SESSION['faculty_rank'] == 'Associate Professor V') echo 'selected'; ?>>Associate Professor V</option>
                                                        <option value="Professor I" <?php if($_SESSION['faculty_rank'] == 'Professor I') echo 'selected'; ?>>Professor I</option>
                                                        <option value="Professor II" <?php if($_SESSION['faculty_rank'] == 'Professor II') echo 'selected'; ?>>Professor II</option>
                                                        <option value="Professor III" <?php if($_SESSION['faculty_rank'] == 'Professor III') echo 'selected'; ?>>Professor III</option>
                                                        <option value="Professor IV" <?php if($_SESSION['faculty_rank'] == 'Professor IV') echo 'selected'; ?>>Professor IV</option>
                                                        <option value="Professor V" <?php if($_SESSION['faculty_rank'] == 'Professor V') echo 'selected'; ?>>Professor V</option>
                                                        <option value="Professor VI" <?php if($_SESSION['faculty_rank'] == 'Professor VI') echo 'selected'; ?>>Professor VI</option>
                                                        <option value="College Professor" <?php if($_SESSION['faculty_rank'] == 'College Professor') echo 'selected'; ?>>College Professor</option>
                                                        <option value="University Professor" <?php if($_SESSION['faculty_rank'] == 'University Professor') echo 'selected'; ?>>University Professor</option>
                                                    </select>
                                                </div>


                                                <!-- Role -->
                                                <div class="mb-3">
                                                    <label for="role" class="form-label"><strong>Role:</strong></label>
                                                    <p id="role_display"><?php echo $_SESSION['role'] ?></p>
                                                    <select class="form-control d-none" id="role" name="role" required>
                                                        <option value="">Select your role</option>
                                                        <option value="Regular Instructor" <?php if($_SESSION['role'] == 'Regular Instructor') echo 'selected'; ?>>Regular Instructor</option>
                                                        <option value="Contract of Service Instructor" <?php if($_SESSION['role'] == 'Contract of Service Instructor') echo 'selected'; ?>>Contract of Service Instructor</option>
                                                        <option value="Human Resources Personnel" <?php if($_SESSION['role'] == 'Human Resources Personnel') echo 'selected'; ?>>Human Resources Personnel</option>
                                                    </select>
                                                </div>


                                                <!-- Department -->
                                                <div class="mb-3">
                                                    <label for="department" class="form-label"><strong>Department:</strong></label>
                                                    <p id="department_display"><?php echo $_SESSION['department'] ?></p>
                                                    <select class="form-control d-none" id="department" name="department" required>
                                                        <option value="">Select your department</option>
                                                        <option value="College of Agriculture" <?php if($_SESSION['department'] == 'College of Agriculture') echo 'selected'; ?>>College of Agriculture</option>
                                                        <option value="College of Allied Medicine" <?php if($_SESSION['department'] == 'College of Allied Medicine') echo 'selected'; ?>>College of Allied Medicine</option>
                                                        <option value="College of Arts and Sciences" <?php if($_SESSION['department'] == 'College of Arts and Sciences') echo 'selected'; ?>>College of Arts and Sciences</option>
                                                        <option value="College of Engineering" <?php if($_SESSION['department'] == 'College of Engineering') echo 'selected'; ?>>College of Engineering</option>
                                                        <option value="College of Industrial Technology" <?php if($_SESSION['department'] == 'College of Industrial Technology') echo 'selected'; ?>>College of Industrial Technology</option>
                                                        <option value="College of Teacher Education" <?php if($_SESSION['department'] == 'College of Teacher Education') echo 'selected'; ?>>College of Teacher Education</option>
                                                        <option value="College of Administration, Business, Hospitality, and Accountancy" <?php if($_SESSION['department'] == 'College of Administration, Business, Hospitality, and Accountancy') echo 'selected'; ?>>College of Administration, Business, Hospitality, and Accountancy</option>
                                                        <option value="Human Resources Management Office" <?php if($_SESSION['department'] == 'Human Resources Management Office') echo 'selected'; ?>>Human Resources Management Office</option>
                                                    </select>
                                                </div>


                                                <!-- Member Since Section (static, non-editable) -->
                                                <div class="mb-3">
                                                    <label for="created_at" class="form-label"><strong>Member Since</strong></label>
                                                    <p id="created_at"><?php echo $membercreation; ?></p>
                                                    <input type="text" class="form-control d-none" id="department" name="created_at" value="<?php echo $membercreation; ?>" disabled>
                                                </div>


                                                <!-- Buttons Section for HR Info -->
                                                <div class="mt-auto d-flex gap-2 justify-content-md-end">
                                                    <button class="btn btn-warning mt-3" id="editButton" type="button">Edit Profile</button>                                                    
                                                </div>
                                                <div class="mt-auto d-flex gap-2 justify-content-md-end">
                                                    <button class="btn btn-secondary mt-3 d-none" id="cancelButton" type="button">Cancel</button>
                                                    <button class="btn btn-warning mt-3 d-none" id="submitChangesButton" type="button">Submit Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Picture Section -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h5>Profile Picture</h5>
                                </div>
                                <div class="card-body text-center">
                                    <!-- Image Preview -->
                                    <div>
                                        <img id="imagePreview" src="<?php echo (!empty($_SESSION['profile_picture'])) ? '../../uploads/' . $_SESSION['profile_picture'] : '../../img/cropped-SLSU_Logo-1.png'; ?>" alt="User Profile" class="img-fluid mb-3 rounded-circle" width="300" height="300">
                                    </div>

                                    <!-- Upload Form -->
                                    <form id="uploadForm" action="../profile/upload_profile.php" method="POST" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*" required>
                                        </div>
                                        <!-- Removed the "Crop & Upload" button -->
                                    </form>
                                    
                                    <!-- Delete Photo Button -->
                                    <button type="button" class="btn btn-danger mt-2" data-bs-toggle="modal" data-bs-target="#deletePhotoModal">
                                        Delete Photo
                                    </button>
                                </div>
                            </div>
                        </div>


                        <!-- Crop Modal -->
                        <div class="modal fade" id="cropModal" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered"> <!-- modal-xl for larger size -->
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h5 class="modal-title text-white">Crop Your Profile Picture</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="d-flex justify-content-center">
                                            <img id="imageToCrop" src="" alt="Crop Image" style="max-width: 100%; height: auto;">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-success" id="confirmCrop">Crop & Upload</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Delete Photo Confirmation Modal -->
                        <div class="modal fade" id="deletePhotoModal" tabindex="-1" aria-labelledby="deletePhotoModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger">
                                        <h5 class="modal-title text-white" id="deletePhotoModalLabel">Delete Profile Photo</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete your profile photo? This action cannot be undone.
                                    </div>
                                    <div class="modal-footer">
                                        <form action="../profile/delete_profile_photo.php" method="POST">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" name="delete_photo" class="btn btn-danger">Delete Photo</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Profile Picture Section -->
                    </div>
                </div>
                <!--end::Container-->
            </div>
            <!--end::Profile Management Page-->
        </main> <!--end::App Main--> 
        
        <!-- Success Upload Modal -->
        <div class="modal fade" id="uploadSuccessModal" tabindex="-1" aria-labelledby="uploadSuccessModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="uploadSuccessModalLabel">Upload Successful</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Your profile picture has been uploaded successfully.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Delete Modal -->
        <div class="modal fade" id="deleteSuccessModal" tabindex="-1" aria-labelledby="deleteSuccessModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="deleteSuccessModalLabel">Deletion Successful</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Your profile picture has been deleted successfully.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Update Modal -->
        <div class="modal fade" id="updateSuccessModal" tabindex="-1" aria-labelledby="updateSuccessModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="updateSuccessModal">Update Successful</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Your profile has been updated successfully.
                    </div>
                    <div class="modal-footer">
                        <a href="profile_management.php" class="btn btn-success">OK</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Request Modal -->
        <div class="modal fade" id="requestSuccessModal" tabindex="-1" aria-labelledby="requestSuccessModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="requestSuccessModal">Update Request Successful</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Your profile update request has been sent to HR Department successfuly.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Edit Button col2-->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success-subtle">
                        <h5 class="modal-title" id="editModalLabel">HR Confirmation Required</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Editing these fields requires confirmation from HR. Are you sure you want to proceed?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="confirmEditButton">Confirm</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Update Profile Confirmation col1 -->
        <div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success-subtle">
                        <h5 class="modal-title" id="updateProfileModalLabel">Confirm Profile Update</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to update your profile? These changes will be saved immediately.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="confirmUpdateButton">Confirm Update</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Confirming Submit Changes col2 -->
        <div class="modal fade" id="submitModal" tabindex="-1" aria-labelledby="submitModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success-subtle">
                        <h5 class="modal-title" id="submitModalLabel">Confirm Changes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to submit these changes? The changes will require HR approval before they take effect.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="col-2-cancel">Cancel</button>
                        <button type="button" class="btn btn-primary" id="confirmSubmitButton">Confirm Submission</button>
                    </div>
                </div>
            </div>
        </div>



        <!--begin::Footer-->
        <?php require_once('../includes/footer.php')?> 
        <!--end::Footer-->
    </div> <!--end::App Wrapper--> 
    
    
    <!--begin::Script-->
    <!-- JAVA SCRIPTS --> 
    <?php require_once('../includes/dashboard_default_scripts.php');?>
    <!-- Cropper.js JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>


    <!-- JavaScript for Cropping and Uploading -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        let cropper;
        const imagePreview = document.getElementById('imagePreview');
        const imageToCrop = document.getElementById('imageToCrop');
        const profilePictureInput = document.getElementById('profile_picture');
        const confirmCrop = document.getElementById('confirmCrop');
        const uploadForm = document.getElementById('uploadForm');
        const cropModalElement = document.getElementById('cropModal');
        const cropModal = new bootstrap.Modal(cropModalElement, {
            backdrop: 'static',
            keyboard: false
        });

        // When a file is selected
        profilePictureInput.addEventListener('change', function (e) {
            const files = e.target.files;
            if (files && files.length > 0) {
                const file = files[0];

                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Sorry, only JPG, JPEG, PNG files are allowed.');
                    profilePictureInput.value = '';
                    return;
                }

                // Validate file size (2MB)
                if (file.size > 2097152) {
                    alert('Sorry, your file is too large. Maximum size is 2MB.');
                    profilePictureInput.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    imageToCrop.src = e.target.result;

                    // Show the modal after setting the image source
                    cropModal.show();
                };
                reader.readAsDataURL(file);
            }
        });

        // Initialize Cropper.js when the modal is fully shown
        cropModalElement.addEventListener('shown.bs.modal', function () {
            if (cropper) {
                cropper.destroy();
            }

            cropper = new Cropper(imageToCrop, {
                aspectRatio: 1, // Square crop
                viewMode: 1,
                preview: '.preview',
                movable: true,
                zoomable: true,
                rotatable: false,
                scalable: false,
                responsive: true,
                autoCropArea: 1,
                ready: function () {
                    // Optional: Add any additional configurations after Cropper.js is ready
                },
            });
        });

        // Handle the Crop & Upload action
        confirmCrop.addEventListener('click', function () {
            if (cropper) {
                // Get the cropped image data as a Blob
                cropper.getCroppedCanvas({
                    width: 300,
                    height: 300,
                }).toBlob(function (blob) {
                    // Create a FormData object
                    const formData = new FormData();
                    formData.append('profile_picture', blob, 'profile_picture.png'); // You can set the desired file name and type

                    // Create an XMLHttpRequest to send the data
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', '../profile/upload_profile.php', true);

                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            // Successfully uploaded
                            // Reload the page or update the profile picture preview
                            window.location.href = '../dashboard/profile_management.php?upload=success';
                        } else {
                            alert('An error occurred while uploading the image.');
                        }
                    };

                    xhr.send(formData);

                    // Close the modal
                    cropModal.hide();
                }, 'image/png');
            }
        });

        // When the crop modal is closed, destroy the cropper instance
        cropModalElement.addEventListener('hidden.bs.modal', function () {
            if (cropper) {
                cropper.destroy();
                cropper = null;
                imageToCrop.src = '';
                profilePictureInput.value = '';
            }
        });
    });
    </script>

    <!-- Function to show a modal by ID -->
    <script>
    function showModal(modalId) {
        var myModal = new bootstrap.Modal(document.getElementById(modalId));
        myModal.show();
    }

    <?php if ($showUploadSuccess): ?>
        document.addEventListener('DOMContentLoaded', function() {
            showModal('uploadSuccessModal');
        });
    <?php endif; ?>

    <?php if ($showDeleteSuccess): ?>
        document.addEventListener('DOMContentLoaded', function() {
            showModal('deleteSuccessModal');
        });
    <?php endif; ?>

    <?php if ($showDeleteError): ?>
        document.addEventListener('DOMContentLoaded', function() {
            alert('No profile picture to delete.');
        });
    <?php endif; ?>
    
    <?php if ($showUpdateSuccess): ?>
    document.addEventListener('DOMContentLoaded', function() {
        showModal('updateSuccessModal');
    });
    <?php endif; ?>

    <?php if ($showRequestSuccess): ?>
    document.addEventListener('DOMContentLoaded', function() {
        showModal('requestSuccessModal');
    });
    <?php endif; ?>

    <?php if ($showRequestNone): ?>
    document.addEventListener('DOMContentLoaded', function() {
        alert('No changes were submitted for approval.');
    });
    <?php endif; ?>

    </script>


    <!-- JavaScript for edit functionality and modal -->
    <script>
        // Trigger the modal when the edit button is clicked
        document.getElementById('editButton').addEventListener('click', function (event) {
            event.preventDefault();
            var editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        });

        // Confirm edit functionality to enable form inputs in the second column
        document.getElementById('confirmEditButton').addEventListener('click', function () {
            // Enable input fields and dropdowns in the HR-protected fields form
            var hrFormInputs = document.querySelectorAll('#hrProtectedFieldsForm input, #hrProtectedFieldsForm select');
            hrFormInputs.forEach(function (input) {
                if (input.classList.contains('d-none')) {
                    input.classList.remove('d-none'); // Show hidden fields
                }
                input.removeAttribute('readonly');
            });

            // Hide the displayed text (p tags) within the form
            document.querySelectorAll('#hrProtectedFieldsForm p[id]').forEach(function (p) {
                p.classList.add('d-none');
            });

            // Show the cancel and submit buttons after confirmation
            document.getElementById('cancelButton').classList.remove('d-none');
            document.getElementById('submitChangesButton').classList.remove('d-none');

            // Hide the edit button
            document.getElementById('editButton').style.display = 'none';

            // Close the modal after confirmation
            var editModal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
            editModal.hide();
        });


        // Handle Cancel Button functionality (reset only second column)
        document.getElementById('cancelButton').addEventListener('click', function () {
            // Revert back to the non-editable state for second column only
            var secondColumnInputs = document.querySelectorAll('.col-md-6:nth-child(2) form input, .col-md-6:nth-child(2) form select');
            secondColumnInputs.forEach(function (input) {
                input.classList.add('d-none'); // Hide fields including the dropdown
                input.setAttribute('readonly', 'readonly'); // Make fields read-only again if they are inputs
            });

            // Show the p tags again in the second column only
            document.querySelectorAll('.col-md-6:nth-child(2) p[id]').forEach(function (p) {
                p.classList.remove('d-none');
            });

            // Hide the cancel and submit buttons
            document.getElementById('cancelButton').classList.add('d-none');
            document.getElementById('submitChangesButton').classList.add('d-none');

            // Show the edit button again
            document.getElementById('editButton').style.display = 'inline-block';
        });

        // Handle Submit Changes button (trigger second modal for confirmation)
        document.getElementById('submitChangesButton').addEventListener('click', function () {
            var submitModal = new bootstrap.Modal(document.getElementById('submitModal'));
            submitModal.show();
        });
    </script>


    <!-- Update Profile -->
    <script>
    // Trigger the modal when the "Update Profile" button is clicked
    document.getElementById('updateProfileButton').addEventListener('click', function (event) {
        event.preventDefault();  // Prevent form submission for now
        var updateModal = new bootstrap.Modal(document.getElementById('updateProfileModal'));
        updateModal.show();
    });

    // Confirm Profile Update
    document.getElementById('confirmUpdateButton').addEventListener('click', function () {
        // Submit the editable fields form
        document.getElementById('editableFieldsForm').submit();
    });
    </script>


    <!-- Handle Submit Changes button (trigger second modal for confirmation) -->
    <script>    
    

    // Confirm Submission in the modal
    document.getElementById('confirmSubmitButton').addEventListener('click', function () {
        // Submit the HR-protected fields form
        document.getElementById('hrProtectedFieldsForm').submit();
    });
    </script>


    <!-- Employee ID validation -->
    <script>
    document.getElementById("employee_id").addEventListener("input", function() {
    const pattern = /^\d{3}-\d{3}$/;
        if (!pattern.test(this.value)) {
            this.setCustomValidity("Employee ID must be in the format 123-456");
        } else {
            this.setCustomValidity("");
        }
    });
    </script>
</body>
</html>


