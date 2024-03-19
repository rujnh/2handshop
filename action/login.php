<?php

include '../config/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับข้อมูลจากฟอร์ม
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // ค้นหาผู้ใช้จากฐานข้อมูลโดยใช้ email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        // เจอผู้ใช้งาน ทำการเปรียบเทียบรหัสผ่าน
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // รหัสผ่านถูกต้อง ให้ทำการเข้าสู่ระบบ
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['email'] = $row['email'];

            header("Location: ../index.php");
            exit;
        } else {
            echo "รหัสผ่านไม่ถูกต้อง";
        }
    } else {
        echo "ไม่พบผู้ใช้งานในระบบ";
    }
}
?>
