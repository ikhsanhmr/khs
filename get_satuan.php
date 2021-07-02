<?php
include_once("lib/config.php");
include_once("lib/function.php");
//$current_paket_jenis = '4';
$current_paket_jenis = $_GET['paket_jenis'] ;

$query = "SELECT satuan FROM tb_paket where paket_jenis = $current_paket_jenis ";
$result = mysqli_query($query);

$respon = array();
while ($hasil = mysqli_fetch_row($result))
{
    $respon[] = $hasil;
}

//echo $respon[0][0];
echo json_encode($respon);

?>