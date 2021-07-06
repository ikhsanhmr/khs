<?php
session_start();
include_once('lib/config.php');
include_once('lib/function.php');
include_once('lib/check.php');
include_once('lib/terbilang.php');
include_once "phpqrcode/phpqrcode/qrlib.php";

$no_spj = $_GET['id'];
$kode_area  = $_SESSION['area'];
$area       = select_nama_area($kode_area, $mysqli);
$nama_area  = $area[0][0];

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

    //$q = "select *, ABS(DATEDIFF(SPJ_TANGGAL_MULAI,SPJ_ADD_TANGGAL)) as diff from tb_spj where spj_no = '$no_spj'";
    $q = "select *, ABS((DATEDIFF(SPJ_TANGGAL_MULAI,SPJ_ADD_TANGGAL)))+1 as diff from tb_spj where spj_no = '$no_spj'"; //dirubah karena audit SPI
    $getdata_query = mysqli_query($mysqli, $q);
    while ($data_spj=mysqli_fetch_array($getdata_query)) {
        $spj_data[] = $data_spj;
    }

    $qr = "select *, ABS(DATEDIFF(tanggal_addendum,SPJ_ADD_TANGGAL)) as diff from tb_spj where spj_no = '$no_spj'";
    $getdata_queryr = mysqli_query($mysqli, $qr);
    while ($data_spjr=mysqli_fetch_array($getdata_queryr)) {
        $spj_datar[] = $data_spjr;
    }


    /*$no_pjn         = $spj_data[0]['NOMOR_PJN'];
    $tgl_pjn_f  = $spj_data[0]['TGL_PJN'];
    $tgl_pjn    = format_indo($tgl_pjn_f);
*/
    $nama_manager   = $spj_data[0]['NAMA_MANAGER'];
    $dir_vendor     = get_direksi($spj_data[0]['VENDOR_ID'], $mysqli);
    $vendor         = $spj_data[0]['VENDOR_ID'];
    $skkio          = $spj_data[0]['SKKI_NO'];
    $paket_kerja    = $spj_data[0]['PAKET_JENIS'];
    $spj            = $spj_data[0]['SPJ_ADD_NILAI'];
    $ppn            = $spj_data[0]['PPN'];
    $min_ppn        = $spj_data[0]['MIN_PPN'];
    $dir_pkj        = $spj_data[0][16];
    $dir_lpg        = $spj_data[0][19];
    $mulai          = date('d-m-Y', strtotime($spj_data[0]['SPJ_TANGGAL_MULAI']));
    $sampai         = date('d-m-Y', strtotime($spj_data[0]['SPJ_ADD_TANGGAL']));
    $diff           = $spj_data[0]['diff'];
    
    //echo $diff;
    $deskripsi      = $spj_data[0]['SPJ_DESKRIPSI'];

    $tanggal_addendums = $spj_data[0]['tanggal_addendum'];
    
    $no_pjn     = get_no_pjn($vendor, $paket_kerja, $mysqli);
    $tgl_pjn_f  = date('Y-m-d', strtotime(get_tgl_pjn($vendor, $paket_kerja, $mysqli)));
    $tgl_pjn    = format_indo($tgl_pjn_f);

    $no_spp     = get_no_spp($vendor, $paket_kerja, $mysqli);
    $tgl_spp_f  = date('Y-m-d', strtotime(get_tgl_spp($vendor, $paket_kerja, $mysqli)));
    $tgl_spp    = format_indo($tgl_spp_f);

    $no_pen     = get_no_penawaran($vendor, $paket_kerja, $mysqli);
    $tgl_pen_f  = date('Y-m-d', strtotime(get_tgl_penawaran($vendor, $paket_kerja, $mysqli)));
    $tgl_pen    = format_indo($tgl_pen_f);
    //echo $tgl_pen;

    $no_rks     = get_no_rks($vendor, $paket_kerja, $mysqli);
    $tgl_rks_f  = date('Y-m-d', strtotime(get_tgl_rks($vendor, $paket_kerja, $mysqli)));
    $tgl_rks    = format_indo($tgl_rks_f);


    $tgl_akhir_f = date('Y-m-d', strtotime($spj_data[0]['SPJ_ADD_TANGGAL']));
    $tgl_akhir = format_indo($tgl_akhir_f);

    $jenis_skk = get_jenis_skk($skkio, $mysqli);

    //$tgl_spj_f  = date('Y-m-d',strtotime($spj_data[0]['SPJ_INPUT_DATE']));
    //diganti karena spj nya bisa tanggal mundur request UPK
    
    if ($tanggal_addendums=='0000-00-00') {
        $tgl_spj_f  = date('Y-m-d', strtotime($spj_data[0]['SPJ_TANGGAL_MULAI']));
        $tgl_spj    = format_indo($tgl_spj_f);
    //$diff         = $spj_data[0]['diff'];
    } else {
        $tgl_spj_f  = date('Y-m-d', strtotime($spj_data[0]['tanggal_addendum']));
        $tgl_spj    = format_indo($tgl_spj_f);
        //$diff		= $spj_datar[0]['diff'];
    }
    
    $q = "select vendor_nama,paket_deskripsi2
            from tb_vendor a, tb_paket b, tb_mapping_vendor c 
            where a.vendor_id = c.vendor_id
            and c.paket_jenis = b.paket_jenis
            and b.paket_jenis = $paket_kerja
            and a.vendor_id = '$vendor'";
        $p=mysqli_query($mysqli, $q);
        while ($rows2=mysqli_fetch_array($p)) {
            $data2[]=$rows2;
        }

        $v = select_nama_vendor($vendor, $mysqli);
        $nama_vendor = $v[0][0];

        $p = select_desk_paket($paket_kerja, $mysqli);
        $paket_deskripsi = $p[0][0];
        
        $pecah_paket=substr($paket_deskripsi, 0, 7);
        if ($pecah_paket=="PAKET 1") {
            $pasal_pembayaran="Pasal 6";
            $tembusan_manager="Senior Manager Niaga";
        } else {
            $pasal_pembayaran="Pasal 14";
            $tembusan_manager="Senior Manager Teknik";
        }
        

        $ss = "select skki_tanggal from tb_skko_i where skki_no = '$skkio'";
        //echo $ss;
        $skki_search = mysqli_query($mysqli, $ss);
        while ($data_skki=mysqli_fetch_row($skki_search)) {
            $skki_data[] = $data_skki;
        }

        $tgl_skkio_f    = date('Y-m-d', strtotime($skki_data[0][0]));
        $tgl_skkio      = format_indo($tgl_skkio_f);
        $ao_ai = ($jenis_skk == 'SKKI') ? 'Investasi (SKKI)' : 'Operasi (SKKO)';
        $jabatan_vendor = get_jabatan_vend($vendor, $mysqli);
        $nilai_spj = number_format($spj);
        
//------------- Untuk QRCODE---------------
 
  $tempdir = "tempQRCODE/"; //Nama folder tempat menyimpan file qrcode
   if (!file_exists($tempdir)) { //Buat folder bername temp
    mkdir($tempdir);
   }

    $tempdirinsert="http://10.29.1.44/khs_2020/tempQRCODE/";
    //ambil logo
    $logopath="http://10.29.1.44/khs_2020/img/logo_pln2.png";

 //isi qrcode jika di scan
 $codeContents = "$no_spj";

 //simpan file qrcode
 QRcode::png($codeContents, $tempdir.'qrwithlogo.png', QR_ECLEVEL_H, 2.5, 2);

 // ambil file qrcode
 $QR = imagecreatefrompng($tempdir.'qrwithlogo.png');

 // memulai menggambar logo dalam file qrcode
$logo = imagecreatefromstring(file_get_contents($logopath));
 
 imagecolortransparent($logo, imagecolorallocatealpha($logo, 0, 0, 0, 127));
 imagealphablending($logo, false);
 imagesavealpha($logo, true);

 $QR_width = imagesx($QR);
 $QR_height = imagesy($QR);

 $logo_width = imagesx($logo);
 $logo_height = imagesy($logo);

 // Scale logo to fit in the QR Code
 $logo_qr_width = $QR_width/8;
 $scale = $logo_width/$logo_qr_width;
 $logo_qr_height = $logo_height/$scale;

 imagecopyresampled($QR, $logo, $QR_width/2.3, $QR_height/2.3, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
 //imagecopyresampled($QR, $QR_width/10.3, $QR_height/10.3, 0, 0, $logo_qr_width);

 // Simpan kode QR lagi, dengan logo di atasnya
 imagepng($QR, $tempdir.'qrwithlogo.png');
 $show_barcode='<img src="'.$tempdirinsert.'qrwithlogo.png'.'" style="width:120px" />';
 //echo '<img src="'.$tempdirinsert.'qrwithlogo.png'.'"  style="width:120px" />';

//--------------END QRCODE-----------------
        
  //  $template_file  = "template/spj_tmp_04.rtf";
    $template_file  = "template/spj_tmp_04.htm";
    $original       = array("bar_code","no_spj", "tgl_spj", "nama_vendor", "jabatan_vendor", "no_rks", "no_pen", "tgl_pen", "no_spp", "tgl_spp", "no_pjn", "tgl_pjn" ,"paket_deskripsi","nama_area","th_pjn","nama_vendor","paketdeskripsi","deskripsi","nilai_spj","terbilang_spj","day","terbilang_hari","tgl_akhir","ao_ai","no_anggaran","tgl_anggaran","pasal_pembayaran","no_pjn","tgl_pjn","dir_pkj","dir_lpg","nama_vendor","jabatan_vendor","dir_vendor","nama_manager","tembusan_manager");
    $new            = array($show_barcode,$no_spj, $tgl_spj, $nama_vendor,$jabatan_vendor,$no_rks,$no_pen,$tgl_pen,$no_spp,$tgl_spp,$no_pjn,$tgl_pjn,$paket_deskripsi ,$nama_area, date('Y', strtotime($tgl_pjn_f)),$nama_vendor,$paket_deskripsi,$deskripsi,$nilai_spj,ucwords(terbilang($spj)),$diff,terbilang($diff),$tgl_akhir,$ao_ai,$skkio,$tgl_skkio,$pasal_pembayaran,$no_pjn,$tgl_pjn,$dir_pkj,$dir_lpg,$nama_vendor,$jabatan_vendor,$dir_vendor,$nama_manager,$tembusan_manager);
    $file_download = "template/tmp_doc/spj_".str_replace(" ", "", str_replace('/', '_', $no_spj)).".doc";
    //echo $file_download;
    //8 Oktober 2019, tanggal spp diubah menjadi tanggal pjn
    $handle2 = fopen($file_download, "w");

    $handle = fopen($template_file, "r");
    $contents = fread($handle, filesize($template_file));
    $newphrase = str_replace($original, $new, $contents);

    fwrite($handle2, $newphrase);
    fclose($handle);
    fclose($handle2);


    // Otomatis membuka file hasil parser saat proses selesai
    echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=0;URL=$file_download>";
    echo '<script language="javascript">window.open("spj_view.php")</script>';




?>

