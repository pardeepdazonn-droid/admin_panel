<?php
include('header/header.php');
include('product_model.php');
include('fetch_tableData.php');

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "Invalid Product ID";
    exit;
}

$product = getProductById($id);
if (!$product) {
    echo "Product not found";
    exit;
}
?>
  <div class="container py-4">
 
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-semibold">Update Product Details</h4>
    <button type="button" class="btn-close" aria-label="Close" onclick="window.history.back()"></button>
  </div>

  <div class="card shadow p-4">
<form id="form" enctype="multipart/form-data">
      <div class="row g-3">

        <div class="col-md-6">
          <label for="serial_no" class="form-label">Serial No</label>
          <input type="text" id="serial_no" name="serial_no" class="form-control"
                 value="<?= htmlspecialchars($product['serial_no']) ?>" required>
        </div>

        <div class="col-md-6">
          <label for="name" class="form-label">Product Name</label>
          <input type="text" id="name" name="name" class="form-control"
                 value="<?= htmlspecialchars($product['name']) ?>" required>
        </div>

        <div class="col-12">
          <label for="description" class="form-label">Description</label>
          <textarea id="description" name="description" class="form-control" rows="3" required><?= htmlspecialchars($product['description']) ?></textarea>
        </div>

        <div class="col-md-4">
          <label for="price" class="form-label">Price</label>
          <input type="number" id="price" name="price" step="0.01" class="form-control"
                 value="<?= htmlspecialchars($product['price']) ?>" required>
        </div>

        <div class="col-md-4">
          <label for="comp_price" class="form-label">Compare Price</label>
          <input type="number" id="comp_price" name="comp_price" step="0.01" class="form-control"
                 value="<?= htmlspecialchars($product['comp_price']) ?>" required>
        </div>

        <div class="col-md-4">
          <label for="discount" class="form-label">Discount (%)</label>
          <input type="number" id="discount" name="discount" class="form-control"
                 value="<?= htmlspecialchars($product['discount']) ?>" required>
        </div>

        <div class="col-md-6">
          <label for="category" class="form-label">Category</label>
          <select id="category" name="category" class="form-select" required>
            <option value="">Select a category</option>
            <?php foreach ($categories as $cat): ?>
              <option value="<?= htmlspecialchars($cat['category_name']) ?>"
                <?= $product['category'] == $cat['category_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['category_name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-6">
          <label for="brand" class="form-label">Brand</label>
          <select name="brand" id="brand" class="form-select" required>
            <option value="">Select Brand</option>
            <?php foreach ($brands as $br): ?>
              <option value="<?= htmlspecialchars($br['name']) ?>"
                <?= $product['brand'] == $br['brand_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($br['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-6">
          <label for="delivery_time" class="form-label">Delivery Info</label>
          <input type="text" id="delivery_time" name="delivery_time" class="form-control"
                 value="<?= htmlspecialchars($product['delivery_time']) ?>" required>
        </div>
         <div class="col-md-6">
          <label for="delivery_time" class="form-label">Delivery Info</label>
          <input type="text" id="delivery_time" name="delivery_time" class="form-control"
                 value="<?= htmlspecialchars($product['coupon']) ?>" required>
        </div>
         <div class="col-md-6">
          <label for="delivery_time" class="form-label">Delivery Info</label>
          <input type="text" id="delivery_time" name="delivery_time" class="form-control"
                 value="<?= htmlspecialchars($product['replacement']) ?>" required>
        </div>

        <div class="col-md-6">
          <label for="image" class="form-label">Product Image</label><br>
          <?php if (!empty($product['image'])): ?>
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="Product Image" class="product-img-preview mb-2"><br>
          <?php endif; ?>
          <input type="file" id="image" name="image" class="form-control">
        </div>
          <div id="responseMessage" class="mt-3"></div>
        <div class="col-12 text-end mt-3">
          <button type="submit" class="btn btn-success px-4">Update Product</button>
        </div>

      </div>
    </form>
  </div>
</div>


<script>
document.querySelector("form").addEventListener("submit", async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append("action", "update");
    formData.append("id", "<?= $product['product_id'] ?>"); // Pass ID dynamically

    let response = await fetch("product_api.php", {
        method: "POST",
        body: formData
    });

    let result = await response.json();

    if (result.success) {
        alert(result.message);
    } else {
        alert("Error: " + result.message);
    }
});
</script>
<?php 
include('footer/footer.php');
?>
