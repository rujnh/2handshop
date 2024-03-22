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
        $image_names = array();
        foreach ($_FILES['image']['tmp_name'] as $key => $tmp_name) {
            $image_name = $_FILES['image']['name'][$key];
            $image_tmp = $_FILES['image']['tmp_name'][$key];
            $image_path = "../images/product/large-size/" . $image_name;
            if (move_uploaded_file(
                $image_tmp,
                $image_path
            )) {
                $image_names[] = $image_name;
            }
        }

        // รวมชื่อไฟล์เป็น string โดยใช้ implode()
        $image_names_string = implode("', '", $image_names);

        // เตรียมคำสั่ง SQL สำหรับเพิ่มข้อมูลในฐานข้อมูล
        $sql = "INSERT INTO products (name,description, color, category_id, image, created_at, price, favorite, user_id, condition_id, tel_number) VALUES ('$name', '$description', '$color', '$category_id', '$image_names_string', NOW(), '$price', 0, '$user_id', '$condition_id', '$tel_number')";

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
