<?php
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
?>

<body class="skin-black">
	<!--include file header-->
	<?php
	include("lib/header.php");
	$area_kode = $_SESSION['area'];
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
							<header class="panel-heading">EDIT SKKI/O</header>
							<div class="panel-body table-responsive">
								<form class="form-horizontal tasi-form" method="post" action="skkoi_edit_submit.php">
									<table class="table table-hover">
										<?php
										$skki_no = $_GET['skki_no'];
										$query = "select * from tb_skko_i where skki_no = '$skki_no'";
										$resultQuery = mysqli_query($mysqli, $query);
										while ($rows = mysqli_fetch_row($resultQuery)) {
											$data[] = $rows;
										}
										$current_skki_jenis 	= $data[0][0];
										$current_skki_no 		= $data[0][1];
										$current_area_kode 		= $data[0][2];
										$current_skki_nilai 	= number_format($data[0][3]);
										$current_skki_terpakai 	= number_format($data[0][4]);
										$current_skki_tanggal 	= $data[0][5];
										$current_paket_pekerjaan = $data[0][6];
										$current_skki_revisi	= $data[0][7];
										$current_keterangan		= $data[0][10];
										$err		= $_GET['err'];
										$success	= $_GET['scs'];
										?>

										<tr>
											<td>SKKI/O NO</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="" data-options="required:true" value="<?php echo $current_skki_no ?>" readonly></input></td>
											<input type="hidden" class="form-control" name="var_skki_no" data-options="required:true" value="<?php echo $current_skki_no ?>"></input>
										</tr>
										<tr>
											<td>SKKI JENIS</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="var_skki_jenis" data-options="required:true" value="<?php echo $current_skki_jenis ?>" readonly></input></td>
										</tr>
										<tr>
											<td>AREA KODE</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="var_area_kode" data-options="required:true" value="<?php echo $current_area_kode ?>" readonly></input></td>
										</tr>
										<tr>
											<td>SKKI NILAI</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="var_skki_nilai" id="nilai" data-options="required:true" value="<?php echo $current_skki_nilai ?>" placeholder="Nilai PRK tidak menggunakan koma" data-toggle="tooltip" title="Nilai PRK tidak menggunakan koma"></input></td>
										</tr>
										<tr>
											<td>SKKI TERPAKAI</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="var_skki_terpakai" id="nilai" data-options="required:true" value="<?php echo $current_skki_terpakai ?>" readonly></input></td>
										</tr>
										<tr>
											<td>SKKI TANGGAL</td>
											<td>:</td>
											<td><input type="date" class="form-control" id="skki_date" name="var_skki_tgl" data-options="required:true" value="<?php echo $current_skki_tanggal ?>"></input></td>
										</tr>

										<tr>
											<td>Revisi</td>
											<td>:</td>
											<td><input type="text" class="form-control" id="skki_revisi" name="var_skki_revisi" data-options="required:true" value="<?php echo $current_skki_revisi; ?>"></input></td>
										</tr>

										<tr>
											<td>Keterangan</td>
											<td>:</td>
											<td><input type="text" class="form-control m-b-10" id="keterangan" name="var_keterangan" data-options="required:true" value="<?php echo $current_keterangan; ?>"></input></td>
										</tr>

										<tr>
											<td colspan='4'>
												<font color="red"><?php echo $err; ?></font>
											</td>
										</tr>
										<tr>
											<td colspan='4'><button type="submit" class="btn btn-info" onclick="document.getElementById('submitForm').submit()">Submit</button></td>
										</tr>
										</tr>
										<td>
											<font color="green"><?php echo $success ?></font>
										</td>
										</tr>
									</table>
								</form>
							</div>
						</section>
					</div>
				</div>
			</section><!-- /.content -->
		</aside><!-- /.right-side -->
	</div>

	<?php include("lib/footers.php"); ?>
</body>

</html>