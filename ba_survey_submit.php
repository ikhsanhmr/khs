<?php
ini_set('session.gc_maxlifetime', 30*60);
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
include_once("lib/function.php");


$surat_ijin_no	= $_POST['var_no_surat_ptsp'];
$tgl_survey		= date('Y-m-d',strtotime($_POST['var_tgl_survey']));
$hasil_survey	= $_POST['var_hasil_survey'];
$status			= $_POST['option_persetujuan'];


if($status == '1')
{
	$spj = search_spj_by_no_surat_ptsp($surat_ijin_no);
	$spj_no = $spj[0][0];

	$return_ba= flag_revisi($spj_no, $status);
	if ($return_ba==0) {
		echo '<script language="javascript">alert("Flag Revisi Berhasil")</script>';
		echo '<script language="javascript">window.location = "perijinan.php"</script>';
	}

}
else
{

	$return_ba = ba_survey_add(
		$surat_ijin_no,
		$tgl_survey,
		$hasil_survey,
		$status
		);
	
	if ($return_ba==0) {
		echo '<script language="javascript">alert("BA Survey Berhasil Ditambahkan")</script>';
		echo '<script language="javascript">window.location = "perijinan.php"</script>';
	} else {
		echo '<script language="javascript">alert("BA Survey Gagal Ditambahkan")</script>';
		echo '<script language="javascript">window.location = "perijinan.php"</script>';
	} 
	
}

?>
