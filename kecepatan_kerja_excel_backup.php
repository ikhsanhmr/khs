<?php
    session_start();
    require_once "Excel/Excel.class.php";
    require_once "lib/config.php";
    
    $area = $_GET['area'];
    $vendor = $_GET['vendor'];
                            
    if ($area=="" && $vendor=="") {
        $sql="SELECT DISTINCT a.spj_no, 
							f.AREA_NAMA, 
							b.vendor_nama, 
							c.paket_deskripsi, 
							(datediff(CURDATE(),a.SPJ_TANGGAL_MULAI)/ datediff(IFNULL(a.SPJ_ADD_TANGGAL,a.SPJ_TANGGAL_AKHIR),a.SPJ_TANGGAL_MULAi)), 
							(select max(d.progress_value) from tb_progress d where d.spj_no = a.spj_no ) 
											FROM tb_spj a left join tb_vendor b on a.VENDOR_ID = b.VENDOR_ID
														  LEFT JOIN tb_paket c on a.PAKET_JENIS = c.PAKET_JENIS
														  LEFT JOIN tb_skko_i e on a.SKKI_NO = e.SKKI_NO
                                                          LEFT JOIN tb_area f on e.AREA_KODE = f.AREA_KODE";
    } elseif ($vendor=="" && $area!="") {
        $sql="SELECT DISTINCT a.spj_no,
							f.AREA_NAMA, 
							b.vendor_nama, 
							c.paket_deskripsi, 
							(datediff(CURDATE(),a.SPJ_TANGGAL_MULAI)/ datediff(IFNULL(a.SPJ_ADD_TANGGAL,a.SPJ_TANGGAL_AKHIR),a.SPJ_TANGGAL_MULAi)), 
							(select max(d.progress_value) from tb_progress d where d.spj_no = a.spj_no ) 
								FROM tb_spj a left join tb_vendor b on a.VENDOR_ID = b.VENDOR_ID
									LEFT JOIN tb_paket c on a.PAKET_JENIS = c.PAKET_JENIS
                                    LEFT JOIN tb_skko_i e on a.SKKI_NO = e.SKKI_NO
                                    LEFT JOIN tb_area f on e.AREA_KODE = f.AREA_KODE
                                      WHERE f.AREA_KODE = $area";
    } elseif ($area=="" && $vendor!="") {
        $sql="SELECT DISTINCT a.spj_no, 
							f.AREA_NAMA,
							b.vendor_nama, 
							c.paket_deskripsi, 
							(datediff(CURDATE(),a.SPJ_TANGGAL_MULAI)/ datediff(IFNULL(a.SPJ_ADD_TANGGAL,a.SPJ_TANGGAL_AKHIR),a.SPJ_TANGGAL_MULAi)),
							(select max(d.progress_value) from tb_progress d where d.spj_no = a.spj_no ) 
								FROM tb_spj a left join tb_vendor b on a.VENDOR_ID = b.VENDOR_ID
								  LEFT JOIN tb_paket c on a.PAKET_JENIS = c.PAKET_JENIS
                                  LEFT JOIN tb_skko_i e on a.SKKI_NO = e.SKKI_NO
                                  LEFT JOIN tb_area f on e.AREA_KODE = f.AREA_KODE
                        WHERE b.VENDOR_NAMA LIKE '%$vendor%'";
    } elseif ($area!="" && $vendor!="") {
        $sql="SELECT DISTINCT a.spj_no, f.AREA_NAMA,
											b.vendor_nama, 
											c.paket_deskripsi, 
											(datediff(CURDATE(),a.SPJ_TANGGAL_MULAI)/ datediff(IFNULL(a.SPJ_ADD_TANGGAL,a.SPJ_TANGGAL_AKHIR),a.SPJ_TANGGAL_MULAi)),
											(select max(d.progress_value) from tb_progress d where d.spj_no = a.spj_no ) 
											FROM tb_spj a left join tb_vendor b on a.VENDOR_ID = b.VENDOR_ID
														  LEFT JOIN tb_paket c on a.PAKET_JENIS = c.PAKET_JENIS
                                                          LEFT JOIN tb_skko_i e on a.SKKI_NO = e.SKKI_NO
                                                          LEFT JOIN tb_area f on e.AREA_KODE = f.AREA_KODE
                                            WHERE f.AREA_KODE = $area and b.VENDOR_NAMA LIKE '%$vendor%'";
    }
    
    //echo  $sql;
    $resultQuery=mysqli_query($mysqli, $sql);
    while ($rows=mysqli_fetch_row($resultQuery)) {
        $data[] = $rows;
    }
    
    $excel = new Excel();
    $excel->setHeader('kecepatan kerja.xls');
    $excel->BOF();
    
    //header
    $excel->writeLabel(0, 0, "No");
    $excel->writeLabel(0, 1, "No SPJ");
    $excel->writeLabel(0, 2, "Nama Area");
    $excel->writeLabel(0, 3, "Nama Vendor");
    $excel->writeLabel(0, 4, "Jenis Pekerjaan");
    $excel->writeLabel(0, 5, "Durasi Waktu");
    $excel->writeLabel(0, 6, "Progress Pekerjaan");
    
    for ($i=0;$i<count($data);$i++) {
        $current_no_spj = $data[$i][0];
        $current_nama_area = $data[$i][1];
        $current_nama_vendor = $data[$i][2];
        $current_jenis_pekerjaan = $data[$i][3];
        $current_durasi_waktu = $data[$i][4];
        $current_progress_pekerjaan =   ($data[$i][5] == "" ? 0 : $data[$i][5]) ;
        
        $a=$i+1;
        $b= floor($current_durasi_waktu*100);
        
        if ($b>100) {
            $b = 100;
        }
        $c= $current_progress_pekerjaan;
        
        $excel->writeLabel($a, 0, "$a");
        $excel->writeLabel($a, 1, "$current_no_spj");
        $excel->writeLabel($a, 2, "AREA $current_nama_area");
        $excel->writeLabel($a, 3, "$current_nama_vendor");
        $excel->writeLabel($a, 4, "$current_jenis_pekerjaan");
        $excel->writeLabel($a, 5, "$b%");
        $excel->writeLabel($a, 6, "$c%");
    }
    $excel->EOF();
 
    exit();
?>
				