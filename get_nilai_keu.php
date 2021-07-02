<?php
include_once("lib/config.php");
include_once("lib/function.php");
//$current_spj_no= '001.SPJ/DAN.02.03/A.JTN/2016';
session_start();
$current_spj_no = $_GET['spj_no'];

$respon = select_nilai_add_keu($current_spj_no);
//echo 'dhaifina'.$respon;
echo json_encode($respon);

?>