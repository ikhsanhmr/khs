<?php
session_start();
include_once("lib/config.php");
include_once("lib/check.php");
include_once("lib/function.php");

$get_var_no_spj 		= $_POST['var_no_spj'];
$get_var_no_addendum 	= $_POST['var_no_addendum'];
$get_target_awal 		= $_POST['target_awal'];
$get_var_nilai_addendum = str_replace(",","",$_POST['var_nilai_addendum']);
$get_var_ppn 				= str_replace(",","",$_POST['ppn']);
$get_var_min_ppn 			= str_replace(",","",$_POST['min_ppn']);

if($_POST["var_tanggal_akhir"]!=null)
	{  $get_var_tanggal_akhir = date('Y-m-d',strtotime($_POST['var_tanggal_akhir'])); }

if ($_POST["ad_var_target"]!=null)
	{ $get_ad_var_target = $_POST['ad_var_target']; }


$get_var_deskripsi 	= $_POST['var_deskripsi'];
$username 			= $_SESSION['username'];

$get_var_tgl_addendum 	= date('Y-m-d',strtotime($_POST['var_tanggal_add']));
$get_var_skki_awal		= $_POST['var_skki_awal'];
$get_var_skki_tujuan	= ($_POST['var_skki_tujuan'] == "" ? "-" : $_POST['var_skki_tujuan']);
mysqli_query("START TRANSACTION");
$spj = mysqli_query("SELECT
	CASE WHEN SPJ_ADD_NILAI  is NULL THEN SPJ_NILAI
		ELSE SPJ_ADD_NILAI									 
		END SPJ_NILAI
	FROM tb_spj WHERE spj_no = '$get_var_no_spj'");
	while($rows=mysqli_fetch_array($spj)){
		$res[]=$rows;
	}

$select_vendor = mysqli_query("SELECT vendor_id, paket_jenis, spj_add_nilai FROM tb_spj where SPJ_NO = '$get_var_no_spj'");
while($rows2=mysqli_fetch_array($select_vendor)){
	$res4[]=$rows2;
}
	$vendor_id = $res4[0][0];
	$paket_jenis = $res4[0][1];
	$spj_nilai_sebelum_adendum = $res4[0][2];
	
	
	$query2 = mysqli_query("select pagu_kontrak, terpakai from tb_pagu_kontrak where vendor_id = '$vendor_id' and paket_jenis = '$paket_jenis'");
    while($roww=mysqli_fetch_array($query2)){
		$res5[]=$roww;
	}
	$pagu_kontrak = $res5[0][0];	
	$current = $res5[0][1];
		

//query finansial vendor
	$select_finansial_vendor = mysqli_query("SELECT fin_limit, fin_current FROM tb_fin_vendor where vendor_id = '$vendor_id'");
	while($rows21=mysqli_fetch_array($select_finansial_vendor)){
		$res41[]=$rows21;
	}
		$fin_limit = $res41[0][0];
		$fin_current = $res41[0][1];
		
	/*$skki = mysqli_query("SELECT b.skki_nilai FROM tb_spj a, tb_skko_i b WHERE a.skki_no = b.skki_no AND a.spj_no = '$get_var_no_spj'");
	while($rows2=mysqli_fetch_array($skki)){
		$res2[]=$rows2;
	}*/
	
	$skki_terpakai = mysqli_query("SELECT skki_terpakai, skki_nilai FROM tb_skko_i WHERE skki_no = '$get_var_skki_tujuan'");
	while($rows=mysqli_fetch_array($skki_terpakai)){
								$skki[]=$rows;
							} 
	 
		
	$tgl_akhir = mysqli_query("SELECT 
		CASE WHEN SPJ_ADD_TANGGAL is NULL THEN SPJ_TANGGAL_AKHIR
			ELSE SPJ_ADD_TANGGAL							 
			END SPJ_ADD_TANGGAL
		FROM tb_spj WHERE spj_no = '$get_var_no_spj'");
		while($rows3=mysqli_fetch_array($tgl_akhir)){
			$res3[]=$rows3;
		}
	
$nilai_spj = $res[0][0];
if($get_var_nilai_addendum==""){
	$get_var_nilai_addendum=0;
}
if($get_var_no_spj==""){
	echo '<script language="javascript">alert("nomor spj harus di pilih")</script>';
	echo '<script language="javascript">window.location = "inp_addendum.php"</script>';
}else if($get_var_no_addendum==""){
	echo '<script language="javascript">alert("nomor addendum harus di isi")</script>';
	echo '<script language="javascript">window.location = "inp_addendum.php"</script>';

}else if($get_var_nilai_addendum==0 && $get_var_tanggal_akhir=="" && $get_var_skki_tujuan=="-" && $get_ad_var_target==""){
	echo '<script language="javascript">alert("nilai addendum / tanggal akhir / SKKI Tujuan / Target Volume Adendum harus di isi")</script>';
	echo '<script language="javascript">window.location = "inp_addendum.php"</script>';
}else if($get_var_deskripsi==""){
	echo '<script language="javascript">alert("deskripsi harus di isi")</script>';
	echo '<script language="javascript">window.location = "inp_addendum.php"</script>';
//}else if($get_var_nilai_addendum >$res2[0][0]){
}else if((($skki[0][0]+$get_var_nilai_addendum) > $skki[0][1]) and ($get_var_skki_tujuan != '-')){
	echo '<script language="javascript">alert("nilai addendum melebihi nilai SKKI/O")</script>';
	echo '<script language="javascript">window.location = "inp_addendum.php"</script>';
//buka bentar untuk buka adendum dengan tanggal adendum mundur, request UPK 
	//}else if($get_var_tanggal_akhir != null and strtotime($get_var_tanggal_akhir) < strtotime($res3[0][0])){
	//echo '<script language="javascript">alert("tanggal addendum harus lebih besar dari tanggal akhir")</script>';
	//echo '<script language="javascript">window.location = "inp_addendum.php"</script>';
}else if(($current - $spj_nilai_sebelum_adendum + $get_var_nilai_addendum)>=$pagu_kontrak){
	echo '<script language="javascript">alert("nilai adendum spj lebih dari nilai pagu kontrak")</script>';
	echo '<script language="javascript">window.location = "inp_addendum.php"</script>';
}else if(($fin_current - $spj_nilai_sebelum_adendum + $get_var_nilai_addendum)>=$fin_limit){
	echo '<script language="javascript">alert("nilai adendum spj lebih dari finansial vendor")</script>';
	echo '<script language="javascript">window.location = "inp_addendum.php"</script>';
}else{
	$insert_tb_add = "INSERT INTO tb_addendum (
									ADDENDUM_NO,
									SPJ_NO,
									ADDENDUM_NILAI,
									ADDENDUM_TANGGAL_AKHIR,
									ADDENDUM_DESKRIPSI,
									ADDENDUM_INPUT_DATE,
									ADDENDUM_INPUT_USER,
									TGL_ADDENDUM, 
									ADENDUM_TARGET,
									TARGET_AWAL)
					VALUES ('$get_var_no_addendum',
							'$get_var_no_spj',
							$get_var_nilai_addendum,
							'$get_var_tanggal_akhir',
							'$get_var_deskripsi',
							CURDATE(),
							'$username',
							'$get_var_tgl_addendum',
							'$get_ad_var_target',
							'$get_target_awal')";


$update_fin_vendor = "UPDATE tb_fin_vendor a, tb_vendor b, tb_spj c SET a.fin_current = a.fin_current + ($get_var_nilai_addendum - $nilai_spj)
					WHERE a.vendor_id = b.vendor_id
					AND b.vendor_id = c.vendor_id
					AND c.spj_no = '$get_var_no_spj'";

$update_skki_terpakai = "UPDATE tb_skko_i a, tb_spj b SET a.skki_terpakai = a.skki_terpakai + ($get_var_nilai_addendum - $nilai_spj)
					WHERE a.skki_no = b.skki_no
					AND b.spj_no = '$get_var_no_spj'";
					
$update_pagu_terpakai = "UPDATE tb_pagu_kontrak SET TERPAKAI = ($current - $spj_nilai_sebelum_adendum + $get_var_nilai_addendum) WHERE vendor_id = $vendor_id and PAKET_JENIS = $paket_jenis";					

$update_nilai_add = "UPDATE tb_spj SET spj_add_nilai = $get_var_nilai_addendum, PPN = $get_var_ppn , MIN_PPN = $get_var_min_ppn  WHERE SPJ_NO = '$get_var_no_spj'";
$update_tanggal_akhir = "UPDATE tb_spj SET SPJ_ADD_TANGGAL = '$get_var_tanggal_akhir' WHERE SPJ_NO = '$get_var_no_spj'";
//nambah untuk tanggal surat spj ketika di adendum
//ubah ni..
$update_tanggal_addendum = "UPDATE tb_spj SET tanggal_addendum = '$get_var_tgl_addendum' WHERE SPJ_NO = '$get_var_no_spj'";
$update_adendum_target = "UPDATE tb_spj SET SPJ_TARGET='$get_ad_var_target', SPJ_TARGET_AWAL='$get_target_awal' WHERE SPJ_NO = '$get_var_no_spj'";
$res_insert_tb_add = mysqli_query($insert_tb_add);	

if($get_var_tanggal_akhir=="" && $get_var_nilai_addendum!=0 && $get_ad_var_target==""){
	//$res_insert_tb_add = mysqli_query($insert_tb_add);
	$res_update_fin_vendor = mysqli_query($update_fin_vendor);
	$res_update_skki_terpakai = mysqli_query($update_skki_terpakai);
	$res_update_nilai_add = mysqli_query($update_nilai_add);
	$res_update_tanggal_akhir = 1;
	$res_update_target_volume = 1;//ditambah 27 juli 2018
	$res_update_pagu_terpakai = mysqli_query($update_pagu_terpakai);
	
}else if($get_var_tanggal_akhir!="" && $get_var_nilai_addendum==0 && $get_ad_var_target!=""){
	//$res_insert_tb_add = mysqli_query($insert_tb_add);;
	$res_update_fin_vendor = 1;
	$res_update_skki_terpakai = 1;
	$res_update_nilai_add = 1;
	$res_update_tanggal_akhir = mysqli_query($update_tanggal_akhir);
	$res_update_tanggal_awal = mysqli_query($update_tanggal_addendum);
	$res_update_target_volume = mysqli_query($update_adendum_target);
	$res_update_pagu_terpakai =1;
}else if($get_var_tanggal_akhir!="" && $get_var_nilai_addendum!=0 && $get_ad_var_target!=""){
	//$res_insert_tb_add = mysqli_query($insert_tb_add);
	$res_update_fin_vendor = mysqli_query($update_fin_vendor);
	$res_update_skki_terpakai = mysqli_query($update_skki_terpakai);
	$res_update_nilai_add = mysqli_query($update_nilai_add);
	$res_update_tanggal_akhir = mysqli_query($update_tanggal_akhir);
	$res_update_tanggal_awal = mysqli_query($update_tanggal_addendum);
	$res_update_target_volume = mysqli_query($update_adendum_target);
	$res_update_pagu_terpakai = mysqli_query($update_pagu_terpakai);
}
		

if($get_var_skki_tujuan != '-')
{

	$GET_NILAI_ADD_DB =select_nilai_adds($get_var_no_spj);
	$nilai_add_DB = $GET_NILAI_ADD_DB[0][0];
	//echo $nilai_add_DB;

	$update_skki_spj = "UPDATE tb_spj SET SKKI_NO = '$get_var_skki_tujuan' where spj_no = '$get_var_no_spj'";

	$update_nilai_skki_awal = "UPDATE tb_skko_i SET skki_terpakai = skki_terpakai - '$nilai_add_DB'
					WHERE skki_no = '$get_var_skki_awal'";

	$update_nilai_skki_tujuan = "UPDATE tb_skko_i SET skki_terpakai = skki_terpakai + '$nilai_add_DB'
					WHERE skki_no = '$get_var_skki_tujuan'";

	/*echo $update_skki_spj;
	echo $update_nilai_skki_awal;
	echo $update_nilai_skki_tujuan;*/
	mysqli_query($update_nilai_skki_awal);
	mysqli_query($update_nilai_skki_tujuan);
	mysqli_query($update_skki_spj);
	$res_update_fin_vendor = 1;
	$res_update_skki_terpakai = 1;
	$res_update_nilai_add = 1;
	$res_update_tanggal_akhir = 1;
	$res_update_tanggal_awal = 1;
	$res_update_target_volume = 1;
	$res_update_pagu_terpakai =1;
}

//echo $res_insert_tb_add;
/*echo $insert_tb_add;
echo $res_update_tanggal_akhir;
echo $res_update_fin_vendor;
echo $res_update_skki_terpakai;
echo $res_update_nilai_add*/;


if($res_insert_tb_add==1 && $res_update_fin_vendor==1 && $res_update_skki_terpakai==1 && $res_update_nilai_add==1 && $res_update_tanggal_akhir==1 && $res_update_target_volume==1 && $res_update_pagu_terpakai ==1){
	echo '<script language="javascript">alert("Berhasil")</script>';
	echo '<script language="javascript">window.open("addendum_print.php?id='.$get_var_no_spj.'")</script>';
	echo '<script language="javascript">window.location = "inp_addendum.php"</script>';
	mysqli_query("COMMIT");
	/*echo "pagu sekarang ".$current;
	echo "<br>";
	echo "spj sebelum ".$spj_nilai_sebelum_adendum; 
	echo "<br>";
	echo "spj adendum ".$get_var_nilai_addendum;
	echo "<br>";
	echo "pagu kontrak ".$pagu_kontrak;*/
	
}else{
	echo '<script language="javascript">alert("Gagal, cek nomor adendum apakah ada yang sama!")</script>';
	echo '<script language="javascript">window.location = "inp_addendum.php"</script>';
	mysqli_query("ROLLBACK");
	}
}

?>