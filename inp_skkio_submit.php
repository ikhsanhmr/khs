<?php
    session_start();
    include_once("lib/config.php");
    include_once("lib/check.php");

    $get_var_skki_no 	= $_POST['no_skkoi'];
    $get_var_skki_jenis = $_POST['jenis'];
    $get_var_area_kode 	= $_POST['Area'];
    $get_var_tahun 		= $_POST['tahun'];
    $get_var_skki_nilai = str_replace(",", "", $_POST['var_nilai_skkoi']);
    $get_var_skki_tgl 	= date('Y-m-d', strtotime($_POST['var_tanggal']));
    $get_var_paket		= $_POST['paket'];
    $get_var_keterangan		= $_POST['keterangan'];
    $today 		= date('Y-m-d');
    $username 	= $_SESSION['username'];
    

    /*echo $get_var_skki_no;
    echo $get_var_skki_jenis;
    echo $get_var_area_kode;
    echo $get_var_skki_nilai;
    echo $get_var_skki_tgl;*/


    mysqli_query($mysqli, "START TRANSACTION");
    $sql = "INSERT INTO TB_SKKO_I(SKKI_JENIS,
								SKKI_NO,
								AREA_KODE,
								SKKI_NILAI,
								SKKI_TANGGAL,
								paket_pekerjaan,
								REVISI,
								tahun,
								keterangan,
								update_by,
								update_date)
			VALUES('$get_var_skki_jenis',
					'$get_var_skki_no',
					'$get_var_area_kode',
					$get_var_skki_nilai,
					'$get_var_skki_tgl',
					'$get_var_paket',
					0,
					'$get_var_tahun',
					'$get_var_keterangan',
					'$username',
					'$today'
					)";
    $query = mysqli_query($mysqli, $sql);
    //echo $sql;
    //mysqli_query($mysqli, "COMMIT");
    if ($query==1) {
        echo '<script language="javascript">alert("Input Berhasil")</script>';
        echo '<script language="javascript">window.location = "skkoi_view.php"</script>';
        mysqli_query($mysqli, "COMMIT");
    } else {
        echo '<script language="javascript">alert("Input Gagal, Data PRK sudah terdaftar atau cek penulisan nilai prk")</script>';
        echo '<script language="javascript">window.location = "skkoi_view.php"</script>';
        mysqli_query($mysqli, "ROLLBACK");
    }
