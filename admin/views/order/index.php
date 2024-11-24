<?php include("../../include/header.php"); ?>
<link rel="stylesheet" href="../../assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="../../assets/plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="../../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../../assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="../../assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<style>
    .dataTables_filter {
        display: none;
    }

    .dataTables_length {
        float: left !important;
    }
</style>
<?php
require_once("../../services/connect_data.php");
$connect = new Connect_Data();
$connect->connectData();
?>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include("../../include/checkmenu.php"); ?>
            <div class="layout-page">
                <?php include("../../include/navbar.php"); ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="py-3 mb-0">ข้อมูลรายการสั่งซื้อทั้งหมด</h4>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="table-responsive">
                                    <div class="btn-toolbar demo-inline-spacing" role="toolbar" aria-label="Toolbar with button groups">
                                        <div class="btn-group" role="group" aria-label="First group">
                                            <a href="?status=1" class="btn btn-outline-danger <?php if (isset($_GET['status']) && $_GET['status'] == "1") echo "active"; ?>">
                                                <i class="tf-icons bx bx-credit-card"></i>
                                                รอชำระเงิน
                                                <?php
                                                $connect->sql = "SELECT
                                            count( * ) AS numberorder 
                                            FROM   orders WHERE order_status='1'";
                                                $connect->queryData();
                                                $rsconnect = $connect->fetch_AssocData();
                                                if ($rsconnect['numberorder'] > 0) {
                                                ?>
                                                    <div class="badge bg-danger rounded-pill ms-auto"><?= $rsconnect['numberorder'] ?></div>
                                                <?php
                                                }
                                                ?>

                                            </a>


                                        </div>
                                        <div class="btn-group" role="group" aria-label="First group">

                                            <a href="?status=2" class="btn btn-outline-warning <?php if (isset($_GET['status']) && $_GET['status'] == "2") echo "active"; ?>">
                                                <i class="tf-icons bx bx-check-circle"></i>
                                                รอยืนยันการชำระเงิน
                                                <?php
                                                $connect->sql = "SELECT
                                            count( * ) AS numberorder 
                                            FROM   orders WHERE order_status='2'";
                                                $connect->queryData();
                                                $rsconnect = $connect->fetch_AssocData();
                                                if ($rsconnect['numberorder'] > 0) {
                                                ?>
                                                    <div class="badge bg-danger rounded-pill ms-auto"><?= $rsconnect['numberorder'] ?></div>
                                                <?php
                                                }
                                                ?>
                                            </a>


                                        </div>
                                        <div class="btn-group" role="group" aria-label="Second group">
                                            <a href="?status=3" class="btn btn-outline-info <?php if (isset($_GET['status']) && $_GET['status'] == "3") echo "active"; ?>">
                                                <i class="tf-icons bx bxs-backpack"></i>
                                                รอจัดส่ง
                                                <?php
                                                $connect->sql = "SELECT
                                            count( * ) AS numberorder 
                                            FROM   orders WHERE order_status='3'";
                                                $connect->queryData();
                                                $rsconnect = $connect->fetch_AssocData();
                                                if ($rsconnect['numberorder'] > 0) {
                                                ?>
                                                    <div class="badge bg-danger rounded-pill ms-auto"><?= $rsconnect['numberorder'] ?></div>
                                                <?php
                                                }
                                                ?>
                                            </a>


                                        </div>
                                        <div class="btn-group" role="group" aria-label="Second group">

                                            <a href="?status=4" class="btn btn-outline-success <?php if (isset($_GET['status']) && $_GET['status'] == "4") echo "active"; ?>">
                                                <i class="tf-icons bx bx-check-double"></i>
                                                จัดส่งเรียบร้อยแล้ว

                                            </a>

                                        </div>
                                        <div class="btn-group" role="group" aria-label="Second group">

                                            <a href="?status=0" class="btn btn-outline-dark <?php if (isset($_GET['status']) && $_GET['status'] == "0") echo "active"; ?>">
                                                <i class="tf-icons bx bx-x"></i>
                                                ข้อมูลการชำระเงินไม่ถูกต้อง
                                                <?php
                                                $connect->sql = "SELECT
                                            count( * ) AS numberorder 
                                            FROM   orders WHERE order_status='0'";
                                                $connect->queryData();
                                                $rsconnect = $connect->fetch_AssocData();
                                                if ($rsconnect['numberorder'] > 0) {
                                                ?>
                                                    <div class="badge bg-danger rounded-pill ms-auto"><?= $rsconnect['numberorder'] ?></div>
                                                <?php
                                                }
                                                ?>
                                            </a>

                                        </div>
                                        <div class="btn-group" role="group" aria-label="Second group">

                                            <a href="?status=5" class="btn btn-outline-secondary <?php if (isset($_GET['status']) && $_GET['status'] == "5") echo "active"; ?>">
                                                <i class="tf-icons bx bx-x"></i>
                                                ยกเลิกออเดอร์
                                                <?php
                                                $connect->sql = "SELECT
                                            count( * ) AS numberorder 
                                            FROM   orders WHERE order_status='5'";
                                                $connect->queryData();
                                                $rsconnect = $connect->fetch_AssocData();
                                                if ($rsconnect['numberorder'] > 0) {
                                                ?>
                                                    <div class="badge bg-danger rounded-pill ms-auto"><?= $rsconnect['numberorder'] ?></div>
                                                <?php
                                                }
                                                ?>
                                            </a>

                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-12 mb-4 order-0">
                            <div class="card">
                                <h5 class="card-header ">
                                    <div class="input-group ">
                                        <span class="input-group-text bg-primary text-white" id="basic-addon11">ค้นหาข้อมูล </span>
                                        <input type="text" autocomplete="yes" id="search" name="search" class="form-control" placeholder="ค้นหาข้อมูลจากตาราง" />
                                    </div>
                                </h5>
                                <div class="card-body">
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-bordered" id="tablePayment">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">รหัสการสั่งซื้อ</th>
                                                    <th class="text-center">ผู้สั่งซื้อ </th>
                                                    <th class="text-center">วันที่สั่งซื้อ</th>
                                                    <th class="text-center">ยอดเงินรวม</th>
                                                    <th class="text-center">สถานะการสั่งซื้อ</th>
                                                    <th class="text-center"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbPayment">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <?php include("../../include/footer.php"); ?>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
</body>
<?php include("../../include/script.php"); ?>
<script src="../../assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="../../assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="../../assets/plugins/toastr/toastr.min.js"></script>
<script src="../../assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>

<script>
    var table; 

    $(document).ready(function() {
        dataOrder();
        if (sessionStorage.getItem('toastrShown') === 'edit') {
            toastr.success("แก้ไขข้อมูลแล้วค่ะ !");
            sessionStorage.removeItem('toastrShown');
        }
        if (sessionStorage.getItem('toastrShown') === 'save') {
            toastr.success("บันทึกข้อมูลแล้วค่ะ !");
            sessionStorage.removeItem('toastrShown');
        }
    });

    $('#search').on('input', function() {
        var value = $(this).val().trim();
        table.search(value).draw();
    });

    function dataOrder() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                $('#tablePayment').DataTable().destroy();
                document.getElementById("tbPayment").innerHTML = this.responseText;
                $('#tablePayment').DataTable({
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
                    "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "ทั้งหมด"] ]
                });
                table = $('#tablePayment').DataTable();
            }
        };
        var status = "<?php echo isset($_GET['status']) ? $_GET['status'] : 'All'; ?>";
        xhttp.open("GET", "../../services/payment/tablePayment.php?status=" + status, true);
        xhttp.send();
    }
</script>