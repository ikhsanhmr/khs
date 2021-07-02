<?php session_start();
	  include_once('lib/head.php');
	  include_once("lib/check.php");?>
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
								<header class="panel-heading">EDIT FINANSIAL</header>
								<div class="panel-body table-responsive">
									<form class="form-horizontal tasi-form" method="post" action="fin_vendor_edit_submit.php">
										<table class="table table-hover">
											<?php
													$vendor_id = $_GET['vendor_id'];
													$query = "select * from tb_fin_vendor where vendor_id = $vendor_id";
													$resultQuery=mysqli_query($query);
													while ($rows=mysqli_fetch_row($resultQuery)){ 
														$data[] = $rows;
													}
													$current_vendor_id = $data[0][0];
													$current_rating = $data[0][1];
													$current_fin_limit = $data[0][2];
													$current_fin_current = $data[0][3];
													$current_fin_limit=number_format($current_fin_limit);
													$current_fin_current=number_format($current_fin_current);
													$err=$_GET['err'];
													$success=$_GET['scs'];
											?>
											<tr>
												<td>VENDOR ID</td>
												<td>:</td>
												<td><input type="text" name="var_vendor_id" data-options="required:true" value="<?php echo $current_vendor_id ?>"readonly></input></td>
											</tr>
											<tr>
												<td>RATING LAPORAN AUDIT</td>
												<td>:</td>
												<td><input type="text" name="var_rating" data-options="required:true" value="<?php echo $current_rating?>"></input></td>
											</tr>
											<tr>
												<td>FINANSIAL LIMIT</td>
												<td>:</td>
												<td><input type="text" name="var_fin_limit" data-options="required:true" value="<?php echo $current_fin_limit ?>"></input></td>
											</tr>
											<tr>
												<td>FINANSIAL CURRENT</td>
												<td>:</td>
												<td><input type="text" name="var_fin_current" data-options="required:true" value="<?php echo $current_fin_current ?>"readonly></input></td>
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
		<?php include("lib/footer.php");?>
	</body>
</html>