<?php 
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
?>
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
							<header class="panel-heading">History Pembayaran</header>
							<div class="panel-body table-responsive">
								<div class="demo-html"></div>
								<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
									<thead>						
										<tr>
											<th>#</th>
											<th>Nama Area</th>
											<th>No SPJ</th>
											<th>Progress</th>
											<th>Termin1</th>
											<th>Termin2</th>
											<th>Termin3</th>
											<th>SPJ Nilai</th>
											<th>Jumlah Pembayaran</th>
											<th>Status Pembayaran</th>
										</tr>
									</thead>
									<tbody>
									<?php
									$area = $_SESSION['area'];
									
									if($area!=18){
									$count = "SELECT COUNT(*) FROM TB_SPJ WHERE AREA_KODE =$area order by SPJ_INPUT_DATE desc";
									}else{
									$count = "SELECT COUNT(*) FROM TB_SPJ order by SPJ_INPUT_DATE desc";	
									}
									//echo $count;
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
												
									//$sql="SELECT * FROM TB_SPJ WHERE AREA_KODE = $area order by SPJ_INPUT_DATE desc LIMIT $offset, $rowsperpage";
									if($area!=18){
									$sql="SELECT  a.AREA_KODE, a.SPJ_NO,  (select coalesce(max(b.progress_value),0) from tb_progress b 
											where a.spj_no = b.spj_no ) AS progress, c.termin_1, c.termin_2, c.termin_3, A.SPJ_ADD_NILAI , 
											(select coalesce(SUM(d.PEMBAYARAN_NOMINAL),0) from tb_pembayaran d where a.spj_no = d.spj_no ) 
											as jumlah_pembayaran, c.keterangan  FROM tb_spj a LEFT JOIN tb_termin c on a.SPJ_NO=c.spj_no 
											where a.AREA_KODE=$area GROUP BY c.spj_no";
									}else{
										$sql="SELECT  a.AREA_KODE, a.SPJ_NO,  (select coalesce(max(b.progress_value),0) from tb_progress b 
											where a.spj_no = b.spj_no ) AS progress, c.termin_1, c.termin_2, c.termin_3, A.SPJ_ADD_NILAI , 
											(select coalesce(SUM(d.PEMBAYARAN_NOMINAL),0) from tb_pembayaran d where a.spj_no = d.spj_no ) 
											as jumlah_pembayaran, c.keterangan  FROM tb_spj a LEFT JOIN tb_termin c on a.SPJ_NO=c.spj_no  
											GROUP BY c.spj_no";
									}
									//echo $sql;
									$resultQuery=mysqli_query($sql);
									while ($rows=mysqli_fetch_array($resultQuery)){ 
										$data[] = $rows;
									}
									for($i=0;$i<count($data);$i++){
										$current_no_spj 	= $data[$i]['SPJ_NO'];
										$current_nama_area 	= $data[$i]['AREA_KODE'];
										$get_nama = select_nama_area($current_nama_area);
										$nama_area = $get_nama[0][0];
									
										$progress = $data[$i]['progress']; 				
										$termin1 = $data[$i]['termin_1']; 				
										$termin2 = $data[$i]['termin_2']; 				
										$termin3 = $data[$i]['termin_3']; 				
										$spj_nilai = $data[$i]['SPJ_ADD_NILAI']; 				
										$jumlah_pembayaran = $data[$i]['jumlah_pembayaran']; 				
										$keterangan = $data[$i]['keterangan'];
										$b = $keterangan;
										
										if($b=='bayar 100'){
										$class="badge badge-success";
										}else if($b=='bayar 60'){
										$class="badge badge-info";
										}else if($b=='bayar 50'){
										$class="badge badge-warning";
										}else if($b=='bayar 30'){
										$class="badge badge-danger";
										}else{
										$class="badge badge-danger";
										};
										
										$c = $keterangan;
										
										
										$a=($i+1)+(($currentpage-1)*$rowsperpage);

									echo "<tr><td>$a</td>
										<td>AREA $nama_area</td>
										<td>$current_no_spj</td>
										<td>$progress</td>";
										if($c=='bayar 100'){
											$class1="badge badge-success";
											echo "<td><span class='$class1'>$termin1</span></td>
												  <td><span class='$class1'>$termin2</span></td>
												  <td><span class='$class1'>$termin3</span></td>";
										}else if($c=='bayar 60'){
											$class1="badge badge-success";
											echo "<td><span class='$class1'>$termin1</span></td>
												  <td><span class='$class1'>$termin2</span></td>
												  <td>$termin3</td>";
										}else if($c=='bayar 50'){
											$class1="badge badge-success";
											echo "<td><span class='$class1'>$termin1</span></td>
												  <td>$termin2</td>
												  <td>$termin3</td>";
										}else if($c=='bayar 30'){
											$class1="badge badge-success";
											echo "<td><span class='$class1'>$termin1</span></td>
												  <td>$termin2</td>
												  <td>$termin3</td>";
										}else{
											echo "<td>$termin1</td>
												  <td>$termin2</td>
												  <td>$termin3</td>";
										}
										
										echo"
										<td>$spj_nilai</td>
										<td>$jumlah_pembayaran</td>
										<td><span class='$class'>$keterangan</span></td>
									 ";
									}
									?>
									<!-- <td><a href='spj_edit.php?spj_no=$current_no_spj')'>Edit</a></td></tr> -->
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
										   echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=1&area=$area'><<</a></li> ";
										   // get previous page num
										   $prevpage = $currentpage - 1;
										   // show < link to go back to 1 page
										   echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage&area=$area'><</a></li> ";
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
												 echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$x&area=$area'>$x</a></li> ";
											  } // end else
										   } // end if 
										} // end for
														 
										// if not on last page, show forward and last page links        
										if ($currentpage != $totalpages) {
										   // get next page
										   $nextpage = $currentpage + 1;
											// echo forward link for next page 
										   echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage&area=$area'>></a></li> ";
										   // echo forward link for lastpage
										   echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages&area=$area'>>></a></li> ";
										} // end if
										/****** end build pagination links ******/
										echo "</ul>
										</div>
									</div>
								</section>
							</div>";
							?>
							<!-- <p class="text-center"><a href="kecepatan_kerja_excel.php?area=<?php echo $area;?>&vendor=<?php echo $vendor;?>" class='btn btn-success center' >Export Excel</a></p> -->
		
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