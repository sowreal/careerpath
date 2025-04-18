<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>CareerPath - Start Your Career Journey With Us</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


    <!-- Global Style -->
    <link rel="stylesheet" href="../css/global.css">
    <!-- General Styles -->
    <link rel="stylesheet" href="../css/registration/general.css">
    <!-- Form Styles -->
    <link rel="stylesheet" href="../css/registration/form.css">
    <!-- Button Styles -->
    <link rel="stylesheet" href="../css/registration/buttons.css">
    <!-- Dropdown Styles -->
    <link rel="stylesheet" href="../css/registration/dropdown.css">
    <!-- Password Handling Styles -->
    <link rel="stylesheet" href="../css/registration/password.css">
    <!-- Responsive Styles -->
    <link rel="stylesheet" href="../css/registration/responsive.css">
    <!-- Progressbar Styles -->
    <link rel="stylesheet" href="../css/registration/progressbar.css">


</head>

<body>

<!-- Main Container -->
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <!-- Success Message Box -->
    <div class="row border rounded-5 p-3 bg-white shadow box-area">
        <!-- Left Box -->
        <div class="col-md-6 left-box d-flex justify-content-center flex-column align-items-center" style="background: #00BF7B;">
            <div class="featured-image mb-3 text-center">
                <img src="../Imager2.png" class="img-fluid" style="width: 350px;">
            </div>
            <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600; text-align: center;">Success!</p>
            <small class="text-white text-wrap text-center" style="width: 17rem; font-family: 'Courier New', Courier, monospace; text-align: center;">
                Your registration was successful!
            </small>
        </div>

        <!-- Right Box -->
        <div class="col-md-6 right-box d-flex flex-column justify-content-center align-items-center text-center">
            <div class="content-box">
                <h2>Registration Complete!</h2>
                <p>Thank you for joining us. You will be redirected to your dashboard shortly.</p>
                <p>If you're not redirected, <a href="login.php">click here</a> to go login.</p>
            </div>
        </div>
    </div>
</div>


<!-- Redirect to Dashboard after 5 seconds -->
<script>
        setTimeout(function() {
            window.location.href = "login.php";  // Adjusted path
        }, 3000);  // 3 seconds delay
</script>

<!-- JavaScript Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- JS Files -->
<script src="../js/registration/registration_buttons.js"></script>
<script src="../js/registration/registration_validation.js"></script>
<script src="../js/registration/registration_progress.js"></script>
<script src="../js/registration/registration_password.js"></script>
<script src="../js/registration/registration_placeholders.js"></script>
<script src="../js/registration/registration_review.js"></script>
<script src="../js/registration/registration_tooltips.js"></script>
<script src="../js/registration/registration_ajax.js"></script>
<script src="../js/registration/registration_resend.js"></script>


</body>
</html>
