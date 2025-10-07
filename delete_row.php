<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'product_model.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

$id = !empty($_POST['id']) ? intval($_POST['id']) : 0;

if (!$id) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing or invalid id']);
    exit;
}

if (deleteProduct($id)) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database deletion failed']);
}
