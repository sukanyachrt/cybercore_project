<?php
include('../Connect_Data.php');
error_reporting(0);
$connect = new Connect_Data();
$connect->connectData();

$order = new Connect_Data();
$order->connectData();

$orderdetail = new Connect_Data();
$orderdetail->connectData();


$connect->sql = "SELECT YEAR
( orders.order_date ) AS yearorder 
FROM orders WHERE
order_status > 0 GROUP BY
YEAR (orders.order_date)";
$connect->queryData();
$sumorderAll=0;
while ($rsconnect = $connect->fetch_AssocData()) {
    $yearorder = $rsconnect['yearorder'];
    $order->sql = "SELECT	orders.order_id 
                    FROM	orders 
                    WHERE	order_status > 0 AND  order_status!=5	AND YEAR ( order_date )= '".$yearorder."'";
    $order->queryData();
    $sumorder=0;
    while ($rsorder = $order->fetch_AssocData()) {
        $order_id=$rsorder['order_id'];
        $orderdetail->sql = "SELECT  sum(orders_detail.order_qty * 	orders_detail.product_price) as sumprice  	FROM 	orders_detail  WHERE order_id ='" . $order_id . "'";
        $orderdetail->queryData();
        $rsorderdetail = $orderdetail->fetch_AssocData();
        $sumorder += $rsorderdetail['sumprice'];
        $sumorderAll+= $rsorderdetail['sumprice'];
    }

    echo '<tr>
    <td class="text-center">' . $yearorder . '</td>
    <td class="text-end">' . number_format($sumorder,2). '</td>
    </tr>';
}
echo '<tr>
<td class="text-center"><b>รวมทั้งหมด</b></td>
<td class="text-end"><b>' . number_format($sumorderAll,2). '</b></td>
</tr>';