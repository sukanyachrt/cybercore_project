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
                        <h4 class="py-3 mb-0">ข้อมูลประเภทสินค้า</h4>

                        <div class="row">
                            <div class="col-lg-12 mb-0 order-0 d-flex justify-content-end">
                                <a href="data.php" class="btn btn-primary text-white account-image-reset mb-4">
                                    <i class="bx bx-plus d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">
                                        <i class="bx bx-plus me-1"></i>

                                        เพิ่มข้อมูล</span>
                                </a>
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
                                                        <th class="text-center">รหัสสินค้า</th>
                                                        <th class="text-center">ชื่อประเภทสินค้า	</th>
                                                        <th class="text-center">สถานะ</th>
                                                        <th class="text-center"></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbproducttype">


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>

                    </div>
                    <div class="modal fade" id="modal_confirm_del" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-warning ">
                                    <h4 class="modal-title text-white" id="exampleModalLabel2">แจ้งเตือน</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h5 class="">ยืนยันการลบข้อมูล ?</h5>
                                </div>
                                <div class="modal-footer text-center">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        ยกเลิก
                                    </button>
                                    <button type="button" id="btnIdProducttype" onclick="confirmDel_employ()" class="btn btn-warning">ยืนยัน</button>
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
        $("#tbproducttype tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });


    function dataProducttype() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("tbproducttype").innerHTML = this.responseText;

            }
        };
        xhttp.open("GET", "../../services/producttype/tableProducttype.php", true);
        xhttp.send();
    }

    function updateEmployStatus(objId) {
        $('#modal_confirm_del').modal('show');
        $('#btnIdProducttype').val(objId)


    }

    function confirmDel_employ() {
        let objId = $('#btnIdProducttype').val();
        $.ajax({
            type: 'GET',
            url: "../../services/producttype/data.php?v=updateProducttypeStatus&id=" + objId,
            success: function(response) {
                if (response.result == 1) {
                    dataProducttype();
                    $('#modal_confirm_del').modal('hide');
                }
            },
            error: function(error) {
                console.log(error)
            }
        });
    }
</script>