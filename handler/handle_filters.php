<?php
include('../conn.php');  
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
$where = [];
$errors = [];
if (!empty($_POST['categories']) && is_array($_POST['categories'])) {
    $categories = array_filter($_POST['categories'], fn($c) => !empty($c));
    if ($categories) {
        $categories = array_map([$conn, 'real_escape_string'], $categories);
        $quoted = array_map(fn($c) => "'$c'", $categories);
        $where[] = "category IN (" . implode(',', $quoted) . ")";
    }
} elseif (isset($_POST['categories'])) {
    $errors[] = "Categories must be an array.";
}
if (!empty($_POST['brands']) && is_array($_POST['brands'])) {
    $brands = array_filter($_POST['brands'], fn($b) => !empty($b));
    if ($brands) {
        $brands = array_map([$conn, 'real_escape_string'], $brands);
        $quoted = array_map(fn($b) => "'$b'", $brands);
        $where[] = "brand IN (" . implode(',', $quoted) . ")";
    }
} elseif (isset($_POST['brands'])) {
    $errors[] = "Brands must be an array.";
}
if (isset($_POST['price'])) {
    if (is_numeric($_POST['price'])) {
        $price = (float)$_POST['price'];
        $where[] = "price <= $price";
    } else {
        $errors[] = "Price must be a number.";
    }
}
if (!empty($_POST['discount']) && is_array($_POST['discount'])) {
    $discounts = array_filter($_POST['discount'], fn($d) => is_numeric($d));
    if ($discounts) {
        $discountConditions = [];
        foreach ($discounts as $d) {
            $discountConditions[] = "discount >= " . intval($d);
        }
        $where[] = "(" . implode(' OR ', $discountConditions) . ")";
    }
} elseif (isset($_POST['discount'])) {
    $errors[] = "Discounts must be an array of numbers.";
}
if ($errors) {
    echo "<h3>Errors:</h3><ul>";
    foreach ($errors as $err) {
        echo "<li>" . htmlspecialchars($err) . "</li>";
    }
    echo "</ul>";
    exit;
}
$sql = "SELECT * FROM product";
if ($where) {
    $sql .= " WHERE " . implode(' AND ', $where);
}
$result = $conn->query($sql);
if (!$result) {
    die("Query failed: " . $conn->error);
}
if ($result->num_rows > 0) {
    echo '<div class="row g-4">';
    while ($row = $result->fetch_assoc()) {
        ?>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card product-card h-100">
                <img src="<?= htmlspecialchars($row['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['name']) ?>">
                <div class="card-body d-flex flex-column">
                    <h6 class="card-title"><?= htmlspecialchars($row['name']) ?></h6>
                    <p class="mb-1">
                        <?php if (!empty($row['price'])): ?>
                            <span class="price">₹<?= number_format($row['price'], 2) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($row['comp_price'])): ?>
                            <span class="comp-price">₹<?= number_format($row['comp_price'], 2) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($row['discount'])): ?>
                            <span class="discount">(<?= $row['discount'] ?>% off)</span>
                        <?php endif; ?>
                    </p>
                    <?php if (!empty($row['delivery_time'])): ?>
                        <p class="text-muted small mb-3"><i class="bi bi-truck"></i> <?= htmlspecialchars($row['delivery_time']) ?></p>
                    <?php endif; ?>
                    <div class="mt-auto d-flex justify-content-between">
                        <a href="buy.php?id=<?= $row['product_id'] ?>" class="btn btn-sm btn-warning">
                            <i class="bi bi-lightning-charge-fill"></i> Buy Now
                        </a>
                        <button class="btn btn-sm btn-outline-primary add-to-cart" data-id="<?= $row['product_id'] ?>">
                            <i class="bi bi-cart-plus"></i> Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    echo '</div>';
}
 else {
    echo "<p>No products found matching your filters.</p>";
}
?>
