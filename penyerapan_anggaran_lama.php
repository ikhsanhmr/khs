<?php
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
include_once("lib/GLOBAL_VAR.php");
$area_kode=$_SESSION['area'];
?>


<link  type="text/css" href="css/bootstrap-datepicker.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>

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
                    	<header class="panel-heading">Search Criteria</header>
                        <div class="panel-body">
                            <form role="form">
                                <div class="form-group">
                                    <label for="Area" >Area</label>
                                    <select class="form-control m-b-10" name="area">
                                        <option value="">-Pilih Area-</option>
                                        
										<?php
                                         /*   $data_area=select_area();
                                                for($i=0;$i<count($data_area);$i++){
                                                    $current_area_kode = $data_area[$i][0];
                                                    $current_area_nama = $data_area[$i][1];*/
                                        ?>
                                        <!--<option value="<?php //echo $current_area_kode;?>"><?php //echo $current_area_nama;?></option>-->
                                        <?php //}?>
										<?php
                                                $datae= ($area_kode != 54560) ? select_area_by_code($area_kode, $mysqli) : select_area($mysqli);
                                                for ($i=0;$i<count($datae);$i++) {
                                                    $kodes = $datae[$i][0];
                                                    $namas = $datae[$i][1]; ?>
											<option value='<?php echo $kodes?>'><?php echo $namas; ?></option>
											<?php
                                                }
                                            ?>
										
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="Area" >Tahun</label>
	                            	<input class="year form-control date-pick"  name="tahun" placeholder="Tahun">
                                </div>
                                <button type="submit" class="btn btn-info"> <a href="/khs/kecepatan_kerja.php"></a>Submit</button>
                            </form>
                        </div>
                    </section>
                </div>
           </div>

    		<div class="row">
				<div class="col-md-12">
					<section class="panel">
						<header class="panel-heading">DATA PENYERAPAN ANGGARAN</header>
						<div class="panel-body table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>#</th>
										<th>Nama Area</th>
										<th>No SKKO/SKKI</th>
										<th>Nilai SKKO/I</th>
										<th>Sisa SKKO/I</th>
										<th>Jumlah SPJ Terbit</th>
										<th>Total Nilai SPJ</th>
										<th>Penyerapan SKKO/I (%)</th>
										<th>Pembayaran SPJ (%)</th>
										<th>Pembayaran SKKO/I (%)</th>
									</tr>
								</thead>

								<tbody>
								<?php
                                    $area 	= $_GET['area'];
                                    $tahun 	= $_GET['tahun'];

                                    if ($area=="" && $tahun=="") {
                                        $sql = "select count(a.skki_no)
											from tb_skko_i a, tb_area d
											where d.area_kode = a.area_kode
											AND a.tahun ='2018'
											AND a.area_kode = $area_kode
											order by d.area_kode, a.skki_no";
                                        $result = mysqli_query($mysqli, $sql);
                                        $r = mysqli_fetch_row($result);
                                        $numrows = $r[0];

                                        include "lib/page.php";
                                            
                                        $sql="select a.skki_no, 
												d.area_nama, 
												a.skki_nilai,
												(select count(b.spj_no) from tb_spj b where b.skki_no = a.skki_no ) as jml_spj,
												(select sum(b.SPJ_ADD_NILAI) from tb_spj b where b.skki_no = a.skki_no) as total_spj,
												(select sum(b.pembayaran_nominal) from tb_pembayaran b, tb_spj c where b.spj_no = c.spj_no and c.skki_no = a.skki_no) as total_bayar,
													a.SKKI_NILAI - SKKI_TERPAKAI as sisa_skki 
												from tb_skko_i a, tb_area d
												where d.area_kode = a.area_kode
												AND a.tahun ='2018'
												AND a.area_kode = $area_kode
												AND a.SKKI_NO NOT LIKE 'dumping%' 	
												order by d.area_kode, a.skki_no
												LIMIT $offset, $rowsperpage";
                                    } elseif ($tahun=="" && $area!="") {
                                        $sql = "select count(a.skki_no)
											from tb_skko_i a, tb_area d
											where d.area_kode = a.area_kode
											AND d.area_kode = $area
											order by d.area_kode, a.skki_no";
                                        $result = mysqli_query($mysqli, $sql);
                                        $r = mysqli_fetch_row($result);
                                        $numrows = $r[0];

                                        include "lib/page.php";
                                            
                                        $sql="select a.skki_no, 
												d.area_nama, 
												a.skki_nilai,
												(select count(b.spj_no) from tb_spj b where b.skki_no = a.skki_no ) as jml_spj,
												(select sum(b.SPJ_ADD_NILAI) from tb_spj b where b.skki_no = a.skki_no) as total_spj,
												(select sum(b.pembayaran_nominal) from tb_pembayaran b, tb_spj c where b.spj_no = c.spj_no and c.skki_no = a.skki_no) as total_bayar,
													a.SKKI_NILAI - SKKI_TERPAKAI as sisa_skki 
												from tb_skko_i a, tb_area d
												where d.area_kode = a.area_kode
												AND d.area_kode = $area
												AND a.SKKI_NO NOT LIKE 'dumping%' 
												order by d.area_kode, a.skki_no
												LIMIT $offset, $rowsperpage";
                                    } elseif ($area=="" && $tahun!="") {
                                        $sql = "select count(a.skki_no)
											from tb_skko_i a, tb_area d
											where d.area_kode = a.area_kode
											AND a.tahun =$tahun
											AND a.SKKI_NO NOT LIKE 'dumping%' 
											order by d.area_kode, a.skki_no";
                                        $result = mysqli_query($mysqli, $sql);
                                        $r = mysqli_fetch_row($result);
                                        $numrows = $r[0];

                                        include "lib/page.php";
                                            
                                        $sql="select a.skki_no, 
												d.area_nama, 
												a.skki_nilai,
												(select count(b.spj_no) from tb_spj b where b.skki_no = a.skki_no ) as jml_spj,
												(select sum(b.SPJ_ADD_NILAI) from tb_spj b where b.skki_no = a.skki_no) as total_spj,
												(select sum(b.pembayaran_nominal) from tb_pembayaran b, tb_spj c where b.spj_no = c.spj_no and c.skki_no = a.skki_no) as total_bayar,
													a.SKKI_NILAI - SKKI_TERPAKAI as sisa_skki 
												from tb_skko_i a, tb_area d
												where d.area_kode = a.area_kode
												AND a.tahun =$tahun
												AND a.SKKI_NO NOT LIKE 'dumping%' 
												order by d.area_kode, a.skki_no
												LIMIT $offset, $rowsperpage";
                                    } else {
                                        $sql = "select count(a.skki_no)
											from tb_skko_i a, tb_area d
											where d.area_kode = a.area_kode
		                                    and d.AREA_KODE = $area
		                                    AND a.tahun =$tahun
											AND a.SKKI_NO NOT LIKE 'dumping%' 
		                                    order by d.area_kode, a.skki_no";
                                        $result = mysqli_query($mysqli, $sql);
                                        $r = mysqli_fetch_row($result);
                                        $numrows = $r[0];

                                        include "lib/page.php";
                                            
                                        $sql="select a.skki_no, 
												d.area_nama, 
												a.skki_nilai,
												(select count(b.spj_no) from tb_spj b where b.skki_no = a.skki_no ) as jml_spj,
												(select sum(b.SPJ_ADD_NILAI) from tb_spj b where b.skki_no = a.skki_no) as total_spj,
												(select sum(b.pembayaran_nominal) from tb_pembayaran b, tb_spj c where b.spj_no = c.spj_no and c.skki_no = a.skki_no) as total_bayar,
												a.SKKI_NILAI - SKKI_TERPAKAI as sisa_skki
												from tb_skko_i a, tb_area d
												where d.area_kode = a.area_kode
		                                        and d.AREA_KODE = $area
		                                        AND a.tahun =$tahun
												AND a.SKKI_NO NOT LIKE 'dumping%' 
		                                        order by d.area_kode, a.skki_no 
												LIMIT $offset, $rowsperpage";
                                    }

                                    $resultQuery=mysqli_query($mysqli, $sql);
                                    while ($rows=mysqli_fetch_row($resultQuery)) {
                                        $data[] = $rows;
                                    }

                                    for ($i=0;$i<count($data);$i++) {
                                        $current_nama_area 		= $data[$i][1];
                                        $current_no_skko 		= $data[$i][0];
                                        $current_nominal_skko 	= $data[$i][2];
                                        $current_jumlah_spj 	= $data[$i][3];
                                        $current_nominal_spj 	= $data[$i][4];
                                        $current_persentasi_pembayaran_spj = $data[$i][5];

                                        $b 			=floor($current_nominal_spj/$current_nominal_skko*100);
                                        $nominal 	= number_format($current_nominal_spj);
                                        $nominal2 	= number_format($current_nominal_skko);
                                        $sisa_skki = number_format($data[$i][6]);
                                    
                                        $a=($i+1)+(($currentpage-1)*$rowsperpage);
                                        if ($b>=75) {
                                            $class="badge badge-success";
                                        } elseif ($b>=50) {
                                            $class="badge badge-info";
                                        } elseif ($b>=25) {
                                            $class="badge badge-warning";
                                        } else {
                                            $class="badge badge-danger";
                                        };
                                        $c=floor($current_persentasi_pembayaran_spj/$current_nominal_spj*100);
                                        if ($c>=75) {
                                            $class1="badge badge-success";
                                        } elseif ($c>=50) {
                                            $class1="badge badge-info";
                                        } elseif ($c>=25) {
                                            $class1="badge badge-warning";
                                        } else {
                                            $class1="badge badge-danger";
                                        };
                                        $d=floor($current_persentasi_pembayaran_spj/$current_nominal_skko*100);
                                        if ($d>=75) {
                                            $class2="badge badge-success";
                                        } elseif ($d>=50) {
                                            $class2="badge badge-info";
                                        } elseif ($d>=25) {
                                            $class2="badge badge-warning";
                                        } else {
                                            $class2="badge badge-danger";
                                        };
                                        echo "<tr><td>$a</td>
											  <td>AREA $current_nama_area</td>
											  <td><a href='spj.php?id=$current_no_skko'>$current_no_skko</a></td>
											  <td>Rp.$nominal2</td>
											  <td>Rp.$sisa_skki</td>
											  <td>$current_jumlah_spj</td>
											  <td>Rp.$nominal</td>
											  <td><span class='$class'>$b%</span></td>
											  <td><span class='$class1'>$c%</span></td>
											  <td><span class='$class2'>$d%</span></td></tr>";
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
                                echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=1&area=$area&tahun=$tahun'><<</a></li> ";
                                // get previous page num
                                $prevpage = $currentpage - 1;
                                // show < link to go back to 1 page
                                echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage&area=$area&tahun=$tahun'><</a></li> ";
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
                                        echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$x&area=$area&tahun=$tahun'>$x</a></li> ";
                                    } // end else
                                } // end if
                            } // end for
                                             
                            // if not on last page, show forward and last page links
                            if ($currentpage != $totalpages) {
                                // get next page
                                $nextpage = $currentpage + 1;
                                // echo forward link for next page
                                echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage&area=$area&tahun=$tahun'>></a></li> ";
                                // echo forward link for lastpage
                                echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages&area=$area&tahun=$tahun'>>></a></li> ";
                            } // end if
                            /****** end build pagination links ******/
                            echo "</ul>
							</div>
						</div>
					</section>
				</div>";
                ?>
			<p class="text-center"><a href="penyerapan_anggaran_excel.php?area=<?php echo $area;?>" class='btn btn-success center' >Export Excel</a></p>
			</div>
			
		</section>
		</div>
	</div>
                </section>
            </aside>

        </div>
		<script type="text/javascript">
	      	$('.year').datepicker({
		        minViewMode: 2,
		        format: 'yyyy',
		        autoclose:true
	       	});
	  	</script>
        <?php include("lib/footer.php");?>
	</body>
</html>