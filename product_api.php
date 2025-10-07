<?php
header('Content-Type: application/json');
include_once 'product_model.php';

$action = $_POST['action'] ?? $_GET['action'] ?? null;

switch ($action) {
    case 'get':
        $id = intval($_GET['id'] ?? 0);
        if ($id > 0) {
            $product = getProductById($id);
            echo json_encode(['success' => true, 'data' => $product]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid ID']);
        }
        break;

    case 'update':
        $id = intval($_POST['id'] ?? 0);
        if ($id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid ID']);
            exit;
        }

        $serial_no     = $_POST['serial_no'] ?? '';
        $name          = $_POST['name'] ?? '';
        $description   = $_POST['description'] ?? '';
        $price         = floatval($_POST['price'] ?? 0);
        $comp_price    = floatval($_POST['comp_price'] ?? 0);
        $discount      = floatval($_POST['discount'] ?? 0);
        $delivery_time = $_POST['delivery_time'] ?? '';
        $category      = $_POST['category'] ?? '';
        $brand         = $_POST['brand'] ?? '';
        $coupon        = $_POST['coupon'] ?? '';
        $replacement   = $_POST['replacement'] ?? '';
        $image_path    = null;

    
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_name = $_FILES['image']['name'];
            $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
            $allowed = ['jpg','jpeg','png','gif','webp'];
            if (in_array($ext, $allowed)) {
                $new_name = uniqid().".".$ext;
                $dest = "uploads/".$new_name;
                if (move_uploaded_file($image_tmp_name, $dest)) {
                    $image_path = $dest;
                }
            }
        }

        $updated = updateProduct($id, $serial_no, $name, $description, $price, $comp_price, $discount, $delivery_time, $category, $brand, $coupon, $replacement, $image_path);

        if ($updated) {
            echo json_encode(['success' => true, 'message' => 'Product updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update product']);
        }
        break;

    case 'delete':
        $id = intval($_POST['id'] ?? 0);
        if ($id > 0 && deleteProduct($id)) {
            echo json_encode(['success' => true, 'message' => 'Product deleted']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Delete failed']);
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}
