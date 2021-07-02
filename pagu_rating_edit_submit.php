<?php
ini_set('session.gc_maxlifetime', 30*60);
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
include_once("lib/function.php");

$get_var_id_vendor	= $_POST['var_id_vendor'];
$get_var_rating		= $_POST['var_rating'];
$get_var_limit		= $_POST['var_limit'];

$return_pagu_rating = pagu_rating_edit($get_var_rating,$get_var_limit,$get_var_id_vendor, $mysqli);

if ($return_pagu_rating==0) {
	echo '<script language="javascript">alert("Nilai Pagu Rating Berhasil Diubah")</script>';
	echo '<script language="javascript">window.location = "kontrol_finansial.php"</script>';
} else {
	echo '<script language="javascript">alert("Nilai Pagu Rating Gagal Diubah")</script>';
	echo '<script language="javascript">window.location = "kontrol_finansial.php"</script>';
}
