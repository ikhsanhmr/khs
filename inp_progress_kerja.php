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
												<option value="">- Pilih NO SPJ -</option>
													<?php
                                                        //$data=select_spj_no($kode_area); di edit setelah -10 + 30
                                                        $data=select_spj_no_termin($kode_area, $mysqli);
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
										<label class="col-sm-2 col-sm-2 control-label">SPJ  Deskripsi</label>
										<div class="col-sm-3">
											<div class="input-group m-b-10">
                                               	<textarea class="form-control" style="width:885px" rows="3" name="" id="spj_deskripsi" readonly>
												</textarea>
                                            </div>
										</div>										
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Target Pekerjaan</label>
										<div class="col-sm-3">
											<div class="input-group m-b-10">
                                               	<input type="text" class="form-control" name="target_realisasi" id="target_realisasi" readonly>
                                                <span class="input-group-addon" id="satuan"></span>
                                            </div>
										</div>										
									</div>
									
										
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Progress Pekerjaan</label>
										<div class="col-sm-10">
											<!--<input type="text" class="form-control" name="var_progress">-->
											<select class="form-control m-b-10" name="var_progress" id="var_progress">
												<option value=''>-pilih progress-</option>
												<?php
                                                    for ($i=5;$i<=90;$i+=5) {
                                                        echo "<option value='$i'>$i%</option>";
                                                    }
                                                ?>
												<option value='100'>100%</option>
												<option value='130'>130%</option>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Realisasi</label>
										<div class="col-sm-3">
											<div class="input-group m-b-10">
                                               	<input type="text" class="form-control" id="realisasi" name="var_realisasi" required>
                                                <span class="input-group-addon" id="satuan2"></span>
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
										<label class="col-sm-2 col-sm-2 control-label">Nomor  TUG 9</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="no_tug9" required>
										</div>
									</div>
									
									<div class="form-group">
										<label class=" col-sm-2 col-sm-2 control-label">Tanggal TUG 9</label>
										<div class="col-md-2">
											<input type="date" class="form-control" name="tgl_tug9" id="tgl_tug9" required>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Nomor  TUG 10</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="no_tug10" required>
										</div>
									</div>
									
									<div class="form-group">
										<label class=" col-sm-2 col-sm-2 control-label">Tanggal TUG 10</label>
										<div class="col-md-2">
											<input type="date" class="form-control" name="tgl_tug10" id="tgl_tug10" required>
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
		document.getElementById("realisasi").value="";
		document.getElementById("var_progress").value="";
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
			
			span2 = document.getElementById("satuan2");
			var str2= JSON.stringify(data);
			var satuan2_json = str2.replace('[["', " ").replace('"]]'," ");
			span2.innerText = satuan_json;
			})
		})
		
		$.getJSON('get_target.php',{'spj_no' : spj_no},function(data)
			{
				var str= JSON.stringify(data);
				$("#target_realisasi").val(data);
			})
			
		$.getJSON('get_deskripsi.php',{'spj_no' : spj_no},function(data)
			{
				var str= JSON.stringify(data);
				$("#spj_deskripsi").val(data);
			})	
	})
	
	$("#var_progress").change(function(){
		var spj_no = $("#spj_no").val();
		$.getJSON('get_target.php',{'spj_no' : spj_no},function(data)
			{
				var str= JSON.stringify(data);
				var var_progress = $("#var_progress").val();
				var hasil_data = (var_progress * data)/100;
				$("#realisasi").val(hasil_data);
			})
	})
	
	
</script>
</body>
</html>