<?php
ini_set('session.gc_maxlifetime', 30*60);
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
include_once("lib/function.php");

$surat_ijin_no	= $_POST['var_no_surat_ptsp'];
$tgl_bayar		= date('Y-m-d',strtotime($_POST['var_tgl_bayar_retribusi']));

$return_bayar = bayar_retribusi_add(
		$surat_ijin_no,
		$tgl_bayar
		);

if ($return_bayar==0) {
	echo '<script language="javascript">alert("Pembayaran Retribusi Berhasil Ditambahkan")</script>';
	echo '<script language="javascript">window.location = "perijinan.php"</script>';
} else {
	echo '<script language="javascript">alert("Pembayaran Retribusi Berhasil Ditambahkan")</script>';
	echo '<script language="javascript">window.location = "perijinan.php"</script>';
} 

?>
