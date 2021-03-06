<?php session_start();
      include_once('lib/head.php');
      include_once("lib/check.php");
      $print_area = $_SESSION['area'];
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
		<!--include file header-->
		<?php
            include("lib/header.php");
            $kode_area = $_SESSION['area'];
        ?>
		<div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
			<?php include("lib/menu.php");?>
                    
            <aside class="right-side">
								<div class="panel-body table-responsive">
								<?php
                                    $count = "select count(spj_no) from tb_pembayaran";
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
								<section class="panel">
								<header class="panel-heading">Evaluasi Vendor</header>
								<div class="panel-body table-responsive">
								<div class="demo-html"></div>
								<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
									<thead>
										<tr align="center">
											<th>#</th>
											<th>No SPJ</th>
											<th>Status Evaluasi</th>
											<th>Verifikasi Evaluasi MB</th>
											<th>Verifikasi Evaluasi MUP3</th>
										</tr>
									</thead>
									
									<tbody>
									<?php
                                        /*$querys = "SELECT A.SPJ_NO, B.id_kriteria From tb_pembayaran A LEFT JOIN penilaian_nilai B
                                                    on A.SPJ_NO=B.spj_no GROUP BY A.SPJ_NO";*/
                                                    
                                        /*$querys = "SELECT A.SPJ_NO, B.evaluasi, B.verifikasi_evaluasi, B.catatan_verifikasi From tb_pembayaran A LEFT JOIN
                                                    tb_termin B on A.SPJ_NO=B.spj_no LEFT JOIN tb_spj C on A.SPJ_NO=C.SPJ_NO
                                                    WHERE B.keterangan='bayar 100' AND C.AREA_KODE=$print_area GROUP BY A.SPJ_NO";*/
                                                    
                                        $querys = "SELECT A.SPJ_NO, B.evaluasi, B.verifikasi_mb, B.catatan_verifikasi_mb , B.verifikasi_mup3, catatan_verifikasi_mup3
														From tb_spj A LEFT JOIN tb_termin B on A.SPJ_NO=B.spj_no
																WHERE A.AREA_KODE=$print_area GROUP BY A.SPJ_NO";
                                        //echo $querys;
                                                    
                                        $resultQuerys=mysqli_query($mysqli, $querys);
                                        while ($rows=mysqli_fetch_row($resultQuerys)) {
                                            $datas[] = $rows;
                                        }
                                        
                                        for ($j=0;$j<count($datas);$j++) {
                                            $spj_no = $datas[$j][0];
                                            $evaluasi = $datas[$j][1];
                                            $verifikasi_evaluasi = $datas[$j][2];
                                            $detail_verifikasi = $datas[$j][3];
                                            
                                            $verifikasi_evaluasi_mup3 = $datas[$j][4];
                                            $catatan_verifikasi_mup3 = $datas[$j][4];
                                            $detail_verifikasi_mup3 = $datas[$j][5];
                                            
                                            if ($evaluasi==0) {
                                                $id_kriteria = "<a href='isi_evaluasi_vendor.php?&no_spj=$spj_no'>belum diisi</a>";
                                            } else {
                                                $id_kriteria = "<a href='lihat_evaluasi_vendor.php?&no_spj=$spj_no'>sudah diisi</a>";
                                            }
                                            
                                            if ($verifikasi_evaluasi==0) {
                                                $verifikasi_evaluasi = "<span class='badge badge-info'>belum diverifikasi</span>";
                                            } elseif ($verifikasi_evaluasi==1) {
                                                $verifikasi_evaluasi = "<span class='badge badge-success'>diterima</span>";
                                            } elseif ($verifikasi_evaluasi==2) {
                                                $verifikasi_evaluasi = "<span class='badge badge-danger'>ditolak, karena $detail_verifikasi</span>";
                                            }
                                            
                                            
                                            if ($catatan_verifikasi_mup3==1) {
                                                $catatan_verifikasi_mup3="<span class='badge badge-success'>diterima</span>";
                                            } elseif ($catatan_verifikasi_mup3==2) {
                                                $catatan_verifikasi_mup3="<span class='badge badge-danger'>ditolak, karena $detail_verifikasi_mup3</span>";
                                            } elseif ($catatan_verifikasi_mup3==0) {
                                                $catatan_verifikasi_mup3="<span class='badge badge-info'>belum diverifikasi</span>";
                                            }
                                            
                                            $no = $j+$offset+1;
                                            echo "<tr><td>$no</td>
													<td>$spj_no</td>
													<td>$id_kriteria</td>
													<td>$verifikasi_evaluasi</td>
													<td>$catatan_verifikasi_mup3</td>
												   </tr>";
                                        }
                                    ?>
									</tbody>
								</table>
								</div>
								</div>								
							</section>
						</div>
            </aside><!-- /.right-side -->
	<?php include("lib/footer.php");?>
	</body>
</html>