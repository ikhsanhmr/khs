<?php
session_start();
include_once("lib/config.php");
include_once("lib/check.php");
$paket_jenis = $_GET['paket_jenis'];

$sql ="SELECT AREA_KODE FROM tb_mapping_vendor WHERE PAKET_JENIS ='$paket_jenis'";
$resultQuery=mysqli_query($mysqli, $sql);
while ($rows=mysqli_fetch_row($resultQuery)) {
    $data[] = $rows;
}

if (empty($data[0][0])) {
    $delQuery = mysqli_query($mysqli, "DELETE FROM tb_paket WHERE PAKET_JENIS = '$paket_jenis'");
    //if ($delQuery==1) {
    echo '<script language="javascript">alert("Paket Jenis Berhasil Dihapus")</script>';
    echo '<script language="javascript">window.location = "master_paket.php"</script>';
} else {
    echo '<script language="javascript">alert("ERROR : Paket Jenis Gagal di Hapus karena Sudah ter Mapping!")</script>';
    echo '<script language="javascript">window.location = "master_paket.php"</script>';
}
