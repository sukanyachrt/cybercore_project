<?php
header('Content-Type: application/json');
include('../connect_data.php');
$connect = new Connect_Data();
$connect->connectData();
$data = isset($_GET['v']) ? $_GET['v'] : '';
$result = array();
?>