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
$sql = "SELECT * FROM products WHERE id = $product_id AND user_id = $user_id";
$result = mysqli_query($conn, $sql);

// ตรวจสอบว่ามีข้อมูลของสินค้าที่ต้องการแก้ไขหรือไม่
if (mysqli_num_rows($result) == 0) {
    // หากไม่พบสินค้าที่ต้องการแก้ไขให้ redirect ไปยังหน้าที่เหมาะสม
    header("Location: myproduct.php");
    exit();
}

$row = mysqli_fetch_assoc($result);
?>

<div class="Shopping-cart-area pt-60 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>แก้ไขสินค้า</h2>
                <form action="update_product.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                    <div class="form-group">
                        <label for="name">ชื่อสินค้า:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="description">รายละเอียดสินค้า:</label>
                        <textarea class="form-control" id="description" name="description" rows="5"><?php echo $row['description']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="price">ราคาสินค้า:</label>
                        <input type="number" class="form-control" id="price" name="price" value="<?php echo $row['price']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="price">เบอร์โทรศัพท์:</label>
                        <input type="text" class="form-control" id="tel_number" name="tel_number" value="<?php echo $row['tel_number']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="image">รูปภาพสินค้า:</label>
                        <input type="file" class="form-control-file" id="image" name="image">
                        <img src="images/product/large-size/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" style="max-width: 200px;">
                    </div>
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