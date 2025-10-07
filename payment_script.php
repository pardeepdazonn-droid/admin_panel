<?php
session_start();
require __DIR__ . "/vendor/autoload.php";
require_once 'conn.php';
require_once 'product_model.php';

use Dotenv\Dotenv;
use Stripe\Stripe;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Use Stripe key from .env
Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to make a purchase");
}

// Get product info from POST
$product_id = $_POST['product_id'] ?? null;
$quantity   = $_POST['quantity'] ?? 1;

if (!$product_id) die("Product not found");

$product = getProductById($product_id);
if (!$product) die("Product not found");

$unit_amount = $product['price'] * 100;

// Get logged-in user data
$user_id = $_SESSION['user_id'];
$user_name = '';
$user_email = '';
$user_phone = '';

$stmt = $conn->prepare("SELECT name, email, phone FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($user_data = $result->fetch_assoc()) {
    $user_name = $user_data['name'];
    $user_email = $user_data['email'];
    $user_phone = $user_data['phone'];

    // Update session
    $_SESSION['user_name'] = $user_name;
    $_SESSION['user_email'] = $user_email;
    $_SESSION['user_phone'] = $user_phone;
} else {
    die("User not found");
}
$stmt->close();

// Store checkout data in session
$_SESSION['checkout_data'] = [
    'product_id' => $product_id,
    'quantity' => $quantity
];

$checkout_session = \Stripe\Checkout\Session::create([
    "payment_method_types" => ["card"],
    "mode" => "payment",
    "success_url" => "http://localhost/ecommerce-dashboard/success.php?session_id={CHECKOUT_SESSION_ID}",
    "cancel_url"  => "http://localhost/index.php",
    "customer_email" => $user_email,
    "line_items" => [[
        "quantity" => $quantity,
        "price_data" => [
            "currency" => "usd",
            "unit_amount" => $unit_amount,
            "product_data" => [
                "name" => $product['name'],
                "images" => [$product['image'] ?? '']
            ]
        ]
    ]],
    "metadata" => [
        "product_id" => $product_id,
        "quantity"   => $quantity,
        "user_id"    => $user_id,
        "customer_name" => $user_name,
        "customer_email" => $user_email,
        "customer_phone" => $user_phone
    ]
]);

// Redirect to Stripe Checkout
header("Location: " . $checkout_session->url);
exit;
?>
