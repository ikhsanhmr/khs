<?php
	session_start();
	include_once("lib/config.php");
	include_once("lib/check.php");
	$get_var_spj_no = $_POST['var_spj_no'];
	$get_var_spj_nilai = str_replace(",","",$_POST['var_spj_nilai']);
	$get_var_spj_tanggal_mulai = date('Y-m-d',strtotime($_POST['var_mulai_berlaku']));
	$get_var_spj_tanggal_akhir = date('Y-m-d',strtotime($_POST['var_akhir_berlaku']));

	$get_var_ppn 				= str_replace(",","",$_POST['ppn']);
	$get_var_min_ppn 			= str_replace(",","",$_POST['min_ppn']);
	

	mysqli_query($mysqli, "START TRANSACTION");
	
	$q = mysqli_query($mysqli, "SELECT spj_no,spj_nilai,spj_add_nilai,vendor_id,skki_no,PAKET_JENIS FROM tb_spj WHERE spj_no = '$get_var_spj_no'");
	while($rows=mysqli_fetch_row($q)){
		$data[]=$rows;
	}

	$vendor_id = $data[0][3];
	$skki_no = $data[0][4];
	$add_nilai = $data[0][2];
	$spj_nilai = $data[0][1];
	$paket_jenis = $data[0][5];
	
	$fin_curr_Q = mysqli_query($mysqli, "SELECT fin_limit, fin_current FROM tb_fin_vendor WHERE vendor_id = $vendor_id");
	while($rows3=mysqli_fetch_row($fin_curr_Q)){
		$data_fin_vendor[] = $rows3;
	}

	$fin_limit = $data_fin_vendor[0][0];
	$fin_current = $data_fin_vendor[0][1];

	$query2a = mysqli_query($mysqli, "select pagu_kontrak, terpakai from tb_pagu_kontrak where vendor_id = '$vendor_id' and paket_jenis = '$paket_jenis'");
	//echo "select pagu_kontrak, terpakai from tb_pagu_kontrak where vendor_id = '$vendor_id' and paket_jenis = '$paket_jenis'";
    while($roww=mysqli_fetch_array($query2a)){
		$res5[]=$roww;
	}
	$pagu_kontrak = $res5[0][0];	
	$current = $res5[0][1];

	$skki_Q = mysqli_query($mysqli, "SELECT skki_nilai,skki_terpakai FROM tb_skko_i WHERE skki_no = '$skki_no'");
	while($rows4=mysqli_fetch_row($skki_Q)){
		$data_skki[] = $rows4;
	}
	$skkoi_nilai = $data_skki[0][0];
	$skkoi_terpakai = $data_skki[0][1];
		
	$jlh_pembayaran_Q = mysqli_query($mysqli, "SELECT COALESCE(sum(pembayaran_nominal),0) FROM tb_pembayaran WHERE spj_no = '$get_var_spj_no'");
	while($rows2=mysqli_fetch_row($jlh_pembayaran_Q)){
		$data2[]=$rows2;
	}
	$ttl_pembayaran = $data2[0][0];
	
	$add_exist = mysqli_query($mysqli, "SELECT * FROM TB_ADDENDUM WHERE SPJ_NO = '$get_var_spj_no'");
	while($rows5=mysqli_fetch_row($add_exist)){
		$isexist[]=$rows5;
	}

	if($isexist != null){
		$edit_variable = "spj_add_nilai";
		$update_add = mysqli_query($mysqli, "UPDATE TB_ADDENDUM SET addendum_nilai = $get_var_spj_nilai WHERE spj_no = '$get_var_spj_no' AND addendum_nilai = $add_nilai");
		$diff = $get_var_spj_nilai - $add_nilai;
		

	}else{
		$edit_variable2 = "spj_add_tanggal";
		$edit_variable = "spj_nilai";
		$edit_variable2 = "spj_tanggal_akhir";
		$update_add = mysqli_query($mysqli, "UPDATE tb_spj SET spj_add_nilai = $get_var_spj_nilai WHERE spj_no = '$get_var_spj_no'");
		$diff = $get_var_spj_nilai - $data[0][1];
	}
	
	$query = mysqli_query($mysqli, "UPDATE tb_spj SET $edit_variable = $get_var_spj_nilai WHERE SPJ_NO = '$get_var_spj_no'") or die("MySQL error:".mysqli_error($mysqli));
	$query2 = mysqli_query($mysqli, "UPDATE tb_fin_vendor SET fin_current = fin_current + $diff WHERE vendor_id = $vendor_id");
	$query3 = mysqli_query($mysqli, "UPDATE tb_skko_i SET skki_terpakai = skki_terpakai + $diff WHERE skki_no = '$skki_no'");
	$query4 = mysqli_query($mysqli, "UPDATE tb_pagu_kontrak SET terpakai = terpakai + $diff WHERE vendor_id = $vendor_id and PAKET_JENIS = (SELECT PAKET_JENIS from tb_spj where SPJ_NO = '$get_var_spj_no')");
	$query5 = mysqli_query($mysqli, "UPDATE tb_spj SET PPN = $get_var_ppn, MIN_PPN = $get_var_min_ppn WHERE SPJ_NO = '$get_var_spj_no'") or die("MySQL error:".mysqli_error($mysqli));
	if($get_var_spj_nilai==""){
		echo '<script language="javascript">window.location = "spj_edit.php?err=SPJ NILAI TIDAK BOLEH KOSONG&spj_no='.$get_var_spj_no.'"</script>';
	}else if($get_var_spj_nilai<$ttl_pembayaran){
		echo '<script language="javascript">window.location = "spj_edit.php?err=SPJ NILAI KURANG DARI NILAI YANG SUDAH BAYAR&spj_no='.$get_var_spj_no.'"</script>';
	}else if( ($fin_limit < ($get_var_spj_nilai + $fin_current - $spj_nilai)) AND ($vendor_id != 106) ){
			echo '<script language="javascript">window.location = "spj_edit.php?err=SPJ NILAI LEBIH DARI FINANSIAL VENDOR&spj_no='.$get_var_spj_no.'"</script>';
	}else if($skkoi_nilai < $skkoi_terpakai + ($get_var_spj_nilai - $skkoi_terpakai)){
		echo '<script language="javascript">window.location = "spj_edit.php?err=SPJ NILAI LEBIH DARI BATAS SKKO/I&spj_no='.$get_var_spj_no.'"</script>';
	}else if(($current - $add_nilai + $get_var_spj_nilai)>=$pagu_kontrak){
				/*echo $current;
				echo "<br/>";
				echo $add_nilai;
				echo "<br/>";
				echo $get_var_spj_nilai;		
				echo "<br/>";
				echo $pagu_kontrak;*/
			echo '<script language="javascript">window.location = "spj_edit.php?err=SPJ NILAI LEBIH DARI PAGU KONTRAK VENDOR&spj_no='.$get_var_spj_no.'"</script>';
	
	}else if($get_var_spj_tanggal_mulai==null or $get_var_spj_tanggal_akhir==null){
		echo '<script language="javascript">window.location = "spj_edit.php?err=TANGGAL TIDAK BOLEH KOSONG&spj_no='.$get_var_spj_no.'"</script>';
	}else if($get_var_spj_tanggal_mulai>$get_var_spj_tanggal_akhir){
		echo '<script language="javascript">window.location = "spj_edit.php?err=TANGGAL MULAI LEBIH DARI TANGGAL AKHIR&spj_no='.$get_var_spj_no.'"</script>';
	}else{

		if($query==1 and $query2==1 and $query3==1 and $update_add==1 and $query4==1 and $query5==1){
			mysqli_query($mysqli, "COMMIT");
			echo "OK";
		}else{
			mysqli_query($mysqli, "ROLLBACK");
			echo "GAGAL";
		}
		echo '<script language="javascript">window.location = "spj_edit.php?scs=EDIT SUKSES&spj_no='.$get_var_spj_no.'"</script>';
	}
