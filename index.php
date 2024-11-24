<!-- ======= header and css  ======= -->
<?php
include("include/header.php");
$connect = new Connect_Data();
$connect->connectData();

?>

<body>

  <!-- ======= Menu ======= -->
  <?php
  include("include/menunav.php");
  ?>


  <!-- ======= Hero Section ======= -->
  <section id="home" class="hero d-flex align-items-center section-bg">
    <div class="container">
      <div class="row justify-content-between gy-5">
        <div class="col-lg-5 order-2 order-lg-1 d-flex flex-column justify-content-center align-items-center align-items-lg-start text-center text-lg-start">
          <h2 data-aos="fade-up">CyberCore<br>อุปกรณ์คอมพิวเตอร์</h2>
          <p data-aos="fade-up" data-aos-delay="100">เป็นร้านขายอุปกรณ์คอมพิวเตอร์ โดยมีร้านค้าตั้งอยู่ที่ ถนนอัสสัมชัญ แขวงบางไผ่ เขตบางแค กรุงเทพมหานคร 10160</p>
          <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
            <a href="#product" class="btn-book-a-table">Shop</a>
          </div>
        </div>
        <div class="col-lg-7 order-1 order-lg-2 text-center text-lg-start">
          <img src="assets/img/logo_login.jpg" class="img-fluid" alt="" data-aos="zoom-out" data-aos-delay="300">
        </div>
      </div>
    </div>
  </section><!-- End Hero Section -->

  <main id="main">

    


    <section id="product" class="product">

      <div class="section-header">
        <div class="my-4"></div>
        <h2>สินค้า</h2>
        <p>รวมสินค้า<span>ร้านเรา!</span></p>
      </div>

      <div class="text-center">
        <div class="container">
          <div class="row">
            <?php
            $connect->sql = "SELECT  * FROM  product  WHERE product_status =1";
            $connect->queryData();
            while ($rsconnect = $connect->fetch_AssocData()) {
            ?>
              <div class="col-sm-1 col-md-3 col-lg-3 mb-3">
                <div class="card">
                  <img src="assets/img/product/<?= $rsconnect['product_image'] ?>" class="card-img-top" alt="...">
                  <div class="card-body">
                    <h5 class="card-title"><?= $rsconnect['product_name'] ?></h5>
                    <p class="card-detail"><?= $rsconnect['product_detail'] ?></p>
                    <a href="product.php?id=<?= $rsconnect['product_id'] ?>" class="btn btn-outline-dark me-2">ดูเพิ่มเติม</a>
                  </div>

                </div>
              </div>

            <?php
            }
            ?>







          </div>
        </div>
    </section>

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Contact</h2>
          <p><span>Contact Us</span></p>
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3734.4750480759194!2d100.36842107491967!3d13.731794886658003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e297c5e7a461bf%3A0x3764918b24f9fd48!2z4LmC4Lij4LiH4LmA4Lij4Li14Lii4LiZ4Lit4Lix4Liq4Liq4Lix4Lih4LiK4Lix4LiN4LiY4LiZ4Lia4Li44Lij4Li1!5e1!3m2!1sth!2sth!4v1731939524858!5m2!1sth!2sth" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <div class="row gy-4">
          <div class="col-md-6">
            <div class="info-item  d-flex align-items-center">
              <i class="icon bi bi-map flex-shrink-0"></i>
              <div>
                <h3>ที่อยู่ร้านค้า</h3>
                <p> ถนนอัสสัมชัญ แขวงบางไผ่ เขตบางแค กรุงเทพมหานคร 10160</p>
              </div>
            </div>
          </div><!-- End Info Item -->

          <div class="col-md-6">
            <div class="info-item d-flex align-items-center">
              <i class="icon bi bi-envelope flex-shrink-0"></i>
              <div>
                <h3>Email</h3>
                <p> kongpob@gnail.com</p>
              </div>
            </div>
          </div><!-- End Info Item -->

          <div class="col-md-6">
            <div class="info-item  d-flex align-items-center">
              <i class="icon bi bi-telephone flex-shrink-0"></i>
              <div>
                <h3>เบอร์โทร</h3>
                <p>012 345 6789</p>
              </div>
            </div>
          </div><!-- End Info Item -->

          <div class="col-md-6">
            <div class="info-item  d-flex align-items-center">
              <i class="icon bi bi-share flex-shrink-0"></i>
              <div>
                <h3>เวลา เปิด-ปิด ร้าน</h3>
                <div><strong>จันทร์ - ศุกร์ :</strong> 08.00น. - 18.00น.
                  <br><strong>เสาร์ - อาทิตย์ :</strong> ปิด</br>
                </div>
              </div>
            </div>
          </div><!-- End Info Item -->

        </div>

        <!--End Contact Form -->

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

  <?php include("include/footer.php"); ?>

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <?php include("include/script.php"); ?>

</body>

</html>