<?php
ob_start();
session_start(); // เริ่มต้น session
?>

<!doctype html>
<html class="no-js" lang="zxx">

<!-- index-431:41-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Home Version Four || limupa - Digital Products Store ECommerce Bootstrap 4 Template</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
    <!-- Material Design Iconic Font-V2.2.0 -->
    <link rel="stylesheet" href="css/material-design-iconic-font.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Font Awesome Stars-->
    <link rel="stylesheet" href="css/fontawesome-stars.css">
    <!-- Meanmenu CSS -->
    <link rel="stylesheet" href="css/meanmenu.css">
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <!-- Slick Carousel CSS -->
    <link rel="stylesheet" href="css/slick.css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="css/animate.css">
    <!-- Jquery-ui CSS -->
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <!-- Venobox CSS -->
    <link rel="stylesheet" href="css/venobox.css">
    <!-- Nice Select CSS -->
    <link rel="stylesheet" href="css/nice-select.css">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="css/magnific-popup.css">
    <!-- Bootstrap V4.1.3 Fremwork CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Helper CSS -->
    <link rel="stylesheet" href="css/helper.css">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- Modernizr js -->
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    
   
    <!--[if lt IE 8]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
    <!-- Begin Body Wrapper -->
    <div class="body-wrapper">
        <!-- Begin Header Area -->
        <header class="li-header-4">
            <!-- Begin Header Top Area -->
            <div class="header-top">
                <div class="container">
                    <div class="row">
                        <!-- Begin Header Top Left Area -->
                        <div class="col-lg-3 col-md-4">
                            <div class="header-top-left">
                                <ul class="phone-wrap">
                                    <!-- <li><span>Telephone Enquiry:</span><a href="#">(+123) 123 321 345</a></li> -->
                                </ul>
                            </div>
                        </div>
                        <!-- Header Top Left Area End Here -->
                        <!-- Begin Header Top Right Area -->
                        <div class="col-lg-9 col-md-8">
                            <div class="header-top-right">
                                <ul class="ht-menu">
                                    <!-- Begin Setting Area -->
                                    <?php if(isset($_SESSION['user_id'])): ?>
                             
                                    <li>
                                        <div class="ht-setting-trigger">
                                            <span><?php echo $_SESSION['fullname']; ?></span>
                                        </div>
                                        <div class="setting ht-setting">
                                            <ul class="ht-setting-list">
                                                <!-- <li><a href="cart.php">ตะกร้าของฉัน</a></li> -->
                                                <li><a href="favorite.php">สินค้าถูกใจ</a></li>
                                                <li><a href="myproduct.php">โพสต์ของฉัน</a></li>
                                                <li><a href="logout.php">ออกจากระบบ</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="addproduct.php" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> โพสต์สินค้า</a>
                                    </li>
                                    <?php else: ?>
                                    <!-- เมนูสำหรับผู้ใช้ที่ยังไม่ล็อกอิน -->
                                    <li><a href="login.php">Login</a></li>
                                    <li><a href="register.php">Register</a></li>
                                    <?php endif; ?>
                                    <!-- Setting Area End Here -->

                                    <!-- Language Area End Here -->
                                </ul>
                            </div>
                        </div>
                        <!-- Header Top Right Area End Here -->
                    </div>
                </div>
            </div>
            <!-- Header Top Area End Here -->
            <!-- Begin Header Middle Area -->
            <div class="header-middle pl-sm-0 pr-sm-0 pl-xs-0 pr-xs-0">
                <div class="container">
                    <div class="row">
                        <!-- Begin Header Logo Area -->
                        <div class="col-lg-3">
                            <div class="logo pb-sm-30 pb-xs-30">
                                <a href="index.php">
                                    <!-- <img src="images/menu/logo/2.jpg" alt=""> -->
                                    <h3>2HANDSHOP</h3>
                                </a>
                            </div>
                        </div>
                        <!-- Header Logo Area End Here -->
                        <!-- Begin Header Middle Right Area -->
                        <div class="col-lg-9 pl-0 ml-sm-15 ml-xs-15">
                            <!-- Begin Header Middle Searchbox Area -->
                            <form action="products.php" class="hm-searchbox">
                                <select onchange="redirectToProducts(this)" class="nice-select select-search-category">
                                    <option value="0">All</option>
                                    <!-- loop เพื่อแสดงรายการ categories -->
                                    <?php 
                                    // เชื่อมต่อกับฐานข้อมูล
include 'config/connect.php';

// สร้างคำสั่ง SQL เพื่อดึงข้อมูล categories จากตาราง categories
$sql = "SELECT id, name FROM categories";

// ทำการ query ข้อมูล
$result = $conn->query($sql);

                                    
                                    while($row = $result->fetch_assoc()){ ?>
                                    <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                                    <?php } ?>
                                    <!-- จบการ loop -->
                                </select>
                                <input type="text" name="search" placeholder="Enter your search key ...">
                                <button class="li-btn" type="submit"><i class="fa fa-search"></i></button>
                            </form>
                            <script>
    // Function เมื่อเลือก option จาก dropdown ให้ redirect ไปยังหน้า products.php พร้อมส่งค่า id ของหมวดหมู่ไปด้วย
    function redirectToProducts(selectElement) {
        var categoryId = selectElement.value;
        window.location.href = "products.php?search=" + categoryId;
    }
</script>
                            <!-- Header Middle Searchbox Area End Here -->
                            <!-- Begin Header Middle Right Area -->
                            <div class="header-middle-right">
                                <ul class="hm-menu">
                                    <!-- Begin Header Middle Wishlist Area -->
                                    <li class="hm-wishlist">
                                        <a href="favorite.php">
                                            <?php
                                           if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // คำสั่ง SQL เพื่อดึงจำนวนสินค้าในรายการสิ่งที่ชื่นชอบของผู้ใช้จากตาราง favorite
    $wishlist_sql = "SELECT COUNT(*) AS wishlist_count FROM favorite WHERE user_id = $user_id";
    $wishlist_result = $conn->query($wishlist_sql);

    if($wishlist_result) {
        $wishlist_row = $wishlist_result->fetch_assoc();
        $wishlist_count = $wishlist_row['wishlist_count'];

        // แสดงจำนวนสินค้าใน wishlist
        echo '<span class="cart-item-count wishlist-item-count">' . $wishlist_count . '</span>';
    } else {
        echo "Error retrieving wishlist count: " . $conn->error;
    }
} else {
    // ถ้าไม่ได้ล็อกอิน แสดงจำนวนสินค้าใน wishlist เป็น 0
    echo '<span class="cart-item-count wishlist-item-count">0</span>';
}
?>
                                            <i class="fa fa-heart-o"></i>
                                        </a>
                                    </li>
                                    <!-- Header Middle Wishlist Area End Here -->
                                    <!-- Begin Header Mini Cart Area -->
                                    <?php

// if(isset($_SESSION["user_id"])){
//     $user_id = $_SESSION['user_id'];

//     // สร้างคำสั่ง SQL เพื่อดึงข้อมูลในตาราง carts ของผู้ใช้นั้น
//     $sql = "SELECT * FROM carts WHERE user_id = $user_id";
//     $result = $conn->query($sql);

//     // ตรวจสอบว่ามีข้อมูลในตะกร้าหรือไม่
//     if ($result->num_rows > 0) {
//         $total_items = 0;
//         $total_price = 0;
        
//         // นับจำนวนรายการสินค้าในตะกร้าและคำนวณราคารวม
//         // while($row = $result->fetch_assoc()) {
//         //     $total_items += $row['qty'];
//         //     $total_price += $row['amount'];
//         // }
        
//         // แสดงข้อมูลรายการสินค้าและมูลค่ารวมในตะกร้า
//         echo '
        
//         <li class="hm-minicart">
//         <a href="cart.php">

//                   <div class="hm-minicart-trigger">
//                       <span class="item-icon"></span>
//                       <span class="item-text">'.$total_price.'
//                           <span class="cart-item-count">'.$total_items.'</span>
//                       </span>
//                   </div>
//               </a>

//               </li>';
//     } else {
//         // หากไม่มีสินค้าในตะกร้า
//         echo '
//         <li class="hm-minicart">
//         <a href="cart.php">

//                   <div class="hm-minicart-trigger">
//                       <span class="item-icon"></span>
//                       <span class="item-text">0.00
//                           <span class="cart-item-count">0</span>
//                       </span>
//                   </div>
//                   </a>
//               </li>
//               ';
//     }
// } else {
//     // หากไม่ได้ล็อกอิน
//     echo '<li class="hm-minicart">
//               <div class="hm-minicart-trigger">
//                   <span class="item-icon"></span>
//                   <span class="item-text">£0.00
//                       <span class="cart-item-count">0</span>
//                   </span>
//               </div>
//           </li>';
// }
// ?>
</a>
                                    <!-- Header Mini Cart Area End Here -->
                                </ul>
                            </div>
                            <!-- Header Middle Right Area End Here -->
                        </div>
                        <!-- Header Middle Right Area End Here -->
                    </div>
                </div>
            </div>
            <!-- Header Middle Area End Here -->
            <!-- Begin Header Bottom Area -->
            <div class="header-bottom header-sticky stick d-none d-lg-block d-xl-block">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Begin Header Bottom Menu Area -->
                            <div class="hb-menu">
                                <nav>
                                    <ul>
                                        <li>
                                            <a href="index.php">หน้าแรก</a>

                                        </li>

                                        <li><a href="products.php">สินค้าทั้งหมด</a></li>
                                        <!-- <li><a href="contact.php">ติดต่อเรา</a></li> -->

                                    </ul>
                                </nav>
                            </div>
                            <!-- Header Bottom Menu Area End Here -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Header Bottom Area End Here -->
            <!-- Begin Mobile Menu Area -->
            <div class="mobile-menu-area mobile-menu-area-4 d-lg-none d-xl-none col-12">
                <div class="container">
                    <div class="row">
                        <div class="mobile-menu">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu Area End Here -->
        </header>