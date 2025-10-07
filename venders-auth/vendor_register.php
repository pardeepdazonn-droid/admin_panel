<?php
session_start();
include('../header/header.php');
?>

<section class="vh-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #36d1dc, #5b86e5);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <h3 class="text-center mb-4 fw-bold text-primary">
                            <i class="bi bi-person-plus me-2"></i>Vendor Registration
                        </h3>

                        <!-- Error & Success Messages -->
                        <?php if(isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger text-center">
                                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                            </div>
                        <?php endif; ?>
                        <?php if(isset($_SESSION['success'])): ?>
                            <div class="alert alert-success text-center">
                                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Registration Form -->
                        <form method="post" action="vendor_register_process.php">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                    <input type="text" name="name" class="form-control" placeholder="Enter your full name" required>
                                </div>
                            </div>

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
                                    <input type="password" name="password" class="form-control" placeholder="Create a password" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-telephone"></i></span>
                                    <input type="text" name="phone" class="form-control" placeholder="Enter phone number" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Company Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-buildings"></i></span>
                                    <input type="text" name="company_name" class="form-control" placeholder="Your company (optional)">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success w-100 py-2 mt-2">
                                <i class="bi bi-check-circle me-1"></i> Register
                            </button>
                        </form>

                        <!-- Already Registered -->
                        <p class="text-center mt-4 mb-0">
                            Already registered? 
                            <a href="../vendors.php" class="fw-bold text-decoration-none text-primary">Login</a>
                        </p>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center mt-3 text-white-50">
                    <small>&copy; <?= date("Y"); ?> Vendor Portal | MyShop</small>
                </div>
            </div>
        </div>
    </div>
</section>
<?php 
include('../footer/footer.php');
?>