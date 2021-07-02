<?php
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
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
							<header class="panel-heading">Tagihan</header>
							<div class="panel-body">
							<form class="form-horizontal tasi-form" method="post" action="inp_tagihan_submit.php">
								<div class="form-group">
								
								<?php if ($kode_area!=18) { ?>
								<label class="col-sm-2 col-sm-2 control-label">Nomor SPJ</label>
									<div class="col-sm-10">
									<!--<select class="form-control m-b-10" name="var_no_spj" id="spj_no" onChange="nilai_spj_add(this.value)" >
										<option value="">- NO SPJ -</option>
										
										<?php
                                    
                                            /*$sql ="SELECT a.spj_no FROM tb_spj a, tb_progress b WHERE a.spj_no = b.spj_no and a.area_kode = $kode_area";
                                            $resultQuery=mysqli_query($sql);
                                            if(isset($resultQuery)){
                                            $noRows = mysqli_num_rows($resultQuery);
                                            if ($noRows > 0) {
                                        ?>
                                        <?php
                                            //$data=select_spj_no($kode_area);
                                            $data=select_progress($kode_area);
                                            for($i=0;$i<count($data);$i++)
                                            {
                                                $current_spj_no = $data[$i][0];
                                        ?>
                                            <option value='<?php echo $current_spj_no; ?>'><?php echo $current_spj_no;?></option>

                                        <?php
                                            }
                                            }else{
                                        ?>
                                            <option value=''><font color="red"><?php echo "SPJ Belum ada progress";?></font></option>
                                            <?php
                                                }
                                            }*/
                                            ?>
									</select>-->
									<select class="form-control m-b-10" name="var_no_spj" id="spj_no" onChange="nilai_spj_add(this.value)" >
										<option value="">- NO SPJ -</option>
										<?php
                                            //$data=select_spj_no($kode_area); eidel ubah
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
										<?php }?>
									<!--  untuk otomatis pilih nomor SPJ-->
									
									<?php if ($kode_area==18) { ?>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Nomor SPJ</label>
										<div class="col-sm-10">
										<input type="text" class="typeahead2 form-control" name="var_no_spj" id="spj_no"  autocomplete="off" onChange="nilai_spj_add_keu(this.value)" >
										</div>
									</div>
									<?php }?>
								
								<div class="form-group">
									<label class="col-sm-2 col-sm-2 control-label">Total Tagihan</label>
									<div class="col-sm-10">
										<input type="hidden" class="form-control" name="vendor_id" id="vendor_id" placeholder="ID Vendor">
										<input type="hidden" class="form-control" name="paket_jenis" id="paket_jenis" placeholder="Paket Jenis">
										<input type="hidden" class="form-control" name="skki_o_no" id="skki_o_no" placeholder="SKKI/O No">
										<input type="text" class="form-control" name="total_tagihan" id="total_tagihan" placeholder="Total Tagihan" readonly>
									</div>
								</div>
										
								<div class="form-group">
									<label class="col-sm-2 col-sm-2 control-label">Nominal Tagihan</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="var_nominal_tagihan" id="nilai" placeholder="Nominal Tagihan" readonly>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-2 col-sm-2 control-label">Keterangan Bayar</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="keterangan_bayar" id="keterangan_bayar" placeholder="keterangan bayar" readonly>
									</div>
								</div>
										
								<div class="form-group">
									<label class=" col-sm-2 col-sm-2 control-label">Tanggal Bayar</label>
									<div class="col-md-2">
										<input type="date" class="form-control" name="var_tanggal_bayar" id="tgl_tagihan">
									</div>
								</div>
										
								<div class="form-group">
									<label class="col-sm-2 col-sm-2 control-label">Nomor BASTP</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="var_no_bastp" placeholder="Nomor BASTP" required>
									</div>
								</div>
										
								<div class="form-group">
									<label class="col-sm-2 col-sm-2 control-label">Deskripsi</label>
									<div class="col-sm-10">
										<textarea rows="2" cols="125" name="var_deskripsi" placeholder="Nomor SAP" required></textarea>
									</div>
								</div>
										
								<div class="form-group">
									<div class="col-lg-offset-2 col-lg-10">
									<button type="submit" id="submit" class="btn btn-info" onclick="document.getElementById('submitForm').submit()">Submit</button>
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


<script type="text/javascript">
	$('input.typeahead2').typeahead({
	    source:  function (query, process) {
        return $.get('ajax/ajax_nomor_spbj.php', { query: query }, function (data) {
        		console.log(data);
        		data = $.parseJSON(data);
	            return process(data);
	        });
	    }
	});
</script>	
	
		
<script type="text/javascript">

function nilai_spj_add(value) {
	var spj_no = document.getElementById("spj_no").value;
	$.getJSON('get_nilai.php',{'spj_no' : spj_no},function(data){
	$("#nilai").val(data);
	var keterangan_bayar = "";
	$("#keterangan_bayar").val(keterangan_bayar);
	})

	$.getJSON('get_termin.php',{'spj_no' : spj_no},function(data){
		if(data == 0) //non termin
		{//alert("non termin");
			$.getJSON('get_nilai.php',{'spj_no' : spj_no},function(data_nilai_spj){
			
			$.getJSON('get_val.php',{'spj_no' : spj_no},function(data)
			{
				$.getJSON('get_val.php',{'spj_no' : spj_no},function(data_progress)
				{
					$.getJSON('get_nilai_keterangan.php',{'spj_no' : spj_no},function(keterangan)
					{
					  $.getJSON('get_paket.php',{'spj_no' : spj_no},function(isi_paket)
						{
							$.getJSON('get_vendor.php',{'spj_no' : spj_no},function(isi_vendor)
						{
							$.getJSON('get_skki_o.php',{'spj_no' : spj_no},function(isi_skki_o)
						{
				
				switch (true) {
							case keterangan==""  && data_progress < 90:
									alert("Tidak bisa input pembayaran karena progress belum 90%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
								break;
								
							case keterangan == "" && data_progress==90:
									alert("pembayaran 90%");	
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (90/100)*data_nilai_spj;
									$("#total_tagihan").val(data_nilai_spj);
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 90";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#paket_jenis").val(isi_paket);
									$("#vendor_id").val(isi_vendor);
									$("#skki_o_no").val(isi_skki_o);
								break;
								
							case keterangan == "" && data_progress==100:
									alert("pembayaran langsung 100%");	
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (100/100)*data_nilai_spj;
									$("#total_tagihan").val(data_nilai_spj);
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 100";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#paket_jenis").val(isi_paket);
									$("#vendor_id").val(isi_vendor);
									$("#skki_o_no").val(isi_skki_o);
								break;

							case keterangan == "" && data_progress==130:
									alert("pembayaran langsung 130%");	
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (130/100)*data_nilai_spj;
									$("#total_tagihan").val(data_nilai_spj);
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 130";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#paket_jenis").val(isi_paket);
									$("#vendor_id").val(isi_vendor);
									$("#skki_o_no").val(isi_skki_o);
								break;			
								
							
							case  keterangan == "bayar 90" && data_progress < 100 :
									alert("Tidak dapat input pembayaran karena progress  belum 100%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
								break;
								
							case  keterangan == "bayar 90" && data_progress >100 && data_progress < 130 :
									alert("Tidak dapat input pembayaran karena progress  belum 130%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
								break;	
							
							case keterangan == "bayar 90" && data_progress == 100 && data_progress < 130:
									alert("pembayaran ditambah  10% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (10/100)*data_nilai_spj;
									$("#total_tagihan").val(data_nilai_spj);
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 100";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#paket_jenis").val(isi_paket);
									$("#vendor_id").val(isi_vendor);
									$("#skki_o_no").val(isi_skki_o);
								break;
								
							case keterangan == "bayar 90" && data_progress == 130:
									alert("pembayaran akhir ditambah  40% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (40/100)*data_nilai_spj;
									$("#total_tagihan").val(data_nilai_spj);
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 130";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#paket_jenis").val(isi_paket);
									$("#vendor_id").val(isi_vendor);
									$("#skki_o_no").val(isi_skki_o);
								break;	
							
							case  keterangan == "bayar 100" && data_progress < 130:
									alert("Tidak dapat input pembayaran karena progress  belum 130%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
								break;
								
							case keterangan == "bayar 100" && data_progress == 130:
									alert("pembayaran akhir ditambah  30% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (30/100)*data_nilai_spj;
									$("#total_tagihan").val(data_nilai_spj);
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 130";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#paket_jenis").val(isi_paket);
									$("#vendor_id").val(isi_vendor);
									$("#skki_o_no").val(isi_skki_o);
								break;
									
							default:
								//alert("error, tidak sesuai kriteria");
								document.getElementById("submit").disabled = true;
								var nilai_nominal_tagihan1 = 0;
								$("#nilai").val(nilai_nominal_tagihan1);
							}
				
				
				/*if(data < 100)
				{
				alert("Tidak Bisa Input Pembayaran, Progress Belum 100%");
				document.getElementById("submit").disabled = true;
				}
				else
				{
				alert("pembayaran langsung 100%");
				document.getElementById("submit").disabled = false;
				var keterangan_bayar = "bayar 100";
				$("#keterangan_bayar").val(keterangan_bayar);
			
				}*/
			})
			})
			  })
			    })
			    })
			    })
			    })
		}

		if(data == 1) // termin
		{//alert(" termin");
			$.getJSON('get_nilai.php',{'spj_no' : spj_no},function(data_nilai_spj){
		
			$.getJSON('get_val.php',{'spj_no' : spj_no},function(data_progress)
			{
				$.getJSON('get_nilai_termin1.php',{'spj_no' : spj_no},function(data_termin1)
				{
					$.getJSON('get_nilai_termin2.php',{'spj_no' : spj_no},function(data_termin2)
					{
						$.getJSON('get_nilai_termin3.php',{'spj_no' : spj_no},function(data_termin3)
						{
							$.getJSON('get_nilai_keterangan.php',{'spj_no' : spj_no},function(keterangan)
						{
							$.getJSON('get_paket.php',{'spj_no' : spj_no},function(isi_paket)
						{
							$.getJSON('get_vendor.php',{'spj_no' : spj_no},function(isi_vendor)
						{
							$.getJSON('get_skki_o.php',{'spj_no' : spj_no},function(isi_skki_o)
						{
						if(data_nilai_spj < 5000000000){
							
							switch (true) {
							case keterangan==""  && data_progress <= 55:
									alert("Tidak bisa input pembayaran karena progress termin belum di atas 55%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
								break;
							
							case keterangan == "" && data_progress==90:
									alert("pembayaran langsung 90%");	
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (90/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 90";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
								
							
							case keterangan == "" && data_progress==100:
									alert("pembayaran langsung 100%");	
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (100/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 100";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
								
								
							case keterangan == "" && data_progress==130:
									alert("pembayaran langsung 130%");	
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (130/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 130";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;		
							
							case  keterangan=="" && data_progress > data_termin1:
									alert("pembayaran sebesar 50%");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (50/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 50";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
								
							case  keterangan == "bayar 50" && data_progress < 90:
									alert("Tidak dapat input pembayaran karena progress termin belum 90%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
								break;	
							
							case  keterangan == "bayar 90" && data_progress < 100:
									alert("Tidak dapat input pembayaran karena progress termin belum 100%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
								break;
								
							case  keterangan == "bayar 100" && data_progress < 130:
									alert("Tidak dapat input pembayaran karena progress termin belum 130%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
								break;	
								
								
							case keterangan == "bayar 50" && data_progress == 90:
									alert("pembayaran ditambah  40% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (40/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 90";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
								
							case  keterangan == "bayar 50" && data_progress >90 && data_progress < 100 :
									alert("Tidak dapat input pembayaran karena progress  belum 100%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
								break;	
								
							case keterangan == "bayar 50" && data_progress == 100:
									alert("pembayaran ditambah  50% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (50/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 100";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
								
							case  keterangan == "bayar 50" && data_progress >100 && data_progress < 130 :
									alert("Tidak dapat input pembayaran karena progress  belum 130%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
								break;		
	
							case keterangan == "bayar 50" && data_progress == 130:
									alert("pembayaran ditambah  80% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (80/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 130";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
							
							case keterangan == "bayar 90" && data_progress == 100:
									alert("pembayaran  ditambah  10% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (10/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 100";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
								
							case  keterangan == "bayar 90" && data_progress >100 && data_progress < 130 :
									alert("Tidak dapat input pembayaran karena progress  belum 130%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
								break;	
								
							case keterangan == "bayar 90" && data_progress == 130:
									alert("pembayaran  ditambah  40% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (40/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 130";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;	
							
							case keterangan == "bayar 100" && data_progress == 130:
									alert("pembayaran akhir ditambah  30% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (30/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 130";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
								
							default:
								alert("error");
								document.getElementById("submit").disabled = true;
								var nilai_nominal_tagihan1 = 0;
								$("#nilai").val(nilai_nominal_tagihan1);
							}
							
						}else{
							switch (true) {
							case keterangan==""  && data_progress <= 35:
									alert("Tidak bisa input pembayaran karena progress termin belum di atas 35%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
								break;
								
							case keterangan == "" && data_progress==90:
									alert("pembayaran langsung 90%");	
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (90/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 90";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
							
								
							case keterangan == "" && data_progress==100:
									alert("pembayaran langsung 100%");	
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (100/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 100";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
								
							case keterangan == "" && data_progress==130:
									alert("pembayaran langsung 130%");	
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (130/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 130";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;	
								
							case  keterangan == "" && data_progress > data_termin2:
									alert("pembayaran sebesar 60%");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (60/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 60";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
							
							case  keterangan == "" && data_progress > data_termin1:
									alert("pembayaran pertama sebesar 30%");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (30/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 30";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
								
							
							case  keterangan == "bayar 30" && data_progress <=65:
									alert("Tidak dapat input pembayaran karena progress termin belum di atas 65%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
								break;
							//berhasil semua yang di atas
							
							case  keterangan == "bayar 30" && data_progress >65 && data_progress <90:
									alert("pembayaran ditambah 30% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (30/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 60";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
								
							case keterangan == "bayar 30" && data_progress >65 && data_progress == 90:
									alert("pembayaran ditambah  60% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (60/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 90";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;

							case keterangan == "bayar 30" && data_progress == 100:
									alert("pembayaran ditambah  70% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (70/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 100";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
							
							case keterangan == "bayar 30" && data_progress == 130:
									alert("pembayaran ditambah  100% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (100/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 100";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;		
							
							case  keterangan == "bayar 60" && data_progress < 90:
									alert("Tidak dapat input pembayaran karena progress termin belum 90%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
								break;
							
							case  keterangan == "bayar 90" && data_progress < 100:
									alert("Tidak dapat input pembayaran karena progress termin belum 100%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
								break;
								
							case  keterangan == "bayar 100" && data_progress < 130:
									alert("Tidak dapat input pembayaran karena progress termin belum 130%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
								break;	
							
							case keterangan == "bayar 60" && data_progress == 90:
									alert("pembayaran ditambah 30% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (30/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 90";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
								
							case keterangan == "bayar 60" && data_progress == 100:
									alert("pembayaran ditambah 40% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (40/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 100";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;

							case keterangan == "bayar 60" && data_progress == 130:
									alert("pembayaran terakhir  ditambah 70% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (70/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 130";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;

							case keterangan == "bayar 90" && data_progress == 100:
									alert("pembayaran  ditambah  10% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (10/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 100";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
								
							case keterangan == "bayar 90" && data_progress == 130:
									alert("pembayaran  ditambah  40% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (40/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 130";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;	
							
							case keterangan == "bayar 100" && data_progress == 130:
									alert("pembayaran akhir ditambah  30% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (30/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 130";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;	
								
							default:
								alert("error");
								document.getElementById("submit").disabled = true;
								var nilai_nominal_tagihan1 = 0;
								$("#nilai").val(nilai_nominal_tagihan1);
							}
							
						}
					})
					})
					})
				})
				})
				})
				})
			})
			})
		}
		
	})		

	}

</script>	

<script type="text/javascript">

function nilai_spj_add_keu(value) {
	var spj_no = document.getElementById("spj_no").value;
	$.getJSON('get_nilai.php',{'spj_no' : spj_no},function(data){
	$("#nilai").val(data);
	var keterangan_bayar = "";
	$("#keterangan_bayar").val(keterangan_bayar);
	})

	$.getJSON('get_termin.php',{'spj_no' : spj_no},function(data){
		if(data == 0) //non termin
		{//alert("non termin");
			$.getJSON('get_nilai_keu.php',{'spj_no' : spj_no},function(data_nilai_spj){
			
			$.getJSON('get_val.php',{'spj_no' : spj_no},function(data)
			{
				$.getJSON('get_val.php',{'spj_no' : spj_no},function(data_progress)
				{
					$.getJSON('get_nilai_keterangan.php',{'spj_no' : spj_no},function(keterangan)
					{
					  $.getJSON('get_paket.php',{'spj_no' : spj_no},function(isi_paket)
						{
							$.getJSON('get_vendor.php',{'spj_no' : spj_no},function(isi_vendor)
						{
							$.getJSON('get_skki_o.php',{'spj_no' : spj_no},function(isi_skki_o)
						{
				
				switch (true) {
							case keterangan==""  && data_progress < 90:
									alert("Tidak bisa input pembayaran karena progress belum 90%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
								break;
								
							case keterangan == "" && data_progress==90:
									alert("pembayaran 90%");	
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (90/100)*data_nilai_spj;
									$("#total_tagihan").val(data_nilai_spj);
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 90";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#paket_jenis").val(isi_paket);
									$("#vendor_id").val(isi_vendor);
									$("#skki_o_no").val(isi_skki_o);
								break;
								
							case keterangan == "" && data_progress==100:
									alert("pembayaran langsung 100%");	
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (100/100)*data_nilai_spj;
									$("#total_tagihan").val(data_nilai_spj);
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 100";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#paket_jenis").val(isi_paket);
									$("#vendor_id").val(isi_vendor);
									$("#skki_o_no").val(isi_skki_o);
								break;

							case keterangan == "" && data_progress==130:
									alert("pembayaran langsung 130%");	
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (130/100)*data_nilai_spj;
									$("#total_tagihan").val(data_nilai_spj);
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 130";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#paket_jenis").val(isi_paket);
									$("#vendor_id").val(isi_vendor);
									$("#skki_o_no").val(isi_skki_o);
								break;			
								
							
							case  keterangan == "bayar 90" && data_progress < 100 :
									alert("Tidak dapat input pembayaran karena progress  belum 100%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
								break;
								
							case  keterangan == "bayar 90" && data_progress >100 && data_progress < 130 :
									alert("Tidak dapat input pembayaran karena progress  belum 130%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
								break;	
							
							case keterangan == "bayar 90" && data_progress == 100 && data_progress < 130:
									alert("pembayaran ditambah  10% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (10/100)*data_nilai_spj;
									$("#total_tagihan").val(data_nilai_spj);
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 100";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#paket_jenis").val(isi_paket);
									$("#vendor_id").val(isi_vendor);
									$("#skki_o_no").val(isi_skki_o);
								break;
								
							case keterangan == "bayar 90" && data_progress == 130:
									alert("pembayaran akhir ditambah  40% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (40/100)*data_nilai_spj;
									$("#total_tagihan").val(data_nilai_spj);
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 130";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#paket_jenis").val(isi_paket);
									$("#vendor_id").val(isi_vendor);
									$("#skki_o_no").val(isi_skki_o);
								break;	
							
							case  keterangan == "bayar 100" && data_progress < 130:
									alert("Tidak dapat input pembayaran karena progress  belum 130%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
								break;
								
							case keterangan == "bayar 100" && data_progress == 130:
									alert("pembayaran akhir ditambah  30% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (30/100)*data_nilai_spj;
									$("#total_tagihan").val(data_nilai_spj);
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 130";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#paket_jenis").val(isi_paket);
									$("#vendor_id").val(isi_vendor);
									$("#skki_o_no").val(isi_skki_o);
								break;
									
							default:
								//alert("error, tidak sesuai kriteria");
								document.getElementById("submit").disabled = true;
								var nilai_nominal_tagihan1 = 0;
								$("#nilai").val(nilai_nominal_tagihan1);
							}
				
				
				/*if(data < 100)
				{
				alert("Tidak Bisa Input Pembayaran, Progress Belum 100%");
				document.getElementById("submit").disabled = true;
				}
				else
				{
				alert("pembayaran langsung 100%");
				document.getElementById("submit").disabled = false;
				var keterangan_bayar = "bayar 100";
				$("#keterangan_bayar").val(keterangan_bayar);
			
				}*/
			})
			})
			  })
			    })
			    })
			    })
			    })
		}

		if(data == 1) // termin
		{//alert(" termin");
			$.getJSON('get_nilai.php',{'spj_no' : spj_no},function(data_nilai_spj){
		
			$.getJSON('get_val.php',{'spj_no' : spj_no},function(data_progress)
			{
				$.getJSON('get_nilai_termin1.php',{'spj_no' : spj_no},function(data_termin1)
				{
					$.getJSON('get_nilai_termin2.php',{'spj_no' : spj_no},function(data_termin2)
					{
						$.getJSON('get_nilai_termin3.php',{'spj_no' : spj_no},function(data_termin3)
						{
							$.getJSON('get_nilai_keterangan.php',{'spj_no' : spj_no},function(keterangan)
						{
							$.getJSON('get_paket.php',{'spj_no' : spj_no},function(isi_paket)
						{
							$.getJSON('get_vendor.php',{'spj_no' : spj_no},function(isi_vendor)
						{
							$.getJSON('get_skki_o.php',{'spj_no' : spj_no},function(isi_skki_o)
						{
						if(data_nilai_spj < 5000000000){
							
							switch (true) {
							case keterangan==""  && data_progress <= 55:
									alert("Tidak bisa input pembayaran karena progress termin belum di atas 55%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
								break;
							
							case keterangan == "" && data_progress==90:
									alert("pembayaran langsung 90%");	
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (90/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 90";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
								
							
							case keterangan == "" && data_progress==100:
									alert("pembayaran langsung 100%");	
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (100/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 100";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
								
								
							case keterangan == "" && data_progress==130:
									alert("pembayaran langsung 130%");	
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (130/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 130";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;		
							
							case  keterangan=="" && data_progress > data_termin1:
									alert("pembayaran sebesar 50%");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (50/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 50";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
								
							case  keterangan == "bayar 50" && data_progress < 90:
									alert("Tidak dapat input pembayaran karena progress termin belum 90%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
								break;	
							
							case  keterangan == "bayar 90" && data_progress < 100:
									alert("Tidak dapat input pembayaran karena progress termin belum 100%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
								break;
								
							case  keterangan == "bayar 100" && data_progress < 130:
									alert("Tidak dapat input pembayaran karena progress termin belum 130%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
								break;	
								
								
							case keterangan == "bayar 50" && data_progress == 90:
									alert("pembayaran ditambah  40% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (40/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 90";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
								
							case  keterangan == "bayar 50" && data_progress >90 && data_progress < 100 :
									alert("Tidak dapat input pembayaran karena progress  belum 100%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
								break;	
								
							case keterangan == "bayar 50" && data_progress == 100:
									alert("pembayaran ditambah  50% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (50/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 100";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
								
							case  keterangan == "bayar 50" && data_progress >100 && data_progress < 130 :
									alert("Tidak dapat input pembayaran karena progress  belum 130%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
								break;		
	
							case keterangan == "bayar 50" && data_progress == 130:
									alert("pembayaran ditambah  80% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (80/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 130";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
							
							case keterangan == "bayar 90" && data_progress == 100:
									alert("pembayaran  ditambah  10% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (10/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 100";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
								
							case  keterangan == "bayar 90" && data_progress >100 && data_progress < 130 :
									alert("Tidak dapat input pembayaran karena progress  belum 130%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
								break;	
								
							case keterangan == "bayar 90" && data_progress == 130:
									alert("pembayaran  ditambah  40% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (40/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 130";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;	
							
							case keterangan == "bayar 100" && data_progress == 130:
									alert("pembayaran akhir ditambah  30% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (30/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 130";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
								
							default:
								alert("error");
								document.getElementById("submit").disabled = true;
								var nilai_nominal_tagihan1 = 0;
								$("#nilai").val(nilai_nominal_tagihan1);
							}
							
						}else{
							switch (true) {
							case keterangan==""  && data_progress <= 35:
									alert("Tidak bisa input pembayaran karena progress termin belum di atas 35%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
								break;
								
							case keterangan == "" && data_progress==90:
									alert("pembayaran langsung 90%");	
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (90/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 90";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
							
								
							case keterangan == "" && data_progress==100:
									alert("pembayaran langsung 100%");	
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (100/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 100";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
								
							case keterangan == "" && data_progress==130:
									alert("pembayaran langsung 130%");	
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (130/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 130";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;	
								
							case  keterangan == "" && data_progress > data_termin2:
									alert("pembayaran sebesar 60%");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (60/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 60";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
							
							case  keterangan == "" && data_progress > data_termin1:
									alert("pembayaran pertama sebesar 30%");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (30/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 30";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
								
							
							case  keterangan == "bayar 30" && data_progress <=65:
									alert("Tidak dapat input pembayaran karena progress termin belum di atas 65%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
								break;
							//berhasil semua yang di atas
							
							case  keterangan == "bayar 30" && data_progress >65 && data_progress <90:
									alert("pembayaran ditambah 30% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (30/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 60";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
								
							case keterangan == "bayar 30" && data_progress >65 && data_progress == 90:
									alert("pembayaran ditambah  60% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (60/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 90";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;

							case keterangan == "bayar 30" && data_progress == 100:
									alert("pembayaran ditambah  70% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (70/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 100";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
							
							case keterangan == "bayar 30" && data_progress == 130:
									alert("pembayaran ditambah  100% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (100/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 100";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;		
							
							case  keterangan == "bayar 60" && data_progress < 90:
									alert("Tidak dapat input pembayaran karena progress termin belum 90%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
								break;
							
							case  keterangan == "bayar 90" && data_progress < 100:
									alert("Tidak dapat input pembayaran karena progress termin belum 100%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
								break;
								
							case  keterangan == "bayar 100" && data_progress < 130:
									alert("Tidak dapat input pembayaran karena progress termin belum 130%");
									document.getElementById("submit").disabled = true;
									var nilai_nominal_tagihan1 = 0;
									$("#nilai").val(nilai_nominal_tagihan1);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
								break;	
							
							case keterangan == "bayar 60" && data_progress == 90:
									alert("pembayaran ditambah 30% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (30/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 90";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
								
							case keterangan == "bayar 60" && data_progress == 100:
									alert("pembayaran ditambah 40% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (40/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 100";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;

							case keterangan == "bayar 60" && data_progress == 130:
									alert("pembayaran terakhir  ditambah 70% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (70/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 130";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;

							case keterangan == "bayar 90" && data_progress == 100:
									alert("pembayaran  ditambah  10% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (10/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 100";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;
								
							case keterangan == "bayar 90" && data_progress == 130:
									alert("pembayaran  ditambah  40% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (40/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 130";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;	
							
							case keterangan == "bayar 100" && data_progress == 130:
									alert("pembayaran akhir ditambah  30% lagi");
									document.getElementById("submit").disabled = false;
									var nilai_nominal_tagihan1 = (30/100)*data_nilai_spj;
									$("#nilai").val(nilai_nominal_tagihan1);
									var keterangan_bayar = "bayar 130";
									$("#keterangan_bayar").val(keterangan_bayar);
									$("#vendor_id").val(isi_vendor);
									$("#paket_jenis").val(isi_paket);
									$("#total_tagihan").val(data_nilai_spj);
									$("#skki_o_no").val(isi_skki_o);
								break;	
								
							default:
								alert("error");
								document.getElementById("submit").disabled = true;
								var nilai_nominal_tagihan1 = 0;
								$("#nilai").val(nilai_nominal_tagihan1);
							}
							
						}
					})
					})
					})
				})
				})
				})
				})
			})
			})
		}
		
	})		

	}

	
</script>	
<?php include("lib/footers.php");?>
</body>
</html>