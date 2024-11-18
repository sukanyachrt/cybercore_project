<?php
header('Content-Type: application/json');
include('../connect_data.php');
error_reporting(0);
session_start();
$connect = new Connect_Data();
$connect->connectData();
$data = isset($_GET['v']) ? $_GET['v'] : '';
$result = array();
if ($data == "checkauth") {

    $username = $_POST["Username"];
    $password = $_POST["Password"];
    $connect->sql = "SELECT * FROM	customers
	WHERE	(c_email ='" . $username . "' OR customer_username='" . $username . "') AND c_status=1";
    $connect->queryData();
    $row = $connect->num_rows();
    if ($row > 0) {
        $rsconnect = $connect->fetch_AssocData();
        if ($rsconnect['c_password'] == $password) {
            $result = [
                'status' => "ok",
                'data' => $rsconnect
            ];
        } else {
            $result = [
                'status' => "no",
                'msg' => "password ไม่ถูกต้องครับ"
            ];
        }
    } else {
        $result = [
            'status' => "no",
            'msg' => "ไม่พบรหัสผู้ใช้งาน"
        ];
    }

    echo json_encode($result);
} else if ($data == "createCustomer") {
    $post = $_POST;
    // check Username และ email ห้ามซ้ำ
    $connect->sql = "SELECT * FROM	customers
	WHERE	c_email='" . $post['c_email'] . "' OR customer_username='" . $post['customer_username'] . "'";
    $connect->queryData();
    $row = $connect->num_rows();
    if ($row > 0) {
        echo json_encode(["status" => "no", "msg" => "ไม่สามารถลงทะเบียนเนื่องจากมี Username หรือ email นี้แล้วในระบบ"]);
    } else {
        $connect->sql = "INSERT INTO `customers` VALUES
            (null,'" . $post['customer_fname'] . "','" . $post['customer_lname'] . "','" . $post['customer_telephone'] . "','" . $post['c_address'] . "','" . $post['c_email'] . "','" . $post['c_password'] . "','" . $post['customer_username'] . "','1')";
        $connect->queryData();
        $customer_id = $connect->id_insertrows();
        if ($customer_id > 0) {
            $connect->sql = "SELECT * FROM	customers
           WHERE	customer_id='" . $customer_id . "'";
            $connect->queryData();
            $rsconnect = $connect->fetch_AssocData();
            echo json_encode(["status" => "ok", 'data' => $rsconnect]);
        } else {
            echo json_encode(["status" => "no", "msg" => "ไม่สามารถลงทะเบียนผู้ใช้ได้ค่ะ"]);
        }
    }
} else if ($data == "updateProfile") {
    $post = $_POST;
    $connect->sql = "UPDATE `customers` SET 
    `customer_fname`='" . $post['customer_fname'] . "',
    `customer_lname`='" . $post['customer_lname'] . "',
    `customer_telephone`='" . $post['customer_telephone'] . "',
    `c_address`='" . $post['c_address'] . "',
    `c_email`='" . $post['c_email'] . "',
    `c_password`='" . $post['c_password'] . "',
    `customer_username`='" . $post['customer_username'] . "'
     WHERE customer_id='" . $_SESSION['customer_id'] . "'";
    $connect->queryData();
    echo json_encode(["status" => "ok", 'data' => $post]);

} else if ($data == "resetpassword") {
    $username = $_POST["resetUsername"];
    $password = $_POST["ResetPassword"];
    $connect->sql = "SELECT * FROM	customers
	WHERE	(c_email ='" . $username . "' OR customer_username='" . $username . "') AND c_status=1";
    $connect->queryData();
    $row = $connect->num_rows();
    if ($row > 0) {
        $rsconnect = $connect->fetch_AssocData();
        $customer_id = $rsconnect['customer_id'];
        $connect->sql = "UPDATE customers  SET c_password='".$password."' WHERE customer_id='".$customer_id."'";
        $connect->queryData();
        echo json_encode(["status" => "ok", 'msg' => "Reset Password ให้เรียบร้อยแล้วค่ะ"]);
    }
    else{
        echo json_encode(["status" => "no", 'msg' => "Username หรือ Email ไม่ถูกต้องค่ะ !"]);
        
    }

    
}
