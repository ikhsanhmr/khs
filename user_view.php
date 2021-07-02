<?php session_start();
	  include_once('lib/head.php');
	  include_once("lib/check.php");?>
	<body class="skin-black">
		<!--include file header-->
		<?php 
			include("lib/header.php");
			$area_kode=$_SESSION['area'];
		?>	
<
		<div class="wrapper row-offcanvas row-offcanvas-left">
			<!-- Left side column. contains the logo and sidebar -->
			<?php include("lib/menu.php");?>
			<aside class="right-side">
				<!-- Main content -->
				<section class="content">
					
					<div class="row">
						<div class="col-md-12">
							<section class="panel">
								<header class="panel-heading">Delete User</header>
								<div class="panel-body table-responsive">
									<?php
									$count = "SELECT count(username) FROM tb_user ";
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
												<td><strong>Username</strong></td>
											</tr>
										</thead>
										<tbody>
											<?php
												$sql="SELECT username
														FROM tb_user order by username LIMIT $offset, $rowsperpage";
													
													$resultQuery=mysqli_query($sql);
													while ($rows=mysqli_fetch_row($resultQuery)){ 
														$data[] = $rows;
													}
												
												for($i=0;$i<count($data);$i++){
													$current_username = $data[$i][0];
													//$current_rating_lap_audit = $data[$i][1];
													//$current_fin_limit = $data[$i][2];
													//$current_fin_current = $data[$i][3];
													//$current_fin_limit=number_format($current_fin_limit);
													//$current_fin_current = number_format($current_fin_current);
													//$edit_action = "<a href='fin_vendor_edit.php?vendor_id=$current_vendor_id'>Edit</a>";
													$delete_action = "<a href='user_delete.php?username=$current_username' onclick='return confirm(\"Delete : ".$current_username." ?\")'>Delete</a>";
													$no = $i+$offset+1;
													echo "<tr align='center'>
														  <td>$no</td>
														  <td>$current_username</td>
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
		<?php include("lib/footer.php");?>
	</body>
</html>