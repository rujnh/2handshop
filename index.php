<?php

include 'include/header.php';
include 'config/connect.php';


?>
<div class="content-wraper pt-60 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 order-1 order-lg-2">
                <!-- shop-top-bar end -->
                <!-- shop-products-wrapper start -->
                <div class="shop-products-wrapper">
                    <div class="product-area shop-product-area">
                        <div class="row">
                            <?php


                            // ตรวจสอบว่ามีการส่งค่าค้นหามาหรือไม่
                            if (isset($_GET['search'])) {
                                $search = $_GET['search'];
                                // สร้างคำสั่ง SQL เพื่อค้นหาข้อมูลของสินค้าที่ตรงกับเงื่อนไขที่ระบุ
                                $sql = "SELECT products.*, categories.name AS category_name 
            FROM products 
            LEFT JOIN categories ON products.category_id = categories.id 
            WHERE products.name LIKE '%$search%' OR products.color LIKE '%$search%' OR products.price LIKE '%$search%' OR categories.name LIKE '%$search%'";
                            } else {
                                // ถ้าไม่มีการส่งค่าค้นหามา ให้เรียกดึงข้อมูลสินค้าทั้งหมด
                                $sql = "SELECT products.*, categories.name AS category_name 
            FROM products 
            LEFT JOIN categories ON products.category_id = categories.id";
                            }

                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                            ?>
                                    <div class="col-lg-4 col-md-4 col-sm-6 mt-40">
                                        <!-- single-product-wrap start -->
                                        <div class="product-wrap">
                                            <div class="product-image">
                                                <a href="product.php?id=<?php echo $row['id']; ?>">
                                                    <img src="images/product/large-size/<?php echo $row['image']; ?>" alt="Li's Product Image">
                                                </a>
                                                <?php if (isset($row['sticker']) && $row['sticker']) : ?>
                                                    <span class="sticker">New</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="product_desc">
                                                <div class="product_desc_info">
                                                    <div class="product-review">
                                                        <h5 class="manufacturer">
                                                            <a href="shop-left-sidebar.php?category_name=<?php echo $row['category_name']; ?>"><?php echo $row['category_name']; ?></a>
                                                        </h5>
                                                        <div class="rating-box">
                                                            <ul class="rating">
                                                                <a href="action/favorite.php?id=<?php echo $row['id']; ?>">
                                                                    <i class="fa fa-heart text-danger"></i> <?php echo $row['favorite']; ?>
                                                                </a>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <h4><a class="product_name" href="product.php?id=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></h4>
                                                    <div class="price-box">
                                                        <span class="new-price">$<?php echo $row['price']; ?></span>
                                                        <?php if (isset($row['old_price'])) : ?>
                                                            <span class="old-price">$<?php echo $row['old_price']; ?></span>
                                                        <?php endif; ?>
                                                        <?php if (isset($row['discount_percentage'])) : ?>
                                                            <span class="discount-percentage"><?php echo '-' . $row['discount_percentage'] . '%'; ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="add-actions">
                                                    <ul class="add-actions-link">
                                                        <li class="add-cart active"><a href="#">Add to cart</a></li>
                                                        <li><a class="links-details" href="wishlist.php"><i class="fa fa-heart-o"></i></a></li>
                                                        <li><a href="#" title="quick view" class="quick-view-btn" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-eye"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- single-product-wrap end -->
                                    </div>
                            <?php
                                }
                            } else {
                                echo '<div class="no-product-message">ไม่พบสินค้า</div>';
                            }

                            ?>


                        </div>
                    </div>



                </div>
                <!-- shop-products-wrapper end -->
            </div>
            <style>
                .no-product-message {
                    text-align: center;
                    /* จัดข้อความตรงกลาง */
                    font-size: 50px;
                    /* ปรับขนาดตัวอักษรใหญ่ขึ้น */
                    margin-top: 20px;
                    /* กำหนดระยะห่างด้านบน */
                }

                .category-wrapper {
                    border: 1px solid #e0e0e0;
                    padding: 15px;
                    border-radius: 8px;
                    background-color: #f9f9f9;
                    margin-bottom: 10px;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    transition: background-color 0.3s ease;
                    text-decoration: none;
                    color: #333;
                }

                .category-wrapper:hover {
                    background-color: #e0e0e0;
                }

                .category-info {
                    display: flex;
                    flex-direction: column;
                }

                .category-name {
                    font-size: 16px;
                    font-weight: bold;
                    margin-bottom: 5px;
                }

                .product-count {
                    font-size: 14px;
                    color: #666;
                }

                .category-icon {
                    font-size: 24px;
                    color: #999;
                }
            </style>

            <div class="col-lg-3 order-2 order-lg-1">
                <div class="sidebar-category-container mt-sm-30 mt-xs-30">
                    <div class="sidebar-categores-box">
                        <div class="filter-sub-area pt-sm-10 pt-xs-10">
                            <h4 class="filter-sub-titel">Categories</h5>
                                <div class="categori-checkbox">
                                    <ul>
                                        <?php
                                        $sql = "SELECT id, name FROM categories";
                                        $categories = $conn->query($sql);
                                        if ($categories->num_rows > 0) {
                                            while ($category = $categories->fetch_assoc()) {
                                                $categoryName = $category['name'];
                                                $countSql = "SELECT COUNT(*) AS count FROM products WHERE category_name = '$categoryName'";
                                                $countResult = $conn->query($countSql);
                                                $countRow = $countResult->fetch_assoc();
                                                $productCount = $countRow['count'];
                                                echo '<li><a href="#" class="category-link mb-sm-30 mb-xs-30" data-category="' . $categoryName . '">
                                    <div class="category-wrapper">
                                        <div class="category-info">
                                            <div class="category-name">' . $category['name'] . '</div>
                                            <div class="product-count">(' . $productCount . ')</div>
                                        </div>
                                        <div class="category-icon">&#9654;</div>
                                    </div>
                                </a></li>';
                                            }
                                        } else {
                                            echo "No categories available.";
                                        }
                                        ?>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                var categoryLinks = document.querySelectorAll('.category-link');
                                                categoryLinks.forEach(function(link) {
                                                    link.addEventListener('click', function(event) {
                                                        event.preventDefault();
                                                        var categoryName = this.getAttribute('data-category');
                                                        redirectToProducts(categoryName);
                                                    });
                                                });

                                                function redirectToProducts(categoryName) {
                                                    window.location.href = "products.php?search=" + encodeURIComponent(categoryName);
                                                }
                                            });
                                        </script>
                                    </ul>
                                </div>
                        </div>
                    </div>
                </div>
            </div>




        </div>
    </div>
</div>

<?php

include 'include/footer.php'

?>