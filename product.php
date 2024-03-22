<?php
include 'include/header.php';
include 'config/connect.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // สร้างคำสั่ง SQL เพื่อดึงข้อมูลของสินค้าที่มี ID ตรงกับที่รับมา
    $sql = "SELECT * FROM products WHERE id = $product_id";

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
                    <div class="col-lg-5 col-md-6">
                        <!-- Product Details Left -->
                        <div class="product-details-left">
                            <div class="product-details-images slider-navigation-1">
                                <?php
                                // แยกชื่อรูปภาพจากสตริงที่มีรูปภาพหลายรูป
                                $image_names = explode(',', $row['image']);
                                foreach ($image_names as $image_name) {
                                ?>
                                    <div class="lg-image">
                                        <a class="popup-img venobox vbox-item" href="images/product/large-size/<?php echo $image_name; ?>" data-gall="myGallery">
                                            <img src="images/product/large-size/<?php echo $image_name; ?>" alt="product image" style="max-width: 600px; max-height: 400px;">
                                        </a>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                            <!-- <div class="product-details-thumbs slider-thumbs-1">
                                <div class="sm-image"><img src="images/product/small-size/<?php echo $row['image']; ?>" alt="product image thumb"></div>
                            </div> -->
                        </div>
                        <!--// Product Details Left -->
                    </div>

                    <div class="col-lg-7 col-md-6">
                        <div class="product-details-view-content ">
                            <div class="product-info">
                                <div class="product-desc">
                                    <h2 style="font-size: 24px;"><strong style="color: black;"><?php echo $row['name']; ?></strong></h2>
                                    <div class="price-box">
                                        <span class="new-price new-price-2" style="color: #666666;">ราคา : <?php echo $row['price']; ?> บาท</span>
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

<?php
include 'include/footer.php';
?>