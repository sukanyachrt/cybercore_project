<?php include ("../../include/header.php"); ?>
<link rel="stylesheet" href="../../assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="../../assets/plugins/toastr/toastr.min.css">



<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include ("../../include/checkmenu.php"); ?>
            <div class="layout-page">
                <?php include ("../../include/navbar.php"); ?>
                <?php

                require_once ("../../services/connect_data.php");
                $order = new Connect_Data();
                $order->connectData();
                $order->sql = "SELECT
customers.customer_fname,
customers.customer_lname,
c_address,
customer_telephone,
orders.order_id,
orders.customer_id,
orders.order_date,
orders.order_status 
FROM orders INNER JOIN customers ON orders.customer_id = customers.customer_id  
WHERE order_id='" . $_GET['id'] . "'";
                $order->queryData();
                $rsorder = $order->fetch_AssocData();

                $order_status = $rsorder['order_status'];
                if ($rsorder['order_id'] <= 9) {
                    $order_id = "0000" . $rsorder['order_id'];
                } else if ($rsorder['order_id'] >= 10 && $rsorder['order_id'] <= 99) {
                    $order_id = "000" . $rsorder['order_id'];
                } else if ($rsorder['order_id'] >= 100 && $rsorder['order_id'] <= 999) {
                    $order_id = "00" . $rsorder['order_id'];
                } else if ($rsorder['order_id'] >= 1000 && $rsorder['order_id'] <= 9999) {
                    $order_id = "0" . $rsorder['order_id'];
                } else {
                    $order_id = $rsorder['order_id'];
                }
                // ยอดที่ต้องชำระจริง
                $orderdetail = new Connect_Data();
                $orderdetail->connectData();
                $orderdetail->sql = "SELECT  sum(orders_detail.order_qty * 	orders_detail.product_price) as sumprice  	FROM 	orders_detail  WHERE order_id ='" . $_GET['id'] . "'";
                $orderdetail->queryData();
                $rsorderdetail = $orderdetail->fetch_AssocData();
                $sumprice = $rsorderdetail['sumprice'];

                // ข้อมูลการชำระเงิน
                $payment = new Connect_Data();
                $payment->connectData();
                $payment->sql = "SELECT * FROM payment WHERE order_id='" . $_GET['id'] . "'";
                $payment->queryData();
                $rspayment = $payment->fetch_AssocData();

                // สถานะ
                
                if ($rsorder['order_status'] == 1) {
                    $status_span = '<span class="badge rounded-pill bg-danger">รอชำระเงิน</span>';
                } else if ($rsorder['order_status'] == 2) {
                    $status_span = '<span class="badge rounded-pill bg-warning">รอยืนยันการชำระเงิน</span>';
                } else if ($rsorder['order_status'] == 3) {
                    $status_span = '<span class="badge rounded-pill bg-info">รอจัดส่ง</span>';
                } else if ($rsorder['order_status'] == 4) {
                    $status_span = '<span class="badge rounded-pill bg-success">จัดส่งเรียบร้อยแล้ว</span>';
                } else if ($rsorder['order_status'] == 0) {
                    $status_span = '<span class="badge rounded-pill bg-dark">ข้อมูลการชำระเงินไม่ถูกต้อง</span>';
                } else if ($rsorder['order_status'] == 5) {
                    $status_span = '<span class="badge rounded-pill bg-dark">ยกเลิกออเดอร์</span>';
                }
                ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="py-3 mb-0">รายละเอียดข้อมูล /
                            <?= $status_span ?>
                        </h4>

                        <div class="row">
                            <div class="col-12">
                                <h6>ออเดอร์ของฉัน > หมายเลขสั่งซื้อ :
                                    <?= $order_id ?>
                                </h6>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card radius-10 border-top  border-3 border-danger">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="text-center position-relative">
                                                            <div class="step-icon mx-auto bg-danger border rounded-circle d-flex align-items-center justify-content-center"
                                                                style="width:50px;height:50px;">
                                                                <i class='bx bx-shopping-bag text-white'></i>
                                                            </div>
                                                            <h4 class="mt-3 fs-6">ทำรายการสำเร็จ</h4>
                                                            <div class="arrow-icon position-absolute d-none d-lg-block"
                                                                style="top:50px; right:-25px">
                                                                <svg class="bi bi-arrow-right" fill="currentColor"
                                                                    height="25" viewbox="0 0 16 16" width="25"
                                                                    xmlns="http://www.w3.org/2000/svg">
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
                                                                    <i class="bx bx-x text-white"></i>
                                                                </div>
                                                                <h4 class="mt-3 fs-6">
                                                                    ยกเลิกออเดอร์

                                                                </h4>
                                                                <div class="arrow-icon d-none d-lg-block position-absolute"
                                                                    style="top:50px; right:-25px">
                                                                    <svg class="bi bi-arrow-right" fill="currentColor"
                                                                        height="25" viewbox="0 0 16 16" width="25"
                                                                        xmlns="http://www.w3.org/2000/svg">
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
                                                                <i class='bx bxs-wallet-alt text-white'></i>
                                                            </div>
                                                            <h4 class="mt-3 fs-6">
                                                                รอชำระเงิน

                                                            </h4>
                                                            <div class="arrow-icon d-none d-lg-block position-absolute"
                                                                style="top:50px; right:-25px">
                                                                <svg class="bi bi-arrow-right" fill="currentColor"
                                                                    height="25" viewbox="0 0 16 16" width="25"
                                                                    xmlns="http://www.w3.org/2000/svg">
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
                                                                    <i class="bx bx-x text-white"></i>
                                                                </div>
                                                                <h4 class="mt-3 fs-6">
                                                                    ข้อมูลการขำระเงินไม่ถูกต้อง

                                                                </h4>
                                                                <div class="arrow-icon d-none d-lg-block position-absolute"
                                                                    style="top:50px; right:-25px">
                                                                    <svg class="bi bi-arrow-right" fill="currentColor"
                                                                        height="25" viewbox="0 0 16 16" width="25"
                                                                        xmlns="http://www.w3.org/2000/svg">
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
                                                                <i class='bx bxs-edit text-white'></i>
                                                            </div>
                                                            <h4 class="mt-3 fs-6">
                                                                รอยืนยันการชำระเงิน


                                                            </h4>
                                                            <div class="arrow-icon d-none d-lg-block position-absolute"
                                                                style="top:50px; right:-25px">
                                                                <svg class="bi bi-arrow-right" fill="currentColor"
                                                                    height="25" viewbox="0 0 16 16" width="25"
                                                                    xmlns="http://www.w3.org/2000/svg">
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
                                                                <svg class="bi bi-truck text-white" fill="currentColor"
                                                                    height="25" viewbox="0 0 16 16" width="30"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z">
                                                                    </path>
                                                                </svg>
                                                            </div>
                                                            <h4 class="mt-3 fs-6">รอจัดส่ง</h4>
                                                            <div class="arrow-icon d-none d-lg-block position-absolute"
                                                                style="top:50px; right:-25px">
                                                                <svg class="bi bi-arrow-right" fill="currentColor"
                                                                    height="25" viewbox="0 0 16 16" width="25"
                                                                    xmlns="http://www.w3.org/2000/svg">
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
                                                                <i class='bx bxs-check-square text-white'></i>
                                                            </div>
                                                            <h4 class="mt-3 fs-6">จัดส่งเรียบร้อยแล้ว</h4>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-12">
                                        <h5>รายละเอียดข้อมูลการชำระเงิน</h5>
                                        <div class="row">
                                            <div class="col-lg-12 order-0">
                                                <?php
                                                if (isset ($rspayment['pay_bank'])) {
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-lg-12 ">
                                                            <div class="demo-inline-spacing ">
                                                                <div class="list-group  border  border-3 border-danger">
                                                                    <a href="javascript:void(0);"
                                                                        class="list-group-item list-group-item-action">ผู้สั่งซื้อ
                                                                        :
                                                                        <?= $rsorder['customer_fname'] . " " . $rsorder['customer_fname'] ?>
                                                                    </a>
                                                                    <a href="javascript:void(0);"
                                                                        class="list-group-item list-group-item-action">วันที่สั่งซื้อ
                                                                        :
                                                                        <?= date('d/m/Y', strtotime($rsorder['order_date'])) ?>
                                                                    </a>
                                                                    <a href="javascript:void(0);"
                                                                        class="list-group-item list-group-item-action">ธนาคารที่ชำระ
                                                                        :
                                                                        <?= $rspayment['pay_bank'] ?>
                                                                    </a>
                                                                    <a href="javascript:void(0);"
                                                                        class="list-group-item list-group-item-action">วันที่ชำระเงิน
                                                                        :
                                                                        <?= date('d/m/Y', strtotime($rspayment['pay_date'])) . " เวลา " . $rspayment['pay_time'] ?>
                                                                    </a>
                                                                    <a href="javascript:void(0);"
                                                                        class="list-group-item list-group-item-action">ยอดในการชำระ
                                                                        :
                                                                        <?= $sumprice ?> บาท
                                                                    </a>
                                                                    <a href="javascript:void(0);"
                                                                        class="list-group-item list-group-item-action bg-transparent">
                                                                        หลักฐานการโอน
                                                                        <?php
                                                                        $pay_image = json_decode($rspayment['pay_image']);
                                                                        if ($pay_image) {
                                                                            foreach ($pay_image as $index => $image) {
                                                                                ?>
                                                                                <img class="img-fluid d-flex mx-auto mb-4"
                                                                                    style="max-width:400px; max-height:400px;"
                                                                                    src="../../../assets/img/payment/<?= $image ?>"
                                                                                    alt="Card image cap" />
                                                                                <p class="text-center text-black"> รูปที่
                                                                                    <?= $index + 1 ?>
                                                                                </p>
                                                                            <?php
                                                                            }
                                                                        } else {
                                                                            ?>
                                                                            <img class="img-fluid d-flex mx-auto mb-4"
                                                                                style="max-width:400px; max-height:400px;"
                                                                                src="../../../assets/img/payment/<?= $rspayment['pay_image'] ?>"
                                                                                alt="Card image cap" />

                                                                            <?php
                                                                        }

                                                                        ?>
                                                                        <a href="javascript:void(0);"
                                                                            class="list-group-item list-group-item-action">รายละเอียด
                                                                            :
                                                                            <?= $rspayment['pay_detail'] ?>
                                                                        </a>
                                                                        <?php
                                                                        if ($rsorder['order_status'] == 2) {
                                                                            ?>
                                                                            <a href="javascript:void(0);"
                                                                                class="list-group-item list-group-item-action text-center">
                                                                                <button class="btn btn-outline-dark m-2"
                                                                                    onclick="confirmPayment('NO')">ข้อมูลการชำระไม่ถูกต้อง</button>
                                                                                <button class="btn btn-warning"
                                                                                    onclick="confirmPayment('YES')"> <i
                                                                                        class='bx bxs-edit text-white'></i>
                                                                                    ยืนยันผลการชำระเงิน</button>
                                                                            </a>
                                                                        <?php } ?>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-lg-12 ">
                                                            <div class="demo-inline-spacing ">
                                                                <div class="list-group  border  border-3 border-danger">
                                                                    <a href="javascript:void(0);"
                                                                        class="list-group-item list-group-item-action">ยังไม่มีการชำระเงิน</a>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-12">
                                        <h5>ที่อยู่สำหรับจัดส่ง</h5>
                                        <div class="card radius-10 border-top  border-3 border-danger">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <p class="mb-0">
                                                                <?= $rsorder['customer_fname'] . " " . $rsorder['customer_lname'] ?>
                                                            </p>
                                                            <p class="my-1">
                                                                <?= $rsorder['c_address'] ?>
                                                            </p>
                                                            <p class="mb-0 font-13">
                                                                <?= $rsorder['customer_telephone'] ?>
                                                            </p>
                                                        </div>
                                                        <div
                                                            class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto">
                                                            <i class="fa fa-shopping-cart"></i>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h5>รายการสินค้า</h5>
                                        <?php
                                        $product = new Connect_Data();
                                        $product->connectData();
                                        $product->sql = "SELECT orders_detail.product_id,orders_detail.order_qty, 
                                        orders_detail.product_price,  product.product_name, product.product_detail, 
                                        product.product_image
                                        FROM orders_detail INNER JOIN product ON  orders_detail.product_id = product.product_id
                                        WHERE order_id='" . $_GET['id'] . "'";
                                        $product->queryData();
                                        $sumAllmoney = 0;
                                        $sumorder_qty = 0;
                                        while ($result = $product->fetch_AssocData()) {
                                            $sumAllmoney += $result['product_price'] * $result['order_qty'];
                                            $sumorder_qty += $result['order_qty'];
                                            ?>
                                            <div class="card border shadow-none mb-2">
                                                <div class="card-body">
                                                    <div class="row align-items-start">
                                                        <div class="col-md-2 col-12">
                                                            <img src="../../../assets/img/product/<?= $result['product_image'] ?>"
                                                                alt="" class="avatar-lg rounded">
                                                        </div>
                                                        <div class="col-md-4 col-12 align-self-center overflow-hidden">
                                                            <div>
                                                                <h5 class="text-truncate font-size-18"><a href="#"
                                                                        class="text-dark">
                                                                        <?= $result['product_name'] ?>
                                                                    </a></h5>

                                                                <p class="mb-0 mt-1"><span class="fw-medium">
                                                                        <?= $result['product_detail'] ?>
                                                                    </span></p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-12 align-self-center overflow-hidden">
                                                            <div>
                                                                <h5 class="text-truncate font-size-18"><a href="#"
                                                                        class="text-dark">Price </a></h5>

                                                                <p class="mb-0 mt-1"><span class="fw-medium">
                                                                        <?= "฿" . $result['product_price'] ?>
                                                                    </span></p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-12 align-self-center overflow-hidden">
                                                            <div>
                                                                <h5 class="text-truncate font-size-18"><a href="#"
                                                                        class="text-dark">Quantity </a></h5>

                                                                <p class="mb-0 mt-1"><span class="fw-medium">
                                                                        <?= $result['order_qty'] ?>
                                                                    </span></p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-12 align-self-center overflow-hidden">
                                                            <div>
                                                                <h5 class="text-truncate font-size-18"><a href="#"
                                                                        class="text-dark">Total </a></h5>

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
                                                    <div class="col-md-10 col-6">
                                                        <span class="fw-medium h5">
                                                            สินค้าทั้งหมด :
                                                        </span>
                                                    </div>
                                                    <div class="col-md-2 col-6 text-start">
                                                        <span class="fw-medium h5">
                                                            <?= $sumorder_qty ?> รายการ

                                                        </span>
                                                    </div>
                                                    <div class="col-md-10 col-6">
                                                        <span class="fw-medium h5">
                                                            ยอดรวม :
                                                        </span>
                                                    </div>
                                                    <div class="col-md-2 col-6 text-start">
                                                        <span class="fw-medium h5">
                                                            <?= "฿" . $sumAllmoney ?>

                                                        </span>
                                                    </div>
                                                </div>


                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <?php
                                if ($rsorder['order_status'] == 3) {
                                    ?>
                                    <div class="row mt-4">
                                        <div class="col-12 text-center">
                                            <div class="d-grid gap-2 col-lg-6 mx-auto">
                                                <button class="btn btn-success btn-lg" type="button" onclick="confirm(4)">
                                                    <i class='bx bxs-check-square text-white'></i>
                                                    จัดส่งสินค้าเรียบร้อยแล้ว
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modal_confirm" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-warning ">
                                    <h4 class="modal-title text-white" id="exampleModalLabel2">แจ้งเตือน</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h5 class="">ยืนยันผลการชำระเงินไม่ถูกต้อง ?</h5>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="order_details">หมายเหตุ / เหตุผล : </label>
                                                <textarea class="form-control" id="order_details" name="order_details"
                                                    rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer text-center">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        ยกเลิก
                                    </button>
                                    <button type="button" id="btnIdEmploy" onclick="confirm('0')"
                                        class="btn btn-warning">ยืนยัน</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include ("../../include/footer.php"); ?>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
</body>
<?php include ("../../include/script.php"); ?>
<script src="../../assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="../../assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="../../assets/plugins/toastr/toastr.min.js"></script>
<script>
    $(document).ready(function () {

        if (sessionStorage.getItem('toastrShown') === 'save') {
            toastr.success("บันทึกข้อมูลแล้วค่ะ !");
            sessionStorage.removeItem('toastrShown');
        }
    });

    function confirmPayment(typeconfirm) {
        if (typeconfirm == "YES") {
            confirm(3);
        } else {

            $('#modal_confirm').modal('show')
        }
    }

    function confirm(status) {
        if (status == "0") {
            if ($('#order_details').val() == "") {
                toastr.error("โปรดกรอกหมายเหตุ / เหตุผลด้วยค่ะ !");
            }
            else{
                $.ajax({
                type: 'GET',
                url: "../../services/payment/data.php?v=updatestatus&id=<?php echo $_GET['id'] ?>&status=" + status+"&order_details="+$('#order_details').val(),
                success: function (response) {
                    if (response.result == 1) {
                        $('#modal_confirm').modal('hide');
                        sessionStorage.setItem('toastrShown', 'save');
                        location.reload();

                    }
                },
                error: function (error) {
                    console.log(error)
                }
            });
            }
        }
        else {
            $.ajax({
                type: 'GET',
                url: "../../services/payment/data.php?v=updatestatus&id=<?php echo $_GET['id'] ?>&status=" + status+"&order_details=",
                success: function (response) {
                    if (response.result == 1) {
                        $('#modal_confirm').modal('hide');
                        sessionStorage.setItem('toastrShown', 'save');
                        location.reload();

                    }
                },
                error: function (error) {
                    console.log(error)
                }
            });
        }

    }
</script>