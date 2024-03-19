<?php
// ตรวจสอบว่ามีการส่งไฟล์มาหรือไม่
if ($_FILES['image']) {
    // เก็บข้อมูลของไฟล์ที่อัปโหลด
    $file_name = $_FILES['image']['name'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];
    $file_size = $_FILES['image']['size'];
    
    // ตรวจสอบว่าไฟล์ที่อัปโหลดเป็นไฟล์รูปภาพหรือไม่
    $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
    $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    if (in_array($file_extension, $allowed_types)) {
        // กำหนดโฟลเดอร์ที่ต้องการเก็บไฟล์
        $upload_path = 'uploads/';
        // กำหนดชื่อไฟล์ใหม่ (ใช้ timestamp เพื่อให้ไม่ซ้ำกัน)
        $new_file_name = time() . '_' . $file_name;
        // กำหนดพาธที่สมบูรณ์ของไฟล์ที่จะอัปโหลด
        $file_destination = $upload_path . $new_file_name;
        
        // อัปโหลดไฟล์
        if (move_uploaded_file($file_tmp, $file_destination)) {
            echo "อัปโหลดรูปภาพสำเร็จ";
            // ทำสิ่งที่คุณต้องการหลังจากอัปโหลดไฟล์สำเร็จ
        } else {
            echo "เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ";
        }
    } else {
        echo "ไฟล์ที่อัปโหลดต้องเป็นรูปภาพเท่านั้น";
    }
}
?>
