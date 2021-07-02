<?php
session_start();
include_once("lib/config.php");
include_once("lib/check.php");
$vendor_id = $_GET['vendor_id'];
$paket_jenis = $_GET['paket_jenis'];
$area_kode = $_GET['area_kode'];

$sql ="SELECT PAKET_JENIS, VENDOR_ID FROM tb_spj WHERE VENDOR_ID ='$vendor_id' and PAKET_JENIS='$paket_jenis'";
$resultQuery=mysqli_query($mysqli, $sql);
while ($rows=mysqli_fetch_row($resultQuery)){ 
	$data[] = $rows;
}

if((empty($data[0][0]))and(empty($data[0][1])))
{
	$delQuery = mysqli_query($mysqli, "DELETE FROM tb_mapping_vendor WHERE VENDOR_ID = '$vendor_id' and PAKET_JENIS='$paket_jenis' and AREA_KODE='$area_kode'");
	//if ($delQuery==1) {
	echo '<script language="javascript">alert("Mapping Vendor Berhasil Dihapus")</script>';
	echo '<script language="javascript">window.location = "master_mapping.php"</script>';
} else {
	echo '<script language="javascript">alert("ERROR : Mapping Vendor Gagal di Hapus karena Sudah ada SPJ Terbit!")</script>';
	echo '<script language="javascript">window.location = "master_mapping.php"</script>';
}
