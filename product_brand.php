<?php
include('conn.php');

header('Content-Type: application/json'); 

$response = [
    'success' => false,
    'message' => 'An unknown error occurred.'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand_name = $_POST['brand_name'] ?? '';
    $brand_slug = $_POST['brand_slug'] ?? '';
    $brand_des  = $_POST['brand_des'] ?? '';
    $brand_image = "";

    // Handle file upload if provided
    if (isset($_FILES['brand_image']) && $_FILES['brand_image']['error'] === UPLOAD_ERR_OK) {
        $image_tmp_name = $_FILES['brand_image']['tmp_name'];
        $image_size     = $_FILES['brand_image']['size'];
        $image_name     = $_FILES['brand_image']['name'];

        $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'png', 'jpeg', 'gif', 'webp'];

        if (!in_array($image_ext, $allowed_extensions)) {
            $response['message'] = "Invalid file type. Only jpg, jpeg, png, gif, webp allowed.";
        } elseif ($image_size > 5000000) { 
            $response['message'] = "File size exceeds limit (5MB).";
        } else {
            $new_image_name = uniqid('', true) . '.' . $image_ext;
            $upload_dir = 'uploads/';
            $destination = $upload_dir . $new_image_name;

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            if (move_uploaded_file($image_tmp_name, $destination)) {
                $brand_image = $new_image_name;
            } else {
                $response['message'] = "Failed to upload image.";
            }
        }
    }
    if ($response['message'] === 'An unknown error occurred.') {
        $stmt = $conn->prepare("INSERT INTO brand (name, slug, image, des) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssss", $brand_name, $brand_slug, $brand_image, $brand_des);
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = "Brand added successfully!";
            } else {
                $response['message'] = "Database error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $response['message'] = "Failed to prepare SQL statement.";
        }
    }
}

echo json_encode($response);
exit;
?>
