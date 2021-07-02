<?php
ini_set('session.gc_maxlifetime', 30 * 60);
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
include_once("lib/config.php");
date_default_timezone_set('Asia/Jakarta');
$vendor_id					= $_POST['vendor_id'];
$paket_jenis				= $_POST['paket_jenis'];
$nilai_pagu					= $_POST['nilai_pagu'];
$rangking					= $_POST['rangking'];
$no_pjn						= $_POST['no_pjn'];
$tgl_pjn					= $_POST['tgl_pjn'];
$tgl_pjn_save 				= date('Y-m-d', strtotime($tgl_pjn));
$no_rks						= $_POST['no_rks'];
$tgl_rks					= $_POST['tgl_rks'];
$tgl_rks_save 				= date('Y-m-d', strtotime($tgl_rks));
$no_spp						= $_POST['no_spp'];
$tgl_spp					= $_POST['tgl_spp'];
$tgl_spp_save				= date('Y-m-d', strtotime($tgl_spp));
$no_penawaran				= $_POST['no_penawaran'];
$tgl_penawaran				= $_POST['tgl_penawaran'];
$tgl_penawaran_save			= date('Y-m-d', strtotime($tgl_penawaran));
$tgl_akhir					= $_POST['tgl_akhir'];
$tgl_akhir_save				= date('Y-m-d', strtotime($tgl_akhir));

$today 						= date('Y-m-d H:i:s');
$username 					= $_SESSION['username'];

$terpakai = 1.0000;

$sql = "INSERT into `tb_pagu_kontrak` SET `VENDOR_ID`='$vendor_id', `PAKET_JENIS`='$paket_jenis', 
				`PAGU_KONTRAK`='$nilai_pagu',`TERPAKAI`='$terpakai',`RANKING`='$rangking', 
				`NO_PJN`='$no_pjn',`TGL_PJN`='$tgl_pjn_save',`NO_RKS`='$no_rks',`TGL_RKS`='$tgl_rks_save', 
				`NO_SPP`='$no_spp',`tgl_spp`='$tgl_spp_save',`NO_PENAWARAN`='$no_penawaran',
				`tgl_penawaran`='$tgl_penawaran_save', `PAGU_KONTRAK_SBLM_UPDATE`='0',`TGL_AKHIR`='$tgl_akhir_save',
				`UPDATE_BY`='$username',`UPDATE_DATE`='$today'";

$resultQuery = mysqli_query($mysqli, $sql);

if (isset($resultQuery)) {
	echo '<script language="javascript">alert("Pagu Vendor Berhasil Ditambah!")</script>';
	echo '<script language="javascript">window.location = "master_pagu.php"</script>';
} else {
	echo '<script language="javascript">alert("Pagu Vendor Gagal Ditambah!")</script>';
	echo '<script language="javascript">window.location = "master_pagu.php"</script>';
}
