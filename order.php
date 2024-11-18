<?php
include("include/header.php");
?>
<style>
    .dataTables_filter {
        display: none;
    }

    .dataTables_length {
        float: left !important;
    }

    .dataTables_paginate {
        float: right !important;
    }
</style>
<?php
$order = new Connect_Data();
$order->connectData();

$orderdetail = new Connect_Data();
$orderdetail->connectData();
?>

<body>
    <?php
    include("include/menunav.php");
    ?>
    <section id="material" class="material">
        <div class="container mt-2">
            <div class="row">
                <div class="col-12">
                    <?php
                    if (!isset($_SESSION['customer_id'])) {

                    ?>
                        <div class="card text-center my-4">
                            <div class="card-header bg-danger text-white maincolor">
                                ไม่มีข้อมูลผู้ใช้งาน
                            </div>
                            <div class="card-body my-3">
                                <h5 class="card-title">โปรด login เข้าสู่ระบบก่อนค่ะ</h5>
                                <a href="login.php" class="btn btn-danger maincolor my-3">login เข้าใช้งาน</a>
                            </div>

                        </div>
                    <?php

                    } else {


                    ?>
                        <div class="row mb-2 mt-3">
                            <div class="col-md-8 text-start text-md-end">
                                <p class="pt-1"> ค้นหาข้อมูล : </p>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control" id="statusFilter">
                                    <option value="">ทั้งหมด</option>
                                    <option value="รอชำระเงิน">รอชำระเงิน</option>
                                    <option value="รอยืนยันการชำระเงิน">รอยืนยันการชำระเงิน</option>
                                    <option value="รอจัดส่ง">รอจัดส่ง</option>
                                    <option value="จัดส่งเรียบร้อยแล้ว">จัดส่งเรียบร้อยแล้ว</option>
                                    <option value="ยกเลิกออเดอร์">ยกเลิกออเดอร์</option>
                                </select>
                            </div>

                        </div>
                        <div class="table-responsive col-md-12">
                            <table class="table table-bordered table-striped" id="tableorder">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col" class="text-center">เลขที่สั่งซื้อ</th>
                                        <th scope="col" class="text-center">วันที่สั่งซื้อ</th>
                                        <th scope="col" class="text-center">ราคารวม</th>
                                        <th scope="col" class="text-center">สถานะ</th>
                                        <th scope="col" class="text-center">หมายเหตุ</th>
                                        <th scope="col" class="text-center">รายละเอียด</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $order->sql = "SELECT *  	FROM 	orders  WHERE customer_id ='" . $_SESSION['customer_id'] . "'";
                                    $order->queryData();
                                    $noid = 1;
                                    $row = $order->num_rows();
                                    if ($row == 0) {
                                    ?>
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <div class="card m-5">
                                                    ยังไม่มีรายการสั่งซื้อ
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    while ($rsorder = $order->fetch_AssocData()) {
                                        $sumprice = 0;
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

                                        //หายอดสินค้ารวม
                                        $orderdetail->sql = "SELECT  sum(orders_detail.order_qty * 	orders_detail.product_price) as sumprice  	FROM 	orders_detail  WHERE order_id ='" . $rsorder['order_id'] . "'";
                                        $orderdetail->queryData();
                                        $rsorderdetail = $orderdetail->fetch_AssocData();
                                        $sumprice = $rsorderdetail['sumprice'];
                                        $timestamp = strtotime($rsorder['order_date']);
                                        $new_timestamp = $timestamp + (24 * 3600); 
                                        $new_date = date("Y-m-d H:i:s", $new_timestamp);
                                    ?>
                                        <tr>
                                            <td class="text-center">
                                                <?= ($noid++) ?>
                                            </td>
                                            <td class="text-center">
                                                <?= $order_id ?>
                                            </td>
                                            <td class="text-center">
                                                <?= date('d/m/Y', strtotime($rsorder['order_date'])) ?>
                                            </td>
                                            <td class="text-center">
                                                <?= "฿" . number_format($sumprice, 2) ?>
                                            </td>
                                            <td class="text-center status">
                                                <?php
                                                if ($rsorder['order_status'] == 1) {
                                                    echo '<span class="badge rounded-pill bg-danger">รอชำระเงิน</span><br/>';
                                                    echo '<span class="text-danger">โปรดชำระภายใน';
                                                    if (time() > $new_timestamp) {
                                                        echo "หมดเขตการชำระ";
                                                    } else {
                                                        echo date('d/m/Y H:i:s', strtotime($new_date))." น.";
                                                    }
                                                    echo '</span>';
                                                } else if ($rsorder['order_status'] == 2) {
                                                    echo '<span class="badge rounded-pill bg-warning">รอยืนยันการชำระเงิน</span>';
                                                } else if ($rsorder['order_status'] == 3) {
                                                    echo '<span class="badge rounded-pill bg-primary">รอจัดส่ง</span>';
                                                } else if ($rsorder['order_status'] == 4) {
                                                    echo '<span class="badge rounded-pill bg-success">จัดส่งเรียบร้อยแล้ว</span>';
                                                } else if ($rsorder['order_status'] == 0) {
                                                    echo '<span class="badge rounded-pill bg-dark">ข้อมูลการขำระเงินไม่ถูกต้อง</span>';
                                                } else if ($rsorder['order_status'] == 5) {
                                                    echo '<span class="badge rounded-pill bg-dark">ยกเลิกออเดอร์</span>';
                                                }
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <?=$rsorder['order_details']?>
                                            </td>
                                            <td class="text-center">

                                                <a href="orderdetail.php?id=<?php echo $rsorder['order_id'] ?>" type="button" class="btn btn-outline-danger btn-sm"><i class="bi bi-eye"></i></a>
                                                <button type="button" onclick="cancelOrder('<?php echo $rsorder['order_id'] ?>','<?php echo $rsorder['order_status'] ?>')" class="btn btn-outline-dark btn-sm">X</a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title text-white" id="exampleModalLabel">แจ้งเตือน</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="resultcancelorder modal-body text-center">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="button" class="btn btn-dark" id="btnidcancelOrder" value="" onclick="confirmCancelorder()">ตกลง</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include("include/footer.php"); ?>

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <div id="preloader"></div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php include("include/script.php"); ?>
    <script src="admin/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="admin/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="admin/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="admin/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="admin/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="admin/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            var table;

            $('#tableorder').DataTable({
                "language": {
                    "lengthMenu": "แสดง _MENU_ รายการ",
                    "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                    "infoEmpty": "ไม่พบรายการ",
                    "infoFiltered": "(กรองจากทั้งหมด _MAX_ รายการ)",
                    "search": "ค้นหา:",
                    "paginate": {
                        "first": "หน้าแรก",
                        "last": "หน้าสุดท้าย",
                        "next": "ถัดไป",
                        "previous": "ก่อนหน้า"
                    }
                },
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "ทั้งหมด"]
                ]
            });
            table = $('#tableorder').DataTable();

            $('#statusFilter').change(function() {
                var selectedStatus = $(this).val();
                table.search(selectedStatus).draw();

            });
        });

        function cancelOrder(id, status) {
            console.log(status)
            if (status <= 1) {
                $('.resultcancelorder').text("ต้องการยกเลิกออเดอร์นี้ ?")
                $('#btnidcancelOrder').val(id)
                $('#exampleModal').modal('show')
            } else {
                $('#btnidcancelOrder').val('')
                $('.resultcancelorder').text("ไม่สามารถยกเลิกออเดอร์นี้ได้ !")
                $('#exampleModal').modal('show')
            }

        }

        function confirmCancelorder() {
            var id = $('#btnidcancelOrder').val();
            if (id > 0) {
                $.ajax({
                    type: 'GET',
                    url: "services/cart/order.php?v=cancelOrder&id=" + id,
                    success: function(response) {
                        window.location = "order.php"
                    }
                });
            } else {
                $('#exampleModal').modal('hide')
            }

        }
    </script>
</body>

</html>