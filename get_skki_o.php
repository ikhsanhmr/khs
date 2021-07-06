<?php
include_once("lib/config.php");
include_once("lib/function.php");
//$current_spj_no = '0007.PJ/DAN.00.02/A.JTN/2016';
$current_spj_no = $_GET['spj_no'] ;

$query = "SELECT skki_no FROM TB_SPJ WHERE SPJ_NO = '$current_spj_no' ";
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