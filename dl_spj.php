<?php session_start();
    include_once('lib/head.php');
    include_once("lib/check.php");
    if (isset($_GET['err'])) {
        switch ($_GET['err']) {
            case 1:
                $err = "nama manager tidak boleh kosong";
                break;
            case 2:
                $err = "belum memilih spj";
        }
    }?>
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
								<header class="panel-heading">Mengunduh SPJ</header>

								<div class="panel-body" onload=disableselect();>
									<form class="form-horizontal tasi-form" method="post" action="addendum_print.php">
										<div class="form-group">
											<label class="col-sm-2 control-label col-lg-2">Nama Manager</label>
											<div class="col-sm-10">
													<input type="text" class="form-control" name="nama_manager"></input>
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-2 control-label col-lg-2">Nomor SPJ</label>
											<div class="col-lg-10">
												<select class="form-control m-b-10" name="var_no_spj" id="spj">
													  <option value="">-- SPJ --</option>
														<?php
                                                            $data = select_spj_no($area_kode, $mysqli);
                                                            for ($i=0;$i<count($data);$i++) {
                                                                $current_spj_no = $data[$i][0]; ?>
																<option value='<?php echo $current_spj_no?>'><?php echo $current_spj_no; ?></option><?php
                                                            }
                                                        ?>
												  </select>
											</div>
										</div>
										
										<div  class="form-group">
											<div class="col-sm-2"></div>
											<div  class="col-lg-10">
												<font color="red"><?php echo $err?></font>
											</div>
										</div>
										
										<div class="form-group">
											<div class="col-lg-offset-2 col-lg-10">
												<button type="submit" class="btn btn-info" onclick="document.getElementById('submitForm').submit()">Download</button>
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