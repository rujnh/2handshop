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

        // อัปโหลดไฟล์รูปภาพ
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_path = "../images/product/large-size/" . $image_name;

        // ย้ายไฟล์รูปภาพไปยังโฟลเดอร์ที่เก็บรูปภาพ
        move_uploaded_file($image_tmp, $image_path);

        // เตรียมคำสั่ง SQL สำหรับเพิ่มข้อมูลในฐานข้อมูล
        $sql = "INSERT INTO products (name,description, color, category_id, image, created_at, price, favorite, user_id, condition_id, tel_number) VALUES ('$name', '$description', '$color', '$category_id', '$image_name', NOW(), '$price', 0, '$user_id', '$condition_id', '$tel_number')";

        // ทำการเพิ่มข้อมูลลงในฐานข้อมูล
        if ($conn->query($sql) === TRUE) {
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
