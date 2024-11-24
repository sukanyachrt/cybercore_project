<?php include("../../include/header.php"); ?>
<link rel="stylesheet" href="../../assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="../../assets/plugins/toastr/toastr.min.css">

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include("../../include/checkmenu.php"); ?>
            <div class="layout-page">
                <?php include("../../include/navbar.php"); ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="py-3 mb-0">ข้อมูลการชำระเงิน</h4>
                        <div class="row">
                            <div class="col-md-12">

                                <!-- <div class="my-3">
                                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                        <a href="?status=All" class="btn btn-outline-secondary <?php if (isset($_GET['status']) && $_GET['status'] == "All") echo "active"; ?>">
                                            <i class="tf-icons bx bx-list-check"></i>
                                            ทั้งหมด
                                        </a>
                                        <a href="?status=1"  class="btn btn-outline-danger <?php if (isset($_GET['status'])&& $_GET['status'] == "1") echo "active"; ?>">
                                            <i class="tf-icons bx bx-credit-card"></i>
                                            รอชำระเงิน
                                        </a>
                                        <a href="?status=2"  class="btn btn-outline-warning <?php if (!isset($_GET['status']) || $_GET['status'] == "2") echo "active"; ?>">
                                            <i class="tf-icons bx bx-check-circle"></i>
                                            รอยืนยันการชำระเงิน
                                        </a>
                                        <a href="?status=3"  class="btn btn-outline-info <?php if (isset($_GET['status']) && $_GET['status'] == "3") echo "active"; ?>">
                                            <i class="tf-icons bx bxs-backpack"></i>
                                            รอจัดส่ง
                                        </a>
                                        <a href="?status=4"  class="btn btn-outline-success <?php if (isset($_GET['status']) && $_GET['status'] == "4") echo "active"; ?>">
                                            <i class="tf-icons bx bx-check-double"></i>
                                            จัดส่งเรียบร้อยแล้ว
                                        </a>
                                        <a href="?status=0"  class="btn btn-outline-dark <?php if (isset($_GET['status']) && $_GET['status'] == "0") echo "active"; ?>">
                                            <i class="tf-icons bx bx-x"></i>
                                            ข้อมูลการชำระเงินไม่ถูกต้อง
                                        </a>
                                    </div>
                                </div> -->
                               


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
                                        <table class="table table-bordered">
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
<script>
    $(document).ready(function() {
        dataProducttype();
        if (sessionStorage.getItem('toastrShown') === 'edit') {
            toastr.success("แก้ไขข้อมูลแล้วค่ะ !");
            sessionStorage.removeItem('toastrShown');
        }
        if (sessionStorage.getItem('toastrShown') === 'save') {
            toastr.success("บันทึกข้อมูลแล้วค่ะ !");
            sessionStorage.removeItem('toastrShown');
        }
    });
    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tbPayment tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });


    function dataProducttype() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("tbPayment").innerHTML = this.responseText;

            }
        };
        var status = "<?php echo isset($_GET['status']) ? $_GET['status'] : '2'; ?>";
        xhttp.open("GET", "../../services/payment/tablePayment.php?status=" + status, true);
        xhttp.send();
    }
</script>