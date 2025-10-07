<?php 
include('header/header.php');
?>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card p-4">
        <h3 class="text-center mb-3">Forgot Password</h3>
        <form method="post" action="send_reset.php">
          <div class="mb-3">
            <label class="form-label">Enter your email</label>
            <input type="email" class="form-control" name="email" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php 
include('footer/footer.php');
?>
