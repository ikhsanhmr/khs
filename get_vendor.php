<?php
include_once("lib/config.php");
include_once("lib/function.php");
//$current_spj_no = '0007.PJ/DAN.00.02/A.JTN/2016';
$current_spj_no = $_GET['spj_no'] ;

$query = "SELECT VENDOR_ID FROM tb_spj where spj_no = '$current_spj_no' ";
//echo $query;
$result = mysqli_query($mysqli, $query);

$respon = array();
while ($hasil = mysqli_fetch_row($result))
{
    $respon[] = $hasil;
}

//echo $respon[0][0];
echo json_encode($respon);

?>