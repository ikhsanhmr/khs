<?php
session_start();
include_once("lib/config.php");
include_once('lib/head.php');
include_once("lib/check.php");
$get_username = $_GET['pengguna'];

$tambah = mysqli_query($mysqli, "update tb_user set user_status=0 where username='$get_username'");
$resultQuery = mysqli_query($mysqli, $tambah);
if ($tambah == 1) {
	mysqli_query($mysqli, "COMMIT");
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
								<header class="panel-heading">Data User Terverifikasi</header>
								<div class="panel-body">
									<table>
										<tr>
											<td>Username <font color="blue"><?php echo $get_username ?></font> telah diverikasi</td>
										</tr>
										<tr>
											<td><a href="inp_user_all.php">kembali ke daftar user </a></td>
										</tr>
									</table>
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
<?php
} else {
	echo "update tb_user set user_status=0 where username='$get_username'";
	//echo '<script language="javascript">alert("Input Gagal")</script>';
	//echo '<script language="javascript">window.location = "inp_tagihan.php"</script>';
	mysqli_query($mysqli, "ROLLBACK");
}
?>