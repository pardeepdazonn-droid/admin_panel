<?php
include 'conn.php';
include 'header/header.php';
include 'header/nav.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: user_loginForm.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT o.order_id, o.total_amount, o.order_status, o.created_at, s.address_line1, s.city, s.state, s.postal_code, s.country
    FROM orders o
    LEFT JOIN shipping s ON o.order_id = s.order_id
    WHERE o.customer_email = ?
    ORDER BY o.created_at DESC
");
$stmt->bind_param("s", $_SESSION['user_email']);

$stmt->execute();
$orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<div class="container py-5">
    <h2 class="mb-4">My Orders</h2>

    <?php if (empty($orders)): ?>
        <div class="alert alert-info">You have no orders yet.</div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($orders as $order): ?>
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Order #<?= $order['order_id'] ?></h5>
                                <span class="badge <?= $order['order_status'] == 'pending' ? 'bg-warning' : 'bg-success' ?>">
                                    <?= ucfirst($order['order_status']) ?>
                                </span>
                            </div>
                            <small class="text-muted">Placed on: <?= date('d M, Y', strtotime($order['created_at'])) ?></small>

                            <div class="mt-3">
                                <strong>Total Amount:</strong> $<?= number_format($order['total_amount'], 2) ?>
                            </div>

                            <div class="mt-2">
                                <strong>Shipping Address:</strong>
                                <p class="mb-0">
                                    <?= htmlspecialchars($order['address_line1']) ?>, <?= htmlspecialchars($order['city']) ?>,
                                    <?= htmlspecialchars($order['state']) ?>, <?= htmlspecialchars($order['postal_code']) ?>,
                                    <?= htmlspecialchars($order['country']) ?>
                                </p>
                            </div>

                            <div class="mt-3 text-end">
                                <a href="order_details.php?order_id=<?= $order['order_id'] ?>" class="btn btn-primary btn-sm">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include('footer/bottom.php'); ?>