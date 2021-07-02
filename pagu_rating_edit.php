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

	$query = "select * from tb_vendor where vendor_id='$vendor_id' ";
	$resultQuery = mysqli_query($mysqli, $query);
	while ($rows = mysqli_fetch_row($resultQuery)) {
		$data[] = $rows;
	}
	$current_vendor_id	= $data[0][0];
	$current_vendor_nama = $data[0][1];
	$err		= $_GET['err'];
	$success	= $_GET['scs'];

	$query3 = "SELECT * FROM TB_FIN_VENDOR WHERE vendor_id='$vendor_id'";
	$resultQuery3 = mysqli_query($mysqli, $query3);
	while ($rows = mysqli_fetch_row($resultQuery3)) {
		$data3[] = $rows;
	}
	$current_vendor_id	= $data3[0][0];
	$current_rating_lap	= $data3[0][1];
	$current_fin_limit	= $data3[0][2];
	$current_fin_current = $data3[0][3];


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
							<header class="panel-heading">EDIT PAGU RATING</header>
							<div class="panel-body table-responsive">
								<form class="form-horizontal tasi-form" method="post" action="pagu_rating_edit_submit.php">
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
											<label class="col-sm-2 control-label col-lg-2" for="inputSuccess">Rating</label>
											<div class="col-lg-10">
												<select class="form-control m-b-10" name="var_rating">
													<option value="">- Pilih Rating -</option>
													<?php
													$query2 = "SELECT rating_laporan_audit FROM TB_RATING";
													$resultQuery2 = mysqli_query($mysqli, $query2);
													while ($rows = mysqli_fetch_row($resultQuery2)) {
														$data2[] = $rows;
													}

													for ($a = 0; $a < count($data2); $a++) {
														$current_rating = $data2[$a][0];
													?>

														<option value="<?php echo $current_rating; ?>"><?php echo $current_rating; ?></option>

													<?php
													}
													?>

												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-2 col-sm-2 control-label">Limit</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="var_limit" value="<?php echo $current_fin_limit; ?>"></input>
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