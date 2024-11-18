<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/c/CodingLabYT-->
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <!--<title> Login and Registration Form in HTML & CSS | CodingLab </title>-->
    <style>
        /* Google Font Link */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: linear-gradient(-225deg, #E3FDF5 0%, #FFE6FA 100%);
            background-image: linear-gradient(to top, #a8edea 0%, #fed6e3 100%);
            background-attachment: fixed;
            background-repeat: no-repeat;
            padding: 30px;
        }

        .container {
            position: relative;
            max-width: 850px;
            width: 100%;
            background: #fff;
            padding: 40px 30px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            perspective: 2700px;
        }

        .container .cover {
            position: absolute;
            top: 0;
            left: 50%;
            height: 100%;
            width: 50%;
            z-index: 98;
            transition: all 1s ease;
            transform-origin: left;
            transform-style: preserve-3d;
        }

        .container #flip:checked~.cover {
            transform: rotateY(-180deg);
        }

        .container .cover .front,
        .container .cover .back {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
        }

        .cover .back {
            transform: rotateY(180deg);
            backface-visibility: hidden;
        }

        .container .cover::before,
        .container .cover::after {
            content: '';
            position: absolute;
            height: 100%;
            width: 100%;
            background: #000000;
            opacity: 0.5;
            z-index: 12;
        }

        .container .cover::after {
            opacity: 0.3;
            transform: rotateY(180deg);
            backface-visibility: hidden;
        }

        .container .cover img {
            position: absolute;
            height: 100%;
            width: 100%;
            object-fit: cover;
            z-index: 10;
        }

        .container .cover .text {
            position: absolute;
            z-index: 130;
            height: 100%;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .cover .text .text-1,
        .cover .text .text-2 {
            font-size: 26px;
            font-weight: 600;
            color: #fff;
            text-align: center;
        }

        .cover .text .text-2 {
            font-size: 15px;
            font-weight: 500;
        }

        .container .forms {
            height: 100%;
            width: 100%;
            background: #fff;
        }

        .container .form-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .form-content .login-form,
        .form-content .signup-form {
            width: calc(100% / 2 - 25px);
        }

        .forms .form-content .title {
            position: relative;
            font-size: 24px;
            font-weight: 500;
            color: #333;
        }

        .forms .form-content .title:before {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            height: 3px;
            width: 25px;
            background: #000000;
        }

        .forms .signup-form .title:before {
            width: 20px;
        }

        .forms .form-content .input-boxes {
            margin-top: 30px;
        }

        .forms .form-content .input-box {
            display: flex;
            align-items: center;
            height: 50px;
            width: 100%;
            margin: 10px 0;
            position: relative;
        }

        .form-content .input-box input {
            height: 100%;
            width: 100%;
            outline: none;
            border: none;
            padding: 0 30px;
            font-size: 16px;
            font-weight: 500;
            border-bottom: 2px solid rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .form-content .input-box input:focus,
        .form-content .input-box input:valid {
            border-color: #000000;
        }

        .form-content .input-box i {
            position: absolute;
            color: #000000;
            font-size: 17px;
        }

        .forms .form-content .text {
            font-size: 14px;
            font-weight: 500;
            color: #333;
        }

        .forms .form-content .text a {
            text-decoration: none;
        }

        .forms .form-content .text a:hover {
            text-decoration: underline;
        }

        .forms .form-content .button {
            color: #fff;
            margin-top: 40px;
        }

        .forms .form-content .button input {
            color: #fff;
            background: #000000;
            border-radius: 6px;
            padding: 0;
            cursor: pointer;
            transition: all 0.4s ease;
        }

        .forms .form-content .button input:hover {
            background: #000000;
        }

        .forms .form-content label {
            color: #000000;
            cursor: pointer;
        }

        .forms .form-content label:hover {
            text-decoration: underline;
        }

        .forms .form-content .login-text,
        .forms .form-content .sign-up-text {
            text-align: center;
            margin-top: 25px;
        }

        .container #flip {
            display: none;
        }

        @media (max-width: 730px) {
            .container .cover {
                display: none;
            }

            .form-content .login-form,
            .form-content .signup-form {
                width: 100%;
            }

            .form-content .signup-form {
                display: none;
            }

            .container #flip:checked~.forms .signup-form {
                display: block;
            }

            .container #flip:checked~.forms .login-form {
                display: none;
            }
        }
    </style>
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link rel="stylesheet" href="assets/plugins/toastr/toastr.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="container">
        <div class="cover">
            <div class="front">
                <img src="assets/img/logo_login.jpg" alt="">
                <div class="text">
                    <span class="text-1">CyberCore<br>อุปกรณ์คอมพิวเตอร์</span>
                    <span class="text-2"></span>
                </div>
            </div>

        </div>
        <div class="forms">
            <div class="form-content">
                <div class="login-form">
                    <div class="title">เข้าสู่ระบบ</div>
                    <form action="#" id="loginForm">
                        <div class="input-boxes">
                            <div class="input-box input-group">
                                <i class="fas fa-envelope"></i>
                                <input type="text" id="Username" autocomplete="yes" name="Username" placeholder="Enter your username" required>
                            </div>
                            <div class="input-box input-group">
                                <i class="fas fa-lock"></i>
                                <input type="password" id="Password" name="Password" placeholder="Enter your password" required>
                            </div>

                            <div class="button input-box">
                                <input type="submit" value="เข้าสู่ระบบ">
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</body>
<script src="assets/vendor/libs/jquery/jquery.js"></script>
<script src="assets/plugins/jquery-validation/jquery.validate.min.js"></script>

<script src="assets/plugins/toastr/toastr.min.js"></script>

<script>
    $('#loginForm').validate({
        rules: {
            Username: {
                required: true,
                alphanumeric: true, // เพิ่มกฎ alphanumeric สำหรับตัวเลขและตัวอักษร
            },
            Password: {
                required: true,
                alphanumeric: true, // เพิ่มกฎ alphanumeric สำหรับตัวเลขและตัวอักษร
            },
        },
        messages: {
            Username: {
                required: "โปรดกรอกรหัสผู้ใช้งาน",
                alphanumeric: "โปรดกรอกรหัสผู้ใช้งานที่มีเฉพาะตัวเลขและตัวอักษร",
            },
            Password: {
                required: "โปรดกรอกรหัสผ่าน",
                alphanumeric: "โปรดกรอกรหัสผ่านที่มีเฉพาะตัวเลขและตัวอักษร",
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
                url: "services/auth/data.php?v=checkauth",
                data: $(form).serialize(),
                success: function(response) {
                    console.log(response)
                    if (response.status == "ok") {
                        postSession(response);

                    } else {
                        toastr.error(response.msg)
                    }
                },
                error: function(error) {
                    console.log(error)
                }
            });
        },
    });

    // เพิ่มเงื่อนไขสำหรับกฎ alphanumeric
    $.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
    }, "โปรดกรอกข้อมูลที่มีเฉพาะตัวเลขและตัวอักษร (a-z)");

    function postSession(data) {
        $.ajax({
            url: "./createsession.php",
            type: "POST",
            data: data, // ใช้ข้อมูลจากการร้องขอแรก
            success: function(Res) {
                sessionStorage.removeItem('menu');
                window.location.replace(Res.page);
            },

        });
    }
</script>

</html>