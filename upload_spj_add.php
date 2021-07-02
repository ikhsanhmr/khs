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
								<header class="panel-heading">Upload Dokumen SPBJ / Addendum yang Sudah Ditandatangani</header>
								<div class="panel-body table-responsive">
									<form class="form-horizontal tasi-form" method="post" action="spj_add_upload_submit.php" enctype="multipart/form-data">
										<table class="table table-hover">
											<?php
													$spj_no = $_GET['id'];
											?>
											<tr>
												<td>SPJ NO</td>
												<td>:</td>
												<td><input type="text" class="form-control" name="var_spj_no" data-options="required:true" value="<?php echo $spj_no ?>"readonly></input></td>
											</tr>
											<tr>
												<td>Keterangan</td>
												<td>:</td>
												<td><input type="text" class="form-control" name="keterangan" data-options="required:true" placeholder="misal: Dokumen SPBJ;Addendum I, Addendum II, dst" required></input></td>
											</tr>
											<tr>
												<td>File Dokumen yang Sudah Ditandatangani</td>
												<td>:</td>
												<td><input type="file" class="form-control" name="file_dokumen" data-options="required:true"></input></td>
											</tr>
											<tr>
												<td colspan='4'><button type="submit" class="btn btn-info">Submit</button></td>
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