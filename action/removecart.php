<?php
include '../config/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    // รับค่า ID ของสินค้าที่ต้องการลบ
    $cart_id = $_GET['id'];
    
    // สร้างคำสั่ง SQL สำหรับลบสินค้าออกจากตะกร้า
    $sql = "DELETE FROM carts WHERE id = $cart_id";
    
    // ทำการลบข้อมูล
    if ($conn->query($sql) === TRUE) {
        // หากลบสำเร็จให้เด้งกลับไปยังหน้าตะกร้าสินค้า
        header("Location: ../cart.php");
        exit();
    } else {
        // หากเกิดข้อผิดพลาดในการลบข้อมูล
        echo "Error deleting record: " . $conn->error;
    }
} else {
    // หากไม่ได้รับค่า ID หรือไม่ได้ใช้เมธอด GET
    echo "Invalid request";
}
?>
