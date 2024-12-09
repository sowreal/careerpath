<?php
// contact_us.php

// Include session management and ensure the user is logged in
require_once 'session.php'; // Adjust the path as necessary

// Include the database connection
require_once 'connection.php'; // Adjust the path as necessary

// Include configuration
require_once 'config.php'; // Ensure BASE_PATH is defined in config.php

// Initialize variables for error/success messages
$success = '';
$error = '';
$pageTitle = 'Contact Us';
$activePage = 'Contact Us';

// CSRF Protection: Generate a CSRF token if not already set
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate CSRF Token
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $error = "Invalid CSRF token.";
    } else {
        // Retrieve and sanitize form inputs
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
        $message = isset($_POST['message']) ? trim($_POST['message']) : '';

        // Validate inputs
        if (empty($name) || empty($email) || empty($subject) || empty($message)) {
            $error = "All fields are required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Please enter a valid email address.";
        } else {
            try {
                // If the user is logged in, get their user_id
                $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

                // Prepare the SQL statement using PDO
                $stmt = $conn->prepare("
                    INSERT INTO contact_messages 
                    (user_id, name, email, subject, message) 
                    VALUES 
                    (:user_id, :name, :email, :subject, :message)
                ");

                // Bind parameters
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
                $stmt->bindParam(':message', $message, PDO::PARAM_STR);

                // Execute the statement
                $stmt->execute();

                // Success message
                $success = "Your message has been sent successfully! We'll get back to you shortly.";

                // Optionally, you can redirect to a thank-you page
                // header("Location: thank_you.php");
                // exit();
            } catch (PDOException $e) {
                // Log the error for debugging (do not display detailed errors to users in production)
                error_log("Database Error: " . $e->getMessage());
                $error = "An unexpected error occurred. Please try again later.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once BASE_PATH . '/php/includes/header.php'; ?>
    <title>Contact Us - CareerPath</title>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
    <div class="app-wrapper"> 
        <!--begin::Header-->
        <?php require_once BASE_PATH . '/php/includes/navbar.php'; ?>
        <!--end::Header--> 
        
        <!--begin::Sidebar-->
        <?php
            // Role-Based Sidebar Inclusion
            if (isset($_SESSION['role'])) {
                if ($_SESSION['role'] == 'Human Resources') {
                    require_once BASE_PATH . '/php/includes/sidebar_hr.php';
                } elseif ($_SESSION['role'] == 'Regular Instructor' || $_SESSION['role'] == 'Contract of Service Instructor') {
                    require_once BASE_PATH . '/php/includes/sidebar_faculty.php';
                } else {
                    // Default Sidebar or handle other roles
                    require_once BASE_PATH . '/php/includes/sidebar_default.php';
                }
            } else {
                // If role is not set, include default sidebar or handle accordingly
                require_once BASE_PATH . '/php/includes/sidebar_default.php';
            }
        ?> 
        <!--end::Sidebar--> 

        <!--begin::App Main-->
        <main class="app-main">
            <div class="app-content-header"> 
                <div class="container-fluid"> 
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Contact Us</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <?php if ($_SESSION['role'] == 'Human Resources'): ?>
                                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/php/dashboard_HR/dashboard_HR.php">Home</a></li>
                                <?php else: ?>
                                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/php/dashboard/dashboard_faculty.php">Home</a></li>
                                <?php endif; ?>
                                <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    <!-- Contact Form Card -->
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h5>Get in Touch</h5>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($success)): ?>
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <?php echo htmlspecialchars($success); ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($error)): ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <?php echo htmlspecialchars($error); ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    <?php endif; ?>

                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" novalidate>
                                        <!-- CSRF Token -->
                                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

                                        <!-- Name -->
                                        <div class="mb-3">
                                            <label for="name" class="form-label"><strong>Name</strong></label>
                                            <input type="text" class="form-control" id="name" name="name" 
                                                value="<?php echo isset($_SESSION['user_id']) ? htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']) : ''; ?>" 
                                                <?php echo isset($_SESSION['user_id']) ? 'readonly' : 'required'; ?>>
                                        </div>

                                        <!-- Email -->
                                        <div class="mb-3">
                                            <label for="email" class="form-label"><strong>Email</strong></label>
                                            <input type="email" class="form-control" id="email" name="email" 
                                                value="<?php echo isset($_SESSION['user_id']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" 
                                                <?php echo isset($_SESSION['user_id']) ? 'readonly' : 'required'; ?>>
                                        </div>

                                        <!-- Subject -->
                                        <div class="mb-3">
                                            <label for="subject" class="form-label"><strong>Subject</strong></label>
                                            <input type="text" class="form-control" id="subject" name="subject" required>
                                        </div>

                                        <!-- Message -->
                                        <div class="mb-3">
                                            <label for="message" class="form-label"><strong>Message</strong></label>
                                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-success">Send Message</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> <!-- End of Row -->
                </div> <!-- End of Container -->
            </div> <!-- End of App Content -->
        </main> <!-- End of Main Content -->

        <!-- Footer -->
        <?php require_once BASE_PATH . '/php/includes/footer.php'; ?>
    </div> <!-- End of App Wrapper -->

    <!--begin::Script--> 
    <?php require_once BASE_PATH . '/php/includes/dashboard_default_scripts.php'; ?> 
</body>
</html>
