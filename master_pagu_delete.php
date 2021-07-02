<?php
session_start();
include_once("lib/config.php");
include_once("lib/check.php");
$vendor_id = $_GET['vendor_id'];
$paket_jenis = $_GET['paket_jenis'];

$sql ="SELECT TERPAKAI FROM tb_pagu_kontrak WHERE VENDOR_ID ='$vendor_id' and PAKET_JENIS='$paket_jenis'";
$resultQuery=mysqli_query($mysqli, $sql);
while ($rows=mysqli_fetch_row($resultQuery)){ 
	$data[] = $rows;
}

if($data[0][0]== '0.0000')
{
	$delQuery = mysqli_query($mysqli, "DELETE FROM tb_pagu_kontrak WHERE VENDOR_ID = '$vendor_id' and PAKET_JENIS='$paket_jenis'");
	//if ($delQuery==1) {
	echo '<script language="javascript">alert("Pagu Vendor Berhasil Dihapus")</script>';
	echo '<script language="javascript">window.location = "master_pagu.php"</script>';
} else {
	echo '<script language="javascript">alert("ERROR : Pagu Vendor Gagal di Hapus karena Sudah ada SPJ Terbit!")</script>';
	echo '<script language="javascript">window.location = "master_pagu.php"</script>';
}
