<!-- add_product_action.php -->

<!-- Connect to Database -->
<?php include '../config/connect.php'; ?>

<?php
if(isset($_FILES['images'])) {
    $total_images = count($_FILES['images']['name']);

    // Loop Through Uploaded Images
    for($i = 0; $i < $total_images; $i++) {
        $file_name = $_FILES['images']['name'][$i];
        $file_tmp = $_FILES['images']['tmp_name'][$i];
        $file_type = $_FILES['images']['type'][$i];

        // Check File Type
        if($file_type == "image/jpeg" || $file_type == "image/png" || $file_type == "image/jpg") {
            // Generate Unique File Name
            $new_file_name = uniqid('', true) . '_' . $file_name;
            // Specify Target Directory
            $target_dir = "../images/product/";
            $target_file = $target_dir . $new_file_name;

            // Move File to Target Directory
            if(move_uploaded_file($file_tmp, $target_file)) {
                // Insert Data into Database
                $sql = "INSERT INTO product_images (product_id, image) VALUES ('$product_id', '$new_file_name')";
                mysqli_query($conn, $sql);
            } else {
                echo "เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ";
            }
        } else {
            echo "รูปภาพที่อัปโหลดต้องเป็นไฟล์รูปภาพเท่านั้น";
        }
    }
}
?>
