<?php session_start();
	include_once('lib/head.php');
	include_once("lib/check.php");
	$id_vendor = $_GET['vendor_id'];
	$sql="SELECT a.vendor_nama, b.rating_laporan_audit_sebelum_update, b. rating_laporan_audit_setelah_update, b.fin_limit_sebelum_update,
			b.fin_limit_setelah_update, b.fin_update_user, b.fin_update_date, b.file_bukti, b.status from tb_vendor a, tb_fin_vendor_update b
			WHERE a.VENDOR_ID = b.vendor_id 
			AND a.vendor_id = $id_vendor";
		$resultQuery=mysqli_query($mysqli, $sql);
		while ($rows=mysqli_fetch_row($resultQuery)){ 
		$data[] = $rows;
		}
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

			 <div class="row">
                        <div class="col-md-12">
                            <section class="panel">
                              <header class="panel-heading">
                                 Summary
                              </header>
                              <div class="panel-body">

                              	<?php 

										$sql_summary = "SELECT count(vendor_id) as jumlah
														FROM tb_fin_vendor_update
														WHERE VENDOR_ID = $id_vendor";

										$res_summary = mysqli_query($mysqli, $sql_summary);
										$summary = mysqli_fetch_assoc($res_summary);
										$jumlah_update = $summary['jumlah'];
									
										for($i=0;$i<count($data);$i++){
										$nama_vendor = $data[$i][0];

									} 
									?>

									Data Finansial Vendor <strong><?php echo $nama_vendor; ?></strong> telah diupdate <strong><?php echo $jumlah_update; ?>  kali</strong> 
                              </div>
                            </section>
                        </div>
              </div>


		<section class="panel">
			<header class="panel-heading">Detail Update Finansial Vendor</header>
			<div class="panel-body table-responsive">			
				<table class="table table-hover">
					<thead>
						<tr>
							<td><a href='edit_finansial_vendor.php' class="btn btn-info">BACK</a></td>
						</tr>
						<?php
							if(count($data)>0){
								echo "
									<tr>
										<th>#</th>
										<th>Nama Vendor</th>
										<th>Rating Laporan Audit Sebelum Update</th>
										<th>Rating Laporan Audit Setelah Update</th>
										<th>Finansial Limit Sebelum Update</th>
										<th>Finansial Limit Setelah Update</th>
										<th>Diupdate Oleh</th>
										<th>Tanggal Update</th>
										<th>Bukti Landasan Update</th>
										<th>Status Verifikasi</th>
									</tr>
								";
							}
							?>
					</thead>
					<tbody>
						<?php
							$sql1 = "SELECT count(vendor_id) as jumlah
														FROM tb_fin_vendor_update
														WHERE VENDOR_ID = $id_vendor";
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
								
							if(count($data)==0){
								$sql="SELECT * from tb_vendor 
									WHERE vendor_id = $id_vendor";
								$resultQuery=mysqli_query($mysqli, $sql);
								while ($rows=mysqli_fetch_row($resultQuery)){ 
								$vendor_nama = $rows[1];
								}
								echo "Belum Ada Data Update Finansial untuk  Vendor <strong>$vendor_nama</strong>";
							}else{
								for($i=0;$i<count($data);$i++){
									$rating_laporan_audit_sebelum_update = $data[$i][1];
									$rating_laporan_audit_setelah_update = $data[$i][2];
									$fin_limit_sebelum_update = $data[$i][3];
									$fin_limit_setelah_update = $data[$i][4];
									$fin_update_user = $data[$i][5];
									$file_bukti = $data[$i][7];
									$status_verifikasi = $data[$i][8];
									if($status_verifikasi==0){
										$print_status_verifikasi="<span class='badge badge-warning'>menunggu verifikasi</span>";
									}elseif($status_verifikasi==1){
										$print_status_verifikasi="<span class='badge badge-success'>diterima</span>";
									}else{
										$print_status_verifikasi="<span class='badge badge-danger'>ditolak</span>";
									}
									
									$fin_update_date = date('d-m-Y',strtotime($data[$i][6]));
									$current_tanggal_akhir =  date('d-m-Y',strtotime($data[$i][7]));
									$b=($i+1)+(($currentpage-1)*$rowsperpage);
									$current_value = number_format($current_nilai_spj);
									echo "<tr><td>$b</td>
											<td>$nama_vendor</td>
											<td>$rating_laporan_audit_sebelum_update</td>
											<td>$rating_laporan_audit_setelah_update</td>
											<td>$fin_limit_sebelum_update</td>
											<td>$fin_limit_setelah_update</td>
											<td>$fin_update_user</td>
											<td>$fin_update_date</td>
											<td><a href=$file_bukti target=_blank>File Bukti Edit Finansial</a></td>
											<td>$print_status_verifikasi</td>
											</tr>";
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
	
	<?php include("lib/footer.php");?>
	</body>
</html>