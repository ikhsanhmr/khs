<?php
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
include_once("lib/mail.php");

$no_spj = $_GET['id'];
//$sql ="SELECT count(SPJ_NO) FROM tb_progress WHERE SPJ_NO ='$no_spj'";
$sql = "SELECT count(SPJ_NO) FROM tb_termin WHERE SPJ_NO ='$no_spj' and keterangan !=''";
$resultQuery = mysqli_query($mysqli, $sql);
while ($rows = mysqli_fetch_row($resultQuery)) {
	$data[] = $rows;
}

$sqlxx = "SELECT SPJ_ADD_NILAI, VENDOR_ID, PAKET_JENIS, SKKI_NO from tb_spj where SPJ_NO='$no_spj'";
$resultQueryxx = mysqli_query($mysqli, $sqlxx);
while ($rowsxx = mysqli_fetch_row($resultQueryxx)) {
	$dataxx[] = $rowsxx;
}

$print_spjaddnilai = $dataxx[0][0];
$print_vendorid = $dataxx[0][1];
$print_paket = $dataxx[0][2];
$print_skkino = $dataxx[0][3];

if ($data[0][0] == '0') {

	/*$sql1 = "UPDATE tb_fin_vendor 
					SET FIN_CURRENT = FIN_CURRENT - (SELECT a.SPJ_ADD_NILAI from tb_spj a WHERE a.SPJ_NO = '$no_spj')
					WHERE VENDOR_ID = (SELECT a.VENDOR_ID from tb_spj a WHERE a.SPJ_NO = '$no_spj')";
		$sql2 = "UPDATE tb_pagu_kontrak
					SET TERPAKAI = TERPAKAI - (SELECT a.SPJ_ADD_NILAI from tb_spj a WHERE a.SPJ_NO = '$no_spj')
					WHERE VENDOR_ID = (SELECT a.VENDOR_ID from tb_spj a WHERE a.SPJ_NO = '$no_spj')
					AND PAKET_JENIS = (SELECT a.PAKET_JENIS from tb_spj a WHERE a.SPJ_NO = '$no_spj')";
		$sql3 = "UPDATE tb_skko_i
					SET SKKI_TERPAKAI = SKKI_TERPAKAI - (SELECT a.SPJ_ADD_NILAI from tb_spj a WHERE a.SPJ_NO = '$no_spj')
					WHERE SKKI_NO = (SELECT a.SKKI_NO from tb_spj a WHERE a.SPJ_NO = '$no_spj')";
		*/

	$subject = '[KHS 2020] Notifikasi Pembatalan SPJ';
	mail_sent($no_spj, $subject, "delete");
	$sql1 = "UPDATE tb_fin_vendor 
					SET FIN_CURRENT = (FIN_CURRENT - $print_spjaddnilai)
					WHERE VENDOR_ID = '$print_vendorid'";
	$sql2 = "UPDATE tb_pagu_kontrak
					SET TERPAKAI = (TERPAKAI - $print_spjaddnilai)
					WHERE VENDOR_ID = '$print_vendorid'
					AND PAKET_JENIS = '$print_paket'";
	$sql3 = "UPDATE tb_skko_i
					SET SKKI_TERPAKAI = (SKKI_TERPAKAI - $print_spjaddnilai)
					WHERE SKKI_NO = '$print_skkino'";

	$sql = "DELETE FROM tb_spj WHERE SPJ_NO  = '$no_spj' LIMIT 1";
	$sql4 = "DELETE FROM tb_progress WHERE SPJ_NO  = '$no_spj' LIMIT 1";
	$sql5 = "DELETE FROM tb_termin WHERE SPJ_NO  = '$no_spj' LIMIT 1";
	$sql6 = "DELETE FROM tb_addendum WHERE SPJ_NO  = '$no_spj'";
	//echo $sql;
	$resultQuery1 = mysqli_query($mysqli, $sql1);
	$resultQuery2 = mysqli_query($mysqli, $sql2);
	$resultQuery3 = mysqli_query($mysqli, $sql3);
	$resultQuery = mysqli_query($mysqli, $sql);
	$resultQuery4 = mysqli_query($mysqli, $sql4);
	$resultQuery5 = mysqli_query($mysqli, $sql5);
	$resultQuery6 = mysqli_query($mysqli, $sql6);

	if (
		$resultQuery1 == 1 and $resultQuery2 == 1 and $resultQuery3 == 1 and $resultQuery == 1 and $resultQuery4 == 1
		and $resultQuery5 == 1 and $resultQuery6 == 1
	) {
		mysqli_query($mysqli, "COMMIT");
		echo '<script language="javascript">alert("No SPJ Berhasil di Hapus !")</script>';
		echo '<script language="javascript">window.location = "spj_view.php"</script>';
	} else {
		mysqli_query($mysqli, "ROLLBACK");
		echo '<script language="javascript">alert("No SPJ Gagal di Hapus, Ada Kesalahan !")</script>';
		echo '<script language="javascript">window.location = "spj_view.php"</script>';
	}
} else {
	echo '<script language="javascript">alert("Tidak Bisa Dihapus Karena SPJ Sudah Ada Pembayaran")</script>';
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
