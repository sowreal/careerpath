<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';  // Ensure the correct path for Composer autoload


// Start or resume the session to store the verification code
session_start(); 


// Function to generate a secure verification code
function generateVerificationCode($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    
    for ($i = 0; $length > $i; $i++) {
        $randomIndex = random_int(0, $charactersLength - 1);  // Secure random index
        $randomString .= $characters[$randomIndex];
    }
    
    return $randomString;
}

// Function to send the verification email
function sendVerificationEmail($email, $firstName, $lastName, $verificationCode) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();  // Send using SMTP
        $mail->Host       = 'smtp.hostinger.com';               // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                               // Enable SMTP authentication
        $mail->Username   = 'no-reply@slsucareerpath.com';       // SMTP username
        $mail->Password   = 'u7?gio35&DP';                      // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;        // Enable SSL encryption
        $mail->Port       = 465;                                // SMTP port for SSL

        // Recipients
        $mail->setFrom('no-reply@slsucareerpath.com', 'SLSU CareerPath Verification');
        $mail->addAddress($email, "$firstName $lastName");  // Add a recipient

        // Content
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = 'Email Verification Code';
        $mail->Body    = "Dear $firstName $lastName,<br><br>Your verification code is \n\n<strong>$verificationCode</strong>. \n\nPlease enter this code to complete your registration.<br><br>Thank you!";
        $mail->AltBody = "Dear $firstName $lastName,\n\nYour verification code is $verificationCode.\nPlease enter this code to complete your registration.\n\nThank you!";

        // Send the email
        return $mail->send();  // Return true if the email is sent successfully
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;  // Return false if the email failed to send
    }
}

// Check if the email has already been sent
// if (!isset($_SESSION['email_sent']) || $_SESSION['email_sent'] === false) {

//     $email = $_POST['email'];
//     $firstName = $_POST['first_name'];
//     $lastName = $_POST['last_name'];

//     // Generate a verification code
//     $verificationCode = generateVerificationCode();

//     // Store the verification code in the session
//     $_SESSION['verification_code'] = $verificationCode;

//     // Send the verification email
//     if (sendVerificationEmail($email, $firstName, $lastName, $verificationCode)) {
//         $_SESSION['email_sent'] = true;  // Mark the email as sent
//         echo "Verification email sent successfully.";
//     } else {
//         echo "Failed to send verification email.";
//     }
// } else {
//     echo "Verification email already sent. Please check your inbox.";
// }
