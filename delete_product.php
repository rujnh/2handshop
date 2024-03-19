<?php
ob_start();
include 'include/header.php';
include 'config/connect.php';

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// ตรวจสอบว่ามีการส่ง ID ของสินค้ามาหรือไม่
if (!isset($_GET['id'])) {
    header("Location: myproduct.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = $_GET['id'];

// คำสั่ง SQL เพื่อดึงข้อมูลของสินค้า
$sql = "SELECT * FROM products WHERE id = $product_id AND user_id = $user_id";
$result = mysqli_query($conn, $sql);

// ตรวจสอบว่ามีข้อมูลของสินค้าที่ต้องการลบหรือไม่
if (mysqli_num_rows($result) == 0) {
    header("Location: myproduct.php");
    exit();
}

// คำสั่ง SQL สำหรับลบสินค้า
$delete_sql = "DELETE FROM products WHERE id = $product_id";
$delete_result = mysqli_query($conn, $delete_sql);

// ตรวจสอบว่าสินค้าถูกลบสำเร็จหรือไม่
if ($delete_result) {
    // หากสำเร็จให้แสดงข้อความแจ้งเตือนและ redirect ไปยังหน้า my_products.php
    echo '<div class="container"><div class="alert alert-success" role="alert">ลบสินค้าสำเร็จ</div></div>';
    header("Refresh: 2; URL=myproduct.php");
    exit();
} else {
    // หากไม่สำเร็จให้แสดงข้อความแจ้งเตือน
    echo '<div class="container"><div class="alert alert-danger" role="alert">เกิดข้อผิดพลาดในการลบสินค้า</div></div>';
}

 include 'include/footer.php';
?>
