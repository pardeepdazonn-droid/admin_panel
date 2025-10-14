<?php
include('header/header.php');
include_once('header/nav.php');
require_once('fetch_tableData.php');
require_once 'product_model.php';
$products = getAllProducts();
?>

<div class="container-fluid p-4">
  <div class="menu-container d-flex flex-wrap gap-4 justify-content-center">
    <div class="row justify-content-center w-100">
      <?php foreach ($categories_data as $category => $data): ?>
        <div class="col text-center" style="flex: 0 0 100px;">
          <div class="menu position-relative text-center pb-1">
            <img src="<?= htmlspecialchars($data['image']) ?>" alt="<?= htmlspecialchars($category) ?>">
            <a href="#" class="d-block fw-semibold"><?= htmlspecialchars($category) ?></a>
            <ul class="dropdown list-unstyled z-3">
              <?php foreach ($data['subcategories'] as $sub): ?>
                <li><a href="#"><?= htmlspecialchars($sub) ?></a></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>


<div class="container-fluid">
  <div class="row py-5">
<div class="col-2">
<form id="filterForm">
    <div class="filter-sidebar bg-white p-3 rounded shadow-sm">
      <h5 class="filter-title">Category</h5>
      <ul class="list-unstyled">
        <?php foreach ($categories as $index => $category): ?>
          <li>
            <input type="checkbox" id="cat<?= $index ?>" name="categories[]"
              value="<?= $category['category_name'] ?>">
            <label for="cat<?= $index ?>"><?= $category['category_name']; ?></label>
          </li>
        <?php endforeach; ?>
      </ul>

      <hr>

      <h5 class="filter-title">Brand</h5>
      <ul class="list-unstyled">
        <?php foreach ($brands as $index => $brand): ?>
          <li>
            <input type="checkbox" id="brand<?= $index ?>" name="brands[]"
              value="<?= $brand['name'] ?>">
            <label for="brand<?= $index ?>"><?= $brand['name']; ?></label>
          </li>
        <?php endforeach; ?>
      </ul>

      <hr>

      <div class="filter-container">
        <h5 class="filter-title mb-3">Price Range</h5>
        <p class="mb-1">Selected Price: ₹<span id="selectedPrice">100</span></p>
        <input type="range" class="form-range" id="priceRange" name="price" min="1" max="1000" step="1" value="100">
        <div class="d-flex justify-content-between mt-1">
          <span>₹1</span>
          <span>₹1000</span>
        </div>
      </div>

      <hr>

      <h5 class="filter-title">Customer Ratings</h5>
      <ul class="list-unstyled">
        <li><input type="checkbox" id="rating5" name="rating[]" value="5"><label for="rating5">⭐⭐⭐⭐⭐</label></li>
        <li><input type="checkbox" id="rating4" name="rating[]" value="4"><label for="rating4">⭐⭐⭐⭐</label></li>
        <li><input type="checkbox" id="rating3" name="rating[]" value="3"><label for="rating3">⭐⭐⭐</label></li>
        <li><input type="checkbox" id="rating2" name="rating[]" value="2"><label for="rating2">⭐⭐</label></li>
      </ul>

      <hr>

      <h5 class="filter-title">Discount</h5>
      <ul class="list-unstyled">
        <li><input type="checkbox" id="disc1" name="discount[]" value="10"><label for="disc1">10% or more</label></li>
        <li><input type="checkbox" id="disc2" name="discount[]" value="20"><label for="disc2">20% or more</label></li>
        <li><input type="checkbox" id="disc3" name="discount[]" value="30"><label for="disc3">30% or more</label></li>
        <li><input type="checkbox" id="disc4" name="discount[]" value="50"><label for="disc4">50% or more</label></li>
      </ul>

      <hr>

      <h5 class="filter-title">Availability</h5>
      <ul class="list-unstyled">
        <li><input type="checkbox" id="instock" name="availability[]" value="instock"><label for="instock">In Stock</label></li>
        <li><input type="checkbox" id="fastdelivery" name="availability[]" value="fastdelivery"><label for="fastdelivery">Fast Delivery</label></li>
      </ul>

      <button type="submit" class="btn btn-primary w-100 mt-3">Apply Filters</button>
    </div>
</form>
</div>
    <div class="col-10">
  <h3 class="mb-4 fw-bold d-flex align-items-center gap-2">
    <i class="bi bi-grid"></i> 
    <span id="productHeading">All Products</span>
  </h3>

   
  <div id="response" class="row g-4">
    <?php foreach ($products as $p): ?>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card product-card h-100 shadow-sm border-0 z-n1">
          <img src="<?= htmlspecialchars($p['image']) ?>" class="card-img-top rounded-top"
               alt="<?= htmlspecialchars($p['name']) ?>" loading="lazy">
          <div class="card-body d-flex flex-column">
            <h6 class="card-title text-truncate" title="<?= htmlspecialchars($p['name']) ?>">
              <?= htmlspecialchars($p['name']) ?>
            </h6>

            <p class="mb-1">
              <span class="price fw-bold text-success">$<?= $p['price'] ?></span>
              <span class="comp-price text-muted text-decoration-line-through ms-1">$<?= $p['comp_price'] ?></span>
              <span class="discount text-danger ms-1">(<?= $p['discount'] ?>% off)</span>
            </p>

            <p class="text-muted small mb-3">
              <i class="bi bi-truck"></i> <?= htmlspecialchars($p['delivery_time']) ?>
            </p>

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

   
  <div id="allProductsBackup" class="d-none">
    <?php foreach ($products as $p): ?>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card product-card h-100 shadow-sm border-0">
          <img src="<?= htmlspecialchars($p['image']) ?>" class="card-img-top rounded-top"
               alt="<?= htmlspecialchars($p['name']) ?>" loading="lazy">
          <div class="card-body d-flex flex-column">
            <h6 class="card-title text-truncate"><?= htmlspecialchars($p['name']) ?></h6>
            <p class="mb-1">
              <span class="price fw-bold text-success">$<?= $p['price'] ?></span>
              <span class="comp-price text-muted text-decoration-line-through ms-1">$<?= $p['comp_price'] ?></span>
              <span class="discount text-danger ms-1">(<?= $p['discount'] ?>% off)</span>
            </p>
            <p class="text-muted small mb-3">
              <i class="bi bi-truck"></i> <?= htmlspecialchars($p['delivery_time']) ?>
            </p>
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

  </div>
</div>
<script src="//code.tidio.co/tg2mcpylcfn6w6mh0p4yi3v8lswbhycn.js" async></script>
<script src="js/price_filter.js"></script>
<script src="js/filter_formSubmition.js"></script>

<?php
include('footer/bottom.php');
?>