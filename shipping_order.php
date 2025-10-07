<?php
include('header/header.php');
require_once 'order_model.php';
$orders = getShippingOrders();
?>
<body class="p-4">
<div class="container">
    <h2 class="mb-4">🚚 Shipping Orders</h2>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Address</th>
                    <th>Method</th>
                    <th>Tracking</th>
                    <th>Shipped At</th>
                    <th>Delivered At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?= $order['order_id'] ?></td>
                            <td><?= htmlspecialchars($order['customer_name']) ?></td>
                            <td class="text-truncate" style="max-width:120px;"><?= htmlspecialchars($order['customer_email']) ?></td>
                            <td><?= htmlspecialchars($order['customer_phone']) ?></td>
                            <td>
                                <span class="badge bg-info"><?= $order['order_status'] ?></span>
                            </td>
                            <td><span class="badge bg-success">$<?= $order['total_amount'] ?></span></td>
                            <td>
                                <?= htmlspecialchars($order['address_line1']) ?>, 
                                <?= htmlspecialchars($order['city']) ?>, 
                                <?= htmlspecialchars($order['state']) ?>, 
                                <?= htmlspecialchars($order['country']) ?>
                            </td>
                            <td><?= htmlspecialchars($order['shipping_method']) ?></td>
                            <td class="text-truncate" style="max-width:100px;"><?= $order['tracking_number'] ?: '<span class="text-muted">N/A</span>' ?></td>
                            <td><?= $order['shipped_at'] ?: '<span class="text-muted">Pending</span>' ?></td>
                            <td><?= $order['delivered_at'] ?: '<span class="text-muted">Pending</span>' ?></td>
                            <td>
                                <a href="order_details.php?id=<?= $order['order_id'] ?>" 
                                   class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="12" class="text-center text-muted py-3">
                            No shipping orders found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php 
include('footer/footer.php');
?>
