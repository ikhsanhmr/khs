<?php

session_start();
include_once("lib/config.php");
include_once('lib/head.php');
include_once("lib/check.php");
$username = $_POST['username'];
$var_password = $_POST['var_password'];
$var_email = $_POST['var_email'];

$tambah = "update tb_user SET PASSWORD='$var_password', email='$var_email' where USERNAME='$username'";
$resultQuery = mysqli_query($mysqli, $tambah);
if (isset($tambah)) {
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
								<header class="panel-heading">Edit Profil</header>
								<div class="panel-body">
									<div class="alert alert-success">Data user berhasil diupdate!</div>
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

} else {
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
								<header class="panel-heading">Edit Profile</header>
								<div class="panel-body">
									<div class="alert alert-danger">Profile Gagal Diupdate!</div>
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