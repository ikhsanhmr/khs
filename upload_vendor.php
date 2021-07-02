<?php
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
include_once("lib/function.php");
?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>

<body class="skin-black">
	<!--include file header-->
	<?php 
	include("lib/header.php");
	$kode_area = $_SESSION['area'];
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
					<header class="panel-heading">Upload Vendor</header>
					<div class="panel-body">
						<form class="form-horizontal tasi-form" method="post" enctype="multipart/form-data" action="#.php" >
							<div class="form-group">
	                            <label class="col-sm-2 col-sm-2 control-label">Tahun</label>
	                            <div class="col-sm-3">
	                            	<input class="year form-control date-pick" id="var_tahun" name="var_tahun" placeholder="Tahun">
	                            	
	                            </div>
							</div>	
										
							<div class="form-group">
								<label class=" col-sm-2 col-sm-2 control-label">File</label>
								<div class="col-sm-3">
									<input type="file" class="form-control" name="file_vendor" id="file_vendor">
								</div>
							</div>
										
							<div class="form-group">
								<div class="col-lg-offset-2 col-lg-10">
								<button type="submit" class="btn btn-info" onclick="document.getElementById('submitForm').submit()">Submit</button>
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

	<script type="text/javascript">
      	$('.year').datepicker({
	        minViewMode: 2,
	        format: 'yyyy',
	        autoclose:true
       	});
  	</script>

<?php include("lib/footer.php");?>
</body>
</html>