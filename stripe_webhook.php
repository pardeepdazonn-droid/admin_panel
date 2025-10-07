<?php
require __DIR__ . "/vendor/autoload.php";
require_once 'conn.php';
require_once 'product_model.php';

use Dotenv\Dotenv;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
 
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

 
Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
 
$endpoint_secret = $_ENV['STRIPE_ENDPOINT_SECRET'];
 
$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';

$event = null;

try {
    $event = Webhook::constructEvent(
        $payload,
        $sig_header,
        $endpoint_secret
    );
} catch (\UnexpectedValueException $e) {
    http_response_code(400);
    exit();
} catch (SignatureVerificationException $e) {
    http_response_code(400);
    exit();
}

switch ($event->type) {
    case 'checkout.session.completed':
        $session = $event->data->object;

        $customer_name  = $session->metadata->customer_name ?? '';
        $customer_email = $session->metadata->customer_email ?? '';
        $customer_phone = $session->metadata->customer_phone ?? '';
        $total_amount   = $session->amount_total / 100;

        $product_id = $session->metadata->product_id ?? null;
        $quantity   = $session->metadata->quantity ?? 1;
        $user_id    = $session->metadata->user_id ?? 0;

        $conn->begin_transaction();

        try {
            $order_status = 'paid';
            $stmt = $conn->prepare("INSERT INTO orders (customer_name, customer_email, customer_phone, order_status, total_amount, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
            $stmt->bind_param("ssssd", $customer_name, $customer_email, $customer_phone, $order_status, $total_amount);

            if ($stmt->execute()) {
                $order_id = $conn->insert_id;
                $stmt->close();

                if ($product_id) {
                    $product = getProductById($product_id);
                    if ($product) {
                        $price = $product['price'];
                        $subtotal = $price * $quantity;
                        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price, subtotal) VALUES (?, ?, ?, ?, ?)");
                        $stmt->bind_param("iiidd", $order_id, $product_id, $quantity, $price, $subtotal);
                        $stmt->execute();
                        $stmt->close();
                    }
                }

                $payment_id = $session->payment_intent ?? 'stripe_pi_' . time();
                $stmt = $conn->prepare("INSERT INTO payments (order_id, user_id, stripe_payment_id, amount, payment_status, payment_method, created_at, updated_at) VALUES (?, ?, ?, ?, 'succeeded', 'card', NOW(), NOW())");
                $stmt->bind_param("iisd", $order_id, $user_id, $payment_id, $total_amount);
                $stmt->execute();
                $stmt->close();

                $conn->commit();
            } else {
                throw new Exception("Order insertion failed: " . $stmt->error);
            }
        } catch (Exception $e) {
            $conn->rollback();
            error_log("Webhook error: " . $e->getMessage());
        }
        break;

    default:
        http_response_code(200);
        exit();
}

http_response_code(200);
?>
