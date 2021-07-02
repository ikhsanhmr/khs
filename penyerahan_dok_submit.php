<?php
ini_set('session.gc_maxlifetime', 30*60);
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
include_once("lib/function.php");


$spj_no		= $_POST['var_no_spj'];
$tgl_serah	= date('Y-m-d',strtotime($_POST['var_tgl_serah']));
$jum_dok	= $_POST['var_jumlah_dok'];
$ket		= $_POST['var_keterangan'];
$status_dok	= '0';

$return_ba = serah_dok_add($spj_no, $tgl_serah, $jum_dok, $ket,$status_dok);

if ($return_ba==0) {
	echo '<script language="javascript">alert("Penyerahan Dokumen Berhasil Ditambahkan")</script>';
	echo '<script language="javascript">window.location = "perijinan.php"</script>';
} else {
	echo '<script language="javascript">alert("Penyerahan Dokumen Gagal Ditambahkan")</script>';
	echo '<script language="javascript">window.location = "perijinan.php"</script>';
} 

?>
