<?php
error_reporting(0);
include("include/header.php");
?>
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.css"
    integrity="sha256-NAxhqDvtY0l4xn+YVa6WjAcmd94NNfttjNsDmNatFVc=" crossorigin="anonymous" />

<style>

</style>

<body>
    <?php
    include("include/menunav.php");
    ?>
    <section id="material" class="material">
        <?php

        if ($_SESSION['cart']) {
            ?>

            <div class="container mt-5">
                <div class="row">
                    <div class="col-xl-8">
                        <?php
                        $sumAllmoney = 0;
                        foreach ($_SESSION['cart'] as $index => $value) {
                            $product->sql = "SELECT  *  FROM  product  WHERE product_id ='" . $index . "'";
                            $product->queryData();
                            $result = $product->fetch_AssocData();
                            $sumAllmoney += $result['product_price'] * $value;
                            ?>


                            <div class="card border shadow-none">
                                <div class="card-body" data-product-id="<?= $result['product_id'] ?>">

                                    <div class="d-flex align-items-start border-bottom">
                                        <div class="me-4">
                                            <img src="assets/img/product/<?= $result['product_image'] ?>" alt=""
                                                class="avatar-lg rounded">
                                        </div>
                                        <div class="flex-grow-1 align-self-center overflow-hidden">
                                            <div>
                                                <h5 class="text-truncate font-size-18"><a href="#" class="text-dark">
                                                        <?= $result['product_name'] ?>
                                                    </a></h5>

                                                <p class="mb-0 mt-1"><span class="fw-medium">
                                                        <?= $result['product_detail'] ?>
                                                    </span></p>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ms-2">
                                            <ul class="list-inline mb-0 font-size-16">
                                                <li class="list-inline-item">
                                                    <a href="#" class="text-muted px-1 delete-product">
                                                        <i class="mdi mdi-trash-can-outline"></i>
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mt-1">
                                                    <p class="text-muted mb-2">Price</p>
                                                    <h5 class="mb-0 mt-2"><span class="text-muted me-2">
                                                            <?= "฿" . $result['product_price'] ?>
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="mt-1">
                                                    <p class="text-muted mb-2">Quantity</p>
                                                    <div class="d-inline-flex">
                                                        <div class="quantity">
                                                            <button class="minus-btn px-2" type="button" name="button">
                                                                -
                                                            </button>

                                                            <input type="text" name="name" value="<?= $value ?>">
                                                            <button class="plus-btn" type="button" name="button">
                                                                +
                                                            </button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mt-1">
                                                    <p class="text-muted mb-2">Total</p>
                                                    <h5 class="mb-0 mt-2 product-price"
                                                        data-price="<?= $result['product_price'] ?>">
                                                        <?= "฿" . number_format($result['product_price'] * $value, 2) ?>
                                                    </h5>
                                                </div>
                                            </div>


                                        </div>
                                    </div>

                                </div>
                            </div>
                            <?php
                        }

                        ?>
                        <!-- end card -->





                    </div>

                    <div class="col-xl-4">
                        <div class="mt-5 mt-lg-0">
                            <div class="card border shadow-none">
                                <div class="card-header bg-gray border-bottom py-3 px-4">
                                    <h5 class="font-size-16 mb-0">รายการสินค้า <span class="float-end"></span></h5>
                                </div>
                                <div class="card-body p-4 pt-2">

                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <tbody>
                                                <tr>
                                                    <td>สินค้าทั้งหมด :</td>
                                                    <td class="sumAllitemcart text-end">
                                                        <?= array_sum($_SESSION['cart']) ?>
                                                    </td>
                                                </tr>

                                                <tr class="bg-light">
                                                    <th>ยอดรวม :</th>
                                                    <td class="text-end">
                                                        <span class="sumAllmoney fw-bold">
                                                            <?= "฿" . $sumAllmoney ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- end table-responsive -->
                                </div>
                                <div class="card-footer bg-white">
                                    <div class="col-12">

                                        <div class="text-center mt-2 mt-sm-0">
                                            <!-- <a href="orderconfirm.php" class="btn btn-danger btn-block">
                                                <i class="mdi mdi-cart-outline me-1"></i> Checkout
                                            </a> -->
                                            <button onclick="checkNumberofProduct()" class="btn btn-danger btn-block maincolor">
                                                <i class="mdi mdi-cart-outline me-1"></i> Checkout
                                            </button>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            <?php } else {
            ?>
                <div class="container pt-5">
                    <div class="row">
                        <div class="col-12">
                            <div class="card text-center p-5">
                                <div class="card-body">

                                    <div class="align-items-center">
                                        <span class="cart-blank-icon"><img
                                                src="https://s2.konvy.com/static/img/order/cart-blank-icon.png"
                                                alt=""></span>

                                    </div>
                                    <h5 class="card-title m-2">ไม่มีรายการสินค้า</h5>
                                    <a href="index.php#product" class="btn btn-danger maincolor"><i class="bi bi-plus-circle"></i>
                                        เลือกสินค้าเพิ่ม</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <?php
        }
        ?>
        </div>
    </section>
    <div class="modal fade" id="ShowNumproduct" tabindex="-1" aria-labelledby="ShowNumproductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">
                <form class="" id="resetForm">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title text-white" id="ShowNumproductModalLabel">แจ้งเตือน จำนวนสินค้าไม่เพียงพอ</h5>
                   </div>
                    <div class="modal-body">
                        <table class="table table-bordered" id="showResultnumproduct">
                            <thead>
                                <tr>
                                    <td class="bg-danger text-white">ชื่อสินค้า</td>
                                    <td class="bg-danger text-white">จำนวนที่ได้</td>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <div class="alert alert-danger" style="display: none;" role="alert" >
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" onclick="confirm()">ตกลง</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <?php include("include/footer.php"); ?>

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <div id="preloader"></div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <?php include("include/script.php"); ?>
    <script>
        $('.minus-btn').on('click', function (e) { // ลบจำนวนสินค้า
            e.preventDefault();
            var $this = $(this);
            var $input = $this.closest('div').find('input');
            var $priceElement = $this.closest('.card-body').find('.product-price'); // เลือก element ที่แสดงราคาสินค้า
            var value = parseInt($input.val());

            if (value > 1) {
                value = value - 1;
            } else {
                value = 1;
            }

            $input.val(value);
            updateProductTotal($input, $priceElement); // อัพเดตราคารวมสินค้า

        });

        $('.plus-btn').on('click', function (e) { // เพิ่มจำนวนสินค้า
            e.preventDefault();
            var $this = $(this);
            var $input = $this.closest('div').find('input');
            var $priceElement = $this.closest('.card-body').find('.product-price'); // เลือก element ที่แสดงราคาสินค้า
            var value = parseInt($input.val());
            value = value + 1;
            $input.val(value);

            updateProductTotal($input, $priceElement); // อัพเดตราคารวมสินค้า

        });

        function updateProductTotal($input, $priceElement) {
            var quantity = parseInt($input.val());
            var pricePerUnit = parseFloat($priceElement.data('price')); // ราคาต่อหน่วยของสินค้า
            var totalPrice = quantity * pricePerUnit; // คำนวณราคารวมสินค้า
            $priceElement.text('฿' + totalPrice.toFixed(2)); // แสดงราคารวมสินค้า
            updateSession($input); // อัพเดต session
            updateTotalSum();
        }

        function updateSession($input) {
            var productId = $input.closest('.card-body').data('product-id');
            console.log(productId)
            var quantity = $input.val();

            $.ajax({
                type: 'POST',
                url: 'services/addToCart.php?v=updatecart', // ตั้งค่า URL ของไฟล์ PHP ที่จะอัพเดต session
                data: {
                    productId: productId,
                    quantity: quantity
                },
                success: function (response) {
                    updateCartCount();
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function updateCartCount() {
            $.ajax({
                type: 'GET',
                url: 'services/getCartCount.php',
                success: function (response) {
                    console.log(response)
                    $('.count').text(response);
                    $('.sumAllitemcart').text(response);

                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        $('.delete-product').on('click', function (e) {
            e.preventDefault();
            var $this = $(this);
            var $cardBody = $this.closest('.card-body');
            var productId = $cardBody.data('product-id');

            // ลบสินค้าออกจาก session โดยส่ง productId ไปยังไฟล์ PHP ที่จะดำเนินการลบข้อมูล
            $.ajax({
                type: 'POST',
                url: 'services/addToCart.php?v=removecartByid', // ตั้งค่า URL ของไฟล์ PHP ที่จะลบสินค้า
                data: {
                    productId: productId
                },
                success: function (response) {
                    // หลังจากลบสำเร็จ ให้ลบ card ที่มีข้อมูลสินค้าที่ถูกลบออกจาก DOM
                    $cardBody.closest('.card').remove();
                    // อัพเดตราคารวมสินค้าและจำนวนสินค้าในตะกร้า
                    updateTotalSum();
                    updateCartCount();
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        function updateTotalSum() {
            var totalSum = 0;
            $('.product-price').each(function () {
                var price = parseFloat($(this).text().replace('฿', '').replace(',', ''));
                totalSum += price;
            });
            $('.sumAllmoney').text('฿' + totalSum.toFixed(2));
        }

        function checkNumberofProduct() {
            $.ajax({
                type: 'POST',
                url: "services/cart/order.php?v=checkNumberofProduct",
                success: function (response) {
                    console.log(response)
                    if (response.length > 0) {
                        console.log(response)
                        $('#ShowNumproduct').modal('show');
                        //showResultnumproduct
                        $('#showResultnumproduct tbody').html('')
                        $.each(response, function (key, value) {
                            $('#showResultnumproduct tbody').append('<tr>'+
                            '<td>'+value.product_name+'</td>'+
                            '<td>'+value.remain_num+' ชิ้น </td>'+
                            '</tr>')
                        });
                    }
                    else{
                        window.location.href="orderconfirm.php"
                    }
                }
            });

        }
        function confirm(){
            window.location.href="cart.php"
        }
    </script>
</body>

</html>