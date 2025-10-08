<section style="min-height:100vh;" class="d-flex justify-content-between flex-column">
<?php
include('header/header.php');
include_once('header/nav.php');
require_once 'product_model.php';
$id = $_GET['id'] ?? 0;
$product = getProductById($id);
if (!$product) die("Product not found");
?>
<div class="container py-5">
    <div class="row g-5">
        <div class="col-md-5 text-center">
            <div class="border rounded p-3 bg-white shadow-sm">
                <img src="<?= htmlspecialchars($product['image']) ?>" class="img-fluid w-100 h-100" alt="<?= htmlspecialchars($product['name']) ?>">
            </div>
        </div>

        <div class="col-md-7">
            <h2 class="fw-bold"><?= htmlspecialchars($product['name']) ?></h2>
            <p class="text-muted mb-1">
                Brand: <strong><?= htmlspecialchars($product['brand']) ?></strong> |
                Category: <strong><?= htmlspecialchars($product['category']) ?></strong>
            </p>

            <div class="mb-3">
                <span class="badge bg-success me-2">4.3 ★</span>
                <small class="text-muted">12,345 Ratings & 1,234 Reviews</small>
            </div>

            <div class="mb-3">
                <span class="fs-2 fw-bold text-dark">$<?= $product['price'] ?></span>
                <span class="fs-5 text-muted text-decoration-line-through ms-2">$<?= $product['comp_price'] ?></span>
                <span class="fs-5 text-success ms-2">(<?= $product['discount'] ?>% off)</span>
            </div>

            <p class="mb-3"><?= nl2br(htmlspecialchars($product['description'])) ?></p>

            <div class="mb-3">
                <h6 class="fw-bold">Available Offers</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><i class="bi bi-tag-fill text-success"></i> <span class="text-black"><?= htmlspecialchars($product['coupon']) ?></span></li>
                    <li class="mb-2"><i class="bi bi-truck text-primary"></i> <span class="text-black"><?= htmlspecialchars($product['delivery_time']) ?></span></li>
                    <li><i class="bi bi-arrow-repeat text-warning"></i> <span class="text-black"><?= htmlspecialchars($product['replacement']) ?></span></li>
                </ul>
            </div>

            <form method="post" action="user_checkout.php">
                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                <div class="mb-3 d-flex align-items-center">
                    <label for="qty" class="form-label me-2 mb-0 fw-semibold">Quantity:</label>
                    <input type="number" name="quantity" id="qty" value="1" min="1" class="form-control me-3" style="width:100px;">
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-success btn-lg px-4 shadow-sm">Buy Now</button>
                    <button type="button" class="btn btn-outline-secondary btn-lg px-4 shadow-sm">
                        <i class="bi bi-cart-fill"></i> Add to Cart
                    </button>
                </div>
            </form>

            <div class="mt-3">
                <a href="index.php" class="text-decoration-none">&larr; Back to products</a>
            </div>
        </div>
    </div>
</div>

<?php
include('footer/bottom.php');
?>
</section>
