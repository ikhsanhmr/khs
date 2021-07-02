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
									<form enctype="multipart/form-data" class="form-horizontal tasi-form" method="post" action="up_db_submit.php" name="upload_form" onsubmit="return check();">		
										<div class="form-group">
											<label class="col-sm-2 control-label col-lg-2">Jenis Data</label>
											<div class="col-lg-10">
												<select class="form-control m-b-10" name="var_jenis_data" id="jenis_data">
														<option value="">-- Jenis Data --</option>
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
															<strong>Silahkan Memilih Jenis Data</strong>
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
           $("#jenis_data").change(function(){
		        var jenis_data = $("#jenis_data").val();
		        var area = "<?php echo $_SESSION['area'] ?>"
				var showData = "";
		        if(jenis_data == 0)
		        {
		            $("#isi_data").html("<div class='alert alert-info'><strong>Silahkan Pilih Jenis Data</strong></div>");
		        }else{
					$("#isi_data").html("Select a file: <input type='file' name='excel_data' id='excel_data' accept='.xlsx'></br><button type='submit' class='btn btn-info' onclick='document.getElementById('submitForm').submit()'>Submit</button>");
				}
		    })
			
			function check() {
				var ext = document.upload_form.excel_data.value;
				ext = ext.substring(ext.length-4,ext.length);
				ext = ext.toLowerCase();
				if(ext != 'xlsx') {
					alert('Format File Harus .xlsx');
					return false; 
				}else
					return true; 
				}
</script>
	</body>
</html>