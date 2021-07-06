<?php
ini_set('session.gc_maxlifetime', 30*60);
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
include_once("lib/function.php");

$spj_no			= $_GET['id'];
$surat_ijin_no	= $_POST['var_no_surat_ptsp'];
$tgl_surat		= date('Y-m-d', strtotime($_POST['var_tgl_surat']));
$pekerjaan		= $_POST['var_pekerjaan'];
$kota_adm		= $_POST['var_kota_adm'];
$lokasi			= $_POST['var_lokasi'];

$return_perijinan_add = perijinan_add(
    $spj_no,
    $surat_ijin_no,
    $tgl_surat,
    $pekerjaan,
    $kota_adm,
    $lokasi,
    $mysqli
);


if ($return_perijinan_add==0) {
    echo '<script language="javascript">alert("Perijinan Berhasil Ditambahkan")</script>';
    echo '<script language="javascript">window.location = "perijinan.php"</script>';
} else {
    echo '<script language="javascript">alert("Perijinan Gagal Ditambahkan")</script>';
    echo '<script language="javascript">window.location = "perijinan.php"</script>';
}
