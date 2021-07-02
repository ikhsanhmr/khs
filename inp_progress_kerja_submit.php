<?php
	session_start();
	include_once("lib/config.php");
	$get_var_no_spj 		= $_POST['var_no_spj'];
	$get_var_progress 		= $_POST['var_progress'];
	$get_var_realisasi 		= $_POST['var_realisasi'];
	$get_var_tanggal 		= date('Y-m-d',strtotime($_POST['var_tanggal']));
	$get_var_nama_pengawas 	= $_POST['var_nama_pengawas'];
	$get_var_deskripsi 		= $_POST['var_deskripsi'];
	$no_tug9 				= $_POST['no_tug9'];
	$tgl_tug9 				= $_POST['tgl_tug9'];
	$no_tug10 				= $_POST['no_tug10'];
	$tgl_tug10 				= $_POST['tgl_tug10'];
	$current_date 			= date('Y-m-d');
	$username 				= $_SESSION['username'];
	
	mysqli_query("START TRANSACTION");
	$q = "select max(progress_value) from tb_progress where spj_no = '$get_var_no_spj'";
	$result = mysqli_query($q);
	while ($rows=mysqli_fetch_row($result)){ 
		$data[] = $rows;
	}
	
	if($get_var_no_spj==""){
		echo '<script language="javascript">alert("nomor spj harus di pilih")</script>';
		echo '<script language="javascript">window.location = "inp_progress_kerja.php"</script>';
	}else if($get_var_progress==""){
		echo '<script language="javascript">alert("progress pekerjaan harus di isi")</script>';
		echo '<script language="javascript">window.location = "inp_progress_kerja.php"</script>';
	}else if(is_numeric($get_var_progress)==false and $get_var_progress>100 and $get_var_progress<0){
		echo '<script language="javascript">alert("progress harus numerik [1 - 100]")</script>';
		echo '<script language="javascript">window.location = "inp_progress_kerja.php"</script>';
	}else if($get_var_progress < $data[0][0]){
		echo '<script language="javascript">alert("progress pekerjaan terakhir sudah '.$data[0][0].'%")</script>';
		echo '<script language="javascript">window.location = "inp_progress_kerja.php"</script>';
	}else if($data[0][0]==100){
		echo '<script language="javascript">alert("progress sudah 100%")</script>';
		echo '<script language="javascript">window.location = "inp_progress_kerja.php"</script>';
	}else if($get_var_tanggal==""){
		echo '<script language="javascript">alert("tanggal input harus di pilih")</script>';
		echo '<script language="javascript">window.location = "inp_progress_kerja.php"</script>';
	}else if($get_var_nama_pengawas==""){
		echo '<script language="javascript">alert("nama pengawas harus di isi")</script>';
		echo '<script language="javascript">window.location = "inp_progress_kerja.php"</script>';
	}else if($get_var_deskripsi==""){
		echo '<script language="javascript">alert("komentar harus di isi")</script>';
		echo '<script language="javascript">window.location = "inp_progress_kerja.php"</script>';
	}else{
		$query = "insert into tb_progress (	
											SPJ_NO,
											PROGRESS_DATE,
											PROGRESS_PENGAWAS,
											PROGRESS_NOTES,
											PROGRESS_VALUE,
											REALISASI,
											INPUT_PROGRESS_DATE,
											PROGRESS_INPUT_USER,
											NO_TUG9,
											TGL_TUG9,
											NO_TUG10,
											TGL_TUG10) 
									values 
											('$get_var_no_spj',
											'$get_var_tanggal',
											'$get_var_nama_pengawas', 
											'$get_var_deskripsi', 
											$get_var_progress, 
											$get_var_realisasi,
											'$current_date',
											'$username',
											'$no_tug9',
											'$tgl_tug9',
											'$no_tug10',
											'$tgl_tug10')";
		$resultQuery=mysqli_query($query);
		if($resultQuery==1){
			echo '<script language="javascript">alert("Input Berhasil")</script>';
			echo '<script language="javascript">window.location = "inp_progress_kerja.php"</script>';
			mysqli_query("COMMIT");
		}else{
			echo '<script language="javascript">alert("Input Gagal")</script>';
			echo '<script language="javascript">window.location = "inp_progress_kerja.php"</script>';
			mysqli_query("ROLLBACK");
		}
	}
?>