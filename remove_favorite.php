<?php
include 'config/connect.php';

// ตรวจสอบว่ามีการเข้าสู่ระบบหรือไม่
session_start();
if (!isset($_SESSION['user_id'])) {
    // หากไม่ได้เข้าสู่ระบบให้ redirect ไปยังหน้า login
    header("Location: login.php");
    exit(); // ออกจากการทำงานของสคริปต์
}

// ตรวจสอบว่ามีข้อมูลที่ส่งมาหรือไม่
if (isset($_POST['favorite_id'])) {
    // รับค่ารหัสรายการที่ถูกใจที่ต้องการลบ
    $favorite_id = $_POST['favorite_id'];

    // คำสั่ง SQL เพื่อลบรายการที่ถูกใจออกจากฐานข้อมูล
    $sql = "DELETE FROM favorite WHERE id = $favorite_id";

    if ($conn->query($sql) === TRUE) {
        // หากลบข้อมูลสำเร็จ ให้ redirect กลับไปยังหน้าที่มาก่อนหน้า
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit(); // ออกจากการทำงานของสคริปต์
    } else {
        // หากเกิดข้อผิดพลาดในการลบข้อมูล
        echo "Error deleting record: " . $conn->error;
    }
} else {
    // หากไม่มีข้อมูลที่ส่งมา
    echo "No data sent";
}

$conn->close();
?>
