<?php
include '../config/connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // ตรวจสอบว่ามีการส่งค่า id ของสินค้าผ่าน URL หรือไม่
    if (isset($_GET['id'])) {
        $product_id = $_GET['id'];
        $user_id = $_SESSION['user_id'];

        // ตรวจสอบว่าผู้ใช้ได้กดสินค้านี้ไปแล้วหรือไม่
        $check_favorite_sql = "SELECT * FROM favorite WHERE product_id = $product_id AND user_id = $user_id";
        $check_result = mysqli_query($conn, $check_favorite_sql);

        // ตรวจสอบว่ามีข้อผิดพลาดในการ query หรือไม่
        if ($check_result) {
            // ตรวจสอบว่าผู้ใช้เคยกดสินค้านี้หรือไม่
            if (mysqli_num_rows($check_result) == 0) {
                // เพิ่ม +1 ให้ค่า favorite ของสินค้าในตาราง products
                $update_product_sql = "UPDATE products SET favorite = favorite + 1 WHERE id = $product_id";
                $insert_favorite_sql = "INSERT INTO favorite (product_id, user_id) VALUES ($product_id, $user_id)";

                // ทำการทำงานในการอัพเดทและเพิ่มรายการในตาราง favorite ใน transaction เดียวกัน
                mysqli_begin_transaction($conn);
                if (mysqli_query($conn, $update_product_sql) && mysqli_query($conn, $insert_favorite_sql)) {
                    mysqli_commit($conn);
                    // ทำการรีเฟรชหน้าหลังจากกดถูกใจสำเร็จ
                    echo '<script>window.location.href="../favorite.php";</script>';
                    exit();
                } else {
                    mysqli_rollback($conn);
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                echo "คุณกดไปแล้ว.";
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
} else {
    echo "Invalid request method!";
}
