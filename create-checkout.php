<?php 
include('header/header.php');
?>
<button type="button" class="btn btn-warning btn-lg" data-bs-toggle="modal" data-bs-target="#checkoutModal">
  Buy Now
</button>

<!-- Checkout Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
    
      <div class="modal-header">
        <h5 class="modal-title" id="checkoutModalLabel">Confirm Your Order</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center mb-3">
          <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" 
               style="width:80px;height:80px;object-fit:cover;" class="me-3 rounded border">
          <div>
            <h6 class="mb-1"><?= htmlspecialchars($product['name']) ?></h6>
            <p class="mb-1 text-muted">₹<?= $product['price'] ?></p>
            <label for="modalQty" class="form-label">Quantity:</label>
            <input type="number" id="modalQty" class="form-control" style="width:100px;" value="1" min="1">
          </div>
        </div>
        <div class="alert alert-info">
          <strong>Total:</strong> <span id="totalPrice">₹<?= $product['price'] ?></span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="proceedPayment" class="btn btn-success">Proceed to Payment</button>
      </div>
    </div>
  </div>
</div>

<!-- Stripe Script -->
<script src="https://js.stripe.com/v3/"></script>
<script>
const stripe = Stripe("pk_test_your_public_key"); // Replace with your key
const basePrice = <?= $product['price'] ?>;

document.getElementById("modalQty").addEventListener("input", function() {
  let qty = this.value;
  document.getElementById("totalPrice").textContent = "₹" + (basePrice * qty);
});

document.getElementById("proceedPayment").addEventListener("click", function () {
  const quantity = document.getElementById("modalQty").value;

  fetch("create-checkout.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      product_id: <?= $product['product_id'] ?>,
      quantity: quantity
    })
  })
  .then(res => res.json())
  .then(session => {
    if (session.error) {
      alert(session.error);
    } else {
      return stripe.redirectToCheckout({ sessionId: session.id });
    }
  })
  .catch(err => console.error("Stripe error:", err));
});
</script>
<?php 
include('footer/footer.php');
?>