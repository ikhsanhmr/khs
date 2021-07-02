<?php session_start();
	include_once('lib/head.php');
	  include_once("lib/check.php");?>
	  
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
								<header class="panel-heading">TAMBAH KRITERIA PENILAIAN</header>
								<div class="panel-body">
									<form class="form-horizontal tasi-form" method="post" action="penilaian_kriteria_submit.php">
									
										<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Deskripsi</label>
											<div class="col-sm-10">
												<select class="form-control m-b-10" name="deskripsi">
													<option value=0>- Pilih Deskripsi -</option>
													<?php
														$data=select_penilaian_deskripsi();
														for($i=0;$i<count($data);$i++){
															$current_deskripsi = $data[$i][1];
															?><option value=<?php echo $data[$i][0]?>> <?php echo $current_deskripsi;?> </option><?php
														}
													?>
												</select>
											</div>
										</div>
									
										<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Kriteria</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="kriteria" placeholder="informasi kriteria" required>
											</div>
										</div>
										
										<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Bobot</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="bobot" placeholder="jumlah bobot" required>
											</div>
										</div>
										
										<div class="form-group">
											<div class="col-lg-offset-2 col-lg-10">
												<button type="submit" class="btn btn-info" onclick="document.getElementById('submitForm').submit()">Submit</button>
											</div>
										</div>
									</form>
								
								
								<div class="panel-body table-responsive">
								<?php
									$count = "select count(id_kriteria) from penilaian_kriteria";
									$count_res = mysqli_query($count);
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
								?>
								</section>
								<section class="panel">
								<header class="panel-heading">TABEL Kriteria Penilaian</header>
								<div class="panel-body table-responsive">
								<div class="demo-html"></div>
								<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
									<thead>
										<tr align="center">
											<th>#</th>
											<th>Deskripsi</th>
											<th>Kriteria Penilaian Pengadaan Jasa</th>
											<th>Bobot</th>
											<th>Edit</th>
											<th>Delete</th>
										</tr>
									</thead>
									
									<tbody>
									<?php
										$querys = "SELECT B.deskripsi, A.id_kriteria, A.bobot, A.kriteria from penilaian_kriteria A
													join penilaian_deskripsi B on A.id_deskripsi=B.id_deskripsi";
										$resultQuerys=mysqli_query($querys);
										while ($rows=mysqli_fetch_row($resultQuerys)){ 
											$datas[] = $rows;
										}
										
										for($j=0;$j<count($datas);$j++){
											
											$mutu = $datas[$j][0];
											$id = $datas[$j][1];
											$bobots = $datas[$j][2];
											$kriteria = $datas[$j][3];
									
											$edit_action = "<a href='penilaian_kriteria_edit.php?id=$id'>Edit</a>";
											$delete_action = "<a href='penilaian_kriteria_delete.php?id=$id' onclick='return confirm(\"Hapus : ".$kriteria." ?\")'>Delete</a>";
											
											$no = $j+$offset+1;
											echo "<tr><td>$no</td>
													<td>$mutu</td>
													<td>$kriteria</td>
													<td>$bobots</td>
													<td>$edit_action</td>
													<td>$delete_action</td></tr>";
											}
									?>
									</tbody>
								</table>
								</div>

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