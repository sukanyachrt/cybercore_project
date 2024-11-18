<?php
include('../Connect_Data.php');
error_reporting(0);
$connect = new Connect_Data();
$connect->connectData();
$connect->sql = "SELECT
* 
FROM employees";
$connect->queryData();
while ($rsconnect = $connect->fetch_AssocData()) {
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

    if ($rsconnect['employee_status'] == 1) {
        $employee_status = '<span class="badge bg-label-success">ใช้งาน</span>';
    } else {
        $employee_status = '<span class="badge bg-label-danger">ไม่ใช้งาน</span>';
    }
    echo '<tr>
    <td class="text-center">' . $emp_id. '</td>
    <td class="text-center">' . $rsconnect['employee_fname']." ". $rsconnect['employee_lname']. '</td>
    <td class="text-center">' . $rsconnect['employee_username'] . '</td>
    <td class="text-center">' . $rsconnect['employee_password'] . '</td>
    <td class="text-center">' . $employee_status . '</td>
    <td class="text-center">
        <a  href="data.php?id='.$rsconnect['employee_id'].'"><button class="border-warning text-warning"><i class="bx bx-edit-alt me-1"></i></button></a>
        <button class="border-danger text-danger"  onclick="updateEmployStatus('.$rsconnect['employee_id'].')"><i class="bx bx-trash me-1"></i></button>
    </td>
    </tr>';
}
