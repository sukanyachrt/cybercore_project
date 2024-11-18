<?php
include ("include/header.php");
?>
<link rel="stylesheet" href="assets/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="assets/toastr/toastr.min.css">
<style>
    #toast-container>.toast-success {
        background-color: green;
    }

    .bg-warning-2 {
        background-color: #ECB159 !important;
    }
</style>
<?php
$product = new Connect_Data();
$product->connectData();

$orderdetail = new Connect_Data();
$orderdetail->connectData();

if ($_GET['id'] <= 9) {
    $id = "0000" . $_GET['id'];
} else if ($_GET['id'] >= 10 && $_GET['id'] <= 99) {
    $id = "000" . $_GET['id'];
} else if ($_GET['id'] >= 100 && $_GET['id'] <= 999) {
    $id = "00" . $_GET['id'];
} else if ($_GET['id'] >= 1000 && $_GET['id'] <= 9999) {
    $id = "0" . $_GET['id'];
} else {
    $id = $_GET['id'];
}
?>

<body>
    <?php
    include ("include/menunav.php");
    ?>
    <section id="material" class="material">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12">
                    <h6>ออเดอร์ของฉัน > หมายเลขสั่งซื้อ :
                        <?= $id ?>
                    </h6>
                    <?php
                    $product->sql = "SELECT * FROM 	orders  WHERE order_id ='" . $_GET['id'] . "'";
                    $product->queryData();
                    $rsconnect = $product->fetch_AssocData();
                    $order_status = $rsconnect['order_status'];
                    ?>
                    <?php if ($order_status == 0 && !isset ($_GET['status'])) {
                        ?>
                        <div class="row">
                            <div class="col-12">

                                <div class="card radius-10 border-top  border-3 border-danger bordermaincolor">
                                    <div class="card-header ">
                                        <h6>ข้อมูลการชำระเงินไม่ถูกต้อง</h6>
                                        <p class="text-danger">
                                               <?=$rsconnect['order_details']?> 
                                            </p>
                                    </div>

                                    <div class="card-body py-4">
                                       
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-dark"
                                                onclick="confirmCancelorder()">ยกเลิกออเดอร์</button>
                                            <a class="btn btn-danger maincolor"
                                                href="orderdetail.php?id=<?php echo $_GET['id'] ?>&status=1">แก้ไขข้อมูลการชําระเงิน</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    } ?>
                    <div class="card radius-10 border-top  border-3 border-danger bordermaincolor">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="text-center position-relative">
                                        <div class="step-icon mx-auto bg-danger border rounded-circle d-flex align-items-center justify-content-center"
                                            style="width:50px;height:50px;">
                                            <i class="bi bi-bag-check-fill text-white"></i>
                                        </div>
                                        <h4 class="mt-3 fs-6">ทำรายการสำเร็จ</h4>
                                        <div class="arrow-icon position-absolute d-none d-lg-block"
                                            style="top:50px; right:-25px">
                                            <svg class="bi bi-arrow-right" fill="currentColor" height="25"
                                                viewbox="0 0 16 16" width="25" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"
                                                    fill-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($order_status == 5) { ?>
                                    <div class="col-md-2">
                                        <div class="text-center position-relative">
                                            <div class="step-icon mx-auto <?php if ($order_status == 5)
                                                echo "bg-danger";
                                            else {
                                                echo "bg-secondary";
                                            } ?> border rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 50px;height: 50px;">
                                                <i class="bi bi-x text-white"></i>
                                            </div>
                                            <h4 class="mt-3 fs-6">
                                                ยกเลิกออเดอร์

                                            </h4>
                                            <div class="arrow-icon d-none d-lg-block position-absolute"
                                                style="top:50px; right:-25px">
                                                <svg class="bi bi-arrow-right" fill="currentColor" height="25"
                                                    viewbox="0 0 16 16" width="25" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"
                                                        fill-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="col-md-2">
                                    <div class="text-center position-relative">
                                        <div class="step-icon mx-auto <?php if (($order_status > 1 || $order_status == 0) && $order_status != 5)
                                            echo "bg-danger";
                                        else {
                                            echo "bg-secondary";
                                        } ?> border rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 50px;height: 50px;">
                                            <i class="bi bi-wallet-fill text-white"></i>
                                        </div>
                                        <h4 class="mt-3 fs-6">
                                            รอชำระเงิน

                                        </h4>
                                        <div class="arrow-icon d-none d-lg-block position-absolute"
                                            style="top:50px; right:-25px">
                                            <svg class="bi bi-arrow-right" fill="currentColor" height="25"
                                                viewbox="0 0 16 16" width="25" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"
                                                    fill-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($order_status == 0) { ?>
                                    <div class="col-md-2">
                                        <div class="text-center position-relative">
                                            <div class="step-icon mx-auto <?php if ($order_status == 0 && $order_status != 5)
                                                echo "bg-danger";
                                            else {
                                                echo "bg-secondary";
                                            } ?> border rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 50px;height: 50px;">
                                                <i class="bi bi-wallet-fill text-white"></i>
                                            </div>
                                            <h4 class="mt-3 fs-6">
                                                ข้อมูลการชำระเงินไม่ถูกต้อง

                                            </h4>
                                            <div class="arrow-icon d-none d-lg-block position-absolute"
                                                style="top:50px; right:-25px">
                                                <svg class="bi bi-arrow-right" fill="currentColor" height="25"
                                                    viewbox="0 0 16 16" width="25" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"
                                                        fill-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="col-md-3">
                                    <div class="text-center position-relative">
                                        <div class="step-icon mx-auto <?php if ($order_status > 2 && $order_status != 5)
                                            echo "bg-danger";
                                        else {
                                            echo "bg-secondary";
                                        } ?> border rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 50px;height: 50px;">
                                            <i class="bi bi-pencil-square text-white"></i>
                                        </div>
                                        <h4 class="mt-3 fs-6">
                                            รอยืนยันการชำระเงิน


                                        </h4>
                                        <div class="arrow-icon d-none d-lg-block position-absolute"
                                            style="top:50px; right:-25px">
                                            <svg class="bi bi-arrow-right" fill="currentColor" height="25"
                                                viewbox="0 0 16 16" width="25" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"
                                                    fill-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="text-center position-relative">
                                        <div class="step-icon mx-auto <?php if ($order_status >= 3 && $order_status != 5)
                                            echo "bg-danger";
                                        else {
                                            echo "bg-secondary";
                                        } ?> border rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 50px;height: 50px;">
                                            <svg class="bi bi-truck text-white" fill="currentColor" height="25"
                                                viewbox="0 0 16 16" width="30" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <h4 class="mt-3 fs-6">รอจัดส่ง</h4>
                                        <div class="arrow-icon d-none d-lg-block position-absolute"
                                            style="top:50px; right:-25px">
                                            <svg class="bi bi-arrow-right" fill="currentColor" height="25"
                                                viewbox="0 0 16 16" width="25" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"
                                                    fill-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center position-relative">
                                        <div class="step-icon mx-auto <?php if ($order_status >= 4 && $order_status != 5)
                                            echo "bg-danger";
                                        else {
                                            echo "bg-secondary";
                                        } ?> border rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 50px;height: 50px;">
                                            <i class="bi bi-pencil-square text-white"></i>
                                        </div>
                                        <h4 class="mt-3 fs-6">จัดส่งเรียบร้อยแล้ว</h4>
                                    </div>
                                </div>
                            </div>


                            <?php if ($order_status == 1 || isset ($_GET['status']) == 1) { ?>
                                <div class="row pt-5">

                                    <div class="col-12  maincolor">
                                        <p class="fs-6 pt-2 text-center text-white">แจ้งข้อมูลการชำระเงิน</p>
                                    </div>

                                    <div class="col-12 my-2">
                                        <form id="paymentForm" name="paymentForm">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">ธนาคารที่โอนเงิน</label>
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th></th>
                                                                <th>ธนาคาร</th>
                                                                <th>สาขา</th>
                                                                <th>เลขที่บัญชี</th>
                                                                <th>ชื่อบัญชี </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="odd">
                                                                <td>
                                                                    <input class="form-check-input" type="radio"
                                                                        name="pay_bank" id="pay_bank" value="kbank">
                                                                </td>
                                                                <td><img src="assets/img/bank/kbank.gif" width="20"
                                                                        align="absmiddle"></td>
                                                                <td>กสิกรไทย</td>
                                                                <td>สำนักสีลม</td>
                                                                <td>1234567890</td>
                                                                <td>บจก. cybercore</td>
                                                            </tr>
                                                            <tr class="">
                                                                <td>
                                                                    <input class="form-check-input" type="radio"
                                                                        name="pay_bank" id="pay_bank" value="bbl">
                                                                </td>
                                                                <td><img src="assets/img/bank/bbl.gif" width="20"
                                                                        align="absmiddle"></td>
                                                                <td>กรุงเทพ</td>
                                                                <td>สำนักงานใหญ่สีลม</td>
                                                                <td>1234567890</td>
                                                                <td>บจก. cybercore</td>
                                                            </tr>
                                                            <tr class="odd">
                                                                <td>
                                                                    <input class="form-check-input" type="radio"
                                                                        name="pay_bank" id="pay_bank" value="ktb">
                                                                </td>
                                                                <td><img src="assets/img/bank/ktb.gif" width="20"
                                                                        align="absmiddle"></td>
                                                                <td>กรุงไทย</td>
                                                                <td>สีลม</td>
                                                                <td>1234567890</td>
                                                                <td>บจก. cybercore</td>
                                                            </tr>
                                                            <tr class="">
                                                                <td>
                                                                    <input class="form-check-input" type="radio"
                                                                        name="pay_bank" id="pay_bank" value="scb">
                                                                </td>
                                                                <td><img src="assets/img/bank/scb.gif" width="20"
                                                                        align="absmiddle"></td>
                                                                <td>ไทยพาณิชย์</td>
                                                                <td>ปาโซ่ ทาวเวอร์</td>
                                                                <td>1234567890</td>
                                                                <td>บจก. cybercore</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row my-2">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">วันที่โอน</label>
                                                        <input type="text" class="form-control datepicker" readOnly
                                                            id="pay_date" name="pay_date" placeholder="วัน/เดือน/ปี" />

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">เวลาที่โอน</label>
                                                        <input type="text" autocomplete="off"
                                                            class="form-control bs-timepicker" id="pay_time" name="pay_time"
                                                            placeholder="เวลาที่โอน" />
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row my-2">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">ยอดเงินที่โอน</label>
                                                        <input type="text" class="form-control" id="pay_total"
                                                            name="pay_total" placeholder="ยอดเงินที่โอน">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row my-2">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">หลักฐานการโอน</label>
                                                        <input type="file" id="pay_image" accept="image/*"
                                                            multiple="multiple" class="form-control" name="pay_image[]">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row my-2">
                                                <div class="col-md-12">
                                                    <div class="form-group ">
                                                        <label for="exampleInputPassword1">หมายเหตุ</label>
                                                        <textarea class="form-control" id="pay_detail" name="pay_detail"
                                                            rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row my-2 text-center">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-danger maincolor">บันทึกการโอนเงิน</button>
                                                </div>
                                            </div>


                                        </form>
                                    </div>

                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <h6>ที่อยู่สำหรับจัดส่ง</h6>
                    <div class="card radius-10 border-top  border-3 border-danger bordermaincolor">
                        <div class="card-body">
                            <?php

                            $product->sql = "SELECT * FROM 	customers  WHERE customer_id ='" . $_SESSION['customer_id'] . "'";
                            $product->queryData();
                            $rsconnect = $product->fetch_AssocData();
                            ?>
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0">
                                            <?= $rsconnect['customer_fname'] . " " . $rsconnect['customer_lname'] ?>
                                        </p>
                                        <p class="my-1">
                                            <?= $rsconnect['c_address'] ?>
                                        </p>
                                        <p class="mb-0 font-13">
                                            <?= $rsconnect['customer_telephone'] ?>
                                        </p>
                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto">
                                        <i class="fa fa-shopping-cart"></i>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h6>รายการสินค้า</h6>
                    <?php
                    $product->sql = "SELECT orders_detail.product_id,orders_detail.order_qty, 
                    orders_detail.product_price,  product.product_name, product.product_detail, 
                    product.product_image
                    FROM orders_detail INNER JOIN product ON  orders_detail.product_id = product.product_id
                    WHERE order_id='" . $_GET['id'] . "'";
                    $product->queryData();
                    $sumAllmoney = 0;
                    $sumorder_qty = 0;
                    while ($result = $product->fetch_AssocData()) {
                        $sumAllmoney += ($result['product_price'] * $result['order_qty']);
                        $sumorder_qty += $result['order_qty'];
                        ?>
                        <div class="card border shadow-none mb-2">
                            <div class="card-body">
                                <div class="row align-items-start">
                                    <div class="col-md-2 col-12">
                                        <img src="assets/img/product/<?= $result['product_image'] ?>" alt=""
                                            class="avatar-lg rounded">
                                    </div>
                                    <div class="col-md-4 col-12 align-self-center overflow-hidden">
                                        <div>
                                            <h5 class="text-truncate font-size-18"><a href="#" class="text-dark">
                                                    <?= $result['product_name'] ?>
                                                </a></h5>

                                            <p class="mb-0 mt-1"><span class="fw-medium">
                                                    <?= $result['product_detail'] ?>
                                                </span></p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-12 align-self-center overflow-hidden">
                                        <div>
                                            <h5 class="text-truncate font-size-18"><a href="#" class="text-dark">Price </a>
                                            </h5>

                                            <p class="mb-0 mt-1"><span class="fw-medium">
                                                    <?= "฿" . $result['product_price'] ?>
                                                </span></p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-12 align-self-center overflow-hidden">
                                        <div>
                                            <h5 class="text-truncate font-size-18"><a href="#" class="text-dark">Quantity
                                                </a></h5>

                                            <p class="mb-0 mt-1"><span class="fw-medium">
                                                    <?= $result['order_qty'] ?>
                                                </span></p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-12 align-self-center overflow-hidden">
                                        <div>
                                            <h5 class="text-truncate font-size-18"><a href="#" class="text-dark">Total </a>
                                            </h5>

                                            <p class="mb-0 mt-1"><span class="fw-medium">
                                                    <?= "฿" . number_format($result['product_price'] * $result['order_qty'], 2) ?>
                                                </span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card border shadow-none">

                        <div class="card-body text-end">
                            <div class="row">
                                <div class="col-10">
                                    <span class="fw-medium">
                                        สินค้าทั้งหมด :
                                    </span>
                                </div>
                                <div class="col-2 text-start">
                                    <span class="fw-medium">
                                        <?= $sumorder_qty ?> รายการ

                                    </span>
                                </div>
                                <div class="col-10">
                                    <span class="fw-medium">
                                        ยอดรวม :
                                    </span>
                                </div>
                                <div class="col-2 text-start">
                                    <span class="fw-medium">
                                        <?= "฿" . number_format($sumAllmoney,2 )?>

                                    </span>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include ("include/footer.php"); ?>

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <div id="preloader"></div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/jquery-validation/jquery.validate.min.js"></script>
    <link href="assets/datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
    <script src="assets/datepicker/js/bootstrap-datepicker-custom.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.5.2/flatly/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/timepicker.min.css" />
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css" />
    <script src="assets/js/timepicker.min.js"></script>
    <script src="assets/sweetalert2/sweetalert2.min.js"></script>
    <script src="assets/toastr/toastr.min.js"></script>

    <?php include ("include/script.php"); ?>
    <script>
        if (sessionStorage.getItem('toastrShown') === 'save') {
            toastr.success("บันทึกข้อมูลการชำระเงินแล้วค่ะ !");
            sessionStorage.removeItem('toastrShown');

        }
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            endDate: 'today'

        });

        $(".bs-timepicker").timepicker();

        $('#paymentForm').validate({
            rules: {
                pay_bank: {
                    required: true,
                },
                pay_date: {
                    required: true,
                },
                pay_time: {
                    required: true,
                },
                pay_total: {
                    required: true,
                    alphanumeric: true,
                },
                pay_image: {
                    required: true,
                },

            },
            messages: {
                pay_bank: {
                    required: "โปรดเลือกธนาคารที่โอน",
                },
                pay_date: {
                    required: "โปรดกรอกวันที่โอน",
                },
                pay_time: {
                    required: "โปรดกรอกเวลาที่โอน",
                },
                pay_total: {
                    required: "โปรดกรอกยอดเงินที่โอน",
                    alphanumeric: "โปรดกรอกตัวเลขเท่านั้น",
                },
                pay_image: {
                    required: "โปรดอัพโหลดหลักฐานการโอน",
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function (form) {
                var paymentForm = new FormData($('#paymentForm')[0]);


                $.ajax({
                    async: true,
                    url: "services/cart/order.php?v=insertPayment&id=<?php echo $_GET['id'] ?>",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: paymentForm,
                    success: function (response) {
                        console.log(response)
                        if (response.status == "ok") {
                            sessionStorage.setItem('toastrShown', 'save');
                            window.location = "orderdetail.php?id=<?php echo $_GET['id'] ?>"
                        }
                    },
                    error: function (error) {
                        console.log(error)
                    }
                });
            },
        });

        function confirmCancelorder() {

            $.ajax({
                type: 'GET',
                url: "services/cart/order.php?v=cancelOrder&id=<?php echo $_GET['id'] ?>",
                success: function (response) {
                    window.location = "order.php"
                }
            });



        }

        // เพิ่มเงื่อนไขสำหรับกฎ alphanumeric
        $.validator.addMethod("alphanumeric", function (value, element) {
            return this.optional(element) || /^[0-9.]+$/.test(value);
        }, "โปรดกรอกข้อมูลที่มีเฉพาะตัวเลข");
    </script>
</body>

</html>