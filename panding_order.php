<?php
include('header/header.php');
require_once 'order_model.php';
$orders = getPendingOrders();
?>
    <div class="container">
        <h2 class="mb-4">Pending Orders</h2>

        <div class="table-responsive shadow-sm rounded">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Total</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td class="text-center">#<?= $order['order_id'] ?></td>
                                <td><?= htmlspecialchars($order['customer_name']) ?></td>
                                <td><?= htmlspecialchars($order['customer_email']) ?></td>
                                <td><?= htmlspecialchars($order['customer_phone']) ?></td>
                                <td><span class="badge bg-success">$<?= $order['total_amount'] ?></span></td>
                                <td><?= $order['created_at'] ?></td>
                                <td>
                                    <a href="order_details.php?id=<?= $order['order_id'] ?>" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">No pending orders found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php 
include('footer/footer.php');
?>
