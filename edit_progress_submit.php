<?php
ini_set('session.gc_maxlifetime', 30*60);
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
include_once("lib/function.php");

$var_spj_no			= $_POST['var_spj_no'];
$var_progress		= $_POST['var_progress'];
$progress_sebelum		= $_POST['progress_sebelum'];
$tanggal_progress	= $_POST['tanggal_progress'];
$var_realisasi		= $_POST['var_realisasi'];
$var_deskripsi      = $_POST['var_deskripsi'];
$var_nama_pengawas      = $_POST['var_nama_pengawas'];

$sql ="SELECT count(SPJ_NO) FROM tb_termin WHERE SPJ_NO ='$var_spj_no' and keterangan !=''";
$resultQuery=mysqli_query($mysqli, $sql);
while ($rows=mysqli_fetch_row($resultQuery)) {
    $data[] = $rows;
}
if ($data[0][0] =='0') {
    $sql_progress = "UPDATE `tb_progress` SET `progress_date`='$tanggal_progress',`progress_pengawas`='$var_nama_pengawas',
			`progress_notes`='$var_deskripsi', `progress_value`= '$var_progress', `realisasi`='$var_realisasi' WHERE SPJ_NO='$var_spj_no'
			AND `progress_value`='$progress_sebelum'";
            
    /*echo "UPDATE `tb_progress` SET `progress_date`='$tanggal_progress',`progress_pengawas`='$var_nama_pengawas',
    `progress_notes`='$var_deskripsi', `progress_value`= '$var_progress', `realisasi`='$var_realisasi' WHERE SPJ_NO='$var_spj_no'
    AND `progress_value`='$progress_sebelum'";*/
            
    $resultQueryProgress=mysqli_query($mysqli, $sql_progress);
            
    if (isset($resultQueryProgress)) {
        echo '<script language="javascript">alert("Progress Pekerjaan Berhasil Diupdate")</script>';
        echo '<script language="javascript">window.location = "edit_progress.php"</script>';
    } else {
        echo '<script language="javascript">alert("Progress Pekerjaan  Gagal Diupdate")</script>';
        echo '<script language="javascript">window.location = "edit_progress.php"</script>';
    }
} else {
    echo '<script language="javascript">alert("Tidak Bisa Diubah Karena SPJ Sudah Ada Pembayaran")</script>';
    echo '<script language="javascript">window.location = "edit_progress.php"</script>';
}
//}
