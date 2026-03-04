<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../tools/vendor/autoload.php';

function send_verification_email($user_email, $user_name, $verification_link) {
    $mail = new PHPMailer(true);
    
    try {
        // SMTP Settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'aalumni00@gmail.com';      // Your email
        $mail->Password = 'hkni ipac sjlj mcoy';          // App password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        // Recipients
        $mail->setFrom('alu.admin@ucaconnect.com', 'UCA Connect');
        $mail->addAddress($user_email, $user_name);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Verify Your UCA Connect Account';
        $mail->Body = "
            <h2>Welcome to UCA Connect, $user_name!</h2>
            <p>Click the link below to verify your email:</p>
            <div class='box-button' style='cursor:pointer;border:4px solid black;background-color:gray;padding-bottom:10px;transition:0.1s ease-in-out;user-select:none;display:inline-block;'>
                <a href='$verification_link' class='button' style='background-color:#dddddd;border:4px solid #fff;padding:3px 8px;text-decoration:none;display:inline-block;'>
                    <span style='font-size:1.2em;letter-spacing:1px;'>Verify Email</span>
                </a>
            </div>
        ";
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email Error: {$mail->ErrorInfo}");
        return false;
    }
}