<?php
require_once 'conn.php';

echo "<h2>Checking Users in Database</h2>";

$result = $conn->query("SELECT user_id, name, email FROM users");
if ($result && $result->num_rows > 0) {
    echo "Found users:<br>";
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row['user_id'] . " - Name: " . $row['name'] . " - Email: " . $row['email'] . "<br>";
    }
} else {
    echo "No users found or error: " . $conn->error . "<br>";
}

// Check current session user
session_start();
echo "<h3>Session User Data:</h3>";
echo "User ID: " . ($_SESSION['user_id'] ?? 'Not set') . "<br>";
echo "User Name: " . ($_SESSION['user_name'] ?? 'Not set') . "<br>";
echo "User Email: " . ($_SESSION['user_email'] ?? 'Not set') . "<br>";
?>