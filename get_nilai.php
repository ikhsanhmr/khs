<?php
include_once("lib/config.php");
include_once("lib/function.php");
//$current_spj_no= '001.SPJ/DAN.02.03/A.JTN/2016';
session_start();
$kode_area = $_SESSION['area'];
$current_spj_no = $_GET['spj_no'];

$respon = select_nilai_add($current_spj_no,$kode_area);
//echo 'dhaifina'.$respon;
echo json_encode($respon);

?>