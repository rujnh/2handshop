<?php
// session_start(); // เริ่ม session

include 'include/header.php';
include 'config/connect.php';



?>

<div class="Shopping-cart-area pt-60 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="/action/updatecart.php" method="POST">
                
                    <div class="table-content table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="li-product-remove">ลบ</th>
                                    <th class="li-product-thumbnail">รูปภาพ</th>
                                    <th class="cart-product-name">รายการ</th>
                                    <th class="li-product-price">ราคาต่อหน่วย</th>
                                    <th class="li-product-quantity">จำนวน</th>
                                    <th class="li-product-subtotal">รวม</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
                                    $sql = "SELECT carts.id as cat_id, carts.user_id, carts.product_id, carts.qty, carts.amount, products.name, products.description, products.color
                                        FROM carts
                                        INNER JOIN products ON carts.product_id = products.id
                                        WHERE carts.user_id = ".$_SESSION['user_id']." ";

                                    $result = $conn->query($sql);
                                
                                    $subTotal = 0;
                                    $total = 0;

                                    if ($result->num_rows > 0) {

                                        while ($row = $result->fetch_assoc()) {
                                            $subTotal = ($row['amount'] * $row['qty']);
                                            $total += $subTotal;
                                            echo "<input type='hidden' name='cart_id' value='".$row['cat_id']."'>";
                                            echo "<tr>";
                                            echo "<td class='li-product-remove'><a href='/action/removecart.php?id=".$row['cat_id']."'><i class='fa fa-times'></i></a></td>";
                                            echo "<td class='li-product-thumbnail'><a href='#'><img src='images/product/small-size/{$row['product_id']}.jpg' alt='Li's Product Image'></a></td>";
                                            echo "<td class='li-product-name'><a href='#'>". $row['name'] ."</a></td>";
                                            echo "<td class='li-product-price'><span class='amount'>$". $row['amount'] ."</span></td>";
                                            echo "<td class='quantity'>";
                                            echo "<label>จำนวน</label>";
                                            echo "<div class='cart-plus-minus'>";
                                            echo "<input class='cart-plus-minus-box' name='qty' value='". $row['qty'] ."' type='text'>";
                                            echo "<div class='dec qtybutton'><i class='fa fa-angle-down'></i></div>";
                                            echo "<div class='inc qtybutton'><i class='fa fa-angle-up'></i></div>";
                                            echo "</div>";
                                            echo "</td>";
                                            echo "<td class='product-subtotal'><span class='amount'>$". $row['amount'] * $row['qty'] ."</span></td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "0 results";
                                    }
                                } else {
                                    echo "ไม่มี session หรือ session ถูกทำลาย";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="coupon-all">
                           
                                <div class="coupon2">
                                    <input class="button" name="update_cart" value="Update cart" type="submit">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 ml-auto">
                            <div class="cart-page-total">
                                <h2>Cart totals</h2>
                                <ul>
                                    <li>Subtotal <span><?php echo number_format($total,2); ?></span></li>
                                    <li>Total <span><?php echo number_format($total,2); ?></span></li>
                                </ul>
                                <a href="/action/order.php">ยืนยันการสั่งซื้อ</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include 'include/footer.php'
?>
