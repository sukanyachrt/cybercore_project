<?php
include("include/header.php");
?>

<link rel="stylesheet" href="assets/toastr/toastr.min.css">
<style>
  #toast-container>.toast-error {
    background-color: orange;
  }

  .form {
    background: rgba(19, 35, 47, .6);
    padding: 20px;
    max-width: 500px;
    margin: 20px auto;
    border-radius: 4px;
    box-shadow: 0 4px 10px 4px rgba(19, 35, 47, .1);
  }

  .tab-group {
    list-style: none;
    padding: 0;
    margin: 0 0 10px 0;
  }

  .tab-group:after {
    content: "";
    display: table;
    clear: both;
  }

  .tab-group li a {
    display: block;
    text-decoration: none;
    padding: 8px;
    background: rgba(160, 179, 176, .25);
    color: #a0b3b0;
    font-size: 15px;
    float: left;
    width: 50%;
    text-align: center;
    cursor: pointer;
    transition: 0.5s ease;
  }

  .tab-group li a:hover {
    background: #003366;
    color: #fff;
  }

  .tab-group .active a {
    background: #003366;
    color: #fff;
  }

  .tab-content>div:last-child {
    display: none;
  }
</style>

<body>
  <?php

  include("include/menunav.php");
  ?>
  <section class="d-flex justify-content-center align-items-center" style="background-size: cover; background-position: center;">
    <div class="row col-md-9 col-12">
      <div class="col-12">

        <div class="form">
          <ul class="tab-group">
            <li class="tab  active"><a href="#login">Log In</a></li>
            <li class="tab bg-danger"><a href="#signup">Sign Up</a></li>
          </ul>
          <div class="tab-content">
            <div id="login">
              <form id="loginForm">
                <h1 class="text-center h3 mb-3 fw-normal text-white font-weight-bold fw-bold">ยินดีต้อนรับ</h1>
                <div class="mb-3 form-group">
                  <input type="text" class="form-control" id="Username" name="Username" placeholder="Username" autofocus />
                </div>
                <div class="mb-3 form-password-toggle ">

                  <div class="input-group input-group-merge form-group">
                    <input type="password" class="form-control" id="Password" name="Password" placeholder="Password" aria-describedby="password" />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                <div class="mb-3  text-end">
                  <a href="#" data-bs-toggle="modal" data-bs-target="#resetpasswordModal" class="text-white">ลืมรหัสผ่าน ?</a>
                </div>
                <div class="mb-1">
                  <button class="btn btn-danger w-100 py-2 maincolor" type="submit">เข้าสู่ระบบ</button>
                </div>

              </form>
            </div>
            <div id="signup">
              <form class="" id="signupForm">
                <h1 class="text-center h3 mb-3 fw-normal text-white font-weight-bold fw-bold">ลงทะเบียนเพื่อเป็นสมาชิก</h1>
                <div class="row">
                  <div class="col-md-6  my-1 form-group">
                    <input type="text" class="form-control" id="customer_fname" name="customer_fname" placeholder="ชื่อ">

                  </div>
                  <div class="col-md-6  my-1 form-group">
                    <input type="text" class="form-control" id="customer_lname" name="customer_lname" placeholder="นามสกุล">

                  </div>
                  <div class="col-12 my-1 form-group">
                    <input type="text" class="form-control" id="customer_telephone" name="customer_telephone" placeholder="เบอร์โทรศัพท์">

                  </div>
                  <div class="col-12 my-1 form-group">
                    <input type="text" class="form-control" id="c_address" name="c_address" placeholder="ที่อยู่">

                  </div>
                  <div class="col-12 my-1 form-group">
                    <input type="email" class="form-control" id="c_email" name="c_email" placeholder="Email">

                  </div>
                  <div class="col-12 my-1 form-group">
                    <input type="text" class="form-control" id="customer_username" name="customer_username" placeholder="Username">

                  </div>
                  
                  <div class="col-12 my-1 form-group">
                    <input type="password" class="form-control" id="c_password" name="c_password" placeholder="Password">

                  </div>
                  <div class="col-12 mt-2">
                    <button class="btn btn-danger w-100 py-2 maincolor" type="submit">Register</button>
                  </div>
                </div>

              </form>

            </div>
          </div>
        </div>
      </div>

    </div>
    <!-- Modal แจ้งเตือน-->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
            <button type="button" class="btn btn-warning" data-bs-dismiss="modal">ตกลง</button>
          </div>
        </div>
      </div>
    </div>

    <!-- modal reset password -->
    <div class="modal fade" id="resetpasswordModal" tabindex="-1" aria-labelledby="resetpasswordModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">
          <form class="" id="resetForm">
            <div class="modal-header">
              <h5 class="modal-title" id="resetpasswordModalLabel">ลืมรหัสผ่าน</h5>
             
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="alert alert-danger" style="display: none;" role="alert" id="showReset"></div>
              <div class="row">
                <div class="col mb-3">
                  <label for="nameWithTitle" class="form-label">Username / Email</label>
                  <input type="text" id="resetUsername" name="resetUsername" class="form-control" placeholder="Username" />
                </div>
              </div>
              <div class="row">
                <div class="col mb-3">
                  <label for="nameWithTitle" class="form-label">Password</label>
                  <input type="password" class="form-control" id="ResetPassword" name="ResetPassword" placeholder="Password" aria-describedby="password" />
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-danger w-100">ตกลง</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </section>


  <?php include("include/footer.php"); ?>

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="assets/jquery-validation/jquery.validate.min.js"></script>
  <script src="assets/toastr/toastr.min.js"></script>

  <?php include("include/script.php"); ?>
  <script>
    // การ switch tab
    $('.tab a').on('click', function(e) {

      e.preventDefault();

      $(this).parent().addClass('active');
      $(this).parent().siblings().removeClass('active');

      target = $(this).attr('href');

      $('.tab-content > div').not(target).hide();

      $(target).fadeIn(600);
      $('input[type="password"]').val('');
    });

    

    function showModal() {
      $('#exampleModal').modal('show')
    }


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
          alphanumeric: "โปรดกรอก Username ที่สมัครใช้งาน",
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
            if (response.status == "ok") {
              postSession(response);

            } else {
              $('.modal-body').text(response.msg);
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

    $('#signupForm').validate({
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
          url: "services/auth/data.php?v=createCustomer",
          data: $(form).serialize(),
          success: function(response) {
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

    // 
    $('#resetForm').validate({
      rules: {
        resetUsername: {
          required: true,
          alphanumeric: true, // เพิ่มกฎ alphanumeric สำหรับตัวเลขและตัวอักษร
        },
        ResetPassword: {
          required: true,
          alphanumeric: true, // เพิ่มกฎ alphanumeric สำหรับตัวเลขและตัวอักษร
        },
      },
      messages: {
        resetUsername: {
          required: "โปรดกรอกรหัสผู้ใช้งาน",
          alphanumeric: "โปรดกรอกรหัสผู้ใช้งานที่มีเฉพาะตัวเลขและตัวอักษร",
        },
        ResetPassword: {
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
        $('#showReset').hide()
        $.ajax({
          type: 'POST',
          url: "services/auth/data.php?v=resetpassword",
          data: $(form).serialize(),
          success: function(response) {
            if (response.status == "ok") {
              toastr.success(response.msg)
              $('#resetpasswordModal').modal('hide')

            } else {
              console.log(response)
              
              $('#showReset').text(response.msg)
              $('#showReset').show()
            }
          },
          error: function(error) {
            console.log(error)
          }
        });
      },
    });

    // เพิ่มเงื่อนไขสำหรับกฎ alphanumeric
    $.validator.addMethod("email", function(value, element) {
      return this.optional(element) || /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value);
    }, "โปรดกรอก email ให้ถูกต้อง");

    $.validator.addMethod("alphanumeric", function(value, element) {
      return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
    }, "โปรดกรอกข้อมูลที่มีเฉพาะตัวเลขและตัวอักษร (a-zA-Z0-9)");

    function postSession(data) {
      $.ajax({
        url: "./createsession.php?d=createsession&v=<?php echo isset($_GET['v']) ? $_GET['v'] : '' ?>",
        type: "POST",
        data: data, // ใช้ข้อมูลจากการร้องขอแรก
        success: function(Res) {

          window.location.replace(Res.page);
        },

      });
    }
    
  </script>




</body>

</html>