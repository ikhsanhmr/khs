<?php
		session_start();
		include_once("lib/config.php");
		$spj_no = $_POST["var_spj_no"];
		$keterangan = $_POST["keterangan"];
		$foldername = "dokumen/";
		date_default_timezone_set('Asia/Jakarta');
		$date= date('d-m-Y_H_i_s'); 
		mysqli_query($mysqli, "START TRANSACTION");
		
		if (!empty($spj_no)){
			$image = trim(addslashes($foldername.$date.'-'.basename($_FILES['file_dokumen'] ['name'])));
			$image = str_replace(' ', '_', $image);
				(move_uploaded_file($_FILES['file_dokumen']['tmp_name'], $image));
				$perintah = "insert into tb_upload_dok (spj_no, keterangan, file_dok) VALUES ('$spj_no','$keterangan','$image')";
				$resultQuery=mysqli_query($mysqli, $perintah);
			if($resultQuery==1){
				echo '<script language="javascript">alert("Upload Berhasil")</script>';
				echo '<script language="javascript">window.location = "spj_view.php"</script>';
				mysqli_query($mysqli, "COMMIT");
			}else{
				echo '<script language="javascript">alert("Upload Gagal")</script>';
				echo '<script language="javascript">window.location = "spj_view.php"</script>';
				//echo "insert into tb_upload_dok  (spj_no, keterangan, file_dok) VALUES ('$spj_no','$keterangan','$image')";
				mysqli_query($mysqli, "ROLLBACK");
			}	
		}else{
				echo '<script language="javascript">alert("Nomor SPBJ Kosong")</script>';
				echo '<script language="javascript">window.location = "spj_view.php"</script>';
		}
