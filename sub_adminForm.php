<?php 
include('header/header.php');
?>
    <div class="container py-5">
        <h2 class="mb-4 text-center"><i class="bi bi-person-gear"></i> Sub-Admin Management</h2>
        <div id="message"></div>
        <div class="row">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <i class="bi bi-person-plus"></i> Create Sub-Admin
                    </div>
                    <div class="card-body">
                        <form id="subAdminForm" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Profile Image</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>

                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-check2-circle"></i> Create
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <i class="bi bi-list-ul"></i> Sub-Admin List
                    </div>
                    <div class="card-body">
                        <div id="subAdminList">
                            <?php
                            include "conn.php";
                            $sql = "SELECT id, name, username, email, image, status, created_at 
                                    FROM sub_admin ORDER BY id DESC";
                            $result = $conn->query($sql);
                            ?>
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result && $result->num_rows > 0): ?>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= $row['id'] ?></td>
                                                <td>
                                                    <?php if (!empty($row['image'])): ?>
                                                        <img src="<?= htmlspecialchars($row['image']) ?>" width="40" height="40" class="rounded-circle">
                                                    <?php else: ?>
                                                        <span class="text-muted">No Image</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= htmlspecialchars($row['name']) ?></td>
                                                <td><?= htmlspecialchars($row['username']) ?></td>
                                                <td><?= htmlspecialchars($row['email']) ?></td>
                                                <td>
                                                    <?php if ($row['status'] == 1): ?>
                                                        <span class="badge bg-success">Active</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Inactive</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= $row['created_at'] ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">No Sub Admins found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function loadList() {
            $("#subAdminList").load("list.php");
        }

        $(document).ready(function () {
            $("#subAdminForm").on("submit", function (e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: "sub_admin.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $("#message").html('<div class="alert alert-success">' + response + '</div>');
                        $("#subAdminForm")[0].reset();
                        loadList();
                    },
                    error: function () {
                        $("#message").html('<div class="alert alert-danger">Error submitting form.</div>');
                    }
                });
            });
        });
    </script>
<?php 
include('footer/footer.php');
?>
