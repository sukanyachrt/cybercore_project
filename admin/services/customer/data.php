<?php
header('Content-Type: application/json');
include('../Connect_Data.php');
session_start();
$connect = new Connect_Data();
$connect->connectData();
$data = isset($_GET['v']) ? $_GET['v'] : '';
$result = array();
if ($data == "customerStatus") {
    $connect->sql = "UPDATE customers SET c_status = '0' 
     WHERE customer_id='" . $_GET['id'] . "'";
    $connect->queryData();
    echo json_encode(["result" => $connect->affected_rows()]);
} else if ($data == "updateCustomerAll") {
    $post = $_POST;
    $connect->sql = "UPDATE `customers` SET 
    `customer_fname`='" . $post['customer_fname'] . "',
    `customer_lname`='" . $post['customer_lname'] . "',
    `customer_telephone`='" . $post['customer_telephone'] . "',
    `c_address`='" . $post['c_address'] . "',
    `c_email`='" . $post['c_email'] . "',
    `c_password`='" . $post['c_password'] . "',
    `customer_username`='" . $post['customer_username'] . "',
    `c_status`='" . $post['c_status'] . "'
    WHERE customer_id='" . $_GET['id'] . "'";
    $connect->queryData();

    echo json_encode(["result" => $connect->affected_rows()]);
} else if ($data == "insertcustomer") {
    $post = $_POST;

    $connect->sql = "INSERT INTO `customers`  VALUES 
    (null,
    '" . $post['customer_fname'] . "',
    '" . $post['customer_lname'] . "',
    '" . $post['customer_telephone'] . "',
    '" . $post['c_address'] . "',
    '" . $post['c_email'] . "',
    '" . $post['c_password'] . "',
    '" . $post['customer_username'] . "',
    '" . $post['c_status'] . "'
)";
    $connect->queryData();




    echo json_encode(["result" => $connect->affected_rows()]);
} else if ($data == "dataCustomerByID") {
    $connect->sql = "SELECT    *     FROM     customers 
    WHERE customer_id='" . $_GET['id'] . "'";
    $connect->queryData();
    $row = $connect->num_rows();
    if ($row > 0) {
        $rsconnect = $connect->fetch_AssocData();
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

        $rsconnect['customer_id'] = $cus_id;
        array_push($result, ["status" => "ok", "data" => $rsconnect]);
    } else {
        array_push($result, ["status" => "no"]);
    }

    echo json_encode($result[0]);
} else if ($data == "maxIdCustomer") {
    $connect->sql = "SELECT	MAX( customer_id  ) AS maxid FROM	customers";
    $connect->queryData();
    $rsconnect = $connect->fetch_AssocData();

    $customer_id = $rsconnect['maxid']+1;
    if ($customer_id <= 9) {
        $maxid = "0000" . $customer_id;
    } else if ($customer_id >= 10 && $customer_id <= 99) {
        $maxid = "000" . $customer_id;
    } else if ($customer_id >= 100 && $customer_id <= 999) {
        $maxid = "00" . $customer_id;
    } else if ($customer_id >= 1000 && $customer_id <= 9999) {
        $maxid = "0" . $customer_id;
    } else {
        $maxid = $customer_id;
    }
    $result = ["maxid" => $maxid];

    echo json_encode($result);
}
