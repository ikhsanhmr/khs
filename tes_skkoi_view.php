<?php 
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
	
$skkio="";
if(isset($_GET['skkio_no'])){
	$skkio = $_GET['skkio_no'];
}
?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>

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
							<header class="panel-heading">Search Criteria</header>
							<div class="panel-body">
								<form role="form">
									<div class="form-group">
										<label for="Vendor">NO SKKI/O</label>
										<input type="text" class="form-control" placeholder="Nomor SKKI/O" name="skkio_no">
									</div>
									<button type="submit" class="btn btn-info"> <a href=""></a>Submit</button>
								</form>
							</div>
						</section>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<section class="panel">
							<header class="panel-heading">UPDATE SKKI/O</header>

							<form role="form" action="inp_skkio_submit.php" method="post">
								<div class="form-group">
									<div class="col-md-2 ">
										<select class="form-control m-b-10" name="jenis">
											<option value="SKKI">SKKI</option>
											<option value="SKKO">SKKO</option>
										</select>
									</div>
									
									<div class="col-md-2 ">
										<select class="form-control m-b-10" name="Area">
											<option value="">Pilih Area</option>
												<?php
													$area=select_all_area();
													for($i=0;$i<count($area);$i++){
														$area_kode = $area[$i][0];
														$area_nama = $area[$i][1];
												?>
											<option value='<?php echo $area_kode?>'><?php echo $area_nama;?></option>
											<?php } ?>
										</select>
									</div>

									<div class="col-md-2">
										<input type="date" class="form-control" name="no_skkoi" placeholder="No SKKI/O">
									</div>

									<div class="col-md-2">
										<input type="text" class="form-control" name="var_nilai_skkoi" id="nilai" placeholder="Pagu SKKI/O">
									</div>
											
									<div class="col-md-2">
										<input type="date" class="form-control" name="var_tanggal" placeholder="Tanggal SKKI/O" id="datepick">
									</div>

									<div class="col-md-2">
										<select class="form-control m-b-10" name="paket" placeholder="paket pekerjaan" >
											<option value="NULL">Pilih Paket Pekerjaan</option>
											<option value="B1">B1</option>
											<option value="B2">B2</option>
											<option value="NULL">-</option>
										</select>
									</div>

									<div class="col-md-2">
		                            	<input class="year form-control date-pick" id="tahun" name="tahun" placeholder="Tahun">
	                                </div>

									<div class="col-md-2">
										<input  type="submit" value="Tambah Anggaran">
									</div>
											
								</div>
							</form>


							<div class="panel-body table-responsive">
								<?php
									$count = "select count(skki_no) from tb_skko_i ";
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
								
								<table class="table table-hover">
									<thead>
										<tr align="center">
											<td><strong>#</strong></td>
											<td><strong>SKKI JENIS</strong></td>
											<td><strong>SKKI NO</strong></td>
											<td><strong>AREA KODE</strong></td>
											<td><strong>SKKI NILAI</strong></td>
											<td><strong>SKKI TERPAKAI</strong></td>
											<td><strong>SKKI TANGGAL</strong></td>
											<th></th>
											<th></th>
										</tr>
									</thead>
									
									<tbody>
									<?php
										if ($skkio == ""){
											$query = "select * from tb_skko_i LIMIT $offset, $rowsperpage";
										}else{
											$query = "select * from tb_skko_i where skki_no like '%$skkio%' LIMIT $offset, $rowsperpage";
										}
												
										$resultQuery=mysqli_query($query);
										while ($rows=mysqli_fetch_row($resultQuery)){ 
											$data[] = $rows;
										}
										for($i=0;$i<count($data);$i++){
											$current_skki_jenis = $data[$i][0];
											$current_skki_no = $data[$i][1];
											$current_area_kode = $data[$i][2];
											$current_skki_nilai = $data[$i][3];
											$current_skki_terpakai = $data[$i][4];
											$current_skki_tanggal = $data[$i][5];
											$edit_action = "<a href='skkoi_edit.php?skki_no=$current_skki_no'>Edit</a>";
											$delete_action = "<a href='skkoi_delete.php?skki_no=$current_skki_no' onclick='return confirm(\"Delete : ".$current_skki_no." ?\")'>Delete</a>";
											$no = $i+$offset+1;
											$current_skki_nilai = number_format($current_skki_nilai);
											$current_skki_terpakai = number_format($current_skki_terpakai);
											$current_skki_tanggal = date('d-m-Y',strtotime($current_skki_tanggal));
											echo "<tr align='center'><td>$no</td>
													<td>$current_skki_jenis</td>
													<td>$current_skki_no</td>
													<td>$current_area_kode</td>
													<td>Rp.$current_skki_nilai</td>
													<td>Rp.$current_skki_terpakai</td>
													<td>$current_skki_tanggal</td>
													<td>$edit_action</td>
													<td>$delete_action</td>";
											}
									?>
									</tbody>
								</table>

								<?php
								/******  build the pagination links ******/
									// range of num links to show
									$range = 5;
									echo "<div class='col-md-12'>
													<section class='panel'>
														<div class='panel-body'>
															<div class='text-center'>
																<ul class='pagination'>";
											// if not on page 1, don't show back links
											if ($currentpage > 1) {
											   // show << link to go back to page 1
											   echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=1'><<</a></li> ";
											   // get previous page num
											   $prevpage = $currentpage - 1;
											   // show < link to go back to 1 page
											   echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'><</a></li> ";
											} // end if 

											// loop to show links to range of pages around current page
											for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
											   // if it's a valid page number...
											   if (($x > 0) && ($x <= $totalpages)) {
												  // if we're on current page...
												  if ($x == $currentpage) {
													 // 'highlight' it but don't make a link
													 echo "<li><a href='#'><b>$x</b></a></li>";
												  // if not current page...
												  } else {
													 // make it a link
													 echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$x'>$x</a></li> ";
												  } // end else
											   } // end if 
											} // end for
															 
											// if not on last page, show forward and last page links        
											if ($currentpage != $totalpages) {
											   // get next page
											   $nextpage = $currentpage + 1;
												// echo forward link for next page 
											   echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage'>></a></li> ";
											   // echo forward link for lastpage
											   echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages'>>></a></li> ";
											} // end if
											/****** end build pagination links ******/
											echo "</ul>
												</div>
											</div>
										</section>
									</div>";
									?>
								</div>
							</section>
						</div>
					</div>
				</section><!-- /.content -->
			</aside><!-- /.right-side -->
		</div>
		<script type="text/javascript">
	      	$('.year').datepicker({
		        minViewMode: 2,
		        format: 'yyyy',
		        autoclose:true
	       	});
	  	</script> 	
		<?php include("lib/footer.php");?>
	</body>
</html>