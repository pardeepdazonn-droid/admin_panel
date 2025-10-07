<?php
include 'conn.php';
header('Content-Type: application/json');
$response = ['success' => false, 'message' => 'An unknown error occurred.'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'] ?? '';
    $product_category = $_POST['category_slug'] ?? '';
    $product_des = $_POST['product_des'] ?? '';
    $image_path = "";
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $image_tmp_name = $_FILES['product_image']['tmp_name'];
        $image_name = $_FILES['product_image']['name'];
        $image_size = $_FILES['product_image']['size'];
        $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (!in_array($image_ext, $allowed_extensions)) {
            $response['message'] = "Invalid file type. Only jpg, jpeg, png, gif, webp allowed";
        } elseif ($image_size > 5000000) {
            $response['message'] = "File size exceeds limit (5MB)";
        } else {
            $new_image_name = uniqid() . '.' . $image_ext;
            $upload_dir = 'uploads/';
            $destination = $upload_dir . $new_image_name;

            if (move_uploaded_file($image_tmp_name, $destination)) {
                $image_path = $new_image_name;
            } else {
                $response['message'] = "Failed to upload image.";
            }
        }
    }
    if ($response['success'] === false && $response['message'] !== 'An unknown error occurred.') {

    } else {
    
        $stmt = $conn->prepare("INSERT INTO product_category(category_name, slug, description, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $product_name, $product_category, $product_des, $image_path);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = "Category added successfully!";
        } else {
            $response['message'] = "Database Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

echo json_encode($response);
exit;
?>
