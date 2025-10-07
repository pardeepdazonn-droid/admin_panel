<?php
include('header/header.php'); ?>

<div id="productForm" class="mt-4" style="margin: auto; max-width: 800px;">
  <div class="card shadow p-4 rounded-3">
    <h5 class="text-center mb-3">
      <i class="bi bi-grid text-primary me-2 fs-5"></i> Add Category
    </h5>

    <div id="responseMessage" class="mt-2"></div>

    <form id="productCategoryForm" method="post" action="product_category.php" class="row g-3"
      enctype="multipart/form-data">


      <div class="col-md-6">
        <label for="product_name" class="form-label">
          <i class="bi bi-box me-1 fs-6"></i> Category Name
        </label>
        <input type="text" id="product_name" name="product_name" class="form-control" placeholder="e.g. Electronics"
          required>
      </div>


      <div class="col-md-6">
        <label for="category_slug" class="form-label">
          <i class="bi bi-link-45deg me-1 fs-6"></i> Slug
        </label>
        <input type="text" id="category_slug" name="category_slug" class="form-control" placeholder="e.g. electronics"
          required>
      </div>


      <div class="col-12">
        <label for="product_des" class="form-label">
          <i class="bi bi-card-text me-1 fs-6"></i> Description
        </label>
        <textarea id="product_des" name="product_des" class="form-control" rows="3"
          placeholder="Write a short description..."></textarea>
      </div>


      <div class="col-12">
        <label for="product_image" class="form-label">
          <i class="bi bi-image me-1 fs-6"></i> Category Image
        </label>
        <input type="file" id="product_image" name="product_image" class="form-control">
      </div>


      <div class="col-12 text-center mt-3">
        <button type="submit" class="btn btn-success px-4">
          <i class="bi bi-save me-1"></i> Save Category
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  document.getElementById('productCategoryForm').addEventListener('submit', function (event) {
    event.preventDefault();
    const form = event.target;
    const responseMessage = document.getElementById('responseMessage');
    const formData = new FormData(form);
    fetch(form.action, {
      method: 'POST',
      body: formData,
    })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        responseMessage.innerHTML = '';

        if (data.success) {
          responseMessage.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
          form.reset();

          if (data.redirect) {
            setTimeout(() => {
              window.location.href = data.redirect;
            }, 1000);
          }
        } else {
          responseMessage.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        }
      })
      .catch(error => {
        console.error('Fetch error:', error);
        responseMessage.innerHTML = `<div class="alert alert-danger">An error occurred. Please try again.</div>`;
      });
  });

</script>
<?php
include('footer/footer.php');
?>