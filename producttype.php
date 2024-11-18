<?php
include("include/header.php");
?>

<style>

</style>

<body>
    <?php
    $connect = new Connect_Data();
    $connect->connectData();

    $connect->sql = "SELECT  protype_name FROM  producttype  WHERE protype_id  ='" . $_GET['id'] . "'";
    $connect->queryData();
    $rsconnect = $connect->fetch_AssocData();
    $protype_name = $rsconnect['protype_name'];
    ?>
    <!-- ======= Header ======= -->
    <?php
    include("include/menunav.php");
    ?>

    <!-- ======= Menu Section ======= -->
    <section id="material" class="material">

        <div class="section-header">
            <div class="mb-3"></div>
            <h2>สินค้า</h2>
            <p>รวมสินค้า <span><?= $protype_name ?></span></p>
        </div>

        <div class="text-center">
            <div class="container">
                <div class="row">
                    <?php
                    $connect->sql = "SELECT  * FROM  product  WHERE product_status =1  AND protype_id='" . $_GET['id'] . "'";
                    $connect->queryData();
                    $numrows = $connect->num_rows();
                    if ($numrows == 0) {
                    ?>

                        <h6 class="text-danger">ไม่มีข้อมูลสินค้า</h6>

                    <?php
                    }
                    while ($rsconnect = $connect->fetch_AssocData()) {
                    ?>
                        <div class="col-sm-1 col-md-4 col-lg-4 mb-3">
                            <div class="card ">
                                <img src="assets/img/product/<?= $rsconnect['product_image'] ?>" class="card-img-top" alt="..." style="max-height: 250px; object-fit: contain;">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $rsconnect['product_name'] ?></h5>
                                    <p class="card-text"><?php echo $rsconnect['product_detail'] ?></p>
                                    <h5 class="card-title text-danger pb-3">
                                        <?= number_format($rsconnect['product_price'], 2) . " บาท" ?>
                                    </h5>
                                    <div class="quantity">
                                        <button class="minus-btn addcart" type="button" name="button">
                                            <img src="assets/img/minus.svg" alt="" />
                                        </button>
                                        <input type="text" name="quantity" class="quantity-input" value="1">
                                        <button class="plus-btn addcart" type="button" name="button">
                                            <img src="assets/img/plus.svg" alt="" />
                                        </button>
                                    </div>
                                    <button onclick="addToCart(<?php echo $rsconnect['product_id']; ?>, this)" class="btn btn-outline-danger me-2 bordermaincolor">ใส่ตะกร้า</button>
                                    <button href="#" onclick="addToCartTocart(<?php echo $rsconnect['product_id']; ?>, this)" class="btn btn-danger maincolor">สั่งซื้อ</button>
                                </div>

                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
    </section>


    <?php include("include/footer.php"); ?>

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <div id="preloader"></div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php include("include/script.php"); ?>
    <script type="text/javascript">
        $('.minus-btn').on('click', function(e) { //ลบจำนวนสินค้า
            e.preventDefault();
            var $this = $(this);
            var $input = $this.closest('div').find('input');
            var value = parseInt($input.val());

            if (value > 1) {
                value = value - 1;
            } else {
                value = 0;
            }

            $input.val(value);

        });

        $('.plus-btn').on('click', function(e) { //เพิ่มจำนวนสินค้า
            e.preventDefault();
            var $this = $(this);
            var $input = $this.closest('div').find('input');
            var value = parseInt($input.val());
            value = value + 1;
            $input.val(value);
        });

        function addToCart(productId, e) { //เพิ่มสินค้าลงในตะกร้า
            var quantity = $(e).closest('.card-body').find('.quantity-input').val();
            $.ajax({
                type: 'POST',
                url: 'services/addToCart.php?v=addcart',
                data: {
                    productId: productId,
                    quantity: quantity
                },
                success: function(response) {
                    console.log(response)
                    updateCartCount();

                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

        }

        function addToCartTocart(productId, e) { //เพิ่มสินค้าลงในตะกร้า
            var quantity = $(e).closest('.card-body').find('.quantity-input').val();
            $.ajax({
                type: 'POST',
                url: 'services/addToCart.php?v=addcart',
                data: {
                    productId: productId,
                    quantity: quantity
                },
                success: function(response) {
                    console.log(response)
                    updateCartCount();
                    window.location.href = 'cart.php';
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

        }



        function updateCartCount() {
            $.ajax({
                type: 'GET',
                url: 'services/getCartCount.php',
                success: function(response) {
                    console.log(response)

                    $(".count").css("background", "#d60b28");
                    $(".cart .count").css("width", "16px");
                    $('.count').text(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    </script>
</body>

</html>