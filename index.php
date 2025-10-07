<?php
include('header/header.php');
include_once('header/nav.php');
require_once 'product_model.php';
$products = getAllProducts();
?>
 

<div class="container py-5">
  <h3 class="mb-4 fw-bold"><i class="bi bi-grid"></i> All Products</h3>
  <div class="row g-4">
    <?php foreach ($products as $p): ?>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card product-card h-100">
          <img src="<?= htmlspecialchars($p['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($p['name']) ?>">
          <div class="card-body d-flex flex-column">
            <h6 class="card-title"><?= htmlspecialchars($p['name']) ?></h6>
            <p class="mb-1">
              <span class="price">$<?= $p['price'] ?></span>
              <span class="comp-price">$<?= $p['comp_price'] ?></span>
              <span class="discount">(<?= $p['discount'] ?>% off)</span>
            </p>
            <p class="text-muted small mb-3"><i class="bi bi-truck"></i> <?= htmlspecialchars($p['delivery_time']) ?></p>
            <div class="mt-auto d-flex justify-content-between">
              <a href="buy.php?id=<?= $p['product_id'] ?>" class="btn btn-sm btn-warning">
                <i class="bi bi-lightning-charge-fill"></i> Buy Now
              </a>
              <button class="btn btn-sm btn-outline-primary add-to-cart" data-id="<?= $p['product_id'] ?>">
                <i class="bi bi-cart-plus"></i> Add to Cart
              </button>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
<?php 
include('footer/bottom.php');
?>
