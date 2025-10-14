<?php

include('conn.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $subcategory_name = $_POST['sub_category'];
    $subcategory_slug = $_POST['subcategory_slug'];
    $category_id = $_POST['category_id'];
    $subcategory_description = $_POST['subcategory_description'];
    $status = $_POST['status'];
    $subcategory_img = $_FILES['subcategory_img'] ?? null;
    if (empty($subcategory_name) || empty($category_id) || empty($status)) {
        echo json_encode([
            "status" => "error",
            "message" => "please fill all filleds"
        ]);
        exit;
    }
    $max_size = 5 * 1024 * 1024;
    $allowed_img = ['image/png', 'image/gif', 'image/webp', 'image/jpeg'];
    if ($subcategory_img['size'] > $max_size) {
        echo json_encode([
            "status" => "error",
            "message" => "file is too large upload below 5mb"
        ]);
        exit;
    }
    $img_mime = mime_content_type($subcategory_img['tmp_name']);
    if (!in_array($img_mime, $allowed_img)) {
        echo json_encode([
            "status" => "error",
            "message" => "invalid file type only; jpg, png, gif, and webp are allowed"
        ]);
        exit;
    }
    if ($subcategory_img && $subcategory_img['error'] == 0) {
        $img_dir = "uploads/subcategory/";
        $img_exe = strtolower(pathinfo($subcategory_img['name'], PATHINFO_EXTENSION));
        $img_name = time() . '.' . $img_exe;
        $img_path = $img_dir . $img_name;
        if (!is_dir($img_dir)) {
            mkdir($img_dir, 0777, true);
        }
        ;
        if (!move_uploaded_file($subcategory_img['tmp_name'], $img_path)) {
            echo json_encode([
                "status" => "error",
                "message" => "Failed to move file "
            ]);
            exit;
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "No file uploaded or an error occurred"
        ]);
        exit;
    }
    if (empty($subcategory_slug)) {
        $subcategory_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $subcategory_name)));
    }
    $stmt = $conn->prepare("INSERT INTO sub_category (category_id, subcategory_name, subcategory_slug, subcategory_description, status, subcategory_img, created_at) VALUES(?,?,?,?,?,?, NOW())");
    $stmt->bind_param("isssis", $category_id, $subcategory_name, $subcategory_slug, $subcategory_description, $status, $img_name);
    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Sub category is added successfully"
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Database insertion failed" . $stmt->error
        ]);
    }


}
?>