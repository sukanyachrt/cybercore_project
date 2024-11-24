<?php
include('../Connect_Data.php');
error_reporting(0);
$order = new Connect_Data();
$order->connectData();
$orderdetail = new Connect_Data();
$orderdetail->connectData();
$order->sql = "SELECT
orders.order_id,
orders.customer_id,
orders.order_date,
orders.order_status,
customers.customer_fname,
customers.customer_lname 
FROM
orders
INNER JOIN
customers ON orders.customer_id = customers.customer_id
WHERE
1=1
AND ('".$_GET['status']."' = 'all' OR orders.order_status='".$_GET['status']."')
ORDER BY
ABS(order_status) ASC
";
$order->queryData();
$noid = 1;
$row = $order->num_rows();
if ($row == 0) {
?>
    <tr>
        <td colspan="6" class="text-center">
            <div class="card m-5">
                ยังไม่มีรายการสั่งซื้อ
            </div>
        </td>
    </tr>
<?php
}
while ($rsorder = $order->fetch_AssocData()) {
    $sumprice = 0;
    if ($rsorder['order_id'] <= 9) {
        $order_id = "0000" . $rsorder['order_id'];
    } else if ($rsorder['order_id'] >= 10 && $rsorder['order_id'] <= 99) {
        $order_id = "000" . $rsorder['order_id'];
    } else if ($rsorder['order_id'] >= 100 && $rsorder['order_id'] <= 999) {
        $order_id = "00" . $rsorder['order_id'];
    } else if ($rsorder['order_id'] >= 1000 && $rsorder['order_id'] <= 9999) {
        $order_id = "0" . $rsorder['order_id'];
    } else {
        $order_id = $rsorder['order_id'];
    }

    if ($rsorder['customer_id'] <= 9) {
        $customer_id = "0000" . $rsorder['customer_id'];
    } else if ($rsorder['customer_id'] >= 10 && $rsorder['customer_id'] <= 99) {
        $customer_id = "000" . $rsorder['customer_id'];
    } else if ($rsorder['customer_id'] >= 100 && $rsorder['customer_id'] <= 999) {
        $customer_id = "00" . $rsorder['customer_id'];
    } else if ($rsorder['customer_id'] >= 1000 && $rsorder['customer_id'] <= 9999) {
        $customer_id = "0" . $rsorder['customer_id'];
    } else {
        $customer_id = $rsorder['customer_id'];
    }

    //หายอดสินค้ารวม
    $orderdetail->sql = "SELECT  sum(orders_detail.order_qty * 	orders_detail.product_price) as sumprice  	FROM 	orders_detail  WHERE order_id ='" . $rsorder['order_id'] . "'";
    $orderdetail->queryData();
    $rsorderdetail = $orderdetail->fetch_AssocData();
    $sumprice = $rsorderdetail['sumprice'];
?>
    <tr>
        <td class="text-center"><?= $order_id ?></td>
        <td class="text-left"><?= $rsorder['customer_fname']." ".$rsorder['customer_lname'] ?></td>
        <td class="text-center"><?= date('d/m/Y', strtotime($rsorder['order_date'])) ?></td>
        <td class="text-center"><?= "฿" . number_format($sumprice, 2) ?></td>
        <td class="text-center status">
            <?php
            if ($rsorder['order_status'] == 1) {
                echo '<span class="badge rounded-pill bg-danger">รอชำระเงิน</span>';
            } else if ($rsorder['order_status'] == 2) {
                echo '<span class="badge rounded-pill bg-warning">รอยืนยันการชำระเงิน</span>';
            } else if ($rsorder['order_status'] == 3) {
                echo '<span class="badge rounded-pill bg-info">รอจัดส่ง</span>';
            } else if ($rsorder['order_status'] == 4) {
                echo '<span class="badge rounded-pill bg-success">จัดส่งเรียบร้อยแล้ว</span>';
            }
            else if ($rsorder['order_status'] == 0) {
                echo '<span class="badge rounded-pill bg-dark">ข้อมูลการชำระเงินไม่ถูกต้อง</span>';
            }
            else if ($rsorder['order_status'] == 5) {
                echo '<span class="badge rounded-pill bg-dark">ยกเลิกออเดอร์</span>';
            }
            ?>
        </td>
        <td class="text-center">

            <a href="detailpayment.php?id=<?php echo $rsorder['order_id'] ?>" type="button" class="btn btn-outline-danger btn-sm"><i class='bx bxs-edit'></i></a>
        </td>
    </tr>
<?php
}
?>
