<section class="d-flex justify-content-between flex-column h-100">
<?php
include('header/header.php');
include_once('header/nav.php');
require_once 'product_model.php';
require_once 'conn.php';
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to view this page.");
}
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT name, email, phone FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

$stmt = $conn->prepare("SELECT * FROM user_address WHERE user_id = ? LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$address = $stmt->get_result()->fetch_assoc();
$stmt->close();

$product_id = $_POST['product_id'] ?? $_GET['id'] ?? null;
if (!$product_id)
    die("Product not found");

$product_id = (int)$product_id;
$product = getProductById($product_id);
if (!$product)
    die("Product not found");

$quantity = $_POST['quantity'];
$total_product_price = $product['price'] * $quantity;
 
function gst_include($total_product_price){
    $after_gst=$total_product_price+($total_product_price*18/100);
    return $after_gst;
}
$gst_include_price=gst_include($total_product_price);
 
$customer_address = $address['city']; 
$customer_address = $address['address_line1'] . ', ' . 
                    $address['address_line2'] . ', ' . 
                    $address['city'] . ', ' . 
                    $address['state'] . ', ' . 
                    $address['postal_code'] . ', ' . 
                    $address['country'];

include('distence.php'); 

$discount=$product['discount'];
 
function total($total_product_price, $shipping_fee, $discount, $gst_include_price){

    $total=($shipping_fee+$gst_include_price)-$discount;
    return $total;

}
$total_price=total($total_product_price, $shipping_fee, $discount, $gst_include_price);
 

?>

<div class="container py-5">
    <div id="orderMessage"></div>

    <div class="row g-4 justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title mb-3">Product Details</h4>
                    <div class="d-flex align-items-center gap-3">
                        <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="img-fluid rounded" style="width:120px; height:120px; object-fit:cover;">
                        <div>
                            <h5 class="mb-1"><?= htmlspecialchars($product['name']) ?></h5>
                            <p class="mb-1 text-muted">Brand: <?= htmlspecialchars($product['brand']) ?></p>
                            <p class="mb-1 text-muted">Category: <?= htmlspecialchars($product['category']) ?></p>
                            <p class="mb-0"><strong>Sub Total:</strong> <?= number_format($total_product_price, 2) ?></p>
                            <p class="mb-0"><strong>Gst include:</strong>18%</p>
                            <p class="mb-0"><strong>Shipping fee:</strong> <?= number_format($shipping_fee, 2) ?></p>
                            <p class="mb-0"><strong>Discount:</strong> <?= number_format($product['discount'], 2) ?></p>
                            <p class="mb-0"><strong>Total:</strong> <?= number_format($total_price, 2) ?></p>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title mb-3">Shipping Address</h4>
                    <div id="shippingInfo">
                        <?php if ($address): ?>
                            <p class="mb-1"><strong>Name:</strong> <?= htmlspecialchars($user['name']) ?></p>
                            <p class="mb-1"><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></p>
                            <p class="mb-1"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                            <p class="mb-1"><strong>Address:</strong>
                                <?= htmlspecialchars($address['address_line1']) ?>,
                                <?= htmlspecialchars($address['address_line2']) ?>,
                                <?= htmlspecialchars($address['city']) ?>,
                                <?= htmlspecialchars($address['state']) ?>,
                                <?= htmlspecialchars($address['postal_code']) ?>,
                                <?= htmlspecialchars($address['country']) ?>
                            </p>
                        <?php else: ?>
                            <p class="text-danger">No shipping address found.</p>
                        <?php endif; ?>
                    </div>
                    <button class="btn btn-outline-primary mt-2" id="editAddressBtn">Change Shipping Address</button>

                    <div id="addressFormContainer" class="mt-3" style="display:none;">
                        <form id="addressForm">
                            <input type="text" name="address_line1" class="form-control mb-2" placeholder="Address Line 1" value="<?= htmlspecialchars($address['address_line1'] ?? '') ?>" required>
                            <input type="text" name="address_line2" class="form-control mb-2" placeholder="Address Line 2" value="<?= htmlspecialchars($address['address_line2'] ?? '') ?>">
                            <input type="text" name="city" class="form-control mb-2" placeholder="City" value="<?= htmlspecialchars($address['city'] ?? '') ?>" required>
                            <input type="text" name="state" class="form-control mb-2" placeholder="State" value="<?= htmlspecialchars($address['state'] ?? '') ?>" required>
                            <input type="text" name="postal_code" class="form-control mb-2" placeholder="Postal Code" value="<?= htmlspecialchars($address['postal_code'] ?? '') ?>" required>
                            <input type="text" name="country" class="form-control mb-2" placeholder="Country" value="<?= htmlspecialchars($address['country'] ?? '') ?>" required>
                            <button type="submit" class="btn btn-primary w-100">Save Address</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-md-6 text-center">
            <form method="POST" action="payment_script.php">
                <input type="hidden" name="product_id" value="<?= $product_id ?>">
                <input type="hidden" name="quantity" value="<?= $quantity?>">
                <button type="submit" class="btn btn-success btn-lg w-100">
                    <i class="bi bi-bag-check-fill"></i> Place Order
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('editAddressBtn').addEventListener('click', function () {
    const formContainer = document.getElementById('addressFormContainer');
    formContainer.style.display = formContainer.style.display === 'none' ? 'block' : 'none';
});

document.getElementById('addressForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('edit_shipping.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            if (data.html) document.getElementById('shippingInfo').innerHTML = data.html;
            document.getElementById('orderMessage').innerHTML = `<div class="alert alert-success mt-3">${data.message}</div>`;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } else {
            alert(data.message);
        }
    })
    .catch(err => console.error(err));
});
</script>

<?php include('footer/bottom.php'); ?>
</section>
