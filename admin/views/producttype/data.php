<?php include("../../include/header.php"); ?>
<link rel="stylesheet" href="../../assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="../../assets/plugins/toastr/toastr.min.css">
<?php
include('../../services/connect_data.php');
 $connect = new Connect_Data();
 $connect->connectData();
?>
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include("../../include/checkmenu.php"); ?>
            <div class="layout-page">
                <?php include("../../include/navbar.php"); ?>
                <?php
                $id = isset($_GET['id']) ? $_GET['id'] : '';
                ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="py-3 mb-4"><span class="text-muted fw-light">ข้อมูลประเภทสินค้า</span></h4>
                        <div class="row">
                            <!-- Basic Layout -->
                            <div class="col-xxl">
                                <div class="card mb-4">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0">
                                            
                                            <?php if($id=="") { echo "เพิ่มข้อมูล" ;} else { echo "แก้ไขข้อมูล";}?>
                                        </h5>

                                    </div>
                                    <div class="card-body">
                                        <form id="producttypeForm">
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="protype_id">รหัสประเภทสินค้า</label>
                                                <div class="col-sm-10 form-group">
                                                    <input type="text" class="form-control" ReadOnly id="protype_id" name="protype_id" placeholder="รหัสประเภทสินค้า" />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="protype_name">ชื่อประเภทสินค้า	</label>
                                                <div class="col-sm-10 form-group">
                                                    <input type="text" class="form-control" id="protype_name" name="protype_name" placeholder="ชื่อประเภทสินค้า	" />
                                                </div>
                                            </div>
                                            
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="protype_status">สถานะ </label>
                                                <div class="col-sm-10 form-group">
                                                    <select id="protype_status" name="protype_status" class="form-select">
                                                        <option value="">เลือกสถานะ</option>
                                                        <option value="1">ใช้งาน</option>
                                                        <option value="0">ยกเลิก</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            
                                            
                                            
                                            <div class="row justify-content-end">
                                                <div class="col-sm-10">
                                                    <button type="button" id="btnSave" style="display: none;" class="btn btn-primary">บันทึกข้อมูล</button>
                                                    <button type="button" id="btnSaveEdit" style="display: none;" value="<?php echo $id ?>" class="btn btn-primary">บันทึกการแก้ไข</button>
                                                    <button type="button" id="btnReset" class="btn btn-outline-secondary">กลับ</button>
                                                </div>
                                            </div>
                                        </form>
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
    $(function() {
        
        let id = $('#btnSaveEdit').val();
        if (id != "") {
            $('#btnSaveEdit').show()
            getdataEmploy(id)
           

        } else {
            //เพิ่มข้อมูลใหม่
            $('#btnSave').show()
            $.ajax({
                url: "../../services/producttype/data.php?v=maxIdProducttype",
                type: "GET",
                success: function(Res) {
                    console.log(Res)
                    $('#protype_id').val(Res.maxid)
                }
            });
        }

    });
    function getdataEmploy(id){
        $.ajax({
                url: "../../services/producttype/data.php?v=dataproducttype_id&id=" + id,
                type: "GET",
                success: function(Res) {
                    if (Res.status == "ok") {
                        let data = Res.data;
                        $('#protype_id').val(data.protype_id)
                        $('#protype_name').val(data.protype_name)
                        $('#protype_status').val(data.protype_status)

                    }
                }
            });
    }
    //บันทึก
    $("#btnSave").on("click", function() {
        
        if ($('#producttypeForm').valid()) {

            $.ajax({
                async: true,
                url: "../../services/producttype/data.php?v=inserteproducttype",
                type: "POST",
                cache: false,
                data: $('#producttypeForm').serialize(),
                success: function(Res) {
                    console.log(Res);
                    if (Res.result >= 0) {
                        sessionStorage.setItem('toastrShown', 'save');
                        location.href = 'index.php';

                    }
                }
            });
        }
    });

    $("#btnSaveEdit").on("click", function() {

        if ($('#producttypeForm').valid()) {
            let id = $('#btnSaveEdit').val();
            $.ajax({
                async: true,
                url: "../../services/producttype/data.php?v=updateProducttype&id=" + id,
                type: "POST",
                cache: false,
                data: $('#producttypeForm').serialize(),
                success: function(Res) {
                    console.log(Res);
                    if (Res.result >= 0) {
                        sessionStorage.setItem('toastrShown', 'edit');
                        location.href = 'index.php';

                    }
                }
            });
        }
    });
    $("#btnReset").on("click", function() {
        location.href = 'index.php';
    })
    

    $('#producttypeForm').validate({
        rules: {
            product_id: {
                required: true,
                
            },
            product_name: {
                required: true,

            },
            product_detail: {
                required: true,
            },
            product_price: {
                required: true,
                digits: true, 
                
            },
            product_num :{
                required: true,
                digits: true, 
            },
            product_status: {
                required: true,
               
            },
            product_image: {
                required: true,
               
            },
            progroup_id: {
                required: true,
               
            },
        },
        messages: {
            product_id: {
                required: "โปรดกรอกรหัสสินค้า",
                
            },
            product_name: {
                required: "โปรดกรอกชื่อสินค้า",
                
            },
            product_detail: {
                required: "โปรดกรอกรายละเอียดสินค้า",
                
            },
            product_price: {
                required: "โปรดกรอกราคาสินค้า",
            },
            product_status: {
                required: "โปรดเลือกสถานะสินค้า",
               
            },
            product_image: {
                required: "โปรดอัพโหลดรูปสินค้า",
              
            },
            progroup_id: {
                required: "โปรดกลุ่มสินค้า",
               
            },
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },

    });

    // เพิ่มเงื่อนไขสำหรับกฎ alphanumeric
    $.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
    }, "โปรดกรอกข้อมูลที่มีเฉพาะตัวเลขและตัวอักษร (a-z)");
</script>