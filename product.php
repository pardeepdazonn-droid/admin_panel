<?php
session_start();
include('conn.php');
header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'Unknown error occurred'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serial_no = trim($_POST['serial_no'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = $_POST['price'] ?? 0;
    $comp_price = $_POST['comp_price'] ?? 0;
    $discount = $_POST['discount'] ?? 0;
    $delivery_time = trim($_POST['delivery_time'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $brand = trim($_POST['brand'] ?? '');
    $coupon = trim($_POST['coupon'] ?? '');
    $replacement = trim($_POST['replacement'] ?? '');
    $image_path = "";
    $canInsert = true;

    
    $check = $conn->prepare("SELECT product_id FROM product WHERE serial_no = ?");
    $check->bind_param("s", $serial_no);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $response['message'] = "Duplicate Serial No: Product already exists.";
        $canInsert = false;
    }
    $check->close();

    
    if ($canInsert && isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_name = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($image_ext, $allowed_extensions)) {
            $response['message'] = "Invalid file type. Allowed: jpg, jpeg, png, gif, webp.";
            $canInsert = false;
        } elseif ($image_size > 5000000) {
            $response['message'] = "File too large. Max 5MB.";
            $canInsert = false;
        } else {
            $new_image_name = uniqid() . '.' . $image_ext;
            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
            $destination = $upload_dir . $new_image_name;

            if (move_uploaded_file($image_tmp_name, $destination)) {
                $image_path = $destination;
            } else {
                $response['message'] = "Failed to upload image.";
                $canInsert = false;
            }
        }
    }

    if ($canInsert) {
        $stmt = $conn->prepare("INSERT INTO product 
            (serial_no, name, description, price, comp_price, discount, delivery_time, image, category, brand ,coupon, replacement) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "sssddsssssss",
            $serial_no,
            $name,
            $description,
            $price,
            $comp_price,
            $discount,
            $delivery_time,
            $image_path,
            $category,
            $brand,
            $coupon,
            $replacement
        );

        if ($stmt->execute()) {
            $response = ['success' => true, 'message' => " Product added successfully!"];
        } else {
            $response['message'] = "Database error: " . $stmt->error;
        }
        $stmt->close();
    }
}

echo json_encode($response);
exit;
?>
