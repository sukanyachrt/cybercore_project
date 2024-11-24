<?php
include("include/header.php");
?>
<style>

</style>
<?php
$connect = new Connect_Data();
$connect->connectData();
if (!isset($_SESSION['customer_id'])) {
    header('location:login.php');
}
?>

<body>
    <?php
    include("include/menunav.php");
    ?>
    <section id="material" class="material">
        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="assets/img/userprofile.png"><span class="font-weight-bold mt-2"><?= $_SESSION['customer_fname'] . " " . $_SESSION['customer_lname'] ?></span><span> </span></div>
                </div>
                <div class="col-md-9 border-right">
                    <form class="" id="editProfile">
                        <div class="p-3 py-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="text-right">ข้อมูลส่วนตัว</h4>
                            </div>
                            <?php
                            $connect->sql = "SELECT * FROM 	customers  WHERE customer_id  ='" . $_SESSION['customer_id'] . "'";
                            $connect->queryData();
                            $rsconnect = $connect->fetch_AssocData();
                            ?>
                            <div class="row">
                                <div class="col-md-6  my-1">
                                    <div class="form-floating form-group">
                                        <input type="text" class="form-control" id="customer_fname" name="customer_fname" placeholder="ชื่อ" value="<?= $rsconnect['customer_fname'] ?>">
                                        <label for="floatingInput">ชื่อลูกค้า</label>
                                    </div>
                                </div>
                                <div class="col-md-6  my-1">
                                    <div class="form-floating form-group">
                                        <input type="text" class="form-control" id="customer_lname" name="customer_lname" placeholder="นามสกุล" value="<?= $rsconnect['customer_lname'] ?>">
                                        <label for="floatingPassword">นามสกุล</label>
                                    </div>
                                </div>
                                <div class="col-12 my-1">
                                    <div class="form-floating form-group">
                                        <input type="text" class="form-control" id="customer_telephone" name="customer_telephone" placeholder="เบอร์โทรศัพท์" value="<?= $rsconnect['customer_telephone'] ?>">
                                        <label for="floatingPassword">เบอร์โทรศัพท์</label>
                                    </div>
                                </div>
                                <div class="col-12 my-1">
                                    <div class="form-floating form-group">
                                        <input type="text" class="form-control" id="c_address" name="c_address" placeholder="ที่อยู่" value="<?= $rsconnect['c_address'] ?>">
                                        <label for="floatingPassword">ที่อยู่</label>
                                    </div>
                                </div>
                                <div class="col-12 my-1">
                                    <div class="form-floating form-group">
                                        <input type="email" class="form-control" id="c_email" name="c_email" placeholder="Email" value="<?= $rsconnect['c_email'] ?>">
                                        <label for="floatingPassword">Email</label>
                                    </div>
                                </div>
                                <div class="col-12 my-1">
                                    <div class="form-floating form-group">
                                        <input type="text" class="form-control" id="customer_username" name="customer_username" placeholder="Username" value="<?= $rsconnect['customer_username'] ?>">
                                        <label for="floatingPassword">Username</label>
                                    </div>
                                </div>
                                <div class="col-12 my-1">
                                    <div class="form-floating form-group">
                                        <input type="text" class="form-control" id="c_password" name="c_password" placeholder="Password" value="<?= $rsconnect['c_password'] ?>">
                                        <label for="floatingPassword">Password</label>
                                    </div>
                                </div>

                            </div>

                            <div class="mt-5 text-center"><button class="btn btn-danger profile-button" type="submit">Save Profile</button></div>
                        </div>
                    </form>
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
    <script src="assets/jquery-validation/jquery.validate.min.js"></script>

    <?php include("include/script.php"); ?>
    <script>
        $('#editProfile').validate({
            rules: {
                customer_fname: {
                    required: true,
                },
                customer_lname: {
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
                c_email: {
                    required: true,
                    email: true
                },
                customer_username: {
                    required: true,
                    alphanumeric: true,
                },
                c_password: {
                    required: true,
                    alphanumeric: true,
                },
            },
            messages: {
                customer_fname: {
                    required: "โปรดกรอกชื่อลูกค้า",
                },
                customer_lname: {
                    required: "โปรดกรอกนามสกุลลูกค้า",
                },
                customer_telephone: {
                    required: "โปรดกรอกเบอร์โทรลูกค้า",
                    digits: "กรอกเฉพาะตัวเลขเท่านั้น",
                    minlength: "ตัวเลขจำนวน 10 ตัว",
                    maxlength: "ตัวเลขจำนวน 10 ตัว"
                },
                c_address: {
                    required: "โปรดกรอกที่อยู่",
                },
                c_email: {
                    required: "โปรดกรอก email",

                },
                customer_username: {
                    required: "โปรดกรอกรหัสผู้ใช้งาน",
                },
                c_password: {
                    required: "โปรดกรอกรหัสผ่าน",
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
            submitHandler: function(form) {
                $.ajax({
                    type: 'POST',
                    url: "services/auth/data.php?v=updateProfile",
                    data: $(form).serialize(),
                    success: function(response) {
                        console.log(response)
                        if (response.status == "ok") {
                            postSession(response);

                        } else {
                            $('.modal-body').text(response.msg)
                            $('#exampleModal').modal('show')
                            toastr.error(response.msg)
                        }

                    },
                    error: function(error) {
                        console.log(error)
                    }
                });
            },
        });

        function postSession(data) {
            console.log(data)
            $.ajax({
                url: "./createsession.php?d=updatesession",
                type: "POST",
                data: data, // ใช้ข้อมูลจากการร้องขอแรก
                success: function(Res) {
                     console.log(Res)
                    window.location.replace(Res.page);
                },

            });
        }

        // เพิ่มเงื่อนไขสำหรับกฎ alphanumeric
        $.validator.addMethod("email", function(value, element) {
            return this.optional(element) || /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value);
        }, "โปรดกรอก email ให้ถูกต้อง");

        $.validator.addMethod("alphanumeric", function(value, element) {
            return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
        }, "โปรดกรอกข้อมูลที่มีเฉพาะตัวเลขและตัวอักษร (a-z)");
    </script>