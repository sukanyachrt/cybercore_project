<title>รายงานสินค้าขายดี</title>
<?php
include("../../services/connect_data.php");
require_once __DIR__ . '/vendor/autoload.php'; // เรียกใช้ mPDF
error_reporting(0);

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
$DateDiff = (strtotime($enddate) - strtotime($startdate)) / (60 * 60 * 24);
$sort = $_GET['sort'];
$sumqtyAll = 0;
$sumpriceAll = 0;

$mpdf = new \Mpdf\Mpdf(); // สร้างอ็อบเจ็กต์ mPDF
$mpdf->SetDefaultFont('freeserif');
// HTML ที่คุณต้องการแปลงเป็น PDF
$html = '
    <html>
    <head>
        <title>รายงานสินค้าขายดี</title>
        <style>
        body {
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th {
            background-color: #000000;
            color: #fff;
            border: 1px solid #ddd;
            padding: 8px;
        }
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
            padding: 8px;
        }
        td:not(tbody td) {
            background-color: #000000;
            color: #fff;
        }
        
        
    </style>
    </head>
    <body>
    <div class="text-center mt-4" style="font-size:16px;">ร้าน CyberCore.</div>
    <div class="text-center mb-3" style="font-size:16px; margin-bottom:15px">รายงานสินค้าขายดี</div>
    <table class="table">
        <thead>
            <tr>
                <th class="text-center" width="10%">วันที่</th>
                <th class="text-end" width="25%">ประเภทสินค้า</th>
                <th class="text-end" width="35%">ชื่อสินค้า</th>
                <th class="text-end" width="10%">จำนวน</th>
                <th class="text-end" width="20%">ยอดขาย</th>
            </tr>
        </thead>
        <tbody id="tbreportsell_year">';
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
                        INNER JOIN producttype ON product.protype_id = producttype.protype_id 
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
        } else if ($sort == "จำนวนที่ขายได้ (สูงสุด)") {
            //จำนวนที่ขายได้
            $numberqty = max($sumorderorder_qty);
            $product = array_search($numberqty, $sumorderorder_qty);
            $numberprice = $sumordesumprice[$product];
        } else if ($sort == "จำนวนที่ขายได้ (ต่ำสุด)") {
            //จำนวนที่ขายได้
            $numberqty = min($sumorderorder_qty);
            $product = array_search($numberqty, $sumorderorder_qty);
            $numberprice = $sumordesumprice[$product];
        }

        $sumqtyAll += $numberqty;
        $sumpriceAll += $numberprice;

        $connect->sql = "SELECT
                product_name,
                protype_name 
                FROM
                product
                INNER JOIN producttype ON product.protype_id = producttype.protype_id
                WHERE	product_id = '" . $product . "'";

        $connect->queryData();
        $rsconnect = $connect->fetch_AssocData();
        $html .= '<tr>
                    <td class="text-end">' . date('d/m/Y', strtotime($datesearch)) . '</td>
                    <td class="text-end">' . $rsconnect['protype_name'] . '</td>
                    <td class="text-end">' . $rsconnect['product_name'] . '  </td>
                    <td class="text-end">' . $numberqty . ' ชิ้น</td>
                    
                    <td class="text-end">฿' . number_format($numberprice, 2) . '</td>
                    </tr>';
    } else {
        $html .= '<tr>
                    <td class="text-end">' . date('d/m/Y', strtotime($datesearch)) . '</td>
                    <td class="text-end">-</td>
                    <td class="text-end">-</td>
                    <td class="text-end">-</td>
                    
                    <td class="text-end">-</td>
                    </tr>';
    }
}
$html .= '<tr>
        <td class="text-end" colspan="3">รวม</td>
        <td class="text-end">' . $sumqtyAll . ' ชิ้น</td>
        <td class="text-end">฿' . number_format($sumpriceAll, 2) . '</td>
        </tr>';
$html .= '</tbody>
    </table>
    </body>
    </html>
';

// เพิ่ม HTML เข้าไปใน mPDF
$mpdf->WriteHTML($html);

// สร้างเอกสาร PDF
$mpdf->Output('output.pdf', \Mpdf\Output\Destination::INLINE);
