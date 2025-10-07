<?php
session_start();
require_once 'conn.php';
require_once 'product_model.php';


if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to view this page");
}

$session_id = $_GET['session_id'] ?? '';

if (empty($session_id)) {
    die("Invalid session");
}


$order_success = false;
$order_id = null;
$error_message = '';


if (isset($_SESSION['checkout_data'])) {
    $checkout_data = $_SESSION['checkout_data'];

    $user_id = $_SESSION['user_id'];
    $product_id = $checkout_data['product_id'] ?? null;
    $quantity = $checkout_data['quantity'] ?? 1;


    $customer_name = '';
    $customer_email = '';
    $customer_phone = '';

    $stmt = $conn->prepare("SELECT name, email, phone FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($user_data = $result->fetch_assoc()) {
        $customer_name = $user_data['name'];
        $customer_email = $user_data['email'];
        $customer_phone = $user_data['phone'];
    } else {
        $error_message = "User not found";
    }
    $stmt->close();

    if (!$error_message) {

        $product = getProductById($product_id);

        if ($product) {
            $total_amount = $product['price'] * $quantity;

            $conn->begin_transaction();

            try {

                $order_status = 'paid';
                $stmt = $conn->prepare("INSERT INTO orders (customer_name, customer_email, customer_phone, order_status, total_amount, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");

                if (!$stmt) {
                    throw new Exception("Prepare failed: " . $conn->error);
                }

                $stmt->bind_param("ssssd", $customer_name, $customer_email, $customer_phone, $order_status, $total_amount);

                if ($stmt->execute()) {
                    $order_id = $conn->insert_id;
                    $stmt->close();


                    $price = $product['price'];
                    $subtotal = $price * $quantity;
                    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price, subtotal) VALUES (?, ?, ?, ?, ?)");

                    if (!$stmt) {
                        throw new Exception("Order items prepare failed: " . $conn->error);
                    }

                    $stmt->bind_param("iiidd", $order_id, $product_id, $quantity, $price, $subtotal);

                    if ($stmt->execute()) {
                        $stmt->close();


                        $payment_id = 'manual_' . time();
                        $stmt = $conn->prepare("INSERT INTO payments (order_id, user_id, stripe_payment_id, amount, payment_status, payment_method, created_at, updated_at) VALUES (?, ?, ?, ?, 'succeeded', 'card', NOW(), NOW())");

                        if (!$stmt) {
                            throw new Exception("Payments prepare failed: " . $conn->error);
                        }

                        $stmt->bind_param("iisd", $order_id, $user_id, $payment_id, $total_amount);

                        if ($stmt->execute()) {
                            $conn->commit();
                            $order_success = true;


                            unset($_SESSION['checkout_data']);
                            error_log("Success: Order #$order_id created for logged-in user: $customer_email");
                        } else {
                            throw new Exception("Payment insertion failed: " . $stmt->error);
                        }
                        $stmt->close();
                    } else {
                        throw new Exception("Order items insertion failed: " . $stmt->error);
                    }
                } else {
                    throw new Exception("Order insertion failed: " . $stmt->error);
                }

            } catch (Exception $e) {
                $conn->rollback();
                $error_message = $e->getMessage();
                error_log("Order insertion error: " . $e->getMessage());
            }
        } else {
            $error_message = "Product not found with ID: $product_id";
        }
    }
} else {
    $error_message = "No checkout data in session";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <div class="text-success mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor"
                                class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                            </svg>
                        </div>
                        <h2 class="card-title">Payment Successful!</h2>
                        <p class="card-text">Thank you for your purchase. Your order has been processed successfully.
                        </p>

                        <?php if ($order_success && $order_id): ?>
                            <div class="alert alert-success mt-3">
                                <strong>Order Confirmed!</strong><br>
                                Your order ID is: <strong>#<?php echo $order_id; ?></strong><br>
                                <small>Order placed with: <?php echo htmlspecialchars($customer_email); ?></small>
                            </div>
                        <?php elseif ($error_message): ?>
                            <div class="alert alert-warning mt-3">
                                <strong>Note:</strong> <?php echo htmlspecialchars($error_message); ?><br>
                                Session ID: <?php echo htmlspecialchars($session_id); ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info mt-3">
                                <strong>Payment Verified!</strong><br>
                                Session ID: <?php echo htmlspecialchars($session_id); ?>
                            </div>
                        <?php endif; ?>

                        <p class="text-muted">We have sent a confirmation email to
                            <strong><?php echo htmlspecialchars($customer_email); ?></strong></p>

                        <div class="d-grid gap-2 d-md-block">
                            <a href="index.php" class="btn btn-primary">Continue Shopping</a>
                            <?php if ($order_success && $order_id): ?>
                                <a href="order_details.php?order_id=<?php echo $order_id; ?>"
                                    class="btn btn-outline-secondary">View Order Details</a>
                            <?php else: ?>
                                <a href="order_history.php" class="btn btn-outline-secondary">View Order History</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>