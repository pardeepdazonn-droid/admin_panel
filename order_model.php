<?php
include_once 'conn.php';
function getAllOrders() {
    global $conn;
    $sql = "SELECT * FROM orders ORDER BY created_at DESC";
    $result = $conn->query($sql);

    $orders = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
    }
    return $orders;
}
function getOrderById($order_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    $stmt->close();
    return $order;
}
function getOrderItems($order_id) {
    global $conn;
    $stmt = $conn->prepare("
        SELECT oi.*, p.name AS product_name, p.serial_no
        FROM order_items oi
        JOIN product p ON oi.product_id = p.product_id
        WHERE oi.order_id = ?
    ");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    $stmt->close();
    return $items;
}
function getOrderShipping($order_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM shipping WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $shipping = $result->fetch_assoc();
    $stmt->close();
    return $shipping;
}
function getFullOrderDetails($order_id) {
    $order = getOrderById($order_id);
    if (!$order) return null;

    $order['items'] = getOrderItems($order_id);
    $order['shipping'] = getOrderShipping($order_id);

    return $order;
}

function getPendingOrders() {
    global $conn;
    $sql = "SELECT * FROM orders WHERE order_status = 'pending' ORDER BY created_at DESC";
    $result = $conn->query($sql);

    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
    return $orders;
}

function getShippingOrders() {
    global $conn;
    $sql = "
        SELECT o.order_id, o.customer_name, o.customer_email, o.customer_phone, 
               o.order_status, o.total_amount, o.created_at,
               s.address_line1, s.city, s.state, s.country, s.shipping_method, 
               s.tracking_number, s.shipped_at, s.delivered_at
        FROM orders o
        INNER JOIN shipping s ON o.order_id = s.order_id
        ORDER BY s.shipped_at DESC
    ";
    $result = $conn->query($sql);

    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
    return $orders;
}

?>
