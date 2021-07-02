<?php session_start();
	include_once('lib/head.php');
	include_once("lib/check.php");?>
	<body class="skin-black">
		<?php include_once("lib/header.php");
			$area_kode=$_SESSION['area'];
		?>	
		<div class="wrapper row-offcanvas row-offcanvas-left">
			<!-- Left side column. contains the logo and sidebar -->
			<?php include_once("lib/menu.php");?>

			<aside class="right-side">

				<!-- Main content -->
				<section class="content">
					
					<div class="row">
						<div class="col-md-12">
							<section class="panel">
								<header class="panel-heading">Upload Data</header>
								<div class="panel-body">
									<form class="form-horizontal tasi-form" method="post" action="dl_db_submit.php">		
										<div class="form-group">
											<label class="col-sm-2 control-label col-lg-2">Jenis Data</label>
											<div class="col-lg-10">
												<select class="form-control m-b-10" name="var_tabel" id="var_tabel">
														<option value="">-- Pilih Tabel --</option>
														<option value="1">SPJ</option>
														<option value="2">SKKI/O</option>
												 </select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 col-sm-2 control-label"></label>
											<div class="col-sm-10">
												<div class="col-md-6 form-group">
													<div  id="isi_data">
														<div class="alert alert-info">
															<strong>Silahkan pilih tabel</strong>
														</div>
													</div>
												</div>
											</div>
										</div>
									</form>
								</div>
							</section>
						</div>
					</div>
				</section><!-- /.content -->
			</aside><!-- /.right-side -->
		</div>
		<?php include("lib/footer.php");?>
		<script>
           $("#var_tabel").change(function(){
		        var tabel = $("#var_tabel").val();
				var showData = "";
		        if(tabel == 0)
		        {
		            $("#isi_data").html("<div class='alert alert-info'><strong>Silahkan Pilih Tabel Database</strong></div>");
		        }else{
					$("#isi_data").html("<button type='submit' class='btn btn-info' onclick='document.getElementById('submitForm').submit()'>Download</button>");
				}
		    })
</script>
	</body>
</html>