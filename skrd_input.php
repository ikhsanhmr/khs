<?php
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
include_once("lib/function.php");
?>

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
					<header class="panel-heading">Input SKRD</header>
					<div class="panel-body">
						<form class="form-horizontal tasi-form" method="post" action="skrd_input_submit.php">
							<div class="form-group">
	                            <label class="col-sm-2 col-sm-2 control-label">No. Surat Ke PTSP</label>
	                            <div class="col-sm-10">
	                            <select class="form-control" name="var_no_surat_ptsp">
	                            	<option>- Pilih No Surat Ke PTSP -</option>
	                            	<?php
										$data=select_perijinan();
										for($i=0;$i<count($data);$i++){
											$current_no_surat_ptsp	= $data[$i]['surat_ijin_no'];
									?>
									<option value='<?php echo $current_no_surat_ptsp; ?>'><?php echo $current_no_surat_ptsp;?></option>
									<?php
										}
									?>
	                            </select>
	                            </div>
							</div>	
										
							<div class="form-group">
								<label class=" col-sm-2 col-sm-2 control-label">Tanggal Terbit SKRD</label>
								<div class="col-md-2">
								<input type="date" class="form-control" name="var_tgl_terbit_skrd" id="datepick">
								</div>
							</div>

							<div class="form-group">
	                            <label class="col-sm-2 col-sm-2 control-label">Biaya Retribusi</label>
	                            <div class="col-sm-10">
	                            <input type="text" class="form-control" name="var_biaya_retribusi" placeholder="Biaya Retribusi"></input>
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
	
<?php include("lib/footer.php");?>
</body>
</html>