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
							<header class="panel-heading">EDIT Kriteria Penilaian</header>
							<div class="panel-body table-responsive">
								<form class="form-horizontal tasi-form" method="post" action="penilaian_kriteria_edit_submit.php">
									<table class="table table-hover">
										<?php
											$id = $_GET['id'];
											$query = "SELECT B.deskripsi, A.id_kriteria, A.bobot, A.kriteria, A.id_deskripsi from penilaian_kriteria A
													join penilaian_deskripsi B on A.id_deskripsi=B.id_deskripsi where A.id_kriteria = '$id'";
															
											$resultQuery=mysqli_query($query);
											while ($rows=mysqli_fetch_row($resultQuery)){ 
												$datas[] = $rows;
											}
											
											$mutu = $datas[0][0];
											$ids = $datas[0][1];
											$bobots = $datas[0][2];
											$kriteria = $datas[0][3];
											$deskripsi = $datas[0][4];
											
											?>
											
										<tr>
											<input type="hidden" class="form-control" name="id" data-options="required:true" value="<?php echo $ids ?>"></input>
											<td>Deskripsi</td>
											<td>:</td>
											<td><select class="form-control m-b-10" name="deskripsi">
													<option value=0>- Pilih Deskripsi -</option>
													<?php
														$data=select_penilaian_deskripsi();
														for($i=0;$i<count($data);$i++){
															$current_deskripsi = $data[$i][1];
															?><option <?php if ($deskripsi==$data[$i][0]){ echo "selected='".$deskripsi."'";}else{echo "";} ?> value=<?php echo $data[$i][0]?>> <?php echo $current_deskripsi;?> </option>
															  
															<?php
														}
													?>
												
												</select></td>
												</tr>
										<tr>
											<td>Kriteria</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="kriteria" data-options="required:true" value="<?php echo $kriteria ?>"></input></td>
										</tr>
										<tr>
											<td>Bobot</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="bobot" data-options="required:true" value="<?php echo $bobots ?>"></input></td>
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