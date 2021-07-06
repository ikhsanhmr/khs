<?php
session_start();
$_SESSION['download'] = true;
include_once('lib/head.php');
include_once("lib/check.php");
include_once("lib/mail.php");

$area_kode					= $_SESSION['area'];
$get_var_nama_manager 		= $_POST['var_nama_manager'];
$get_var_dir_vendor 		= $_POST['var_dir_vendor'];
$get_var_no_skkio 			= $_POST['var_no_skkio'];
$get_var_paket_pekerjaan 	= $_POST['var_paket_pekerjaan'];
$get_var_vendor 			= $_POST['var_vendor'];
$get_var_deskripsi_pekerjaan = $_POST['var_deskripsi_pekerjaan'];
$get_var_no_spj 			= $_POST['var_no_spj'];
$get_var_nilai_spj 			= str_replace(",", "", $_POST['var_nilai_spj']);
$get_var_target 			= $_POST['var_target'];
$get_var_mulai_berlaku 		= date('Y-m-d', strtotime($_POST['var_mulai_berlaku']));
$get_var_akhir_berlaku 		= date('Y-m-d', strtotime($_POST['var_akhir_berlaku']));
$get_var_ganggguan			= $_POST['gangguan'];
$get_var_ppn 				= str_replace(",", "", $_POST['ppn']);
$get_var_min_ppn 			= str_replace(",", "", $_POST['min_ppn']);

$get_var_dir_pkj 		= $_POST['var_dir_pkj'];
$get_var_dir_lpg 		= $_POST['var_dir_lpg'];

$get_var_no_pjn		= $_POST['var_no_pjn'];
$get_var_tgl_pjn 	= $_POST['var_tgl_pjn'];

$get_var_metode_bayar	= $_POST['option_bayar'];
//if($get_var_metode_bayar == '0')
if ($get_var_metode_bayar == '1') {
	$get_var_termin_1	= $_POST['var_termin_1'];
	$get_var_termin_2 	= $_POST['var_termin_2'];
	$get_var_termin_3 	= $_POST['var_termin_3'];
	$get_var_termin_4 	= $_POST['var_termin_4'];
	$get_var_termin_5 	= $_POST['var_termin_5'];
}

$today 		= date('Y-m-d');
$username 	= $_SESSION['username'];

if ($get_var_paket_pekerjaan == 1) {
	$check = mysqli_query($mysqli, "select a.vendor_id from tb_fin_vendor a,tb_mapping_vendor b where a.vendor_id = b.vendor_id and a.vendor_id=$get_var_vendor and b.area_kode=$area_kode and b.paket_jenis=$get_var_paket_pekerjaan");
	$check_res = mysqli_fetch_array($check);
	if ($check_res[0][0] == "") {
		$get_var_paket_pekerjaan = 2;
	}
}

mysqli_query($mysqli, "START TRANSACTION");
$fin_current = mysqli_query($mysqli, "SELECT fin_limit, fin_current FROM tb_fin_vendor WHERE vendor_id = $get_var_vendor");
while ($rows = mysqli_fetch_array($fin_current)) {
	$data[] = $rows;
}
$skki_terpakai = mysqli_query($mysqli, "SELECT skki_terpakai, skki_nilai FROM tb_skko_i WHERE skki_no = '$get_var_no_skkio'");
while ($rows = mysqli_fetch_array($skki_terpakai)) {
	$skki[] = $rows;
}


//penambahan 10 Oktober 2018
//$query = "select pagu_kontrak from tb_pagu_kontrak where vendor_id = '$get_var_vendor' and paket_jenis = '$get_var_paket_pekerjaan' ";
$query = "select * from tb_pagu_kontrak where vendor_id = '$get_var_vendor' and paket_jenis = '$get_var_paket_pekerjaan' ";
$resultQuery = mysqli_query($mysqli, $query);
$row = mysqli_fetch_array($resultQuery);
$pagu_kontrak = $row['PAGU_KONTRAK'];
$terpakai = $row['TERPAKAI'];
$sisa_pagu_kontrak = $pagu_kontrak - $terpakai;

$query = "SELECT sum(SPJ_ADD_NILAI) as total_spj FROM `tb_spj` where VENDOR_ID = $get_var_vendor and PAKET_JENIS = $get_var_paket_pekerjaan";
$resultQuery = mysqli_query($mysqli, $query);
$row = mysqli_fetch_array($resultQuery);
$current = $row['total_spj'];

if ($get_var_nama_manager == "") {
	echo '<script language="javascript">alert("nama manager tidak boleh kosong")</script>';
	echo '<script language="javascript">window.location = "seleksi_vendor.php"</script>';
} else if ($get_var_no_skkio == "") {
	echo '<script language="javascript">alert("nomor skki/o harus di pilih")</script>';
	echo '<script language="javascript">window.location = "seleksi_vendor.php"</script>';
} else if ($get_var_paket_pekerjaan == "") {
	echo '<script language="javascript">alert("paket pekerjaan harus di pilih")</script>';
	echo '<script language="javascript">window.location = "seleksi_vendor.php"</script>';
} else if ($get_var_vendor == "") {
	echo '<script language="javascript">alert("vendor harus di pilih")</script>';
	echo '<script language="javascript">window.location = "seleksi_vendor.php"</script>';
} else if ($get_var_deskripsi_pekerjaan == "") {
	echo '<script language="javascript">alert("deskripsi pekerjaan tidak boleh kosong")</script>';
	echo '<script language="javascript">window.location = "seleksi_vendor.php"</script>';
} else if ($get_var_no_spj == "") {
	echo '<script language="javascript">alert("nomor spj tidak boleh kosong")</script>';
	echo '<script language="javascript">window.location = "seleksi_vendor.php"</script>';
} else if ($get_var_nilai_spj == "") {
	echo '<script language="javascript">alert("nilai spj tidak boleh kosong")</script>';
	echo '<script language="javascript">window.location = "seleksi_vendor.php"</script>';
} else if ($get_var_mulai_berlaku == "" || $get_var_akhir_berlaku == "") {
	echo '<script language="javascript">alert("tanggal berlaku spj harus di pilih")</script>';
	echo '<script language="javascript">window.location = "seleksi_vendor.php"</script>';
} else if ($get_var_mulai_berlaku > $get_var_akhir_berlaku) {
	echo '<script language="javascript">alert("tanggal mulai harus lebih kecil dari tanggal akhir")</script>';
	echo '<script language="javascript">window.location = "seleksi_vendor.php"</script>';
	//di command karena upk riau salah pilih paket dan mau bikin spj baru}else if($get_var_mulai_berlaku < $today){
	//echo '<script language="javascript">alert("tanggal berlaku harus tanggal hari ini atau selanjutnya")</script>';
	//echo '<script language="javascript">window.location = "seleksi_vendor.php"</script>';
} else if ($get_var_nilai_spj > ($data[0][0] - $data[0][1])) {
	echo '<script language="javascript">alert("nilai spj lebih dari nilai sisa limit")</script>';
	echo '<script language="javascript">window.location = "seleksi_vendor.php"</script>';
	//else if(($get_var_nilai_spj + $current)>$pagu_kontrak)
} else if ($get_var_nilai_spj > $sisa_pagu_kontrak) {
	echo '<script language="javascript">alert("nilai spj lebih dari nilai pagu kontrak")</script>';
	echo '<script language="javascript">window.location = "seleksi_vendor.php"</script>';
} else if (($skki[0][0] + $get_var_nilai_spj) > $skki[0][1]) {
	echo '<script language="javascript">alert("nilai spj lebih dari nilai prk skki-skko")</script>';
	echo '<script language="javascript">window.location = "seleksi_vendor.php"</script>';
} else {

	$query1 = "UPDATE tb_skko_i SET skki_terpakai = skki_terpakai + $get_var_nilai_spj WHERE skki_no = '$get_var_no_skkio'";
	$skki_upd = mysqli_query($mysqli, $query1);
	$query2 = "UPDATE tb_fin_vendor SET fin_current = fin_current+$get_var_nilai_spj WHERE vendor_id = $get_var_vendor";
	$result = mysqli_query($mysqli, $query2);
	$query3 = "UPDATE tb_pagu_kontrak SET TERPAKAI = TERPAKAI+$get_var_nilai_spj WHERE vendor_id = $get_var_vendor and PAKET_JENIS = $get_var_paket_pekerjaan";
	//echo $query3;
	$res3 = mysqli_query($mysqli, $query3);
	$query = "INSERT INTO tb_spj (
								SPJ_NO,
								VENDOR_ID,
								SKKI_NO,
								PAKET_JENIS,
								SPJ_NILAI,
								SPJ_TANGGAL_MULAI,
								SPJ_TANGGAL_AKHIR,
								SPJ_DESKRIPSI,
								SPJ_STATUS,
								SPJ_ADD_NILAI,
								SPJ_INPUT_DATE,
								SPJ_INPUT_USER,
								SPJ_TARGET,
								AREA_KODE,
								NAMA_MANAGER,
								DIREKSI_PEKERJAAN,
								DIREKSI_LAPANGAN,
								gangguan,
								SPJ_ADD_TANGGAL,
								PPN,
								MIN_PPN
								)
					VALUES ('$get_var_no_spj',
							 $get_var_vendor, 
							 '$get_var_no_skkio', 
							 $get_var_paket_pekerjaan, 
							 $get_var_nilai_spj, 
							 '$get_var_mulai_berlaku', 
							 '$get_var_akhir_berlaku', 
							 '$get_var_deskripsi_pekerjaan',
							 0,
							 $get_var_nilai_spj,
							 CURDATE(),
							 '$username',
							 $get_var_target,
							 $area_kode,
							 '$get_var_nama_manager',
							 '$get_var_dir_pkj',
							 '$get_var_dir_lpg',
							 $get_var_ganggguan,
							 '$get_var_akhir_berlaku',
							 $get_var_ppn,
							 $get_var_min_ppn
							 );";
	// ECHO $query;
	$resultQuery = mysqli_query($mysqli, $query);
	$q = "select vendor_nama,paket_deskripsi 
		from tb_vendor a, tb_paket b, tb_mapping_vendor c 
		where a.vendor_id = c.vendor_id
		and c.paket_jenis = b.paket_jenis
		and a.vendor_id = '$get_var_vendor'";
	$p = mysqli_query($mysqli, $q);
	while ($rows2 = mysqli_fetch_array($p)) {
		$data2[] = $rows2;
	}

	$query_termin = "INSERT INTO tb_termin (
								SPJ_NO,
								TERMIN_1,
								TERMIN_2,
								TERMIN_3,
								TERMIN_4,
								TERMIN_5,
								STATUS
								)
					VALUES ('$get_var_no_spj',
							'$get_var_termin_1', 
							'$get_var_termin_2',
							'$get_var_termin_3',
							'$get_var_termin_4',
							'$get_var_termin_5',
							$get_var_metode_bayar
							 );";
	$resultQuery_termin = mysqli_query($mysqli, $query_termin);
	//echo $query_termin;

	if ($resultQuery == 1 and $result == 1 and $skki_upd == 1 and $resultQuery_termin == 1 and $res3 == 1) {
		mysqli_query($mysqli, "COMMIT");
		$subject = '[KHS 2020] Notifikasi Pembuatan SPJ';
		mail_sent($get_var_no_spj, $subject, "create");
		echo '<script language="javascript">alert("Berhasil")</script>';
		//echo '<script language="javascript">window.location = ".php"</script>';
		echo '<script language="javascript">window.open("addendum_print.php?id=' . $get_var_no_spj . '")</script>';
		/*echo '<script language="javascript">window.location = "seleksi_vendor.php"</script>';*/
	} else {
?>
		<script language="javascript">
			alert("Seleksi Vendor Gagal")
		</script>
		<!--	<script language="javascript">window.location = "seleksi_vendor.php"</script> -->
	<?php
		mysqli_query($mysqli, "ROLLBACK");
	}
	?>
	</div>
	</section>
	</div>
	</div>
	</section><!-- /.content -->
	</aside><!-- /.right-side -->
	</div>
	<?php include("lib/footer.php"); ?>
	</body>





<?php


}



?>