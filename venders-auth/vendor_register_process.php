<?php
session_start();
require '../conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $phone = trim($_POST['phone']);
    $company_name = trim($_POST['company_name']);

    if (empty($name) || empty($email) || empty($password) || empty($phone)) {
        $_SESSION['error'] = "All fields except company are required.";
        header("Location: vendor_register.php");
        exit;
    }


    if (!isset($_SESSION['email_verified']) || $_SESSION['email_verified'] !== true) {
        $_SESSION['error'] = "Please verify your email before registering.";
        header("Location: vendor_register_process.php");
        exit;
    }



    $stmt = $conn->prepare("SELECT vendor_id FROM vendors WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "Email already registered.";
        header("Location: vendor_register.php");
        exit;
    }
    $stmt->close();

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO vendors (name,email,password,phone,company_name) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sssss", $name, $email, $hashed_password, $phone, $company_name);

    if ($stmt->execute()) {
        unset($_SESSION['email_verified']);
        $_SESSION['success'] = "Vendor registered successfully!";
        header("Location: ../vendors.php");
    } else {
        $_SESSION['error'] = "Something went wrong.";
        header("Location: vendor_register.php");
    }
}
?>