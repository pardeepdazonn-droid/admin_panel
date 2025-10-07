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
                    <li><a href="#dashboard" class="active"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                    <li><a href="#demo" class="menu-item" data-bs-toggle="collapse" aria-expanded="false"
                            aria-controls="demo"><i class="bi bi-box-seam"></i> Products</a>
                        <ul class="collapse list-unstyled submenu ps-2 mb-3" id="demo">
                            <li><a href="#products-list" class="submenu-item d-block py-1 load-content"
                                    data-page="product_list.php"><i class="bi bi-list-ul"></i> Product List</a></li>
                            <li><a href="#add-product" class="submenu-item d-block py-1 load-content"
                                    data-page="add_product.php"><i class="bi bi-plus-circle"></i> Add
                                    Product</a></li>
                            <li><a href="#categories" class="submenu-item d-block py-1 load-content"
                                    data-page="add_category.php"><i class="bi bi-grid "></i>
                                    Add Categories</a></li>
                            <li><a href="#brands" class="submenu-item d-block py-1 load-content"
                                    data-page="add_brands.php"><i class="bi bi-tags"></i>
                                    Brands</a></li>
                        </ul>
                    </li>
                    <li><a href="#orders" class="menu-item" data-bs-toggle="collapse" aria-expanded="false"
                            aria-controls="orders"><i class="bi bi-receipt-cutoff"></i> Orders</a>
                        <ul class="collapse list-unstyled submenu ps-2 mb-3" id="orders">
                            <li><a href="#all-orders" class="submenu-item d-block py-1 load-content"
                                    data-page="order.php"><i class="bi bi-list-check"></i> All Orders</a></li>
                            <li><a href="#pending-orders" class="submenu-item d-block py-1 load-content"
                                    data-page="panding_order.php"><i class="bi bi-clock-history"></i> Pending
                                    Orders</a></li>
                            <li><a href="#shipped-orders" class="submenu-item d-block py-1 text-truncate load-content"
                                    data-page="shipping_order.php"><i class="bi bi-truck"></i> Shipped Orders</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#customers" class="menu-item " data-bs-toggle="collapse" aria-expanded="false"
                            aria-controls="customers"><i class="bi bi-people"></i> Customers</a>
                        <ul class="submenu ps-2 mb-3 collapse list-unstyled" id="customers">
                            <a href="#customer-list" class="submenu-item d-block py-1 load-content"
                                data-page="users.php"><i class="bi bi-list"></i>
                                Customer
                                List</a>
                            <a href="#feedback" class="submenu-item d-block py-1"><i class="bi bi-chat-dots"></i>
                                Feedback</a>
                        </ul>
                    </li>
                    <li><a href="#marketing" class="menu-item" data-bs-toggle="collapse" aria-expanded="false"
                            aria-controls="marketing"><i class="bi bi-megaphone"></i> Marketing</a>
                        <ul class="submenu ps-4 mb-3 list-unstyled collapse" id="marketing">
                            <a href="#coupons" class="submenu-item d-block py-1"><i class="bi bi-ticket-perforated"></i>
                                Coupons</a>
                            <a href="#promotions" class="submenu-item d-block py-1"><i class="bi bi-bullhorn"></i>
                                Promotions</a>
                        </ul>
                    </li>
                    <li><a href="#reports" class="menu-item"><i class="bi bi-bar-chart-line"></i> Reports</a></li>
                    <li><a href="#settings" class="menu-item" data-bs-toggle="collapse" data-bs-target="#settings"
                            aria-expanded="false" aria-controls="settings">
                            <i class="bi bi-gear"></i> Settings
                        </a>
                        <ul class="submenu ps-2 mb-3 collapse list-unstyled" id="settings">
                            <li><a href="#store-settings" class="submenu-item d-block py-1"><i class="bi bi-shop"></i>
                                    Store
                                    Settings</a></li>
                            <li><a href="#payment-settings" class="submenu-item d-block py-1"><i
                                        class="bi bi-credit-card"></i>
                                    Payment Settings</a></li>
                            <li><a href="#shipping-settings" class="submenu-item d-block py-1"><i
                                        class="bi bi-truck"></i>
                                    Shipping
                                    Settings</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#admins" class="menu-item" data-bs-toggle="collapse" aria-expanded="false"
                            aria-controls="admins"><i class="bi bi-person-badge"></i> Role</a>
                        <ul class="submenu ps-4 mb-3 list-unstyled collapse" id="admins">
                            <li>
                                <a href="#sub-admin" class="submenu-item d-block py-1 load-content"
                                    data-page="sub_adminForm.php">
                                    <i class="bi bi-person"></i> Sub Admin
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#" class="mt-auto text-white"><i class="bi bi-person"></i> Profile</a></li>
                    <li><a href="logout.php" class="mt-auto text-danger"><i class="bi bi-box-arrow-right"></i>
                            Logout</a>
                    </li>
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