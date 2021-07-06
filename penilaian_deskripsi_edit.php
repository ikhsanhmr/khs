<?php
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
?>

<body class="skin-black">
	<!--include file header-->
	<?php
        include("lib/header.php");
        $area_kode=$_SESSION['area'];
    ?>	

	<div class="wrapper row-offcanvas row-offcanvas-left">
		<!-- Left side column. contains the logo and sidebar -->
		<?php include("lib/menu.php");?>
		<aside class="right-side">
			<!-- Main content -->
			<section class="content">


					
				<div class="row">
					<div class="col-md-12">
						<section class="panel">
							<header class="panel-heading">EDIT PENILAIAN DESKRIPSI</header>
							<div class="panel-body table-responsive">
								<form class="form-horizontal tasi-form" method="post" action="penilaian_deskripsi_edit_submit.php">
									<table class="table table-hover">
										<?php
                                            $id = $_GET['id'];
                                            $query = "select * from penilaian_deskripsi where id_deskripsi = '$id'";
                                            $resultQuery=mysqli_query($mysqli, $query);
                                            while ($rows=mysqli_fetch_row($resultQuery)) {
                                                $data[] = $rows;
                                            }
                                            
                                            $deskripsi 	= $data[0][1];
                                            $bobot 		= $data[0][2];
                                            $err		=$_GET['err'];
                                            $success	=$_GET['scs'];
                                            ?>

										<tr>
											<td>Deskripsi</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="deskripsi" data-options="required:true" value="<?php echo $deskripsi ?>"></input></td>
											<input type="hidden" class="form-control" name="id" data-options="required:true" value="<?php echo $id ?>"></input>
										</tr>
										<tr>
											<td>Bobot</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="bobot" data-options="required:true" value="<?php echo $bobot ?>"></input></td>
										</tr>

										<tr>
											<td colspan='4'><font color="red"><?php echo $err; ?></font></td>
										</tr>
										<tr>
											<td colspan='4'><button type="submit" class="btn btn-info" onclick="document.getElementById('submitForm').submit()">Submit</button></td>
										</tr>
										</tr>
											<td><font color="green"><?php echo $success ?></font></td>
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
		
	<?php include("lib/footers.php");?>
	</body>
</html>