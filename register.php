<?php

include 'include/header.php';
include 'config/connect.php';




?>

<div class="page-section mb-60">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-6 col-xs-12 mx-auto">
                <form action="action/register.php" method="POST">
                    <div class="login-form">
                        <h4 class="login-title">Register</h4>
                        <div class="row">
                            <div class="col-md-12 col-12 mb-20">
                                <label>ชื่อ-นามสกุล</label>
                                <input class="mb-0" type="text" name="full_name" placeholder="First Name">
                            </div>
                  
                            <div class="col-md-6 mb-20">
                                <label>Email Address*</label>
                                <input class="mb-0" type="email" name="email" placeholder="Email Address">
                            </div>
                            <div class="col-md-6 mb-20">
                                <label>เบอร์โทรศัพท์*</label>
                                <input class="mb-0" type="text" name="phone" placeholder="เบอร์โทรศัพท์">
                            </div>
                            <div class="col-md-12 mb-20">
                                <label>รหัสผ่าน</label>
                                <input class="mb-0" type="password" name="password" placeholder="Password">
                            </div>
          
                            <div class="col-12">
                                <button type="submit" class="register-button mt-0">สมัครสมาชิก</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
    </div>


    <?php

// include 'include/footer.php'

?>