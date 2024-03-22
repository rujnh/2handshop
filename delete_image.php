<?php
include 'config/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $image_id = $_GET['id'];

    // คำสั่ง SQL เพื่อลบรูปภาพจากตาราง product_images
    $sql_delete_image = "DELETE FROM product_images WHERE id = $image_id";

    if (mysqli_query($conn, $sql_delete_image)) {
        // ลบรูปภาพสำเร็จ
        header("Location: edit_product.php?id=$product_id");
        exit();
    } else {
        // เกิดข้อผิดพลาดในการลบรูปภาพ
        echo "เกิดข้อผิดพลาดในการลบรูปภาพ: " . mysqli_error($conn);
    }
} else {
    // หากไม่มีการส่งข้อมูล ID ของรูปภาพมา
    echo "ไม่สามารถเข้าถึงหน้านี้โดยตรง";
}
