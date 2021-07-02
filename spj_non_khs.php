<?php 
session_start();
include_once("lib/check.php");
include_once('lib/head.php');
?>

<body class="skin-black">
	<?php 
		include_once("lib/header.php");
		$area_kode=$_SESSION['area'];
	?>	
	<div class="wrapper row-offcanvas row-offcanvas-left">
		<!-- Left side column. contains the logo and sidebar -->
		<?php include_once("lib/menu.php");?>

		<aside class="right-side">

			<!-- Main content -->
			<section class="content">
					
				<div class="row">
					<div class="col-md-12">
						<section class="panel">
							<header class="panel-heading">Input SPJ non KHS</header>
							<div class="panel-body">
								<form class="form-horizontal tasi-form" method="post" action="non_khs_submit.php">
										<!-- <div class="form-group">
                                          <label class="col-sm-2 col-sm-2 control-label">Nama Manager</label>
                                          <div class="col-sm-10">
                                              <input type="text" class="form-control" name="var_nama_manager">
                                          </div>
										</div> -->
										
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Nomor SKKI/O</label>
										<div class="col-sm-10">
			                            <select class="form-control m-b-10" name="var_no_skkio">
			                            	<option value="">-- SKKI/SKKO --</option>
													<?php
														$data=select_skkio_no($area_kode);
														for($i=0;$i<count($data);$i++){
															$current_skki_no = $data[$i][0];
													?>
													<option value='<?php echo $current_skki_no?>'><?php echo $current_skki_no;?></option>
													<?php
														}
													?>
			                            </select>
			                            </div>
										<!--</div>
										
										<div class="form-group">-->
										<!-- 	<label class="col-sm-2 col-sm-2 control-label" for="inputSuccess">Paket Pekerjaan</label>
											<div class="col-sm-10">
												  <select class="form-control m-b-10" id="paket" name="var_paket_pekerjaan">
										            <option value="0">Pilih Paket</option>
										            <?php
											            $query  = "SELECT PAKET_JENIS,PAKET_DESKRIPSI FROM tb_paket";
											            $result = mysqli_query($query);
											            $output = '';
											            while($hasil = mysqli_fetch_assoc($result))
											            {
											                $output .= "<option value='".$hasil['PAKET_JENIS']."'>".$hasil['PAKET_DESKRIPSI']."</option> \n";
											            }
											            echo $output;
										            ?>
										        </select>
											</div>
										</div> -->

										
										
										<!-- tahun skarang date('Y'); -->
										<!-- <div id="update"></div>
										<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Vendor Yang Tersedia</label>
										<div class="col-sm-10">

										<table id="availablevendor" class="table table-condensed">								
				                            <tr><td>Pilih Paket Pekerjaan</td></tr>
				                        </table>

										
										</div>
										</div> -->

										<div class="form-group">	
											<label class="col-sm-2 col-sm-2 control-label" name="var_deskripsi_pekerjaan">Deskripsi Pekerjaan</label>
												<div class="col-sm-3">
													<textarea rows="3" class="form-control" name="var_deskripsi_pekerjaan"></textarea>
												</div>
										</div>
										
										<div class="form-group">
                                          <label class="col-sm-2 col-sm-2 control-label">Nomor SPJ</label>
                                          <div class="col-sm-10">
                                              <input type="text" class="form-control" name="var_no_spj">
                                          </div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-2 col-sm-2 control-label">Nilai SPJ</label>
											
											<div class="col-md-2" form-group >
		                                       <input type="text" class="form-control" name="min_ppn" id="min_ppn" placeholder="nilai sebelum ppn">
	                                    	</div>
	                                    	<div class="col-md-2" form-group >
		                                       <input type="text" class="form-control" name="ppn" id="ppn" placeholder="ppn 10%" readonly>
	                                    	</div>
											<div class="col-md-2">
												<input type="text" class="form-control" name="var_nilai_spj" id="nilai" placeholder="nilai setelah ppn" readonly>
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-2 col-sm-2 control-label">Nama Vendor</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="var_nama_vendor" >
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-2 col-sm-2 control-label">SPJ Berlaku Mulai</label>
											<div class="col-md-2">
												<input type="date" class="form-control" name="var_mulai_berlaku" id="datepick">
											</div>
											
											<label class=" col-sm-2 col-sm-2 control-label">Sampai Dengan</label>
											<div class="col-md-2">
												<input type="date" class="form-control" name="var_akhir_berlaku" id="datepick1">
											</div>
										</div>
										<div class="form-group">
											<div class="col-lg-offset-2 col-lg-10">
												<button type="submit" class="btn btn-info">Submit</button>
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
		<script>
         /*  $("#paket").change(function(){
		        var paket = $("#paket").val();
		        var area = "<?php echo $_SESSION['area'] ?>"
		        if(paket == 0)
		        {
		            $("#availablevendor").html("<tr><td>Pilih Paket Pekerjaan</label></td></tr>");
		        }
		        else
		        {
		            $.getJSON('getdata.php',{'paket_jenis' : paket,'area' : area},function(data){
		                var showData = null;
		                $.each(data,function(index,value){
							var limit = numeral(value.fin_limit).format('0,0');
							var sisa = numeral(value.sisa).format('0,0');
							showData += '<tr><td><input type="radio" name="var_vendor" id="optionsRadios1" value="'+value.vendor_id+'"></td><td>'+value.vendor_nama+'</td><td> Limit : Rp.'+limit+'</td><td> Sisa : Rp.'+sisa+'</td></tr>';
							//showData += "<option>"+value.vendor_nama+"</option>";
		                })
						if(showData==null){
							showData='<tr><td><i>TIDAK ADA VENDOR YANG TERSEDIA</i></td></tr>';
						}
		                $("#availablevendor").html(showData);
		            })
		        }
		    })*/

		$("#min_ppn").keyup(function(event){
		//var nilai = $("#min_ppn").val().replace(/,/g,"");
		//alert(nilai);
		//var ppn = (10 / 100) * nilai;
		//var total = nilai + ppn;
		$("#ppn").val( Math.floor($("#min_ppn").val().replace(/,/g,"") * 10/100).toLocaleString('en') );
		$("#nilai").val( Math.floor($("#min_ppn").val().replace(/,/g,"") * 110/100).toLocaleString('en') );
	})
</script>
	</body>
</html>