<?php
session_start();
include_once('lib/head.php');
include_once("lib/check.php");

$no_spj = $_GET['spj_no'];
$progress = $_GET['progress'];

//$sql ="SELECT count(SPJ_NO) FROM tb_progress WHERE SPJ_NO ='$no_spj'";
$sql ="SELECT count(SPJ_NO) FROM tb_termin WHERE SPJ_NO ='$no_spj' and keterangan !=''";
$resultQuery=mysqli_query($mysqli, $sql);
while ($rows=mysqli_fetch_row($resultQuery)) {
    $data[] = $rows;
}

if ($data[0][0] =='0') {
    $sql1="DELETE FROM tb_progress  WHERE SPJ_NO='$no_spj'
			AND `progress_value`='$progress'";
    //echo $sql;
    $resultQuery1=mysqli_query($mysqli, $sql1);
    if (isset($resultQuery1)) {
        echo '<script language="javascript">alert("Progress Pekerjaan Berhasil Dihapus")</script>';
        echo '<script language="javascript">window.location = "edit_progress.php"</script>';
    } else {
        echo '<script language="javascript">alert("Progress Pekerjaan  Gagal Dihapus")</script>';
        echo '<script language="javascript">window.location = "edit_progress.php"</script>';
    }
} else {
    echo '<script language="javascript">alert("Tidak Bisa Dihapus Karena SPJ Sudah Ada Pembayaran")</script>';
    echo '<script language="javascript">window.location = "edit_progress.php"</script>';
}
