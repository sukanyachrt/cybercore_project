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
                        <h4 class="py-3 mb-4"><span class="text-muted fw-light">ข้อมูลพนักงาน</span></h4>
                        <div class="row">
                            <!-- Basic Layout -->
                            <div class="col-xxl">
                                <div class="card mb-4">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0">

                                            <?php if ($id == "") {
                                                echo "เพิ่มข้อมูล";
                                            } else {
                                                echo "แก้ไขข้อมูล";
                                            } ?>
                                        </h5>

                                    </div>
                                    <div class="card-body">
                                        <form id="employeeForm">
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="employee_id">รหัสพนักงาน</label>
                                                <div class="col-sm-10 form-group">
                                                    <input type="text" class="form-control" ReadOnly id="employee_id" name="employee_id" placeholder="รหัสพนักงาน" />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="employee_fname">ชื่อพนักงาน</label>
                                                <div class="col-sm-10 form-group">
                                                    <input type="text" class="form-control" id="employee_fname" name="employee_fname" placeholder="ชื่อพนักงาน" />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="employee_lname">นามสกุลพนักงาน</label>
                                                <div class="col-sm-10 form-group">
                                                    <input type="text" class="form-control" id="employee_lname" name="employee_lname" placeholder="นามสกุลพนักงาน" />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="employee_username"> Username เข้าสู่ระบบ</label>
                                                <div class="col-sm-10 form-group">
                                                    <input type="text" id="employee_username" name="employee_username" class="form-control" placeholder="Username เข้าสู่ระบบ" />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="employee_password">รหัสผ่าน</label>
                                                <div class="col-sm-10 form-group">
                                                    <input type="text" id="employee_password" name="employee_password" class="form-control" placeholder="รหัสผ่าน" />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="employee_status">สถานะ </label>
                                                <div class="col-sm-10 form-group">
                                                    <select id="employee_status" name="employee_status" class="form-select">
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
                url: "../../services/employee/data.php?v=maxIdEmploy",
                type: "GET",
                success: function(Res) {
                    $('#employee_id').val(Res.maxid)
                }
            });
        }

    });

    function getdataEmploy(id) {
        $.ajax({
            url: "../../services/employee/data.php?v=dataEmployByID&id=" + id,
            type: "GET",
            success: function(Res) {
                if (Res.status == "ok") {
                    let data = Res.data;
                    $('#employee_id').val(data.employee_id)
                    $('#employee_fname').val(data.employee_fname)
                    $('#employee_lname').val(data.employee_lname)
                    $('#employee_username').val(data.employee_username)
                    $('#employee_status').val(data.employee_status)
                    $('#employee_username').val(data.employee_username)
                    $('#employee_password').val(data.employee_password)
                    $('#employeeForm').valid();
                }
            }
        });
    }
    //บันทึก
    $("#btnSave").on("click", function() {

        if ($('#employeeForm').valid()) {

            $.ajax({
                async: true,
                url: "../../services/employee/data.php?v=insertemploy",
                type: "POST",
                cache: false,
                data: $('#employeeForm').serialize(),
                success: function(Res) {
                   if (Res.result >= 0) {
                        sessionStorage.setItem('toastrShown', 'save');
                        location.href = 'index.php';

                    }
                }
            });
        }
    });

    $("#btnSaveEdit").on("click", function() {

        if ($('#employeeForm').valid()) {
            let id = $('#btnSaveEdit').val();
            $.ajax({
                async: true,
                url: "../../services/employee/data.php?v=updateEmployAll&id=" + id,
                type: "POST",
                cache: false,
                data: $('#employeeForm').serialize(),
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


    $('#employeeForm').validate({
        rules: {
            employee_id: {
                required: true,
                alphanumeric: true,
            },
            employee_fname: {
                required: true,

            },
            employee_lname: {
                required: true,

            },
            employee_username: {
                required: true,
                alphanumeric: true,

            },
            employee_password: {
                required: true,
                alphanumeric: true,
            },
            employee_status: {
                required: true,
            },
        },
        messages: {
            employee_id: {
                required: "โปรดกรอกรหัสพนักงาน",
                alphanumeric: "โปรดกรอกรหัสผู้ใช้งานที่มีเฉพาะตัวเลขและตัวอักษร",
            },
            employee_fname: {
                required: "โปรดกรอกชื่อพนักงาน",
            },
            employee_fname: {
                required: "โปรดกรอกนามสกุลพนักงาน",
            },
          
            employee_username: {
                required: "กรุณากรอก Username",
                digits: "กรุณากรอกเฉพาะตัวเลข",
            },
            employee_password: {
                required: "กรุณากรอกรหัสผ่านเข้าสู่ระบบ",
                digits: "กรุณากรอกเฉพาะตัวเลขและตัวอักษร A-ZA",
            },
            employee_status: {
                required: 'โปรดเลือกสถานะ',
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