<?php
include('../Connect_Data.php');
error_reporting(0);
$connect = new Connect_Data();
$connect->connectData();

$order = new Connect_Data();
$order->connectData();

$orderdetail = new Connect_Data();
$orderdetail->connectData();

$yearorder = $_GET['year'];
$connect->sql = "SELECT MONTH
( orders.order_date ) AS monthorder 
FROM orders WHERE
order_status > 0 AND YEAR (orders.order_date)='" . $yearorder . "' GROUP BY
YEAR (orders.order_date),MONTH (orders.order_date)";
$connect->queryData();
$sumorderAll = 0;
while ($rsconnect = $connect->fetch_AssocData()) {
    $monthorder = $rsconnect['monthorder'];
    $order->sql = "SELECT	orders.order_id 
                    FROM	orders 
                    WHERE	order_status > 0 AND  order_status!=5 	AND MONTH ( order_date )= '" . $monthorder . "'
                    AND YEAR  ( order_date )= '" . $yearorder . "'";
    $order->queryData();
    $sumorder = 0;
    while ($rsorder = $order->fetch_AssocData()) {
        $order_id = $rsorder['order_id'];
        $orderdetail->sql = "SELECT  sum(orders_detail.order_qty * 	orders_detail.product_price) as sumprice  	FROM 	orders_detail  WHERE order_id ='" . $order_id . "'";
        $orderdetail->queryData();
        $rsorderdetail = $orderdetail->fetch_AssocData();
        $sumorder += $rsorderdetail['sumprice'];
        $sumorderAll += $rsorderdetail['sumprice'];
    }
    $monthNameThai = date("F", mktime(0, 0, 0, $monthorder, 1, date("Y"))); // แปลงเลขเดือนเป็นชื่อของเดือนในภาษาอังกฤษ
    $monthNameThai = str_replace(
        ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
        ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"],
        $monthNameThai
    );

    echo '<tr>
    <td class="text-center">' . $yearorder . '</td>
    <td class="text-center">' . $monthNameThai . '</td>
    <td class="text-end">' . number_format($sumorder, 2) . '</td>
    </tr>';
}
echo '<tr>
<td class="text-end" colspan="2"><b>รวมทั้งหมด</b></td>
<td class="text-end"><b>' . number_format($sumorderAll, 2) . '</b></td>
</tr>';
