<?php
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
?>

<body class="skin-black">
	<!--include file header-->
	<?php
	include("lib/header.php");
	$area_kode = $_SESSION['area'];
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
							<header class="panel-heading">EDIT Master Vendor</header>
							<div class="panel-body table-responsive">
								<form class="form-horizontal tasi-form" method="post" action="master_vendor_edit_submit.php">
									<table class="table table-hover">
										<?php
										$vendor_id = $_GET['vendor_id'];
										$query = "SELECT vendor_nama, tahun, direksi_vendor, email, telepon, jabatan,vendor_id 
														from tb_vendor where vendor_id='$vendor_id'";
										$resultQuery = mysqli_query($mysqli, $query);
										while ($rows = mysqli_fetch_row($resultQuery)) {
											$data[] = $rows;
										}
										$vendor_nama		 	= $data[0][0];
										$tahun_pekerjaan	 	= $data[0][1];
										$direksi			 	= $data[0][2];
										$email					= $data[0][3];
										$telepon				= $data[0][4];
										$jabatan				= $data[0][5];
										$vendor_id				= $data[0][6];
										$err					= $_GET['err'];
										$success				= $_GET['scs'];
										?>

										<tr>
											<td>Nama Vendor</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="var_vendor" data-options="required:true" value="<?php echo $vendor_nama ?>"></input></td>
											<input type="hidden" class="form-control" name="vendor_id" data-options="required:true" value="<?php echo $vendor_id ?>"></input>
										</tr>
										<tr>
											<td>Tahun Pekerjaan</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="tahun_pekerjaan" data-options="required:true" value="<?php echo $tahun_pekerjaan ?>"></input></td>
										</tr>
										<tr>
											<td>Direksi Vendor</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="direksi_vendor" data-options="required:true" value="<?php echo $direksi ?>"></input></td>
										</tr>
										<tr>
											<td>Jabatan</td>
											<td>:</td>
											<td>
												<select class="form-control m-b-10" name="jabatan" id="jabatan" required>
													<option value="Direktur Utama">Direktur Utama</option>
													<option value="Direktur">Direktur</option>

												</select>
										</tr>
										<tr>
											<td>Email</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="email" id="nilai" data-options="required:true" value="<?php echo $email ?>"></input></td>
										</tr>

										<tr>
											<td>Telepon</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="telepon" id="nilai" data-options="required:true" value="<?php echo $telepon ?>"></input></td>
										</tr>

										<tr>
											<td colspan='4'>
												<font color="red"><?php echo $err; ?></font>
											</td>
										</tr>
										<tr>
											<td colspan='4'><button type="submit" class="btn btn-info">Submit</button></td>
										</tr>
										</tr>
										<td>
											<font color="green"><?php echo $success ?></font>
										</td>
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

	<?php include("lib/footers.php"); ?>
</body>

</html>