<?php session_start();
    include_once('lib/head.php');
    include_once("lib/check.php");?>
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
        <?php include("lib/header.php");
            session_start();
            $print_kode_area = $_SESSION['area'];
            ?> 
        
                <div class="wrapper row-offcanvas row-offcanvas-left">
                    <!-- Left side column. contains the logo and sidebar -->
                    <?php include("lib/menu.php");?>
                    <aside class="right-side">

                <!-- Main content -->
                <section class="content">

        <div class="row">
            
                    </div>


    <div class="row">
		<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">edit - hapus progress kerja</header>
			<div class="panel-body table-responsive">
				<div class="demo-html"></div>
				<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
								
					<thead>						
						<tr>
							<th>#</th>
							<th>No SPJ</th>
							<th>Nama Area</th>
							<th>Nama Vendor</th>
							<th>Jenis Pekerjaan</th>
							<th>Progress</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody>
						<?php
                            $area = $_GET['area'];
                            $vendor = $_GET['vendor'];
                            
                                if ($area=="" && $vendor=="") {
                                    $count = "SELECT count(a.spj_no) FROM tb_progress a join tb_spj b on a.spj_no = b.SPJ_NO where b.AREA_KODE $print_kode_area  ";
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
                                    
                                    $sql="SELECT DISTINCT a.spj_no, f.AREA_NAMA, b.vendor_nama, c.paket_deskripsi, 
										d.progress_value FROM tb_spj a left join tb_vendor b on a.VENDOR_ID = b.VENDOR_ID 
											LEFT JOIN tb_paket c on a.PAKET_JENIS = c.PAKET_JENIS LEFT JOIN tb_skko_i e on a.SKKI_NO = e.SKKI_NO
												LEFT JOIN tb_area f on e.AREA_KODE = f.AREA_KODE LEFT JOIN tb_progress d on a.SPJ_NO = d.SPJ_NO 
													where f.AREA_KODE=$print_kode_area and d.progress_value !=''	
											";
                                } elseif ($vendor=="" && $area!="") {
                                    $count = "SELECT DISTINCT a.spj_no, f.AREA_NAMA, b.vendor_nama, c.paket_deskripsi, 
										d.progress_value FROM tb_spj a left join tb_vendor b on a.VENDOR_ID = b.VENDOR_ID 
											LEFT JOIN tb_paket c on a.PAKET_JENIS = c.PAKET_JENIS LEFT JOIN tb_skko_i e on a.SKKI_NO = e.SKKI_NO
												LEFT JOIN tb_area f on e.AREA_KODE = f.AREA_KODE LEFT JOIN tb_progress d on a.SPJ_NO = d.SPJ_NO 
													where a.vendor_id != 106 and a.PAKET_JENIS != 0 and f.AREA_KODE=$print_kode_area";
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
                                    
                                    
                                    $sql="SELECT DISTINCT a.spj_no,f.AREA_NAMA, 
											b.vendor_nama, 
											c.paket_deskripsi, 
											(datediff(CURDATE(),a.SPJ_TANGGAL_MULAI)/ datediff(IFNULL(a.SPJ_ADD_TANGGAL,a.SPJ_TANGGAL_AKHIR),a.SPJ_TANGGAL_MULAi)), 
											(select max(d.progress_value) from tb_progress d where d.spj_no = a.spj_no ) 
											FROM tb_spj a left join tb_vendor b on a.VENDOR_ID = b.VENDOR_ID
														  LEFT JOIN tb_paket c on a.PAKET_JENIS = c.PAKET_JENIS
                                                          LEFT JOIN tb_skko_i e on a.SKKI_NO = e.SKKI_NO
                                                          LEFT JOIN tb_area f on e.AREA_KODE = f.AREA_KODE
                                            WHERE f.AREA_KODE = $area  and a.vendor_id != 106	and a.PAKET_JENIS != 0
											";
                                } elseif ($area=="" && $vendor!="") {
                                    $count = "SELECT DISTINCT count(a.spj_no)
											FROM tb_spj a left join tb_vendor b on a.VENDOR_ID = b.VENDOR_ID
														  LEFT JOIN tb_paket c on a.PAKET_JENIS = c.PAKET_JENIS
                                                          LEFT JOIN tb_skko_i e on a.SKKI_NO = e.SKKI_NO
                                                          LEFT JOIN tb_area f on e.AREA_KODE = f.AREA_KODE
                                            WHERE b.VENDOR_NAMA LIKE '%$vendor%'  and a.vendor_id != 106	and a.PAKET_JENIS != 0";
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
                                    
                                    $sql="SELECT DISTINCT a.spj_no, f.AREA_NAMA,
											b.vendor_nama, 
											c.paket_deskripsi, 
											(datediff(CURDATE(),a.SPJ_TANGGAL_MULAI)/ datediff(IFNULL(a.SPJ_ADD_TANGGAL,a.SPJ_TANGGAL_AKHIR),a.SPJ_TANGGAL_MULAi)),
											(select max(d.progress_value) from tb_progress d where d.spj_no = a.spj_no ) 
											FROM tb_spj a left join tb_vendor b on a.VENDOR_ID = b.VENDOR_ID
														  LEFT JOIN tb_paket c on a.PAKET_JENIS = c.PAKET_JENIS
                                                          LEFT JOIN tb_skko_i e on a.SKKI_NO = e.SKKI_NO
                                                          LEFT JOIN tb_area f on e.AREA_KODE = f.AREA_KODE
                                            WHERE b.VENDOR_NAMA LIKE '%$vendor%'  and a.vendor_id != 106	and a.PAKET_JENIS != 0
											";
                                } elseif ($area!="" && $vendor!="") {
                                    $count = "SELECT DISTINCT count(a.spj_no)
											FROM tb_spj a left join tb_vendor b on a.VENDOR_ID = b.VENDOR_ID
														  LEFT JOIN tb_paket c on a.PAKET_JENIS = c.PAKET_JENIS
                                                          LEFT JOIN tb_skko_i e on a.SKKI_NO = e.SKKI_NO
                                                          LEFT JOIN tb_area f on e.AREA_KODE = f.AREA_KODE
                                            WHERE f.AREA_KODE = $area and b.VENDOR_NAMA LIKE '%$vendor%'  and a.vendor_id != 106	and a.PAKET_JENIS != 0";
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
                                    
                                    $sql="SELECT DISTINCT a.spj_no, f.AREA_NAMA,
											b.vendor_nama, 
											c.paket_deskripsi, 
											(datediff(CURDATE(),a.SPJ_TANGGAL_MULAI)/ datediff(IFNULL(a.SPJ_ADD_TANGGAL,a.SPJ_TANGGAL_AKHIR),a.SPJ_TANGGAL_MULAi)),
											(select max(d.progress_value) from tb_progress d where d.spj_no = a.spj_no ) 
											FROM tb_spj a left join tb_vendor b on a.VENDOR_ID = b.VENDOR_ID
														  LEFT JOIN tb_paket c on a.PAKET_JENIS = c.PAKET_JENIS
                                                          LEFT JOIN tb_skko_i e on a.SKKI_NO = e.SKKI_NO
                                                          LEFT JOIN tb_area f on e.AREA_KODE = f.AREA_KODE
                                            WHERE f.AREA_KODE = $area and b.VENDOR_NAMA LIKE '%$vendor%'  and a.vendor_id != 106	and a.PAKET_JENIS != 0
											";
                                }
                                //echo  $sql;
                                $resultQuery=mysqli_query($mysqli, $sql);
                                while ($rows=mysqli_fetch_row($resultQuery)) {
                                    $data[] = $rows;
                                }
                                for ($i=0;$i<count($data);$i++) {
                                    $current_no_spj = $data[$i][0];
                                    $current_nama_area = $data[$i][1];
                                    $current_nama_vendor = $data[$i][2];
                                    $current_jenis_pekerjaan = $data[$i][3];
                                    $current_durasi_waktu = $data[$i][4];
                                    $current_progress_pekerjaan =   ($data[$i][4] == "" ? 0 : $data[$i][4]) ;
                                    $a=($i+1)+(($currentpage-1)*$rowsperpage);
                                    $b= floor($current_durasi_waktu*100);
                                    if ($b>100) {
                                        $b = 100;
                                    }
                                    if ($b>=75) {
                                        $class="badge badge-success";
                                    } elseif ($b>=50) {
                                        $class="badge badge-info";
                                    } elseif ($b>=25) {
                                        $class="badge badge-warning";
                                    } elseif ($b<0) {
                                        $b=0;
                                        $class="badge badge-danger";
                                    } else {
                                        $class="badge badge-danger";
                                    };
                                    $c= $current_progress_pekerjaan;
                                    if ($c>=75) {
                                        $class1="badge badge-success";
                                    } elseif ($c>=50) {
                                        $class1="badge badge-info";
                                    } elseif ($c>=25) {
                                        $class1="badge badge-warning";
                                    } else {
                                        $class1="badge badge-danger";
                                    };
                                    echo "<tr><td>$a</td>
										  <td><a href='history.php?id=$current_no_spj'>$current_no_spj </a></td>
										  <td>AREA $current_nama_area</td>
										  <td>$current_nama_vendor</td>
										  <td>$current_jenis_pekerjaan</td>	
										  <td><span class='$class1'>$c%</span></td>
										  <td><a href='edit_progress_form.php?spj_no=$current_no_spj&area_kode=$print_kode_area'>
												edit</a></td>
										  <td><a href='delete_progress.php?spj_no=$current_no_spj&progress=$current_durasi_waktu'
										   onclick='return confirm(\"Hapus Progress ".$current_no_spj." ?\")'>delete</a></td></tr>
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
                                echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=1&area=$area&vendor=$vendor'><<</a></li> ";
                                // get previous page num
                                $prevpage = $currentpage - 1;
                                // show < link to go back to 1 page
                                echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage&area=$area&vendor=$vendor'><</a></li> ";
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
                                        echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$x&area=$area&vendor=$vendor'>$x</a></li> ";
                                    } // end else
                                } // end if
                            } // end for
                                             
                            // if not on last page, show forward and last page links
                            if ($currentpage != $totalpages) {
                                // get next page
                                $nextpage = $currentpage + 1;
                                // echo forward link for next page
                                echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage&area=$area&vendor=$vendor'>></a></li> ";
                                // echo forward link for lastpage
                                echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages&area=$area&vendor=$vendor'>>></a></li> ";
                            } // end if
                            /****** end build pagination links ******/
                            echo "</ul>
							</div>
						</div>
					</section>
				</div>";
                ?>
				<p class="text-center"><a href="kecepatan_kerja_excel.php?area=<?php echo $area;?>&vendor=<?php echo $vendor;?>" class='btn btn-success center' >Export Excel</a></p>
		
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