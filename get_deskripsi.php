<?php
include_once("lib/config.php");
include_once("lib/function.php");

//$current_spj_no= '001.SPJ/DAN.02.01/A.JTN/2016';
$current_spj_no = $_GET['spj_no'];

$query = "SELECT SPJ_DESKRIPSI FROM `tb_spj` WHERE SPJ_NO ='$current_spj_no' ";
//echo $query;
$result = mysqli_query($query);

$respon = array();
while ($hasil = mysqli_fetch_row($result))
{
    $respon[] = $hasil;
}
/*
$query2 = "SELECT vendor_id from tb_spj where spj_no = '$current_spj_no' ";
$resultQuery=mysqli_query($query2);
$row = mysqli_fetch_array($resultQuery);
$vendor = $row['vendor_id'];

if ($vendor < 107){
	$respon = $100;
}
*/
//echo $respon[0][0];
echo json_encode($respon);

?>