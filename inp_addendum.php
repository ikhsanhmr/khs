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
								<header class="panel-heading">Addendum</header>

								<div class="panel-body" onload=disableselect();>
									<form class="form-horizontal tasi-form" method="post" action="inp_addendum_submit.php">
										<div class="form-group">
											<label class="col-sm-2 control-label col-lg-2">Nomor SPJ</label>
											<div class="col-lg-10">
												<select class="form-control m-b-10" name="var_no_spj" id="spj">
													  <option value="">-- SPJ --</option>
														<?php
                                                            $data = get_spj_by_area($area_kode, $mysqli);
                                                            for ($i=0;$i<count($data);$i++) {
                                                                $current_spj_no = $data[$i][0]; ?>
																<option value='<?php echo $current_spj_no?>'><?php echo $current_spj_no; ?></option><?php
                                                            }
                                                        ?>
												  </select>
											</div>
										</div>
										<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label"></label>
										<div class="col-sm-10">

										<div class="col-md-6 form-group">
										<div class="alert alert-info" id="spjdata">
											<strong>Silahkan Memilih No SPJ!</strong>
				                    	</div>
				                    	</div>

										</div>
										</div>
										<div class="form-group">
                                          <label class="col-sm-2 col-sm-2 control-label">Nomor Addendum</label>
                                          <div class="col-sm-10" id="no_add">
                                             <input type="text" class="form-control" name="var_no_addendum" required>
                                          </div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-2 col-sm-2 control-label">Nilai Addendum (Sebelum PPN)</label>
											<div class="col-md-2" form-group >
		                                       <input type="text" class="form-control" name="min_ppn" id="min_ppn" placeholder="nilai sebelum ppn" required>
	                                    	</div>
	                                    	<div class="col-md-2" form-group >
		                                       <input type="text" class="form-control" name="ppn" id="ppn" placeholder="ppn 10%" readonly>
	                                    	</div>
											<div class="col-md-2">
												<input type="text" class="form-control" name="var_nilai_addendum" id="nilai" placeholder="nilai setelah ppn" readonly>
											</div>	
										</div>
										<div class="form-group">
											<label class=" col-sm-2 col-sm-2 control-label">Tanggal Addendum</label>
												<div class="col-md-2">
													<input type="date" class="form-control" name="var_tanggal_add" id="tgl_amd" required >
												</div>
										</div>

										<div class="form-group">
											<label class=" col-sm-2 col-sm-2 control-label">Tanggal Akhir SPJ </label>
												<div class="col-md-2">
													<input type="date" class="form-control" name="var_tanggal_akhir" id="tgl_add" required>
												</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 col-sm-2 control-label">SKKI/O Awal</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="var_skki_awal" id="skki_awal" readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label col-lg-2">SKKI/O Tujuan</label>
											<div class="col-lg-10">
												<select class="form-control m-b-10" name="var_skki_tujuan" id="skki_tujuan">
													  	
													  	<option value="-">- (Pilih Jika SKKI/O Berubah)</option>
														<?php
                                                            $data = get_all_skki($area_kode, $mysqli);
                                                            for ($i=0;$i<count($data);$i++) {
                                                                $current_skki = $data[$i]['SKKI_NO'];
                                                                $keterangan = $data[$i]['keterangan']; ?>
																<option value='<?php echo $current_skki?>'><?php echo $current_skki. '  ' .$keterangan; ?></option><?php
                                                            }
                                                        ?>
												  </select>
											</div>
										</div>
										
										<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Target Volume Awal</label>
										<div class="col-sm-3">
											<div class="input-group m-b-10">
												<input type="hidden" class="form-control" name="target_awal" id="var_target2">
                                               	<input type="text" class="form-control" name="var_target" id="var_target" readonly>
                                                <span class="input-group-addon" id="satuan" ></span>
                                            </div>
										</div>										
										</div>
										
										<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Target Volume Addendum  </label>
										<div class="col-sm-3">
											<div class="input-group m-b-10">
                                               	<input type="text" class="form-control" name="ad_var_target" id="ad_var_target" required>
                                                <span class="input-group-addon" id="satuan2" ></span>
                                            </div>
										</div>										
										</div>

										<div class="form-group">	
											<label class="col-sm-2 col-sm-2 control-label" name="var_deskripsi">Deskripsi</label>
												<div class="col-sm-3">
													<textarea rows="3" cols="125" name="var_deskripsi" required></textarea>
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
			function dateFormat(date){
				var d = date.getDate().toString();
				d=d.length>1?d:'0'+d;
				var m = (date.getMonth()+1).toString();
				m=m.length>1?m:'0'+m;
				var y = date.getFullYear().toString();
				return d+'-'+m+'-'+y;
			}

			$("#min_ppn").keyup(function(event){
		//var nilai = $("#min_ppn").val().replace(/,/g,"");
		//alert(nilai);
		//var ppn = (10 / 100) * nilai;
		//var total = nilai + ppn;
		$("#ppn").val( Math.floor($("#min_ppn").val().replace(/,/g,"") * 10/100).toLocaleString('en') );
		$("#nilai").val( Math.floor($("#min_ppn").val().replace(/,/g,"") * 110/100).toLocaleString('en') );
		})
		
           	$("#spj").change(function(){
		        var spj = $("#spj").val();
		        var area = "<?php echo $_SESSION['area'] ?>"
		        //alert(spj);
		        //alert(area);
				
		        if(spj == 0)
		        {
		            $("#spjdata").html("<strong>Pilih No SPJ!</strong>");
		        }
		        else
		        {
		            $.getJSON('getspj.php',{'no_spj' : spj,'area' : area},function(data){
		                var showData = "";
		                $.each(data,function(index,value){
							var d_awal = new Date(value.SPJ_TANGGAL_MULAI);
							var d_akhir = new Date(value.SPJ_TANGGAL_AKHIR);
							var akhir = dateFormat(d_akhir);
							var awal = dateFormat(d_awal);
							var nilai_spj = numeral(value.SPJ_NILAI);
							nilai_spj = nilai_spj.format('0,0');
							var paket = value.PAKET_JENIS;
							var gangguan = value.gangguan;
							//alert(paket);
							//if (paket == 11 || paket == 9 || gangguan == 1){
							//if (paket == 11 || gangguan == 1){
								if (gangguan == 1){
								 document.getElementById("skki_tujuan").disabled = true;
								 //$("#skki_tujuan").html("<option value="">- (Pilih Jika SKKI/O Tidak Berubah)</option>");
								 $("#skki_tujuan").val("-");
							}

							//var test = $("#skki_tujuan").val();
							//alert (test);
		                	showData += "<table><tr><td>No SPJ</td><td>:</td><td>"+value.SPJ_NO+"</td></tr><tr><td>Nama Vendor</td><td>:</td><td>"+value.VENDOR_NAMA+"</td></tr><tr><td>Nilai SPJ</td><td>:</td><td>Rp."+nilai_spj+"</td></tr><tr><td>Tanggal Awal</td><td>:</td><td>"+awal+"</td></tr><tr><td>Tanggal Akhir</td><td>:</td><td>"+akhir+"</td></tr></table>";
		               })
		                $("#spjdata").html(showData);

		            })

		            $.getJSON('get_skki.php',{'no_spj' : spj},function(data){
		                
		                $.each(data,function(index,value){
							var skki_awal = value.skki_no;
							//alert(skki_awal);
		                	document.getElementById("skki_awal").value = skki_awal;
		                })
		            })
					
					$.getJSON('get_target.php',{'spj_no' : spj},function(data){
						var str= JSON.stringify(data);
						$("#var_target").val(data);
						$("#var_target2").val(data);
					})
					
					$.getJSON('get_paket.php',{'spj_no' : spj},function(data){
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
		        }
		    })
		    


</script>
	</body>
</html>