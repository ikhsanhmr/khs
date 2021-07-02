<?php session_start();
	  include_once('lib/head.php');
	  include_once("lib/check.php");?>

								
									<?php
									$get_spj = $_GET['no_spj'];
									$print_areas = $_SESSION['area'];
									/*$query_judul = "Select a.VENDOR_NAMA, A.DIREKSI_VENDOR, b.SPJ_NO, c.PAKET_DESKRIPSI2, B.SPJ_DESKRIPSI, B.SPJ_TANGGAL_MULAI, B.SPJ_TANGGAL_AKHIR, D.PEMBAYARAN_TANGGAL, E.AREA_NAMA, C.PAKET_DESKRIPSI
													from tb_vendor A JOIN tb_spj B  JOIN tb_paket C  JOIN tb_pembayaran D  JOIN tb_area E WHERE A.VENDOR_ID=B.VENDOR_ID AND C.PAKET_JENIS=B.PAKET_JENIS AND D.SPJ_NO=B.SPJ_NO
													AND E.AREA_KODE= B.AREA_KODE AND B.SPJ_NO='$get_spj'";*/
													
									$query_judul = 	"Select a.VENDOR_NAMA, A.DIREKSI_VENDOR, b.SPJ_NO, c.PAKET_DESKRIPSI2, B.SPJ_DESKRIPSI,
														B.SPJ_TANGGAL_MULAI, B.SPJ_TANGGAL_AKHIR, B.tgl_bastp, E.AREA_NAMA, C.PAKET_DESKRIPSI 
														from tb_vendor A JOIN tb_spj B JOIN tb_paket C JOIN tb_area E WHERE A.VENDOR_ID=B.VENDOR_ID 
														AND C.PAKET_JENIS=B.PAKET_JENIS AND E.AREA_KODE= B.AREA_KODE AND B.SPJ_NO='$get_spj'";				
													
										$resultQuery=mysqli_query($query_judul);
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
								
								$strhtml.=" <div class='judul_form'>
												Form Evaluasi Vendor KHSJ 2019
												<br>
												PT PLN (PERSERO) UNIT INDUK WILAYAH RIAU DAN KEPRI
												<br>
												$print_area
												</div>";
								$strhtml.="<div class ='tempat_kode'>
											KODE BIDANG KHSJ
											<br>
											$kode_kerja
											</div>
											";
								
								$strhtml.="<table border=1px width='100%' class='konten_juduls'>
											<tr>
												<td>Nama Perusahaan</td>
												<td>$nama_perusahaan</td>
												<td>Nama Pekerjaan</td>
												<td>$n_pekerjaan</td>
											</tr>
											<tr>
												<td>Nama Direktur</td>
												<td>$nama_direktur</td>
												<td>Tanggal Kontrak SPBJ</td>
												<td>$tgl_spbj</td>
											</tr>
											<tr>
												<td>No. Kontrak KHSJ</td>
												<td>$no_khs</td>
												<td>Tanggal Berakhir Kontrak</td>
												<td>$tgl_akhr_kon</td>
											</tr>
											<tr>
												<td>Jenis Pekerjaan</td>
												<td>$j_pekerjaan</td>
												<td>Tanggal BASTP</td>
												<td>$tgl_bastp</td>
											</tr>
										</table>";
								
									$strhtml.= "<table  border=1px width='100%' class='konten_judul'>
												<tr align='center'>
													<td>No</td>
													<td>Deskripsi</td>
													<td>Bobot (%)</td>
													<td>Kriteria Penilaian Pengadaan Jasa</td>
													<td>Nilai</td>
													<td>Bobot</td>
													<td>Score</td>
												</tr>
												<tr align='center'>
													<td>1</td>
													<td>2</td>
													<td>3</td>
													<td>4</td>
													<td>5</td>
													<td>6</td>
													<td>7=5x6</td>
												</tr>
									
												<tbody>";
									
										$querys = "SELECT B.deskripsi, B.bobot, A.id_kriteria, A.bobot, A.kriteria, C.nilai, A.id_deskripsi 
														from penilaian_kriteria A join penilaian_deskripsi B join penilaian_nilai C where  A.id_deskripsi=B.id_deskripsi and 
														A.id_kriteria = C.id_kriteria and C.spj_no='$get_spj'";
										$resultQuerys=mysqli_query($querys);
										while ($rows=mysqli_fetch_row($resultQuerys)){ 
											$datas[] = $rows;
										}
										
										$arr = array();	
										
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
										
										$nom = 1;
										foreach ($arr as $key => $value) {
											$mutu = $key;
											$bobot1 = $value['bobot'];
											$strhtml.="<tr><td rowspan=".++$value['count'].">".$nom++."</td>";
											$strhtml.= "<td rowspan=".$value['count'].">".$mutu."</td>";
											$strhtml.= "<td rowspan=".$value['count'].">".$bobot1."%</td>";
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
												$strhtml.= "<tr>
														<td>$kriteria</td>
														<td>$nilais</td>
														<td>$bobot</td>
														<td>$scores</td>
														</tr>
														";
												}
											}
												
							
										$strhtml.="	</tbody>
													</table>";
														
										$strhtml.= "<div class='rekap_nilai'></div>
										<br>
													<div  class='tulis_rekap'>Rekap Nilai</div>
													<table class='konten_nilai' border='1px' width='100%'>
														<tr align='center'>
															<td>No</td>
															<td>Deskripsi</td>
															<td>Total Nilai</td>
														</tr>
													<tbody>";
									
										$query_kel = "SELECT A.deskripsi, SUM((C.nilai*C.bobot)/10) AS total_nilai FROM penilaian_deskripsi A JOIN
													penilaian_kriteria B JOIN penilaian_nilai C where a.id_deskripsi=b.id_deskripsi and b.id_kriteria=c.id_kriteria 
													and c.spj_no='$get_spj' GROUP BY A.deskripsi ORDER BY A.id_deskripsi";
										$resultQueryl=mysqli_query($query_kel);
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
											$strhtml.= "<tr><td>$no</td>
													<td>$desk</td>
													<td>$total_nilai1_print</td>
													";
											}
									
										$strhtml.="</tr>
													<tr>
													<td><font size='3'><b>Total Score Penilaian Vendor</b></font></td>
													<td></td>
													<td><b><font size='4'>$total_inisiasi. $keterangan_akhir</font></b></td>
													</tr>
												</tbody>
											</table>
											<br/>";
								$strhtml.="<div class='row'>
										   <div class='col-md-4'>
											<table class='keterangan_range' border=1px width='20'>
										
											<tr align='center'>
												<td>Nilai</td>
												<td>Range Score</td>
												<td>Keterangan</td>
											</tr>
											<tr align='center'>
												<td></td>
												<td></td>
												<td></td>
											</tr>
									<tbody>
										<tr align='center'>
											<td>8</td>
											<td>>8.1-10</td>
											<td>Baik Sekali</td>
										</tr>
										<tr align='center'>
											<td>6</td>
											<td>>6.1-8.1</td>
											<td>Baik</td>
										</tr>
										<tr align='center'>
											<td>4</td>
											<td>>4.1-6.1</td>
											<td>Cukup</td>
										</tr>
										<tr align='center'>
											<td>2</td>
											<td>>2.1-4.1</td>
											<td>Kurang</td>
										</tr>
										<tr align='center'>
											<td>1</td>
											<td>0-2.1</td>
											<td>Sangat Kurang</td>
										</tr>
									</tbody>
								</table>
								</div>
								</div>";
								
				function format_indo($date)
						{
							$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

							$tahun = substr($date, 0, 4);
							$bulan = substr($date, 5, 2);                 
							$tgl   = substr($date, 8, 2);

							$result = $tgl . " " . $BulanIndo[(int)$bulan-1]. " ". $tahun;
							return($result);
						}

							$today_f    = date('Y-m-d');
							$today      = format_indo($today_f);
					
					$kota_area=$print_areas;
					if($kota_area==181){
						$kota_area="Pekanbaru";
					}elseif($kota_area==182){
						$kota_area="Dumai";
					}elseif($kota_area==183){
						$kota_area="Tanjungpinang";
					}elseif($kota_area==184){
						$kota_area="Rengat";
					}elseif($kota_area==185){
						$kota_area="Pekanbaru";
					}elseif($kota_area==186){
						$kota_area="Tanjungpinang";
					}elseif($kota_area==187){
						$kota_area="Pekanbaru";
					}elseif($kota_area==188){
						$kota_area="Tanjungpinang";
					}
					
					$query_judul = "SELECT AREA_NAMA FROM `tb_area` WHERE AREA_KODE=$print_area";
					$show_judul = mysqli_query($query_judul);
					while ($rowjudul = mysqli_fetch_row($show_judul)) {
						$nama_area = $rowjudul[0];
					}
					
					$query_direksi = "SELECT DIREKSI_PEKERJAAN, DIREKSI_LAPANGAN, pengawas_lap FROM tb_spj WHERE spj_no='$get_spj'";
					$show_direksi= mysqli_query($query_direksi);
					while ($row_direksi = mysqli_fetch_row($show_direksi)) {
						$nama_dirp = $row_direksi[0];
						$nama_dirl = $row_direksi[1];
						$pengawas_lap = $row_direksi[2];
					}
					
					$query_manager = "SELECT NAMA_MANAGER FROM tb_spj WHERE AREA_KODE=$print_areas GROUP BY NAMA_MANAGER LIMIT 1";
					$show_manager = mysqli_query($query_manager);
					while ($rowmanager = mysqli_fetch_row($show_manager)) {
						$nama_manager = $rowmanager[0];
					}
					
					$strhtml.="<br/>";
					$strhtml.= "<div class='print_tanggal_bulan'>$kota_area, $today";
					$strhtml.="</div>";
					
					
					
					$strhtml.= "<div class='posisi_dirp'>
								Disetujui oleh,
								<br>
								Direksi Pekerjaan
								<br>
								<br>
								<br>
								$nama_dirp
								</div>";

					$strhtml.= "<div class='posisi_dirl'>
							
								Direksi Lapangan
								<br>
								<br>
								<br>
								$nama_dirl
								</div>";

					$strhtml.= "<div class='dinilai_oleh'>
								Dinilai oleh,
								</div>";

					$strhtml.= "<div class='pengawas_lap'>
								Pengawas Lapangan
								<br>
								<br>
								<br>
								$pengawas_lap
								</div>";	
								
			require ("lib/mpdf/mpdf.php");

			$stylesheet = file_get_contents('css/table/style.css');
			$fileName = 'reportPdf-perSPBJ-'.$nama_perusahaan . date('d-m-Y') . '-' . date('h.i.s');

			$mpdf = new mPDF('utf-8', 'A4', 0, '', 10, 10, 5, 1, 1, 1, '');
			//$mpdf->SetDisplayMode('fullpage');
			$mpdf->WriteHTML($stylesheet,1);
			$mpdf->WriteHTML($strhtml);
			ob_clean();
			$mpdf->Output('files/' . $fileName. '.pdf','D');

?>								
								
								