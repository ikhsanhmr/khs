<?php 
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
/*


							$sql = "SELECT spj.spj_no, ijin.jumlah
									FROM tb_spj spj
									LEFT JOIN 
									( SELECT spj_no, count( spj_no ) AS jumlah FROM tb_ijin GROUP BY spj_no )
									ijin ON spj.spj_no = ijin.spj_no
									WHERE spj.spj_no != 'No SPJ'
									AND spj.spj_no LIKE '%$spj_no%'
									";
*/
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
				<header class="panel-heading">Perijinan</header>
				<div class="panel-body">
					<form role="form">
						<div class="form-group">
							<label for="no_spj">No. SPJ</label>
							<input type="text" class="form-control" placeholder="No. SPJ" name="no_spj">
						</div>
						<button type="submit" class="btn btn-info"><a href="/khs/perijinan.php"></a>Submit</button>
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
									<th>Jumlah Dokumen</th>
									<th>Surat Ijin yang Telah Dibuat</th>
									<th>Action</th>
								</tr>
							</thead>

							<tbody>
							<?
							$no_spj = $_GET['no_spj'];

							if($no_spj==""){	
								$sql = "SELECT count( * )
										FROM ( SELECT s.spj_no, d.jumlah_dok, i.jumlah FROM tb_spj s left JOIN tb_dokumen d ON d.spj_no = s.spj_no LEFT JOIN ( SELECT spj_no, COUNT( spj_no ) AS jumlah FROM tb_ijin GROUP BY spj_no )i ON s.spj_no = i.spj_no where d.jumlah_dok != '' AND s.SPJ_STATUS='0' AND d.info_01='0'
										)total";

										//$sql= ""
								$result = mysqli_query($sql);
								$r = mysqli_fetch_row($result);
								$numrows = $r[0];

								include_once("lib/paging.php");
										
								$sql="SELECT s.spj_no, d.jumlah_dok, i.jumlah FROM tb_spj s left JOIN tb_dokumen d ON d.spj_no = s.spj_no LEFT JOIN ( SELECT spj_no, COUNT( spj_no ) AS jumlah FROM tb_ijin GROUP BY spj_no )i ON s.spj_no = i.spj_no where d.jumlah_dok != '' AND s.SPJ_STATUS='0' AND d.info_01='0'
									LIMIT $offset, $rowsperpage";
							}

							else{		
								$sql = "SELECT count( * )
										FROM ( SELECT s.spj_no, d.jumlah_dok, i.jumlah FROM tb_spj s left JOIN tb_dokumen d ON d.spj_no = s.spj_no LEFT JOIN ( SELECT spj_no, COUNT( spj_no ) AS jumlah FROM tb_ijin GROUP BY spj_no )i ON s.spj_no = i.spj_no where d.jumlah_dok != '' AND s.SPJ_STATUS='0' AND d.info_01='0' AND s.spj_no LIKE '%$no_spj%' 
										)total";
								$result = mysqli_query($sql);
								$r = mysqli_fetch_row($result);
								$numrows = $r[0];

								include_once("lib/paging.php");
										
								$sql="SELECT s.spj_no, d.jumlah_dok, i.jumlah FROM tb_spj s left JOIN tb_dokumen d ON d.spj_no = s.spj_no LEFT JOIN ( SELECT spj_no, COUNT( spj_no ) AS jumlah FROM tb_ijin GROUP BY spj_no )i ON s.spj_no = i.spj_no where d.jumlah_dok != '' AND s.SPJ_STATUS='0' AND d.info_01='0' AND s.spj_no LIKE '%$no_spj%' 
									LIMIT $offset, $rowsperpage";
							}

							$resultQuery=mysqli_query($sql);
							while ($rows=mysqli_fetch_row($resultQuery)){ 
								$data[] = $rows;
							}

							$nomor=1;
							for ($i=0;$i<count($data);$i++){
								$current_no_spj	= $data[$i][0];
								$jumlah_dok		= $data[$i][1];
								$jumlah_ijin	= $data[$i][2];

								if($jumlah_ijin == '')
								{$jumlah_ijin =0;}

								echo "<tr>";
									echo "<td>".($i+1)."</td>";
									echo "<td>".$current_no_spj."</td>";
									echo "<td>".$jumlah_dok."</td>"; 
									echo "<td>".$jumlah_ijin."</td>";
									echo "<td>";									
									echo "<a href='perijinan_add.php?id=$current_no_spj'>Add</a>";	
									echo "</td>";
								echo "</tr>";
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
				</section>
			</div>
		</div>
	</section>
	</aside>

	</div>

<?php include("lib/footer.php");?>
</body>
</html>