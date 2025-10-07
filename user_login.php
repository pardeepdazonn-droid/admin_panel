<?php
session_start();
include('conn.php');

header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'Invalid request'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $response['message'] = "Email and password are required.";
        echo json_encode($response);
        exit;
    }

    
    $stmt = $conn->prepare("SELECT user_id, name, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
    
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];

            $response['success'] = true;
            $response['message'] = "Login successful!";
        } else {
            $response['message'] = "Invalid password.";
        }
    } else {
        $response['message'] = "No user found with this email.";
    }

    $stmt->close();
}

echo json_encode($response);
exit;
?>
