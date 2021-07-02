<?php
		session_start();
		include_once("lib/config.php");
		include_once('lib/head.php');
		include_once("lib/check.php");
		
		define('DB_SERVER', 'localhost');
		define('DB_USERNAME', 'root');
		define('DB_PASSWORD', 'pln123');
		define('DB_DATABASE', 'khs_production_2019');
		$connection = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
		
		$print_area = $_SESSION['area'];
		$pilih_paket = $_POST['pilih_paket'];
		
		$query_judul = "SELECT AREA_NAMA FROM `tb_area` WHERE AREA_KODE=$print_area";
		$show_judul = mysqli_query($query_judul);
		while ($rowjudul = mysqli_fetch_row($show_judul)) {
			$nama_area = $rowjudul[0];
		}
		
		$query_manager = "SELECT NAMA_MANAGER FROM tb_spj WHERE AREA_KODE=$print_area GROUP BY NAMA_MANAGER LIMIT 1";
		$show_manager = mysqli_query($query_manager);
		while ($rowmanager = mysqli_fetch_row($show_manager)) {
			$nama_manager = $rowmanager[0];
		}
		
		$query_paket = "SELECT PAKET_DESKRIPSI from tb_paket where paket_jenis=$pilih_paket";
		$show_paket = mysqli_query($query_paket);
		while ($row_paket=mysqli_fetch_row($show_paket)){
			$paket_deskripsi = $row_paket[0];
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
							//$strhtml.= "PEKERJAAN SR-APP / JTR-GARDU / JTM T.BETON / JTM T.BESI / SKTM-GH";
							$strhtml.= "PEKERJAAN $paket_deskripsi";
							$strhtml.= "<br/>";
							$strhtml.= "PT PLN (PERSERO) UNIT INDUK WILAYAH RIAU DAN KEPRI";
							$strhtml.="</div>";
							$strhtml.= "<br/>";
							$strhtml.= "<table class='hei'>
									<thead><tr><th>Nomor</th><th>Nama Perusahaan</th><th>Nama UP</th><th>MUTU</th><th>SDM DAN KEUANGAN</th><th>LINGKUNGAN,K3&APD</th>
												<th>ADMINISTRASI</th><th>KOMUNIKASI DAN RESPONSIVENESS</th><th>JUMLAH</th>
												<th>KETERANGAN</th></tr></thead><tbody>";
									
							/*$query = mysqli_query($connection,"
										SELECT C.VENDOR_NAMA, SUM(case when B.id_deskripsi = 1 then ((b.nilai*b.bobot)/10) end)MUTU, 
										SUM(case when B.id_deskripsi = 2 then ((b.nilai*b.bobot)/10) end)SDM, 
										SUM(case when B.id_deskripsi = 5 then ((b.nilai*b.bobot)/10) end)Lingkungan,
										SUM(case when B.id_deskripsi = 6 then ((b.nilai*b.bobot)/10) end)Administrasi,
										SUM(case when B.id_deskripsi = 7 then ((b.nilai*b.bobot)/10) end)Komunikasi 
										FROM penilaian_nilai B join tb_spj D JOIN tb_vendor C where B.spj_no=D.SPJ_NO and 
										D.VENDOR_ID=C.VENDOR_ID AND D.AREA_KODE=$print_area GROUP BY C.VENDOR_ID, B.spj_no
							");	*/
							
							
							$query = mysqli_query($connection,"
										SELECT C.VENDOR_NAMA, SUM(case when B.id_deskripsi = 1 then ((b.nilai*b.bobot)/10) end)MUTU, 
										SUM(case when B.id_deskripsi = 2 then ((b.nilai*b.bobot)/10) end)SDM, 
										SUM(case when B.id_deskripsi = 5 then ((b.nilai*b.bobot)/10) end)Lingkungan,
										SUM(case when B.id_deskripsi = 6 then ((b.nilai*b.bobot)/10) end)Administrasi,
										SUM(case when B.id_deskripsi = 7 then ((b.nilai*b.bobot)/10) end)Komunikasi,
										F.AREA_NAMA
										FROM penilaian_nilai B join tb_spj D JOIN tb_vendor C JOIN tb_termin E  join tb_area F  where B.spj_no=D.SPJ_NO and 
										D.VENDOR_ID=C.VENDOR_ID and D.SPJ_NO=E.spj_no AND D.AREA_KODE=F.AREA_KODE 
										AND D.PAKET_JENIS=$pilih_paket AND E.verifikasi_mup3=1 
										GROUP BY C.VENDOR_ID, B.spj_no
									");
							
							$nomor=1;
							$arr = array();
							while ($row_query= mysqli_fetch_row($query)) {
								
								$tampilkan_area = $row_query[6];
								if(!isset($arr[$row_query[0]])){
									$arr[$row_query[0]]['Mutu']['qty'] = 0;
									$arr[$row_query[0]]['Mutu']['total'] = 0;
									$arr[$row_query[0]]['SDM']['qty'] = 0;
									$arr[$row_query[0]]['SDM']['total'] = 0;
									$arr[$row_query[0]]['Lingkungan']['qty'] = 0;
									$arr[$row_query[0]]['Lingkungan']['total'] = 0;
									$arr[$row_query[0]]['Administrasi']['qty'] = 0;
									$arr[$row_query[0]]['Administrasi']['total'] = 0;
									$arr[$row_query[0]]['Komunikasi']['qty'] = 0;
									$arr[$row_query[0]]['Komunikasi']['total'] = 0;
								}
								$arr[$row_query[0]]['Mutu']['qty']++;
								$arr[$row_query[0]]['Mutu']['total'] += $row_query[1];
								$arr[$row_query[0]]['SDM']['qty']++;
								$arr[$row_query[0]]['SDM']['total'] += $row_query[2];
								$arr[$row_query[0]]['Lingkungan']['qty']++;
								$arr[$row_query[0]]['Lingkungan']['total'] += $row_query[3];
								$arr[$row_query[0]]['Administrasi']['qty']++;
								$arr[$row_query[0]]['Administrasi']['total'] += $row_query[4];
								$arr[$row_query[0]]['Komunikasi']['qty']++;
								$arr[$row_query[0]]['Komunikasi']['total'] += $row_query[5];
								$arr[$row_query[0]]['AREA_NAMA']= $row_query[6];
								
								/*$name_vendor = $row_query[0];
								$mutu = $row_query[1];
								$sdm = $row_query[2];
								$lingkungan = $row_query[3];
								$adm = $row_query[4];
								$komunikasi = $row_query[5];
								$mutup = number_format($mutu, 1, '.', '');
								$sdmp = number_format($sdm, 1, '.', '');
								$lingkunganp = number_format($lingkungan, 1, '.', '');
								$admp = number_format($adm, 1, '.', '');
								$komunikasip = number_format($komunikasi, 1, '.', '');
								
								$totalp= $mutup+$sdmp+$lingkunganp+$admp+$komunikasip;
								$keterangan = "";
								if($totalp >0 && $totalp <2.1){
									$keterangan = "Sangat Kurang";
								}elseif($totalp>=2.1 && $totalp <4.1){
									$keterangan = "Kurang";
								}elseif($totalp>=4.1 && $totalp <6.1){
									$keterangan = "Cukup";
								}elseif ($totalp>=6.1 && $totalp <8.1){
									$keterangan="Baik";
								}elseif ($totalp>=8.1 && $totalp<=10){
									$keterangan="Baik Sekali";
								}
								
								$strhtml.= "<tr>
									  <td>$nomor</td>		
									  <td>$name_vendor</td>		
									  <td>$mutup</td>		
									  <td>$sdmp</td>		
									  <td>$lingkunganp</td>	
									  <td>$admp</td>
									  <td>$komunikasip</td>
									  <td>$totalp</td>
									  <td>$keterangan</td>
									  ";
								$strhtml.="</tr>";
								*/
							}
							foreach($arr as $k => $v){
								$tampilkan_area = $v['AREA_NAMA'];
								$mutup = $v['Mutu']['total'] / $v['Mutu']['qty'];
								$sdmp= $v['SDM']['total'] / $v['SDM']['qty'];
								$lingkunganp = $v['Lingkungan']['total'] / $v['Lingkungan']['qty'];
								$admp = $v['Administrasi']['total'] / $v['Administrasi']['qty'];
								$komunikasip = $v['Komunikasi']['total'] / $v['Komunikasi']['qty'];
								
								$mutupp =  number_format($mutup, 2, '.', '');
								$sdmpp =  number_format($sdmp, 2, '.', '');
								$lingkunganpp =  number_format($lingkunganp, 2, '.', '');
								$admpp =  number_format($admp, 2, '.', '');
								$komunikasipp =  number_format($komunikasip, 2, '.', '');
								
								$totalp= $mutup+$sdmp+$lingkunganp+$admp+$komunikasip;
								
								$totalpp= $mutupp+$sdmpp+$lingkunganpp+$admpp+$komunikasipp;
								$keterangan = "";
								
								if($totalpp >0 && $totalpp <2.1){
									$keterangan = "Sangat Kurang";
								}elseif($totalpp>=2.1 && $totalpp <4.1){
									$keterangan = "Kurang";
								}elseif($totalpp>=4.1 && $totalpp <6.1){
									$keterangan = "Cukup";
								}elseif ($totalpp>=6.1 && $totalpp <8.1){
									$keterangan="Baik";
								}elseif ($totalpp>=8.1 && $totalpp<=10){
									$keterangan="Baik Sekali";
								}
								
								$strhtml.= "<tr>
									  <td>$nomor</td>		
									  <td>$k</td>		
									  <td>$tampilkan_area</td>		
									  <td>$mutupp</td>		
									  <td>$sdmpp</td>		
									  <td>$lingkunganpp</td>	
									  <td>$admpp</td>
									  <td>$komunikasipp</td>
									  <td>$totalpp</td>
									  <td>$keterangan</td>
									  ";
								$strhtml.="</tr>";
								$nomor++;	
							}
							//echo "<pre>";print_r($arr);echo "</pre>";exit();
					$strhtml.="</table>";
					$strhtml.="<br/>";
	
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
					 if($pilih_paket==1){
					$strhtml.= "<div class='posisi_srm_aga1'>$kota_area, $today";
					$strhtml.="<br/>";
					
					$strhtml.="SRM NIAGA";
					$strhtml.="<br/>";
					$strhtml.="<br/>";
					$strhtml.="<br/>";
					$strhtml.="<br/>";
					$strhtml.="<br/>";
					$strhtml.="Busran Labintang";
					$strhtml.="</div>";
					
					$strhtml.= "<div class='posisi_msb_sar1'>
								MSB STR SAR
								<br>
								<br>
								<br>
								<br>
								<br>
								Wilsriza Wilmar
								</div>";
					}else{
					$strhtml.= "<div class='posisi_srm_aga1'>$kota_area, $today";	
					$strhtml.="<br/>";
					$strhtml.="SRM TEKNIK";
					$strhtml.="<br/>";
					$strhtml.="<br/>";
					$strhtml.="<br/>";
					$strhtml.="<br/>";
					$strhtml.="<br/>";
					$strhtml.="Taufik Eko W";
					$strhtml.="</div>";
						
						$strhtml.= "<div class='posisi_msb_sar1'>
								MSB REN POLA OP DAN HAR SIS DIST
								<br>
								<br>
								<br>
								<br>
								<br>
								Andhy Prasetiawan
								</div>";
					}
			
			require ("lib/mpdf/mpdf.php");

			$stylesheet = file_get_contents('css/table/style.css');
			$fileName = 'reportPdf-All_Vendor-'.$nama_vendor . date('d-m-Y') . '-' . date('h.i.s');

			$mpdf = new mPDF('utf-8', 'A4', 0, '', 10, 10, 5, 1, 1, 1, '');
			//$mpdf->SetDisplayMode('fullpage');
			$mpdf->WriteHTML($stylesheet,1);
			$mpdf->WriteHTML($strhtml);
			ob_clean();
			$mpdf->Output('files/' . $fileName. '.pdf','D');

?>