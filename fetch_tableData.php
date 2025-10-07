<?php
include('conn.php');


$categories = [];
$sql = "SELECT category_id, category_name FROM product_category ORDER BY category_name ASC";
$result_category = $conn->query($sql);

if ($result_category && $result_category->num_rows > 0) {
  while ($row = $result_category->fetch_assoc()) {
    $categories[] = $row;
  }
}


$brands = [];
$sql = "SELECT brand_id, name FROM brand ORDER BY name ASC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $brands[] = $row;
  }
}

function getCategory($conn){
$sql="SELECT COUNT(*) AS category FROM product_category";
$result= $conn->query($sql);
$total_category = $result->fetch_assoc();
$category =$total_category['category'];
return$category;
}


function getTotalProduct($conn){
$sql="SELECT COUNT(*) AS products FROM product";
$result= $conn->query($sql);
$total_product = $result->fetch_assoc();
$products =$total_product['products'];
return$products;
}

function getRevenue($conn){
$sql="SELECT SUM(total_amount) AS revenue FROM orders";
$result= $conn->query($sql);
$total_revenue = $result->fetch_assoc();
$amount =$total_revenue['revenue'];
return$amount;
}

function getPendingOrder($conn){
  $sql="SELECT COUNT(*) AS pendingOrder FROM orders WHERE order_status='pending'";
  $result=$conn->query($sql);
  $total_pending=$result->fetch_assoc();
  $pending=$total_pending['pendingOrder']?? 0;
  return$pending;
}

?>