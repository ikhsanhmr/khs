<?php session_start();
include_once('lib/head.php');
include_once("lib/check.php");
include_once("lib/function.php"); ?>

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
							<header class="panel-heading">Edit Profile</header>
							<div class="panel-body">
								<form class="form-horizontal tasi-form" method="post" action="update_user_submit.php">

									<input type="hidden" value="<?php echo $_SESSION['username'] ?>" name="username">

									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Area</label>
										<div class="col-sm-10">
											<?php
											$data = ($kode_area != 54560) ? select_area_by_code($kode_area, $mysqli) : select_area($mysqli);
											for ($i = 0; $i < count($data); $i++) {
												$kode = $data[$i][0];
												$nama = $data[$i][1];
											}
											?><input class="input-xlarge disabled" id="disabledInput" value="<?php echo $nama  ?>" type="text" disabled="">

										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Username</label>
										<div class="col-sm-10">
											<input class="input-xlarge disabled" id="disabledInput" value="<?php echo $_SESSION['username'] ?>" type="text" disabled="">
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Password</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="var_password" value="<?php echo get_password($_SESSION['username'], $mysqli) ?>">
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Email</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="var_email" value="<?php echo get_email($_SESSION['username'], $mysqli) ?>">
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