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

// คำสั่ง SQL เพื่อดึงข้อมูลของสินค้าที่ถูกใจของผู้ใช้
$sql = "SELECT products.*, favorite.id AS favorite_id FROM products
        INNER JOIN favorite ON products.id = favorite.product_id
        WHERE favorite.user_id = $user_id";

$result = mysqli_query($conn, $sql);
?>

<div class="Shopping-cart-area pt-60 pb-60">
    <div class="container">
        <form action="action/addproduct.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">ชื่อสินค้า:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="condition_id">สภาพสินค้า:</label>
                <select class="form-control" id="condition_id" name="condition_id" required>
                    <!-- ตัวเลือกของหมวดหมู่สินค้าจะถูกเติมจากฐานข้อมูล -->
                    <option value="">กรุณาเลือกสภาพสินค้า</option>
                    <!-- ตัวอย่างการเติมตัวเลือก -->
                    <?php
                    // เชื่อมต่อกับฐานข้อมูล
                    include 'config/connect.php';

                    // สร้างคำสั่ง SQL เพื่อดึงข้อมูล categories จากตาราง categories
                    $sql = "SELECT id, name FROM product_condition";

                    // ทำการ query ข้อมูล
                    $result = $conn->query($sql);


                    while ($row = $result->fetch_assoc()) { ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                    <?php } ?>
                    <!-- เพิ่มตัวเลือกตามหมวดหมู่สินค้าที่มีในฐานข้อมูล -->
                </select>
            </div>
            <div class="form-group">
                <label for="description">คำอธิบาย:</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="color">สี:</label>
                <input type="text" class="form-control" id="color" name="color" required>
            </div>
            <div class="form-group">
                <label for="category_id">หมวดหมู่:</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <!-- ตัวเลือกของหมวดหมู่สินค้าจะถูกเติมจากฐานข้อมูล -->
                    <option value="">กรุณาเลือกหมวดหมู่</option>
                    <!-- ตัวอย่างการเติมตัวเลือก -->
                    <?php
                    // เชื่อมต่อกับฐานข้อมูล
                    include 'config/connect.php';

                    // สร้างคำสั่ง SQL เพื่อดึงข้อมูล categories จากตาราง categories
                    $sql = "SELECT id, name FROM categories";

                    // ทำการ query ข้อมูล
                    $result = $conn->query($sql);


                    while ($row = $result->fetch_assoc()) { ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                    <?php } ?>
                    <!-- เพิ่มตัวเลือกตามหมวดหมู่สินค้าที่มีในฐานข้อมูล -->
                </select>
            </div>
            <div class="form-group">
                <label for="image">รูปภาพ:</label>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
            </div>


            <div class="form-group">
                <label for="price">ราคา:</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>

            <div class="form-group">
                <label for="tel_number">เบอร์โทรศัพท์:</label>
                <input type="text" class="form-control" id="tel_number" name="tel_number" required>
            </div>


            <button type="submit" class="btn btn-primary">เพิ่มสินค้า</button>
        </form>

    </div>
</div>

<?php
include 'include/footer.php'
?>