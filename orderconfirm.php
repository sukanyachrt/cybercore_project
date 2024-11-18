<?php
include("include/header.php");
?>
<link rel="stylesheet" href="assets/bs-stepper/css/bs-stepper.min.css">
<style>
    .active .bs-stepper-title {
        color: red;
    }

    .active .bs-stepper-circle {
        background-color: red !important;
    }
</style>
<?php
if (!isset($_SESSION['customer_id'])) {
    header('location:login.php?v=orderconfirm');
}
if (!isset($_SESSION['cart'])) {
    header('location:order.php');
}
$connect = new Connect_Data();
$connect->connectData();
?>

<body>
    <?php
    include("include/menunav.php");
    ?>
    <section id="material" class="material">
        <div class="container mt-4">
            <div class="row">
                <div class="col-12">

                    <div class="bs-stepper wizard-modern wizard-modern-example">
                        <div class="bs-stepper-header table-responsive">
                            <div class="step" data-target="#data-address">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-circle">1</span>
                                    <span class="text-sm bs-stepper-title">วิธีการจัดส่ง</span>

                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#data-payment">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-circle">2</span>
                                    <span class="text-sm bs-stepper-title">ชำระเงิน</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#installation-work-detail">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-circle">3</span>
                                    <span class="text-sm bs-stepper-title">สังซื้อเสร็จสมบูรณ์</span>
                                </button>
                            </div>
                        </div>
                        <div class="bs-stepper-content">
                            <div id="data-address" class="content">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-4">
                                            <h6>ที่อยู่สำหรับจัดส่ง</h6>
                                            <?php

                                            $connect->sql = "SELECT * FROM 	customers  WHERE customer_id ='" . $_SESSION['customer_id'] . "'";
                                            $connect->queryData();
                                            $rsconnect = $connect->fetch_AssocData();
                                            ?>
                                            <div class="col mt-3">
                                                <div class="card radius-10 border-start border-0 border-3 border-danger">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                                <div>
                                                                    <p class="mb-0 text-secondary"><?= $rsconnect['customer_fname'] . " " . $rsconnect['customer_lname'] ?></p>
                                                                    <p class="my-1"><?= $rsconnect['c_address'] ?></p>
                                                                    <p class="mb-0 font-13"><?= $rsconnect['customer_telephone'] ?></p>
                                                                </div>
                                                                <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i class="fa fa-shopping-cart"></i>
                                                                </div>
                                                            </div>
                                                            <!-- <div class="col-md-4 mt-4 mt-sm-0 d-none d-md-block">
                                                                <div class="text-center text-md-end">
                                                                    <a href="#" class="text-danger">แก้ไข
                                                                        <i class="bi bi-pencil-square"></i>
                                                                    </a>
                                                                </div>
                                                            </div> -->
                                                        </div>

                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-12 d-flex justify-content-center">
                                        <div class="col-12 text-end">
                                            <a href="cart.php"  class="btn btn-secondary"><i class="bi bi-arrow-left-circle"></i> ย้อนกลับ</a>
                                            <a href="#" onclick="stepper.next()" class="btn btn-danger"><i class="bi bi-arrow-right-circle"></i> ต่อไป</a>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div id="data-payment" class="content">
                                <div class="row">
                                    <div class="col-12">
                                        <h6>ข้อมูลการชำระเงิน</h6>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="">
                                                <div class="col">
                                                    <div class="card radius-10 border-start border-0 border-3 border-danger">
                                                        <div class="card-body">
                                                            <h6>บัญชีธนาคารที่ใช้รับชำระค่าบริการ</h6>
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th></th>
                                                                            <th>ธนาคาร</th>
                                                                            <th>สาขา</th>
                                                                            <th>เลขที่บัญชี</th>
                                                                            <th>ชื่อบัญชี </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr class="odd">
                                                                            <td><img src="assets/img/bank/kbank.gif" width="50" align="absmiddle"></td>
                                                                            <td>กสิกรไทย</td>
                                                                            <td>สำนักสีลม</td>
                                                                            <td>1234567890</td>
                                                                            <td>บจก. บางปะหันบรรจุภัณฑ์</td>
                                                                        </tr>
                                                                        <tr class="">
                                                                            <td><img src="assets/img/bank/bbl.gif" width="50" align="absmiddle"></td>
                                                                            <td>กรุงเทพ</td>
                                                                            <td>สำนักงานใหญ่สีลม</td>
                                                                            <td>1234567890</td>
                                                                            <td>บจก. บางปะหันบรรจุภัณฑ์</td>
                                                                        </tr>
                                                                        <tr class="odd">
                                                                            <td><img src="assets/img/bank/ktb.gif" width="50" align="absmiddle"></td>
                                                                            <td>กรุงไทย</td>
                                                                            <td>สีลม</td>
                                                                            <td>1234567890</td>
                                                                            <td>บจก. บางปะหันบรรจุภัณฑ์</td>
                                                                        </tr>
                                                                        <tr class="">
                                                                            <td><img src="assets/img/bank/scb.gif" width="50" align="absmiddle"></td>
                                                                            <td>ไทยพาณิชย์</td>
                                                                            <td>ปาโซ่ ทาวเวอร์</td>
                                                                            <td>1234567890</td>
                                                                            <td>บจก. บางปะหันบรรจุภัณฑ์</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mt-5 mt-lg-0">
                                                <div class="card border shadow-none">
                                                    <div class="card-header bg-gray border-bottom py-3 px-4">
                                                        <h5 class="font-size-16 mb-0">รายการสินค้า <span class="float-end"></span></h5>
                                                    </div>
                                                    <div class="card-body p-4 pt-2">

                                                        <div class="table-responsive">
                                                            <table class="table mb-0">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>สินค้าทั้งหมด :</td>
                                                                        <td class="sumAllitemcart text-end"><?= array_sum($_SESSION['cart']) ?></td>
                                                                    </tr>

                                                                    <tr class="bg-light">
                                                                        <th>ยอดเงินสุทธิต้องชำระ คือ :</th>
                                                                        <td class="text-end">
                                                                            <span class="sumAllmoney fw-bold">
                                                                                <?php
                                                                                $sumAllmoney = 0;
                                                                                foreach ($_SESSION['cart'] as $index => $value) {
                                                                                    $product->sql = "SELECT  *  FROM  product  WHERE product_id ='" . $index . "'";
                                                                                    $product->queryData();
                                                                                    $result = $product->fetch_AssocData();
                                                                                    $sumAllmoney += $result['product_price'] * $value;
                                                                                }
                                                                                ?>

                                                                                <?= "฿" . $sumAllmoney ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-12 d-flex justify-content-center">
                                        <div class="col-12 text-end">
                                            <a href="#" onclick="stepper.previous()" class="btn btn-secondary"><i class="bi bi-arrow-left-circle"></i> ย้อนกลับ</a>
                                            <a href="#" onclick="confirmorder()" class="btn btn-danger"><i class="bi bi-arrow-right-circle"></i> ยืนยันการสั่งซื้อ</a>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div id="installation-work-detail" class="content">
                                <div class="row">
                                    <div class="col-12">
                                        <h6>ข้อมูลการสั่งซื้อ</h6>
                                        <div class="mt-5 mt-lg-0 orderdetail" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="">
                                                        <div class="col">
                                                            <div class="card radius-10 border-start border-0 border-3 border-danger">
                                                                <div class="card-body">
                                                                    <div class="text-center ">
                                                                        <span class="cart-blank-icon"><img src="https://s2.konvy.com/static/img/order/cart-blank-icon.png" alt=""></span>

                                                                    </div>
                                                                    <h5 class="card-title m-2 text-center">การสั่งซื้อเสร็จสมบูรณ์</h5>
                                                                    <p class="order_id">เลขที่สั่งซื้อ : -</p>
                                                                    <p class="order_money">จำนวนเงิน : -</p>
                                                                    <p class="order_date">เวลาการสั่งซื้อ : -</p>
                                                                    <div class="text-center">
                                                                        <button onclick="orderdetail()" id="orderdetail"  class="btn btn-danger"><i class="bi bi-file-earmark-arrow-up-fill"></i> แจ้งชำระเงิน</button>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
    </section>
    <?php include("include/footer.php"); ?>

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <div id="preloader"></div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/bs-stepper/js/bs-stepper.min.js"></script>
    <?php include("include/script.php"); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.stepper = new Stepper(document.querySelector('.wizard-modern-example'), {
                linear: false,
                animation: true
            })

        });

        function confirmorder() {
            $.ajax({
                type: 'POST',
                url: "services/cart/order.php?v=confirmorder",
                success: function(response) {
                    console.log(response)
                    if (response.status == "ok") {
                        $('.order_id').text('เลขที่สั่งซื้อ : ' + response.order_id);
                        $('#orderdetail').val(response.order_id)
                        $('.order_date').text('เวลาการสั่งซื้อ : ' + response.order_date);
                        $('.order_money').text('จำนวนเงิน : ' + response.order_money);
                        $('.orderdetail').show()

                        stepper.next()
                    }
                }
            });
        }

        function orderdetail() {
            if ($('#orderdetail').val() > 0) {
                console.log($('#orderdetail').val())
                window.location.href = "orderdetail.php?id=" + $('#orderdetail').val()
            } else {
                stepper.previous()
            }

        }
    </script>
</body>

</html>