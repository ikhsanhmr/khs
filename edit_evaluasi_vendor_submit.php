<?php
		session_start();
		include_once("lib/config.php");
		include_once('lib/head.php');
		include_once("lib/check.php");
		
		$isi_id = $_POST["isi_id"];
		$no_spj = $_POST["no_spj"];
		$isi_nilai = $_POST["isi_nilai"];
		$isi_bobot = $_POST["isi_bobot"];
		$isi_id_deskripsi = $_POST["isi_id_deskripsi"];
		
		//$isi_score = $_POST["isi_score"];
		
		$tgl_spbj = $_POST["tgl_spbj"];
		$pengawas_lap = $_POST["pengawas_lap"];
		$tgl_bastp = date('Y-m-d',strtotime($_POST['tgl_bastp']));
		
		if($tgl_bastp<=$tgl_spbj){
			echo '<script language="javascript">alert("tanggal bastp harus lebih besar dari tanggal kontrak spbj!")</script>';
			echo "<script language='javascript'>window.location = 'isi_evaluasi_vendor.php?&no_spj=$no_spj'</script>";
		}else{
		
		$simp1 = mysqli_query ("DELETE from penilaian_nilai where spj_no='$no_spj'");					
		$simp11 = mysqli_query("UPDATE tb_spj set tgl_bastp='$tgl_bastp', pengawas_lap='$pengawas_lap' where spj_no='$no_spj'");
			
		foreach($isi_id as $i => $task) {
	
		$simp2= mysqli_query("INSERT INTO penilaian_nilai (id_kriteria, spj_no, nilai,bobot, id_deskripsi) 
				VALUES ('$task', '$no_spj', '$isi_nilai[$i]', '$isi_bobot[$i]','$isi_id_deskripsi[$i]')");
}
		$simp3 = mysqli_query("UPDATE tb_termin set verifikasi_mb=0, verifikasi_mup3=0 where spj_no='$no_spj'");	
		
	if(($simp1==1) and ($simp2==1) and ($simp3==1) and ($simp11==1)){
				echo '<script language="javascript">alert("Evaluasi Berhasil Diupdate")</script>';
				echo "<script language='javascript'>window.location = 'lihat_evaluasi_vendor.php?&no_spj=$no_spj'</script>";
				mysqli_query("COMMIT");
			}else{
				echo '<script language="javascript">alert("Evaluasi Gagal Disimpan")</script>';
				echo "<script language='javascript'>window.location = 'lihat_evaluasi_vendor.php?&no_spj=$no_spj'</script>";
				/*echo ("INSERT INTO penilaian_nilai (id_kriteria, spj_no, nilai,bobot) 
				VALUES ('$task', '$no_spj', '$isi_nilai[$i]', '$isi_bobot[$i]')");;*/
				mysqli_query("ROLLBACK");
			}
		}
?>