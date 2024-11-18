<?php
header('Content-Type: application/json');
include('../connect_data.php');
//error_reporting(0);
$connect = new Connect_Data();
$connect->connectData();
$data = isset($_GET['v']) ? $_GET['v'] : '';
$result = array();

if ($data == "updateProducttypeStatus") {
    $connect->sql = "UPDATE producttype SET protype_status = '0' 
     WHERE protype_id ='" . $_GET['id'] . "'";
    $connect->queryData();
    echo json_encode(["result" => $connect->affected_rows()]);
} else if ($data == "maxIdProducttype") {
    $connect->sql = "SELECT	MAX( protype_id ) AS maxid FROM	producttype";
    $connect->queryData();

    $rsconnect = $connect->fetch_AssocData();
    $maxid = $rsconnect['maxid'] + 1;
    if ($maxid <= 9) {
        $protype_id = "0000" . $maxid;
    } else if ($maxid >= 10 && $maxid <= 99) {
        $protype_id = "000" . $maxid;
    } else if ($maxid >= 100 && $maxid <= 999) {
        $protype_id = "00" . $maxid;
    } else if ($maxid >= 1000 && $maxid <= 9999) {
        $protype_id = "0" . $maxid;
    } else {
        $protype_id = $maxid;
    }
    $result = ["maxid" => $protype_id];
    echo json_encode($result);
} else if ($data == "dataproducttype_id") {
    $connect->sql = "SELECT
    *
FROM
producttype
	
    WHERE protype_id='" . $_GET['id'] . "'";
    $connect->queryData();
    $row = $connect->num_rows();
    if ($row > 0) {

        $rsconnect = $connect->fetch_AssocData();
        if ($rsconnect['protype_id'] <= 9) {
            $protype_id = "0000" . $rsconnect['protype_id'];
        } else if ($rsconnect['protype_id'] >= 10 && $rsconnect['protype_id'] <= 99) {
            $protype_id = "000" . $rsconnect['protype_id'];
        } else if ($rsconnect['protype_id'] >= 100 && $rsconnect['protype_id'] <= 999) {
            $protype_id = "00" . $rsconnect['product_id'];
        } else if ($rsconnect['protype_id'] >= 1000 && $rsconnect['protype_id'] <= 9999) {
            $protype_id = "0" . $rsconnect['protype_id'];
        } else {
            $protype_id = $rsconnect['protype_id'];
        }
        $rsconnect['protype_id'] = $protype_id;
        array_push($result, ["status" => "ok", "data" => $rsconnect]);
    } else {
        array_push($result, ["status" => "no"]);
    }

    echo json_encode($result[0]);
} else if ($data == "updateProducttype") {
    $post = $_POST;
    $connect->sql = "UPDATE `producttype` SET 
    `protype_name`='" . $post['protype_name'] . "',
    `protype_status`='" . $post['protype_status'] . "'
    WHERE protype_id='" . $_GET['id'] . "'";
    $connect->queryData();
    echo json_encode(["result" => $connect->affected_rows()]);
} else if ($data == "inserteproducttype") {
    $post = $_POST;
    $product_image = "";

    $connect->sql = "INSERT INTO `producttype` VALUES 
    (null,
    '" . $post['protype_name'] . "',
    '" . $post['protype_status'] . "'
     )";
    $connect->queryData();
    echo json_encode(["result" => $connect->affected_rows()]);
}
