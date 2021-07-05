<?php
ini_set('session.gc_maxlifetime', 30*60);
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
include_once("lib/function.php");

$surat_ijin_no	= $_POST['var_no_surat_ptsp'];
$tgl_skrd		= date('Y-m-d',strtotime($_POST['var_tgl_terbit_skrd']));
$biaya_retribusi= $_POST['var_biaya_retribusi'];

$return_skrd = skrd_add(
		$surat_ijin_no,
		$tgl_skrd,
		$biaya_retribusi,
		$mysqli
		);

if ($return_skrd==0) {
	echo '<script language="javascript">alert("SKRD Berhasil Ditambahkan")</script>';
	echo '<script language="javascript">window.location = "perijinan.php"</script>';
} else {
	echo '<script language="javascript">alert("SKRD Gagal Ditambahkan")</script>';
	echo '<script language="javascript">window.location = "perijinan.php"</script>';
}
