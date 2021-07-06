<?php
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
?>

<body class="skin-black">

	<!--include file header-->
	<?php
	include("lib/header.php");
	$kode_area = $_SESSION['area'];
	?>

	<div class="wrapper row-offcanvas row-offcanvas-left">
		<!-- Left side column. contains the logo and sidebar -->
		<?php include("lib/menu.php"); ?>

		<aside class="right-side">
			<!-- Main content -->
			<section class="content">
				<div class="row">
					<div class="col-md-12">
						<section class="panel">
							<header class="panel-heading">Tagihan</header>
							<div class="panel-body">
								<form class="form-horizontal tasi-form" method="post" action="inp_tagihan_submit.php">
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Nomor SPJ</label>

										<div class="col-sm-10">
											<!--<select class="form-control m-b-10" name="var_no_spj" id="spj_no" onChange="nilai_spj_add(this.value)" >
										<option value="">- NO SPJ -</option>
										
										<?php

										/*$sql ="SELECT a.spj_no FROM tb_spj a, tb_progress b WHERE a.spj_no = b.spj_no and a.area_kode = $kode_area";
											$resultQuery=mysqli_query($sql);
											if(isset($resultQuery)){
											$noRows = mysqli_num_rows($resultQuery);
											if ($noRows > 0) {
										?>	
										<?php
											//$data=select_spj_no($kode_area);
											$data=select_progress($kode_area);
											for($i=0;$i<count($data);$i++)
											{
												$current_spj_no = $data[$i][0];
										?>
											<option value='<?php echo $current_spj_no; ?>'><?php echo $current_spj_no;?></option>

										<?php
											}
											}else{
										?>	
											<option value=''><font color="red"><?php echo "SPJ Belum ada progress";?></font></option>
											<?php 
												}
											}*/
										?>
									</select>-->
											<select class="form-control m-b-10" name="var_no_spj" id="spj_no" onChange="nilai_spj_add(this.value)">
												<option value="">- NO SPJ -</option>
												<?php
												$data = select_spj_no($kode_area, $mysqli);
												for ($i = 0; $i < count($data); $i++) {
													$current_spj_no = $data[$i][0];
												?>
													<option value='<?php echo $current_spj_no; ?>'><?php echo $current_spj_no; ?></option>

												<?php
												}
												?>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Nominal Tagihan</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="var_nominal_tagihan" id="nilai" placeholder="Nominal Tagihan" readonly>
										</div>
									</div>

									<div class="form-group">
										<label class=" col-sm-2 col-sm-2 control-label">Tanggal Bayar</label>
										<div class="col-md-2">
											<input type="date" class="form-control" name="var_tanggal_bayar" id="tgl_tagihan">
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Nomor BASTP</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="var_no_bastp" placeholder="Nomor BASTP" required>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Deskripsi</label>
										<div class="col-sm-10">
											<textarea rows="2" cols="125" name="var_deskripsi" placeholder="Nomor SAP" required></textarea>
										</div>
									</div>

									<div class="form-group">
										<div class="col-lg-offset-2 col-lg-10">
											<button type="submit" id="submit" class="btn btn-info" onclick="document.getElementById('submitForm').submit()">Submit</button>
										</div>
									</div>
								</form>
							</div>
						</section>
					</div>
				</div>
			</section><!-- /.content -->
		</aside><!-- /.right-side -->

	</div>

	<script type="text/javascript">
		function nilai_spj_add(value) {
			var spj_no = document.getElementById("spj_no").value;
			$.getJSON('get_nilai.php', {
				'spj_no': spj_no
			}, function(data) {
				$("#nilai").val(data);
			})

			$.getJSON('get_termin.php', {
				'spj_no': spj_no
			}, function(data) {
				if (data == 0) //non termin
				{ //alert("non termin");
					$.getJSON('get_val.php', {
						'spj_no': spj_no
					}, function(data) {
						if (data < 100) {
							alert("Tidak Bisa Input Pembayaran, Progress Belum 100%");
							document.getElementById("submit").disabled = true;
						} else {
							document.getElementById("submit").disabled = false;
						}
					})
				}


				if (data == 1) // termin
				{ //alert(" termin");
					$.getJSON('get_nilai.php', {
						'spj_no': spj_no
					}, function(data_nilai_spj) {

						$.getJSON('get_val.php', {
							'spj_no': spj_no
						}, function(data_progress) {
							$.getJSON('get_nilai_termin1.php', {
								'spj_no': spj_no
							}, function(data_termin1) {
								$.getJSON('get_nilai_termin2.php', {
									'spj_no': spj_no
								}, function(data_termin2) {
									$.getJSON('get_nilai_termin3.php', {
										'spj_no': spj_no
									}, function(data_termin3) {
										if (data_nilai_spj < 5000000000) {

											if ((data_progress < data_termin1)) {
												alert("Tidak Bisa Input Pembayaran Dikarenakan Progress Termin Belum Melebihi 55%");
												document.getElementById("submit").disabled = true;
												var nilai_nominal_tagihan1 = 0;
												$("#nilai").val(nilai_nominal_tagihan1);
											} else if ((data_progress > data_termin1)) {
												alert("pembayaran 50%");
												document.getElementById("submit").disabled = false;
												var nilai_nominal_tagihan1 = (50 / 100) * data_nilai_spj;
												$("#nilai").val(nilai_nominal_tagihan1);
											} else if ((data_termin1 == 0) || (data_progress < data_termin2)) {
												alert("Tidak Bisa Input Pembayaran Dikarenakan Progress Termin Belum Mencapai 100%");
												document.getElementById("submit").disabled = true;
												var nilai_nominal_tagihan1 = 0;
												$("#nilai").val(nilai_nominal_tagihan1);
											} else if ((data_progress > data_termin1) && (data_progress == data_termin2)) {
												alert("pembayaran 100%");
												document.getElementById("submit").disabled = false;
												var nilai_nominal_tagihan1 = (50 / 100) * data_nilai_spj;
												$("#nilai").val(nilai_nominal_tagihan1);
											} else if ((data_progress == data_termin2)) {
												alert("pembayaran langsung 100%");
												document.getElementById("submit").disabled = false;
												var nilai_nominal_tagihan1 = (100 / 100) * data_nilai_spj;
												$("#nilai").val(nilai_nominal_tagihan1);
											}

										} else {
											if ((data_progress < data_termin1) && (data_progress < data_termin2) && (data_progress < data_termin3)) {
												alert("Tidak Bisa Input Pembayaran Dikarenakan Progress Belum Sesuai dengan Termin 35%");
												document.getElementById("submit").disabled = true;
											} else if ((data_termin1 == 0) && (data_progress < $data_termin2) && (data_progress < data_termin3)) {
												alert("Tidak Bisa Input Pembayaran Dikarenakan Progress Belum Sesuai dengan Termin 65%");
												document.getElementById("submit").disabled = true;
											} else if ((data_termin1 == 0) && (data_termin2 == 0) && (data_progress < data_termin3)) {
												alert("Tidak Bisa Input Pembayaran Dikarenakan Progress Belum Sesuai dengan Termin 100%");
												document.getElementById("submit").disabled = true;

											} else if ((data_progress > data_termin1) && (data_progress < data_termin2) && (data_progress < data_termin3)) {
												alert("pembayaran 30%");
												document.getElementById("submit").disabled = false;
												var nilai_nominal_tagihan1 = (30 / 100) * data_nilai_spj;
												$("#nilai").val(nilai_nominal_tagihan1);
											} else if ((data_progress > data_termin1) && (data_progress > data_termin2) && (data_progress < data_termin3)) {
												alert("pembayaran 60%");
												document.getElementById("submit").disabled = false;
												var nilai_nominal_tagihan1 = (30 / 100) * data_nilai_spj;
												$("#nilai").val(nilai_nominal_tagihan1);
											} else if ((data_termin1 == 0) && (data_termin2 == 0) && (data_progress == data_termin3)) {
												alert("pembayaran 100%");
												document.getElementById("submit").disabled = false;
												var nilai_nominal_tagihan1 = (40 / 100) * data_nilai_spj;
												$("#nilai").val(nilai_nominal_tagihan1);
											} else if ((data_progress == data_termin3)) {
												alert("pembayaran langsung 100%");
												document.getElementById("submit").disabled = false;
												var nilai_nominal_tagihan1 = (100 / 100) * data_nilai_spj;
												$("#nilai").val(nilai_nominal_tagihan1);
											}

										}
									})
								})
							})
						})
					})
				}

			})

		}
	</script>

	<?php include("lib/footers.php"); ?>
</body>

</html>