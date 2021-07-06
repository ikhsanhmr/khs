<?php
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
?>

<body class="skin-black">
	<!--include file header-->
	<?php include("lib/header.php");
    $kode_area = $_SESSION['area'];?>	
		
	<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
	<?php include("lib/menu.php");?>

        <aside class="right-side">
        <!-- Main content -->
            <section class="content">
				<div class="row">
					<div class="col-md-12">
						<section class="panel">
							<header class="panel-heading">Progress Pekerjaan</header>
							<div class="panel-body" onload=disableselect();>
								<form class="form-horizontal tasi-form" method="post" action="inp_progress_kerja_submit.php">
										
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label" for="inputSuccess">Nomor SPJ</label>
										<div class="col-sm-10">
											<select class="form-control m-b-10" name="var_no_spj" id="spj_no">
												<option value="">- NO SPJ -</option>
													<?php
                                                        $data=select_spj_no($kode_area, $mysqli);
                                                        for ($i=0;$i<count($data);$i++) {
                                                            $current_spj_no = $data[$i][0]; ?>
												<option value='<?php echo $current_spj_no; ?>'><?php echo $current_spj_no; ?></option>
													<?php
                                                        }
                                                    ?>
												</select>
										</div>
									</div>
										
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Progress Pekerjaan</label>
										<div class="col-sm-10">
											<!--<input type="text" class="form-control" name="var_progress">-->
											<select class="form-control m-b-10" name="var_progress">
												<?php
                                                    for ($i=5;$i<=100;$i+=5) {
                                                        echo "<option value='$i'>$i%</option>";
                                                    }
                                                ?>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Realisasi</label>
										<div class="col-sm-2">
											<div class="input-group m-b-10">
                                               	<input type="text" class="form-control" name="var_realisasi" id="realisasi" required>
                                                <span class="input-group-addon" id="satuan"></span>
                                            </div>
										</div>										
									</div>
										
									<div class="form-group">
										<label class=" col-sm-2 col-sm-2 control-label">Tanggal</label>
										<div class="col-md-2">
											<input type="date" class="form-control" name="var_tanggal" id="tgl_progress" required>
										</div>
									</div>
										
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Nama Pengawas</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="var_nama_pengawas" required>
										</div>
									</div>
										
									<div class="form-group">	
										<label class="col-sm-2 col-sm-2 control-label">Komentar</label>
										<div class="col-sm-3">
											<textarea rows="3" name="var_deskripsi" required></textarea>
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
	
<?php include("lib/footers.php");?>
<script>
    $("#spj_no").change(function(){
		var spj_no = $("#spj_no").val();
		//alert(spj_no);
		$.getJSON('get_paket.php',{'spj_no' : spj_no},function(data){
		    
			var paket = JSON.parse(data);
			//alert(paket);
		 	$.getJSON('get_satuan.php',{'paket_jenis' : paket},function(data){
			//alert(data);
			span = document.getElementById("satuan");
			var str= JSON.stringify(data);
			var satuan_json = str.replace('[["', " ").replace('"]]'," ");
			span.innerText = satuan_json;
			})
		})
		
		

	})
</script>
</body>
</html>