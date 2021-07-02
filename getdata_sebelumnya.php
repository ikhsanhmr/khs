<?php
session_start();
include_once("lib/config.php");
$paket = isset($_GET['paket_jenis']) ? intval($_GET['paket_jenis']) : 0;
$area = isset($_GET['area']) ? intval($_GET['area']) : 0;
$nilai = isset($_GET['nilai']) ? intval(str_replace(",","",$_GET['nilai'])) : 0;
$gangguan = isset($_GET['gangguan']) ? intval($_GET['gangguan']) : 0;
$year = 2018;
$area_kode=$_SESSION['area'];


/*$paket = 1;
$area = 54110;
$nilai = 1000000000;*/
$query = "select c.vendor_id, a.vendor_nama, b.fin_limit, b.fin_limit-b.fin_current as sisa, a.vendor_id, d.PAGU_KONTRAK, d.TERPAKAI,
			d.TERPAKAI+ $nilai as kontrak_add, round((d.TERPAKAI+ $nilai)/d.PAGU_KONTRAK*100) as percent_add, 0 as n_maks, 0 as n_min
			from tb_vendor a, tb_fin_vendor b, tb_mapping_vendor c, tb_pagu_kontrak d
			where a.vendor_id = b.vendor_id
			and a.vendor_id = c.vendor_id
			and a.STATUS = 0
			AND c.PAKET_JENIS = $paket
			and c.mapping_tahun = $year
			and c.VENDOR_ID = d.VENDOR_ID
			and c.PAKET_JENIS = d.PAKET_JENIS
			and c.area_kode = $area
			and d.TERPAKAI = 0
			and round((d.TERPAKAI+ $nilai)/d.PAGU_KONTRAK*100) <= 100
			ORDER BY d.RANKING
			LIMIT 1";
$result = mysqli_query($query);
$num_rows = mysqli_num_rows($result);
$respon = array();
if ($num_rows > 0 ){
	//echo "0";
	while ($hasil = mysqli_fetch_array($result))
	{
	   $respon[] = $hasil;
	}
}else{
	//echo "1";
	$query = "select c.vendor_id, a.vendor_nama, b.fin_limit, b.fin_limit-b.fin_current as sisa, a.vendor_id, d.PAGU_KONTRAK, d.TERPAKAI, 
		        d.TERPAKAI+ $nilai as kontrak_add, round((d.TERPAKAI+ $nilai)/d.PAGU_KONTRAK*100) as percent_add, 0 as n_maks, 0 as n_min
				from tb_vendor a, tb_fin_vendor b, tb_mapping_vendor c, tb_pagu_kontrak d
				where a.vendor_id = b.vendor_id
				and a.vendor_id = c.vendor_id
				and a.STATUS = 0
				and c.VENDOR_ID = d.VENDOR_ID
				and c.PAKET_JENIS = d.PAKET_JENIS
				AND c.PAKET_JENIS = $paket
				and c.mapping_tahun = $year
				and c.area_kode = $area
				and (d.terpakai+$nilai) / d.pagu_kontrak < 1 
				and b.fin_limit-b.fin_current-$nilai > 0
				order by round((d.TERPAKAI+ $nilai)/d.PAGU_KONTRAK*100)";
	$result = mysqli_query($query);
	$k=0;
	$temp = array();
		while ($hasil = mysqli_fetch_array($result))
		{
		   $temp[] = $hasil;
		   $k++;
		}
		
		$index_terpilih = 0;	
		$i=0;
		$prosen_terkecil = $temp[0]["percent_add"];
		//echo $prosen_terkecil;
		//cek apakah ada data yang sama
		foreach ($temp as $data) {				
			if($i==0) {
				$prosen_terkecil=$temp[$i]["percent_add"];
				$pilihan[$index_terpilih]=$i;	
			} elseif($prosen_terkecil==$temp[$i]["percent_add"]) { // ditemukan nilai prosen yang sama
				$index_terpilih++;
				$pilihan[$index_terpilih]=$i;
			}else break;
					
			$i++;
		}
		$jumlah = count($pilihan);
		$i=0;
		while ($i < $jumlah){
			$respon[] =  $temp[$pilihan[$i]];
			$i++;
		}
}

//$flag = (($paket == 9) AND ($area == 54560)) ? 1 : 0;
$flag = 0;

$flag = ($area_kode == 54560 AND $paket == 9) ? 1 : 0;

if ($paket >= 1 OR $gangguan == 1 OR $flag == 1) {
	$respon = array();
	$query = "select c.vendor_id, a.vendor_nama, b.fin_limit, b.fin_limit-b.fin_current as sisa, a.vendor_id, d.PAGU_KONTRAK, d.TERPAKAI,
			d.TERPAKAI+ $nilai as kontrak_add, round((d.TERPAKAI+ $nilai)/d.PAGU_KONTRAK*100) as percent_add, 0 as n_maks, 0 as n_min
			from tb_vendor a, tb_fin_vendor b, tb_mapping_vendor c, tb_pagu_kontrak d
			where a.vendor_id = b.vendor_id
			and a.vendor_id = c.vendor_id
			and a.STATUS = 0
			AND c.PAKET_JENIS = $paket
			and c.mapping_tahun = $year
			and c.VENDOR_ID = d.VENDOR_ID
			and c.PAKET_JENIS = d.PAKET_JENIS
			and c.area_kode = $area
			and round((d.TERPAKAI+ $nilai)/d.PAGU_KONTRAK*100) <= 100
			ORDER BY d.RANKING";
	$result = mysqli_query($query);
	while ($hasil = mysqli_fetch_array($result))
	{
	   $respon[] = $hasil;
	}
}

echo json_encode($respon);
?>