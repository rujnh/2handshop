<?php

include 'include/header.php';
include 'config/connect.php';




?>

<div class="page-section mb-60">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-xs-12 col-lg-6 mb-30 mx-auto">
                <!-- Login Form s-->
                <form action="action/login.php" method="POST">
                    <div class="login-form">
                        <h4 class="login-title">Login</h4>
                        <div class="row">
                            <div class="col-md-12 col-12 mb-20">
                                <label>Email Address*</label>
                                <input class="mb-0" type="email" name="email" placeholder="Email Address">
                            </div>
                            <div class="col-12 mb-20">
                                <label>Password</label>
                                <input class="mb-0" type="password" name="password" placeholder="Password">
                            </div>
                            <div class="col-md-8">
                                <div class="check-box d-inline-block ml-0 ml-md-2 mt-10">
                                    <input type="checkbox" id="remember_me">
                                    <label for="remember_me">Remember me</label>
                                </div>
                            </div>
                            <div class="col-md-4 mt-10 mb-20 text-left text-md-right">
                                <a href="/2handshop/forgotpass.php"> Forgot Password?</a>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="register-button mt-0">Login</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>


    <?php

    include 'include/footer.php'

    ?>