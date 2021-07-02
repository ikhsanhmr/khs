<?php session_start();
	include_once('lib/head.php');
	  include_once("lib/check.php");?>
	  
<script type="text/javascript" src="js/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="datatables/media/css/dataTables.bootstrap.css">
<link rel="stylesheet" type="text/css" href="datatables/examples/resources/syntax/shCore.css">
<style type="text/css" class="init">
	
</style>

<script type="text/javascript" language="javascript" src="datatables/media/js/jquery.dataTables.js">
</script>
<script type="text/javascript" language="javascript" src="datatables/media/js/dataTables.bootstrap.js">
</script>
<script type="text/javascript" language="javascript" src="datatables/examples/resources/syntax/shCore.js">
</script>

<script type="text/javascript" language="javascript" class="init">
	
$(document).ready(function() {
	$('#example').DataTable();
} );

</script>
	  
	<body class="skin-black">
		<!--include file header-->
		<?php 
			include("lib/header.php"); 
			$kode_area = $_SESSION['area'];
		?>
		<div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
			<?php include("lib/menu.php");
			
			$no_spj = $_GET["no_spj"];
			$verifikasi = $_GET["verifikasi"];
			
			
			?>
            <aside class="right-side">
                <!-- Main content -->
                <section class="content">
					<div class="row">
						<div class="col-md-12">
							<section class="panel">
								<header class="panel-heading">No SPJ : <?php echo $no_spj ?></header>
								<div class="panel-body">
									<form class="form-horizontal tasi-form" method="post" action="isi_verikasi_mup3_submit_tolak.php">
									
										<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Alasan Evaluasi Ditolak</label>
											<div class="col-sm-10">
												<input type="hidden" name="no_spj" value="<?php echo $no_spj ?>">
												<input type="hidden" name="verifikasi" value="<?php echo $verifikasi ?>">
												<input type="text" class="form-control" name="alasan_evaluasi" placeholder="alasan menolak evaluasi" required>
											</div>
										</div>
										
										<div class="form-group">
											<div class="col-lg-offset-2 col-lg-10">
												<button type="submit" class="btn btn-info" onclick="document.getElementById('submitForm').submit()">Submit</button>
										<a href="javascript:history.back()" class="btn btn-info pull-right"><i class="fa fa-backward"></i> Kembali</a>
											</div>
										</div>
									</form>			
							</section>
						</div>
					</div>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->

        </div>
	
	<?php include("lib/footer.php");?>
	</body>
</html>