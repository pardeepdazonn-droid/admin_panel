<?php
include('conn.php');

if(isset($_GET['search'])){
    $search = $_GET['search'];
    $search_safe = $conn->real_escape_string($search);

    $sql = "
    SELECT 
        p.product_id, 
        p.name, 
        p.image, 
        p.brand, 
        c.category_name, 
        s.subcategory_name
    FROM product p
    LEFT JOIN product_category c ON p.product_id = c.category_id
    LEFT JOIN sub_category s ON p.product_id = s.subcategory_id
    WHERE 
        p.name LIKE '%$search_safe%' OR
        p.brand LIKE '%$search_safe%' OR
        c.category_name LIKE '%$search_safe%' OR
        s.subcategory_name LIKE '%$search_safe%'
    LIMIT 10";

    $result = $conn->query($sql);

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo '<a href="product_details.php?id='. $row['product_id'] .'" class="list-group-item list-group-item-action d-flex align-items-center">';
            echo '<img src="'. htmlspecialchars($row['image']) .'" style="width:40px; height:40px; object-fit:cover; margin-right:10px;">';
            echo '<div>';
            echo '<div class="fw-bold">'. htmlspecialchars($row['name']) .'</div>';
            echo '</div></a>';
        }
    } else {
        echo '<div class="list-group-item">No results found</div>';
    }
}
?>
