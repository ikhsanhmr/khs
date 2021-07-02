<?php session_start();
include_once('lib/head.php');
include_once("lib/check.php");

$no_spj = $_GET['id'];

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
					<header class="panel-heading">Tambah Perijinan</header>
					<div class="panel-body">
						<form class="form-horizontal tasi-form" method="post" action="perijinan_add_submit.php?id=<? echo $no_spj;?>">
							<div class="form-group">
	                            <label class="col-sm-2 col-sm-2 control-label">No. SPJ</label>
	                            <div class="col-sm-10">
	                            <input type="text" class="form-control" name="var_no_spj" id="var_no_spj" disabled value="<?echo $no_spj;?>">
	                            </div>
							</div>

							<div class="form-group">
	                            <label class="col-sm-2 col-sm-2 control-label">No. Surat Ke PTSP</label>
	                            <div class="col-sm-10">
	                            <input type="text" class="form-control" name="var_no_surat_ptsp" id="var_no_surat_ptsp" placeholder="No. Surat Ke PTSP">
	                            </div>
							</div>	
										
							<div class="form-group">
								<label class=" col-sm-2 col-sm-2 control-label">Tanggal Surat</label>
								<div class="col-sm-10">
								<input type="date" class="form-control" name="var_tgl_surat" id="datepick">
								</div>
							</div>

							<div class="form-group">
	                            <label class="col-sm-2 col-sm-2 control-label">Pekerjaan</label>
	                            <div class="col-sm-10"><input type="text" class="form-control" name="var_pekerjaan" placeholder="Pekerjaan"></div>
							</div>	

							<div class="form-group">
	                            <label class="col-sm-2 col-sm-2 control-label">Kota Administrasi</label>
	                            <div class="col-sm-10">
	                            <select class="form-control m-b-10" name="var_kota_adm">
	                            	<option value="">- Pilih Kota Administrasi -</option>>
	                            	<option value="JAKARTA BARAT">Jakarta Barat</option>
	                            	<option value="JAKARTA PUSAT">Jakarta Pusat</option>
	                            	<option value="JAKARTA SELATAN">Jakarta Selatan</option>
	                            	<option value="JAKARTA TIMUR">Jakarta Timur</option>
	                            	<option value="JAKARTA UTARA">Jakarta Utara</option>
	                            	<option value="KEP. SERIBU">Kepulauan Seribu</option>
	                            </select>
	                            </div>
							</div>	

							<div class="form-group">
	                            <label class="col-sm-2 col-sm-2 control-label">Lokasi</label>
	                            <div class="col-sm-10">
	                            <textarea class="form-control" name="var_lokasi" placeholder="Lokasi"></textarea>
	                            </div>
							</div>	
										
							<div class="form-group">
								<div class="col-lg-offset-2 col-lg-10">
								<button name="Submit" type="submit" class="btn btn-info">Submit</button>
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