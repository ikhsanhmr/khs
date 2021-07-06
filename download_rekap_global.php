<?php
		session_start();
		include_once("lib/config.php");
		include_once('lib/head.php');
		include_once("lib/check.php");
		
		// define('DB_SERVER', 'localhost');
		// define('DB_USERNAME', 'root');
		// define('DB_PASSWORD', 'pln123');
		// define('DB_DATABASE', 'khs_production_2019');
		/ = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
		
		$print_area = $_SESSION['area'];
		
		$vendor_id = $_GET['vendor_id'];

		$query = "SELECT vendor_nama from tb_vendor where vendor_id=$vendor_id";
		$show_data = mysqli_query($mysqli, $query);
		while ($row = mysqli_fetch_row($show_data)) {
			$nama_vendor = $row[0];
		}

		$query_judul = "SELECT AREA_NAMA FROM `tb_area` WHERE AREA_KODE=$print_area";
		$show_judul = mysqli_query($mysqli, $query_judul);
		while ($rowjudul = mysqli_fetch_row($show_judul)) {
			$nama_area = $rowjudul[0];
		}
		
		$query_manager = "SELECT NAMA_MANAGER FROM tb_spj WHERE AREA_KODE=$print_area GROUP BY NAMA_MANAGER LIMIT 1";
		$show_manager = mysqli_query($mysqli, $query_manager);
		while ($rowmanager = mysqli_fetch_row($show_manager)) {
			$nama_manager = $rowmanager[0];
		}

							$strhtml.="<table border=0px;>
											<tr>
												<td class='bah'>PT PLN (PERSERO) UNIT INDUK</td>
											</tr>
											<tr>
												<td class='bah'>WILAYAH RIAU DAN KEPULAUAN RIAU</td>
											</tr>
										</table>";
							$strhtml.="<hr>";
							$strhtml.="<div class='kasidia'>";	
							$strhtml.= "REKAPITULASI PENILAIAN VENDOR KHSJ 2019";
							$strhtml.= "<br/>";
							$strhtml.= "PEKERJAAN SR-APP / JTR-GARDU / JTM T.BETON / JTM T.BESI / SKTM-GH";
							$strhtml.= "<br/>";
							$strhtml.= "PT PLN (PERSERO) UNIT INDUK WILAYAH RIAU DAN KEPRI";
							$strhtml.= "<br/>";
							$strhtml.= "$nama_vendor";
							$strhtml.="</div>";
							$strhtml.= "<br/>";
							$strhtml.= "<table class='hei'>
									<thead><tr><th>Nomor</th><th>Nomor SPBJ</th><th>Paket Jenis</th><th>Nama UP</th><th>MUTU</th><th>SDM DAN KEUANGAN</th><th>LINGKUNGAN,K3&APD</th>
												<th>ADMINISTRASI</th><th>KOMUNIKASI DAN RESPONSIVENESS</th><th>JUMLAH</th>
												<th>KETERANGAN</th></tr></thead><tbody>";
									
							/*$query = mysqli_query($mysqli, "
										SELECT B.spj_no, SUM(case when B.id_deskripsi = 1 then ((b.nilai*b.bobot)/10) end)MUTU, 
										SUM(case when B.id_deskripsi = 2 then ((b.nilai*b.bobot)/10) end)SDM,
										SUM(case when B.id_deskripsi = 5 then ((b.nilai*b.bobot)/10) end)Lingkungan,
										SUM(case when B.id_deskripsi = 6 then ((b.nilai*b.bobot)/10) end)Administrasi, 
										SUM(case when B.id_deskripsi = 7 then ((b.nilai*b.bobot)/10) end)Komunikasi 
										FROM penilaian_nilai B join tb_spj C where b.spj_no=C.SPJ_NO and C.VENDOR_ID=$vendor_id
										and C.AREA_KODE=$print_area GROUP BY B.spj_no
							");	*/
							
							$query = mysqli_query($mysqli, "
										SELECT B.spj_no, SUM(case when B.id_deskripsi = 1 then ((b.nilai*b.bobot)/10) end)MUTU, 
										SUM(case when B.id_deskripsi = 2 then ((b.nilai*b.bobot)/10) end)SDM,
										SUM(case when B.id_deskripsi = 5 then ((b.nilai*b.bobot)/10) end)Lingkungan,
										SUM(case when B.id_deskripsi = 6 then ((b.nilai*b.bobot)/10) end)Administrasi, 
										SUM(case when B.id_deskripsi = 7 then ((b.nilai*b.bobot)/10) end)Komunikasi,
										c.PAKET_JENIS,E.AREA_NAMA FROM penilaian_nilai B join tb_spj C JOIN tb_termin D JOIN tb_area E where b.spj_no=C.SPJ_NO 
										and C.SPJ_NO=D.spj_no and C.AREA_KODE=E.AREA_KODE and C.VENDOR_ID=$vendor_id  
										AND D.verifikasi_mup3=1 GROUP BY B.spj_no ORDER by c.PAKET_JENIS		
							");
							
							$row_count = mysqli_num_rows($query);
							
							$nomor=1;
							$total_inisiasi = 0;
							while ($row_query= mysqli_fetch_row($query)) {
								$no_spbj = $row_query[0];
								$mutu = $row_query[1];
								$sdm = $row_query[2];
								$lingkungan = $row_query[3];
								$adm = $row_query[4];
								$komunikasi = $row_query[5];
								$paket_jenis = $row_query[6];
								$tampilkan_area = $row_query[7];
								$mutup = number_format($mutu, 2, '.', '');
								$sdmp = number_format($sdm, 2, '.', '');
								$lingkunganp = number_format($lingkungan, 2, '.', '');
								$admp = number_format($adm, 2, '.', '');
								$komunikasip = number_format($komunikasi, 2, '.', '');
								
								$totalp= $mutup+$sdmp+$lingkunganp+$admp+$komunikasip;
								$total_inisiasi +=$totalp;
								
								
								$keterangan = "";
								if($totalp >0 && $totalp <2.1){
									$keterangan = "Blacklist";
								}elseif($totalp>=2.1 && $totalp <4.1){
									$keterangan = "Pemutusan Kontrak";
								}elseif($totalp>=4.1 && $totalp <6.1){
									$keterangan = "Perlu Pembinaan";
								}elseif ($totalp>=6.1 && $totalp <8.1){
									$keterangan="Ditingkatkan";
								}elseif ($totalp>=8.1 && $totalp<=10){
									$keterangan="Dipertahankan";
								}
								
							$strhtml.= "<tr>
								  <td>$nomor</td>		
								  <td>$no_spbj</td>		
								  <td>$paket_jenis</td>		
								  <td>$tampilkan_area</td>		
								  <td>$mutup</td>		
								  <td>$sdmp</td>		
								  <td>$lingkunganp</td>	
								  <td>$admp</td>
								  <td>$komunikasip</td>
								  <td>$totalp</td>
								  <td>$keterangan</td>
								  ";
							$strhtml.="</tr>";
							$nomor++;
							}
							$total_inisiasi_akhir = $total_inisiasi/$row_count;
							$total_inisiasi_akhirs = number_format($total_inisiasi_akhir, 2, '.', '');
							
							$keterangan_akhir = "";
								if($total_inisiasi_akhir >0 && $total_inisiasi_akhir <2.1){
									$keterangan_akhir = "Blacklist";
								}elseif($total_inisiasi_akhir>=2.1 && $total_inisiasi_akhir <4.1){
									$keterangan_akhir = "Pemutusan Kontrak";
								}elseif($total_inisiasi_akhir>=4.1 && $total_inisiasi_akhir <6.1){
									$keterangan_akhir = "Perlu Pembinaan";
								}elseif ($total_inisiasi_akhir>=6.1 && $total_inisiasi_akhir <8.1){
									$keterangan_akhir="Ditingkatkan";
								}elseif ($total_inisiasi_akhir>=8.1 && $total_inisiasi_akhir<=10){
									$keterangan_akhir="Dipertahankan";
								}
								
							
							$nomor++;							
							$strhtml.= "<tr>
									<td colspan='9' align='right'><b>Rata-rata</b></td>
									<td><b>$total_inisiasi_akhirs</b></td>
									<td><b>$keterangan_akhir</b></td>
									";
					$strhtml.="</tr>";
					$strhtml.="</table>";
					$strhtml.="<br/>";
					
					$strhtml.="<div class='judul_status'>Status Penilaian Vendor</div>";
					$strhtml.= "<table  class='heimamen'>
										<tr align='center'>
											<td>No</td>
											<td>Range Score</td>
											<td>Keterangan</td>
										</tr>
									<tbody>
										<tr align='center'>
											<td>1</td>
											<td>>8.1-10</td>
											<td>Dipertahankan</td>
										</tr>
										<tr align='center'>
											<td>2</td>
											<td>>6.1-8.1</td>
											<td>Ditingkatkan</td>
										</tr>
										<tr align='center'>
											<td>3</td>
											<td>>4.1-6.1</td>
											<td>Perlu Pembinaan</td>
										</tr>
										<tr align='center'>
											<td>4</td>
											<td>>2.1-4.1</td>
											<td>Pemutusan Kontrak</td>
										</tr>
										<tr align='center'>
											<td>5</td>
											<td>0-2.1</td>
											<td>Blacklist</td>
										</tr>
									</tbody>
								</table>";
				
					//date_default_timezone_set('Asia/Jakarta');
					//$print_date= date('d-m-Y');
					
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
					
					$kota_area=$print_area;
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
					}elseif($kota_area==18){
						$kota_area="Pekanbaru";
					}
					
					$strhtml.="<br/>";
					$strhtml.= "<div class='print_manager'>Pekanbaru, $today";
					$strhtml.="<br/>";
					
					/*$strhtml.="MANAJER $nama_area";
					$strhtml.="<br/>";
					$strhtml.="<br/>";
					$strhtml.="<br/>";
					$strhtml.="<br/>";
					$strhtml.="<br/>";
					$strhtml.="$nama_manager";*/
					$strhtml.="</div>";
					
						$strhtml.= "<div class='posisi_srm_aga'>
								Disetujui oleh,
								<br>
								SRM NIAGA
								<br>
								<br>
								<br>
								Busran Labintang
								</div>";

					$strhtml.= "<div class='posisi_msb_sar'>
								MSB STR SAR
								<br>
								<br>
								<br>
								Wilsriza Wilmar
								</div>";

					$strhtml.= "<div class='posisi_srm_tek'>
								SRM TEKNIK
								<br>
								<br>
								<br>
								Taufik Eko W
								</div>";

					$strhtml.= "<div class='posisi_msb_renpol'>
								MSB REN POLA OP DAN HAR SIS DIST
								<br>
								<br>
								<br>
								Andhy Prasetiawan
								</div>";					
			
			require ("lib/mpdf/mpdf.php");

			$stylesheet = file_get_contents('css/table/style.css');
			$fileName = 'reportPdf-SPBJ-'.$nama_vendor . date('d-m-Y') . '-' . date('h.i.s');

			$mpdf = new mPDF('utf-8', 'A4', 0, '', 10, 10, 5, 1, 1, 1, '');
			//$mpdf->SetDisplayMode('fullpage');
			$mpdf->AddPage('L');
			$mpdf->WriteHTML($stylesheet,1);
			$mpdf->WriteHTML($strhtml);
			ob_clean();
			$mpdf->Output('files/' . $fileName. '.pdf','D');

?>


