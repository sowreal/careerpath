<?php
// Start session
session_start();

// Include the database connection
include('connection.php'); // Your PDO connection script

// Initialize an empty error message
$error_message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL statement to find the user by email and check if they are verified
    $sql = "SELECT * FROM users WHERE email = ? AND is_verified = 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the user data

    // Check if user exists
    if ($user) {
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Clear existing session data
            $_SESSION = array();

            // Destroy the session if it's already active
            if (session_id() != "" || isset($_COOKIE[session_name()])) {
                setcookie(session_name(), '', time() - 3600, '/');
                session_unset();
                session_destroy();
            }

            // Start a new session
            session_start();

            // Regenerate session ID to prevent session fixation
            session_regenerate_id(true);

            // Set session variables on successful login
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['role'] = $user['role']; // Store the user's role in session

            // Redirect based on role
            if ($user['role'] == 'Regular Instructor' || $user['role'] == 'Contract of Service Instructor') {
                header('Location: dashboard/dashboard_faculty.php'); // Relative path
            } elseif ($user['role'] == 'Human Resources') {
                header('Location: dashboard_HR/dashboard_HR.php'); // Relative path
            } else {
                // Default redirect if role doesn't match
                header('Location: dashboard/dashboard_faculty.php');
            }
            exit();
        
        } else {
            // Invalid password
            $error_message = "Incorrect password. Please try again.";
        }        
    } else {
        // No user found or account not verified
        $error_message = "No user found with this email or account not verified.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>CareerPath - Start Your Career Journey With Us</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
 
    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Custom Stylesheet -->
    <link href="../css/global.css" rel="stylesheet" />
    <link href="../css/login/login.css" rel="stylesheet" />

    <style>
        .error-message {
            margin-top: -0.8rem;
            padding-bottom: 0.5rem;
            color: #b22222;  /* Dark red for error */
            font-weight: bold;
        }
    </style>

</head>

<body>

<!-- Main Container -->
<div class="container d-flex justify-content-center align-items-center min-vh-100">

    <!-- Login Container -->
    <div class="row border rounded-5 p-3 bg-white shadow box-area">

        <!-- Left Box -->
        <div class="col-md-6 left-box d-flex justify-content-center flex-column align-items-center" style="background: #00BF7B;">
            <div class="featured-image mb-3 text-center">
                <img src="../Imager2.png" class="img-fluid" style="width: 350px;"> <!-- Updated to go one directory up -->
            </div>
            <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600; text-align: center;">Be Verified</p>
            <small class="text-white text-wrap text-center" style="width: 17rem; font-family: 'Courier New', Courier, monospace; text-align: center;">Join the experience</small>
        </div>

        <!-- Right Box -->
        <div class="col-md-6 right-box">
            <div class="row align-items-center">
                <!-- Home Button -->
                <div class="mt-auto d-flex justify-content-end">
                    <a href="../index.html">
                        <button type="button" class="btn btn-lg btn-light fs-6">
                            <i class="fas fa-home"></i>
                        </button>
                    </a>
                </div>

                <div class="header-text mb-4 text-center">
                    <h2>Hello, Again</h2>
                    <p>We are happy to have you back</p>
                </div>

                <!-- Login Form -->
                <form id="loginForm" action="login.php" method="POST">
                    <!-- Email Field with Client-Side Email Validation -->
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control form-control-lg" placeholder="Email address" required
                            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"> <!-- Ensures basic email format -->
                    </div>

                    <!-- Email Error Message (if applicable) placed outside the input-group -->
                    <?php if (!empty($error_message) && strpos($error_message, 'email') !== false): ?>
                        <div id="verification-message" class="error-message"><?php echo $error_message; ?></div>
                    <?php endif; ?>


                    <!-- Password Field -->
                    <div class="input-group mb-3">
                        <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Password" required>
                        <span class="input-group-text" onclick="togglePassword()">
                            <i id="password-icon" class="far fa-eye"></i>
                        </span>
                    </div>


                    <!-- Password Error Message (if any) placed outside the input-group -->
                    <?php if (!empty($error_message) && strpos($error_message, 'password') !== false): ?>
                        <div id="password-error" class="error-message"><?php echo $error_message; ?></div>
                    <?php endif; ?>



                    <div class="input-group mb-5 d-flex justify-content-end">
                        <!-- <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="FormCheck">
                            <label for="FormCheck" class="form-check-label text-secondary"><small>Remember me</small></label>
                        </div> -->
                        <div class="Forgot">
                            <p><a href="#" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">Forgot Password?</a></p>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <button type="submit" class="btn btn-lg btn-primary w-100">Login</button>
                    </div>

                    <!-- Login with Google Button -->
                    <!-- <div class="input-group mb-3">
                        <button type="button" class="btn btn-lg btn-light w-100 fs-6">
                            <img src="../google.png" style="width:20px" class="me-2"><small>Sign in with Google</small>
                        </button>
                    </div> -->
                </form>


                
                <div class="row text-center">
                    <small>Don't have an account? <a href="../registration.html">Sign Up</a></small> <!-- Updated to go one directory up -->
                </div>

                <!-- Forgot Password Modal -->
                <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <form id="forgotPasswordForm">
                            <div class="modal-header">
                            <h5 class="modal-title" id="forgotPasswordLabel">Forgot Password</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <p>Enter your registered email address, and we'll send you a link to reset your password.</p>
                            <div class="mb-3">
                                <label for="forgotEmail" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="forgotEmail" name="email" required>
                            </div>
                            <div id="forgotPasswordMessage" style="color: green;"></div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="submitButton">Send Reset Link</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>


<!-- Custom JS -->
<script src="../js/login.js"></script> <!-- Updated to go one directory up -->

<!-- Form submission for modal -->
<script>
    document.getElementById('forgotPasswordForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    const email = document.getElementById('forgotEmail').value;
    const submitButton = document.getElementById('submitButton');
    const messageElement = document.getElementById('forgotPasswordMessage');
    let countdown = 5; // Countdown for the button re-enable

    // Disable the submit button and provide feedback
    submitButton.disabled = true;
    submitButton.textContent = 'Sending...';

    // Clear previous messages
    messageElement.textContent = '';
    messageElement.style.color = '';

    // Send AJAX request
    fetch('process_forgot_password.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'email=' + encodeURIComponent(email)
    })
    .then(response => response.text())
    .then(data => {
        // Display success or error message from the server
        messageElement.textContent = data;
        messageElement.style.color = 'green'; // Success message in green
    })
    .catch(error => {
        console.error('Error:', error);
        messageElement.textContent = 'An error occurred. Please try again.';
        messageElement.style.color = 'red'; // Error message in red
    })
    .finally(() => {
        // Countdown for re-enabling the button
        const countdownInterval = setInterval(() => {
            if (countdown > 0) {
                submitButton.textContent = `Wait ${countdown}s`;
                countdown--;
            } else {
                clearInterval(countdownInterval);
                submitButton.disabled = false;
                submitButton.textContent = 'Send Reset Link';
            }
        }, 1000); // Countdown updates every second
    });
});
</script>


    <!-- Toggle Password -->
    <script>
        function togglePassword() {
        const passwordField = document.getElementById("password");
        const icon = document.getElementById("password-icon");
        
        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
    </script>

</body>
</html>
