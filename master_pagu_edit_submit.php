<?php
	session_start();
	include_once("lib/config.php");
	include_once("lib/check.php");

	$vendor_nama 		= $_POST['vendor_nama'];
	$vendor_id	 		= $_POST['vendor_id'];
	$paket_jenis	 	= $_POST['paket_jenis'];
	$var_nilai_pagu	 	= $_POST['var_nilai_pagu'];
	$var_rangking	 	= $_POST['var_rangking'];
	$var_no_pjn	 		= $_POST['var_no_pjn'];
	$var_tgl_pjn	 	= date('Y-m-d',strtotime($_POST['var_tgl_pjn']));
	$var_no_rks	 		= $_POST['var_no_rks'];
	$var_tgl_rks	 	= date('Y-m-d',strtotime($_POST['var_tgl_rks']));
	$var_no_spp	 		= $_POST['var_no_spp'];
	$var_tgl_spp	 	= date('Y-m-d',strtotime($_POST['var_tgl_spp']));
	$var_no_penawaran	= $_POST['var_no_penawaran'];
	$var_tgl_penawaran	 = date('Y-m-d',strtotime($_POST['var_tgl_penawaran']));
	$var_tgl_akhir		 = date('Y-m-d',strtotime($_POST['var_tgl_akhir']));
	
	$today 		= date('Y-m-d');
	$username 	= $_SESSION['username'];
	

	mysqli_query($mysqli, "START TRANSACTION");
	$sql = "UPDATE tb_pagu_kontrak SET RANKING = '$var_rangking', NO_PJN = '$var_no_pjn',
			TGL_PJN = '$var_tgl_pjn', NO_RKS = '$var_no_rks', TGL_RKS='$var_tgl_rks',
			NO_SPP='$var_no_spp', TGL_SPP='$var_tgl_spp', NO_PENAWARAN='$var_no_penawaran',
			TGL_PENAWARAN='$var_tgl_penawaran', TGL_AKHIR='$var_tgl_akhir',
			UPDATE_BY='$username', UPDATE_DATE='$today' WHERE VENDOR_ID = '$vendor_id' AND PAKET_JENIS='$paket_jenis'";
	
	/*echo "UPDATE tb_pagu_kontrak SET RANKING = '$var_rangking', NO_PJN = '$var_no_pjn',
			TGL_PJN = '$var_tgl_pjn', NO_RKS = '$var_no_rks', TGL_RKS='$var_tgl_rks',
			NO_SPP='$var_no_spp', TGL_SPP='$var_tgl_spp', NO_PENAWARAN='$var_no_penawaran',
			TGL_PENAWARAN='$var_tgl_penawaran', TGL_AKHIR='$var_tgl_akhir',
			UPDATE_BY='$username', UPDATE_DATE='$today' WHERE VENDOR_ID = '$vendor_id' AND PAKET_JENIS='$paket_jenis'";*/
	
	//echo $sql;
	$query = mysqli_query($mysqli, $sql);
	
	if($query==1){
			echo '<script language="javascript">alert("Data Pagu Vendor Berhasil Diupdate!")</script>';
			echo '<script language="javascript">window.location = "master_pagu.php"</script>';
		mysqli_query($mysqli, "COMMIT");
		} else {
			echo '<script language="javascript">alert("Data Pagu Vendor Gagal Diupdate!")</script>';
			echo '<script language="javascript">window.location = "master_pagu.php"</script>';
		mysqli_query($mysqli, "ROLLBACK");
		}
	
		/*if($query==1){
			mysqli_query("COMMIT");
			
		}else{
			mysqli_query("ROLLBACK");
		}
		echo '<script language="javascript">window.location = "master_pagu_edit.php?scs=EDIT SUKSES&vendor_id='.$vendor_id.'&paket_jenis='.$paket_jenis.'"</script>';
	 */
