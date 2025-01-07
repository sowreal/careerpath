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
                                    <form id="profileForm" action="../profile/update_profile.php" method="POST" class="d-flex flex-column h-100">
                                        <div class="row">
                                            <!-- Editable Information Form -->
                                            <div class="col-md-6 d-flex flex-column">
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
                                            </div>

                                            <!-- HR Confirmed Information Form -->
                                            <div class="col-md-6 d-flex flex-column">
                                                <!-- Email -->
                                                <div class="mb-3">
                                                    <label for="email" class="form-label"><strong>Email:</strong></label>
                                                    <input type="text" class="form-control" id="email" name="email" value="<?php echo $_SESSION['email']?>" required>
                                                </div>

                                                <!-- Employee ID -->
                                                <div class="mb-3">
                                                    <label for="employee_id" class="form-label"><strong>Employee ID:</strong></label>
                                                    <input type="text"
                                                        class="form-control"
                                                        id="employee_id"
                                                        name="employee_id"
                                                        value="<?php echo $_SESSION['employee_id'] ?>"
                                                        pattern="[A-Z]{4}-[A-Z]{3}\d{4}"
                                                        title="Employee ID must be in the format ABCD-EFG1234"
                                                        required>
                                                </div>

                                                <!-- Faculty Rank -->
                                                <div class="mb-3">
                                                    <label for="faculty_rank" class="form-label"><strong>Faculty Rank:</strong></label>
                                                    <select class="form-control" id="faculty_rank" name="faculty_rank" required>
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
                                                    <select class="form-control" id="role" name="role" required>
                                                        <option value="">Select your role</option>
                                                        <option value="Regular Instructor" <?php if($_SESSION['role'] == 'Regular Instructor') echo 'selected'; ?>>Regular Instructor</option>
                                                        <option value="Contract of Service Instructor" <?php if($_SESSION['role'] == 'Contract of Service Instructor') echo 'selected'; ?>>Contract of Service Instructor</option>
                                                        <option value="Human Resources Personnel" <?php if($_SESSION['role'] == 'Human Resources Personnel') echo 'selected'; ?>>Human Resources Personnel</option>
                                                    </select>
                                                </div>

                                                <!-- Department -->
                                                <div class="mb-3">
                                                    <label for="department" class="form-label"><strong>Department:</strong></label>
                                                    <select class="form-control" id="department" name="department" required>
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
                                            </div>
                                        </div>

                                        <!-- Buttons Section for Editable Info -->
                                        <div class="mt-auto d-flex gap-2 justify-content-md-end">
                                            <button type="submit" class="btn btn-success mt-3" id="updateProfileButton">Save Changes</button>
                                        </div>
                                    </form>
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

        <!--begin::Footer-->
        <?php //require_once('../includes/footer.php')?>
        <!--end::Footer-->
    </div> <!--end::App Wrapper-->

    <!--begin::Script-->
    <!-- JAVA SCRIPTS -->
    <?php require_once('../includes/dashboard_default_scripts.php');?>
    <!-- Cropper.js JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <!-- Bootstrap JS Bundle (includes Popper) -->

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

                // Validate file size (10MB)
                if (file.size > 10485760) {  // 10 * 1024 * 1024 = 10485760 bytes
                    alert('Sorry, your file is too large. Maximum size is 10MB.');
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

    </script>

    <!-- Employee ID validation -->
    <script>
    document.getElementById("employee_id").addEventListener("input", function() {
    const pattern = /^[A-Z]{4}-[A-Z]{3}\d{4}$/;
        if (!pattern.test(this.value)) {
            this.setCustomValidity("Employee ID must be in the format ABCD-EFG1234");
        } else {
            this.setCustomValidity("");
        }
    });
    </script>
</body>
</html>