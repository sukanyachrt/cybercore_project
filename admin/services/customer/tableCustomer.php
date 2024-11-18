<?php
include('../connect_data.php');
session_start();
$connect = new Connect_Data();
$connect->connectData();

$order = new Connect_Data();
$order->connectData();

$connect->sql = "SELECT * FROM customers";
$connect->queryData();
while ($rsconnect = $connect->fetch_AssocData()) {
    if ($rsconnect['c_status'] == 1) {
        $c_status = '<span class="badge bg-label-success">ยังคงเป็นสมาชิก</span>';
    } else {
        $c_status = '<span class="badge bg-label-danger">ยกเลิกการเป็นสมาชิก</span>';
    }

    $customer_id = $rsconnect['customer_id'];
    if ($customer_id <= 9) {
        $cus_id = "0000" . $customer_id;
    } else if ($customer_id >= 10 && $customer_id <= 99) {
        $cus_id = "000" . $customer_id;
    } else if ($customer_id >= 100 && $customer_id <= 999) {
        $cus_id = "00" . $customer_id;
    } else if ($customer_id >= 1000 && $customer_id <= 9999) {
        $cus_id = "0" . $customer_id;
    } else {
        $cus_id = $customer_id;
    }


    // จำนวนออเดอร์ที่ลูกค้าสั่ง
    // $order->sql = "SELECT	COUNT(*) as numOrder FROM	orders WHERE customer_id='".$customer_id."'	GROUP BY customer_id";
    // $order->queryData();
    // $row = $order->num_rows();
    // $numorder="";
    // if ($row > 0) {
    //     $rsorder = $order->fetch_AssocData();
    //     $numorder=$rsorder['numOrder'];
    // }
   



    echo '<tr>
    <td class="text-center">' . $cus_id . '</td>
    <td class="text-center">' . $rsconnect['customer_fname'] . ' ' . $rsconnect['customer_lname'] . '</td>
    <td class="text-center">' . $rsconnect['c_address'] . '</td>
    <td class="text-center">' . $rsconnect['customer_telephone'] . '</td>
    <td class="text-center">' . $c_status . '</td>
    <td class="text-center">
        <a  href="data.php?id='.$rsconnect['customer_id'].'"><button class="border-warning text-warning"><i class="bx bxs-grid"></i></button></a>
        <button class="border-danger text-danger"  onclick="updateCustomerStatus('.$rsconnect['customer_id'].')"><i class="bx bx-trash me-1"></i></button>
    </td>
    </tr>';
}
