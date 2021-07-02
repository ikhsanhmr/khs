<?php
session_start();
include_once("lib/config.php");
include_once("lib/check.php");

$username = $_GET['username'];
$delQuery = mysqli_query($mysqli, "DELETE FROM tb_user WHERE username = '$username'");
if ($delQuery==1) {
	echo '<script language="javascript">alert("User Berhasil Dihapus")</script>';
	echo '<script language="javascript">window.location = "inp_user_all.php"</script>';
} else {
	echo '<script language="javascript">alert("ERROR : User Gagal di Hapus !")</script>';
	echo '<script language="javascript">window.location = "inp_user_all.php"</script>';
}
