<?php
require 'conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    $stmt = $conn->prepare("SELECT admin_id, reset_expires FROM admin WHERE reset_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user) {
        die("Invalid token.");
    }

    if (strtotime($user['reset_expires']) < time()) {
        die("Token expired.");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE admin SET password = ?, reset_token = NULL, reset_expires = NULL WHERE admin_id = ?");
    $stmt->bind_param("si", $hashedPassword, $user['admin_id']);
    if ($stmt->execute()) {
        echo "<p>Password updated successfully. <a href='admin.php'>Login</a></p>";
    } else {
        echo "Failed to update password.";
    }
    $stmt->close();
}
