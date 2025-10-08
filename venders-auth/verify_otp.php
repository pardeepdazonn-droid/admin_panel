<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp = $_POST['otp'] ?? '';

    header('Content-Type: application/json');

    if (empty($otp)) {
        echo json_encode(["error" => "OTP is required"]);
        exit;
    }

    if (!isset($_SESSION['otp'], $_SESSION['otp_expires'])) {
        echo json_encode(["error" => "No OTP found, please request again."]);
        exit;
    }

    if (time() > $_SESSION['otp_expires']) {
        echo json_encode(["error" => "OTP expired."]);
        exit;
    }

    if ($otp == $_SESSION['otp']) {
        $_SESSION['email_verified'] = true; 
        unset($_SESSION['otp'], $_SESSION['otp_expires']);
        echo json_encode(["success" => true, "message" => "Email verified successfully!"]);
        exit;
    } else {
        echo json_encode(["error" => "Invalid OTP."]);
    }
}
?>