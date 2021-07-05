<?php
        session_start();
        include_once("lib/config.php");
        include_once('lib/head.php');
        include_once("lib/check.php");
        
        $no_spj = $_GET["no_spj"];
        $verifikasi = $_GET["verifikasi"];
        
        $simp1= mysqli_query($mysqli, "UPDATE tb_termin set verifikasi_mb=$verifikasi where spj_no='$no_spj'");
        
    if ($simp1==1) {
        echo '<script language="javascript">alert("Verifikasi Berhasil Disimpan")</script>';
        echo '<script language="javascript">window.location = "verifikasi_evaluasi_mb.php"</script>';
        mysqli_query($mysqli, "COMMIT");
    } else {
        echo '<script language="javascript">alert("Verifikasi Gagal Disimpan")</script>';
        echo '<script language="javascript">window.location = "verifikasi_evaluasi_mb.php"</script>';
        /*echo ("INSERT INTO penilaian_nilai (id_kriteria, spj_no, nilai,bobot)
        VALUES ('$task', '$no_spj', '$isi_nilai[$i]', '$isi_bobot[$i]')");;*/
        mysqli_query($mysqli, "ROLLBACK");
    }
