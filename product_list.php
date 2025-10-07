<?php
include('header/header.php');
require_once 'product_model.php';
$products = getAllProducts();
?>
    <div class="container d-flex flex-column align-items-center ">
        <div class="container my-4">
            <div class="table-responsive shadow-sm rounded">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-truncate text-center">Serial No</th>
                            <th class="text-truncate text-center">Name</th>
                            <th class="text-truncate text-center">Description</th>
                            <th class="text-truncate text-center">Price</th>
                            <th class="text-truncate text-center">Pre Price</th>
                            <th class="text-truncate text-center">Discount</th>
                            <th class="text-truncate text-center">Delivery Time</th>
                            <th class="text-truncate text-center">Category</th>
                            <th class="text-truncate text-center">Brand</th>
                            <th class="text-truncate text-center">Image</th>
                            <th class="text-truncate text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $row): ?>
                                <tr>
                                    <td class="text-center"><?= htmlspecialchars($row['serial_no']) ?></td>
                                    <td class="text-truncate"><?= htmlspecialchars($row['name']) ?></td>
                                    <td class="text-truncate" style="max-width: 140px;">
                                        <?= htmlspecialchars($row['description']) ?>
                                    </td>
                                    <td class="text-center"><span
                                            class="badge bg-success">$<?= htmlspecialchars($row['price']) ?></span></td>
                                    <td class="text-center"><span
                                            class="text-decoration-line-through text-muted">$<?= htmlspecialchars($row['comp_price']) ?></span>
                                    </td>
                                    <td class="text-center"><span
                                            class="badge bg-warning text-dark"><?= htmlspecialchars($row['discount']) ?>%</span>
                                    </td>
                                    <td class="text-center"><?= htmlspecialchars($row['delivery_time']) ?> Days</td>
                                    <td class="text-center"><?= htmlspecialchars($row['category']) ?></td>
                                    <td class="text-center"><?= htmlspecialchars($row['brand']) ?></td>
                                    <td>
                                        <?php if (!empty($row['image'])): ?>
                                            <img src="<?= htmlspecialchars($row['image']) ?>" alt="Image"
                                                class="img-fluid rounded-3" style="width: 60px; height: 50px;">
                                        <?php else: ?>
                                            <span class="text-muted">No Image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="edit_product.php?id=<?= $row['product_id'] ?>"
                                                class="btn btn-sm btn-primary p-2">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger p-2 delete-btn"
                                                data-id="<?= htmlspecialchars($row['product_id'], ENT_QUOTES) ?>"
                                                title="Delete product">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="11" class="text-center text-muted py-3">No products found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <script>
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.delete-btn');
            if (!btn) return;

            const id = btn.dataset.id;
            if (!id) return alert('Missing product id');

            if (!confirm('Are you sure you want to delete this product?')) return;

            btn.disabled = true;
            const original = btn.innerHTML;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

            fetch('delete_row.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'id=' + encodeURIComponent(id)
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        btn.closest('tr').remove();
                    } else {
                        alert(data.error || 'Delete failed');
                        btn.disabled = false;
                        btn.innerHTML = original;
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Error: ' + err.message);
                    btn.disabled = false;
                    btn.innerHTML = original;
                });
        });
    </script>
<?php 
include('footer/footer.php');
?>