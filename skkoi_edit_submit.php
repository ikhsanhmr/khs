<?php
	session_start();
	include_once("lib/config.php");
	include_once("lib/check.php");

	$get_var_skki_no 	= $_POST['var_skki_no'];
	$get_var_skki_jenis = $_POST['var_skki_jenis'];
	$get_var_area_kode 	= $_POST['var_area_kode'];
	$get_var_skki_nilai = str_replace(",","",$_POST['var_skki_nilai']);
	$get_var_skki_terpakai 	= str_replace(",","",$_POST['var_skki_terpakai']);
	$get_var_skki_tgl 		= date('Y-m-d',strtotime($_POST['var_skki_tgl']));
	$get_var_skki_revisi	= $_POST['var_skki_revisi'];
	$get_var_keterangan		= $_POST['var_keterangan'];
	$today 		= date('Y-m-d');
	$username 	= $_SESSION['username'];
	

	mysqli_query($mysqli, "START TRANSACTION");
	$sql = "UPDATE TB_SKKO_I SET SKKI_JENIS = '$get_var_skki_jenis',AREA_KODE = $get_var_area_kode,
			SKKI_NILAI = $get_var_skki_nilai,SKKI_TANGGAL = '$get_var_skki_tgl', REVISI='$get_var_skki_revisi',
			KETERANGAN='$get_var_keterangan', update_by='$username', update_date='$today' WHERE SKKI_NO = '$get_var_skki_no'";
	//echo $sql;
	$query = mysqli_query($mysqli, $sql);
	
	if($get_var_skki_no==""){
		echo '<script language="javascript">window.location = "skkoi_edit.php?err=NOMOR SKKI/O TIDAK BOLEH KOSONG&skki_no='.$get_var_skki_no.'"</script>';
	}else if($get_var_skki_jenis!="SKKI" and $get_var_skki_jenis!="SKKO"){
		echo '<script language="javascript">window.location = "skkoi_edit.php?err=JENIS SKKI INVALID ( HARUS SKKI / SKKO )&skki_no='.$get_var_skki_no.'"</script>';
	}else if($get_var_area_kode==""){
		echo '<script language="javascript">window.location = "skkoi_edit.php?err=AREA KODE TIDAK BOLEH KOSONG&skki_no='.$get_var_skki_no.'"</script>';
	}else if($get_var_skki_nilai < $get_var_skki_terpakai){
		echo '<script language="javascript">window.location = "skkoi_edit.php?err=NILAI SKKI/O TIDAK BOLEH KECIL DARI NILAI YANG TERPAKAI&skki_no='.$get_var_skki_no.'"</script>';
	}else if($get_var_skki_tgl==""){
		echo '<script language="javascript">window.location = "skkoi_edit.php?err=TANGGAL SKKI/O TIDAK BOLEH KOSONG&skki_no='.$get_var_skki_no.'"</script>';
	}else{
		if($query==1){
			mysqli_query($mysqli, "COMMIT");
			
		}else{
			mysqli_query($mysqli, "ROLLBACK");
		}
		echo '<script language="javascript">window.location = "skkoi_edit.php?scs=EDIT SUKSES&skki_no='.$get_var_skki_no.'"</script>';
	}
