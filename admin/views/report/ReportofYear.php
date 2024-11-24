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
$mpdf = new \Mpdf\Mpdf(); // สร้างอ็อบเจ็กต์ mPDF
$mpdf->SetDefaultFont('freeserif');
// HTML ที่คุณต้องการแปลงเป็น PDF
$html = '
    <html>
    <head>
        <title>รายงานยอดขายสรุปรายปี</title>
       
        
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
    <div class="text-center mt-4" style="font-size:16px;">ร้าน CyberCore</div>
    <div class="text-center mb-3" style="font-size:16px; margin-bottom:15px">รายงานยอดขายสรุปรายปี</div>
    <table class="table">
        <thead>
            <tr>
                <th class="text-center" width="50%">ปี</th>
                <th class="text-end" width="50%">ยอดขาย</th>
            </tr>
        </thead>
        <tbody id="tbreportsell_year">';



$connect->sql = "SELECT YEAR
        ( orders.order_date ) AS yearorder 
        FROM orders WHERE
        order_status > 0 GROUP BY
        YEAR (orders.order_date)";
$connect->queryData();
$sumorderAll = 0;
while ($rsconnect = $connect->fetch_AssocData()) {
    $yearorder = $rsconnect['yearorder'];
    $order->sql = "SELECT	orders.order_id 
                    FROM	orders 
                    WHERE	order_status > 0 AND  order_status!=5	AND YEAR ( order_date )= '" . $yearorder . "'";
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

    $html .= '<tr>
    <td class="text-center">' . $yearorder . '</td>
    <td class="text-end">' . number_format($sumorder, 2) . '</td>
    </tr>';
}
$html .= '<tr>
<td class="text-center"><b>รวมทั้งหมด</b></td>
<td class="text-end"><b>' . number_format($sumorderAll, 2) . '</b></td>
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
