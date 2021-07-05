<?php
include_once("lib/config.php");
include_once("lib/function.php");

//$current_spj_no= '002.SPJ/DAN.02.01/A.JTN/2016';
//$current_spj_no = '001.SPJ/DAN.02.01/A.JTN/2016';
$current_spj_no = $_GET['spj_no'];


//$query = "SELECT coalesce(ifnull(status,0)) FROM `TB_TERMIN` WHERE SPJ_NO ='$current_spj_no' ";
$query = "SELECT COALESCE((SELECT keterangan FROM tb_termin WHERE SPJ_NO ='$current_spj_no'), '0') FROM DUAL";
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