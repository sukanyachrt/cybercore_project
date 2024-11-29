<?php
include('../Connect_Data.php');
error_reporting(0);
$connect = new Connect_Data();
$connect->connectData();
$connect->sql = "SELECT
producttype.protype_id,
producttype.protype_name,
product.product_name,
product.product_detail,
product.product_id,
product.product_price,
product.product_num,
product.product_status,
product.product_image 
FROM
product
INNER JOIN producttype ON product.protype_id = producttype.protype_id";
$connect->queryData();
while ($rsconnect = $connect->fetch_AssocData()) {
    if ($rsconnect['product_id'] <= 9) {
        $product_id = "0000" . $rsconnect['product_id'];
    } else if ($rsconnect['product_id'] >= 10 && $rsconnect['product_id'] <= 99) {
        $product_id = "000" . $rsconnect['product_id'];
    } else if ($rsconnect['product_id'] >= 100 && $rsconnect['product_id'] <= 999) {
        $product_id = "00" . $rsconnect['product_id'];
    } else if ($rsconnect['product_id'] >= 1000 && $rsconnect['product_id'] <= 9999) {
        $product_id = "0" . $rsconnect['product_id'];
    } else {
        $product_id = $rsconnect['product_id'];
    }

    if ($rsconnect['product_status'] == 1) {
        $product_status = '<span class="badge bg-label-success">ใช้งาน</span>';
    } else {
        $product_status = '<span class="badge bg-label-danger">ไม่ใช้งาน</span>';
    }
    echo '<tr>
    <td class="text-center">' . $product_id . '</td>
    <td class="text-left">' . $rsconnect['product_name'] . '</td>
    <td class="text-center">' . "฿" .$rsconnect['product_price'] . '</td>
    <td class="text-center">' . $rsconnect['product_num'] . '</td>
    <td class="text-center">' . $rsconnect['protype_name'] . '</td>
   
    <td class="text-center">
        <a  href="data.php?id='.$rsconnect['product_id'].'"><button class="border-warning text-warning"><i class="bx bx-edit-alt me-1"></i></button></a>
        <button class="border-danger text-danger"  onclick="updateEmployStatus('.$rsconnect['product_id'].')"><i class="bx bx-trash me-1"></i></button>
    </td>
    </tr>';
}
