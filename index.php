<?php
	session_start();
	if(isset($_GET['err'])){
		$err = $_GET['err'];
		switch($err){
			case 1:
				$err = "Username / Password salah";
				break;
			case 2:
				$err = "User sedang login ditempat lain";
				break;
		}
	}else{$err="";}
	if(isset($_SESSION['isLogin'])){
		$role=$_SESSION['role'];
		if($role == 1 or $role == 2){
			echo '<script language="javascript">window.location = "kontrol_finansial.php"</script>';
		}else if($role == 3){
			echo '<script language="javascript">window.location = "inp_tagihan.php"</script>';
		}else if($role == 4){
			echo '<script language="javascript">window.location = "seleksi_vendor.php"</script>';
		}else if($role == 5){
			echo '<script language="javascript">window.location = "kecepatan_kerja.php"</script>';
		}
	
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Dashboard KHS 2020 | Login</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Bootstrap Login Form</title>
		<link rel="icon" href="img/icon_rev.png" type="image/x-icon">
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
				<div class="col-sm-8"><font size="5"><a href="">LOG IN</br>DASHBOARD - KHS 2020</font></br><small style="font-weight: normal;">PLN UIWRKR</small></a></div>
		  </h1>
      </div>
      <div class="modal-body">
          <form class="form col-md-12 center-block" method="post" action="login_action.php">
            <div class="form-group">
              <input type="text" class="form-control input-default" placeholder="Username" name="username" autofocus required>
            </div>
            <div class="form-group">
              <input type="password" class="form-control input-default" placeholder="Password" name="password" required >
            </div>
            <div class="form-group">
              <button class="btn btn-primary btn-lg btn-block">Log in</button>
              <!-- <span class="pull-right"><a href="#">Register</a></span><span><a href="#">Need help?</a></span> -->
            </div>
			 dont have an account? <a href="register.php">Register</a><br/>
			 
			 <!--<font color="red">info : data skki belum final</font>-->
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