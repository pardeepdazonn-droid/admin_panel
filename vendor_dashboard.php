<?php
session_start();
// Prevent browser caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");
 
if (!isset($_SESSION['user_id'])) {
    header("Location: vendors.php");
    exit;
}

include('header/header.php');
include_once('fetch_tableData.php');

?>
<div class="dashboard-container d-flex overflow-x-hidden">
    <!-- Sidebar -->
   <div class="dashboard-sidebar bg-dark text-light d-flex flex-column p-3">
    <div class="logo mb-4 text-center">
        <img src="images/admin-logo.png" alt="Logo" class="img-fluid" style="max-height: 80px;">
    </div>
    <nav class="flex-grow-1">
        <ul class="nav flex-column gap-2">
            <li><a href="#dashboard" class="nav-link active"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
            
            <!-- Products -->
            <li>
                <a class="nav-link collapsed d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" href="#productsMenu">
                    <span><i class="bi bi-box-seam me-2"></i> Products</span>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <ul class="collapse list-unstyled ps-3" id="productsMenu">
                    <li><a href="#" class="nav-link load-content" data-page="product_list.php">Product List</a></li>
                    <li><a href="#" class="nav-link load-content" data-page="add_product.php">Add Product</a></li>
                    <li><a href="#" class="nav-link load-content" data-page="add_category.php">Categories</a></li>
                </ul>
            </li>

            <!-- Orders -->
            <li>
                <a class="nav-link collapsed d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" href="#ordersMenu">
                    <span><i class="bi bi-receipt-cutoff me-2"></i> Orders</span>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <ul class="collapse list-unstyled ps-3" id="ordersMenu">
                    <li><a href="#" class="nav-link load-content" data-page="order.php">All Orders</a></li>
                    <li><a href="#" class="nav-link load-content" data-page="panding_order.php">Pending Orders</a></li>
                    <li><a href="#" class="nav-link load-content" data-page="shipping_order.php">Shipped Orders</a></li>
                </ul>
            </li>

            <!-- Profile & Logout -->
            <li><a href="profile.php" class="nav-link"><i class="bi bi-person me-2"></i>Profile</a></li>
            <li><a href="vendors_logout.php" class="nav-link text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
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