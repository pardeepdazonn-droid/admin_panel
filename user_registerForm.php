<?php 
include('header/header.php');
?>
<div class="container mt-5">
  <div class="card shadow-lg border-0 rounded-4" style="max-width: 650px; margin: auto;">
    <div class="card-body p-5">
      <h2 class="text-center mb-4 text-primary">
        <i class="bi bi-person-plus-fill"></i> Create Account
      </h2>

      <div id="responseMessage" class="mb-3"></div>

      <form id="registerForm" enctype="multipart/form-data" action="">
        
        <div class="row g-3">
          <div class="col-12">
            <label class="form-label fw-semibold">Full Name</label>
            <input type="text" name="name" class="form-control rounded-3" placeholder="John Doe" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Email</label>
            <input type="email" name="email" class="form-control rounded-3" placeholder="example@email.com" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Password</label>
            <input type="password" name="password" class="form-control rounded-3" placeholder="••••••••" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Phone</label>
            <input type="text" name="phone" class="form-control rounded-3" placeholder="+91 9876543210">
          </div>
        </div>

        
        <h5 class="mt-4 text-secondary border-bottom pb-2">
          <i class="bi bi-geo-alt-fill"></i> Address Information
        </h5>
        <div class="row g-3 mt-1">
          <div class="col-12">
            <label class="form-label fw-semibold">Address Line 1</label>
            <input type="text" name="address_line1" class="form-control rounded-3" placeholder="Street, House No." required>
          </div>
          <div class="col-12">
            <label class="form-label fw-semibold">Address Line 2</label>
            <input type="text" name="address_line2" class="form-control rounded-3" placeholder="Apartment, Landmark (optional)">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">City</label>
            <input type="text" name="city" class="form-control rounded-3" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">State</label>
            <input type="text" name="state" class="form-control rounded-3" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Postal Code</label>
            <input type="text" name="postal_code" class="form-control rounded-3" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Country</label>
            <input type="text" name="country" class="form-control rounded-3" required>
          </div>
        </div>

        <button type="submit" class="btn btn-success btn-lg w-100 mt-4 rounded-3 shadow-sm">
          <i class="bi bi-check-circle-fill"></i> Register
        </button>
      </form>

      <p class="text-center mt-3 mb-0 text-muted">
        Already have an account? <a href="user_loginForm.php" class="text-decoration-none">Login here</a>
      </p>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  $("#registerForm").on("submit", function(e) {
    e.preventDefault();

    $.ajax({
      url: "user.php", 
      type: "POST",
      data: new FormData(this),
      processData: false,
      contentType: false,
      dataType: "json",  
      success: function(response) {
        if (response.success) {
          $("#responseMessage").html(
            '<div class="alert alert-success">' + response.message + '</div>'
          );
          $("#registerForm")[0].reset();
        } else {
          $("#responseMessage").html(
            '<div class="alert alert-danger">' + response.message + '</div>'
          );
        }
      },
      error: function(xhr, status, error) {
        $("#responseMessage").html(
          '<div class="alert alert-danger">AJAX Error: ' + error + '</div>'
        );
      }
    });
  });
});
</script>

<?php 
include('footer/footer.php');
?>
