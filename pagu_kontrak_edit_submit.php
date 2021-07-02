<?php
ini_set('session.gc_maxlifetime', 30 * 60);
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
include_once("lib/function.php");

$get_var_id_vendor		= $_POST['var_id_vendor'];
$get_var_paket_id		= $_POST['var_paket_id'];
$get_var_pagu_kontrak	= $_POST['var_pagu_kontrak'];

$return_pagu_kontrak = pagu_kontrak_edit($get_var_pagu_kontrak, $get_var_id_vendor, $get_var_paket_id, $mysqli);


if ($return_pagu_kontrak == 0) {
	echo '<script language="javascript">alert("Nilai Pagu Kontrak Berhasil Diubah")</script>';
	echo '<script language="javascript">window.location = "kontrol_finansial.php"</script>';
} else {
	echo '<script language="javascript">alert("Nilai Pagu Kontrak Gagal Diubah")</script>';
	echo '<script language="javascript">window.location = "kontrol_finansial.php"</script>';
}
