<?php
session_start();
include_once("lib/config.php");
include_once('lib/head.php');
include_once("lib/check.php");
$get_username = $_POST['var_username'];
$var_email = $_POST['var_email'];
$var_jabatan = $_POST['var_jabatan'];
$get_role = $_POST['var_role'];
$get_area_kode = $_SESSION['area'];
$password = "plnwrkr@" . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
$encrypt = md5($password);
$user_status = 0;
$user_last_activity = 0;

mysqli_query($mysqli, "START TRANSACTION");
$user = "select USERNAME from tb_user where username = '$get_username'";
$result_user = mysqli_query($mysqli, $user);
while ($rows = mysqli_fetch_row($result_user)) {
	$data1[] = $rows;
}
$pass = "select PASSWORD from tb_user where password = '$password'";
$result_pass = mysqli_query($mysqli, $pass);
while ($rows = mysqli_fetch_row($result_pass)) {
	$data2[] = $rows;
}
while ($data2[0][0] == $encrypt) {
	$password = "plnwrkr@" . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
	$encrypt = md5($password);
}
if ($get_username == "") {
	echo '<script language="javascript">alert("Username masih kosong")</script>';
	echo '<script language="javascript">window.location = "inp_user.php"</script>';
} else if (!preg_match('/^[a-zA-Z0-9.]+$/', $get_username)) {
	echo '<script language="javascript">alert("Username hanya boleh diisi huruf angka dan titik")</script>';
	echo '<script language="javascript">window.location = "inp_user.php"</script>';
} else if ($get_role == 0) {
	echo '<script language="javascript">alert("Role belum dipilih")</script>';
	echo '<script language="javascript">window.location = "inp_user.php"</script>';
} else if ($data1[0][0] != "") {
	echo '<script language="javascript">alert("username sudah terpakai")</script>';
	echo '<script language="javascript">window.location = "inp_user.php"</script>';
} else {
	$tambah = mysqli_query($mysqli, "insert into tb_user values('$get_username',$get_role,$get_area_kode,'$password','$user_status','$var_email', '$var_jabatan')");
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
									<header class="panel-heading">Data User Yang Ditambahkan</header>
									<div class="panel-body">
										<table>
											<tr>
												<td>USERNAME</td>
												<td>:</td>
												<td><?php echo $get_username ?></td>
											</tr>
											<tr>
												<td>PASSWORD</td>
												<td>:</td>
												<td><?php echo $password ?></td>
											</tr>
											<tr>
												<td>Email</td>
												<td>:</td>
												<td><?php echo $var_email ?></td>
											</tr>
											<tr>
												<td>Jabatan</td>
												<td>:</td>
												<td><?php echo $var_jabatan ?></td>
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
		echo "insert into tb_user values('$get_username',$get_role,$get_area_kode,'$password','$user_status','$var_email', '$var_jabatan')";
		//echo '<script language="javascript">alert("Input Gagal")</script>';
		//echo '<script language="javascript">window.location = "inp_tagihan.php"</script>';
		mysqli_query($mysqli, "ROLLBACK");
	}
}
?>