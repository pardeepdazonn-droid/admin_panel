<?php
session_start();
require 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_email = trim($_POST['email']);
    $input_password = $_POST['password'];

    
    if (empty($input_email) || empty($input_password)) {
        $_SESSION['error'] = "Please enter both email and password.";
        header("Location: admin.php");
        exit;
    }
    $stmt = $conn->prepare("SELECT admin_id, email, password FROM admin WHERE email = ?");
    $stmt->bind_param("s", $input_email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($db_id, $db_email, $db_password);
        $stmt->fetch();
        if (password_verify($input_password, $db_password)) {
            $_SESSION['admin_id'] = $db_id;
            $_SESSION['admin_email'] = $db_email;

            unset($_SESSION['error']);
            header("Location: landing_page.php");
            exit;
        } else {
            $_SESSION['error'] = "Incorrect password.";
            header("Location: admin.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "No account found with that email.";
        header("Location: admin.php");
        exit;
    }
    $stmt->close();
}
