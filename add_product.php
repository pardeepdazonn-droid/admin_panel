<?php
include('fetch_tableData.php');
?>
<?php 
include('header/header.php');?>
  <div>
    <div class="text-center mb-4">
      <h5 class="offcanvas-title" id="offcanvasTopLabel">Add your product details</h5>
    </div>
    <div>
      <div id="productForm" style="margin: auto;">
        <div id="responseMessage" class="mt-3"></div>
        <form id="productform" method="post" action="product.php" class="d-flex flex-column gap-3"
          enctype="multipart/form-data">
          <div>
            <label for="serial_no" class="form-label">Serial No</label>
            <input type="text" id="serial_no" name="serial_no" class="form-control" required>
          </div>
          <div>
            <label for="name" class="form-label">Product Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
          </div>
          <div>
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-control" required></textarea>
          </div>
          <div>
            <label for="price" class="form-label">Price</label>
            <input type="number" id="price" name="price" class="form-control" required>
          </div>
          <div>
            <label for="comp_price" class="form-label">compare Price</label>
            <input type="number" id="comp_price" name="comp_price" class="form-control" required>
          </div>
          <div>
            <label for="category" class="form-label">Category</label>
            <select id="category" name="category" class="form-control" required>
              <option value="">Select a category</option>
              <?php foreach ($categories as $category): ?>
                <option value="<?php echo htmlspecialchars($category['category_name']); ?>">
                  <?php echo htmlspecialchars($category['category_name']); ?>

                </option>

              <?php endforeach; ?>
            </select>
          </div>
          <div>
            <label for="brand" class="form_label">Brands</label>
            <select name="brand" id="brand" class="form-control" required>
              <option value="">Select Brand</option>
              <?php foreach ($brands as $brand): ?>
                <option value="<?php echo htmlspecialchars($brand['name']); ?>">
                  <?php echo htmlspecialchars($brand['name']); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div>
            <label for="discount" class="form-label">Discount (%)</label>
            <input type="number" id="discount" name="discount" class="form-control" required>
          </div>
          <div>
            <label for="delivery_time" class="form-label">Delivery Info</label>
            <input type="text" id="delivery_time" name="delivery_time" class="form-control" required>
          </div>
          <div>
            <label for="coupon" class="form-label">Coupon</label>
            <input type="text" id="coupon" name="coupon" class="form-control" required>
          </div>
          <div>
            <label for="replacement" class="form-label">Replacement </label>
            <input type="text" id="replacement" name="replacement" class="form-control" required>
          </div>
          <div>
            <label for="image" class="form-label">Product Image</label>
            <input type="file" id="image" name="image" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-success">Save</button>
        </form>
      </div>
    </div>
  </div>
  <script src="js/ajax.js"></script>
<?php 
include('footer/footer.php');
?>