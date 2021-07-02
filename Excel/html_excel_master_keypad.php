<?php 
function xlsBOF() {
echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
return;
}

function xlsEOF() {
echo pack("ss", 0x0A, 0x00);
return;
}

function xlsWriteNumber($Row, $Col, $Value) {
echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
echo pack("d", $Value);
return;
}

function xlsWriteLabel($Row, $Col, $Value ) {
$L = strlen($Value);
echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
echo $Value;
return;
}

include "lib/config.php";

$queabsdetail = "SELECT * FROM lp_master_keypad";
$exequeabsdetail = mysqli_query($queabsdetail);
while($res = mysqli_fetch_array($exequeabsdetail)){

	$data['id_siswa'][] = $res['id_siswa'];
	$data['nama_siswa'][] = $res['nama_siswa'];
	
} 

$jm = sizeof($data['id_siswa']);
header("Pragma: public" );
header("Expires: 0" );
header("Cache-Control: must-revalidate, post-check=0, pre-check=0" );
header("Content-Type: application/force-download" );
header("Content-Type: application/octet-stream" );
header("Content-Type: application/download" );;
header("Content-Disposition: attachment;filename=file_siswa.xls " );
header("Content-Transfer-Encoding: binary " );
xlsBOF();
xlsWriteLabel(0,3,"Data Siswa" );
xlsWriteLabel(2,0,"Nomor" );
xlsWriteLabel(2,1,"Nama Siswa" );
xlsWriteLabel(2,2,"NIS" );
xlsWriteLabel(2,3,"Kelamin" );
xlsWriteLabel(2,4,"Alamat" );
xlsWriteLabel(2,5,"Telpon" );
$xlsRow = 3;

for ($y=0; $y<$jm; $y++) {
	++$i;
	xlsWriteNumber($xlsRow,0,"$i" );
	xlsWriteLabel($xlsRow,1,$data['nama_siswa'][$y]);
	xlsWriteLabel($xlsRow,2,$data['nis'][$y]);
	$xlsRow++;
}
xlsEOF();
exit();