<?php session_start();
include_once('lib/head.php');
include_once("lib/check.php"); ?>

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
	});
</script>

<body class="skin-black">
	<!--include file header-->
	<?php
	include("lib/header.php");
	$kode_area = $_SESSION['area'];
	?>
	<div class="wrapper row-offcanvas row-offcanvas-left">
		<!-- Left side column. contains the logo and sidebar -->
		<?php include("lib/menu.php"); ?>

		<aside class="right-side">

			<!-- Main content -->
			<section class="content">
				<div class="row">
					<div class="col-md-12">
						<section class="panel">
							<header class="panel-heading">TAMBAH USER</header>
							<div class="panel-body">
								<form class="form-horizontal tasi-form" method="post" action="inp_user_all_submit.php">
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Area Kode</label>
										<div class="col-sm-10">
											<select class="form-control m-b-10" name="var_area">
												<option value=0>- Pilih Area -</option>
												<?php
												$data = select_area($mysqli);
												for ($i = 0; $i < count($data); $i++) {
													$current_area = $data[$i][1];
												?><option value=<?php echo $data[$i][0] ?>> <?php echo $current_area; ?> </option><?php
																																																				}
																																																					?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Username</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="var_username">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Email</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="var_email">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Jabatan</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="var_jabatan">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">ROLE</label>
										<div class="col-sm-10">
											<select class="form-control m-b-10" name="var_role">
												<option value=0> - Pilih Role - </option>
												<?php
												$data = select_role($mysqli);
												for ($i = 0; $i < count($data); $i++) {
													$current_role = $data[$i][1];
												?><option value=<?php echo $data[$i][0] ?>> <?php echo $current_role; ?> </option><?php
																																																				}
																																																					?>
											</select>
										</div>
									</div>

									<div class="form-group">
										<div class="col-lg-offset-2 col-lg-10">
											<button type="submit" class="btn btn-info" onclick="document.getElementById('submitForm').submit()">Submit</button>
										</div>
									</div>
								</form>
							</div>

							<div class="panel-body table-responsive">
								<?php
								$count = " select count(username) from tb_user";
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

								?>
								<div class="demo-html"></div>
								<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
									<thead>
										<tr align="center">
											<td><strong>#</strong></td>
											<td><strong>Username</strong></td>
											<td><strong>Role ID</strong></td>
											<td><strong>Area Kode</strong></td>
											<td><strong>Password</strong></td>
											<td><strong>User Status</strong></td>
											<td><strong>Email</strong></td>
											<td><strong>Jabatan</strong></td>
											<th>Delete</th>
										</tr>
									</thead>

									<tbody>
										<?php

										//$query = "select * from tb_user order by USER_STATUS desc LIMIT $offset, $rowsperpage";
										$query = "select * from tb_user order by USER_STATUS desc ";
										$resultQuery = mysqli_query($mysqli, $query);

										while ($rows = mysqli_fetch_row($resultQuery)) {
											$bah[] = $rows;
										}
										for ($i = 0; $i < count($bah); $i++) {
											$pengguna = $bah[$i][0];
											$hak_akses = $bah[$i][1];
											$area_kode = $bah[$i][2];
											$password = $bah[$i][3];
											$user_status = $bah[$i][4];
											if ($user_status == 0) {
												$user_status = "<button type='submit' class='btn btn-success'>verified</button>";
											} else {
												$user_status = "<form method='POST' action='verified_user.php?pengguna=$pengguna'>
												
												<button type='submit' class='btn btn-warning'>not verified</button>
												</form>
												";
											}
											$email = $bah[$i][5];
											$jabatan = $bah[$i][6];
											$print_area = $bah[$i][2];
											$no = $i + $offset + 1;
											$edit_action = "<a href='user_edit.php?username=$pengguna&password=$password&email=$email&area_kode=$print_area'>Edit</a>";
											$delete_action = "<a href='user_delete.php?username=$pengguna' onclick='return confirm(\"Yakin Delete : " . $pengguna . " ?\")'>Delete</a>";

											echo "<tr align='center'><td>$no</td>
													<td>$pengguna</td>
													<td>$hak_akses</td>
													<td>$area_kode</td>
													<td>$password</td>
													<td>$user_status</td>
													<td>$email</td>
													<td>$jabatan</td>
													<td>$delete_action</td>
													
													";
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

	<?php include("lib/footer.php"); ?>
</body>

</html>