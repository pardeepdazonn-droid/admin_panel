<?php
session_start();
include('header/header.php');
?>

 <section class="vh-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #667eea, #764ba2);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <h3 class="text-center mb-4 fw-bold text-primary">
                            <i class="bi bi-shop-window me-2"></i>Vendor Login
                        </h3>

                        <!-- Error or Success -->
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger text-center">
                                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                            </div>
                        <?php endif; ?>
                        <div id="vendorLoginMessage"></div>

                        <!-- Login Form -->
                        <form id="vendorLoginForm" method="post">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 mt-2">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Login
                            </button>
                        </form>

                        <p class="text-center mt-4 mb-0">
                            Don’t have an account? 
                            <a href="venders-auth/vendor_register.php" class="fw-bold text-decoration-none text-primary">Register</a>
                        </p>
                    </div>
                </div>

                <!-- Extra -->
                <div class="text-center mt-3 text-white-50">
                    <small>&copy; <?= date("Y"); ?> MyShop Vendor Portal</small>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.getElementById('vendorLoginForm').addEventListener('submit', function(e) {
    e.preventDefault(); 
    const form = e.target;
    const formData = new FormData(form);

    fetch('venders-auth/vendor_login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const msgDiv = document.getElementById('vendorLoginMessage');
        if(data.success){
            msgDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                                                                                                 
            setTimeout(() => {
                window.location.href = 'vendor_dashboard.php';
            },1000);
        } else {
            msgDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        }
    })
    .catch(error => {
        console.error(error);
        document.getElementById('vendorLoginMessage').innerHTML = 
            `<div class="alert alert-danger">Something went wrong. Try again.</div>`;
    });
});
</script>
<?php 
include('footer/footer.php');
?>