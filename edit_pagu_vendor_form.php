<?php
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
?>
<script type="text/javascript" src="js/jquery.js"></script>


<body class="skin-black">
	<!--include file header-->
	<?php
        include("lib/header.php");
        $vendor_id	= $_GET['vendor_id'];
        $paket_jenis	= $_GET['paket_jenis'];

        //$query = "select * from tb_vendor where vendor_id='$vendor_id' ";
        $query = "SELECT A.VENDOR_ID, A.VENDOR_NAMA, B.PAKET_JENIS, B.PAGU_KONTRAK, 
									B.TERPAKAI FROM tb_vendor A, tb_pagu_kontrak B WHERE A.VENDOR_ID=B.VENDOR_ID and A.vendor_id='$vendor_id'
									and B.PAKET_JENIS='$paket_jenis'";
                                    
                                
        $resultQuery=mysqli_query($mysqli, $query);
        while ($rows=mysqli_fetch_row($resultQuery)) {
            $data[] = $rows;
        }
        $current_vendor_id	= $data[0][0];
        $current_vendor_nama= $data[0][1];
        $paket_jenis= $data[0][2];
        $pagu_kontrak= $data[0][3];
        $err		=$_GET['err'];
        $success	=$_GET['scs'];
    

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
							<header class="panel-heading">REVISI PAGU KONTRAK VENDOR</header>
							<div class="panel-body table-responsive">
								<form class="form-horizontal tasi-form" method="post" action="edit_pagu_vendor_submit.php" enctype="multipart/form-data">
									<table class="table table-hover">
										<div class="form-group">
                                          	<label class="col-sm-2 control-label col-lg-2" for="inputSuccess">Vendor</label>
                                          	<div class="col-lg-10">
												
												<input type="hidden" name="var_id_vendor" value=<?php echo "'$current_vendor_id'";?>>	
												<input type="hidden" name="paket_jenis" value=<?php echo "'$paket_jenis'";?>>	
												<input type="hidden" name="pagu_kontrak" value=<?php echo "'$pagu_kontrak'";?>>	
                                              	<input type="text" class="form-control" name="" id="var_id_vendor" value=<?php echo "'$current_vendor_nama'";?> disabled>
												
                                          	</div>
                                      	</div>
										
										<div class="form-group">
                                          	<label class="col-sm-2 control-label col-lg-2" for="inputSuccess">Paket Jenis</label>
                                          	<div class="col-lg-10">
											<input type="text" class="form-control" name="" id="paket_jenis" value=<?php echo "'$paket_jenis'";?> disabled>
												
                                          	</div>
                                      	</div>
										
										<div class="form-group">
                                          	<label class="col-sm-2 control-label col-lg-2" for="inputSuccess">Pagu Kontrak Vendor</label>
                                          	<div class="col-lg-10">
											<input type="text" class="form-control" name="" id="pagu_kontrak" value=<?php echo "'$pagu_kontrak'";?> disabled>
                                              	
                                          	</div>
                                      	</div>
										
                                      	<div class="form-group">
                                          	<label class="col-sm-2 col-sm-2 control-label">Upgrade Pagu Kontrak</label>
                                          	<div class="col-sm-10">
													<input type="text" class="form-control" placeholder="nilai upgrade pagu kontrak, tidak pakai koma atau titik" name="upgrade_pagu_kontrak">
                                          	</div>
                                      	</div>
										
										<div class="form-group">
												<label class=" col-sm-2 col-sm-2 control-label">Surat Permohonan Upgrade</label>
												<div class="col-sm-10">
												<input type="file" class="form-control" name="file_bukti_upgrade" id="file_bukti_upgrade" required>
												</div>
											</div>	
                                    
										
										<?php
                                            if (isset($err)) {
                                                ?>
										<tr>
											<td colspan='4'><font color="red"><?php echo $err; ?></font></td>
										</tr>
										<?php
                                            }
                                        ?>

										<div class="form-group">
											<div class="col-lg-offset-2 col-lg-10"><button type="submit" class="btn btn-info" onclick="document.getElementById('submitForm').submit()">Submit</button></div>
										</div>

										<tr>
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
