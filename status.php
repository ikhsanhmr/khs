<?php session_start();
include_once('lib/head.php');
include_once("lib/check.php");
$id_vendor = $_GET['id'];
$paket_jenis = $_GET['id2'];
// var_dump($id_vendor);
// die;
$sql = "SELECT c.area_nama, 
			a.SPJ_NO, 
			a.SPJ_ADD_NILAI, 
			a.SPJ_TANGGAL_MULAI, 
			CASE WHEN a.SPJ_ADD_TANGGAL  is NULL THEN a.SPJ_TANGGAL_AKHIR
			ELSE a.SPJ_ADD_TANGGAL
			END tanggal_akhir
		FROM tb_spj a, tb_skko_i b, tb_area c
		WHERE a.VENDOR_ID = $id_vendor 
			AND a.PAKET_JENIS = $paket_jenis
			AND a.SKKI_NO = b.SKKI_NO
			AND b.area_kode = c.area_kode";
$resultQuery = mysqli_query($mysqli, $sql);
while ($rows = mysqli_fetch_row($resultQuery)) {
	$data[] = $rows;
}
?>

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

						<div class="row">
							<div class="col-md-12">
								<section class="panel">
									<header class="panel-heading">
										Summary
									</header>
									<div class="panel-body">

										<?php

										$sql_summary = "SELECT count(spj_no) as total_spj, 
													sum(SPJ_ADD_NILAI) as total_nilai,
													(select vendor_nama from tb_vendor where vendor_id = $id_vendor) as nama_vendor,
													(select paket_deskripsi from tb_paket where paket_jenis = $paket_jenis) as paket
													FROM tb_spj a
													WHERE a.VENDOR_ID = $id_vendor
													AND a.PAKET_JENIS = $paket_jenis";

										$res_summary = mysqli_query($mysqli, $sql_summary);
										$summary = mysqli_fetch_assoc($res_summary);
										$nama_paket = $summary['paket'];
										$nama_vendor = $summary['nama_vendor'];

										?>

										<strong><?php echo $summary['nama_vendor']; ?></strong> telah mengambil <strong><?php echo $summary['total_spj']; ?> SPJ</strong> untuk pekerjaan <?php echo $summary['paket']; ?> total nilai <strong>Rp.<?php echo number_format($summary['total_nilai']); ?></strong>

									</div>
								</section>
							</div>
						</div>


						<section class="panel">
							<header class="panel-heading">Detail Pekerjaan Vendor</header>
							<div class="panel-body table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<td><a href='kontrol_finansial.php' class="btn btn-info">BACK</a></td>
										</tr>
										<?php
										if (count($data) > 0) {
											echo "
									<tr>
										<th>#</th>
										<th>Area</th>
										<th>No. SPJ</th>
										<th>Nominal SPJ</th>
										<th>Tanggal Mulai</th>
										<th>Tanggal Akhir</th>
									</tr>
								";
										}
										?>
									</thead>
									<tbody>
										<?php
										$sql1 = "SELECT COUNT(*) FROM tb_spj";
										$result = mysqli_query($mysqli, $sql1);
										$r = mysqli_fetch_row($result);
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

										//table
										// var_dump($data);

										if (count($data) == 0) {
											echo "Belum Ada Data SPJ dengan Vendor <strong>$nama_vendor</strong> dan Paket <strong>$nama_paket</strong>";
										} else {
											for ($i = 0; $i < count($data); $i++) {
												$current_area = $data[$i][0];
												$current_no_spj = $data[$i][1];
												$current_nilai_spj = $data[$i][2];
												$current_tanggal_mulai = date('d-m-Y', strtotime($data[$i][3]));
												$current_tanggal_akhir =  date('d-m-Y', strtotime($data[$i][4]));
												$b = ($i + 1) + (($currentpage - 1) * $rowsperpage);
												$current_value = number_format($current_nilai_spj);
												echo "<tr><td>$b</td>
											<td>AREA $current_area</td>
											<td>$current_no_spj</td>
											<td>Rp.$current_value</td>
											<td>$current_tanggal_mulai</td>
											<td>$current_tanggal_akhir</td></tr>";
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
										}
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

	<?php include("lib/footer.php"); ?>
</body>

</html>