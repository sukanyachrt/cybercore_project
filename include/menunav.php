<?php
$producttype = new Connect_Data();
$producttype->connectData();
$product = new Connect_Data();
$product->connectData();
?>
<style>

</style>
<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center justify-content-between">

        <h1 class="logo"><a href="index.php">CyberCore.</a></h1>
        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto active" href="index.php#home">หน้าหลัก</a></li>
                <!-- <li><a class="nav-link scrollto" href="index.php#about">เกี่ยวกับ</a></li> -->
                <li class="dropdown"><a href="index.php#product"><span>รายการสินค้า</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <?php
                        $producttype->sql = "SELECT protype_id,protype_name 
FROM	producttype WHERE	protype_status = 1 GROUP BY	protype_id";
                        $producttype->queryData();
                        while ($rsproducttype = $producttype->fetch_AssocData()) {
                        ?>
                            <li><a href="producttype.php?id=<?= $rsproducttype['protype_id'] ?>">
                                    <?= $rsproducttype['protype_name'] ?>
                                </a></li>
                            <?php

                            ?>

                        <?php
                        }
                        ?>
                    </ul>
                </li>
                <li><a class="nav-link scrollto" href="index.php#contact">ช่องทางการติดต่อ</a></li>
                <li><a href="order.php">ออเดอร์ของฉัน</a></li>
                <li class="cartNav"><a href="cart.php">ตะกร้าสินค้า
                        <div>
                            <i class="bi bi-cart2" style="font-size: 25px;"></i>
                            <span class="badge bg-danger">
                                <span class="cart">
                                    <?php
                                    if (isset($_SESSION['cart'])) {
                                        echo array_sum($_SESSION['cart']);
                                    } else {
                                        echo "0";
                                    }

                                    ?>
                                </span>
                            </span>
                        </div>
                    </a>

                </li>

            </ul>


        </nav>

        <div class="social-links">
            <?php
            if (isset($_SESSION['customer_id'])) {
            ?>
                <div class="dropdown">
                    <button class="dropbtn"><i class="bi bi-person" style="font-size: 20px;"></i>
                        <?php
                        if (isset($_SESSION['customer_id'])) {
                            echo $_SESSION['customer_fname']." ".$_SESSION['customer_fname'];
                        }
                        ?>
                        <i class="bi bi-caret-down-fill"></i>
                    </button>
                    <div class="dropdown-content">
                        <a href="profile.php">ข้อมูลส่วนตัว</a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalConfirmlogout">ออกจากระบบ</a>

                    </div>
                </div>

            <?php } else {
            ?>
                <a href="login.php" class="login text-center" style=" color: #0b2341;
  font-size: 16px;"><i class="bi bi-person" style="font-size: 28px;"></i>
                    <?php
                    if (isset($_SESSION['customer_id'])) {
                        echo $_SESSION['customer_fname'];
                    } else {
                        echo "บัญชีของฉัน";
                    }
                    ?>
                </a>
            <?php
            } ?>



            <a href="cart.php" class="cartlink" style=" color: #0b2341;
  font-size: 28px;
  cursor: pointer;
  line-height: 0;
  transition: 0.5s;">

                <div class="cart">
                    <span class="count">
                        <?php
                        if ($_SESSION['cart']) {
                            echo array_sum($_SESSION['cart']);
                        } else {
                        }

                        ?>
                    </span>
                    <i class="bi bi-cart2"></i>
                </div>


            </a>
            <i class="bi bi-list mobile-nav-toggle"></i>



        </div>

    </div>
</header>
<!-- Modal -->
<div class="modal fade" id="modalConfirmlogout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                คุณต้องการออกจากระบบใช่ไหม ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-warning" onclick="confirmLogout()">ยืนยัน</button>
            </div>
        </div>
    </div>
</div>
<style>
    .social-links {
        margin-left: auto;

    }

    .social-links a {
        margin-left: 15px;

    }

    .login {
        padding-right: 10px;
    }

    .cartNav {
        display: none;
    }

    .cartlink {
        padding-right: 20px;
    }

    @media (max-width: 700px) {
        .cartNav {
            display: block;
        }


        .cartlink {
            display: none;
        }
    }

    .dropbtn {
        background-color: #fff;
        color: #000;
        padding: 16px;
        font-size: 16px;
        border: none;
        font-weight: 400;
    }

    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f1f1f1;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown-content a {
        color: black;
        padding: 20px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #ddd;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var cartCount = parseInt($(".cart .count").text());
    if (cartCount === 0 || isNaN(cartCount)) {
        $(".cart .count").css("background", "none");
        $(".cart .count").css("width", "0");
    }

    function confirmLogout() {
        window.location = "logout.php"
    }
</script>