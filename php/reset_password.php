<?php
// reset_password.php
session_start();
require 'connection.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Validate token format
    if (ctype_xdigit($token) && strlen($token) === 64) {
        // Check if token exists and is valid
        $stmt = $conn->prepare("SELECT * FROM password_resets WHERE token = ?");
        $stmt->execute([$token]);
        $reset = $stmt->fetch();

        if ($reset && $reset['expires'] >= time()) {
            $_SESSION['reset_email'] = $reset['email'];
            $_SESSION['reset_token'] = $token;  // Store token in session for additional verification
        } else {
            echo "Invalid or expired token.";
            exit();
        }
    } else {
        echo "Invalid token format.";
        exit();
    }
} else {
    echo "No token provided.";
    exit();
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

    <!-- Bootstrap CSS (only include one version) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link href="../css/global.css" rel="stylesheet" />
    <link href="../css/login/login.css" rel="stylesheet" />

    <style>
        .resetPasswordMessage {
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
                <img src="../Imager2.png" class="img-fluid" style="width: 350px;">
            </div>
            <p class="text-white fs-2 text-center" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Be Verified</p>
            <small class="text-white text-wrap text-center" style="width: 17rem; font-family: 'Courier New', Courier, monospace;">Join the experience</small>
        </div>

        <!-- Right Box -->
        <div class="col-md-6 right-box">
            <div class="row align-items-center">
                <div class="header-text mb-4 text-center">
                    <h2>Hello, Again</h2>
                    <p>Reset your password below</p>
                </div>

                <div class="container">
                    <h2 class="mb-4">Create New Password</h2>
                    <form id="resetPasswordForm">
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">New Password:</label>
                            <input type="password" class="form-control" id="newPassword" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmNewPassword" class="form-label">Confirm New Password:</label>
                            <input type="password" class="form-control" id="confirmNewPassword" name="confirm_password" required>
                        </div>
                        <div id="resetPasswordMessage" class="mb-3"></div>
                        <div class="row mb-3">
                            <div class="col">
                                <a href="../index.html" class="btn btn-secondary w-100">Home</a>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="row text-center mt-3">
                    <small>Don't have an account? <a href="../registration.html">Sign Up</a></small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS (only include one version) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script src="../js/login.js"></script>

<script>
    document.getElementById('resetPasswordForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const password = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmNewPassword').value;
        const resetPasswordMessage = document.getElementById('resetPasswordMessage');

        // Clear previous messages
        resetPasswordMessage.textContent = '';
        resetPasswordMessage.classList.remove('text-danger', 'text-success');

        // Send AJAX request
        fetch('process_reset_password.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'password=' + encodeURIComponent(password) + '&confirm_password=' + encodeURIComponent(confirmPassword)
        })
        .then(response => response.text())
        .then(data => {
            // Display success or error message
            resetPasswordMessage.textContent = data;

            if (data.includes('successfully')) {
                resetPasswordMessage.classList.add('text-success');
                // Optionally redirect to login page after a delay
                setTimeout(() => {
                    window.location.href = 'login.php';
                }, 3000);
            } else {
                resetPasswordMessage.classList.add('text-danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            resetPasswordMessage.textContent = 'An error occurred. Please try again.';
            resetPasswordMessage.classList.add('text-danger');
        });
    });
</script>

</body>
</html>
