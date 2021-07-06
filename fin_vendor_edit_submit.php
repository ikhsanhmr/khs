<?php
	session_start();
	include_once("lib/config.php");
	include_once("lib/check.php");
	$get_var_vendor_id = $_POST['var_vendor_id'];
	$get_var_rating = $_POST['var_rating'];
	$get_var_fin_limit = str_replace(",","",$_POST['var_fin_limit']);
	$get_var_fin_current = str_replace(",","",$_POST['var_fin_current']);
	
	mysqli_query($mysqli, "START TRANSACTION");
	$query = mysqli_query($mysqli, "UPDATE tb_fin_vendor SET RATING_LAPORAN_AUDIT = '$get_var_rating', FIN_LIMIT = '$get_var_fin_limit'
							WHERE VENDOR_ID = '$get_var_vendor_id'");
	
	if($get_var_rating==""){
		echo '<script language="javascript">window.location = "fin_vendor_edit.php?err=RATING LAPORAN AUDIT TIDAK BOLEH KOSONG&vendor_id='.$get_var_vendor_id.'"</script>';
	}else if($get_var_fin_limit==""){
		echo '<script language="javascript">window.location = "fin_vendor_edit.php?err=FINANSIAL LIMIT TIDAK BOLEH KOSONG&vendor_id='.$get_var_vendor_id.'"</script>';
	}else if($get_var_fin_limit < $get_var_fin_current){
		echo '<script language="javascript">window.location = "fin_vendor_edit.php?err=FINANSIAL LIMIT TIDAK BOLEH LEBIH KECIL DARI FINANSIAL YANG LAGI DIGUNAKAN&vendor_id='.$get_var_vendor_id.'"</script>';
	}else{
		if($query==1){
			mysqli_query($mysqli, "COMMIT");
			
		}else{
			mysqli_query($mysqli, "ROLLBACK");
		}
		echo '<script language="javascript">window.location = "fin_vendor_edit.php?scs=INPUT SUKSES&vendor_id='.$get_var_vendor_id.'"</script>';
	}
?>