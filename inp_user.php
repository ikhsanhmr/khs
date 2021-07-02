<?php session_start();
include_once('lib/head.php');
include_once("lib/check.php"); ?>

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
							<header class="panel-heading">TAMBAH USER</header>
							<div class="panel-body">
								<form class="form-horizontal tasi-form" method="post" action="inp_user_submit.php">

									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">USERNAME</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="var_username" required>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Email</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="var_email" required>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Jabatan</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="var_jabatan" required>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">ROLE</label>
										<div class="col-sm-10">
											<select class="form-control m-b-10" name="var_role">
												<option value=0>- Pilih Role -</option>
												<?php
												$data = select_role_filter($mysqli);
												for ($i = 0; $i < count($data); $i++) {
													$current_role = $data[$i][1];
												?><option value=<?php echo $data[$i][0] ?>> <?php echo $current_role; ?> </option><?php
																																																						}
																																																							?>
											</select>
										</div>
									</div>

									<div class="form-group">
										<div class="col-lg-offset-2 col-lg-10">
											<button type="submit" class="btn btn-info" onclick="document.getElementById('submitForm').submit()">Submit</button>
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

	<?php include("lib/footers.php"); ?>
</body>

</html>