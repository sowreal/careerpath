<?php
include('../../session.php'); // Ensure the user is logged in
include('../../connection.php'); // Include the database connection

// Define variables for Page Titles and Sidebar Active effects
$pageTitle = 'Career Path | Career Tracking';
$activePage = 'CPT_Request';

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
                window.location.href = '../../login.php';
              </script>";
        exit();
    }
    // If the user is part of Human Resources, redirect to their dashboard
    header('Location: ../../dashboard_HR/dashboard_HR.php'); // Redirect to HR dashboard if not a faculty member
    exit();
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
                    <div class="app-content-header">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h3 class="mb-0">SUC Faculty Position Reclassification Request Form</h3>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-end">
                                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Career Progress Tracking Request Form</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Centered Form Card Container -->
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-md-10">
                            <div class="card shadow-sm mt-4">
                                <div class="card-header bg-success text-white">
                                    <h1 class="card-title">Request Form</h1>
                                </div>
                                <div class="card-body">
                                    <form>

                                        <div class="row">
                                            <!-- Personal Information Column -->
                                            <div class="col-md-6">
                                                <h5 class="font-weight-bold mb-3">Personal Information</h5>
                                                <div class="form-group mt-3">
                                                    <label for="last_name">Last Name</label>
                                                    <input type="text" class="form-control mt-2" id="last_name" 
                                                        placeholder="Enter last name" 
                                                        value="<?php echo $_SESSION['last_name']; ?>">
                                                </div>
                                                <div class="form-group mt-3">
                                                    <label for="first_name">First Name</label>
                                                    <input type="text" class="form-control mt-2" id="first_name" 
                                                        placeholder="Enter first name" 
                                                        value="<?php echo $_SESSION['first_name']; ?>">
                                                </div>
                                                <div class="form-group mt-3 mb-3">
                                                    <label for="email">Email</label>
                                                    <input type="email" class="form-control mt-2" id="email"
                                                        placeholder="Enter email" 
                                                        value="<?php echo $_SESSION['email']; ?>">
                                                </div>
                                            </div>

                                            <!-- Highest Educational Attainment Column -->
                                            <div class="col-md-6">
                                                <h5 class="font-weight-bold">Highest Educational Attainment</h5>
                                                <div class="form-group mt-3">
                                                    <label for="degree">Name of Degree</label>
                                                    <input type="text" class="form-control mt-2" id="degree" placeholder="Enter highest degree">
                                                </div>
                                                <div class="form-group mt-3">
                                                    <label for="name_hei">Name of HEI</label>
                                                    <input type="text" class="form-control mt-2" id="name_hei" placeholder="Enter name of Higher Education Institution">
                                                </div>
                                                <div class="form-group mt-3">
                                                    <label for="year_graduated">Year Graduated</label>
                                                    <input type="text" class="form-control mt-2" id="year_graduated" placeholder="Enter year of graduation">
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
                                                    <div class="form-group mt-3">
                                                        <label for="mode_of_appointment">Mode of Appointment</label>
                                                        <select class="form-control" id="mode_of_appointment" name="mode_of_appointment">
                                                            <option value="new_appointment">New Appointment</option>
                                                            <option value="institutional_promotion">Institutional Promotion</option>
                                                            <option value="nbc461">NBC 461</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group mt-3 mb-3">
                                                        <label for="date_of_appointment">Date of Appointment</label>
                                                        <input type="date" class="form-control" id="date_of_appointment" placeholder="Select date of appointment">
                                                    </div>
                                                </div>

                                                <!-- Right Column -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="suc_name">Name of SUC</label>
                                                        <input type="text" class="form-control" id="suc_name" placeholder="Enter name of SUC">
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <label for="campus">Campus</label>
                                                        <input type="text" class="form-control" id="campus" placeholder="Enter campus name">
                                                    </div>
                                                    <div class="form-group mt-3 mb-3">
                                                        <label for="address">Address</label>
                                                        <input type="text" class="form-control" id="address" placeholder="Enter address">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Submit Button with Modal Trigger -->
                                        <div class="mt-4 text-right">
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#confirmationModal">
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
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmationModalLabel">Confirm Submission</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>
                                    Attached to this request form are my self-accomplished Individual Summary Sheet (ISS) and its attached forms; 
                                    checklist of evidence submitted; and photocopy of the sets of evidence based on my ISS. 
                                    The electronic copies of the ISS and the evidence are available in my Google Drive that I will willingly share 
                                    with the Evaluation Committees for the validation of the information submitted.
                                </p>
                                <p>
                                    I attest that all information provided in this request for position reclassification are true, accurate, and complete. 
                                    I understand that any falsification of these documents may lead to my disqualification 
                                    from position reclassification for this evaluation cycle.
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Agree and Submit</button>
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


</body>
</html>


