<?php 

include_once('../conn.php');
include_once('../fetch_tableData.php');

header("content-type: application/json");
$type=$_GET['type']??'';

switch($type){
    case 'products':  
        $total = getTotalProduct($conn);
        echo json_encode(["totalProducts" => $total]);
        break;
    case 'categories':
        $total = getCategory($conn);
        echo json_encode(["totalCategories" => $total]);
        break;
    case 'revenue':
        $revenue = getRevenue($conn);
        echo json_encode(["totalRevenue"=> $revenue]);
        break;
    case 'pending':
        $pending = getPendingOrder($conn);
        echo json_encode(["totalPending"=>$pending]);
        break;
    case 'revenue_chart':
    $sql = "SELECT DATE(created_at) as order_date, SUM(total_amount) as revenue 
            FROM orders 
            GROUP BY DATE(created_at) 
            ORDER BY order_date ASC";
    $result = $conn->query($sql);

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $timestamp = strtotime($row['order_date']) * 1000; // convert date → JS timestamp
        $data[] = ["x" => $timestamp, "y" => (float)$row['revenue']];
    }

    echo json_encode($data, JSON_NUMERIC_CHECK); // ensure numbers, not strings
    break;
    case 'products_chart':
        
        $sql = "SELECT DATE(created_at) as day, COUNT(*) as total 
                FROM orders
                GROUP BY DATE(created_at) 
                ORDER BY day ASC";
        $result = $conn->query($sql);

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = [
                "x" => strtotime($row['day']) * 1000, // JS timestamp (ms)
                "y" => (int)$row['total']
            ];
        }
        echo json_encode($data);
        break;
    default:
        echo json_encode(["error" => "invalid type", "received" => $type]);
}



?>