<?php

include_once('lib/mail.php');
include_once('lib/function.php');

$no_spj 	= "SPJ/DEMO/MENTENG/000001";
$subject 	= "[KHS] Notifikasi Pembuatan SPJ";
$sender 	= 'plndisjaya_khs@pln.co.id';
$receiver 	= 'nisa.azmi@pln.co.id';
$file_attach = 'uploads/KHS.pdf';

//$spj = select_all_spj($no_spj);
$q = "select * from tb_spj where spj_no = '$no_spj'";
$getdata_query = mysqli_query($q);
while($data_spj=mysqli_fetch_array($getdata_query))
    { $spj_data[] = $data_spj; }

$area_kode 		= $spj_data[0]['AREA_KODE'];
$vendor_id 		= $spj_data[0]['VENDOR_ID'];
$paket_jenis 	= $spj_data[0]['PAKET_JENIS'];
$desk 			= $spj_data[0]['SPJ_DESKRIPSI'];
$nilai 			= $spj_data[0]['SPJ_ADD_NILAI'];

$paket = get_desk_paket($paket_jenis);
$paket_pekerjaan = $paket[0][0];

$vendor = select_nama_vendor($vendor_id);
$vendor_nama = $vendor[0][0];
//echo $vendor_id;

$area  = select_nama_area($area_kode);
$area_nama = $area[0][0];

$body="
Kepada Ysh Direktur ".$vendor_nama." <br><br>
Telah Dilakukan Pembuatan SPJ untuk : <br>
<table border='0'>
	<tr>
	    <td>Area</td>
	    <td>:</th>
	    <td>".$area_nama."</td>
  	</tr>
  	<tr>
	    <td>No SPJ </td>
	    <td>:</td>
	    <td>".$no_spj."</td>
  	</tr>
  	<tr>
	    <td>Vendor yang Ditunjuk</td>
	    <td>:</td>
	    <td>".$vendor_nama."</td>
  	</tr>
  	<tr>
	    <td>Paket Pekerjaan</td>
	    <td>:</td>
	    <td>".$paket_pekerjaan."</td>
  	</tr>
  	<tr>
	    <td>Deskripsi Pekerjaan</td>
	    <td>:</td>
	    <td>".$desk."</td>
  	</tr>
  	<tr>
	    <td>Nilai Pekerjaan</td>
	    <td>:</td>
	    <td>Rp ".number_format($nilai).",-</td>
  	</tr>
</table><br>
Harap Segera Berkoordinasi dengan Area ".$area_nama." 
";

mail_attachment($subject,$sender,$receiver, $body);
?>