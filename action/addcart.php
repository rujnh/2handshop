<?php
include '../config/connect.php';

// ตรวจสอบว่ามีการส่งคำร้องขอแบบ POST หรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // เริ่ม session
    session_start();

    // ตรวจสอบว่าผู้ใช้เข้าสู่ระบบหรือไม่ และใช้ค่า user_id จาก session
    if(isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // รับข้อมูลจากฟอร์ม
        $product_id = $_POST['product_id'];
        $qty = $_POST['qty'];
        $amount = $_POST['amount'];

        // สร้างคำสั่ง SQL เพื่อทำการ insert ข้อมูลในตาราง carts
        $sql = "INSERT INTO carts (product_id, user_id, qty, amount)
                VALUES ('$product_id', '$user_id', '$qty', '$amount')";

        // ทำการ insert ข้อมูล
        if ($conn->query($sql) === TRUE) {
            // ถ้าสำเร็จให้ redirect กลับไปที่หน้าเดิมหรือหน้าอื่นตามที่คุณต้องการ
            header("Location: ../cart.php");
        } else {
            // หากเกิดข้อผิดพลาดในการ insert ให้แสดงข้อความผิดพลาด
            echo "ผิดพลาดในการเพิ่มสินค้าในตะกร้า: " . $conn->error;
        }
    } else {
        // ถ้าไม่ได้เข้าสู่ระบบให้เก็บ URL ปัจจุบันไว้ใน session เพื่อเรียกกลับมาหลังจากเข้าสู่ระบบ
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        header("Location: ../login.php");
    }
}

?>