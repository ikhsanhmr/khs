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
							<header class="panel-heading">spj</header>
							<div class="panel-body table-responsive">
								<div class="demo-html"></div>
								<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
									<thead>						
										<tr>
											<th>#</th>
											<th>No SPJ <br/><button type='button' name='lihat_detail' id='lihat_detail' class='btn btn-info btn-xs'>(klik untuk melihat history dokumen)</button></th>
											<th>Nama Area</th>
											<th>Nama Vendor</th>
											<th>Jenis Pekerjaan</th>
											<th>Deskripsi Pekerjaan</th>
											<th>Detail Pekerjaan</th>
											<th>Download</th>
											<th>Upload</th>
											<th>Delete</th>
											<!--<th>Edit</th>-->
										</tr>
									</thead>
									<tbody>
									<?php
                                    $area = $_SESSION['area'];
                                        
                                    $count = "SELECT COUNT(*) FROM TB_SPJ WHERE AREA_KODE =$area order by SPJ_INPUT_DATE desc";
                                    //echo $count;
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
                                                
                                    //$sql="SELECT * FROM TB_SPJ WHERE AREA_KODE = $area order by SPJ_INPUT_DATE desc LIMIT $offset, $rowsperpage";
                                    $sql="SELECT * FROM TB_SPJ WHERE AREA_KODE = $area order by SPJ_INPUT_DATE desc";
                                    //echo $sql;
                                    $resultQuery=mysqli_query($mysqli, $sql);
                                    while ($rows=mysqli_fetch_array($resultQuery)) {
                                        $data[] = $rows;
                                    }
                                    for ($i=0;$i<count($data);$i++) {
                                        $current_no_spj 	= $data[$i]['SPJ_NO'];
                                        $current_nama_area 	= $data[$i]['AREA_KODE'];
                                        $get_nama = select_nama_area($current_nama_area, $mysqli);
                                        $nama_area = $get_nama[0][0];

                                        $current_vendor= $data[$i]['VENDOR_ID'];
                                        $get_vendor = select_nama_vendor($current_vendor, $mysqli);
                                        $nama_vendor = $get_vendor[0][0];

                                        $current_jenis_pekerjaan = $data[$i]['PAKET_JENIS'];
                                        $get_paket = get_desk_paket($current_jenis_pekerjaan, $mysqli);
                                        $des_paket = $get_paket[0][0];
                                        $current_desc = $data[$i]['SPJ_DESKRIPSI'];
                                        $a=($i+1)+(($currentpage-1)*$rowsperpage);

                                        /*echo "<tr><td>$a</td>
                                            <td><a href='history_upload_dokumen.php?spj_no=$current_no_spj'>$current_no_spj</a></td>
                                            <td>AREA $nama_area</td>
                                            <td>$nama_vendor</td>
                                            <td>$des_paket</td>
                                            <td>$current_desc</td>
                                            <td><button type='button' name='lihat_detail' id='lihat_detail' class='btn btn-success btn-xs'>Detail</button></td>
                                            <td><a href='addendum_print.php?id=$current_no_spj')'>Download</a></td>
                                            <td><a href='upload_spj_add.php?id=$current_no_spj')'>Upload</a></td>
                                            <td><a href='spj_delete.php?id=$current_no_spj' onclick='return confirm(\"Hapus ".$current_no_spj." ?\")'>Hapus</a></td>
                                            <td><a href='spj_edit.php?spj_no=$current_no_spj')'>Edit</a></td></tr>
                                         ";*/
                                     
                                        echo "<tr><td>$a</td>
										<td><a href='history_upload_dokumen.php?spj_no=$current_no_spj'>$current_no_spj</a></td>
										<td>AREA $nama_area</td>
										<td>$nama_vendor</td>
										<td>$des_paket</td>
										<td>$current_desc</td>
										<td><button type='button' name='lihat_detail' id='lihat_detail' class='btn btn-success btn-xs'>Detail</button></td>
										<td><a href='addendum_print.php?id=$current_no_spj')'>Download</a></td>
										<td><a href='upload_spj_add.php?id=$current_no_spj')'>Upload</a></td>
										<td><a href='spj_delete.php?id=$current_no_spj' onclick='return confirm(\"Hapus ".$current_no_spj." ?\")'>Hapus</a></td>
										
									 ";
                                     
                                        /* echo "<tr><td>$a</td>
                                            <td>$current_no_spj</td>
                                            <td>AREA $nama_area</td>
                                            <td>$nama_vendor</td>
                                            <td>$des_paket</td>
                                            <td>$current_desc</td>
                                            <td><a href='addendum_print.php?id=$current_no_spj')'>Download</a></td>
                                            <td><a href='spj_delete.php?id=$current_no_spj' onclick='return confirm(\"Hapus ".$current_no_spj." ?\")'>Hapus</a></td>

                                         ";*/
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