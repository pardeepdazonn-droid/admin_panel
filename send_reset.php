<?php
require 'conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    $stmt = $conn->prepare("SELECT admin_id FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $token = bin2hex(random_bytes(32)); // 64 chars
        $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));
        $stmt->close();

        $stmt = $conn->prepare("UPDATE admin SET reset_token = ?, reset_expires = ? WHERE email = ?");
        $stmt->bind_param("sss", $token, $expires, $email);
        $stmt->execute();

        // Normally: send via email, here we just show
        $resetLink = "http://localhost/ecommerce-dashboard/reset_password.php?token=" . urlencode($token);
        echo "<div style='margin:20px;padding:20px;border:1px solid #ccc;'>
                <p><strong>Password reset link:</strong></p>
                <a href='$resetLink'>$resetLink</a>
              </div>";

        $stmt->close();
    } else {
        echo "No account found with that email.";
    }
}
