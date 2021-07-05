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
								
									<?php
									$get_spj = $_GET['no_spj'];
									/*$query_judul = "Select a.VENDOR_NAMA, A.DIREKSI_VENDOR, b.SPJ_NO, c.PAKET_DESKRIPSI2, B.SPJ_DESKRIPSI, B.SPJ_TANGGAL_MULAI, B.SPJ_TANGGAL_AKHIR, D.PEMBAYARAN_TANGGAL, E.AREA_NAMA, C.PAKET_DESKRIPSI
													from tb_vendor A JOIN tb_spj B  JOIN tb_paket C  JOIN tb_pembayaran D  JOIN tb_area E WHERE A.VENDOR_ID=B.VENDOR_ID AND C.PAKET_JENIS=B.PAKET_JENIS AND D.SPJ_NO=B.SPJ_NO
													AND E.AREA_KODE= B.AREA_KODE AND B.SPJ_NO='$get_spj'";*/
													
									$query_judul = 	"Select a.VENDOR_NAMA, A.DIREKSI_VENDOR, b.SPJ_NO, c.PAKET_DESKRIPSI2, B.SPJ_DESKRIPSI,
														B.SPJ_TANGGAL_MULAI, B.SPJ_TANGGAL_AKHIR, B.tgl_bastp, E.AREA_NAMA, C.PAKET_DESKRIPSI, B.pengawas_lap  
														from tb_vendor A JOIN tb_spj B JOIN tb_paket C JOIN tb_area E WHERE A.VENDOR_ID=B.VENDOR_ID 
														AND C.PAKET_JENIS=B.PAKET_JENIS AND E.AREA_KODE= B.AREA_KODE AND B.SPJ_NO='$get_spj'";				
													
										$resultQuery=mysqli_query($mysqli, $query_judul);
										while ($row=mysqli_fetch_row($resultQuery)){ 
											$data[] = $row;
										}
											$nama_perusahaan 	= $data[0][0];
											$nama_direktur 		= $data[0][1];
											$no_khs				= $data[0][2];
											$j_pekerjaan		= $data[0][3];
											$n_pekerjaan		= $data[0][4];
											$tgl_spbj			= $data[0][5];
											$tgl_akhr_kon		= $data[0][6];
											$tgl_bastp			= $data[0][7];
											$print_area			= $data[0][8];
											$kode_kerja			= $data[0][9];
											$pengawas_lap		= $data[0][10];
								
								?>
								<form class="form-horizontal" action="edit_evaluasi_vendor_submit.php" role="form" method="post" onsubmit="return confirm('Yakin menyimpan perubahan ini?');"/>  
								<section class="panel">
								<header class="panel-heading">Form Evaluasi Vendor KHSJ 2019</header>
								<div class="panel-body table-responsive">
								<div class="demo-html"></div>
								
								<div class = "pull-right">
									<b>KODE BIDANG KHSJ
									<br>
									<?php echo $kode_kerja?></b>
								</div>
								
								<b>PT PLN (PERSERO) UNIT INDUK WILAYAH RIAU DAN KEPRI
								<br><?php echo $print_area; ?></b>
								
								<table  class="table table-striped table-bordered" cellspacing="0" width="100%">
									<tr>
										<td>Nama Perusahaan</td>
										<td><?php echo $nama_perusahaan; ?></td>
										<td>Nama Pekerjaan</td>
										<td><?php echo $n_pekerjaan;?></td>
									</tr>
									<tr>
										<td>Nama Direktur</td>
										<td><?php echo $nama_direktur;?></td>
										<td>Tanggal Kontrak SPBJ</td>
										<td><?php echo $tgl_spbj;?></td>
									</tr>
									<tr>
										<td>No. Kontrak KHSJ</td>
										<td><?php echo $no_khs; ?></td>
										<td>Tanggal Berakhir Kontrak</td>
										<td><?php echo $tgl_akhr_kon; ?></td>
									</tr>
									<tr>
										<td>Jenis Pekerjaan</td>
										<td><?php echo $j_pekerjaan;?></td>
										<td>Tanggal BASTP</td>
										<td>
												<input type="date" class="form-control" name="tgl_bastp" id="tgl_bastp" value=<?php echo $tgl_bastp ?> required>
												<input type="hidden" class="form-control" name="tgl_spbj" id="tgl_spbj" value=<?php echo $tgl_spbj  ?>>
										</td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td>Pengawas Lapangan</td>
										<td>
												<input type="text" class="form-control" name="pengawas_lap" id="pengawas_lap" value=<?php echo "'$pengawas_lap'" ?> required>
										</td>
									</tr>
								</table>
								</div>
								</section>
								
								<section class="panel">
								<div class="panel-body table-responsive">
								<div class="demo-html"></div>
								<!--<form class="form-horizontal" action="edit_evaluasi_vendor_submit.php" role="form" method="post" onsubmit="return confirm('Yakin menyimpan perubahan ini?');"/>-->             
									
									<input type="hidden" name="no_spj" value=<?php echo $get_spj ?>>
									<table  class="table table-striped table-bordered" cellspacing="0" width="100%">
										<tr align="center">
											<td>No</td>
											<td>Deskripsi</td>
											<td>Bobot (%)</td>
											<td>Kriteria Penilaian Pengadaan Jasa</td>
											<td>Nilai</td>
											<td>Bobot</td>
											<td>Score</td>
											<!--<td rowspan="3" align="center">Total Nilai</td>-->
										</tr>
										<tr align="center">
											<td>1</td>
											<td>2</td>
											<td>3</td>
											<td>4</td>
											<td>5</td>
											<td>6</td>
											<td>7=5x6</td>
										</tr>
										<tr align="center">
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
									
									<tbody>
									<?php
										$querys = "SELECT B.deskripsi, B.bobot, A.id_kriteria, A.bobot, A.kriteria, C.nilai, A.id_deskripsi 
														from penilaian_kriteria A join penilaian_deskripsi B join penilaian_nilai C where  A.id_deskripsi=B.id_deskripsi and 
														A.id_kriteria = C.id_kriteria and C.spj_no='$get_spj'";
										$resultQuerys=mysqli_query($mysqli, $querys);
										while ($rows=mysqli_fetch_row($resultQuerys)){ 
											$datas[] = $rows;
										}
										
										
										/*$query2 = "SELECT A.deskripsi, SUM((C.nilai*C.bobot)/10) AS total_nilai FROM penilaian_deskripsi A JOIN
													penilaian_kriteria B JOIN penilaian_nilai C where a.id_deskripsi=b.id_deskripsi and b.id_kriteria=c.id_kriteria 
													and c.spj_no='$get_spj' GROUP BY A.deskripsi ORDER BY A.id_deskripsi";
										
										
										
										$resultQuery2=mysqli_query($mysqli, $query2);
										while ($row2=mysqli_fetch_row($resultQuery2)){ 
											$data2[] = $row2;
											$merge_mutu = $data2[0][0];
											$total_nilai = $data2[0][1];
										}*/
										 
										$arr = array();	
										/*for($j=0;$j<count($datas);$j++){
											
											$mutu = $datas[$j][0];
											$bobot1 = $datas[$j][1];
											$id = $datas[$j][2];
											$bobots = $datas[$j][3];
											$kriteria = $datas[$j][4];
											$nilai = $datas[$j][5];
											$score = $nilai * $bobots;
											$id_deskripsi = $datas[$j][6];
											
										/*	if($mutu==$merge_mutu){
												$print_total_nilai = "<td rowspan='4' align='center'>$total_nilai</td>";
											}
											*/
											/*$edit_action = "<a href='penilaian_kriteria_edit.php?id=$id'>Edit</a>";
											$delete_action = "<a href='penilaian_kriteria_delete.php?id=$id' onclick='return confirm(\"Hapus : ".$kriteria." ?\")'>Delete</a>";
											/*$nilais = "<input type='text' class='form-control' name='isi_nilai[$id]' id='isi_nilai[$id]' placeholder='nilai' value='$nilai' required='' size='8' onInput='cari_score(this.value,$id)'>
														<input type='hidden' name='isi_id[$id]' value='$id'>";*/
														
											/*$nilais="<input type='number'  value='$nilai' name='isi_nilai[$id]' id='isi_nilai[$id]' min='1' max='5' onchange='cari_score(this.value,$id)'  oninput='(!validity.rangeOverflow||(value=5)) && (!validity.rangeUnderflow||(value=1)) &&
													(!validity.stepMismatch||(value=parseInt(this.value)));'>
													<input type='hidden' name='isi_id[$id]' value='$id'>";			
													
											$bobot = "<input type='text' class='form-control' name='isi_bobot[$id]'  id='isi_bobot[$id]' required='' size='8' value='$bobots' disabled>
														<input type='hidden' class='form-control' name='isi_bobot[$id]'  id='isi_bobot[$id]' required='' size='8' value='$bobots'>";
											$scores = "<input type='text' class='form-control' name='isi_score[$id]'  id='isi_score[$id]' placeholder='score' required='' size='8' value='$score' disabled>
														<input type='hidden' name='isi_id_deskripsi[$id]' value='$id_deskripsi'>";
											
											$no = $j+$offset+1;
											echo "<tr><td>$no</td>
													<td>$mutu</td>
													<td>$bobot1%</td>
													<td>$kriteria</td>
													<td>$nilais</td>
													<td>$bobot</td>
													<td>$scores</td>
													</tr>
													";
											}*/
											for($j=0;$j<count($datas);$j++){
											$ar_line = array();
											$arr[$datas[$j][0]]['bobot'] = $datas[$j][1];
											$arr[$datas[$j][0]]['count'] ++;
											if($arr[$datas[$j][0]]['count']==1){
												$arr[$datas[$j][0]]['item'] = array();
											}
											$ar_line['id'] = $datas[$j][2];
											$ar_line['bobots'] = $datas[$j][3];
											$ar_line['kriteria'] = $datas[$j][4];
											$ar_line['nilai'] = $datas[$j][5];
											$ar_line['id_deskripsi'] = $datas[$j][6];
											
											array_push($arr[$datas[$j][0]]['item'],$ar_line);
										}
										// echo "<pre>";print_r($arr);echo "</pre>";exit();
										$nom = 1;
										foreach ($arr as $key => $value) {
											$mutu = $key;
											$bobot1 = $value['bobot'];
											echo "<tr><td rowspan=".++$value['count'].">".$nom++."</td>";
											echo "<td rowspan=".$value['count'].">".$mutu."</td>";
											echo "<td rowspan=".$value['count'].">".$bobot1."%</td>";
											echo "<td></td>";
											foreach ($value['item'] as $it) {
												$id = $it['id'];
												$bobots = $it['bobots'];
												$kriteria = $it['kriteria'];
												$nilai = $it['nilai'];
												$id_deskripsi = $it['id_deskripsi'];
												$score = $nilai * $bobots;
												/*$nilai = "<input type='text' class='form-control' name='isi_nilai[$id]' id='isi_nilai[$id]' placeholder='nilai' required='' size='8' onInput='cari_score(this.value,$id)'>
															<input type='hidden' name='isi_id[$id]' value='$id'>";*/
															
												$nilais="<input type='number'  value='$nilai' name='isi_nilai[$id]' id='isi_nilai[$id]' min='1' max='5' onchange='cari_score(this.value,$id)'  oninput='(!validity.rangeOverflow||(value=5)) && (!validity.rangeUnderflow||(value=1)) &&
														(!validity.stepMismatch||(value=parseInt(this.value)));'>
														<input type='hidden' name='isi_id[$id]' value='$id'>
														";			
															
												$bobot = "<input type='text' class='form-control' name='isi_bobot[$id]'  id='isi_bobot[$id]' required='' size='8' value='$bobots' disabled>
															<input type='hidden' class='form-control' name='isi_bobot[$id]'  id='isi_bobot[$id]' required='' size='8' value='$bobots'>";
												$scores = "<input type='text' class='form-control' name='isi_score[$id]'  id='isi_score[$id]' placeholder='score' required='' size='8' value='$score' disabled>
															<input type='hidden' name='isi_id_deskripsi[$id]' value='$id_deskripsi'>";
												
												$no = $j+$offset+1;
												echo "<tr>
														<td>$kriteria</td>
														<td>$nilais</td>
														<td>$bobot</td>
														<td>$scores</td>
														</tr>
														";
												}
											}
											
											
									?>
										<tr align="center">
											<td></td>
											<td></td>
											<td></td>
										</tr>
									</tbody>
								</table>
								<br/>
								<table  class="table table-striped table-bordered" cellspacing="0" width="100%">
										<tr align="center">
											<td>No</td>
											<td>Deskripsi</td>
											<td>Total Nilai</td>
											<!--<td rowspan="3" align="center">Total Nilai</td>-->
										</tr>
									
									<tbody>
									<?php
										$query_kel = "SELECT A.deskripsi, SUM((C.nilai*C.bobot)/10) AS total_nilai FROM penilaian_deskripsi A JOIN
													penilaian_kriteria B JOIN penilaian_nilai C where a.id_deskripsi=b.id_deskripsi and b.id_kriteria=c.id_kriteria 
													and c.spj_no='$get_spj' GROUP BY A.deskripsi ORDER BY A.id_deskripsi";
										$resultQueryl=mysqli_query($mysqli, $query_kel);
										while ($rowl=mysqli_fetch_row($resultQueryl)){ 
											$datal[] = $rowl;
											
										}
										
										$total_inisiasi = 0;
										for($j=0;$j<count($datal);$j++){
											
											$tamp_total = $datal[$j][1];
											$total_inisiasi +=$tamp_total;
											
											$keterangan_akhir = "";
												if($total_inisiasi >0 && $total_inisiasi <2.1){
													$keterangan_akhir = "Sangat Kurang";
												}elseif($total_inisiasi>=2.1 && $total_inisiasi <4.1){
													$keterangan_akhir = "Kurang";
												}elseif($total_inisiasi>=4.1 && $total_inisiasi <6.1){
													$keterangan_akhir = "Cukup";
												}elseif ($total_inisiasi>=6.1 && $total_inisiasi <8.1){
													$keterangan_akhir="Baik";
												}elseif ($total_inisiasi>=8.1 && $total_inisiasi<=10){
													$keterangan_akhir="Baik Sekali";
												}
											
											
											$desk = $datal[$j][0];
											$total_nilail = $datal[$j][1];
											$total_nilai1_print = number_format($total_nilail, 1, '.', '');
											
											$edit_action = "<a href='penilaian_kriteria_edit.php?id=$id'>Edit</a>";
											$delete_action = "<a href='penilaian_kriteria_delete.php?id=$id' onclick='return confirm(\"Hapus : ".$kriteria." ?\")'>Delete</a>";
											
											$no = $j+$offset+1;
											echo "<tr><td>$no</td>
													<td>$desk</td>
													<td>$total_nilai1_print</td>
													";
											}
									?>
									</tr>
									<tr>
										<td><font size="3"><b>Total Score Penilaian Vendor</b></font></td>
										<td></td>
										<td><b><font size="4"><?php echo $total_inisiasi. " ($keterangan_akhir)"; ?></font></b></td>
									</tr>
									
										<tr align="center">
											<td></td>
											<td></td>
											<td></td>
										</tr>
									</tbody>
								</table>
								<br/>
								<div class="row">
								<div class="col-md-4">
								<table  class="table table-striped table-bordered" cellspacing="0" width="20">
										<tr align="center">
											<td>Nilai</td>
											<td>Range Score</td>
											<td>Keterangan</td>
										</tr>
										<tr align="center">
											<td></td>
											<td></td>
											<td></td>
										</tr>
									
									<tbody>
										<tr align="center">
											<td>8</td>
											<td>>8.1-10</td>
											<td>Baik Sekali</td>
										</tr>
										<tr align="center">
											<td>6</td>
											<td>>6.1-8.1</td>
											<td>Baik</td>
										</tr>
										<tr align="center">
											<td>4</td>
											<td>>4.1-6.1</td>
											<td>Cukup</td>
										</tr>
										<tr align="center">
											<td>2</td>
											<td>>2.1-4.1</td>
											<td>Kurang</td>
										</tr>
										<tr align="center">
											<td>1</td>
											<td>0-2.1</td>
											<td>Sangat Kurang</td>
										</tr>
									</tbody>
								</table>
								</div>
								</div>
								
								
									<div class="form-group">
										<label class="col-sm-4"></label>
											<div class="col-sm-4">
												<!--<a class="btn  btn-info"   data-toggle="tooltip" title="Tolak" href="?module=pengambilan_obat&aksi=tolak_tagihan&id_cek_tagihan=<?php echo $id_cek_tagihan;?>"><i class="glyphicon glyphicon-remove"></i> Tolak</a>-->
												<!--<a class="btn  btn-success"   data-toggle="tooltip" title="Simpan " href="<?php echo $aksi ?>?module=pengambilan_obat&aksi=approve_tagihan&id_cek_tagihan=<?php echo $id_cek_tagihan?>" onclick="return confirm('Anda Yakin Akan Approve Tagihan No: <?php echo $edit11['no_tagihan']; ?>?')"><i class="glyphicon glyphicon-ok"></i> Terima</a>-->
												<!--<a href="javascript:history.back()" class="btn btn-info pull-right"><i class="fa fa-backward"></i> Kembali</a>-->
												<?php
												$queryku = "SELECT verifikasi_mb, verifikasi_mup3 from tb_termin where spj_no='$get_spj'";
													$resultQueryku=mysqli_query($mysqli, $queryku);
													while ($rowku=mysqli_fetch_row($resultQueryku)){ 
														$dataku[] = $rowku;
													}
													$verifikasi_mb	= $dataku[0][0];
													$verifikasi_mup3	= $dataku[0][1];
													
													
													if(($verifikasi_mb==0) or($verifikasi_mb==2) or ($verifikasi_mup3==2)){
												?>
												<button type="submit"name="submit" class="btn btn-success"><i class="glyphicon glyphicon-floppy-disk"></i> Update</button>
													<?php }else{
														echo "<a href='download_rekap_perspj.php?&no_spj=$get_spj' class='btn btn-success'>
																<i class='glyphicon glyphicon-download'></i> Download</a>";
													} ?>
												<a href="javascript:history.back()" class="btn btn-info pull-right"><i class="fa fa-backward"></i> Kembali</a>
												
											</div>
									</div> 
								</form>	
								</div>
								
								</div>								
							</section>
								
								</div>
            </aside><!-- /.right-side -->
	<?php include("lib/footer.php");?>
	</body>
</html>
<script type="text/javascript">
function cari_score(value,id) {
	var isi_nilai = document.getElementById("isi_nilai["+id+"]").value;
	var isi_bobot = document.getElementById("isi_bobot["+id+"]").value;
	var score = isi_nilai * isi_bobot;
	document.getElementById("isi_score["+id+"]").value=score;
	
}
</script>
