<?php
session_start();
require __DIR__ . "/vendor/autoload.php";
require_once 'conn.php';
require_once 'product_model.php';

use Dotenv\Dotenv;
use Stripe\Stripe;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to make a purchase");
}

$product_id = $_POST['product_id'] ?? null;
$quantity   = $_POST['quantity'] ?? 1;

if (!$product_id) die("Product not found");

$product = getProductById($product_id);
if (!$product) die("Product not found");

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT name, email, phone FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user) die("User not found");

$user_name  = $user['name'];
$user_email = $user['email'];
$user_phone = $user['phone'];

$stmt = $conn->prepare("SELECT * FROM user_address WHERE user_id = ? LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$address = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$address) die("User address not found");

$customer_address = implode(', ', array_filter([
    $address['address_line1'],
    $address['address_line2'],
    $address['city'],
    $address['state'],
    $address['postal_code'],
    $address['country']
]));

include('distence.php');

$total_product_price = $product['price'] * $quantity;
$gst_include_price   = $total_product_price * 1.18;
$discount            = $product['discount'] ?? 0;
$total_price         = ($gst_include_price + $shipping_fee) - $discount;
$unit_amount         = round($total_price * 100);

$checkout_session = \Stripe\Checkout\Session::create([
    "payment_method_types" => ["card"],
    "mode" => "payment",
    "success_url" => "http://localhost/admin_panel/success.php?session_id={CHECKOUT_SESSION_ID}",
    "cancel_url"  => "http://localhost/index.php",
    "customer_email" => $user_email,
    "line_items" => [[
        "quantity" => 1,
        "price_data" => [
            "currency" => "usd",
            "unit_amount" => $unit_amount,
            "product_data" => [
                "name" => $product['name'] . " (Qty: $quantity)",
                "images" => [$product['image'] ?? '']
            ]
        ]
    ]],
    "metadata" => [
        "product_id" => $product_id,
        "quantity" => $quantity,
        "user_id" => $user_id,
        "customer_name" => $user_name,
        "customer_email" => $user_email,
        "customer_phone" => $user_phone,
        "shipping_fee" => $shipping_fee,
        "gst_amount" => ($gst_include_price - $total_product_price),
        "discount" => $discount,
        "total_price" => $total_price
    ]
]);

header("Location: " . $checkout_session->url);
exit;
?>
