<?php
$conn = new mysqli('zsupntl2tuqe83zjv44gx0pz', 'admin', 'admin123', 'default', 3306);

if ($conn->connect_error) {
    die('فشل الاتصال: ' . $conn->connect_error);
}

$conn->set_charset('utf8mb4');
?>