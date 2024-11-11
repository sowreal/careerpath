<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';  // Ensure the correct path for Composer autoload

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the email is available in the session
if (isset($_SESSION['email'])) {
    // Retrieve the email from the session
    $email = $_SESSION['email'];
    $firstName = $_SESSION['first_name'] ?? '';  // Use a default value if first_name is not set
    $lastName = $_SESSION['last_name'] ?? '';    // Use a default value if last_name is not set

    // Generate a new verification code
    $verificationCode = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);

    // Store the new verification code in the session
    $_SESSION['verification_code'] = $verificationCode;

    // Create the email content
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();  // Send using SMTP
        $mail->Host       = 'smtp.hostinger.com';               // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                               // Enable SMTP authentication
        $mail->Username   = 'support@slsucareerpath.com';       // SMTP username
        $mail->Password   = 'P3#&EIr2Azj';                      // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;        // Enable SSL encryption
        $mail->Port       = 465;                                // SMTP port for SSL

        // Recipients
        $mail->setFrom('support@slsucareerpath.com', 'SLSU CareerPath Verification');
        $mail->addAddress($email, "$firstName $lastName");       // Add the recipient

        // Content
        $mail->isHTML(true);                                    // Set email format to HTML
        $mail->Subject = 'Resend: Email Verification Code';
        $mail->Body    = "Dear $firstName $lastName,<br><br>Your new verification code is \n\n<strong>$verificationCode</strong>. \n\nPlease enter this code to complete your registration.<br><br>Thank you!";
        $mail->AltBody = "Dear $firstName $lastName,\n\nYour new verification code is $verificationCode.\nPlease enter this code to complete your registration.\n\nThank you!";

        // Send the email
        if ($mail->send()) {
            echo 'Verification code has been resent';  // Response for the AJAX request
        } else {
            http_response_code(500);
            echo 'Failed to resend verification email';
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    // If the session does not contain the email, respond with an error
    http_response_code(400);  // Bad Request
    echo 'Error: No email found to resend the verification code.';
}
