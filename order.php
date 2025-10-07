<?php
include('header/header.php');
require_once 'order_model.php';
$orders = getAllOrders();
?>
<div class="container my-5">
    <h2 class="text-center mb-4">Orders List</h2>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th class="text-center">Order ID</th>
                    <th class="text-center">Customer</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Created At</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td class="text-center"><?= $order['order_id'] ?></td>
                            <td>
                                <strong><?= htmlspecialchars($order['customer_name']) ?></strong><br>
                                <small class="text-muted"><?= htmlspecialchars($order['customer_email']) ?></small>
                            </td>
                            <td class="text-center">
                                <?php if ($order['order_status'] == 'Pending'): ?>
                                    <span class="badge bg-warning text-dark">Pending</span>
                                <?php elseif ($order['order_status'] == 'Completed'): ?>
                                    <span class="badge bg-success">Completed</span>
                                <?php elseif ($order['order_status'] == 'Cancelled'): ?>
                                    <span class="badge bg-danger">Cancelled</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary"><?= $order['order_status'] ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold text-success">$<?= number_format($order['total_amount'], 2) ?></span>
                            </td>
                            <td class="text-center"><?= date("Y-m-d H:i", strtotime($order['created_at'])) ?></td>
                            <td class="text-center">
                                <a href="order_details.php?id=<?= $order['order_id'] ?>" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">No orders found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php 
include('footer/footer.php');
?>
