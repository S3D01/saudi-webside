<?php
$conn = new mysqli('127.0.0.1', 'root', '', 'admin_7ol', 3306);

if ($conn->connect_error) {
    die('فشل الاتصال: ' . $conn->connect_error);
}

$conn->set_charset('utf8mb4');
?>  