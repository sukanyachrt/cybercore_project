<?php
header('Content-Type: application/json');
include('../connect_data.php');
error_reporting(0);
$connect = new Connect_Data();
$connect->connectData();
$data = isset($_GET['v']) ? $_GET['v'] : '';
$result = array();

if ($data == "updateProductStatus") {
    // $connect->sql = "UPDATE product SET product_status = '0' 
    //  WHERE product_id ='" . $_GET['id'] . "'";
    // $connect->queryData();
    // echo json_encode(["result" => $connect->affected_rows()]);
    $connect->sql = "DELETE FROM product  WHERE product_id ='" . $_GET['id'] . "'";
    $connect->queryData();
    echo json_encode(["result" => $connect->affected_rows()]);
    // $row = $connect->affected_rows();
    // if($row>0){
    //     json_encode(["result"=>"ลบข้อมูลเรียบร้อยแล้วค่ะ"]);
    // }
    // else{
    //     json_encode(["result"=>"ไม่สามารถลบข้อมูลนี้ได้"]);
    // }
} else if ($data == "maxIdProduct") {
    $connect->sql = "SELECT	MAX( product_id ) AS maxid FROM	product";
    $connect->queryData();

    $rsconnect = $connect->fetch_AssocData();
    $maxid = $rsconnect['maxid'] + 1;
    if ($maxid <= 9) {
        $product_id = "0000" . $maxid;
    } else if ($maxid >= 10 && $maxid <= 99) {
        $product_id = "000" . $maxid;
    } else if ($maxid >= 100 && $maxid <= 999) {
        $product_id = "00" . $maxid;
    } else if ($maxid >= 1000 && $maxid <= 9999) {
        $product_id = "0" . $maxid;
    } else {
        $product_id = $maxid;
    }
    $result = ["maxid" => $product_id];
    echo json_encode($result);
} else if ($data == "dataproduct_id") {
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
	INNER JOIN producttype ON product.protype_id = producttype.protype_id
    WHERE product_id='" . $_GET['id'] . "'";
    $connect->queryData();
    $row = $connect->num_rows();
    if ($row > 0) {

        $rsconnect = $connect->fetch_AssocData();
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
        $rsconnect['product_id'] = $product_id;
        $rsconnect['progroup_imageLocation'] =  "../../../assets/img/product/" . $rsconnect['product_image'];
        array_push($result, ["status" => "ok", "data" => $rsconnect]);
    } else {
        array_push($result, ["status" => "no"]);
    }

    echo json_encode($result[0]);
} else if ($data == "updateProduct") {


    #update
    $product_image = '';
    if ($_FILES["product_image"]["error"] > 0) {
        $product_image = "";
    } else {
        $product_image = $_FILES['product_image']['name'];
        $location = "../../../assets/img/product/" . $product_image;
        $uploadOk = 1;

        if ($uploadOk == 0) {
        } else {
            /* Upload file */
            if (move_uploaded_file($_FILES['product_image']['tmp_name'], $location)) {
            } else {
            }
        }
    }



    $post = $_POST;
    if ($post['product_imageHidden'] != "") {
        $product_image = $post['product_imageHidden'];
    }

    $product_num = $post['product_num'];
    if ($post['updateproduct_num'] > 0) {
        $product_num = $post['product_num'] + $post['updateproduct_num'];
    }
    $connect->sql = "UPDATE `product` SET 
    `protype_id`='" . $post['protype_id'] . "',
    `product_name`='" . $post['product_name'] . "',
    `product_detail`='" . $post['product_detail'] . "',
    `product_price`='" . $post['product_price'] . "',
    `product_num`='" . $product_num . "',
    `product_status`='" . $post['product_status'] . "',
    product_image = '" . $product_image . "'
    WHERE product_id='" . $_GET['id'] . "'";
    $connect->queryData();

    echo json_encode(["result" => $connect->affected_rows()]);
    //  echo json_encode($_POST);
} else if ($data == "insertproduct") {
    $post = $_POST;
    $product_image = "";
    if ($_FILES["product_image"]["error"] > 0) {
        $product_image = "";
    } else {
        $product_image = $_FILES['product_image']['name'];
        $location = "../../../assets/img/product/" . $product_image;
        $uploadOk = 1;

        if ($uploadOk == 0) {
        } else {
            /* Upload file */
            if (move_uploaded_file($_FILES['product_image']['tmp_name'], $location)) {
            } else {
            }
        }
    }
    $connect->sql = "INSERT INTO `product` VALUES 
    (null,
    '" . $post['protype_id'] . "',
    '" . $post['product_name'] . "',
    '" . $post['product_detail'] . "',
    '" . $post['product_price'] . "',
    '" . $post['product_num'] . "',
    '" . $post['product_status'] . "',
    '" . $product_image . "')";
    $connect->queryData();




    echo json_encode(["result" => $connect->affected_rows()]);
}
