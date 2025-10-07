<?php 
include('header/header.php');?>
    <div style="margin: auto; max-width: 800px;" class="mt-4">
  <div class="card shadow p-4 rounded-3">
    <h5 class="text-center mb-3">
      <i class="bi bi-tags text-primary me-2 fs-5"></i> Add Brand
    </h5>

    <div id="responseMessage" class="mt-2"></div>

    <form id="productBrandForm" method="post" action="product_brand.php" 
          class="row g-3" enctype="multipart/form-data">

      <!-- Brand Name -->
      <div class="col-md-6">
        <label for="brand_name" class="form-label">
          <i class="bi bi-tag me-1 fs-6"></i> Brand Name
        </label>
        <input type="text" id="brand_name" name="brand_name" 
               class="form-control" placeholder="e.g. Samsung" required>
      </div>

      <!-- Slug -->
      <div class="col-md-6">
        <label for="brand_slug" class="form-label">
          <i class="bi bi-link-45deg me-1 fs-6"></i> Slug
        </label>
        <input type="text" id="brand_slug" name="brand_slug" 
               class="form-control" placeholder="e.g. samsung" required>
      </div>

      <!-- Description -->
      <div class="col-12">
        <label for="brand_des" class="form-label">
          <i class="bi bi-card-text me-1 fs-6"></i> Description
        </label>
        <textarea id="brand_des" name="brand_des" 
                  class="form-control" rows="3" 
                  placeholder="Write a short description..."></textarea>
      </div>

      <!-- Brand Image -->
      <div class="col-12">
        <label for="brand_image" class="form-label">
          <i class="bi bi-image me-1 fs-6"></i> Brand Image
        </label>
        <input type="file" id="brand_image" name="brand_image" class="form-control">
      </div>

      <!-- Submit -->
      <div class="col-12 text-center mt-3">
        <button type="submit" class="btn btn-success px-4">
          <i class="bi bi-save me-1"></i> Save Brand
        </button>
      </div>
    </form>
  </div>
</div>

<script>
document.getElementById('productBrandForm').addEventListener('submit', function(event) {
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