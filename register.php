<?php
    session_start();
    include_once('lib/head.php');
    if (isset($_GET['err'])) {
        $err = $_GET['err'];
        switch ($err) {
            case 1:
                $err = "Username / Password salah";
                break;
            case 2:
                $err = "User sedang login ditempat lain";
                break;
        }
    } else {
        $err="";
    }
    if (isset($_SESSION['isLogin'])) {
        $role=$_SESSION['role'];
        if ($role == 1 or $role == 2) {
            echo '<script language="javascript">window.location = "kontrol_finansial.php"</script>';
        } elseif ($role == 3) {
            echo '<script language="javascript">window.location = "inp_tagihan.php"</script>';
        } elseif ($role == 4) {
            echo '<script language="javascript">window.location = "seleksi_vendor.php"</script>';
        } elseif ($role == 5) {
            echo '<script language="javascript">window.location = "kecepatan_kerja.php"</script>';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Register Form</title>
		<meta charset="utf-8">
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link href="css/styles.css" rel="stylesheet">
	</head>
	<body>
<!--login modal-->
<div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
    <!--      <label class="col-sm-2 col-sm-2 ">LOGIN</br> - KHS1</label>-->
          <h1 class="row text-center">
				<div class="col-sm-4"><img src="img/logo_pln2.png" height="110" width="90"></div>
				<div class="col-sm-8"><font size="5"><a href="">REGISTER</br>DASHBOARD - KHS</font></br><small style="font-weight: normal;">PLN WRKR</small></a></div>
		  </h1>
      </div>
      <div class="modal-body">
          <form class="form col-md-12 center-block" method="post" action="inp_user_register_submit.php">
            <div class="form-group">
			  <select class="form-control m-b-10" name="var_area">
					<option value=0>- Pilih Area -</option>
						<?php
                            $data = select_area($mysqli);
                            for ($i=0;$i<count($data);$i++) {
                                $current_area = $data[$i][1]; ?>
																<option value=<?php echo $data[$i][0]?>> 
																	<?php echo $current_area; ?> 
																</option><?php
                            }
                                                ?>
			  </select>
            </div>
			<div class="form-group">
			  <input type="text" class="form-control input" name="var_username" placeholder="username" required>
            </div>
            <div class="form-group">
			  <input type="text" class="form-control input" name="var_email" placeholder="email" required>
            </div>
			<div class="form-group">
			  <input type="text" class="form-control input" name="var_jabatan" placeholder="jabatan" required>
            </div>
			<div class="form-group">
			  <select class="form-control m-b-10" name="var_role">
					<option value=0> - Pilih Role - </option>
						<?php
                            $data=select_role_filter($mysqli);
                            for ($i=0;$i<count($data);$i++) {
                                $current_role = $data[$i][1]; ?><option value=<?php echo $data[$i][0]?>> <?php echo $current_role; ?> </option><?php
                            }
                        ?>
			  </select>
            </div>
            <div class="form-group">
              <button class="btn btn-primary btn-lg btn-block">Register</button>
              <!-- <span class="pull-right"><a href="#">Register</a></span><span><a href="#">Need help?</a></span> -->
            </div>
			allready register? <a href="index.php">Log in</a>
          </form>
      </div>
      <div class="modal-footer">
          <div class="col-md-12" align="center">
				<strong><font color="red"><?php echo $err?></font></strong>
		  </div>	
      </div>
  </div>
  </div>
</div>
	<!-- script references -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>