<?php session_start();
	include_once('lib/head.php');
	include_once("lib/check.php");
	$id_vendor = $_GET['vendor_id'];
	$paket_jenis = $_GET['paket_jenis'];
	$sql="SELECT A.VENDOR_ID, A.VENDOR_NAMA, b.paket_jenis, b.pagu_kontrak_sebelum_update, 
		b.pagu_kontrak_setelah_update, b.file_bukti, b.update_by, b.update_date FROM tb_vendor a, 
			tb_pagu_kontrak_update B WHERE a.VENDOR_ID=b.VENDOR_ID AND a.vendor_id = $id_vendor and b.paket_jenis=$paket_jenis";
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
														FROM tb_pagu_kontrak_update
														WHERE VENDOR_ID = $id_vendor and paket_jenis=$paket_jenis";

										$res_summary = mysqli_query($mysqli, $sql_summary);
										$summary = mysqli_fetch_assoc($res_summary);
										$jumlah_update = $summary['jumlah'];
									
										for($i=0;$i<count($data);$i++){
										$nama_vendor = $data[$i][1];

									} 
									?>

									Data Pagu Kontrak Vendor <strong><?php echo $nama_vendor; ?></strong> telah diupdate <strong><?php echo $jumlah_update; ?>  kali</strong> 
                              </div>
                            </section>
                        </div>
              </div>


		<section class="panel">
			<header class="panel-heading">Detail Update Pagu Kontrak Vendor</header>
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
										<th>Paket Jenis</th>
										<th>Pagu Kontrak Sebelum Update</th>
										<th>Pagu Kontrak Setelah Update</th>
										<th>Surat Permohonan Perubahan</th>
										<th>Diupdate Oleh</th>
										<th>Tanggal Update</th>
									</tr>
								";
							}
							?>
					</thead>
					<tbody>
						<?php
							$sql1 = "SELECT count(vendor_id) as jumlah
														FROM tb_fin_vendor_update
														WHERE VENDOR_ID = $id_vendor and paket_jenis=$paket_jenis";
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
								echo "Belum Ada Data Update Pagu Kontrak untuk  Vendor <strong>$vendor_nama</strong>";
							}else{
								for($i=0;$i<count($data);$i++){
									$paket_jenis = $data[$i][2];
									$pagu_sebelum_update = number_format($data[$i][3]);
									$pagu_setelah_update = number_format($data[$i][4]);
									$file_permohonan = $data[$i][5];
									$update_by = $data[$i][6];
									$update_date = $data[$i][7];
									
									
									$fin_update_date = date('d-m-Y',strtotime($data[$i][6]));
									$current_tanggal_akhir =  date('d-m-Y',strtotime($data[$i][7]));
									$b=($i+1)+(($currentpage-1)*$rowsperpage);
									$current_value = number_format($current_nilai_spj);
									echo "<tr><td>$b</td>
											<td>$nama_vendor</td>
											<td>$paket_jenis</td>
											<td>Rp. $pagu_sebelum_update</td>
											<td>Rp. $pagu_setelah_update</td>
											<td><a href=$file_permohonan target=_blank>File Bukti Edit Finansial</a></td>
											<td>$update_by</td>
											<td>$update_date</td>
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
	
	<?php include("lib/footers.php");?>
	</body>
</html>