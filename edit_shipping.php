<?php
session_start();
include 'conn.php';
header('Content-Type: application/json');
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success'=>false,'message'=>'Not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Get POST data safely
$line1 = $_POST['address_line1'] ?? '';
$line2 = $_POST['address_line2'] ?? '';
$city = $_POST['city'] ?? '';
$state = $_POST['state'] ?? '';
$postal = $_POST['postal_code'] ?? '';
$country = $_POST['country'] ?? '';

// Check/update/insert
$stmt = $conn->prepare("SELECT * FROM user_address WHERE user_id=? LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$address = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($address) {
    $stmt = $conn->prepare("UPDATE user_address SET address_line1=?, address_line2=?, city=?, state=?, postal_code=?, country=? WHERE user_id=?");
    $stmt->bind_param("ssssssi", $line1, $line2, $city, $state, $postal, $country, $user_id);
    $stmt->execute();
    $stmt->close();
} else {
    $stmt = $conn->prepare("INSERT INTO user_address (user_id,address_line1,address_line2,city,state,postal_code,country) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param("issssss", $user_id, $line1, $line2, $city, $state, $postal, $country);
    $stmt->execute();
    $stmt->close();
}

// Return JSON only
echo json_encode([
    'success' => true,
    'message' => 'Shipping address updated successfully!'
]);
?>