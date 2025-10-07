<?php
include_once('header/header.php');
require_once 'user_model.php';
$users = getAllUser();
?>
<div class="container py-5">
  <h2 class="mb-4">Registered Users</h2>
  <div class="card shadow-sm">
    <div class="card-body">
      <?php if (!empty($users)): ?>
        <div class="table-responsive">
          <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
              <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Created At</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($users as $user): ?>
                <tr>
                  <td><?= htmlspecialchars($user['user_id']) ?></td>
                  <td><?= htmlspecialchars($user['name']) ?></td>
                  <td><?= htmlspecialchars($user['email']) ?></td>
                  <td><?= htmlspecialchars($user['phone']) ?></td>
                  <td><?= htmlspecialchars($user['created_at'] ?? '-') ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <p class="text-muted">No users found.</p>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php 
include('footer/footer.php');
?>
