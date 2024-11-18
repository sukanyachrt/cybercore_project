<?php
header('Content-Type: application/json');
include('../Connect_Data.php');
//error_reporting(0);
$connect = new Connect_Data();
$connect->connectData();
$data = isset($_GET['v']) ? $_GET['v'] : '';
$result = array();

if ($data == "updateEmployStatus") {
    $connect->sql = "UPDATE salesperson SET Salesperson_status = '0' 
     WHERE Salesperson_Code='" . $_GET['id'] . "'";
    $connect->queryData();
    echo json_encode(["result" => $connect->affected_rows()]);
} else if ($data == "updateEmployAll") {
    
    $post = $_POST;
    $connect->sql = "UPDATE `employees` SET 
    `employee_fname`='" . $post['employee_fname'] . "',
    `employee_lname`='" . $post['employee_lname'] . "',
    `employee_username`='" . $post['employee_username'] . "',
    `employee_password`='" . $post['employee_password'] . "',
    `employee_status`='" . $post['employee_status'] . "'
    WHERE employee_id='" . $_GET['id'] . "'";
    $connect->queryData();

    echo json_encode(["result" => $connect->affected_rows()]);

} else if ($data == "insertemploy") {

    $post = $_POST;
    $connect->sql = "INSERT INTO `employees`  VALUES
     (null,
    '" . $post['employee_fname'] . "',
    '" . $post['employee_lname'] . "',
    '" . $post['employee_username'] . "',
    '" . $post['employee_password'] . "',
    '" . $post['employee_status'] . "')";
    $connect->queryData();
    echo json_encode(["result" => $connect->affected_rows()]);
} else if ($data == "dataEmployByID") {
    $connect->sql = "SELECT * FROM 	employees 
    WHERE employee_id='" . $_GET['id'] . "'";
    $connect->queryData();
    $row = $connect->num_rows();
    if ($row > 0) {
        $rsconnect = $connect->fetch_AssocData();
        $employee_id = $rsconnect['employee_id'];
        if ($employee_id <= 9) {
            $emp_id = "0000" . $employee_id;
        } else if ($employee_id >= 10 && $employee_id <= 99) {
            $emp_id = "000" . $employee_id;
        } else if ($employee_id >= 100 && $employee_id <= 999) {
            $emp_id = "00" . $employee_id;
        } else if ($employee_id >= 1000 && $employee_id <= 9999) {
            $emp_id = "0" . $employee_id;
        } else {
            $emp_id = $employee_id;
        }
        $rsconnect['employee_id'] = $emp_id;
        array_push($result, ["status" => "ok", "data" => $rsconnect]);
    } else {
        array_push($result, ["status" => "no"]);
    }

    echo json_encode($result[0]);
} else if ($data == "maxIdEmploy") {
    $connect->sql = "SELECT	MAX( employee_id ) AS maxid FROM	employees";
    $connect->queryData();
    $rsconnect = $connect->fetch_AssocData();

    $employee_id = $rsconnect['maxid'] + 1;
    if ($employee_id <= 9) {
        $maxid = "0000" . $employee_id;
    } else if ($employee_id >= 10 && $employee_id <= 99) {
        $maxid = "000" . $employee_id;
    } else if ($employee_id >= 100 && $employee_id <= 999) {
        $maxid = "00" . $employee_id;
    } else if ($employee_id >= 1000 && $employee_id <= 9999) {
        $maxid = "0" . $employee_id;
    } else {
        $maxid = $employee_id;
    }

    $result = ["maxid" => $maxid];
    echo json_encode($result);
}
