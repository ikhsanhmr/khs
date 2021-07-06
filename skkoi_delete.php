<?php
session_start();
include_once("lib/config.php");
include_once("lib/check.php");
$skki_no = $_GET['skki_no'];

$sql = "SELECT SKKI_TERPAKAI FROM tb_skko_i WHERE SKKI_NO ='$skki_no'";
$resultQuery = mysqli_query($mysqli, $sql);
while ($rows = mysqli_fetch_row($resultQuery)) {
	$data[] = $rows;
}

if ($data[0][0] == '0') {

	$delQuery = mysqli_query($mysqli, "DELETE FROM tb_skko_i WHERE skki_no = '$skki_no'");
	//if ($delQuery==1) {
	echo '<script language="javascript">alert("PRK SKKI/O Area Berhasil Dihapus")</script>';
	echo '<script language="javascript">window.location = "skkoi_view.php"</script>';
} else {
	echo '<script language="javascript">alert("ERROR : Data PRK SKKI/O  Area Gagal di Hapus Karena Sudah Ada Nilai Terpakai!")</script>';
	echo '<script language="javascript">window.location = "skkoi_view.php"</script>';
}
