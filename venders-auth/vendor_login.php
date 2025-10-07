<?php
session_start();
include('../conn.php');
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    echo json_encode(['success'=>false,'message'=>'Invalid request']);
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if(empty($email) || empty($password)){
    echo json_encode(['success'=>false,'message'=>'Email and password are required']);
    exit;
}

$stmt = $conn->prepare("SELECT vendor_id,email,password,role FROM vendors WHERE email=?");
$stmt->bind_param("s",$email);
$stmt->execute();
$stmt->store_result();

if($stmt->num_rows === 1){
    $stmt->bind_result($id,$db_email,$db_password,$role);
    $stmt->fetch();

    if(password_verify($password,$db_password)){
        $_SESSION['user_id'] = $id;
        $_SESSION['user_email'] = $db_email;
        $_SESSION['role'] = $role;

        echo json_encode(['success'=>true,'message'=>'Login successful']);
    } else {
        echo json_encode(['success'=>false,'message'=>'Incorrect password']);
    }
} else {
    echo json_encode(['success'=>false,'message'=>'No account found with that email']);
}
$stmt->close();
