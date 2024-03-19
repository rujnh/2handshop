<?php
include '../config/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับข้อมูลจากฟอร์ม
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    // เข้ารหัสรหัสผ่าน (เพื่อความปลอดภัย)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // ตรวจสอบว่าเมลซ้ำหรือไม่
    $sql_check_email = "SELECT * FROM users WHERE email='$email'";
    $result_check_email = $conn->query($sql_check_email);
    if ($result_check_email->num_rows > 0) {
        echo "เมลนี้ถูกใช้งานแล้ว";
    } else {
        // สร้างคำสั่ง SQL เพื่อทำการ insert ข้อมูลในตาราง users
        $sql = "INSERT INTO users (fullname, email, phone, password)
                VALUES ('$full_name', '$email', '$phone', '$hashed_password')";
        
        // ทำการ insert ข้อมูล
        if ($conn->query($sql) === TRUE) {
            header("Location: ../index.php");
        } else {
            echo "ผิดพลาด: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>
