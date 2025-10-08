<?php
include('header/header.php');
include_once('fetch_tableData.php');
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2 d-flex flex-column sidebar">
            <div class="mb-4 text-center">
                <img src="images/admin-logo.png" alt="Admin Logo" style="max-height: 80px;" class="img-fluid" />
            </div>
            <nav>
                <ul class="list-unstyled">

                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a href="#dashboard" class="nav-link active text-light"><i class="bi bi-speedometer2 me-2"></i>
                            Dashboard</a>
                    </li>

                    <!-- Products -->
                    <li class="nav-item">
                        <a class="nav-link text-light d-flex justify-content-between align-items-center"
                            data-bs-toggle="collapse" href="#productsMenu" role="button" aria-expanded="false">
                            <span><i class="bi bi-box-seam me-2"></i> Products</span>
                            <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul class="collapse list-unstyled ps-3" id="productsMenu">
                            <li><a href="product_list.php" class="nav-link py-1 load-content">Product List</a></li>
                            <li><a href="add_product.php" class="nav-link py-1 load-content">Add Product</a></li>
                            <li><a href="add_category.php" class="nav-link py-1 load-content">Add Categories</a></li>
                            <li><a href="add_brands.php" class="nav-link py-1 load-content">Brands</a></li>
                        </ul>
                    </li>

                    <!-- Orders -->
                    <li class="nav-item">
                        <a class="nav-link text-light d-flex justify-content-between align-items-center"
                            data-bs-toggle="collapse" href="#ordersMenu" role="button" aria-expanded="false">
                            <span><i class="bi bi-receipt-cutoff me-2"></i> Orders</span>
                            <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul class="collapse list-unstyled ps-3" id="ordersMenu">
                            <li><a href="order.php" class="nav-link py-1 load-content">All Orders</a></li>
                            <li><a href="panding_order.php" class="nav-link py-1 load-content">Pending Orders</a></li>
                            <li><a href="shipping_order.php" class="nav-link py-1 load-content">Shipped Orders</a></li>
                        </ul>
                    </li>

                    <!-- Customers -->
                    <li class="nav-item">
                        <a class="nav-link text-light d-flex justify-content-between align-items-center"
                            data-bs-toggle="collapse" href="#customersMenu" role="button" aria-expanded="false">
                            <span><i class="bi bi-people me-2"></i> Customers</span>
                            <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul class="collapse list-unstyled ps-3" id="customersMenu">
                            <li><a href="users.php" class="nav-link py-1 load-content">Customer List</a></li>
                            <li><a href="#" class="nav-link py-1">Feedback</a></li>
                        </ul>
                    </li>

                    <!-- Marketing -->
                    <li class="nav-item">
                        <a class="nav-link text-light d-flex justify-content-between align-items-center"
                            data-bs-toggle="collapse" href="#marketingMenu" role="button" aria-expanded="false">
                            <span><i class="bi bi-megaphone me-2"></i> Marketing</span>
                            <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul class="collapse list-unstyled ps-3" id="marketingMenu">
                            <li><a href="#" class="nav-link py-1">Coupons</a></li>
                            <li><a href="#" class="nav-link py-1">Promotions</a></li>
                        </ul>
                    </li>

                    <!-- Reports -->
                    <li class="nav-item">
                        <a href="#" class="nav-link text-light"><i class="bi bi-bar-chart-line me-2"></i> Reports</a>
                    </li>

                    <!-- Settings -->
                    <li class="nav-item">
                        <a class="nav-link text-light d-flex justify-content-between align-items-center"
                            data-bs-toggle="collapse" href="#settingsMenu" role="button" aria-expanded="false">
                            <span><i class="bi bi-gear me-2"></i> Settings</span>
                            <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul class="collapse list-unstyled ps-3" id="settingsMenu">
                            <li><a href="#" class="nav-link py-1">Store Settings</a></li>
                            <li><a href="#" class="nav-link py-1">Payment Settings</a></li>
                            <li><a href="#" class="nav-link py-1">Shipping Settings</a></li>
                        </ul>
                    </li>

                    <!-- Roles -->
                    <li class="nav-item">
                        <a class="nav-link text-light d-flex justify-content-between align-items-center"
                            data-bs-toggle="collapse" href="#rolesMenu" role="button" aria-expanded="false">
                            <span><i class="bi bi-person-badge me-2"></i> Role</span>
                            <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul class="collapse list-unstyled ps-3" id="rolesMenu">
                            <li><a href="sub_adminForm.php" class="nav-link py-1 load-content">Sub Admin</a></li>
                        </ul>
                    </li>

                    <!-- Profile / Logout -->
                    <li class="mt-auto"><a href="#" class="nav-link text-light"><i class="bi bi-person me-2"></i>
                            Profile</a></li>
                    <li><a href="logout.php" class="nav-link text-danger"><i class="bi bi-box-arrow-right me-2"></i>
                            Logout</a></li>
                </ul>
            </nav>

        </div>
        <div class="col-lg-10 content" id="main-content">
            <section id="dashboard" class="mb-5">
                <h3 class="section-title">Dashboard Overview</h3>
                <div class="row g-4">
                    <div class="col-md-3">
                        <div class="card p-3 text-white bg-primary">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h4>Total Products: <p class="mt-3"><i
                                                class="bi bi-box-seam fs-1 opacity-75 me-3"></i> <span
                                                id="totalProducts" class="fs-1"></span></p>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card p-3 text-white bg-success">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h4>Total category: <p class="mt-3"><i
                                                class="bi bi-basket3 fs-1 opacity-75 me-3"></i> <span
                                                id="totalCategories" class="fs-1"></span></p>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card p-3 text-white bg-warning">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h4>Total revenue: <p class="mt-3"><i
                                                class="bi bi-currency-dollar fs-1 opacity-75 me-3"></i> <span
                                                id="totalRevenue" class="fs-3"></span></p>
                                    </h4>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card p-3 text-white bg-danger">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h4>Total pending: <p class="mt-3"><i
                                                class="bi bi-clock-history fs-1 opacity-75 me-3"></i> <span
                                                id="totalPending" class="fs-1"></span></p>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <canvas id="salesChart" style="height:400px; width:100%"></canvas>
                    </div>
                    <div class="col-6">
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <canvas id="productsChart" style="height:400px; width:100%"></canvas>
                    </div>
                </div>
            </section>
            <script src="js/content-loader.js"></script>
            <script src="js/revenue_chart.js"></script>
            <script src="js/product_chart.js"></script>
        </div>
    </div>
</div>
<?php
include('footer/footer.php');
?>