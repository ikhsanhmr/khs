<?php session_start();
include_once('lib/head.php');
include_once("lib/check.php"); ?>

<body class="skin-black">
	<!--include file header-->
	<?php
	include("lib/header.php");
	$area_kode = $_SESSION['area'];
	?>

	<div class="wrapper row-offcanvas row-offcanvas-left">
		<!-- Left side column. contains the logo and sidebar -->
		<?php include("lib/menu.php"); ?>
		<aside class="right-side">
			<!-- Main content -->
			<section class="content">

				<div class="row">
					<div class="col-md-12">
						<section class="panel">
							<header class="panel-heading">EDIT SPJ</header>
							<div class="panel-body table-responsive">
								<form class="form-horizontal tasi-form" method="post" action="spj_edit_submit.php">
									<table class="table table-hover">
										<?php
										$spj_no = $_GET['spj_no'];
										$query = "select spj_no, spj_add_nilai, ppn, min_ppn from tb_spj where spj_no = '$spj_no'";
										$resultQuery = mysqli_query($mysqli, $query);
										while ($rows = mysqli_fetch_row($resultQuery)) {
											$data[] = $rows;
										}
										$current_spj_no = $data[0][0];
										$current_spj_nilai = number_format($data[0][1]);
										$current_ppn = number_format($data[0][2]);
										$current_min_ppn = number_format($data[0][3]);
										$err = $_GET['err'];
										$success = $_GET['scs'];
										?>
										<tr>
											<td>SPJ NO</td>
											<td>:</td>
											<td><input type="text" name="var_spj_no" data-options="required:true" value="<?php echo $current_spj_no ?>" readonly></input></td>
										</tr>
										<tr>
											<td>SPJ Nilai</td>
											<td>:</td>
											<td>
												<input type="text" class="form-control" name="min_ppn" id="min_ppn" value="<?php echo $current_min_ppn ?>" data-options="required:true" placeholder="nilai sebelum ppn">
											</td>
											<td>
												<input type="text" class="form-control" name="ppn" id="ppn" placeholder="ppn 10%" value="<?php echo $current_ppn ?>" readonly>
											</td>
											<td>
												<input type="text" class="form-control" name="var_spj_nilai" id="nilai" value="<?php echo $current_spj_nilai ?>" readonly>
											</td>
										</tr>
										<?php
										if (isset($err)) {
										?>
											<tr>
												<td colspan='4'>
													<font color="red"><?php echo $err; ?></font>
												</td>
											</tr>
										<?php
										}
										?>
										<tr>
											<td colspan='4'><button type="submit" class="btn btn-info" onclick="document.getElementById('submitForm').submit()">Submit</button></td>
										</tr>
										</tr>
										<td>
											<font color="green"><?php echo $success ?></font>
										</td>
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
	<?php include("lib/footers.php"); ?>

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

		$("#min_ppn").keyup(function(event) {
			//var nilai = $("#min_ppn").val().replace(/,/g,"");
			//alert(nilai);
			//var ppn = (10 / 100) * nilai;
			//var total = nilai + ppn;
			$("#ppn").val(Math.floor($("#min_ppn").val().replace(/,/g, "") * 10 / 100).toLocaleString('en'));
			$("#nilai").val(Math.floor($("#min_ppn").val().replace(/,/g, "") * 110 / 100).toLocaleString('en'));
		})
	</script>
</body>

</html>