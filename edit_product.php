<?php
include 'include/header.php';
include 'config/connect.php';

// ตรวจสอบว่ามีการเข้าสู่ระบบหรือไม่
if (!isset($_SESSION['user_id'])) {
    // หากไม่ได้เข้าสู่ระบบให้ redirect ไปยังหน้า login
    header("Location: login.php");
    exit(); // ออกจากการทำงานของสคริปต์
}

// ตรวจสอบว่ามีการส่ง ID ของสินค้ามาหรือไม่
if (!isset($_GET['id'])) {
    // หากไม่ได้รับ ID ของสินค้าให้ redirect ไปยังหน้าที่เหมาะสม
    header("Location: myproduct.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = $_GET['id'];

// คำสั่ง SQL เพื่อดึงข้อมูลของสินค้า
$sql_product = "SELECT * FROM products WHERE id = $product_id AND user_id = $user_id";
$result_product = mysqli_query($conn, $sql_product);

// ตรวจสอบว่ามีข้อมูลของสินค้าที่ต้องการแก้ไขหรือไม่
if (mysqli_num_rows($result_product) == 0) {
    // หากไม่พบสินค้าที่ต้องการแก้ไขให้ redirect ไปยังหน้าที่เหมาะสม
    header("Location: myproduct.php");
    exit();
}

$row_product = mysqli_fetch_assoc($result_product);

// คำสั่ง SQL เพื่อดึงรูปภาพจากตาราง product_images
$sql_images = "SELECT * FROM product_images WHERE product_id = $product_id";
$result_images = mysqli_query($conn, $sql_images);
?>

<div class="Shopping-cart-area pt-60 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>แก้ไขสินค้า</h2>
                <form action="update_product.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="product_id" value="<?php echo $row_product['id']; ?>">
                    <div class="form-group">
                        <label for="name">ชื่อสินค้า:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $row_product['name']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="description">รายละเอียดสินค้า:</label>
                        <textarea class="form-control" id="description" name="description" rows="5"><?php echo $row_product['description']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="price">ราคาสินค้า:</label>
                        <input type="number" class="form-control" id="price" name="price" value="<?php echo $row_product['price']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="tel_number">เบอร์โทรศัพท์:</label>
                        <input type="text" class="form-control" id="tel_number" name="tel_number" value="<?php echo $row_product['tel_number']; ?>">
                    </div>

                    <!-- ส่วนที่เพิ่มเข้ามา -->
                    <div class="form-group">
                        <label for="image">รูปภาพสินค้า:</label>
                        <div class="row">
                            <?php
                            if (mysqli_num_rows($result_images) > 0) {
                                while ($row_image = mysqli_fetch_assoc($result_images)) {
                            ?>
                                    <div class="col-md-3">
                                        <img src="images/product/large-size/<?php echo $row_image['image']; ?>" class="img-fluid">

                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <!-- ส่วนเดิม -->

                    <button type="submit" class="btn btn-primary">บันทึก</button>
                    <a href="myproducts.php" class="btn btn-secondary">ยกเลิก</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include 'include/footer.php'
?>