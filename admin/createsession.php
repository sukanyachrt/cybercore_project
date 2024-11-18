<?php
header('Content-Type: application/json');
session_start(); // เริ่ม Session

if (isset($_POST['status']) && $_POST['status'] === 'ok') {
    
    $data = $_POST['data'];
    $_SESSION['employee_id'] = $data['employee_id'];
    $_SESSION['employee_fname'] =$data['employee_fname'];
    $_SESSION['employee_lname'] =$data['employee_lname'];
    $_SESSION['employee_status'] =$data['employee_status'];
    if($_SESSION['employee_status']=="1"){
        echo json_encode(["data"=>"ok","page"=>"views/product/index.php"]);
    }
   
} else {
    echo json_encode(["data"=>"no"]);
}
