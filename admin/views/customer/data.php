<?php include("../../include/header.php"); ?>
<link rel="stylesheet" href="../../assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="../../assets/plugins/toastr/toastr.min.css">

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
                        <h4 class="py-3 mb-4"><span class="text-muted fw-light">ข้อมูลลูกค้า</span></h4>
                        <div class="row">
                            <!-- Basic Layout -->
                            <div class="col-xxl">
                                <div class="card mb-4">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0">
                                            <?php if ($id == "") {
                                                echo "เพิ่มข้อมูล";
                                            } else {
                                                echo "รายละเอียด";
                                            } ?>
                                        </h5>

                                    </div>
                                    <div class="card-body">
                                        <form id="customerForm">
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="customer_id">รหัสลูกค้า</label>
                                                <div class="col-sm-10 form-group">
                                                    <input type="text" class="form-control" ReadOnly id="customer_id" name="customer_id" placeholder="รหัสลูกค้า" />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="customer_fname">ชื่อลูกค้า</label>
                                                <div class="col-sm-10 form-group">
                                                    <input type="text" class="form-control"  id="customer_fname" name="customer_fname" placeholder="ชื่อลูกค้า" <?php if (isset($_GET['id'])) { echo "ReadOnly"; }?> />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="customer_lname">นามสกุลลูกค้า</label>
                                                <div class="col-sm-10 form-group">
                                                    <input type="text" class="form-control" id="customer_lname" name="customer_lname" placeholder="นามสกุลลูกค้า" <?php if (isset($_GET['id'])) { echo "ReadOnly"; }?> />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="c_address">ที่อยู่</label>
                                                <div class="col-sm-10 form-group">
                                                    <div class="input-group input-group-merge">
                                                        <textarea class="form-control" id="c_address" name="c_address" rows="2" placeholder="ที่อยู่" <?php if (isset($_GET['id'])) { echo "ReadOnly"; }?>></textarea>

                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="customer_telephone" <?php if (isset($_GET['id'])) { echo "ReadOnly"; }?>>เบอร์โทรศัพท์</label>
                                                <div class="col-sm-10 form-group">
                                                    <div class="input-group input-group-merge">
                                                        <input type="text" id="customer_telephone" name="customer_telephone" class="form-control" placeholder="เบอร์โทรศัพท์" <?php if (isset($_GET['id'])) { echo "ReadOnly"; }?> />

                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="c_email">Email</label>
                                                <div class="col-sm-10 form-group">
                                                    <div class="input-group input-group-merge">
                                                        <input type="email" id="c_email" name="c_email" class="form-control" placeholder="อีเมล"  <?php if (isset($_GET['id'])) { echo "ReadOnly"; }?>/>

                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="c_email">Username</label>
                                                <div class="col-sm-10 form-group">
                                                    <div class="input-group input-group-merge">
                                                        <input type="<?php if(!isset($_GET['id'])) { echo "text";} else { echo "password"; } ?>" id="customer_username" name="customer_username" class="form-control" placeholder="Username" <?php if (isset($_GET['id'])) { echo "ReadOnly"; }?> />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="c_email">Password</label>
                                                <div class="col-sm-10 form-group">
                                                    <div class="input-group input-group-merge">
                                                        <input type="<?php if(!isset($_GET['id'])) { echo "text";} else { echo "password"; } ?>" id="c_password" name="c_password" class="form-control" placeholder="Password" <?php if (isset($_GET['id'])) { echo "ReadOnly"; }?>/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="c_status">สถานะ </label>
                                                <div class="col-sm-10 form-group">
                                                    <select id="c_status" name="c_status" class="form-select" <?php if (isset($_GET['id'])) { echo "Disabled"; }?>>
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
                                                    <button type="button" id="btnReset" class="btn btn-secondary">กลับ</button>
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
            $('#btnSaveEdit').hide()
            getdataCustomer(id)


        } else {
            //เพิ่มข้อมูลใหม่
            $('#btnSave').show()
            $.ajax({
                url: "../../services/customer/data.php?v=maxIdCustomer",
                type: "GET",
                success: function(Res) {
                    $('#customer_id').val(Res.maxid)
                }
            });
        }

    });

    function getdataCustomer(id) {
        $.ajax({
            url: "../../services/customer/data.php?v=dataCustomerByID&id=" + id,
            type: "GET",
            success: function(Res) {
                if (Res.status == "ok") {
                    let data = Res.data;
                    $('#customer_id').val(data.customer_id)
                    $('#customer_fname').val(data.customer_fname)
                    $('#customer_lname').val(data.customer_lname)
                    $('#customer_telephone').val(data.customer_telephone)
                    $('#c_address').val(data.c_address)
                    $('#c_email').val(data.c_email)
                    $('#c_password').val(data.c_password)
                    $('#customer_username').val(data.customer_username)
                    $('#c_status').val(data.c_status)
                    $('#customerForm').valid();
                }
            }
        });
    }
    //บันทึก
    $("#btnSave").on("click", function() {

        if ($('#customerForm').valid()) {

            $.ajax({
                async: true,
                url: "../../services/customer/data.php?v=insertcustomer",
                type: "POST",
                cache: false,
                data: $('#customerForm').serialize(),
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

        if ($('#customerForm').valid()) {
            let id = $('#btnSaveEdit').val();
            $.ajax({
                async: true,
                url: "../../services/customer/data.php?v=updateCustomerAll&id=" + id,
                type: "POST",
                cache: false,
                data: $('#customerForm').serialize(),
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


    $('#customerForm').validate({
        rules: {
            customer_id: {
                required: true,
             },
            customer_fname: {
                required: true,

            },
            customer_lname: {
                required: true,
            },
            c_email: {
                required: true,
            },
            c_password: {
                required: true,
            },
            c_status: {
                required: true,
            },
            customer_username: {
                required: true,
            },
            customer_telephone: {
                required: true,
                digits: true, // ต้องเป็นตัวเลขเท่านั้น
                minlength: 10, // ต้องมีจำนวน 10 ตัว
                maxlength: 10
            },
            c_address: {
                required: true,
            },


        },
        messages: {
            customer_id: {
                required: "โปรดกรอกรหัสลูกค้า",
            },
            customer_fname: {
                required: "โปรดกรอกชื่อ",
            },
            customer_lname: {
                required: "โปรดกรอกนามสกถล",
            },
            customer_telephone: {
                required: "กรุณากรอกเบอร์โทรศัพท์",
                digits: "กรุณากรอกเฉพาะตัวเลข",
                minlength: "กรุณากรอกเบอร์โทรศัพท์ที่มีจำนวน 10 ตัว"
            },
            c_address: {
                required: "กรุณากรอกที่อยู่",
            },
            c_email: {
                required: "กรุณากรอกอีเมล",
            },
            c_password: {
                required: "กรุณากรอก Password",
            },
            customer_username: {
                required: "กรุณากรอก Username",
            },
            c_status: {
                required: "กรุณาเลือกสถานะ",
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