<?php
// career_progress_request.php

include('../../session.php'); // Ensure the user is logged in
include('../../connection.php'); // Include the database connection
require_once '../../config.php';

// Define variables for Page Titles and Sidebar Active effects
$pageTitle = 'Career Path | Career Tracking';
$activePage = 'CPT_Request';

// Check if the user is a Faculty Member
if ($_SESSION['role'] != 'Regular Instructor' && $_SESSION['role'] != 'Contract of Service Instructor') {
    // Check if the user is Human Resources
    if ($_SESSION['role'] != 'Human Resources') {
        // **Start of Session Destruction**
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        // **End of Session Destruction**

        // Notify the user and redirect to the login page
        echo "<script>
                alert('Your account is not authorized. Redirecting to login page.');
                window.location.href = '../../login.php';
              </script>";
        exit();
    }
    // If the user is part of Human Resources, redirect to their dashboard
    header('Location: ../../dashboard_HR/dashboard_HR.php'); // Redirect to HR dashboard if not a faculty member
    exit();
}

// Initialize variables for error/success messages
$success = '';
$error = '';

// Initialize variables to store form data
$degree = '';
$name_hei = '';
$year_graduated = '';
$mode_of_appointment = '';
$date_of_appointment = '';
$suc_name = '';
$campus = '';
$address = '';

// CSRF Protection: Generate or verify token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate CSRF Token
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $error = "Invalid CSRF token.";
    } else {
        // Retrieve and sanitize form inputs
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        if (!$user_id) {
            $error = "Employee ID not found in session.";
        } else {
            // Safely retrieve 'faculty_rank' from session
            $current_rank = isset($_SESSION['faculty_rank']) ? trim($_SESSION['faculty_rank']) : '';

            // Trim and retrieve other inputs with isset checks
            $degree = isset($_POST['degree']) ? trim($_POST['degree']) : '';
            $name_hei = isset($_POST['name_hei']) ? trim($_POST['name_hei']) : '';
            $year_graduated = isset($_POST['year_graduated']) ? trim($_POST['year_graduated']) : '';
            $mode_of_appointment = isset($_POST['mode_of_appointment']) ? trim($_POST['mode_of_appointment']) : '';
            $date_of_appointment = !empty($_POST['date_of_appointment']) ? $_POST['date_of_appointment'] : null;
            $suc_name = isset($_POST['suc_name']) ? trim($_POST['suc_name']) : '';
            $campus = isset($_POST['campus']) ? trim($_POST['campus']) : '';
            $address = isset($_POST['address']) ? trim($_POST['address']) : '';

            // Server-side validation for 'year_graduated'
            $current_year = date("Y");
            if (!is_numeric($year_graduated) || intval($year_graduated) < 1900 || intval($year_graduated) > $current_year) {
                $error = "Please enter a valid year of graduation.";
            }

            // Validate 'mode_of_appointment'
            $valid_modes = ['new_appointment', 'institutional_promotion', 'nbc461'];
            if (!in_array($mode_of_appointment, $valid_modes)) {
                $error = "Invalid mode of appointment selected.";
            }

            // Additional validations can be added here

            if (empty($error)) {
                try {
                    // Prepare the SQL statement using PDO
                    $stmt = $conn->prepare("
                        INSERT INTO request_form 
                        (user_id, degree_name, name_of_hei, year_graduated, current_rank, mode_of_appointment, date_of_appointment, suc_name, campus, address) 
                        VALUES 
                        (:user_id, :degree, :name_hei, :year_graduated, :current_rank, :mode_of_appointment, :date_of_appointment, :suc_name, :campus, :address)
                    ");

                    // Bind parameters
                    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                    $stmt->bindParam(':degree', $degree, PDO::PARAM_STR);
                    $stmt->bindParam(':name_hei', $name_hei, PDO::PARAM_STR);
                    $stmt->bindParam(':year_graduated', $year_graduated, PDO::PARAM_INT);
                    $stmt->bindParam(':current_rank', $current_rank, PDO::PARAM_STR);
                    $stmt->bindParam(':mode_of_appointment', $mode_of_appointment, PDO::PARAM_STR);
                    $stmt->bindParam(':date_of_appointment', $date_of_appointment, PDO::PARAM_STR);
                    $stmt->bindParam(':suc_name', $suc_name, PDO::PARAM_STR);
                    $stmt->bindParam(':campus', $campus, PDO::PARAM_STR);
                    $stmt->bindParam(':address', $address, PDO::PARAM_STR);

                    // Execute the statement
                    $stmt->execute();

                    // Get the unique request_id
                    $request_id = $conn->lastInsertId();
                    $success = "Request submitted successfully! Your Request ID is: " . htmlspecialchars($request_id);

                    // Optionally, redirect to a confirmation page
                    // header("Location: confirmation.php?request_id=" . urlencode($request_id));
                    // exit();

                } catch (PDOException $e) {
                    // For debugging: Display the error message (remove in production)
                    $error = "An unexpected error occurred. Please try again later. <br> Error Details: " . htmlspecialchars($e->getMessage());

                    // Optionally, log the error for further inspection
                    error_log("Database Error: " . $e->getMessage());
                }
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once '../../includes/header.php' ?>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
    <div class="app-wrapper"> 
        <!--begin::Header-->
        <?php require_once('../../includes/navbar.php'); ?>
        <!--end::Header--> 
        
        <!--begin::Sidebar-->
        <?php require_once('../../includes/sidebar_faculty.php'); ?> 
        <!--end::Sidebar--> 

        <!--begin::App Main-->
        <main class="app-main">
            <section class="content">
                <div class="container-fluid">
                    <!-- Standalone Header -->
                    <div class="app-content-header ">
                        <div class="container-fluid ">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h3 class="mb-0">SUC Faculty Position Reclassification Request Form</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Success and Error Messages -->
                    <?php if($success): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $success; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $error; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Centered Form Card Container -->
                    <div class="row justify-content-center">
                        <div class="col"><!---lg-10 col-md-10-->
                            <div class="card shadow-sm">
                                <div class="card-header bg-success text-white">
                                    <h4>Request Form</h4>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="">
                                        <!-- CSRF Token -->
                                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

                                        <div class="row">
                                            <!-- Personal Information Column -->
                                            <div class="col-md-6">
                                                <h5 class="font-weight-bold mb-3">Personal Information</h5>
                                                <div class="form-group mt-3">
                                                    <label for="last_name">Last Name</label>
                                                    <input type="text" class="form-control mt-2" id="last_name" name="last_name" 
                                                           placeholder="Enter last name" 
                                                           value="<?php echo htmlspecialchars($_SESSION['last_name']); ?>" disabled>
                                                </div>
                                                <div class="form-group mt-3">
                                                    <label for="first_name">First Name</label>
                                                    <input type="text" class="form-control mt-2" id="first_name" name="first_name" 
                                                           placeholder="Enter first name" 
                                                           value="<?php echo htmlspecialchars($_SESSION['first_name']); ?>" disabled>
                                                </div>
                                                <div class="form-group mt-3 mb-3">
                                                    <label for="email">Email</label>
                                                    <input type="email" class="form-control mt-2" id="email" name="email"
                                                           placeholder="Enter email" 
                                                           value="<?php echo htmlspecialchars($_SESSION['email']); ?>" disabled>
                                                </div>
                                            </div>

                                            <!-- Highest Educational Attainment Column -->
                                            <div class="col-md-6">
                                                <h5 class="font-weight-bold">Highest Educational Attainment</h5>
                                                <div class="form-group mt-3">
                                                    <label for="degree">Name of Degree</label>
                                                    <input type="text" class="form-control mt-2" id="degree" name="degree" 
                                                           placeholder="Enter highest degree" required
                                                           value="<?php echo htmlspecialchars($degree); ?>">
                                                </div>
                                                <div class="form-group mt-3">
                                                    <label for="name_hei">Name of HEI</label>
                                                    <input type="text" class="form-control mt-2" id="name_hei" name="name_hei" 
                                                           placeholder="Enter name of Higher Education Institution" required
                                                           value="<?php echo htmlspecialchars($name_hei); ?>">
                                                </div>
                                                <div class="form-group mt-3">
                                                    <label for="year_graduated">Year Graduated</label>
                                                    <input type="number" class="form-control mt-2" id="year_graduated" name="year_graduated" 
                                                           placeholder="Enter year of graduation" required
                                                           value="<?php echo htmlspecialchars($year_graduated); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Current Employment Status Section -->
                                        <div class="row mt-4">
                                            <div class="col-12">
                                                <h5 class="font-weight-bold mb-3">Current Employment Status</h5>
                                            </div>
                                            <!-- Left Column -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="faculty_rank">Current Faculty Rank</label>
                                                    <select class="form-control mt-2" id="faculty_rank" name="faculty_rank" disabled>
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
                                                <div class="form-group mt-3">
                                                    <label for="mode_of_appointment">Mode of Appointment</label>
                                                    <select class="form-control mt-2" id="mode_of_appointment" name="mode_of_appointment" required>
                                                        <option value="">Select Mode of Appointment</option>
                                                        <option value="new_appointment" <?php if($mode_of_appointment == 'new_appointment') echo 'selected'; ?>>New Appointment</option>
                                                        <option value="institutional_promotion" <?php if($mode_of_appointment == 'institutional_promotion') echo 'selected'; ?>>Institutional Promotion</option>
                                                        <option value="nbc461" <?php if($mode_of_appointment == 'nbc461') echo 'selected'; ?>>NBC 461</option>
                                                    </select>
                                                </div>
                                                <div class="form-group mt-3 mb-3">
                                                    <label for="date_of_appointment">Date of Appointment</label>
                                                    <input type="date" class="form-control mt-2" id="date_of_appointment" name="date_of_appointment" 
                                                           placeholder="Select date of appointment" required
                                                           value="<?php echo htmlspecialchars($date_of_appointment); ?>">
                                                </div>
                                            </div>

                                            <!-- Right Column -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="suc_name">Name of SUC</label>
                                                    <input type="text" class="form-control mt-2" id="suc_name" name="suc_name" 
                                                           placeholder="Enter name of SUC" required
                                                           value="<?php echo htmlspecialchars($suc_name); ?>">
                                                </div>
                                                <div class="form-group mt-3">
                                                    <label for="campus">Campus</label>
                                                    <input type="text" class="form-control mt-2" id="campus" name="campus" 
                                                           placeholder="Enter campus name" required
                                                           value="<?php echo htmlspecialchars($campus); ?>">
                                                </div>
                                                <div class="form-group mt-3 mb-3">
                                                    <label for="address">Address</label>
                                                    <input type="text" class="form-control mt-2" id="address" name="address" 
                                                           placeholder="Enter address" required
                                                           value="<?php echo htmlspecialchars($address); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Submit Button with Modal Trigger -->
                                        <div class="mt-4 text-right">
                                            <button type="button" class="btn btn-success" id="submitRequestButton">
                                                Submit Request
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Confirmation Modal -->
                <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="confirmationModalLabel">Statement of Agreement</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <!-- Modal Body -->
                            <div class="modal-body">
                                <p class="fs-5">
                                    Attached to this request form are my self-accomplished Individual Summary Sheet (ISS) and its attached forms; 
                                    checklist of evidence submitted; and photocopy of the sets of evidence based on my ISS. 
                                    The electronic copies of the ISS and the evidence are available in my Google Drive that I will willingly 
                                    share with the Evaluation Committees for the validation of the information submitted.
                                </p>
                                <p class="fs-5">
                                    I attest that all information provided in this request for position reclassification are true, accurate, and complete. 
                                    I understand that any falsification of these documents may lead to my disqualification from position reclassification 
                                    for this evaluation cycle.
                                </p>
                            </div>

                            <!-- Modal Footer with Cancel and Agree Buttons -->
                            <div class="modal-footer">
                                <!-- Cancel Button -->
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                                <!-- Agree and Submit Button -->
                                <button type="button" class="btn btn-success" id="confirmSubmitButton">Agree and Submit</button>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
        </main>
        <!--end::App Main-->

        <!--begin::Footer-->   
            <?php require_once('../../includes/footer.php'); ?> 
        <!--end::Footer-->
    </div> 
    <!--end::App Wrapper--> 
        
        
    <!--begin::Script--> 
    <?php require_once('../../includes/dashboard_default_scripts.php'); ?> 

    <!-- Validation and Modal Trigger Logic -->
    <script>
        document.querySelector('#submitRequestButton').addEventListener('click', function(event) {
            // Reference the form element
            const form = document.querySelector('form');
            
            // Check if the form is valid using the HTML5 checkValidity method
            if (form.checkValidity()) {
                // If valid, prevent the default action and show the confirmation modal
                event.preventDefault();
                $('#confirmationModal').modal('show');
            } else {
                // If not valid, let the browser display the validation messages
                form.reportValidity();
            }
        });

        // Event listener for the Agree and Submit button inside the modal
        document.querySelector('#confirmSubmitButton').addEventListener('click', function() {
            // Submit the form when the user clicks "Agree and Submit" in the modal
            document.querySelector('form').submit();
        });
    </script>

</body>
</html>
