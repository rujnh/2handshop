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

// คำสั่ง SQL เพื่อดึงข้อมูลสินค้าที่ผู้ใช้โพสขายพร้อมกับรูปภาพ
$sql = "SELECT products.*, product_images.image 
        FROM products 
        INNER JOIN product_images ON products.id = product_images.product_id
        WHERE products.user_id = $user_id
        GROUP BY products.id";


$result = mysqli_query($conn, $sql);
?>

<div class="Shopping-cart-area pt-60 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>สินค้าของฉัน</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>รูปภาพ</th>
                            <th>ชื่อสินค้า</th>
                            <th>รายละเอียด</th>
                            <th>ราคา</th>
                            <th>แก้ไข</th>
                            <th>ลบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                <tr>
                                    <td><img src="images/product/large-size/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" style="width: 100px;"></td>

                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['description']; ?></td>
                                    <td><?php echo number_format($row['price'], 0); ?></td>

                                    <td><a href="edit_product.php?id=<?php echo $row['id']; ?>">แก้ไข</a></td>
                                    <td><a href="delete_product.php?id=<?php echo $row['id']; ?>">ลบ</a></td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="6">ไม่พบสินค้า</td>
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