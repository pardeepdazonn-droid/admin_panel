<?php
require_once 'conn.php';

echo "<h2>Checking Table Structure</h2>";

$tables = ['orders', 'order_items', 'payments'];

foreach ($tables as $table) {
    echo "<h3>Table: $table</h3>";
    $result = $conn->query("DESCRIBE $table");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            echo $row['Field'] . " - " . $row['Type'] . " - " . $row['Null'] . " - " . $row['Key'] . "<br>";
        }
    } else {
        echo "Table doesn't exist or error: " . $conn->error . "<br>";
    }
    echo "<hr>";
}
?>