<?php
include "conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($name && $username && $email && $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $imagePath = null;
        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $targetDir = __DIR__ . "/uploads/"; 
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $fileName   = time() . "_" . basename($_FILES['image']['name']);
            $targetFile = $targetDir . $fileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                 
                $imagePath = "uploads/" . $fileName;
            }
        }

        $sql = "INSERT INTO sub_admin (name, username, email, password, image, status, created_at) 
                VALUES (?, ?, ?, ?, ?, 1, NOW())";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            echo "Prepare failed: " . $conn->error;
            exit;
        }

        $stmt->bind_param("sssss", $name, $username, $email, $hashedPassword, $imagePath);

        if ($stmt->execute()) {
            echo "Sub-admin created successfully!";
        } else {
            echo "Database error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "All fields are required.";
    }
}
?>
