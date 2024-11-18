<?php
include('../Connect_Data.php');
error_reporting(0);
$connect = new Connect_Data();
$connect->connectData();
$connect->sql = "SELECT * FROM `producttype`";
$connect->queryData();
$row = $connect->num_rows();
if($row<=0){
    echo '<tr>
    <td class="text-center" colspan="4">ไม่มีข้อมูล</td>
    </tr>';
}
else{
    while ($rsconnect = $connect->fetch_AssocData()) {
        if ($rsconnect['protype_id'] <= 9) {
            $protype_id = "0000" . $rsconnect['protype_id'];
        } else if ($rsconnect['protype_id'] >= 10 && $rsconnect['protype_id'] <= 99) {
            $protype_id = "000" . $rsconnect['protype_id'];
        } else if ($rsconnect['protype_id'] >= 100 && $rsconnect['protype_id'] <= 999) {
            $protype_id = "00" . $rsconnect['protype_id'];
        } else if ($rsconnect['protype_id'] >= 1000 && $rsconnect['protype_id'] <= 9999) {
            $protype_id = "0" . $rsconnect['protype_id'];
        } else {
            $protype_id = $rsconnect['protype_id'];
        }
    
        if ($rsconnect['protype_status'] == 1) {
            $protype_status = '<span class="badge bg-label-success">ใช้งาน</span>';
        } else {
            $protype_status = '<span class="badge bg-label-danger">ไม่ใช้งาน</span>';
        }
        echo '<tr>
        <td class="text-center">' . $protype_id . '</td>
        <td class="text-center">' . $rsconnect['protype_name'] . '</td>
        <td class="text-center">' . $protype_status . '</td>
        <td class="text-center">
            <a  href="data.php?id='.$rsconnect['protype_id'].'"><button class="border-warning text-warning"><i class="bx bx-edit-alt me-1"></i></button></a>
            <button class="border-danger text-danger"  onclick="updateEmployStatus('.$rsconnect['protype_id'].')"><i class="bx bx-trash me-1"></i></button>
        </td>
        </tr>';
    }
}

