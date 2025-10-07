<?php
include('header/header.php');
require_once 'order_model.php';

$order_id = $_GET['id'] ?? 0;
$order = getFullOrderDetails($order_id);
if (!$order) {
    die("Order not found");
}
?>
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Order #<?= $order['order_id'] ?></h2>
    <a href="<?= $_SERVER['HTTP_REFERER'] ?? 'orders.php' ?>" class="btn btn-secondary">
  <i class="bi bi-arrow-left"></i> Back
</a>
  </div>

  <!-- Order Info -->
  <div class="card mb-4 shadow-sm">
    <div class="card-header bg-primary text-white">
      <i class="bi bi-receipt"></i> Order Information
    </div>
    <div class="card-body">
      <p><strong>Customer:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($order['customer_email']) ?></p>
      <p><strong>Phone:</strong> <?= htmlspecialchars($order['customer_phone']) ?></p>
      <p><strong>Status:</strong> 
        <span class="badge bg-info"><?= htmlspecialchars($order['order_status']) ?></span>
      </p>
      <p><strong>Total:</strong> $<?= number_format($order['total_amount'], 2) ?></p>
    </div>
  </div>

  <!-- Order Items -->
  <div class="card mb-4 shadow-sm">
    <div class="card-header bg-dark text-white">
      <i class="bi bi-bag-check"></i> Order Items
    </div>
    <div class="card-body table-responsive">
      <table class="table table-bordered align-middle">
        <thead class="table-light">
          <tr>
            <th>Product</th>
            <th>Serial</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($order['items'] as $item): ?>
            <tr>
              <td><?= htmlspecialchars($item['product_name']) ?></td>
              <td><?= htmlspecialchars($item['serial_no']) ?></td>
              <td><?= $item['quantity'] ?></td>
              <td>$<?= number_format($item['price'], 2) ?></td>
              <td><strong>$<?= number_format($item['price'] * $item['quantity'], 2) ?></strong></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Shipping Info -->
  <div class="card shadow-sm">
    <div class="card-header bg-success text-white">
      <i class="bi bi-truck"></i> Shipping Information
    </div>
    <div class="card-body">
      <?php if ($order['shipping']): ?>
        <p><strong>Address:</strong><br>
          <?= htmlspecialchars($order['shipping']['address_line1']) ?>, 
          <?= htmlspecialchars($order['shipping']['address_line2']) ?><br>
          <?= htmlspecialchars($order['shipping']['city']) ?>, 
          <?= htmlspecialchars($order['shipping']['state']) ?> <?= htmlspecialchars($order['shipping']['postal_code']) ?><br>
          <?= htmlspecialchars($order['shipping']['country']) ?>
        </p>
        <p><strong>Method:</strong> <?= htmlspecialchars($order['shipping']['shipping_method']) ?></p>
        <p><strong>Tracking:</strong> <?= $order['shipping']['tracking_number'] ?: 'N/A' ?></p>
      <?php else: ?>
        <p class="text-muted">No shipping info yet.</p>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php 
include('footer/footer.php');
?>
