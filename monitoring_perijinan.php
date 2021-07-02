<?php 
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
include_once("lib/function.php");
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
				<header class="panel-heading">Monitoring Perijinan</header>
				<div class="panel-body">
					<form role="form">
						<div class="form-group">
							<label for="lokasi_ijin">Lokasi Perijinan</label>
							<input type="text" class="form-control" placeholder="Lokasi Perijinan" name="lokasi_ijin" id="lokasi_ijin">
						</div>
						<div class="form-group">
							<label for="surat_ptsp">Surat PTSP</label>
							<input type="text" class="form-control" placeholder="Surat PTSP" name="no_surat_ptsp" id="no_surat_ptsp">
						</div>
						<div class="form-group">
							<label for="surat_spj">Surat SPJ</label>
							<input type="text" class="form-control" placeholder="Surat SPJ" name="no_spj" id="no_spj">
						</div>

						<button type="submit" class="btn btn-info"><a href="/khs/monitoring_perijinan.php"></a>Submit</button>
					</form>
				</div>
				</section>
			</div>
		</div>                

		<div class="row">
			<div class="col-md-12">
				<section class="panel">
					<header class="panel-heading">Perijinan</header>
					<div class="panel-body table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>#</th>
									<th>No. SPJ</th>
									<th>Lokasi Perijinan</th>
									<th>No. Surat PTSP</th>
									<th>Tanggal Keluar Surat PTSP</th>
									<th>Hasil Survey</th>
									<th>Tanggal Survey</th>
									<th>Tanggal Keluar SKRD</th>
									<th>Pembayaran Retribusi</th> <!--isinya dibayar tgl berapa-->
									<th>Izin Terbit</th>
								</tr>
							</thead>

							<tbody>
							<?
							$lokasi 	= $_GET['lokasi_ijin'];
							$no_ptsp 	= $_GET['no_surat_ptsp'];
							$no_spj 	= $_GET['no_spj'];

							if($no_spj=="" && $no_ptsp =="" && $lokasi ==""){	
								$sql = "SELECT COUNT(*) FROM TB_IJIN";
								$result = mysqli_query($sql);
								$r = mysqli_fetch_row($result);
								$numrows = $r[0];

								include_once("lib/paging.php");
								$sql="SELECT * FROM TB_IJIN LIMIT $offset, $rowsperpage";
							}

							if($no_spj!="" && $no_ptsp =="" && $lokasi ==""){	
								$sql = "SELECT COUNT(*) FROM TB_IJIN WHERE SPJ_NO LIKE '%$no_spj%'  ";
								$result = mysqli_query($sql);
								$r = mysqli_fetch_row($result);
								$numrows = $r[0];

								include_once("lib/paging.php");
								$sql="SELECT * FROM TB_IJIN WHERE SPJ_NO LIKE '%$no_spj%'  LIMIT $offset, $rowsperpage";
							}

							if($no_spj=="" && $no_ptsp !="" && $lokasi ==""){	
								$sql = "SELECT COUNT(*) FROM TB_IJIN WHERE SURAT_IJIN_NO LIKE '%$no_ptsp%' ";
								$result = mysqli_query($sql);
								$r = mysqli_fetch_row($result);
								$numrows = $r[0];

								include_once("lib/paging.php");
								$sql="SELECT * FROM TB_IJIN WHERE SURAT_IJIN_NO LIKE '%$no_ptsp%' LIMIT $offset, $rowsperpage";
							}

							if($no_spj=="" && $no_ptsp =="" && $lokasi !=""){	
								$sql = "SELECT COUNT(*) FROM TB_IJIN WHERE LOKASI LIKE '%$lokasi%' ";
								$result = mysqli_query($sql);
								$r = mysqli_fetch_row($result);
								$numrows = $r[0];

								include_once("lib/paging.php");
								$sql="SELECT * FROM TB_IJIN WHERE LOKASI LIKE '%$lokasi%' LIMIT $offset, $rowsperpage";
							}


							if($no_spj!="" && $no_ptsp !="" && $lokasi ==""){	
								$sql = "SELECT COUNT(*) FROM TB_IJIN WHERE SPJ_NO LIKE '%$no_spj%' AND SURAT_IJIN_NO LIKE '%$no_ptsp%'  ";
								$result = mysqli_query($sql);
								$r = mysqli_fetch_row($result);
								$numrows = $r[0];

								include_once("lib/paging.php");
								$sql="SELECT * FROM TB_IJIN WHERE SPJ_NO LIKE '%$no_spj%' AND SURAT_IJIN_NO LIKE '%$no_ptsp%' LIMIT $offset, $rowsperpage";
							}

							if($no_spj=="" && $no_ptsp !="" && $lokasi !=""){	
								$sql = "SELECT COUNT(*) FROM TB_IJIN WHERE  SURAT_IJIN_NO LIKE '%$no_ptsp%' AND LOKASI LIKE '%$lokasi%' ";
								$result = mysqli_query($sql);
								$r = mysqli_fetch_row($result);
								$numrows = $r[0];

								include_once("lib/paging.php");
								$sql="SELECT * FROM TB_IJIN WHERE SURAT_IJIN_NO LIKE '%$no_ptsp%' AND LOKASI LIKE '%$lokasi%' LIMIT $offset, $rowsperpage";
							}

							if($no_spj!="" && $no_ptsp =="" && $lokasi !=""){	
								$sql = "SELECT COUNT(*) FROM TB_IJIN WHERE  SURAT_IJIN_NO LIKE '%$no_ptsp%' AND LOKASI LIKE '%$lokasi%' ";
								$result = mysqli_query($sql);
								$r = mysqli_fetch_row($result);
								$numrows = $r[0];

								include_once("lib/paging.php");
								$sql="SELECT * FROM TB_IJIN WHERE SURAT_IJIN_NO LIKE '%$no_ptsp%' AND LOKASI LIKE '%$lokasi%' LIMIT $offset, $rowsperpage";
							}

							if($no_spj!="" && $no_ptsp !="" && $lokasi !=""){	
								$sql = "SELECT COUNT(*) FROM TB_IJIN WHERE SPJ_NO LIKE '%$no_spj%' AND SURAT_IJIN_NO LIKE '%$no_ptsp%' AND LOKASI LIKE '%$lokasi%' ";
								$result = mysqli_query($sql);
								$r = mysqli_fetch_row($result);
								$numrows = $r[0];

								include_once("lib/paging.php");
								$sql="SELECT * FROM TB_IJIN WHERE SPJ_NO LIKE '%$no_spj%' AND SURAT_IJIN_NO LIKE '%$no_ptsp%' AND LOKASI LIKE '%$lokasi%' LIMIT $offset, $rowsperpage";
							}

							
							$resultQuery=mysqli_query($sql);
							while ($rows=mysqli_fetch_array($resultQuery)){ 
								$data[] = $rows;
							}
							$nomor=1;
							for ($i=0;$i<count($data);$i++)
								{
									$no_spj			= $data[$i]['spj_no'];
									$lokasi_ijin	= $data[$i]['lokasi'];
									$surat_ijin_no	= $data[$i]['surat_ijin_no'];
									$tanggal_surat	= $data[$i]['tgl_surat'];
									$survey			= $data[$i]['info_01'];
									$tglsurvey		= $data[$i]['tgl_survey'];
									$skrd_no		= $data[$i]['skrd_no'];
									$tgl_skrd		= $data[$i]['tgl_terbit_skrd'];
									$bayar_retribusi= $data[$i]['biaya_retribusi'];
									$tgl_bayar		= $data[$i]['tgl_bayar_retribusi'];
									$izin_terbit	= $data[$i]['biaya_retribusi'];
									
									if ($survey=='0')
									{ $hasil ='OK';}	
									elseif($survey =='1') {$hasil='Perlu Revisi';}
									else {$hasil='-';}	

									if ($bayar_retribusi == '')
										{ $izin_terbit = '-';}
									else
										{$izin_terbit ='OK';}
									
									echo "<tr>";
										echo "<td>".($i+1)."</td>";
										echo "<td>".$no_spj."</td>";
										echo "<td>".$lokasi_ijin."</td>";
										echo "<td>".$surat_ijin_no."</td>";
										echo "<td>".date("d-m-Y", strtotime($tanggal_surat))."</td>";
										echo "<td>".$hasil."</td>";
										echo "<td>".date("d-m-Y", strtotime($tglsurvey))."</td>";
										echo "<td>".date("d-m-Y", strtotime($tgl_skrd))."</td>";
										echo "<td>".date("d-m-Y", strtotime($tgl_bayar))."</td>";
										echo "<td>".$izin_terbit."</td>";
									echo "</tr>";
								}
							?>
							</tbody>
						</table>
						<?
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
											   echo "<li><a href='{$_SERVER['PHP_SELF']}?currentpage=1&no_spj=$no_spj'><<</a></li> ";
											   // get previous page num
											   $prevpage = $currentpage - 1;
											   // show < link to go back to 1 page
											   echo "<li><a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage&no_spj=$no_spj'><</a></li> ";
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
													 echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$x&no_spj=$no_spj'>$x</a></li> ";
												  } // end else
											   } // end if 
											} // end for
											 
											// if not on last page, show forward and last page links        
											if ($currentpage != $totalpages) {
											   // get next page
											   $nextpage = $currentpage + 1;
												// echo forward link for next page 
											   echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage&no_spj=$no_spj'>></a></li> ";
											   // echo forward link for lastpage
											   echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages&no_spj=$no_spj'>>></a></li> ";
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
	</section>
	</aside>

	</div>

<?php include("lib/footer.php");?>
</body>
</html>