<?php
include('../Connect_Data.php');

$connect = new Connect_Data();
$connect->connectData();

$order = new Connect_Data();
$order->connectData();

$orderdetail = new Connect_Data();
$orderdetail->connectData();

$daterang = explode(" - ", $_GET['reportrange']);
$start = explode("/", $daterang[0]);
$end = explode("/", $daterang[1]);

$startdate = $start[2] . "-" . $start[1] . "-" . $start[0];
$enddate = $end[2] . "-" . $end[1] . "-" . $end[0];
//echo $startdate;
$DateDiff = (strtotime($enddate) - strtotime($startdate)) /  (60 * 60 * 24);
$sort = $_GET['sort'];
$sumqtyAll = 0;
$sumpriceAll = 0;
for ($i = 0; $i <= $DateDiff; $i++) {
    $datesearch = date('Y-m-d', strtotime($startdate . "+$i days"));

    $order->sql = "SELECT	orders.order_id 
    FROM	orders 
    WHERE	order_status > 0 AND  order_status!=5	AND DATE(order_date)= '" . $datesearch . "'";

    $order->queryData();
    $row = $order->num_rows();
    if ($row > 0) {
        $sumorderorder_qty = [];
        $sumordesumprice = [];
        while ($rsorder = $order->fetch_AssocData()) {
            $order_id = $rsorder['order_id'];
            $orderdetail->sql = "SELECT
            sum( orders_detail.order_qty * orders_detail.product_price ) AS sumprice, 
            sum(order_qty) as order_qty, 
            orders_detail.product_id
                FROM orders_detail
                INNER JOIN product ON orders_detail.product_id = product.product_id
                INNER JOIN productgroup ON product.progroup_id = productgroup.progroup_id 
                WHERE order_id = '" . $order_id . "' 
                GROUP BY orders_detail.product_id";
            $orderdetail->queryData();
            while ($rsorderdetail = $orderdetail->fetch_AssocData()) {
                if (isset($rsorderdetail['product_id'])) {
                    if (!isset($sumorderorder_qty[$rsorderdetail['product_id']])) {
                        $sumorderorder_qty[$rsorderdetail['product_id']] = 0;
                        $sumordesumprice[$rsorderdetail['product_id']] = 0;
                    }
                    $sumordesumprice[$rsorderdetail['product_id']] += $rsorderdetail['sumprice'];
                    $sumorderorder_qty[$rsorderdetail['product_id']] += $rsorderdetail['order_qty'];
                }
            }
        }

        if ($sort == "ยอดขายสินค้า (สูงสุด)") {
            //ยอดขาย
            $numberprice = max($sumordesumprice);
            $product = array_search($numberprice, $sumordesumprice);
            $numberqty = $sumorderorder_qty[$product];
            
        } else if ($sort == "ยอดขายสินค้า (ต่ำสุด)") {
            //ยอดขาย
            $numberprice = min($sumordesumprice);
            $product = array_search($numberprice, $sumordesumprice);
            $numberqty = $sumorderorder_qty[$product];
        }
        else if ($sort == "จำนวนที่ขายได้ (สูงสุด)") {
            //จำนวนที่ขายได้
            $numberqty = max($sumorderorder_qty);
            $product = array_search($numberqty, $sumorderorder_qty);
            $numberprice=$sumordesumprice[$product];
        }
        else if ($sort == "จำนวนที่ขายได้ (ต่ำสุด)") {
            //จำนวนที่ขายได้
            $numberqty = min($sumorderorder_qty);
            $product = array_search($numberqty, $sumorderorder_qty);
            $numberprice=$sumordesumprice[$product];
        }

        $sumqtyAll +=$numberqty;
        $sumpriceAll +=$numberprice;

        $connect->sql = "SELECT
        product_name,
        progroup_name 
        FROM
        product
        INNER JOIN productgroup ON product.progroup_id = productgroup.progroup_id
        WHERE	product_id = '" . $product . "'";

        $connect->queryData();
        $rsconnect = $connect->fetch_AssocData();
        echo '<tr>
            <td class="text-end">' . date('d/m/Y', strtotime($datesearch)) . '</td>
            <td class="text-end">' . $rsconnect['progroup_name'] . '</td>
            <td class="text-end">' . $rsconnect['product_name'] . '  </td>
            <td class="text-end">' . $numberqty. ' ชิ้น</td>
            
            <td class="text-end">฿'.number_format($numberprice,2).'</td>
            </tr>';
    } else {
        echo '<tr>
            <td class="text-end">' . date('d/m/Y', strtotime($datesearch)) . '</td>
            <td class="text-end">-</td>
            <td class="text-end">-</td>
            <td class="text-end">-</td>
            
            <td class="text-end">-</td>
            </tr>';
    }
}
echo '<tr>
<td class="text-end" colspan="3">รวม</td>
<td class="text-end">'.$sumqtyAll.' ชิ้น</td>
<td class="text-end">฿'.number_format($sumpriceAll,2).'</td>
</tr>';