<?php
ini_set('session.gc_maxlifetime', 30*60);
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
include_once("lib/config.php");
date_default_timezone_set('Asia/Jakarta');
$vendor_nama				= $_POST['vendor_nama'];
$tahun						= $_POST['tahun'];
$direksi_vendor				= $_POST['direksi_vendor'];
$jabatan					= $_POST['jabatan'];
$email						= $_POST['email'];
$telepon					= $_POST['telepon'];
$today 						= date('Y-m-d H:i:s');
$username 					= $_SESSION['username'];

        $sql = "INSERT into `tb_vendor` SET `VENDOR_NAMA`='$vendor_nama', `TAHUN`='$tahun', 
				`DIREKSI_VENDOR`='$direksi_vendor',`EMAIL`='$email', 
				`TELEPON`='$telepon',`jabatan`='$jabatan', `UPDATE_BY`='$username',`UPDATE_DATE`='$today'";

        $resultQuery=mysqli_query($mysqli, $sql);

        if (isset($resultQuery)) {
            echo '<script language="javascript">alert("Vendor Pekerjaan Berhasil Ditambah!")</script>';
            echo '<script language="javascript">window.location = "master_vendor.php"</script>';
        } else {
            echo '<script language="javascript">alert("Vendor Pekerjaan Gagal Ditambah!")</script>';
            echo '<script language="javascript">window.location = "master_vendor.php"</script>';
        }
