<?php
include '../config/connect.php';

// ตรวจสอบว่ามีการล็อกอินอยู่หรือไม่
session_start();
if(!isset($_SESSION["user_id"])){
    header("location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// สร้างคำสั่ง SQL เพื่อดึงข้อมูลในตาราง carts
$sql = "SELECT * FROM carts WHERE user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // หากมี cart ให้ทำการเพิ่มข้อมูลในตาราง orders และ order_detail
    $total_amount = 0;
    $order_date = date("Y-m-d H:i:s");
    // สร้างคำสั่ง SQL เพื่อบันทึกข้อมูลในตาราง orders
    $sql_order = "INSERT INTO orders (user_id, amount_total, order_date) VALUES ('$user_id', '$total_amount', '$order_date')";
    if ($conn->query($sql_order) === TRUE) {
        $order_id = $conn->insert_id; // รับค่า ID ของ order ที่เพิ่มเข้าไปในตาราง orders
        while($row = $result->fetch_assoc()) {
            $product_id = $row['product_id'];
            $qty = $row['qty'];
            $amount = $row['amount'];
            $total_amount += $amount;
            // สร้างคำสั่ง SQL เพื่อบันทึกข้อมูลในตาราง order_detail
            $sql_order_detail = "INSERT INTO order_details (product_id, qty, user_id, order_id, amount) VALUES ('$product_id', '$qty', '$user_id', '$order_id', '$amount')";
            $conn->query($sql_order_detail);
        }
        // อัพเดทค่าราคารวมในตาราง orders
        $sql_update_order = "UPDATE orders SET amount_total='$total_amount' WHERE id='$order_id'";
        $conn->query($sql_update_order);
        
        // ลบข้อมูลในตาราง carts
        $sql_delete_cart = "DELETE FROM carts WHERE user_id = $user_id";
        $conn->query($sql_delete_cart);
        
        // ส่งกลับไปยังหน้าหลักหลังจากทำการสั่งซื้อเรียบร้อยแล้ว
        header("location: ../index.php");
    } else {
        echo "Error: " . $sql_order . "<br>" . $conn->error;
    }
} else {
    // หากไม่มีสินค้าในตะกร้า
    echo "No item in the cart.";
}
$conn->close();
?>
