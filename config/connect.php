<?php
// เชื่อมต่อฐานข้อมูล
$servername = "127.0.0.1:3307";
$username = "root";
$password = "";
$dbname = "2handshop";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
