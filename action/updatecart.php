<?php
include '../config/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าจากฟอร์ม
    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['qty'];

    // สร้างคำสั่ง SQL เพื่ออัปเดตข้อมูล
    $sql = "UPDATE carts SET qty='$quantity' WHERE id='$cart_id'";
    
    // ทำการอัปเดตข้อมูล
    if ($conn->query($sql) === TRUE) {
        // อัปเดตสำเร็จ ให้ redirect กลับไปที่หน้าเดิม
        header("Location: ../cart.php");
        exit();
    } else {
        // หากเกิดข้อผิดพลาดในการอัปเดต
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
