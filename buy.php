<?php
session_start();
$productId = $_GET['id'] ?? 0;
if (!isset($_SESSION['user_id'])) {
    header("Location: user_loginForm.php?redirect=buy.php&id=" . $productId);
    exit;
}
if ($productId) {
    header("Location: product_details.php?id=" . $productId);
    exit;
} else {
    header("Location: index.php");
    exit;
}
