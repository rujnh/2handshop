<?php
// เชื่อมต่อกับฐานข้อมูล
include 'config/connect.php';

// ตรวจสอบว่ามีการส่งค่า product_id มาหรือไม่
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // ค้นหารูปภาพถัดไปของสินค้าที่มี product_id เดียวกัน โดยเรียงตาม id
    $sql_next_image = "SELECT image FROM product_images WHERE product_id = $product_id ORDER BY id ASC LIMIT 1 OFFSET 1";
    $result_next_image = $conn->query($sql_next_image);

    // ตรวจสอบว่าพบรูปภาพถัดไปหรือไม่
    if ($result_next_image->num_rows > 0) {
        $row_next_image = $result_next_image->fetch_assoc();
        // ส่งข้อมูลรูปภาพกลับในรูปแบบ JSON
        echo json_encode(array("image" => $row_next_image['image']));
    } else {
        // ถ้าไม่พบรูปภาพถัดไป ส่งข้อมูลผิดพลาดกลับให้ JavaScript
        echo json_encode(array("error" => "ไม่พบรูปภาพถัดไป"));
    }
} else {
    // ถ้าไม่ได้รับค่า product_id ส่งมา ส่งข้อมูลผิดพลาดกลับให้ JavaScript
    echo json_encode(array("error" => "ไม่ได้รับข้อมูล product_id"));
}
