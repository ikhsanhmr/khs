<?php session_start();
include_once('lib/head.php');
include_once("lib/check.php"); ?>

<body class="skin-black">
	<?php include_once("lib/header.php"); ?>
	<div class="wrapper row-offcanvas row-offcanvas-left">
		<!-- Left side column. contains the logo and sidebar -->
		<?php include_once("lib/menu.php"); ?>

		<aside class="right-side">

			<!-- Main content -->
			<section class="content">

				<div class="row">
					<div class="col-md-12">
						<section class="panel">
							<header class="panel-heading">UPLOAD DATA</header>
							<div class="panel-body">
								<form enctype="multipart/form-data" class="form-horizontal tasi-form" method="post" action="up_db_submit.php" name="upload_form" onsubmit="return check();">
									<?php
									if ($_FILES['excel_data']['type'] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {

										$jenis_data = $_POST['var_jenis_data'];

										$target_path = "uploads/";
										$target_path = $target_path . basename($_FILES['excel_data']['name']);
										if (move_uploaded_file($_FILES['excel_data']['tmp_name'], $target_path)) {
											set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
											include 'PHPExcel/IOFactory.php';

											// This is the file path to be uploaded.
											$inputFileName = 'uploads/' . $_FILES['excel_data']['name'];

											try {
												$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
											} catch (Exception $e) {
												die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
											}


											$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
											$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet
											$err = [];
											$excel_empty = "";
											if ($arrayCount > 1) {
												if ($jenis_data == 1) {
													$databasetable = "tb_spj";
													for ($i = 2; $i <= $arrayCount; $i++) {
														$spj_no[$i - 2] = trim($allDataInSheet[$i]["A"]);
														$vendor_id[$i - 2] = trim($allDataInSheet[$i]["B"]);
														$skki_no[$i - 2] = trim($allDataInSheet[$i]["C"]);
														$paket_jenis[$i - 2] = trim($allDataInSheet[$i]["D"]);
														$spj_nilai[$i - 2] = trim($allDataInSheet[$i]["E"]);
														$spj_tanggal_mulai[$i - 2] = trim($allDataInSheet[$i]["F"]);
														$spj_tanggal_akhir[$i - 2] = trim($allDataInSheet[$i]["G"]);
														$spj_deskripsi[$i - 2] = trim($allDataInSheet[$i]["H"]);
														$spj_status[$i - 2] = 0;
														$spj_add_nilai[$i - 2] = $spj_nilai[$i - 2];
														$spj_add_tanggal[$i - 2] = NULL;
														$spj_input_date[$i - 2] = date('Y-m-d');
														$spj_input_user[$i - 2] = trim($allDataInSheet[$i]["I"]);
														$spj_nama_manager[$i - 2] = trim($allDataInSheet[$i]["J"]);
														$tgl_mulai_db[$i - 2] = date('Y-m-d', strtotime($spj_tanggal_mulai[$i - 2]));
														$tgl_akhir_db[$i - 2] = date('Y-m-d', strtotime($spj_tanggal_akhir[$i - 2]));
														$tgl_inp_db[$i - 2] = date('Y-m-d', strtotime($spj_input_date[$i - 2]));

														//	DATA EXIST VALIDATION	//
														$spj_exist_query = mysqli_fetch_array(mysqli_query($mysqli, "SELECT spj_no FROM " . $databasetable . " WHERE spj_no = '" . $spj_no[$i - 2] . "' and vendor_id = " . $vendor_id[$i - 2] . " and skki_no = '" . $skki_no[$i - 2] . "' and paket_jenis = " . $paket_jenis[$i - 2] . " and spj_nilai = " . $spj_nilai[$i - 2] . " and spj_tanggal_mulai = '" . $tgl_mulai_db[$i - 2] . "' and spj_tanggal_akhir = '" . $tgl_akhir_db[$i - 2] . "' and spj_add_nilai = " . $spj_add_nilai[$i - 2] . " and spj_add_tanggal = '" . $spj_add_tanggal[$i - 2] . "'  and spj_input_user = '" . $spj_input_user[$i - 2] . "'"));
														$spj_exist = $spj_exist_query["spj_no"];

														//	PRIMARY KEY VALIDATION	//
														$spj_primary_query = mysqli_fetch_array(mysqli_query($mysqli, "SELECT spj_no FROM tb_spj WHERE spj_no ='" . $spj_no[$i - 2] . "'"));
														$spj_primary = $spj_primary_query["spj_no"];

														//	VENDOR ID VALIDATION//
														$spj_vendor_id_query = mysqli_fetch_array(mysqli_query($mysqli, "SELECT vendor_id FROM tb_vendor WHERE vendor_id = " . $vendor_id[$i - 2]));
														$spj_vendor_id = $spj_vendor_id_query["vendor_id"];

														//	SKKO/I NUMBER VALIDATION	//
														$skkoi_no_query = mysqli_fetch_array(mysqli_query($mysqli, "SELECT skki_no, skki_nilai, skki_terpakai FROM tb_skko_i WHERE skki_no ='" . $skki_no[$i - 2] . "'"));
														$skkoi_no = $skkoi_no_query["skki_no"];
														$skkoi_sisa = $skkoi_no_query["skki_nilai"] - $skkoi_no_query["skki_terpakai"];

														// SKKO/I AREA VALIDATION //
														$skkoi_area_query = mysqli_fetch_array(mysqli_query($mysqli, "select vendor_id from tb_mapping_vendor a, tb_skko_i b
																								 where a.area_kode = b.area_kode
																								 and b.skki_no = '" . $skki_no[$i - 2] . "'
																								 and a.vendor_id = " . $vendor_id[$i - 2]));
														$skkoi_area = $skkoi_area_query['vendor_id'];

														//	PAKET JENIS BERDASARKAN VENDOR ID	//
														$spj_paket_jenis_vendor_id_query = mysqli_fetch_array(mysqli_query($mysqli, "SELECT vendor_id FROM tb_mapping_vendor WHERE vendor_id = " . $vendor_id[$i - 2] . " AND paket_jenis = " . $paket_jenis[$i - 2] . ""));
														$spj_paket_jenis_vendor_id = $spj_paket_jenis_vendor_id_query["vendor_id"];

														//	FINANCIAL LIMIT VALIDATION	//
														$spj_fin_lim_query = mysqli_fetch_array(mysqli_query($mysqli, "SELECT fin_limit, fin_current FROM tb_fin_vendor WHERE vendor_id = " . $vendor_id[$i - 2]));
														$spj_sisa_fin = $spj_fin_lim_query["fin_limit"] - $spj_fin_lim_query["fin_current"];

														//	SPJ INPUT USER VALIDATION	//
														$spj_inp_user_query = mysqli_fetch_array(mysqli_query($mysqli, "SELECT username FROM tb_user WHERE username = '" . $spj_input_user[$i - 2] . "'"));
														$spj_inp_user = $spj_inp_user_query["username"];

														if ($spj_exist != "") {
															$err[$i - 2] = "<font color='blue'>Data sudah ada</font>";
														} else if ($spj_primary != "") {
															$err[$i - 2] = "<font color='red'>SPJ NO '" . $spj_no[$i - 2] . "' sudah ada di database</font>";
														} else if ($spj_no[$i - 2] == "") {
															$err[$i - 2] = "<font color='red'>SPJ NO tidak boleh kosong</font>";
														} else if ($vendor_id[$i - 2] == "") {
															$err[$i - 2] = "<font color='red'>VENDOR ID tidak boleh kosong</font>";
														} else if ($skki_no[$i - 2] == "") {
															$err[$i - 2] = "<font color='red'>SKKI NO tidak boleh kosong</font>";
														} else if ($paket_jenis[$i - 2] == "") {
															$err[$i - 2] = "<font color='red'>PAKET JENIS tidak boleh kosong</font>";
														} else if ($spj_nilai[$i - 2] == "") {
															$err[$i - 2] = "<font color='red'>SPJ NILAI tidak boleh kosong</font>";
														} else if ($spj_tanggal_mulai[$i - 2] == "") {
															$err[$i - 2] = "<font color='red'>SPJ TANGGAL MULAI tidak boleh kosong</font>";
														} else if ($spj_tanggal_akhir[$i - 2] == "") {
															$err[$i - 2] = "<font color='red'>SPJ TANGGAL AKHIR tidak boleh kosong</font>";
														} else if ($spj_deskripsi[$i - 2] == "") {
															$err[$i - 2] = "<font color='red'>SPJ DESKRIPSI tidak boleh kosong</font>";
														} else if ($spj_input_user[$i - 2] == "") {
															$err[$i - 2] = "<font color='red'>SPJ INPUT USER tidak boleh kosong</font>";
														} else if ($spj_nama_manager[$i - 2] == "") {
															$err[$i - 2] = "<font color='red'>NAMA MANAGER tidak boleh kosong</font>";
														} else if ($spj_vendor_id == "") {
															$err[$i - 2] = "<font color='red'>VENDOR ID '" . $vendor_id[$i - 2] . "' tidak tersedia</font>";
														} else if ($skkoi_no == "") {
															$err[$i - 2] = "<font color='red'>SKKOI NO '" . $skki_no[$i - 2] . "' tidak tersedia</font>";
														} else if ($skkoi_area == "") {
															$err[$i - 2] = "<font color='red'>SKKOI NO '" . $skki_no[$i - 2] . "' tidak sesuai dengan area</font>";
														} else if ($spj_paket_jenis_vendor_id == "") {
															$err[$i - 2] = "<font color='red'>Paket Jenis '" . $paket_jenis[$i - 2] . "' tidak tersedia untuk vendor id " . $vendor_id[$i - 2] . "</font>";
														} else if (!is_numeric($spj_nilai[$i - 2])) {
															$err[$i - 2] = "<font color='red'>Nilai SPJ harus numeric</font>";
														} else if ($spj_nilai[$i - 2] > $skkoi_sisa) {
															$err[$i - 2] = "<font color='red'>Nilai SPJ tidak boleh lebih dari sisa SKKO/I</font>";
														} else if ($spj_sisa_fin < $spj_nilai[$i - 2]) {
															$err[$i - 2] = "<font color='red'>Nilai SPJ tidak boleh lebih dari sisa finansial vendor</font>";
														} else if (strlen($spj_tanggal_mulai[$i - 2]) != 10 or $spj_tanggal_mulai[$i - 2][2] != '-' or $spj_tanggal_mulai[$i - 2][5] != '-') {
															$err[$i - 2] = "<font color='red'>Format Tanggal Mulai Harus 'dd-mm-yyyy'</font>";
														} else if (strlen($spj_tanggal_akhir[$i - 2]) != 10 or $spj_tanggal_akhir[$i - 2][2] != '-' or $spj_tanggal_akhir[$i - 2][5] != '-') {
															$err[$i - 2] = "<font color='red'>Format Tanggal Akhir Harus 'dd-mm-yyyy'</font>";
														} else if (strtotime($spj_tanggal_akhir[$i - 2]) < strtotime($spj_tanggal_mulai[$i - 2])) {
															$err[$i - 2] = "<font color='red'>Tanggal Mulai > Tanggal Akhir</font>";
														} else if ($spj_status[$i - 2] != 0) {
															$err[$i - 2] = "<font color='red'>Nilai Default SPJ Status Harus 0</font>";
														} else if ($spj_inp_user == "") {
															$err[$i - 2] = "<font color='red'>User Belum Ada Di Database</font>";
														} else {
															mysqli_query($mysqli, "START TRANSACTION");
															$insertTable_spj = mysqli_query($mysqli, "insert into " . $databasetable . " (
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
																	NAMA_MANAGER)
																	values('" . $spj_no[$i - 2] . "'," . $vendor_id[$i - 2] . ",'" . $skki_no[$i - 2] . "'," . $paket_jenis[$i - 2] . "," . $spj_nilai[$i - 2] . ",'" . $tgl_mulai_db[$i - 2] . "','" . $tgl_akhir_db[$i - 2] . "','" . $spj_deskripsi[$i - 2] . "'," . $spj_status[$i - 2] . "," . $spj_add_nilai[$i - 2] . ",'" . $tgl_inp_db[$i - 2] . "','" . $spj_input_user[$i - 2] . "','" . $spj_nama_manager[$i - 2] . "')");
															$update_tb_skkoi = mysqli_query($mysqli, "UPDATE tb_skko_i SET skki_terpakai = skki_terpakai+" . $spj_nilai[$i - 2] . " WHERE skki_no = '" . $skki_no[$i - 2] . "'");
															$update_tb_fin_vendor = mysqli_query($mysqli, "UPDATE tb_fin_vendor SET fin_current = fin_current + " . $spj_nilai[$i - 2] . " WHERE vendor_id = " . $vendor_id[$i - 2]);
															$err[$i - 2] = "<font color='green'>Record has been added</font>";
															if ($insertTable_spj == 1 and $update_tb_skkoi == 1 and $update_tb_fin_vendor == 1) {
																mysqli_query($mysqli, "COMMIT");
															} else {
																mysqli_query($mysqli, "ROLLBACK");
															}
														}
													}
													echo "<a href='up_db.php' class='btn btn-info'>Back</a>
																	  <table class='table table-hover'>
																		<tr align='center'>
																			<td><strong>NO</strong></td>
																			<td><strong>SPJ NO</strong></td>
																			<!--<td><strong>VENDOR ID</strong></td>
																			<td><strong>SKKO/I NO</strong></td>
																			<td><strong>PAKET JENIS</strong></td>
																			<td><strong>SPJ NILAI</strong></td>
																			<td><strong>SPJ TANGGAL MULAI</strong></td>
																			<td><strong>SPJ TANGGAL AKHIR</strong></td>
																			<td><strong>SPJ DESKRIPSI</strong></td>
																			<td><strong>SPJ STATUS</strong></td>
																			<td><strong>SPJ NILAI ADDENDUM</strong></td>
																			<td><strong>SPJ TANGGAL ADDENDUM</strong></td>
																			<td><strong>SPJ TANGGAL INPUT</strong></td>
																			<td><strong>SPJ INPUT USER</strong></td>-->
																			<td><strong>KETERANGAN</strong></td>
																		<tr>";
													for ($i = 0; $i < count($err); $i++) {
														echo "<tr align='center'>
																			<td>" . ($i + 1) . "</td>
																			<td>" . $spj_no[$i] . "</td>
																			<!--<td>" . $vendor_id[$i] . "</td>
																			<td>" . $skki_no[$i] . "</td>
																			<td>" . $paket_jenis[$i] . "</td>
																			<td>" . $spj_nilai[$i] . "</td>
																			<td>" . $spj_tanggal_mulai[$i] . "</td>
																			<td>" . $spj_tanggal_akhir[$i] . "</td>
																			<td>" . $spj_deskripsi[$i] . "</td>
																			<td>" . $spj_status[$i] . "</td>
																			<td>" . $spj_add_nilai[$i] . "</td>
																			<td>" . $spj_add_tanggal[$i] . "</td>
																			<td>" . $spj_input_date[$i] . "</td>
																			<td>" . $spj_input_user[$i] . "</td>-->
																			<td>" . $err[$i] . "</td>
																		  </tr>";
													}
													echo "</table>";
												} else if ($jenis_data == 2) {
													$databasetable = "tb_skko_i";
													for ($i = 2; $i <= $arrayCount; $i++) {
														$skki_jenis[$i - 2] = trim($allDataInSheet[$i]["A"]);
														$skki_no[$i - 2] = trim($allDataInSheet[$i]["B"]);
														$area_kode[$i - 2] = trim($allDataInSheet[$i]["C"]);
														$skki_nilai[$i - 2] = trim($allDataInSheet[$i]["D"]);
														$skki_terpakai[$i - 2] = 0;
														$skki_tanggal[$i - 2] = trim($allDataInSheet[$i]["E"]);
														$skki_tanggal_db[$i - 2] = date('Y-m-d', strtotime($skki_tanggal[$i - 2]));
														//	DATA EXIST VALIDATION	//
														$skki_exist_query = mysqli_fetch_array(mysqli_query($mysqli, "SELECT skki_no FROM " . $databasetable . " WHERE skki_jenis = '" . $skki_jenis[$i - 2] . "' and skki_no = '" . $skki_no[$i - 2] . "' and area_kode = '" . $area_kode[$i - 2] . "' and skki_nilai = '" . $skki_nilai[$i - 2] . "' and skki_terpakai = '" . $skki_terpakai[$i - 2] . "' and skki_tanggal = '" . $skki_tanggal[$i - 2] . "'"));
														$skki_exist = $skki_exist_query["skki_no"];

														// PRIMARY KEY VALIDATION	//
														$skki_primary_query = mysqli_fetch_array(mysqli_query($mysqli, "SELECT skki_no FROM " . $databasetable . " WHERE skki_no = '" . $skki_no[$i - 2] . "'"));
														$skki_primary = $skki_primary_query["skki_no"];

														//	AREA KODE VALIDATION	//
														$skki_area_kode_query = mysqli_fetch_array(mysqli_query($mysqli, "SELECT area_kode FROM tb_area WHERE area_kode=" . $area_kode[$i - 2]));
														$skki_area = $skki_area_kode_query["area_kode"];

														if ($skki_exist != "") {
															$err[$i - 2] = "<font color='blue'>Data sudah ada</font>";
														} else if ($skki_jenis[$i - 2] == "") {
															$err[$i - 2] = "<font color='red'>SKKI JENIS tidak boleh kosong</font>";
														} else if ($skki_no[$i - 2] == "") {
															$err[$i - 2] = "<font color='red'>SKKI NO tidak boleh kosong</font>";
														} else if ($area_kode[$i - 2] == "") {
															$err[$i - 2] = "<font color='red'>AREA KODE tidak boleh kosong</font>";
														} else if (!is_numeric($area_kode[$i - 2])) {
															$err[$i - 2] = "<font color='red'>AREA KODE harus angka</font>";
														} else if ($skki_tanggal[$i - 2] == "") {
															$err[$i - 2] = "<font color='red'>SKKI TANGGAL tidak boleh kosong</font>";
														} else if ($skki_nilai[$i - 2] == "") {
															$err[$i - 2] = "<font color='red'>SKKI NILAI tidak boleh kosong</font>";
														} else if (!is_numeric($skki_nilai[$i - 2])) {
															$err[$i - 2] = "<font color='red'>SKKI NILAI Harus Numerik</font>";
														} else if ($skki_primary != "") {
															$err[$i - 2] = "<font color='red'>SKKI NO '" . $skki_no[$i - 2] . "' sudah ada di database</font>";
														} else if ($skki_jenis[$i - 2] != "SKKI" and $skki_jenis[$i - 2] != "SKKO") {
															$err[$i - 2] = "<font color='red'>SKKI/O Jenis Harus Antara SKKI / SKKO</font>";
														} else if ($skki_area == "") {
															$err[$i - 2] = "<font color='red'>Area Kode Invalid</font>";
														} else if (strlen($skki_tanggal[$i - 2]) != 10 or $skki_tanggal[$i - 2][2] != '-' or $skki_tanggal[$i - 2][5] != '-') {
															$err[$i - 2] = "<font color='red'>Format Tanggal Harus 'dd-mm-yyyy'</font>";
														} else {
															$skki_insertTable = mysqli_query($mysqli, "insert into " . $databasetable . " values('" . $skki_jenis[$i - 2] . "', '" . $skki_no[$i - 2] . "', " . $area_kode[$i - 2] . ", " . $skki_nilai[$i - 2] . ", " . $skki_terpakai[$i - 2] . ", '" . $skki_tanggal_db[$i - 2] . "')");
															$err[$i - 2] = "<font color='green'>Record has been added</font>";
														}
													}
													echo "<a href='up_db.php' class='btn btn-info'>Back</a>
																	  <table class='table table-hover'>
																		<tr align='center'>
																			<td><strong>NO</strong></td>
																			<td><strong>SKKI JENIS</strong></td>
																			<td><strong>AREA KODE</strong></td>
																			<td><strong>SKKI NO</strong></td>
																			<td><strong>SKKI NILAI</strong></td>
																			<td><strong>SKKI TERPAKAI</strong></td>
																			<td><strong>SKKI TANGGAL</strong></td>
																			<td><strong>KETERANGAN</strong></td>
																		<tr>";
													for ($i = 0; $i < count($err); $i++) {
														echo "<tr align='center'>
																			<td>" . ($i + 1) . "</td>
																			<td>" . $skki_jenis[$i] . "</td>
																			<td>" . $area_kode[$i] . "</td>
																			<td>" . $skki_no[$i] . "</td>
																			<td>" . $skki_nilai[$i] . "</td>
																			<td>" . $skki_terpakai[$i] . "</td>
																			<td>" . $skki_tanggal[$i] . "</td>
																			<td>" . $err[$i] . "</td>
																		  </tr>";
													}
													echo "</table>";
												}
												unlink("uploads/" . $_FILES['excel_data']['name']);
											} else {
												echo "<a href='up_db.php' class='btn btn-info'>Back</a>
															  <h3>Tidak ada data pada file excel</h3>";
											}
										} else {
											echo "<a href='up_db.php' class='btn btn-info'>Back</a>
														  <h3>Upload gagal</h3>";
										}
									} else {
										echo "<a href='up_db.php' class='btn btn-info'>Back</a>
													  <h3>format file harus .xlsx</h3>";
									}
									?>
								</form>
							</div>
						</section>
					</div>
				</div>
			</section><!-- /.content -->
		</aside><!-- /.right-side -->
	</div>
	<?php include("lib/footer.php"); ?>
</body>

</html>