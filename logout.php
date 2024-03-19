<?php
session_start();

// ลบข้อมูล session ทั้งหมด
session_unset();

// ทำลาย session
session_destroy();

// เปลี่ยนเส้นทางไปยังหน้า index.php
header("Location: index.php");
exit;
?>
