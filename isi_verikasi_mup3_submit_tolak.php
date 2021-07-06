<?php
        session_start();
        include_once("lib/config.php");
        include_once('lib/head.php');
        include_once("lib/check.php");
        
        $no_spj = $_POST["no_spj"];
        $verifikasi = $_POST["verifikasi"];
        $alasan = $_POST["alasan_evaluasi"];
        
        $simp1= mysqli_query($mysqli, "UPDATE tb_termin set verifikasi_mup3='$verifikasi', catatan_verifikasi_mup3='$alasan' where spj_no='$no_spj'");
        
        if ($simp1==1) {
            echo '<script language="javascript">alert("Verifikasi Berhasil Disimpan")</script>';
            echo '<script language="javascript">window.location = "verifikasi_evaluasi_mup3.php"</script>';
            mysqli_query($mysqli, "COMMIT");
        } else {
            echo '<script language="javascript">alert("Verifikasi Gagal Disimpan")</script>';
            echo '<script language="javascript">window.location = "verifikasi_evaluasi_mup3.php"</script>';
            mysqli_query($mysqli, "ROLLBACK");
        }
