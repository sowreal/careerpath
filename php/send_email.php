<?php
// send_email.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

function sendEmail($toEmail, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();  // Send using SMTP
        $mail->Host       = 'smtp.hostinger.com';               // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                               // Enable SMTP authentication
        $mail->Username   = 'no-reply@slsucareerpath.com';      // SMTP username
        $mail->Password   = 'u7?gio35&DP';                      // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;        // Enable SSL encryption
        $mail->Port       = 465;                                // SMTP port for SSL

        // Recipients
        $mail->setFrom('no-reply@slsucareerpath.com', 'SLSU CareerPath Support');
        $mail->addAddress($toEmail);

        // Content
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email failed: " . $mail->ErrorInfo);
        return false;
    }
}
