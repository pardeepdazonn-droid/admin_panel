<?php
include('header/header.php');
require 'conn.php';

if (!isset($_GET['token']) || empty($_GET['token'])) {
    die("Invalid request. No token.");
}
$token = $_GET['token'];
$stmt = $conn->prepare("SELECT admin_id, reset_expires FROM admin WHERE reset_token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    die("Invalid token. Not found.");
}

if (strtotime($user['reset_expires']) < time()) {
    die("Token expired. Please request a new one.");
}
?>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card p-4">
        <h3 class="text-center mb-3">Reset Your Password</h3>
        <form method="post" action="update_password.php">
          <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
          <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" class="form-control" name="password" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" class="form-control" name="confirm_password" required>
          </div>
          <button type="submit" class="btn btn-success w-100">Update Password</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php 
include('footer/footer.php');
?>
