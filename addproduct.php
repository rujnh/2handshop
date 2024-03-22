<?php
include 'include/header.php';
include 'config/connect.php';

// ตรวจสอบว่ามีการเข้าสู่ระบบหรือไม่
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
                    <!-- ตัวเลือกของสภาพสินค้าจะถูกเติมจากฐานข้อมูล -->
                    <option value="">กรุณาเลือกสภาพสินค้า</option>
                    <!-- ตัวอย่างการเติมตัวเลือก -->
                    <?php
                    // เชื่อมต่อกับฐานข้อมูล
                    include 'config/connect.php';

                    // สร้างคำสั่ง SQL เพื่อดึงข้อมูลสภาพสินค้าจากตาราง product_condition
                    $sql = "SELECT id, name FROM product_condition";

                    // ทำการ query ข้อมูล
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) { ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                    <?php } ?>
                    <!-- เพิ่มตัวเลือกตามสภาพสินค้าที่มีในฐานข้อมูล -->
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

                    // สร้างคำสั่ง SQL เพื่อดึงข้อมูลหมวดหมู่สินค้าจากตาราง categories
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
                <input type="file" class="form-control-file" id="image" name="image[]" multiple="multiple" accept="image/*" multiple onchange="previewImages(event)">
                <div id="imagePreview"></div> <!-- ส่วนนี้จะใช้สำหรับแสดงรูปภาพ -->
                <button type="button" id="removeImageButton" class="btn" onclick="removeImage()" style="color: red; background: none; border: none; font-size: 1.2em; display: none;">
                    &times;
                </button>



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
<script>
    // ฟังก์ชันตรวจสอบนามสกุลของไฟล์ภาพ
    function checkFileType(file) {
        // กำหนดนามสกุลของไฟล์ที่ยอมรับ
        const allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
        // ตรวจสอบว่านามสกุลของไฟล์ตรงกับที่ระบุหรือไม่
        return allowedExtensions.test(file.name);
    }

    // ฟังก์ชันตรวจสอบไฟล์ที่เลือกเป็นรูปภาพ
    function validateImages() {
        // หากมีไฟล์ที่เลือก
        if (this.files.length > 0) {
            // วนลูปทุกไฟล์
            for (let i = 0; i < this.files.length; i++) {
                // ตรวจสอบนามสกุลของไฟล์
                if (!checkFileType(this.files[i])) {
                    // แสดงข้อความแจ้งเตือน
                    alert("กรุณาเลือกไฟล์ภาพที่มีนามสกุล .jpg, .jpeg, .png, .gif เท่านั้น");
                    // ล้างค่า input file
                    this.value = '';
                    removeImage();
                    return false;
                }

            }
        }
        return true;
    }

    // เชื่อมตัวแสดงผลกับ input file
    const inputImages = document.getElementById('image');
    // เมื่อมีการเลือกไฟล์ภาพ
    inputImages.addEventListener('change', validateImages);
    var counter = 0; // เพิ่มตัวแปรนับรูปภาพ

    function previewImages(event) {
        var preview = document.getElementById('imagePreview');
        var files = event.target.files;

        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            var reader = new FileReader();

            reader.onload = function(event) {
                var imgContainer = document.createElement('div'); // สร้างคอนเทนเนอร์สำหรับรูปภาพและปุ่มลบ
                imgContainer.setAttribute('style', 'display: inline-block; margin-right: 10px; position: relative;');

                var img = document.createElement('img');
                img.setAttribute('src', event.target.result);
                img.setAttribute('style', 'max-width: 300px; max-height: 300px; margin: 5px;');
                img.setAttribute('id', 'img_' + counter); // กำหนด id ให้กับรูปภาพ
                imgContainer.appendChild(img); // เพิ่มรูปภาพลงในตำแหน่งที่กำหนดไว้

                var removeButton = document.createElement('button'); // สร้างปุ่มลบ
                removeButton.innerHTML = '[ลบ]'; // Unicode ของอักขระ X
                removeButton.style.color = 'red'; // เปลี่ยนสีข้อความเป็นสีแดง
                removeButton.style.position = 'absolute'; // ตั้งค่าตำแหน่งให้เป็น absolute
                removeButton.style.bottom = '-20px'; // ตั้งค่า bottom เพื่อให้ x อยู่ด้านล่างของรูปภาพ
                removeButton.style.left = '50%'; // จัดให้ x อยู่ตรงกลาง
                removeButton.style.transform = 'translateX(-50%)'; // ย้าย x ไปที่กึ่งกลาง
                removeButton.style.backgroundColor = 'transparent'; // ตั้งค่าสีพื้นหลังของปุ่มเป็นโปร่งใส
                removeButton.style.border = 'none'; // ตั้งค่าไม่มีเส้นขอบ
                removeButton.setAttribute('onclick', 'removeImage(' + counter + ')'); // เรียกใช้ฟังก์ชัน removeImage พร้อมส่งค่าตำแหน่งรูปภาพ
                imgContainer.appendChild(removeButton); // เพิ่มปุ่มลบลงในคอนเทนเนอร์

                preview.appendChild(imgContainer); // เพิ่มคอนเทนเนอร์รูปภาพและปุ่มลบลงในตำแหน่งที่กำหนดไว้
                counter++; // เพิ่มค่าตัวแปรนับรูปภาพ
            }

            reader.readAsDataURL(file); // อ่านไฟล์รูปภาพเพื่อแสดงตัวอย่าง
        }
    }



    function removeImage(id) {
        var imgContainer = document.getElementById('img_' + id).parentNode; // หาคอนเทนเนอร์ของรูปภาพ
        imgContainer.parentNode.removeChild(imgContainer); // ลบคอนเทนเนอร์ที่บรรจุรูปภาพออก
        counter--; // ลดค่าตัวแปรนับรูปภาพ


    }
</script>


<?php
include 'include/footer.php'
?>