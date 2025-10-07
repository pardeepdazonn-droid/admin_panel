<?php
include_once 'conn.php';

function getAllProducts() {
    global $conn;
    $sql = "SELECT * FROM product";
    $result = $conn->query($sql);
    if ($result === false) return [];

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    return $products;
}

function getProductById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM product WHERE product_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
    return $product;
}

function updateProduct($id, $serial_no, $name, $description, $price, $comp_price, $discount, $delivery_time, $category, $brand, $image_path = null) {
    global $conn;

    if ($image_path) {
        $stmt = $conn->prepare("UPDATE product 
            SET serial_no=?, name=?, description=?, price=?, comp_price=?, discount=?, delivery_time=?, category=?, brand=?, image=? 
            WHERE product_id=?");
        $stmt->bind_param("sssdddssssi", $serial_no, $name, $description, $price, $comp_price, $discount, $delivery_time, $category, $brand, $image_path, $id);
    } else {
        $stmt = $conn->prepare("UPDATE product 
            SET serial_no=?, name=?, description=?, price=?, comp_price=?, discount=?, delivery_time=?, category=?, brand=? 
            WHERE product_id=?");
        $stmt->bind_param("sssdddsssi", $serial_no, $name, $description, $price, $comp_price, $discount, $delivery_time, $category, $brand, $id);
    }

    $success = $stmt->execute();
    $stmt->close();
    return $success;
}

function deleteProduct($id) {
    global $conn;
    $id = intval($id);
    if ($id <= 0) return false;

    $stmt = $conn->prepare("DELETE FROM product WHERE product_id = ?");
    if (!$stmt) return false;

    $stmt->bind_param("i", $id);
    $success = $stmt->execute();
    $stmt->close();
    return $success;
}
