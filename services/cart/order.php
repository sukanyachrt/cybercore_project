<?php
header('Content-Type: application/json');
include('../connect_data.php');
error_reporting(0);
session_start();
date_default_timezone_set('Asia/Bangkok');
$connect = new Connect_Data();
$connect->connectData();
$product = new Connect_Data();
$product->connectData();
$data = isset($_GET['v']) ? $_GET['v'] : '';
$result = array();
if ($data == "confirmorder") {
    $order_date = date('Y-m-d H:i');
    $connect->sql = "INSERT INTO `orders`  VALUES (null,'" . $_SESSION['customer_id'] . "','" . $order_date . "','1','')";
    $connect->queryData();
    $order_id = $connect->id_insertrows();
    $order_money = 0;
    foreach ($_SESSION['cart'] as $index => $order_qty) {
        $product_id = $index;
        $product->sql = "SELECT  *  FROM  product  WHERE product_id ='" . $product_id . "'";
        $product->queryData();
        $result = $product->fetch_AssocData();
        $product_price = $result['product_price'];
        $product_num = $result['product_num'];
        $remain_num = $product_num - $order_qty; //จำนวนสินค้าคงเหลือ

        $order_money += $product_price * $order_qty;
        $connect->sql = "INSERT INTO `orders_detail` VALUES 
        (null,'" . $order_id . "','" . $product_id . "','" . $order_qty . "','" . $product_price . "')";
        $connect->queryData();

        // ตัดข้อมูลจำนวนสินค้าออกจาก product
        $product->sql = "UPDATE `product` SET 
            `product_num`='" . $remain_num . "' 
            WHERE product_id='" . $product_id . "'";
        $product->queryData();
    }
    if ($order_id > 0) {
        unset($_SESSION['cart']);
        echo json_encode(["status" => "ok", "order_id" => $order_id, "order_date" => $order_date, 'order_money' => number_format($order_money, 2)]);
    } else {
        echo json_encode(["status" => "no"]);
    }
} else if ($data == "insertPayment") {
    $id = $_GET['id'];
    $post = $_POST;
    $pay_date_exp = explode("/", $post['pay_date']);
    $pay_date = $pay_date_exp[2] . "-" . $pay_date_exp[1] . "-" . $pay_date_exp[0];
    $pay_image = array();
    if (isset($_FILES['pay_image']) && !empty($_FILES['pay_image'])) {
        $countFiles = count($_FILES["pay_image"]['name']);
        for ($i = 0; $i < $countFiles; $i++) {
            if ($_FILES["pay_image"]["error"][$i] > 0) {
            } else {
                $name_image = $_FILES['pay_image']['name'][$i];
                array_push($pay_image, $name_image);
               
                $location = "../../assets/img/payment/" . $name_image;
                $uploadOk = 1;

                if ($uploadOk == 0) {
                } else {
                    if (move_uploaded_file($_FILES['pay_image']['tmp_name'][$i], $location)) {
                    } else {
                    }
                }
            }
        }
    }
    // check $id
    $product->sql = "SELECT * FROM payment WHERE order_id='" . $id . "'";
    $product->queryData();
    $row = $product->num_rows();
    if ($row > 0) {
        $rsproduct = $product->fetch_AssocData();
        $pay_id = $rsproduct['pay_id'];
        $connect->sql = "UPDATE `payment` SET 
        `pay_date`='" . $pay_date . "',
        `pay_total`='" . $post['pay_total'] . "',
        `pay_bank`='" . $post['pay_bank'] . "',
        `pay_image`='" . json_encode($pay_image) . "',
        `pay_time`='" . $post['pay_time'] . "',
        `pay_detail`='" . $pay_detail . "'
         WHERE pay_id='" . $pay_id . "'";
        $connect->queryData();
        $product->sql = "UPDATE `orders` SET 
        `order_status`='2' ,order_details=''
        WHERE order_id='" . $id . "'";
        $product->queryData();
        echo json_encode(["status" => "ok", $pay_date]);
    } else {
        $product->sql = "INSERT INTO `payment`(`pay_id`, `order_id`, `pay_date`, `pay_total`, `pay_bank`, `pay_image`, `pay_time`, `pay_detail`) VALUES 
        (null,'" . $id . "','" . $pay_date . "','" . $post['pay_total'] . "','" . $post['pay_bank'] . "','" . json_encode($pay_image) . "','" . $post['pay_time'] . "','" . $pay_detail . "')";
        $product->queryData();
        $pay_id = $product->id_insertrows();
        if ($pay_id > 0) {
            $product->sql = "UPDATE `orders` SET 
            `order_status`='2',order_details=''
            WHERE order_id='" . $id . "'";
            $product->queryData();
            echo json_encode(["status" => "ok", $pay_date]);
        } else {
            echo json_encode(["status" => "no"]);
        }
    }
} else if ($data == "cancelOrder") {
    $connect->sql = "UPDATE `orders` SET order_status='5',order_details='' WHERE order_id='" . $_GET['id'] . "'";
    $connect->queryData();
    echo json_encode(["status" => "ok"]);
} else if ($data == "checkNumberofProduct") {
    foreach ($_SESSION['cart'] as $index => $order_qty) {
        $product_id = $index;
        $product->sql = "SELECT  *  FROM  product  WHERE product_id ='" . $product_id . "'";
        $product->queryData();
        $rsproduct = $product->fetch_AssocData();
        $product_num = $rsproduct['product_num'];
        $product_name = $rsproduct['product_name'];
        $remain_num = $product_num - $order_qty;
        if ($remain_num < 0) {
            // จำนวนสินค้าไม่พอ
            $_SESSION['cart'][$product_id] = $remain_num + $order_qty;
            array_push($result, ['product_id' => $product_id, 'product_name' => $product_name, 'remain_num' => $remain_num + $order_qty]);
        }
    }
    echo json_encode($result);
}
