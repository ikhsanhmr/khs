<?php
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
include_once("lib/mail.php");

$no_spj = $_GET['id'];

$sql = "SELECT count(SPJ_NO) FROM tb_progress WHERE SPJ_NO ='$no_spj'";
$resultQuery = mysqli_query($mysqli, $sql);
while ($rows = mysqli_fetch_row($resultQuery)) {
	$data[] = $rows;
}

if ($data[0][0] == '0') {

	$subject = '[KHS] Notifikasi Pembatalan SPJ';
	mail_sent($no_spj, $subject, "delete");
	$sql1 = "UPDATE tb_fin_vendor 
					SET FIN_CURRENT = FIN_CURRENT - (SELECT a.SPJ_ADD_NILAI from tb_spj a WHERE a.SPJ_NO = '$no_spj')
					WHERE VENDOR_ID = (SELECT a.VENDOR_ID from tb_spj a WHERE a.SPJ_NO = '$no_spj')";
	$sql2 = "UPDATE tb_pagu_kontrak
					SET TERPAKAI = TERPAKAI - (SELECT a.SPJ_ADD_NILAI from tb_spj a WHERE a.SPJ_NO = '$no_spj')
					WHERE VENDOR_ID = (SELECT a.VENDOR_ID from tb_spj a WHERE a.SPJ_NO = '$no_spj')
					AND PAKET_JENIS = (SELECT a.PAKET_JENIS from tb_spj a WHERE a.SPJ_NO = '$no_spj')";
	$sql3 = "UPDATE tb_skko_i
					SET SKKI_TERPAKAI = SKKI_TERPAKAI - (SELECT a.SPJ_ADD_NILAI from tb_spj a WHERE a.SPJ_NO = '$no_spj')
					WHERE SKKI_NO = (SELECT a.SKKI_NO from tb_spj a WHERE a.SPJ_NO = '$no_spj')";
	$sql = "DELETE FROM tb_spj WHERE SPJ_NO  = '$no_spj' LIMIT 1";
	//echo $sql;
	$resultQuery1 = mysqli_query($mysqli, $sql1);
	$resultQuery2 = mysqli_query($mysqli, $sql2);
	$resultQuery3 = mysqli_query($mysqli, $sql3);
	$resultQuery = mysqli_query($mysqli, $sql);
	echo '<script language="javascript">alert("No SPJ Berhasil di Hapus !")</script>';
	echo '<script language="javascript">window.location = "spj_view.php"</script>';
} else {
	echo '<script language="javascript">alert("Tidak Bisa Dihapus Karena SPJ Sudah Ada Progress")</script>';
	echo '<script language="javascript">window.location = "spj_view.php"</script>';
}
/*
$return_delete_news_big = delete_area($id_area);

if ($return_delete_news_big==1) {
	echo '<script language="javascript">alert("Data Area Berhasil di Hapus !")</script>';
	echo '<script language="javascript">window.location = "area.php"</script>';
} else {
	echo '<script language="javascript">alert("Data Area Gagal di Hapus !")</script>';
	echo '<script language="javascript">window.location = "area.php"</script>';
}
*/
