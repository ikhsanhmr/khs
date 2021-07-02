<?php
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
?>


<body class="skin-black">
<?php
include_once("lib/header.php");
$area_kode=$_SESSION['area'];
?>	
	
	<div class="wrapper row-offcanvas row-offcanvas-left">
	<!-- Left side column. contains the logo and sidebar -->
	<?php include_once("lib/menu.php");
    $hariini = date('Y-m-d');
    //echo $hariini;
    ?>
	
		<aside class="right-side">
		<!-- Main content -->
			<section class="content">
				<div class="row">
					<div class="col-md-12">
						<section class="panel">
						<header class="panel-heading">Input SPJ KHS</header>
						<div class="panel-body">
							<form class="form-horizontal tasi-form" method="post" action="seleksi_vendor_submit.php">
								
								<div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">Nama Manager</label>
                                	<div class="col-sm-10">
                                    	<input type="text" class="form-control" name="var_nama_manager" required>
                                    </div>
								</div>

								<div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">Direksi Pekerjaan</label>
                                	<div class="col-sm-10">
                                    	<input type="text" class="form-control" name="var_dir_pkj" required>
                                    </div>
								</div>

								<div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">Direksi Lapangan</label>
                                	<div class="col-sm-10">
                                    	<input type="text" class="form-control" name="var_dir_lpg" required>
                                    </div>
								</div>

									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Nilai SPJ (Sebelum PPN)</label>
										<div class="col-md-2" form-group >
	                                       <input type="text" class="form-control" name="min_ppn" id="min_ppn" placeholder="nilai sebelum ppn" required>
                                    	</div>
                                    	<div class="col-md-2" form-group >
	                                       <input type="text" class="form-control" name="ppn" id="ppn" placeholder="ppn 10%" readonly>
                                    	</div>
										<div class="col-md-2">
											<input type="text" class="form-control" name="var_nilai_spj" id="nilai" placeholder="nilai setelah ppn" readonly>
										</div>
									</div>


								<div class="form-group">
									<label class="col-sm-2 control-label col-lg-2">Lokasi Pekerjaan</label>
									<div class="col-lg-10">
										<select class="form-control m-b-10" name="var_lokasi" id="lokasi">
											<?php
                                                $data= ($area_kode != 54560) ? select_area_by_code($area_kode, $mysqli) : select_area($mysqli);
                                                for ($i=0;$i<count($data);$i++) {
                                                    $kode = $data[$i][0];
                                                    $nama = $data[$i][1]; ?>
											<option value='<?php echo $kode?>'><?php echo $nama; ?></option>
											<?php
                                                }
                                            ?>
										</select>
									</div>
								</div>



										
								<div class="form-group">
									<label class="col-sm-2 control-label col-lg-2">Nomor SKKI/O</label>
									<div class="col-lg-10">
										<select class="form-control m-b-10" name="var_no_skkio">
											<option value="">-- SKKI/SKKO --</option>
											<?php
                                                $data=select_skkio_no($area_kode, $mysqli);
                                                for ($i=0;$i<count($data);$i++) {
                                                    $current_skki_no = $data[$i][0];
                                                    $keterangan = $data[$i][1]; ?>
											<option value='<?php echo $current_skki_no?>'><?php echo $current_skki_no. '  ' .$keterangan; ?></option>
											<?php
                                                }
                                            ?>
										</select>
									</div>
								</div>										
									<!--<div class="form-group">-->

									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Jenis Pekerjaan</label>
										<div class="col-sm-2">
											<label class="radio-inline">
												<input type="radio" name="gangguan"  value="0" checked="checked">Non Gangguan
	                                        </label>
	                                        <label class="radio-inline">
												<input type="radio" name="gangguan"  value="1">Gangguan
	                                        </label>

	                                    </div>
									</div>

									<div class="form-group">
									<label class="col-sm-2 col-sm-2 control-label" for="inputSuccess">Paket Pekerjaan</label>
									<div class="col-sm-10">
										<select class="form-control m-b-10" id="paket" name="var_paket_pekerjaan">
										    <option value="9999">Pilih Paket</option>
										    <?php
                                                $query  = "SELECT PAKET_JENIS,PAKET_DESKRIPSI FROM tb_paket where STATUS = 1 ";
                                                //$query  = "SELECT PAKET_JENIS,PAKET_DESKRIPSI FROM tb_paket where PAKET_JENIS = 1 ";
                                                $result = mysqli_query($mysqli, $query);
                                                $output = '';
                                                while ($hasil = mysqli_fetch_assoc($result)) {
                                                    $output .= "<option value='".$hasil['PAKET_JENIS']."'>".$hasil['PAKET_DESKRIPSI']."</option> \n";
                                                }
                                                echo $output;
                                            ?>
										</select>
									</div>
									</div>

								<!-- tahun skarang date('Y'); -->
								<div id="update"></div>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Vendor Yang Tersedia</label>
										<div class="col-sm-10">
											<table id="availablevendor" class="table table-condensed">					
				                            <tr><td>Pilih Paket Pekerjaan</td></tr>
				                        	</table>
										<font color="red">*note: tidak ada vendor yang tersedia, karena belum ada vendor atau tanggal berakhir kontrak vendor sudah lewat</font>
										</div>
									</div>

									<div class="form-group">	
										<label class="col-sm-2 col-sm-2 control-label" name="var_deskripsi_pekerjaan">Deskripsi Pekerjaan</label>
										<div class="col-sm-3">
											<textarea rows="3" cols="123" name="var_deskripsi_pekerjaan" required></textarea>
										</div>
									</div>

									<!-- <div class="form-group">
                                        <label class="col-sm-2 col-sm-2 control-label">Nomor PJN</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="var_no_pjn">
                                        </div>
									</div>

									<div class="form-group"> 
										<label class="col-sm-2 col-sm-2 control-label">Tanggal PJN</label>
										<div class="col-md-2">
											<input type="date" class="form-control" name="var_tgl_pjn" id="datepick">
										</div>
									</div> -->
										
									<div class="form-group">
                                        <label class="col-sm-2 col-sm-2 control-label">Nomor SPJ</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="var_no_spj" required>
                                        </div>
									</div>
										
								
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Target Volume</label>
										<div class="col-sm-2">
											<div class="input-group m-b-10">
                                               	<input type="text" class="form-control" name="var_target" id="target" required>
                                                <span class="input-group-addon" id="satuan" ></span>
                                            </div>
										</div>										
									</div>

									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Metode Pembayaran</label>
										<div class="col-sm-2">
											<label class="radio-inline">
	                                            <input type="radio" name="option_bayar" id="termin" value="1" onClick="javascript:check_termin();">Termin
	                                        </label>
										</div>
									</div>

									<div class="form-group" id="termin_group" style="display:none;">
										<label class="col-sm-2 col-sm-2 control-label"></label>
										<div class="col-md-1" form-group >
	                                       <input type="text" class="form-control" name="var_termin_1" id="termin1" readonly>
                                    	</div>
                                    	<div class="col-md-1" form-group >
	                                       <input type="text" class="form-control" name="var_termin_2" id="termin2" readonly>
                                    	</div>
                                    	<div class="col-md-1" form-group >
	                                       <input type="text" class="form-control" name="var_termin_3" id="termin3" readonly>
                                    	</div>
                                    	<div class="col-md-1" form-group >
	                                       <input type="text" class="form-control" name="var_termin_4" id="termin4" readonly>
                                    	</div>
                                    	<div class="col-md-1" form-group >
	                                       <input type="text" class="form-control" name="var_termin_5" id="termin5" readonly>
                                    	</div>
									</div>


									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label"></label>
										<div class="col-sm-2">
											<label class="radio-inline">
												<input type="radio" name="option_bayar" id="non_termin" value="0" onClick="javascript:check_termin();">Non Termin
	                                        </label>
                                        </div>
									</div>
										
									<div class="form-group">
											<label class="col-sm-2 col-sm-2 control-label">SPJ Berlaku Mulai</label>
											<div class="col-md-2">
												<input type="date" class="form-control" name="var_mulai_berlaku" id="var_mulai_berlaku">
											</div>
											
											<label class=" col-sm-2 col-sm-2 control-label">Sampai Dengan</label>
											<div class="col-md-2">
												<input type="date" class="form-control" name="var_akhir_berlaku" id="var_akhir_berlaku">
											</div>
										</div>

									<div class="form-group">
										<div class="col-lg-offset-2 col-lg-10">
											<button type="submit" class="btn btn-info" onClick="document.getElementById('submitForm').submit()">Submit</button>
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
    $("#paket").change(function(){
		var paket = $("#paket").val();
		var area = $("#lokasi").val();
		var nilai = $("#nilai").val();
		var gangguan = $('input[name=gangguan]:checked').val();
		//alert(gangguan);
		if(paket == 9999)
		{
		    $("#availablevendor").html("<tr><td>Pilih Paket Pekerjaan</label></td></tr>");
		}
		else
		{
		    $.getJSON('getdata.php',{'paket_jenis' : paket,'area' : area, 'nilai' : nilai, 'gangguan' : gangguan},function(data){
		    	var showData = null;
		    	$.each(data,function(index,value){
					var limit = numeral(value.fin_limit).format('0,0');
					var sisa = numeral(value.sisa).format('0,0');
					var kontrak = numeral(value.PAGU_KONTRAK).format('0,0');
					var terpakai = (value.TERPAKAI/value.PAGU_KONTRAK)*100;
					showData += '<tr><td><input type="radio" name="var_vendor" id="optionsRadios1" value="'+value.vendor_id+'"></td><td>'+value.vendor_nama+'</td><td> Limit : Rp.'+limit+'</td><td> Sisa : Rp.'+sisa+'</td><td> Pagu Kontrak : Rp.'+kontrak+'</td><td> Pagu Kontrak Terpakai : '+terpakai.toPrecision(3)+' %</td></tr>';
					//showData += "<option>"+value.vendor_nama+"</option>";
		        })
				
				if(showData==null)
					{showData='<tr><td><i>TIDAK ADA VENDOR YANG TERSEDIA</i></td></tr>';}
		        $("#availablevendor").html(showData);
		    })

		    $.getJSON('get_satuan.php',{'paket_jenis' : paket},function(data){
		    
			//alert(data);
			//$("#target").val(data);
			span = document.getElementById("satuan");
			var str= JSON.stringify(data);
			var satuan_json = str.replace('[["', " ").replace('"]]'," ");
			span.innerText = satuan_json;
			//alert(satuan_json);
			})
		}

		
	})

	$("#min_ppn").change(function(){
		$("#availablevendor").html("<tr><td>Pilih Paket Pekerjaan</label></td></tr>");
	})

	$("input[name=gangguan]:radio").change(function () {
		$("#availablevendor").html("<tr><td>Pilih Paket Pekerjaan</label></td></tr>");
	})

	$("#min_ppn").keyup(function(event){
		//var nilai = $("#min_ppn").val().replace(/,/g,"");
		//alert(nilai);
		//var ppn = (10 / 100) * nilai;
		//var total = nilai + ppn;
		$("#ppn").val( Math.floor($("#min_ppn").val().replace(/,/g,"") * 10/100).toLocaleString('en') );
		//$("#nilai").val( Math.floor($("#min_ppn").val().replace(/,/g,"") * 110/100).toLocaleString('en') );
		var jumlah_spj=Math.floor($("#min_ppn").val().replace(/,/g,"") * 110/100).toLocaleString('en');
		$("#nilai").val(jumlah_spj);
		//--untuk termin <5M
		var rupiah=5000000000;
		//var penentu =Math.floor((5000000000).replace(/,/g,"") * 110/100).toLocaleString('en');
		var pecah_koma =jumlah_spj.replace(/,/g, "");

		var isi_termin1 = 55;
		var isi_termin2 = 100;
		var isi_termin3 = 0;
		
		//--untuk termin >5M
		var isi_termin1a = 35;
		var isi_termin2a = 65;
		var isi_termin3a = 100;
		if (pecah_koma < 5000000000){
			$("#termin1").val(isi_termin1);
			$("#termin2").val(isi_termin2);
			$("#termin3").val(isi_termin3);
		}else{
			$("#termin1").val(isi_termin1a);
			$("#termin2").val(isi_termin2a);
			$("#termin3").val(isi_termin3a);
		}
		
	})

	function check_termin() {
	    if (document.getElementById('termin').checked) {
	        document.getElementById('termin_group').style.display = 'block';
	    }
	    else document.getElementById('termin_group').style.display = 'none';
	}
</script>
	</body>
</html>