<?php
session_start();
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="index.php"><i class="bi bi-bag-check"></i> MyShop</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Categories</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
        <?php if(isset($_SESSION['user_id'])):?>
          <li class="nav-items"><a href="user_orders.php" class="nav-link">Orders</a></li>
          <?php endif;?>
      </ul>
      <div class="d-flex align-items-center">
        <?php if (isset($_SESSION['user_id'])): ?>
          <span class="text-light me-3">Hi, <?= htmlspecialchars($_SESSION['user_name']); ?></span>
          <a href="userLogout.php" class="btn btn-sm btn-danger">
            <i class="bi bi-box-arrow-right"></i> Logout
          </a>
        <?php else: ?>
          <a href="user_loginForm.php" class="btn btn-sm btn-outline-light me-2">Login</a>
          <a href="user_registerForm.php" class="btn btn-sm btn-success">Sign Up</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
