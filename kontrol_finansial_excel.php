<?php 
	session_start();
	require_once "Excel/Excel.class.php";
	require_once "lib/config.php";
	
	$area = $_GET['area'];
	$vendor = $_GET['vendor'];
							
							
	if($area=="" && $vendor==""){
		$sql = "SELECT e.vendor_nama, x.rating_laporan_audit, x.fin_limit, x.sisa, x.jumlah_area, c.paket_deskripsi, x.vendor_id, x.paket_jenis FROM
									(SELECT DISTINCT b.paket_jenis, a.vendor_id, a.rating_laporan_audit, a.fin_limit, a.fin_limit - a.fin_current as sisa, (select COUNT(d.AREA_KODE) from tb_mapping_vendor d where d.VENDOR_ID = a.vendor_id and d.PAKET_JENIS = b.paket_jenis) as jumlah_area
									from
									tb_fin_vendor a left join tb_mapping_vendor b on a.vendor_id = b.vendor_id) as x 
									left join tb_paket c on c.paket_jenis = x.paket_jenis 
									inner join tb_vendor e on e.vendor_id = x.vendor_id";
	}else if($vendor=="" && $area!=""){
		$sql = "select e.vendor_nama, x.rating_laporan_audit, x.fin_limit, x.sisa, x.jumlah_area, c.paket_deskripsi, x.vendor_id, x.paket_jenis from
									(select distinct b.paket_jenis, a.vendor_id, a.rating_laporan_audit, a.fin_limit, a.fin_limit - a.fin_current as sisa, (select COUNT(d.AREA_KODE) from tb_mapping_vendor d where d.VENDOR_ID = a.vendor_id and d.PAKET_JENIS = b.paket_jenis) as jumlah_area, b.area_kode
									from
									tb_fin_vendor a left join tb_mapping_vendor b on a.vendor_id = b.vendor_id) as x 
									left join tb_paket c on c.paket_jenis = x.paket_jenis 
									inner join tb_vendor e on e.vendor_id = x.vendor_id
									AND x.AREA_KODE = $area";
	}else if($area=="" && $vendor!=""){
		$sql = "select e.vendor_nama, x.rating_laporan_audit, x.fin_limit, x.sisa, x.jumlah_area, c.paket_deskripsi, x.vendor_id, x.paket_jenis from
									(select distinct b.paket_jenis, a.vendor_id, a.rating_laporan_audit, a.fin_limit, a.fin_limit - a.fin_current as sisa, (select COUNT(d.AREA_KODE) from tb_mapping_vendor d where d.VENDOR_ID = a.vendor_id and d.PAKET_JENIS = b.paket_jenis) as jumlah_area
									from
									tb_fin_vendor a left join tb_mapping_vendor b on a.vendor_id = b.vendor_id) as x 
									left join tb_paket c on c.paket_jenis = x.paket_jenis 
									inner join tb_vendor e on e.vendor_id = x.vendor_id
									and e.VENDOR_NAMA like '%$vendor%'";
	}else if($area!="" && $vendor!=""){
		$sql = "select e.vendor_nama, x.rating_laporan_audit, x.fin_limit, x.sisa, x.jumlah_area, c.paket_deskripsi, x.vendor_id, x.paket_jenis from
									(select distinct b.paket_jenis, a.vendor_id, a.rating_laporan_audit, a.fin_limit, a.fin_limit - a.fin_current as sisa, (select COUNT(d.AREA_KODE) from tb_mapping_vendor d where d.VENDOR_ID = a.vendor_id and d.PAKET_JENIS = b.paket_jenis) as jumlah_area, b.area_kode
									from
									tb_fin_vendor a left join tb_mapping_vendor b on a.vendor_id = b.vendor_id) as x 
									left join tb_paket c on c.paket_jenis = x.paket_jenis 
									inner join tb_vendor e on e.vendor_id = x.vendor_id
									WHERE x.AREA_KODE = $area and e.VENDOR_NAMA like '%$vendor%'";
	}
							
	$resultQuery=mysqli_query($sql);
	while($rows=mysqli_fetch_array($resultQuery)){
		$data[]=$rows;
	}

	$excel = new Excel();
	$excel->setHeader('kontrol finansial.xls');
	$excel->BOF();
	
	//header
	$excel->writeLabel(0,0,"No");
	$excel->writeLabel(0,1,"Vendor");
	$excel->writeLabel(0,2,"Rating");
	$excel->writeLabel(0,3,"Kekuatan Finansial");
	$excel->writeLabel(0,4,"Sisa Finansial");
	$excel->writeLabel(0,5,"Persen Sisa Finansial");
	$excel->writeLabel(0,6,"Total Area");
	$excel->writeLabel(0,7,"Jenis Pekerjaan");
	
	for($i=0;$i<count($data);$i++){
		$current_nama_vendor = $data[$i][0];
		$current_rating = $data[$i][1];
		$current_financial = $data[$i][2];
		$current_sisa_financial = $data[$i][3];
		$current_jmlh_area = $data[$i][4];
		$current_jenis_pekerjaan = $data[$i][5];
		$current_no_vendor = $data[$i][6];
		$current_paket_jenis = $data[$i][7];
		
		$a=$i+1;
		$b=floor($current_sisa_financial/$current_financial*100);
		
		$current_financial=number_format($current_financial);
		$current_sisa_financial=number_format($current_sisa_financial);
		
		$excel->writeLabel($a,0,"$a");
		$excel->writeLabel($a,1,"$current_nama_vendor");
		$excel->writeLabel($a,2,"$current_rating");
		$excel->writeLabel($a,3,"Rp.$current_financial");
		$excel->writeLabel($a,4,"Rp.$current_sisa_financial");
		$excel->writeLabel($a,5,"$b%");
		$excel->writeLabel($a,6,"$current_jmlh_area");
		$excel->writeLabel($a,7,"$current_jenis_pekerjaan");
							
	}
	$excel->EOF();
 
	exit();
?>
			