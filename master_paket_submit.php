<?php
ini_set('session.gc_maxlifetime', 30 * 60);
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
include_once("lib/config.php");
date_default_timezone_set('Asia/Jakarta');
$paket_jenis        = $_POST['paket_jenis'];
$paket_deskripsi      = $_POST['paket_deskripsi'];
$satuan              = $_POST['satuan'];
$paket_deskripsi2      = $_POST['paket_deskripsi2'];
$status            = $_POST['status'];
$today             = date('Y-m-d H:i:s');
$username           = $_SESSION['username'];

$sql = "INSERT into `tb_paket` SET `PAKET_JENIS`='$paket_jenis', `PAKET_DESKRIPSI`='$paket_deskripsi',
				`SATUAN`='$satuan',`PAKET_DESKRIPSI2`='$paket_deskripsi2',
				`STATUS`='$status',`UPDATE_BY`='$username', `UPDATE_DATE`='$today'";

$resultQuery = mysqli_query($mysqli, $sql);

if (isset($resultQuery)) {
    echo '<script language="javascript">alert("Paket Pekerjaan Berhasil Ditambah!")</script>';
    echo '<script language="javascript">window.location = "master_paket.php"</script>';
} else {
    echo '<script language="javascript">alert("Paket Pekerjaan Gagal Ditambah!")</script>';
    echo '<script language="javascript">window.location = "master_paket.php"</script>';
}
