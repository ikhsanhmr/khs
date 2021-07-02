<?php
	session_start();
	require_once "Excel/Excel.class.php";
	require_once "lib/config.php";
	
	$tahun = $_GET['tahun'];

	if(isset($_GET['dash'])){
		if($tahun == '')
		{
			$query = "select SKKI.area_nama, skki_nilai, skko_nilai, skki_nilai+skko_nilai,skki_spj,skko_spj, skki_bayar, skko_bayar, SKKI.area_kode  from 
			(select area_nama,
					area_kode,
					sum(skki_nilai) as skki_nilai,
					sum(total_spj) as skki_spj,
					sum(total_bayar) as skki_bayar
			from (select 
					d.area_nama,
					a.area_kode,
					a.skki_nilai,
					(select count(b.spj_no) from tb_spj b where b.skki_no = a.skki_no ) as jml_spj,
					COALESCE((select sum(b.SPJ_ADD_NILAI) from tb_spj b where b.skki_no = a.skki_no),0) as total_spj,
					COALESCE((select sum(b.pembayaran_nominal) from tb_pembayaran b, tb_spj c where b.spj_no = c.spj_no and c.skki_no = a.skki_no),0) as total_bayar,
					a.SKKI_NILAI - SKKI_TERPAKAI as sisa_skki 
				from tb_skko_i a, tb_area d
					where d.area_kode = a.area_kode
					AND a.SKKI_JENIS = 'SKKI'
					AND a.tahun ='2018'	
				order by d.area_kode, a.skki_no) a group by a.area_nama) SKKI,
				(select area_nama,
						area_kode,
						sum(skki_nilai) as skko_nilai,
					   sum(total_spj) as skko_spj,
					   sum(total_bayar) as skko_bayar
				from (select 
							d.area_nama,
							a.area_kode,
							a.skki_nilai,
							(select count(b.spj_no) from tb_spj b where b.skki_no = a.skki_no ) as jml_spj,
							COALESCE((select sum(b.SPJ_ADD_NILAI) from tb_spj b where b.skki_no = a.skki_no),0) as total_spj,
							COALESCE((select sum(b.pembayaran_nominal) from tb_pembayaran b, tb_spj c where b.spj_no = c.spj_no and c.skki_no = a.skki_no),0) as total_bayar,
							a.SKKI_NILAI - SKKI_TERPAKAI as sisa_skki 
							from tb_skko_i a, tb_area d
								where d.area_kode = a.area_kode
								AND a.SKKI_JENIS = 'SKKO'
								AND a.tahun ='2018'	
								order by d.area_kode, a.skki_no) a group by a.area_nama)SKKO
						where SKKI.AREA_kode = SKKO.AREA_kode";

		}
		if ($tahun != ''){
		$query = "select SKKI.area_nama, skki_nilai, skko_nilai, skki_nilai+skko_nilai,skki_spj,skko_spj, skki_bayar, skko_bayar, SKKI.area_kode  from 
									(select area_nama, area_kode,
										sum(skki_nilai) as skki_nilai,
										sum(total_spj) as skki_spj,
										sum(total_bayar) as skki_bayar
									from (select d.area_nama, a.area_kode, a.skki_nilai,
									(select count(b.spj_no) from tb_spj b where b.skki_no = a.skki_no ) as jml_spj,
									COALESCE((select sum(b.SPJ_ADD_NILAI) from tb_spj b where b.skki_no = a.skki_no),0) as total_spj,
									COALESCE((select sum(b.pembayaran_nominal) from tb_pembayaran b, tb_spj c where b.spj_no = c.spj_no and c.skki_no = a.skki_no),0) as total_bayar,
									a.SKKI_NILAI - SKKI_TERPAKAI as sisa_skki 
									from tb_skko_i a, tb_area d
									where d.area_kode = a.area_kode
									AND a.SKKI_JENIS = 'SKKI'
									AND a.tahun =$tahun	
									order by d.area_kode, a.skki_no) a group by a.area_nama) SKKI,
									(select area_nama,area_kode,
										sum(skki_nilai) as skko_nilai,
										sum(total_spj) as skko_spj,
										sum(total_bayar) as skko_bayar
									from (select d.area_nama,a.area_kode,a.skki_nilai,
									(select count(b.spj_no) from tb_spj b where b.skki_no = a.skki_no ) as jml_spj,
									COALESCE((select sum(b.SPJ_ADD_NILAI) from tb_spj b where b.skki_no = a.skki_no),0) as total_spj,
									COALESCE((select sum(b.pembayaran_nominal) from tb_pembayaran b, tb_spj c where b.spj_no = c.spj_no and c.skki_no = a.skki_no),0) as total_bayar,
									a.SKKI_NILAI - SKKI_TERPAKAI as sisa_skki 
									from tb_skko_i a, tb_area d
									where d.area_kode = a.area_kode
									AND a.SKKI_JENIS = 'SKKO'
									AND a.tahun =$tahun
									order by d.area_kode, a.skki_no) a group by a.area_nama)SKKO
									where SKKI.AREA_kode = SKKO.AREA_kode";
		}
		
							if ($_SESSION['area'] != 18){
								$area = $_SESSION['area'];
								$query = $query ." and SKKI.area_kode = $area";
							}

							$query = $query ." order by area_nama";
							$resultQuery=mysqli_query($query);
							while ($rows=mysqli_fetch_row($resultQuery)){ 
								$data[] = $rows;
							}
							
							$excel = new Excel();
							$excel->setHeader('dashboard.xls');
							$excel->BOF();
							
							$excel->writeLabel(0,0,"No");
							$excel->writeLabel(0,1,"Nama Area");
							$excel->writeLabel(0,2,"Total SKKI");
							$excel->writeLabel(0,3,"Total SKKO");
							$excel->writeLabel(0,4,"Total");
							$excel->writeLabel(0,5,"Persen SKKI Terkontrak");
							$excel->writeLabel(0,6,"Jumlah SKKI Terkontrak");
							$excel->writeLabel(0,7,"Persen SKKO Terkontrak");
							$excel->writeLabel(0,8,"Jumlah SKKO Terkontrak");
							$excel->writeLabel(0,9,"Persen SKKI Terbayar dari SPJ Terbit");
							$excel->writeLabel(0,10,"Jumlah SKKI Terbayar dari SPJ Terbit");
							$excel->writeLabel(0,11,"Persen SKKO Terbayar dari SPJ Terbit");
							$excel->writeLabel(0,12,"Jumlah SKKO Terbayar dari SPJ Terbit");
							$excel->writeLabel(0,13,"Persen SKKI Terbayar dari SKKI/SKKO");
							$excel->writeLabel(0,14,"Persen SKKO Terbayar dari SKKI/SKKO");
							
							$TSKKI = 0;
							$TSKKI = 0;
							$TSKKIO = 0;
							$TKONTRAK_SKKI = 0;
							$TKONTRAK_SKKO = 0;
							$TBAYAR_SKKI = 0;
							$TBAYAR_SKKO = 0;
							
							$jumlah = count($data);
							for($i=0;$i<count($data);$i++){
								$a = $i + 1;
								$area = $data[$i][0];
								$SKKI = $data[$i][1];
								$SKKO = $data[$i][2];
								$Total = $data[$i][3];
								$TSKKI = $TSKKI + $SKKI;
								$TSKKO = $TSKKO + $SKKO;
								$TSKKIO = $TSKKIO + $Total;
								$terkontrak_sski = floor(($data[$i][4]/$SKKI)*100);
								$rp_terkontrak_skki = $data[$i][4];
								$TKONTRAK_SKKI = $TKONTRAK_SKKI + $rp_terkontrak_skki;
								$terkontrak_ssko = floor(($data[$i][5]/$SKKO)*100);
								$rp_terkontrak_skko = $data[$i][5];
								$TKONTRAK_SKKO = $TKONTRAK_SKKO + $rp_terkontrak_skko;
								$bayar_kontrak_i = floor(($data[$i][6]/$data[$i][4])*100);
								$bayar_kontrak_o = floor(($data[$i][7]/$data[$i][5])*100);
								$bayar_sski = floor(($data[$i][6]/$SKKI)*100);
								$bayar_ssko = floor(($data[$i][7]/$SKKO)*100);
								$rp_bayar_skki = $data[$i][6];
								$TBAYAR_SKKI = $TBAYAR_SKKI + $rp_bayar_skki;
								$rp_bayar_skko = $data[$i][7];
								$TBAYAR_SKKO = $TBAYAR_SKKO + $rp_bayar_skko;
								
								$excel->writeLabel($a,0,"$a");
								$excel->writeLabel($a,1,"$area");
								$excel->writeLabel($a,2,"Rp ".number_format($SKKI));
								$excel->writeLabel($a,3,"Rp ".number_format($SKKO));
								$excel->writeLabel($a,4,"Rp ".number_format($Total));
								$excel->writeLabel($a,5, $terkontrak_sski." %");
								$excel->writeLabel($a,6,"Rp ".number_format($rp_terkontrak_skki));
								$excel->writeLabel($a,7,$terkontrak_ssko." %");
								$excel->writeLabel($a,8,"Rp ".number_format($rp_terkontrak_skko));
								$excel->writeLabel($a,9,$bayar_kontrak_i." %");
								$excel->writeLabel($a,10,"Rp ".number_format($rp_bayar_skki));
								$excel->writeLabel($a,11,$bayar_kontrak_o." %");
								$excel->writeLabel($a,12,"Rp ".number_format($rp_bayar_skko));
								$excel->writeLabel($a,13,$bayar_sski." %");
								$excel->writeLabel($a,14,$bayar_ssko." %");
							}
							$no  = $jumlah +=1;
							$excel->writeLabel($no,0,$no);
							$excel->writeLabel($no,1,'Total');
							$excel->writeLabel($no,2,"Rp ".number_format($TSKKI));
							$excel->writeLabel($no,3,"Rp ".number_format($TSKKO));
							$excel->writeLabel($no,4,"Rp ".number_format($TSKKIO));
							$excel->writeLabel($no,5,$PERSEN_TKONTRAK_I.'%');
							$excel->writeLabel($no,6,"Rp ".number_format($TKONTRAK_SKKI));
							$excel->writeLabel($no,7,$PERSEN_TKONTRAK_O.'%');
							$excel->writeLabel($no,8,"Rp ".number_format($TKONTRAK_SKKO));
							$excel->writeLabel($no,9,$PERSEN_TBAYAR_I.'%');
							$excel->writeLabel($no,10,"Rp ".number_format($TBAYAR_SKKI));
							$excel->writeLabel($no,11,$PERSEN_TBAYAR_O.'%');
							$excel->writeLabel($no,12,"Rp ".number_format($TBAYAR_SKKO));
							
							$excel->EOF();
							exit();
	}else if(isset($_GET['rekap'])){			
		
		if ($_SESSION['area'] == 18){
			if($tahun=='')
								{
								$query1 = "select paket_pekerjaan, sum(SKKI_NILAI), SUM(total_spj), sum(total_bayar),area_nama from 
									(select d.area_nama,a.area_kode,a.paket_pekerjaan,a.skki_nilai,
									(select count(b.spj_no) from tb_spj b where b.skki_no = a.skki_no ) as jml_spj,
									COALESCE((select sum(b.SPJ_ADD_NILAI) from tb_spj b where b.skki_no = a.skki_no),0) as total_spj,
									COALESCE((select sum(b.pembayaran_nominal) from tb_pembayaran b, tb_spj c where b.spj_no = c.spj_no and c.skki_no = a.skki_no),0) as total_bayar,
									a.SKKI_NILAI - SKKI_TERPAKAI as sisa_skki 
									from tb_skko_i a, tb_area d
									where d.area_kode = a.area_kode
									AND a.SKKI_JENIS = 'SKKI'
									AND a.tahun='2018'
									order by d.area_kode, a.skki_no) a
									group by paket_pekerjaan, AREA_KODE order by area_nama, paket_pekerjaan";
								}
								if($tahun!='')
								{
								$query1 = "select paket_pekerjaan, sum(SKKI_NILAI), SUM(total_spj), sum(total_bayar),area_nama from 
									(select d.area_nama,a.area_kode,a.paket_pekerjaan,a.skki_nilai,
									(select count(b.spj_no) from tb_spj b where b.skki_no = a.skki_no ) as jml_spj,
									COALESCE((select sum(b.SPJ_ADD_NILAI) from tb_spj b where b.skki_no = a.skki_no),0) as total_spj,
									COALESCE((select sum(b.pembayaran_nominal) from tb_pembayaran b, tb_spj c where b.spj_no = c.spj_no and c.skki_no = a.skki_no),0) as total_bayar,
									a.SKKI_NILAI - SKKI_TERPAKAI as sisa_skki 
									from tb_skko_i a, tb_area d
									where d.area_kode = a.area_kode
									AND a.SKKI_JENIS = 'SKKI'
									AND a.tahun=$tahun
									order by d.area_kode, a.skki_no) a
									group by paket_pekerjaan, AREA_KODE order by area_nama, paket_pekerjaan";
								}
			
			$resultQuery=mysqli_query($query1);
			while ($rows=mysqli_fetch_row($resultQuery)){ 
				$data1[] = $rows;
			}
			
			$excel = new Excel();
			$excel->setHeader('rekap skki per-basket.xls');
			$excel->BOF();
			
			//header
			$excel->writeLabel(0,0,"No");
			$excel->writeLabel(0,1,"Paket Pekerjaan");
			$excel->writeLabel(0,2,"Area");
			$excel->writeLabel(0,3,"Total SKKI");
			$excel->writeLabel(0,4,"Persen Terkontrak");
			$excel->writeLabel(0,5,"Jumlah Terkontrak");
			$excel->writeLabel(0,6,"Persen Terbayar dari SPJ Terbit");
			$excel->writeLabel(0,7,"Jumlah Terbayar dari SPJ Terbit");
			$excel->writeLabel(0,8,"Persen Terbayar dari SKKI");
			
			$TSKKI_BASKET = 0;
			$TSKKI_BASKET_TERKONTRAK = 0;
			$TSKKI_BASKET_TERBAYAR = 0;
			for($i=0;$i<count($data1);$i++){
				$jenis = $data1[$i][0];
				$SKKI = $data1[$i][1];
				$TSKKI_BASKET = $TSKKI_BASKET + $SKKI;
				$terkontrak = $data1[$i][2];
				$TSKKI_BASKET_TERKONTRAK = $TSKKI_BASKET_TERKONTRAK + $terkontrak;
				$terbayar = $data1[$i][3];
				$TSKKI_BASKET_TERBAYAR = $TSKKI_BASKET_TERBAYAR + $terbayar;
				$persen_kontrak = floor(($terkontrak/$SKKI)*100);
				$persen_bayar = floor(($terbayar/$terkontrak)*100);
				$persen_bayar_skki = floor(($terbayar/$SKKI)*100);
				$area = $data1[$i][4];
				
				$a=$i+1;
				
				$excel->writeLabel($a,0,"$a");
				$excel->writeLabel($a,1,"$jenis");
				$excel->writeLabel($a,2,"$area");
				$excel->writeLabel($a,3,"Rp ".number_format($SKKI));
				$excel->writeLabel($a,4,$persen_kontrak." %");
				$excel->writeLabel($a,5,"Rp ".number_format($terkontrak));
				$excel->writeLabel($a,6,$persen_bayar." %");
				$excel->writeLabel($a,7,"Rp ".number_format($terbayar));
				$excel->writeLabel($a,8,$persen_bayar_skki." %");
				
			}
			
			$excel->EOF();
			exit();
		}
	}	
	