<?php
include('header/header.php');
include_once('fetch_tableData.php');
?>
<div class="dashboard-container d-flex overflow-x-hidden">
    <!-- Sidebar -->
    <div class="dashboard-sidebar bg-dark text-light d-flex flex-column p-3">
        <div class="logo mb-4 text-center">
            <img src="images/admin-logo.png" alt="Admin Logo" class="img-fluid" style="max-height: 80px;">
        </div>
        <nav>
            <ul class="nav flex-column gap-2">
                <li><a href="#dashboard" class="nav-link active"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
                </li>

                <!-- Products Menu -->
                <li>
                    <a class="nav-link collapsed d-flex justify-content-between align-items-center"
                        data-bs-toggle="collapse" href="#productsMenu" role="button">
                        <span><i class="bi bi-box-seam me-2"></i> Products</span>
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <ul class="collapse list-unstyled ps-2" id="productsMenu">
                        <li class="nav-memu"><a href="#products-list" class="nav-link submenu-item load-content" data-page="product_list.php"><i
                                    class="bi bi-list-ul me-2"></i> Product List</a></li>
                        <li class="nav-menu"><a href="#add-product" class="nav-link submenu-item load-content" data-page="add_product.php"><i
                                    class="bi bi-plus-circle me-2"></i> Add Product</a></li>
                        <li class="nav-menu"><a href="#categories" class="nav-link submenu-item load-content" data-page="add_category.php"><i
                                    class="bi bi-grid me-2"></i> Add Categories</a></li>
                        <li class="nav-menu"><a href="#brands" class="nav-link submenu-item load-content" data-page="add_brands.php"><i
                                    class="bi bi-tags me-2"></i> Brands</a></li>
                    </ul>
                </li>

                <!-- Orders Menu -->
                <li>
                    <a class="nav-link collapsed d-flex justify-content-between align-items-center"
                        data-bs-toggle="collapse" href="#ordersMenu" role="button">
                        <span><i class="bi bi-receipt-cutoff me-2"></i> Orders</span>
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <ul class="collapse list-unstyled ps-2" id="ordersMenu">
                        <li class="nav-menu"><a href="#all-orders" class="nav-link submenu-item load-content text-truncate" data-page="order.php"><i
                                    class="bi bi-list-check me-2"></i> All Orders</a></li>
                        <li class="nav-menu"><a href="#pending-orders" class="nav-link submenu-item load-content text-truncate" data-page="panding_order.php"><i
                                    class="bi bi-clock-history me-2"></i> Pending Orders</a></li>
                        <li class="nav-menu"><a href="#shipped-orders" class="nav-link submenu-item load-content text-truncate"
                                data-page="shipping_order.php"><i class="bi bi-truck me-2"></i> Shipped Orders</a></li>
                    </ul>
                </li>

                <!-- Customers Menu -->
                <li>
                    <a class="nav-link collapsed d-flex justify-content-between align-items-center"
                        data-bs-toggle="collapse" href="#customersMenu" role="button">
                        <span><i class="bi bi-people me-2"></i> Customers</span>
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <ul class="collapse list-unstyled ps-3" id="customersMenu">
                        <!-- <li class="nav-menu"><a href="#customer-list" class="nav-link submenu-item load-content" data-page="users.php"><i
                                    class="bi bi-list me-2"></i> Customer List</a></li> -->
                        <li class="nav-menu"><a href="#feedback" class="nav-link submenu-item"><i class="bi bi-chat-dots me-2"></i> Feedback</a>
                        </li>
                    </ul>
                </li>

                <!-- Marketing -->
                <li>
                    <a class="nav-link collapsed d-flex justify-content-between align-items-center"
                        data-bs-toggle="collapse" href="#marketingMenu" role="button">
                        <span><i class="bi bi-megaphone me-2"></i> Marketing</span>
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <ul class="collapse list-unstyled ps-3" id="marketingMenu">
                        <li class="nav-menu"><a href="#coupons" class="nav-link submenu-item"><i class="bi bi-ticket-perforated me-2"></i>
                                Coupons</a></li>
                        <li class="nav-menu"><a href="#promotions" class="nav-link submenu-item"><i class="bi bi-bullhorn me-2"></i>
                                Promotions</a></li>
                    </ul>
                </li>

                <!-- Reports & Settings -->
                <li><a href="#reports" class="nav-link"><i class="bi bi-bar-chart-line me-2"></i> Reports</a></li>
                <li>
                    <a class="nav-link collapsed d-flex justify-content-between align-items-center"
                        data-bs-toggle="collapse" href="#settingsMenu" role="button">
                        <span><i class="bi bi-gear me-2"></i> Settings</span>
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <ul class="collapse list-unstyled ps-2" id="settingsMenu">
                        <li class="nav-menu"><a href="#store-settings" class="nav-link submenu-item text-truncate"><i class="bi bi-shop me-2"></i> Store
                                Settings</a></li>
                        <li class="nav-menu"><a href="#payment-settings" class="nav-link submenu-item text-truncate"><i class="bi bi-credit-card me-2"></i>
                                Payment</a></li>
                        <li class="nav-menu"><a href="#shipping-settings" class="nav-link submenu-item text-truncate"><i class="bi bi-truck me-2"></i> 
                                Shipping</a></li>
                    </ul>
                </li>

                <li><a href="#" class="nav-link mt-auto"><i class="bi bi-person me-2"></i> Profile</a></li>
                <li><a href="logout.php" class="nav-link text-danger mt-auto"><i class="bi bi-box-arrow-right me-2"></i>
                        Logout</a></li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="dashboard-main col-lg-10 p-4 bg-light" id="main-content">
        <section id="dashboard-overview">
            <h3 class="mb-4 fw-bold text-secondary">Dashboard Overview</h3>
            <div class="row g-4">
                <!-- Stats Cards -->
                <div class="col-md-3">
                    <div class="card shadow-sm text-white bg-primary p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5>Total Products</h5>
                                <p class="fs-2 mt-2"><i class="bi bi-box-seam me-2 opacity-75"></i><span
                                        id="totalProducts"></span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm text-white bg-success p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5>Total Categories</h5>
                                <p class="fs-2 mt-2"><i class="bi bi-basket3 me-2 opacity-75"></i><span
                                        id="totalCategories"></span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm text-white bg-warning p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5>Total Revenue</h5>
                                <p class="fs-3 mt-2"><i class="bi bi-currency-dollar me-2 opacity-75"></i><span
                                        id="totalRevenue"></span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm text-white bg-danger p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5>Total Pending</h5>
                                <p class="fs-2 mt-2"><i class="bi bi-clock-history me-2 opacity-75"></i><span
                                        id="totalPending"></span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts -->
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
    </div>
</div>
<script src="js/content-loader.js"></script>
<script src="js/revenue_chart.js"></script>
<script src="js/product_chart.js"></script>
<?php
include('footer/footer.php');
?>