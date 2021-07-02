<?php
session_start();
include_once("lib/config.php");
include_once("lib/check.php");
include_once("lib/function.php");

$get_var_no_spj 		= $_POST['var_no_spj'];
$get_var_no_addendum 	= $_POST['var_no_addendum'];
$get_var_nilai_addendum = str_replace(",","",$_POST['var_nilai_addendum']);
$get_var_ppn 				= str_replace(",","",$_POST['ppn']);
$get_var_min_ppn 			= str_replace(",","",$_POST['min_ppn']);

if($_POST["var_tanggal_akhir"]!=null)
	{  $get_var_tanggal_akhir = date('Y-m-d',strtotime($_POST['var_tanggal_akhir'])); }
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
		
$skki = mysqli_query("SELECT b.skki_nilai FROM tb_spj a, tb_skko_i b WHERE a.skki_no = b.skki_no AND a.spj_no = '$get_var_no_spj'");
while($rows2=mysqli_fetch_array($skki)){
	$res2[]=$rows2;
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

}else if($get_var_nilai_addendum==0 && $get_var_tanggal_akhir=="" && $get_var_skki_tujuan=="-"){
	echo '<script language="javascript">alert("nilai addendum / tanggal akhir / SKKI Tujuan	 harus di isi")</script>';
	echo '<script language="javascript">window.location = "inp_addendum.php"</script>';
}else if($get_var_deskripsi==""){
	echo '<script language="javascript">alert("deskripsi harus di isi")</script>';
	echo '<script language="javascript">window.location = "inp_addendum.php"</script>';
}else if($get_var_nilai_addendum >$res2[0][0]){
	echo '<script language="javascript">alert("nilai addendum melebihi nilai SKKI/O")</script>';
	echo '<script language="javascript">window.location = "inp_addendum.php"</script>';
}else if($get_var_tanggal_akhir != null and strtotime($get_var_tanggal_akhir) < strtotime($res3[0][0])){
	echo '<script language="javascript">alert("tanggal addendum harus lebih besar dari tanggal akhir")</script>';
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
									TGL_ADDENDUM)
					VALUES ('$get_var_no_addendum',
							'$get_var_no_spj',
							$get_var_nilai_addendum,
							'$get_var_tanggal_akhir',
							'$get_var_deskripsi',
							CURDATE(),
							'$username',
							'$get_var_tgl_addendum')";


$update_fin_vendor = "UPDATE tb_fin_vendor a, tb_vendor b, tb_spj c SET fin_current = fin_current + ($get_var_nilai_addendum - $nilai_spj)
					WHERE a.vendor_id = b.vendor_id
					AND b.vendor_id = c.vendor_id
					AND c.spj_no = '$get_var_no_spj'";

$update_skki_terpakai = "UPDATE tb_skko_i a, tb_spj b SET skki_terpakai = skki_terpakai + ($get_var_nilai_addendum - $nilai_spj)
					WHERE a.skki_no = b.skki_no
					AND b.spj_no = '$get_var_no_spj'";

$update_nilai_add = "UPDATE tb_spj SET spj_add_nilai = $get_var_nilai_addendum, PPN = $get_var_ppn , MIN_PPN = $get_var_min_ppn  WHERE SPJ_NO = '$get_var_no_spj'";
$update_tanggal_akhir = "UPDATE tb_spj SET SPJ_ADD_TANGGAL = '$get_var_tanggal_akhir' WHERE SPJ_NO = '$get_var_no_spj'";
$res_insert_tb_add = mysqli_query($insert_tb_add);	
if($get_var_tanggal_akhir=="" && $get_var_nilai_addendum!=0){
	//$res_insert_tb_add = mysqli_query($insert_tb_add);
	$res_update_fin_vendor = mysqli_query($update_fin_vendor);
	$res_update_skki_terpakai = mysqli_query($update_skki_terpakai);
	$res_update_nilai_add = mysqli_query($update_nilai_add);
	$res_update_tanggal_akhir = 1;
}else if($get_var_tanggal_akhir!="" && $get_var_nilai_addendum==0){
	//$res_insert_tb_add = mysqli_query($insert_tb_add);;
	$res_update_fin_vendor = 1;
	$res_update_skki_terpakai = 1;
	$res_update_nilai_add = 1;
	$res_update_tanggal_akhir = mysqli_query($update_tanggal_akhir);
}else if($get_var_tanggal_akhir!="" && $get_var_nilai_addendum!=0){
	//$res_insert_tb_add = mysqli_query($insert_tb_add);
	$res_update_fin_vendor = mysqli_query($update_fin_vendor);
	$res_update_skki_terpakai = mysqli_query($update_skki_terpakai);
	$res_update_nilai_add = mysqli_query($update_nilai_add);
	$res_update_tanggal_akhir = mysqli_query($update_tanggal_akhir);
}
		

if($get_var_skki_tujuan != '-')
{

	$GET_NILAI_ADD_DB =select_nilai_add($get_var_no_spj);
	$nilai_add_DB = $GET_NILAI_ADD_DB[0][0];
	//echo $nilai_add_DB;

	$update_skki_spj = "UPDATE tb_spj SET SKKI_NO = '$get_var_skki_tujuan' where spj_no = '$get_var_no_spj'";



	$update_nilai_skki_awal = "UPDATE tb_skko_i SET skki_terpakai = skki_terpakai - $nilai_add_DB
					WHERE skki_no = '$get_var_skki_awal'";

	$update_nilai_skki_tujuan = "UPDATE tb_skko_i SET skki_terpakai = skki_terpakai + $nilai_add_DB
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
}

//echo $res_insert_tb_add;
/*echo $insert_tb_add;
echo $res_update_tanggal_akhir;
echo $res_update_fin_vendor;
echo $res_update_skki_terpakai;
echo $res_update_nilai_add*/;



if($res_insert_tb_add==1 && $res_update_fin_vendor==1 && $res_update_skki_terpakai==1 && $res_update_nilai_add==1 && $res_update_tanggal_akhir==1){
	echo '<script language="javascript">alert("Berhasil")</script>';
	echo '<script language="javascript">window.open("addendum_print.php?id='.$get_var_no_spj.'")</script>';
	echo '<script language="javascript">window.location = "inp_addendum.php"</script>';
	mysqli_query("COMMIT");
	//$subject = '[KHS] Notifikasi Amandemen SPJ';
	mail_sent($no_spj, $subject,"amandemen");
}else{
	echo '<script language="javascript">alert("Gagal")</script>';
	echo '<script language="javascript">window.location = "inp_addendum.php"</script>';
	mysqli_query("ROLLBACK");
	}
}

?>