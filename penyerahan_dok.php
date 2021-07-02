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
					<header class="panel-heading">Penyerahan Dokumen </header>
					<div class="panel-body">
						<form class="form-horizontal tasi-form" method="post" action="penyerahan_dok_submit.php">
							<div class="form-group">
	                            <label class="col-sm-2 col-sm-2 control-label">No. SPJ</label>
	                            <div class="col-sm-10">
	                            <select class="form-control" name="var_no_spj">
	                            	<option>- Pilih No SPJ -</option>
	                            	<?php
										$sql = "SELECT * FROM TB_SPJ WHERE SPJ_STATUS='0' AND PAKET_JENIS IN (1,2) ";
										$resultQuery=mysqli_query($sql);
										while ($rows=mysqli_fetch_row($resultQuery)){ 
											$data[] = $rows;
										}
										//$jum_spj= count($data);
										for($i=0;$i<count($data);$i++){
											$current_spj_no	= $data[$i][0];
									?>
									<option value='<?php echo $current_spj_no; ?>'><?php echo $current_spj_no;?></option>
									<?php
										}
									?>
	                            </select>
	                            </div>
							</div>	
										
							<div class="form-group">
								<label class=" col-sm-2 col-sm-2 control-label">Tanggal Penyerahan Dokumen</label>
								<div class="col-md-2">
								<input type="date" class="form-control" name="var_tgl_serah" id="datepick">
								</div>
							</div>

							<div class="form-group">
								<label class=" col-sm-2 col-sm-2 control-label">Jumlah Dokumen yang Diserahkan</label>
								<div class="col-sm-10">
								<input type="text" class="form-control" name="var_jumlah_dok" id="var_jumlah_dok" placeholder="Jumlah Dokumen Yang Diserahkan">
								</div>
							</div>

							<div class="form-group">
	                            <label class="col-sm-2 col-sm-2 control-label">Keterangan</label>
	                            <div class="col-sm-10"><textarea class="form-control" name="var_keterangan" id="var_keterangan" placeholder="Keterangan"></textarea></div>
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