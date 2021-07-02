<?php
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
?>

<body class="skin-black">
	<!--include file header-->
	<?php
	include("lib/header.php");
	$vendor_id	= $_GET['vendor_id'];
	$paket_id	= $_GET['paket_id'];

	$query = "select * from tb_vendor where vendor_id='$vendor_id' ";
	$resultQuery = mysqli_query($mysqli, $query);
	while ($rows = mysqli_fetch_row($resultQuery)) {
		$data[] = $rows;
	}
	$current_vendor_id	= $data[0][0];
	$current_vendor_nama = $data[0][1];
	$err		= $_GET['err'];
	$success	= $_GET['scs'];


	$query2 = "select * from tb_paket where paket_jenis='$paket_id'";
	$resultQuery2 = mysqli_query($mysqli, $query2);
	while ($rows = mysqli_fetch_row($resultQuery2)) {
		$data2[] = $rows;
	}
	$current_paket_jenis = $data2[0][0];
	$current_paket_desk	= $data2[0][1];


	$query3 = "select * from tb_pagu_kontrak where vendor_id='$vendor_id' and paket_jenis = '$paket_id' ";
	$resultQuery3 = mysqli_query($mysqli, $query3);
	while ($rows = mysqli_fetch_row($resultQuery3)) {
		$data3[] = $rows;
	}
	$current_vendor_id		= $data3[0][0];
	$current_paket_jenis	= $data3[0][1];
	$current_pagu_kontrak	= $data3[0][2];

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
							<header class="panel-heading">EDIT PAGU KONTRAK</header>
							<div class="panel-body table-responsive">
								<form class="form-horizontal tasi-form" method="post" action="pagu_kontrak_edit_submit.php">
									<table class="table table-hover">
										<div class="form-group">
											<label class="col-sm-2 control-label col-lg-2" for="inputSuccess">Vendor</label>
											<div class="col-lg-10">
												<select class="form-control m-b-10" name="var_id_vendor" readonly>
													<option value="<?php echo $current_vendor_id; ?>"><?php echo $current_vendor_nama; ?></option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-2 control-label col-lg-2" for="inputSuccess">Paket</label>
											<div class="col-lg-10">
												<select class="form-control m-b-10" name="var_paket_id" disabled="">
													<option value="<?php echo $current_paket_jenis; ?>"><?php echo $current_paket_desk; ?></option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-2 col-sm-2 control-label">Pagu Kontrak</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="var_pagu_kontrak" value="<?php echo $current_pagu_kontrak; ?>"></input>
											</div>
										</div>

										<?php
										if (isset($err)) {
										?>
											<tr>
												<td colspan='4'>
													<font color="red"><?php echo $err; ?></font>
												</td>
											</tr>
										<?php
										}
										?>

										<div class="form-group">
											<div class="col-lg-offset-2 col-lg-10"><button type="submit" class="btn btn-info" onclick="document.getElementById('submitForm').submit()">Submit</button></div>
										</div>

										<tr>
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
	<?php include("lib/footer.php"); ?>

</body>

</html>