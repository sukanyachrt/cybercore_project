
<?php
require_once("../../services/connect_data.php");
$order = new Connect_Data();
$order->connectData();

date_default_timezone_set('Asia/Bangkok');
$order = new Connect_Data();
$order->connectData();

$connect = new Connect_Data();
$connect->connectData();

$order->sql = "SELECT *  	FROM 	orders  WHERE  order_status=1";
$order->queryData();
$noid = 1;
$row = $order->num_rows();
if ($row == 0) {

}
while ($rsorder = $order->fetch_AssocData()) {

  $timestamp = strtotime($rsorder['order_date']);
  $new_timestamp = $timestamp + (24 * 3600);
  $new_date = date("Y-m-d H:i:s", $new_timestamp);
  if (time() > $new_timestamp) {
    $connect->sql = "UPDATE 	orders SET order_status=5,order_details='หมดเวลาในการชำระเงิน'  WHERE order_id ='" . $rsorder['order_id'] . "'";
    $connect->queryData();
  } else {
    echo date('d/m/Y H:i:s', strtotime($new_date));
  }
}
?>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bold ms-0 text-primary">CyberCore </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        <!-- Components -->
        
        <li class="menu-header small text-uppercase"><span class="menu-header-text">เมนู Admin</span></li>
        <li class="menu-item" data-menu="Order">
            <a href="../order/index.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-list-ul"></i>
                <div data-i18n="Basic">รายการสั่งซื้อทั้งหมด</div>

            </a>
        </li>
        <li class="menu-item" data-menu="Payment">
            <a href="../payment/index.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-credit-card"></i>
                <div data-i18n="Basic">ข้อมูลการชำระเงิน</div>
                <?php
                $order->sql = "SELECT
                                            count( * ) AS numberorder 
                                            FROM   orders WHERE order_status='2'";
                $order->queryData();
                $rsorder = $order->fetch_AssocData();
                
                if($rsorder['numberorder']>0){
                    ?>
                    <div class="badge bg-danger rounded-pill ms-auto"><?=$rsorder['numberorder']?></div>
                    <?php
                }
                ?>

                

            </a>
        </li>
        <li class="menu-item" data-menu="general">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-grid"></i>
                <div data-i18n="User interface">จัดการข้อมูลทั่วไป</div>
            </a>
            <ul class="menu-sub">
            <li class="menu-item" data-submenu="product">
                    <a href="../product/index.php" class="menu-link">
                        <div data-i18n="Alerts">ข้อมูลสินค้า</div>
                    </a>
                </li>
                <li class="menu-item" data-submenu="producttype">
                    <a href="../producttype/index.php" class="menu-link">
                        <div data-i18n="Badges">ข้อมูลประเภทสินค้า</div>
                    </a>
                </li>
                <li class="menu-item" data-submenu="productpromotion">
                    <a href="../productpromotion/index.php" class="menu-link">
                        <div data-i18n="Badges">โปรโมชั่นสินค้า</div>
                    </a>
                </li>
                <li class="menu-item " data-submenu="customer">
                    <a href="../customer/index.php" class="menu-link">
                        <div data-i18n="Alerts">ข้อมูลลูกค้า</div>
                    </a>
                </li>
                <li class="menu-item " data-submenu="employee">
                    <a href="../employee/index.php" class="menu-link">
                        <div data-i18n="Alerts">ข้อมูลผู้ดูแลระบบ</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item" data-menu="report">
            <a href="../report/index.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Basic">รายงานต่างๆ</div>

            </a>
        </li>

    </ul>
</aside>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function handleMenuItemClick(clickedItem) {
            document.querySelectorAll('.menu-item').forEach(function(item) {
                if (item.classList.contains('menu-item')) {
                    item.classList.remove('active');
                }
            });

            clickedItem.classList.add('active');
            sessionStorage.setItem('menu', clickedItem.getAttribute('data-menu'));
        }

        document.querySelectorAll('.menu-item').forEach(function(item) {
            item.addEventListener('click', function() {
                handleMenuItemClick(item);
            });
        });

        var storedMenu = sessionStorage.getItem('menu');
        if (storedMenu) {
            document.querySelectorAll('.menu-item').forEach(function(item) {
                if (item.getAttribute('data-menu') === storedMenu) {
                    handleMenuItemClick(item);
                    var reportsellMenuItem = document.querySelector('[data-menu="' + storedMenu + '"]');
                    reportsellMenuItem.classList.add('open');
                }
            });
        }


        var storedMenusub = sessionStorage.getItem('submenu');
        if (storedMenusub) {
            var reportsellMenuItem = document.querySelector('[data-submenu="' + storedMenusub + '"]');
            if (reportsellMenuItem) {
                reportsellMenuItem.classList.add('active');
            }
        }


        $('[data-submenu]').on('click', function() {
            var submenuValue = $(this).attr('data-submenu');
            sessionStorage.setItem('submenu', submenuValue);

        });
    });
</script>