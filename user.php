<?php
session_start();
include('conn.php');

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'An unknown error occurred.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = $_POST['name'] ?? '';
    $email    = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $phone    = $_POST['phone'] ?? '';
    $address_line1 = $_POST['address_line1'] ?? '';
    $address_line2 = $_POST['address_line2'] ?? '';
    $city          = $_POST['city'] ?? '';
    $state         = $_POST['state'] ?? '';
    $postal_code   = $_POST['postal_code'] ?? '';
    $country       = $_POST['country'] ?? '';

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, phone) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $hashedPassword, $phone);

    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;

        $stmtAddr = $conn->prepare("INSERT INTO user_address (user_id, address_line1, address_line2, city, state, postal_code, country) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmtAddr->bind_param("issssss", $user_id, $address_line1, $address_line2, $city, $state, $postal_code, $country);

        if ($stmtAddr->execute()) {
            $response['success'] = true;
            $response['message'] = "User registered successfully!";
        } else {
            $response['message'] = "Failed to save address: " . $stmtAddr->error;
        }
        $stmtAddr->close();
    } else {
        $response['message'] = "Database Error: " . $stmt->error;
    }
    $stmt->close();
}
echo json_encode($response);
exit;
?>
