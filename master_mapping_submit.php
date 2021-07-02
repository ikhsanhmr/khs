<?php
ini_set('session.gc_maxlifetime', 30*60);
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
include_once("lib/config.php");
date_default_timezone_set('Asia/Jakarta');
$vendor_id					= $_POST['vendor_id'];
$paket_jenis				= $_POST['paket_jenis'];
$area_kode					= $_POST['area_kode'];
$tahun_mapping				= $_POST['tahun_mapping'];
$zona						= $_POST['zona'];
$today 						= date('Y-m-d H:i:s');
$username 					= $_SESSION['username'];

		$sql = "INSERT into `tb_mapping_vendor` SET `AREA_KODE`='$area_kode', `PAKET_JENIS`='$paket_jenis', 
				`VENDOR_ID`='$vendor_id',`MAPPING_TAHUN`='$tahun_mapping', `ZONE`='$zona',
				`UPDATE_BY`='$username',`UPDATE_DATE`='$today'";	

		$resultQuery=mysqli_query($mysqli, $sql);

		if (isset($resultQuery)){
			echo '<script language="javascript">alert("Mapping Vendor Berhasil Ditambah!")</script>';
			echo '<script language="javascript">window.location = "master_mapping.php"</script>';
	
		} else {
			echo '<script language="javascript">alert("Mapping Vendor Gagal Ditambah!")</script>';
			echo '<script language="javascript">window.location = "master_mapping.php"</script>';
		}
