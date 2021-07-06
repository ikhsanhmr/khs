<?php
session_Start();
include_once("lib/config.php");
include_once("lib/check.php");
$get_spj = $_GET['no_spj'];
$get_area = $_GET['area'];
//$spj = isset($_GET['no_spj']) ? intval($_GET['no_spj']) : 0;
//$area = isset($_GET['area']) ? intval($_GET['area']) : 0;
$query = "SELECT A.SPJ_NO, B.VENDOR_NAMA,
			CASE WHEN A.SPJ_ADD_NILAI  is NULL THEN A.SPJ_NILAI
			ELSE A.SPJ_ADD_NILAI									 
			END SPJ_NILAI,
			A.SPJ_TANGGAL_MULAI,
			CASE WHEN A.SPJ_ADD_TANGGAL  is NULL THEN A.SPJ_TANGGAL_AKHIR
			ELSE A.SPJ_ADD_TANGGAL										 
			END SPJ_TANGGAL_AKHIR,
			A.gangguan,
			A.PAKET_JENIS
			FROM TB_SPJ A, TB_VENDOR B 
			WHERE A.VENDOR_ID = B.VENDOR_ID 
			AND A.SPJ_NO = '$get_spj'
			AND A.AREA_KODE = '$get_area'
			";
$result = mysqli_query($mysqli, $query);
$res = array();
while ($rows = mysqli_fetch_array($result))
{
    $res[] = $rows;
}
echo json_encode($res);
?>