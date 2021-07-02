<?php
    session_start();
    include_once("lib/config.php");
    include_once('lib/head.php');
    $get_username = $_POST['var_username'];
    $var_email = $_POST['var_email'];
    $var_jabatan = $_POST['var_jabatan'];
    $get_role = $_POST['var_role'];
    $get_area = $_POST['var_area'];
    $get_area_kode = $_SESSION['area'];
    $password = "plnriau@".str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
    $encrypt=md5($password);
    $user_status = 1;
    $user_last_activity = 0;

    mysqli_query($mysqli, "START TRANSACTION");
    $user = "select USERNAME from tb_user where username = '$get_username'";
    $result_user = mysqli_query($mysqli, $user);
    while ($rows=mysqli_fetch_row($result_user)) {
        $data1[] = $rows;
    }
    $pass = "select PASSWORD from tb_user where password = '$password'";
    $result_pass = mysqli_query($mysqli, $pass);
    while ($rows=mysqli_fetch_row($result_pass)) {
        $data2[] = $rows;
    }
    while ($data2[0][0] == $encrypt) {
        $password = "plndisjaya@".str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        $encrypt=md5($password);
    }
        if ($get_username == "") {
            echo '<script language="javascript">alert("Username masih kosong")</script>';
            echo '<script language="javascript">window.location = "register.php"</script>';
        } elseif (!preg_match('/^[a-zA-Z0-9.]+$/', $get_username)) {
            echo '<script language="javascript">alert("Username hanya boleh diisi huruf angka dan titik")</script>';
            echo '<script language="javascript">window.location = "register.php"</script>';
        } elseif ($get_role == 0) {
            echo '<script language="javascript">alert("Role belum dipilih")</script>';
            echo '<script language="javascript">window.location = "register.php"</script>';
        } elseif ($get_area == 0) {
            echo '<script language="javascript">alert("Area belum dipilih")</script>';
            echo '<script language="javascript">window.location = "register.php"</script>';
        } elseif ($data1[0][0] != "") {
            echo '<script language="javascript">alert("username sudah terpakai")</script>';
            echo '<script language="javascript">window.location = "register.php"</script>';
        } else {
            $tambah = mysqli_query($mysqli, "insert into tb_user values('$get_username',$get_role,$get_area,'$password','$user_status','$var_email', '$var_jabatan')");
            $resultQuery = mysqli_query($mysqli, $tambah);
            if ($tambah==1) {
                mysqli_query($mysqli, "COMMIT"); ?>
			
			<body class="skin-black">
				<!--include file header-->
				
				<div class="wrapper row-offcanvas row-offcanvas-left">
					<!-- Left side column. contains the logo and sidebar -->
					
							
					<aside class="right-side">

						<!-- Main content -->
						<section class="content">
							<div class="row">
								<div class="col-md-8">
									<section class="panel">
										<header class="panel-heading">Data User Yang Ditambahkan</header>
										<div class="panel-body">
											<table>
												<tr><td>AREA</td><td>:</td><td><?php echo $get_area?></td></tr>
												<tr><td><font color="red">USERNAME</font></td><td>:</td><td><?php echo $get_username?></td></tr>
												<tr><td><font color="red">PASSWORD</font></td><td>:</td><td><?php echo $password?></td></tr>
												<tr><td>Email</td><td>:</td><td><?php echo $var_email?></td></tr>
												<tr><td>Jabatan</td><td>:</td><td><?php echo $var_jabatan?></td></tr>
												<tr><td><font color="red">catatan : akun dapat dipakai apabila sudah diverifikasi oleh Admin.</font></td></tr>
												<tr><td>kembali ke halaman <a href="index.php">Login</a></td></tr>
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
                echo "insert into tb_user values('$get_username',$get_role,$get_area,'$password','$user_status','$var_email', '$var_jabatan')";
                //echo '<script language="javascript">alert("Input Gagal")</script>';
                //echo '<script language="javascript">window.location = "inp_tagihan.php"</script>';
                mysqli_query($mysqli, "ROLLBACK");
            }
        }
?>