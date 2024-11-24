<?php
include('../Connect_Data.php');

$connect = new Connect_Data();
$connect->connectData();

$order = new Connect_Data();
$order->connectData();

$orderdetail = new Connect_Data();
$orderdetail->connectData();

$start = explode("/", $_GET['start']);
$end = explode("/", $_GET['end']);
$startdate = $start[2] . "-" . $start[1] . "-" . $start[0];
$enddate = $end[2] . "-" . $end[1] . "-" . $end[0];

$DateDiff = (strtotime($enddate) - strtotime($startdate)) /  (60 * 60 * 24);

$sumorderAll=0;
for ($i = 0; $i <= $DateDiff; $i++) {
    $datesearch = date('Y-m-d', strtotime($startdate . "+$i days"));
    $order->sql = "SELECT	orders.order_id 
                    FROM	orders 
                    WHERE	order_status > 0 AND  order_status!=5 	AND DATE(order_date)= '" . $datesearch . "'";

    $order->queryData();
    $row = $order->num_rows();
    if ($row > 0) {
        $sumorder=0;
        while ($rsorder = $order->fetch_AssocData()) {
            $order_id = $rsorder['order_id'];
            $orderdetail->sql = "SELECT  sum(orders_detail.order_qty * 	orders_detail.product_price) as sumprice  	FROM 	orders_detail  WHERE order_id ='" . $order_id . "'";
            $orderdetail->queryData();
           
            while($rsorderdetail = $orderdetail->fetch_AssocData()){
                $sumorder += $rsorderdetail['sumprice'];
                $sumorderAll+= $rsorderdetail['sumprice'];
            }
          
        }
        echo '<tr>
        <td class="text-end">' . date('d/m/Y',strtotime($datesearch)) . '</td>
        <td class="text-end">' . number_format($sumorder, 2) . '</td>
        </tr>';
       
       
    } else {
        echo '<tr>
        <td class="text-end">' . date('d/m/Y',strtotime($datesearch)) . '</td>
        <td class="text-end">-</td>
        </tr>';
    }
}
echo '<tr>
<td class="text-end"><b>รวมทั้งหมด</b></td>
<td class="text-end"><b>' . number_format($sumorderAll,2). '</b></td>
</tr>';