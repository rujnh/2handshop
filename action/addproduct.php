<?php
session_start();
include '../config/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ตรวจสอบว่ามีข้อมูลที่ถูกส่งมาหรือไม่
    if (isset($_POST['name']) && isset($_POST['description']) && isset($_POST['color']) && isset($_POST['category_id']) && isset($_FILES['image']) && isset($_POST['price']) && isset($_POST['condition_id']) && isset($_POST['tel_number'])) {
        // ดึงข้อมูลจากฟอร์ม
        $name = $_POST['name'];
        $description = $_POST['description'];
        $color = $_POST['color'];
        $category_id = $_POST['category_id'];
        $price = $_POST['price'];
        $user_id = $_SESSION['user_id'];
        $condition_id = $_POST['condition_id'];
        $tel_number = $_POST['tel_number'];

        // เตรียมคำสั่ง SQL สำหรับเพิ่มข้อมูลในตาราง products
        $sql_products = "INSERT INTO products (name, description, color, category_id, created_at, price, favorite, user_id, condition_id, tel_number) 
                         VALUES ('$name', '$description', '$color', '$category_id', NOW(), '$price', 0, '$user_id', '$condition_id', '$tel_number')";

        // ทำการเพิ่มข้อมูลลงในตาราง products
        if ($conn->query($sql_products) === TRUE) {
            $last_product_id = $conn->insert_id; // รหัสสินค้าล่าสุดที่เพิ่มเข้าไปในตาราง products

            // อัปโหลดไฟล์รูปภาพ
            foreach ($_FILES['image']['tmp_name'] as $key => $tmp_name) {
                $image_name = $_FILES['image']['name'][$key];
                $image_tmp = $_FILES['image']['tmp_name'][$key];
                $image_path = "../images/product/large-size/" . $image_name;

                if (move_uploaded_file($image_tmp, $image_path)) {
                    // เตรียมคำสั่ง SQL สำหรับเพิ่มข้อมูลในตาราง product_images
                    $sql_product_images = "INSERT INTO product_images (product_id, image, created_at) 
                                           VALUES ('$last_product_id', '$image_name', NOW())";

                    // ทำการเพิ่มข้อมูลลงในตาราง product_images
                    $conn->query($sql_product_images);
                } else {
                    echo "เกิดข้อผิดพลาดในการอัปโหลดไฟล์รูปภาพ: " . $_FILES['image']['error'][$key];
                }
            }

            // ให้หน้าเว็บเปลี่ยนไปที่หน้าแรกหลังจากเพิ่มสินค้าเสร็จสมบูรณ์
            header("Location: ../index.php");
        } else {
            echo "มีข้อผิดพลาดในการเพิ่มสินค้า: " . $conn->error;
        }
    } else {
        echo "กรุณากรอกข้อมูลให้ครบถ้วน";
    }
} else {
    echo "ไม่สามารถเรียกใช้งานได้โดยตรง";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
