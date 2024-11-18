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
    <div class="container mt-5">

      <div class="row d-flex justify-content-center">

        <div class="col-md-9">

          <div class="card p-3 py-4 radius-10 border-start border-0 border-3 border-danger bordermaincolor">

            <div class="text-center">
              <img src="assets/img/userprofile.png" width="100" class="rounded-circle">
            </div>

            <div class="text-center mt-3">
              <h5 class="mt-2 mb-0"><?= $_SESSION['customer_fname'] . " " . $_SESSION['customer_lname'] ?></h5>
            </div>
            <div>
              <ul class="list-group mt-5">

                <li class="list-group-item list-group-item-danger maincolor">รายละเอียด</li>
                <?php
                $connect->sql = "SELECT * FROM 	customers  WHERE customer_id  ='" . $_SESSION['customer_id'] . "'";
                $connect->queryData();
                $rsconnect = $connect->fetch_AssocData();
                ?>

                <li class="list-group-item">ชื่อ : <?= $rsconnect['customer_fname'] . " " . $rsconnect['customer_lname'] ?></li>
                <li class="list-group-item">เบอร์โทรศัพท์ : <?= $rsconnect['customer_telephone'] ?></li>
                <li class="list-group-item">ที่อยู่ :<?= $rsconnect['c_address'] ?></li>
                <li class="list-group-item">email :<?= $rsconnect['c_email'] ?></li>
                <li class="list-group-item">Username :<?= $rsconnect['customer_username'] ?></li>
                <li class="list-group-item">Password :<?= $rsconnect['c_password'] ?></li>
              </ul>
            </div>
            <div class="text-center mt-3">
              <a href="editprofile.php"  class="btn btn-danger maincolor px-4">แก้ไขข้อมูล</a>
              
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
  <?php include("include/script.php"); ?>