<?php
ini_set('session.gc_maxlifetime', 30 * 60);
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
include_once("lib/config.php");
date_default_timezone_set('Asia/Jakarta');
$vendor_id          = $_POST['vendor_id'];
$var_rating          = $_POST['var_rating'];
$isi_limit          = $_POST['isi_limit'];
$today             = date('Y-m-d H:i:s');
$username           = $_SESSION['username'];

// tidak ada di form
$isi_current = 1.00;

$sql = "INSERT into `tb_fin_vendor` SET `VENDOR_ID`='$vendor_id', 
        `RATING_LAPORAN_AUDIT`='$var_rating',`FIN_CURRENT`='$isi_current',
				`FIN_LIMIT`='$isi_limit',`FIN_LIMIT_PERTAMA`='$isi_limit', 
				`RATING_LAPORAN_AUDIT_PERTAMA`='$var_rating',
				`UPDATE_BY`='$username',`UPDATE_DATE`='$today'";

$resultQuery = mysqli_query($mysqli, $sql);

if (isset($resultQuery)) {
  echo '<script language="javascript">alert("Finansial Vendor Berhasil Ditambah!")</script>';
  echo '<script language="javascript">window.location = "master_finansial.php"</script>';
} else {
  echo '<script language="javascript">alert("Finansial Vendor Gagal Ditambah!")</script>';
  echo '<script language="javascript">window.location = "master_finansial.php"</script>';
}
