<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';

    if (empty($email)) {
        echo json_encode(["error" => "Email is required"]);
        exit;
    }

    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_email'] = $email;
    $_SESSION['otp_expires'] = time() + 300; 

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'pardeep.dazonn@gmail.com';
        $mail->Password = 'yegi rcph laie ndou';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('pardeep.dazonn@gmail.com', 'MyShop Verification');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body = "Your OTP code is <b>$otp</b>. It is valid for 5 minutes.";

        $mail->send();

        echo json_encode(["success" => true, "message" => "OTP sent successfully"]);
    } catch (Exception $e) {
        echo json_encode(["error" => "Email sending failed: {$mail->ErrorInfo}"]);
    }
}
?>
