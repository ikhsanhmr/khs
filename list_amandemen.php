<script type="text/javascript" src="js/jquery.js"></script>
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
} );

</script>
<?php 
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
?>

<body class="skin-black">
	<?php include("lib/header.php"); ?> 
	<div class="wrapper row-offcanvas row-offcanvas-left">
	<!-- Left side column. contains the logo and sidebar -->
	<?php include("lib/menu.php");?>
	<aside class="right-side">

	<!-- Main content -->
	<section class="content">
 		<div class="row">
			<div class="col-md-12">
				<section class="panel">
				<header class="panel-heading">List Adendum</header>
				<div class="panel-body">
					<form role="form">
						<div class="form-group">
							<label for="no_spj">No. SPJ</label>
							<input type="text" class="form-control" placeholder="No. SPJ" name="no_spj">
						</div>
						<button type="submit" class="btn btn-info"><a href="/khs/list_amandemen.php"></a>Submit</button>
					</form>
				</div>
				</section>
			</div>
		</div>                

		<div class="row">
			<div class="col-md-12">
				<section class="panel">
					<header class="panel-heading">List Adendum</header>
					<div class="panel-body table-responsive">
						<div class="demo-html"></div>
						<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>#</th>
									<th>No. SPJ</th>
									<th>No. Addendum</th>
									<th>Tanggal Input</th>
									<th>Tanggal Adendum</th>
									<th>Tanggal Akhir</th>
									<th>Nilai SPJ</th>
									<th>Target Volume</th>
									<th>Deskripsi Addendum</th>
								</tr>
							</thead>

							<tbody>
								<?php
									$no_spj = $_GET['no_spj'];
									$area = $_SESSION['area'];
									//echo $area;
									if ($no_spj == ""){
										$query = "SELECT * FROM TB_ADDENDUM A, tb_spj b
											  WHERE b.spj_no = a.spj_no
											  and b.AREA_KODE = $area 
											  and A.ADDENDUM_NO NOT like '%2020a%'";
									}else{
										$query = "SELECT * FROM TB_ADDENDUM A, tb_spj b
											  WHERE a.SPJ_NO LIKE '%$no_spj%' 
											  and b.spj_no = a.spj_no
											  and b.AREA_KODE = $area 
											  and A.ADDENDUM_NO NOT like '%2020a%'";										
									}


									$resultQuery=mysqli_query($query);
									while ($rows=mysqli_fetch_row($resultQuery)){ 
										$data[] = $rows;
									}

									$nomor=1;
									for ($i=0;$i<count($data);$i++){
										$current_no_add 		= $data[$i][0];
										$current_no_spj	 		= $data[$i][1];
										$current_nilai_add		= $data[$i][2]; 
										//$current_tgl_akhir_add	= $data[$i][15];
										$current_tgl_input_add	= $data[$i][5];
										$current_tgl_add_add	= $data[$i][7];
										$current_tgl_akhir_add	= $data[$i][3];
										$current_target_volume_add	= $data[$i][23];
										$current_deskripsi_add	= $data[$i][4];

									echo "<tr>";
									echo "<td></td>";
									echo "<td>".$current_no_spj."</td>";
									echo "<td>".$current_no_add."</td>";
									echo "<td>".$current_tgl_input_add."</td>";
									echo "<td>".$current_tgl_add_add."</td>";
									echo "<td>".$current_tgl_akhir_add."</td>";
									echo "<td>".$current_nilai_add."</td>";
									echo "<td>".$current_target_volume_add."</td>";
									echo "<td>".$current_deskripsi_add."</td>";
									echo "</tr>";

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

<?php include("lib/footer.php");?>
</body>
</html>