<?php
session_start();
require_once 'lib/function.php';
require_once 'Excel/reader.php';
require_once 'Excel/simplexlsx.class.php';
//include_once("Excel/phpExcelReader/reader.php");
//date_default_timezone_set("GMT");

$target_dir = "upload/upload_skki/";
$target_file = $target_dir . basename($_FILES["file_skki"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

if ($uploadOk == 0) {
    echo "File Gagal Diupload";
// if everything is ok, try to upload file
} 
else {
	
    if (move_uploaded_file($_FILES["file_skki"]["tmp_name"], $target_file)) {
		$get_var_file_name 	= $HTTP_POST_FILES['file_skki']['name'];
		
		$var_tahun	= $_POST['var_tahun'];
		$var_flag	= '0';
		$var_revisi	= '0';
		//echo $var_tahun;
 		$nama			= $_FILES['file_skki']['name'];
		
		$xlsx = new SimpleXLSX('upload/upload_skki/'.$nama.'');
		$excel_data = $xlsx->rows();
		$jumlah_row =count($excel_data);
		//echo $jumlah_row;
		
		for ($i=1;$i<count($excel_data);$i++) 
		{
			
			$var_skki_jenis	= trim($excel_data[$i][1]);
			$var_skki_no	= trim($excel_data[$i][2]);	
			$var_kode_area 	= trim($excel_data[$i][3]);
			$var_skki_nilai	= trim($excel_data[$i][4]);	
			$var_skki_tgl	= date('Y-m-d',$xlsx->unixstamp($excel_data[$i][5]));
			$var_paket		= trim($excel_data[$i][6]);	
			//echo $var_skki_jenis;
			
			$return_insert = skki_upload($var_skki_jenis,$var_skki_no,$var_kode_area,$var_skki_nilai,$var_skki_tgl,$var_paket,$var_revisi,$var_flag,$var_tahun, $mysqli);		
		}
	
		
		if ($return_insert==0)
		{
			echo '<script language="javascript">alert("Upload SKKI dengan Jumlah Record : '.($jumlah_row-1).'.")</script>';
			echo '<script language="javascript">window.location = "dashboard.php"</script>';
		}
		else 
		{
			echo '<script language="javascript">alert("ERROR : Upload SKKI Gagal")</script>';
			echo '<script language="javascript">window.location = "upload_skki.php"</script>';
		} 
		
		
    } 
    else 
    { 
    	echo "Terjadi Kesalahan Saat Upload. Silahkan Coba Lagi";
    	echo '<script language="javascript">window.location = "upload_skki.php"</script>';
    }
}
