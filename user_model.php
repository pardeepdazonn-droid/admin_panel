<?php
include_once('conn.php');

function getAllUser(){
    global $conn;
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    $users = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    return $users;
}
?>
