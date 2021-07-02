<?php
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
include_once("lib/GLOBAL_VAR.php");
?>

<link type="text/css" href="css/bootstrap-datepicker.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>

<link rel="stylesheet" type="text/css" href="datatables/media/css/dataTables.bootstrap.css">
<link rel="stylesheet" type="text/css" href="datatables/examples/resources/syntax/shCore.css">
<style type="text/css" class="init">

</style>

<script type="text/javascript" language="javascript" src="datatables/media/js/jquery.dataTables.js">
</script>
<script type="text/javascript" language="javascript" src="datatables/media/js/dataTables.bootstrap.js">
</script>
<script type="text/javascript" language="javascript" src="datatables/examples/resources/syntax/shCore.js">
</script>

<script type="text/javascript" language="javascript" class="init">
	$(document).ready(function() {
		$('#example').DataTable();
	});
</script>

<body class="skin-black">
	<?php include("lib/header.php"); ?>

	<div class="wrapper row-offcanvas row-offcanvas-left">
		<!-- Left side column. contains the logo and sidebar -->
		<?php include("lib/menu.php"); ?>

		<aside class="right-side">

			<!-- Main content -->
			<section class="content">

				<div class="row">
					<div class="col-md-12">
						<section class="panel">
							<header class="panel-heading">DATA VENDOR KHSJ </header>
							<div class="panel-body table-responsive">

								<!--<table class="table table-hover">-->
								<div class="demo-html"></div>
								<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">

									<thead>
										<tr>
											<th>#</th>
											<th>Nama Vendor</th>
											<th>Tahun</th>
											<th>Direksi Vendor</th>
											<!--<th>Finansial Setelah Update</th>
									<th>Finansial Update User</th>
									<th>Finansial Update Tanggal</th>-->
											<th>Email</th>
										</tr>
									</thead>

									<tbody>
										<?php
										//Table
										$area = $_GET['area'];
										$vendor = $_GET['vendor'];
										$ftahun = isset($_GET['tahun']) ? $_GET['tahun'] : $FISCAL_YEAR;


										$count = " SELECT A.VENDOR_ID,  A.VENDOR_NAMA, b.RATING_LAPORAN_AUDIT, 
										b.FIN_LIMIT FROM tb_vendor a, tb_fin_vendor B  WHERE a.VENDOR_ID=b.VENDOR_ID
										and A.VENDOR_NAMA like '%$vendor%'";
										$count_res = mysqli_query($mysqli, $count);
										$r = mysqli_fetch_row($count_res);
										$numrows = $r[0];

										// number of rows to show per page
										$rowsperpage = 10;
										// find out total pages
										$totalpages = ceil($numrows / $rowsperpage);

										// get the current page or set a default
										if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
											// cast var as int
											$currentpage = (int) $_GET['currentpage'];
										} else {
											// default page num
											$currentpage = 1;
										} // end if

										// if current page is greater than total pages...
										if ($currentpage > $totalpages) {
											// set current page to last page
											$currentpage = $totalpages;
										} // end if
										// if current page is less than first page...
										if ($currentpage < 1) {
											// set current page to first page
											$currentpage = 1;
										} // end if

										// the offset of the list, based on current page 
										$offset = ($currentpage - 1) * $rowsperpage;

										$sql = "SELECT A.VENDOR_ID,  A.VENDOR_NAMA, A.TAHUN, 
										A.DIREKSI_VENDOR, A.EMAIL FROM tb_vendor a
									";

										$resultQuery = mysqli_query($mysqli, $sql);
										while ($rows = mysqli_fetch_array($resultQuery)) {
											$data[] = $rows;
										}

										for ($i = 0; $i < count($data); $i++) {
											$current_id_vendor 			= $data[$i][0];
											$current_nama_vendor 		= $data[$i][1];
											$tahun 						= $data[$i][2];
											$direksi_vendor 			= $data[$i][3];
											$email			 			= $data[$i][4];

											$a 		= ($i + 1) + (($currentpage - 1) * $rowsperpage);

											echo "<tr><td>$a</td>
								  <td>$current_nama_vendor</td>
								  <td>$tahun</td>
								  <td>$direksi_vendor</td>
								  <td>$email</td>
								  </tr>	
								  ";
										}
										?>
									</tbody>
								</table>

							</div>
						</section>
					</div>
				</div>
			</section>
		</aside>

	</div>
	<script type="text/javascript">
		$('.year').datepicker({
			minViewMode: 2,
			format: 'yyyy',
			autoclose: true
		});
	</script>
	<?php include("lib/footer.php"); ?>
</body>

</html>