<?php 
session_start();	
include_once('lib/head.php');
include_once("lib/check.php");
?>

<?php 
		$spj_no	= $_GET['spj_no'];
		$area_kode	= $_GET['area_kode'];

		//$query = "select * from tb_vendor where vendor_id='$vendor_id' ";
		$query = "SELECT a.spj_no, a.PROGRESS_VALUE, a.REALISASI, a.progress_date, 
				a.PROGRESS_PENGAWAS, a.progress_notes from tb_progress a join tb_spj b on a.SPJ_NO =b.SPJ_NO 
				and b.AREA_KODE=$area_kode and a.SPJ_NO='$spj_no'";
		$resultQuery=mysqli_query($query);
		while ($rows=mysqli_fetch_row($resultQuery)){ 
			$data[] = $rows;
		}
		$spj_no	= $data[0][0];
		$progress= $data[0][1];
		$realisasi= $data[0][2];
		$progress_date= $data[0][3];
		$pengawas		=$data[0][4];
		$notes		=$data[0][5];

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
							<header class="panel-heading">Edit Progress Pekerjaan</header>
							<div class="panel-body" onload=disableselect();>
								<form class="form-horizontal tasi-form" method="post" action="edit_progress_submit.php">
										
									<div class="form-group">
                                          	<label class="col-sm-2 control-label col-lg-2" for="inputSuccess">Nomor SPJ</label>
                                          	<div class="col-lg-10">
											<input type="text" class="form-control" name="" id="spj_no" value=<?php echo "'$spj_no'";?> disabled>
											<input type="hidden" class="form-control" name="var_spj_no" id="" value=<?php echo "'$spj_no'";?>>
												
                                          	</div>
                                    </div>
									
									<div class="form-group">
                                          	<label class="col-sm-2 control-label col-lg-2" for="inputSuccess">Progress Sekarang</label>
                                          	<div class="col-lg-10">
											<input type="text" class="form-control" name="" id="" value=<?php echo "'$progress'";?> disabled>
											<input type="hidden" class="form-control" name="progress_sebelum" id="" value=<?php echo "'$progress'";?>>
												
                                          	</div>
                                    </div>
									
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Progress Perubahan</label>
										<div class="col-sm-10">
											<!--<input type="text" class="form-control" name="var_progress">-->
											<select class="form-control m-b-10" name="var_progress" id="var_progress">
												<option value=''>-pilih progress-</option>
												<?php
													for($i=5;$i<=90;$i+=5){
														echo "<option value='$i'>$i%</option>";
													}
												?>
												<option value='100'>100%</option>
												<option value='130'>130%</option>
											</select>
										</div>
									</div>
										
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Tanggal</label>
										<div class="col-sm-3">
											<div class="input-group m-b-10">
                                               <input type="date" class="form-control" id="tanggal_progress" name="tanggal_progress" value=<?php echo "'$progress_date'";?> >
                                                
                                            </div>
										</div>										
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Realisasi</label>
										<div class="col-sm-3">
											<div class="input-group m-b-10">
                                               	<input type="text" class="form-control" id="realisasi" name="var_realisasi" value=<?php echo "'$realisasi'";?> >
                                                
                                            </div>
										</div>										
									</div>
									
										
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Nama Pengawas</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="var_nama_pengawas" value=<?php echo "'$pengawas'";?>>
										</div>
									</div>
										
									<div class="form-group">	
										<label class="col-sm-2 col-sm-2 control-label">Komentar</label>
										<div class="col-sm-3">
											<textarea style="width:" rows="3" name="var_deskripsi"><?php echo "$notes";?></textarea>
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