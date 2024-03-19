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
          <?php if (isset($row['sticker']) && $row['sticker']): ?>
          <span class="sticker">New</span>
          <?php endif; ?>
        </div>
        <div class="product_desc">
          <div class="product_desc_info">
            <div class="product-review">
              <h5 class="manufacturer">
                <a href="shop-left-sidebar.php"><?php echo $row['category_name']; ?></a>
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
              <?php if (isset($row['old_price'])): ?>
              <span class="old-price">$<?php echo $row['old_price']; ?></span>
              <?php endif; ?>
              <?php if (isset($row['discount_percentage'])): ?>
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
    echo "0 results";
}
?>

                                               
                                            </div>
                                        </div>
                                
                                    
                    
                            </div>
                            <!-- shop-products-wrapper end -->
                        </div>
                        <div class="col-lg-3 order-2 order-lg-1">
                            <!--sidebar-categores-box start  -->
                            <div class="sidebar-categores-box mt-sm-30 mt-xs-30">
                                
                            <!--sidebar-categores-box end  -->
                            <!--sidebar-categores-box start  -->
                            <div class="sidebar-categores-box">
                                <div class="sidebar-title">
                                    <h2>Filter By</h2>
                                </div>
                                <!-- btn-clear-all start -->
                                <button class="btn-clear-all mb-sm-30 mb-xs-30">Clear all</button>
                                <!-- btn-clear-all end -->
                                <!-- filter-sub-area start -->
                                <!-- <div class="filter-sub-area">
                                    <h5 class="filter-sub-titel">Brand</h5>
                                    <div class="categori-checkbox">
                                        <form action="#">
                                            <ul>
                                                <li><input type="checkbox" name="product-categori"><a href="#">Prime Video (13)</a></li>
                                                <li><input type="checkbox" name="product-categori"><a href="#">Computers (12)</a></li>
                                                <li><input type="checkbox" name="product-categori"><a href="#">Electronics (11)</a></li>
                                            </ul>
                                        </form>
                                    </div>
                                 </div> -->
                                <!-- filter-sub-area end -->
                                <!-- filter-sub-area start -->
                                <div class="filter-sub-area pt-sm-10 pt-xs-10">
    <h5 class="filter-sub-titel">Categories</h5>
    <div class="categori-checkbox">
        <form action="#">
            <ul>
                <?php
                $cate = "SELECT id, name FROM categories";

                // ทำการ query ข้อมูล
                $categories = $conn->query($cate);

                // ถ้ามีข้อมูลหมวดหมู่สินค้า
                if ($categories->num_rows > 0) {
                    while ($category = $categories->fetch_assoc()) {
                        $categoryId = $category['id'];
                        // ค้นหาจำนวนสินค้าในหมวดหมู่นี้
                        $countSql = "SELECT COUNT(*) AS count FROM products WHERE category_id = $categoryId";
                        $countResult = $conn->query($countSql);
                        $countRow = $countResult->fetch_assoc();
                        $productCount = $countRow['count'];

                        // แสดงรายการหมวดหมู่พร้อมกับจำนวนสินค้า
                        echo '<li><input type="checkbox" name="category[]" value="' . $categoryId . '"><a href="#">' . $category['name'] . ' (' . $productCount . ')</a></li>';
                    }
                } else {
                    echo "No categories available.";
                }
                ?>
            </ul>
        </form>
    </div>
</div>


                                <!-- filter-sub-area end -->
                                <!-- filter-sub-area start -->
                                <!-- <div class="filter-sub-area pt-sm-10 pt-xs-10">
                                    <h5 class="filter-sub-titel">Size</h5>
                                    <div class="size-checkbox">
                                        <form action="#">
                                            <ul>
                                                <li><input type="checkbox" name="product-size"><a href="#">S (3)</a></li>
                                                <li><input type="checkbox" name="product-size"><a href="#">M (3)</a></li>
                                                <li><input type="checkbox" name="product-size"><a href="#">L (3)</a></li>
                                                <li><input type="checkbox" name="product-size"><a href="#">XL (3)</a></li>
                                            </ul>
                                        </form>
                                    </div>
                                </div> -->
                                <!-- filter-sub-area end -->
                                <!-- filter-sub-area start -->
                                <div class="filter-sub-area pt-sm-10 pt-xs-10">
                                    <h5 class="filter-sub-titel">Color</h5>
                                    <div class="color-categoriy">
                                        <form action="#">
                                            <ul>
                                                <li><span class="white"></span><a href="#">White (1)</a></li>
                                                <li><span class="black"></span><a href="#">Black (1)</a></li>
                                                <li><span class="Orange"></span><a href="#">Orange (3) </a></li>
                                                <li><span class="Blue"></span><a href="#">Blue  (2) </a></li>
                                            </ul>
                                        </form>
                                    </div>
                                </div>
                                <!-- filter-sub-area end -->
                                <!-- filter-sub-area start -->
                                <!-- <div class="filter-sub-area pt-sm-10 pb-sm-15 pb-xs-15">
                                    <h5 class="filter-sub-titel">Dimension</h5>
                                    <div class="categori-checkbox">
                                        <form action="#">
                                            <ul>
                                                <li><input type="checkbox" name="product-categori"><a href="#">40x60cm (6)</a></li>
                                                <li><input type="checkbox" name="product-categori"><a href="#">60x90cm (6)</a></li>
                                                <li><input type="checkbox" name="product-categori"><a href="#">80x120cm (6)</a></li>
                                            </ul>
                                        </form>
                                    </div> -->
                                 </div>
                                <!-- filter-sub-area end -->
                            </div>
                            <!--sidebar-categores-box end  -->
                            <!-- category-sub-menu start -->
                            
                        </div>
                    </div>
                </div>
            </div>

            <?php

 include 'include/footer.php'

?>