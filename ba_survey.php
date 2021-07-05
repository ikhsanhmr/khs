<?php
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
include_once("lib/function.php");
?>

<head>
<script type="text/javascript"> 
function disable(){ 
document.getElementById("datepick").disabled =true;
document.getElementById("var_hasil_survey").disabled=true;
} 

function enable(){ 
document.getElementById("datepick").disabled=false;
document.getElementById("var_hasil_survey").disabled=false;
} 
</script>
</head>

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
				<form class="form-horizontal tasi-form" method="post" action="ba_survey_submit.php" id="ba_survey">
					<section class="panel">
					<header class="panel-heading">Persetujuan Survey</header>
						<div class="panel-body">
							<div class="form-group">
								<div class="col-lg-10">
									<label class="radio-inline">
	                                    <input type="radio" name="option_persetujuan" id="radio_rev" value="1" onchange="disable();">
	                                    Perlu Revisi
	                                </label>
	                                <label class="radio-inline">
	                                    <input type="radio" name="option_persetujuan" id="radio_ba" value="0" onchange="enable();">
	                                    BA Survey
	                                </label>
								</div>
							</div>

							<div class="form-group">
	                            <label class="col-sm-2 col-sm-2 control-label">No. Surat Ke PTSP</label>
	                            <div class="col-sm-10">
	                            <select class="form-control" name="var_no_surat_ptsp" id="var_no_surat_ptsp">
	                            	<option>- Pilih No Surat Ke PTSP -</option>
	                            	<?php
                                        $data=select_perijinan($mysqli);
                                        for ($i=0;$i<count($data);$i++) {
                                            $current_no_surat_ptsp	= $data[$i]['surat_ijin_no']; ?>
									<option value='<?php echo $current_no_surat_ptsp; ?>'><?php echo $current_no_surat_ptsp; ?></option>
									<?php
                                        }
                                    ?>
	                            </select>
	                            </div>
							</div>	
						</div>
					</section>

					<section class="panel">
					<header class="panel-heading">BA Survey</header>
					<div class="panel-body">
						
							
										
							<div class="form-group">
								<label class=" col-sm-2 col-sm-2 control-label">Tanggal Survey</label>
								<div class="col-md-2">
								<input type="date" class="form-control" name="var_tgl_survey" id="datepick">
								</div>
							</div>

							<div class="form-group">
	                            <label class="col-sm-2 col-sm-2 control-label">Hasil Survey</label>
	                            <div class="col-sm-10">
	                            <textarea class="form-control" name="var_hasil_survey" id="var_hasil_survey" placeholder="Hasil Survey"></textarea>
	                            </div>
							</div>	
										
							<div class="form-group">
								<div class="col-lg-offset-2 col-lg-10">
								<button type="submit" class="btn btn-info" onclick="document.getElementById('submitForm').submit()">Submit</button>
								</div>
							</div>
						
					</div>
					</section>
					</form>
				</div>
			</div>
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
	</div>



<?php include("lib/footer.php");?>
</body>
</html>