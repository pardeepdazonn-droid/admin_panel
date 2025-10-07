<?php 
session_start();
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        die("You must be logged in to place an order.");
    }

    $user_id    = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $quantity   = $_POST['quantity'];

    $stmt = $conn->prepare("SELECT name, email, phone FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$user) die("User not found");

    $stmt = $conn->prepare("SELECT * FROM user_address WHERE user_id = ? LIMIT 1");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $address = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$address) die("User address not found");

    
    $stmt = $conn->prepare("SELECT name, price FROM product WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$product) die("Product not found");

    $total_amount = $product['price'] * $quantity;

    
    $stmt = $conn->prepare("INSERT INTO orders (customer_name, customer_email, customer_phone, order_status, total_amount) 
                            VALUES (?, ?, ?, 'pending', ?)");
    $stmt->bind_param("sssd", $user['name'], $user['email'], $user['phone'], $total_amount);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();


    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) 
                            VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $product['price']);
    $stmt->execute();
    $stmt->close();

    
    $stmt = $conn->prepare("
        INSERT INTO shipping (order_id, address_line1, address_line2, city, state, postal_code, country, shipping_method)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $shipping_method = "Standard";  
    $stmt->bind_param(
        "isssssss",
        $order_id,
        $address['address_line1'],
        $address['address_line2'],
        $address['city'],
        $address['state'],
        $address['postal_code'],
        $address['country'],
        $shipping_method
    );
    $stmt->execute();
    $stmt->close();

    echo "Order placed successfully! Your order ID is #" . $order_id;
}
?>
