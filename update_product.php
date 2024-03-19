<?php
include 'config/connect.php';

// ตรวจสอบว่ามีการส่งค่าข้อมูลมาให้หรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    // รับค่าที่ส่งมา
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // ตรวจสอบว่ามีการอัปโหลดรูปภาพใหม่หรือไม่
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        // รับข้อมูลของรูปภาพ
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];

        // อัปโหลดรูปภาพใหม่
        move_uploaded_file($image_tmp, "images/product/large-size/$image_name");

        // อัปเดตข้อมูลสินค้าพร้อมรูปภาพใหม่
        $sql = "UPDATE products SET name = '$name', description = '$description', price = '$price', image = '$image_name' WHERE id = $product_id";
    } else {
        // อัปเดตข้อมูลสินค้าโดยไม่รวมรูปภาพใหม่
        $sql = "UPDATE products SET name = '$name', description = '$description', price = '$price' WHERE id = $product_id";
    }

    // ทำการอัปเดตข้อมูลในฐานข้อมูล
    if (mysqli_query($conn, $sql)) {
        // หากอัปเดตข้อมูลสำเร็จ ให้ redirect ไปยังหน้า my_products.php
        header("Location: myproduct.php");
        exit();
    } else {
        echo "มีข้อผิดพลาดเกิดขึ้นในการอัปเดตข้อมูล: " . mysqli_error($conn);
    }
} else {
    // หากไม่มีการส่งค่าข้อมูลมาให้ redirect ไปยังหน้าที่เหมาะสม
    header("Location: myproduct.php");
    exit();
}

// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn);
?>
