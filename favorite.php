<?php
include 'include/header.php';
include 'config/connect.php';

// ตรวจสอบว่ามีการเข้าสู่ระบบหรือยัง
if (!isset($_SESSION['user_id'])) {
    // หากไม่ได้เข้าสู่ระบบให้ redirect ไปยังหน้า login
    header("Location: login.php");
    exit(); // ออกจากการทำงานของสคริปต์
}

$user_id = $_SESSION['user_id'];

// คำสั่ง SQL เพื่อดึงข้อมูลสินค้าที่ถูกใจของผู้ใช้พร้อมกับรูปภาพจากตาราง product_images
$sql = "SELECT products.*, favorite.id AS favorite_id, product_images.image AS product_image 
        FROM products
        INNER JOIN favorite ON products.id = favorite.product_id
        LEFT JOIN product_images ON products.id = product_images.product_id
        WHERE favorite.user_id = $user_id
        LIMIT 1";

$result = mysqli_query($conn, $sql);
?>

<div class="Shopping-cart-area pt-60 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>สินค้าที่ถูกใจ</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>รูปภาพ</th>
                            <th>ชื่อสินค้า</th>
                            <th>รายละเอียด</th>
                            <th>ราคา</th>
                            <th>การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                <tr>
                                    <td><img src="images/product/large-size/<?php echo $row['product_image']; ?>" alt="<?php echo $row['name']; ?>" style="width: 100px;"></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['description']; ?></td>
                                    <td><?php echo number_format($row['price'], 0); ?></td>

                                    <td>
                                        <form action="remove_favorite.php" method="post"> <!-- เพิ่มแบบฟอร์มลบ -->
                                            <input type="hidden" name="favorite_id" value="<?php echo $row['favorite_id']; ?>"> <!-- ส่งไอดีของรายการที่ถูกใจเพื่อลบ -->
                                            <button type="submit" class="btn btn-danger">ลบ</button> <!-- เพิ่มปุ่มลบ -->
                                        </form>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="5">ไม่พบสินค้าที่ถูกใจ</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include 'include/footer.php'
?>