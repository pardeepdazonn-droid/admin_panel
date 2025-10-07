<?php
include_once('header/header.php');
$redirect = $_GET['redirect'] ?? 'index.php';
$id = $_GET['id'] ?? '';
?>
<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%; border-radius: 15px;">
    <h3 class="text-center mb-4 text-primary">
      <i class="bi bi-person-circle"></i> Login
    </h3>

    <form id="loginForm">
      
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
      </div>

      
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
      </div>

      
      <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect) ?>">
      <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

      
      <button type="submit" class="btn btn-primary w-100">
        <i class="bi bi-box-arrow-in-right"></i> Login
      </button>
    </form>

    
    <div id="loginMessage" class="mt-3 text-center"></div>

    <div class="text-center mt-3">
      <small>
        Don’t have an account? <a href="user_registerForm.php" class="text-decoration-none">Sign Up</a>
      </small>
    </div>
  </div>
</div>


<script>
document.getElementById("loginForm").addEventListener("submit", async function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    const res = await fetch("user_login.php", { method: "POST", body: formData });
    const data = await res.json();
    document.getElementById("loginMessage").innerText = data.message;

    if (data.success) {
        let redirectUrl = this.querySelector("input[name='redirect']").value;
        let id = this.querySelector("input[name='id']").value;
        if (id) {
            window.location.href = redirectUrl + "?id=" + id;
        } else {
            window.location.href = redirectUrl;
        }
    }
});
</script>
<?php 
include_once('footer/footer.php');
?>