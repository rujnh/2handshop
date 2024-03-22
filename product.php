<?php
include 'include/header.php';
include 'config/connect.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // สร้างคำสั่ง SQL เพื่อดึงข้อมูลของสินค้าที่มี ID ตรงกับที่รับมา
    $sql = "SELECT p.*, c.name AS category_name 
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.id = $product_id";

    // ทำการ query ข้อมูล
    $result = $conn->query($sql);

    // ตรวจสอบว่ามีข้อมูลหรือไม่
    if ($result->num_rows > 0) {
        // ถ้ามีข้อมูล ให้แสดงข้อมูลของสินค้า
        $row = $result->fetch_assoc();
?>
        <div class="content-wraper">
            <div class="container">
                <div class="row single-product-area">
                    <div class="sc-gdwhfx-1 iesnFf">
                        <div class="sc-gdwhfx-0 jIOOZn">
                            <!-- Product Details Left -->
                            <div class="product-details-left">
                                <div class="product-details-images slider-navigation-1">
                                    <?php
                                    // ดึงรายการรูปภาพจาก product_images สำหรับสินค้านี้
                                    $sql_images = "SELECT image FROM product_images WHERE product_id = $product_id";
                                    $result_images = $conn->query($sql_images);

                                    if ($result_images->num_rows > 0) {
                                        while ($row_image = $result_images->fetch_assoc()) {
                                    ?>
                                            <div class="lg-image">
                                                <a class="popup-img venobox vbox-item" href="images/product/large-size/<?php echo $row_image['image']; ?>" data-gall="myGallery">
                                                    <img src="images/product/large-size/<?php echo $row_image['image']; ?>" alt="product image" style="max-width: 600px; max-height: 400px;" class="product-image">
                                                </a>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                    <!-- ปุ่ม Previous -->

                                </div>

                            </div>
                            <button id="prevButton">&#60;</button>
                            <button id="nextButton">&#62;</button>
                        </div>
                        <div class="col-lg-7 col-md-6">

                            <div class="product-details-view-content ">
                                <div class="product-info">
                                    <div class="product-desc">
                                        <p></p>
                                        <h2 style="font-size: 24px;"><strong style="color: black;"><?php echo $row['name']; ?></strong></h2>
                                        <div class="price-box">
                                            <span class="new-price new-price-2" style="color: #666666;">ราคา : <?php echo number_format($row['price'], 0); ?> บาท</span>

                                        </div>
                                    </div>
                                </div>
                                <div class="Details">
                                    <span class="description" style="color: black; font-size: 20px;">รายละเอียด</span>
                                    <p></p>
                                    <p>
                                        <span class="condition" style="color: #666666;">สภาพสินค้า : <?php echo $row['condition_name']; ?></span>
                                    </p>
                                    <p>
                                        <span class="typeproduct" style="color: #666666;">ประเภทสินค้า : <?php echo $row['category_name']; ?></span>
                                    </p>
                                    <p>
                                        <span class="colorproduct" style="color: #666666;">สีของสินค้า : <?php echo $row['color']; ?></span>
                                    </p>
                                </div>
                                <div class="product">

                                    <span class="description" style="color: black; font-size: 20px;">คำอธิบาย</span>
                                    <p></p>
                                    <p>
                                        <span><?php echo $row['description']; ?></span>
                                    </p>
                                    <p>
                                        <span class="text" style="color: black;">เบอร์โทรศัพท์ : 0<?php echo $row['tel_number']; ?></span>
                                    </p>
                                </div>
                            </div>

                            <style>
                                .product-details-left {
                                    /* กำหนดความกว้างสูงสุดของ container */
                                    max-width: 600px;
                                    max-height: 400px;
                                    margin: 0 auto;
                                    /* ทำให้ container อยู่ตรงกลาง */

                                    justify-content: center;
                                    /* จัดเรียง item ใน container ให้อยู่ตรงกลางในแนวนอน */
                                    align-items: center;
                                    /* จัดเรียง item ใน container ให้อยู่ตรงกลางในแนวตั้ง */
                                }

                                .product-image {

                                    object-fit: contain;
                                }

                                .product-details-images {
                                    position: relative;
                                }

                                /* CSS for the previous button */
                                #prevButton {
                                    position: absolute;
                                    top: 50%;
                                    left: 600px;
                                    /* ปรับตำแหน่งตามต้องการ */
                                    transform: translateY(-50%);
                                    background-color: rgba(0, 0, 0, 0.5);
                                    /* สีพื้นหลังของปุ่ม */
                                    color: white;
                                    /* สีตัวอักษร */
                                    border: none;
                                    border-radius: 50%;
                                    /* ทำให้มีรูปร่างเป็นวงกลม */
                                    width: 40px;
                                    /* ขนาดปุ่ม */
                                    height: 40px;
                                    /* ขนาดปุ่ม */
                                    font-size: 20px;
                                    /* ขนาดตัวอักษร */
                                    cursor: pointer;
                                }

                                /* CSS for the next button */
                                #nextButton {
                                    position: absolute;
                                    top: 50%;
                                    right: 600px;
                                    /* ปรับตำแหน่งตามต้องการ */
                                    transform: translateY(-50%);
                                    background-color: rgba(0, 0, 0, 0.5);
                                    /* สีพื้นหลังของปุ่ม */
                                    color: white;
                                    /* สีตัวอักษร */
                                    border: none;
                                    border-radius: 50%;
                                    /* ทำให้มีรูปร่างเป็นวงกลม */
                                    width: 40px;
                                    /* ขนาดปุ่ม */
                                    height: 40px;
                                    /* ขนาดปุ่ม */
                                    font-size: 20px;
                                    /* ขนาดตัวอักษร */
                                    cursor: pointer;
                                }
                            </style>




                            <style>
                                /* CSS for hiding images except the first one */
                                /* .lg-image:not(:first-child) {
                                display: none;
                            } */

                                /* CSS for the like button */
                                .like-button {
                                    display: inline-block;
                                    padding: 10px 20px;
                                    background-color: #dc3545;
                                    /* เปลี่ยนสีพื้นหลังเป็นสีแดง */
                                    color: #fff;
                                    /* เปลี่ยนสีของข้อความเป็นสีขาว */
                                    border: 1px solid #dc3545;
                                    border-radius: 5px;
                                    text-decoration: none;
                                    font-size: 16px;
                                    margin-right: 10px;
                                    /* ปรับขนาดระยะห่างระหว่างปุ่มแชทและปุ่มถูกใจ */
                                }

                                .like-button i {
                                    margin-right: 5px;
                                }
                            </style>

                            <!-- HTML for the like button -->
                            <div class="single-add-to-cart">
                                <form action="action/addcart.php" method="POST" class="cart-quantity">
                                    <!-- Form for adding to cart -->
                                    <a href="messenger.php?receiver_id=<?php echo $row['user_id']; ?>" class="add-to-cart" type="submit"><i class="fab fa-chat"></i> แชทผู้ขาย</a>
                                    <!-- Form for liking -->
                                    <a href="action/favorite.php?id=<?php echo $row['id']; ?>" class="like-button"><i class="fa fa-heart"></i> ถูกใจ</a>
                                    <i class="fa fa-heart text-danger"></i> <?php echo $row['favorite']; ?>
                                    <ul class="rating">
                                        <a href="action/favorite.php?id=<?php echo $row['id']; ?>">

                                        </a>
                                    </ul>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const productImages = document.querySelectorAll(".product-image");
                    let currentImageIndex = 0;

                    // ซ่อนรูปภาพทั้งหมดยกเว้นรูปภาพแรก
                    for (let i = 1; i < productImages.length; i++) {
                        productImages[i].style.display = "none";
                    }

                    // แสดงรูปภาพที่ 1 (รูปภาพแรก)
                    productImages[currentImageIndex].style.display = "block";

                    function nextImage() {
                        // ซ่อนรูปภาพปัจจุบัน
                        productImages[currentImageIndex].style.display = "none";

                        // เพิ่มดัชนีของรูปภาพขึ้น 1 หากไม่เกินขนาดของอาร์เรย์
                        currentImageIndex = (currentImageIndex + 1) % productImages.length;

                        // แสดงรูปภาพที่มีดัชนีใหม่
                        productImages[currentImageIndex].style.display = "block";

                        // ดึงรายละเอียดรูปภาพถัดไปและแสดง
                        fetch('get_next_image.php?id=<?php echo $product_id; ?>')
                            .then(response => response.json())
                            .then(data => {
                                if (!data.error) {
                                    // อัปเดต URL ของรูปภาพและ alt attribute
                                    const imageElement = productImages[currentImageIndex].querySelector('img');
                                    imageElement.src = 'images/product/large-size/' + data.image;
                                    imageElement.alt = 'product image';
                                } else {
                                    console.error(data.error);
                                }
                            })
                            .catch(error => console.error('เกิดข้อผิดพลาดในการดึงข้อมูลรูปภาพถัดไป:', error));
                    }

                    function prevImage() {
                        // ซ่อนรูปภาพปัจจุบัน
                        productImages[currentImageIndex].style.display = "none";

                        // ลดดัชนีของรูปภาพลง 1 หากไม่ติดลบ
                        currentImageIndex--;

                        // ถ้า currentImageIndex น้อยกว่า 0 ให้กลับไปแสดงรูปภาพสุดท้ายของอาร์เรย์
                        if (currentImageIndex < 0) {
                            currentImageIndex = productImages.length - 1;
                        }

                        // แสดงรูปภาพที่มีดัชนีใหม่
                        productImages[currentImageIndex].style.display = "block";
                    }

                    document.getElementById("nextButton").addEventListener("click", nextImage);
                    document.getElementById("prevButton").addEventListener("click", prevImage);
                });
            </script>
        </div>
<?php
    } else {
        // ถ้าไม่พบสินค้าที่ตรงกับ ID ที่รับมา
        echo "ไม่พบสินค้า";
    }
} else {
    // ถ้าไม่ได้รับ ID จาก URL
    echo "ไม่ได้รับข้อมูล ID";
}
?>
<div style="margin-bottom: 100px;"></div>
<?php
include 'include/footer.php';
?>