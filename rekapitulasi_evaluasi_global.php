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
		<!--include file header-->
		<?php
            include("lib/header.php");
            $kode_area = $_SESSION['area'];
        ?>
		<div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
			<?php include("lib/menu.php");?>
                    
            <aside class="right-side">
			<section class="content">
					
				<div class="row">
					<div class="col-md-12">
						<section class="panel">
							<header class="panel-heading">Download  Rekapitulasi Global</header>
							<div class="panel-body">
								<form role="form" method="post" action="download_rekap_all_global.php">
										<div class="col-sm-2">
											<select class="form-control m-b-10" name="pilih_paket" id="pilih_paket" required>
												<option value="">- Pilih Paket-</option>
													<?php
                                                        //$data=select_spj_no($kode_area); di edit setelah -10 + 30
                                                        $data=select_paket_jenis($mysqli);
                                                        for ($i=0;$i<count($data);$i++) {
                                                            $paket = $data[$i][0];
                                                            $paket_ket = $data[$i][1]; ?>
												<option value='<?php echo $paket; ?>'><?php echo $paket_ket; ?></option>
													<?php
                                                        }
                                                    ?>
												</select>
													<!--<span class='badge badge-success'><i class='glyphicon glyphicon-download'></i>Download</span></a></header>-->
													<button type="submit" class="btn btn-success"><i class='glyphicon glyphicon-download'></i>Download</button>
								</form>
							</div>
						</section>
					</div>
				</div>
								
								<div class="row">
								<div class="col-md-12">
									<section class="panel">	
								<div class="panel-body table-responsive">
								<?php
                                    $count = "select count(vendor_id) from tb_vendor";
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
								<header class="panel-heading">Rekapitulasi Evaluasi Vendor 
								<div class="panel-body table-responsive">
								<div class="demo-html"></div>
								<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
									<thead>
										<tr align="center">
											<th>#</th>
											<th>Vendor</th>
											<th>Rekapitulasi per No SPBJ</th>
										</tr>
									</thead>
									<tbody>
									<?php
                                        /*$querys = "SELECT A.SPJ_NO, B.id_kriteria From tb_pembayaran A LEFT JOIN penilaian_nilai B
                                                    on A.SPJ_NO=B.spj_no GROUP BY A.SPJ_NO";*/
                                                    
                                        $querys = "SELECT vendor_id, vendor_nama from tb_vendor";
                                                    
                                        $resultQuerys=mysqli_query($mysqli, $querys);
                                        while ($rows=mysqli_fetch_row($resultQuerys)) {
                                            $datas[] = $rows;
                                        }
                                        
                                        for ($j=0;$j<count($datas);$j++) {
                                            $vendor_id = $datas[$j][0];
                                            $vendor_nama = $datas[$j][1];
                                            
                                            $no = $j+$offset+1;
                                            $download_rekap = "<a href='download_rekap_global.php?&vendor_id=$vendor_id'>
																<span class='badge badge-info'><i class='glyphicon glyphicon-download'></i> download</span></a>";
                                            echo "<tr><td>$no</td>
													<td>$vendor_nama</td>
													<td>$download_rekap</td>
												   </tr>";
                                        }
                                    ?>
									</tbody>
								</table>
								</div>
								</div>
</section>
					</div>
				</div>								
							</section>
						</div>
            </aside><!-- /.right-side -->
			</section>
	<?php include("lib/footer.php");?>
	</body>
</html>