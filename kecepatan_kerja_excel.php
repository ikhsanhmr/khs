<?php
    session_start();
    require_once "Excel/Excel.class.php";
    require_once "lib/config.php";
    
    $area = $_GET['area'];
    $vendor = $_GET['vendor'];
                            
    if ($area=="" && $vendor=="") {
        /*$sql="SELECT DISTINCT a.spj_no,
                            f.AREA_NAMA,
                            b.vendor_nama,
                            c.paket_deskripsi,
                            (datediff(CURDATE(),a.SPJ_TANGGAL_MULAI)/ datediff(IFNULL(a.SPJ_ADD_TANGGAL,a.SPJ_TANGGAL_AKHIR),a.SPJ_TANGGAL_MULAi)),
                            (select max(d.progress_value) from tb_progress d where d.spj_no = a.spj_no )
                                            FROM tb_spj a left join tb_vendor b on a.VENDOR_ID = b.VENDOR_ID
                                                          LEFT JOIN tb_paket c on a.PAKET_JENIS = c.PAKET_JENIS
                                                          LEFT JOIN tb_skko_i e on a.SKKI_NO = e.SKKI_NO
                                                          LEFT JOIN tb_area f on e.AREA_KODE = f.AREA_KODE";*/
                                                          
        $sql="SELECT A.SPJ_NO, C.VENDOR_NAMA, A.SKKI_NO as PRK_NO, S.keterangan, z.PAKET_DESKRIPSI, A.SPJ_DESKRIPSI, A.SPJ_NILAI, A.SPJ_ADD_NILAI, 
				A.SPJ_TANGGAL_MULAI, A.SPJ_TANGGAL_AKHIR, A.SPJ_ADD_TANGGAL, (datediff(CURDATE(),a.SPJ_TANGGAL_MULAI)/ datediff(IFNULL(A.SPJ_ADD_TANGGAL,A.SPJ_TANGGAL_AKHIR),A.SPJ_TANGGAL_MULAI)) 
				AS DURASI_WAKTU, A.AREA_KODE, E.AREA_NAMA , MAX(D.PROGRESS_VALUE) AS PROGRESS_PEKERJAAN, B.PEMBAYARAN_NOMINAL, B.INPUT_PAYMENT_DATE, B.PEMBAYARAN_BASTP FROM tb_spj A LEFT JOIN 
				tb_pembayaran B ON A.SPJ_NO=B.SPJ_NO LEFT JOIN tb_progress D ON A.SPJ_NO=D.SPJ_NO LEFT JOIN tb_area E on A.AREA_KODE=E.AREA_KODE LEFT JOIN tb_vendor C ON A.VENDOR_ID=C.VENDOR_ID 
				LEFT JOIN tb_paket Z on A.PAKET_JENIS = Z.PAKET_JENIS LEFT JOIN tb_skko_i S on A.SKKI_NO=S.SKKI_NO GROUP BY A.SPJ_NO ORDER BY B.PEMBAYARAN_NOMINAL desc";
    } elseif ($vendor=="" && $area!="") {
        /*$sql="SELECT DISTINCT a.spj_no,
                            f.AREA_NAMA,
                            b.vendor_nama,
                            c.paket_deskripsi,
                            (datediff(CURDATE(),a.SPJ_TANGGAL_MULAI)/ datediff(IFNULL(a.SPJ_ADD_TANGGAL,a.SPJ_TANGGAL_AKHIR),a.SPJ_TANGGAL_MULAi)),
                            (select max(d.progress_value) from tb_progress d where d.spj_no = a.spj_no )
                                FROM tb_spj a left join tb_vendor b on a.VENDOR_ID = b.VENDOR_ID
                                    LEFT JOIN tb_paket c on a.PAKET_JENIS = c.PAKET_JENIS
                                    LEFT JOIN tb_skko_i e on a.SKKI_NO = e.SKKI_NO
                                    LEFT JOIN tb_area f on e.AREA_KODE = f.AREA_KODE
                                      WHERE f.AREA_KODE = $area";*/
                                      
        $sql="SELECT A.SPJ_NO, C.VENDOR_NAMA, A.SKKI_NO as PRK_NO, S.keterangan, z.PAKET_DESKRIPSI, A.SPJ_DESKRIPSI, A.SPJ_NILAI, A.SPJ_ADD_NILAI, 
				A.SPJ_TANGGAL_MULAI, A.SPJ_TANGGAL_AKHIR, A.SPJ_ADD_TANGGAL, (datediff(CURDATE(),a.SPJ_TANGGAL_MULAI)/ datediff(IFNULL(A.SPJ_ADD_TANGGAL,A.SPJ_TANGGAL_AKHIR),A.SPJ_TANGGAL_MULAI)) 
				AS DURASI_WAKTU, A.AREA_KODE, E.AREA_NAMA , MAX(D.PROGRESS_VALUE) AS PROGRESS_PEKERJAAN, B.PEMBAYARAN_NOMINAL, B.INPUT_PAYMENT_DATE, B.PEMBAYARAN_BASTP FROM tb_spj A LEFT JOIN 
				tb_pembayaran B ON A.SPJ_NO=B.SPJ_NO LEFT JOIN tb_progress D ON A.SPJ_NO=D.SPJ_NO LEFT JOIN tb_area E on A.AREA_KODE=E.AREA_KODE LEFT JOIN tb_vendor C ON A.VENDOR_ID=C.VENDOR_ID 
				LEFT JOIN tb_paket Z on A.PAKET_JENIS = Z.PAKET_JENIS LEFT JOIN tb_skko_i S on A.SKKI_NO=S.SKKI_NO WHERE A.AREA_KODE = $area GROUP BY A.SPJ_NO ORDER BY B.PEMBAYARAN_NOMINAL desc";
    } elseif ($area=="" && $vendor!="") {
        /*$sql="SELECT DISTINCT a.spj_no,
                            f.AREA_NAMA,
                            b.vendor_nama,
                            c.paket_deskripsi,
                            (datediff(CURDATE(),a.SPJ_TANGGAL_MULAI)/ datediff(IFNULL(a.SPJ_ADD_TANGGAL,a.SPJ_TANGGAL_AKHIR),a.SPJ_TANGGAL_MULAi)),
                            (select max(d.progress_value) from tb_progress d where d.spj_no = a.spj_no )
                                FROM tb_spj a left join tb_vendor b on a.VENDOR_ID = b.VENDOR_ID
                                  LEFT JOIN tb_paket c on a.PAKET_JENIS = c.PAKET_JENIS
                                  LEFT JOIN tb_skko_i e on a.SKKI_NO = e.SKKI_NO
                                  LEFT JOIN tb_area f on e.AREA_KODE = f.AREA_KODE
                        WHERE b.VENDOR_NAMA LIKE '%$vendor%'";*/
                        
        $sql="SELECT A.SPJ_NO, C.VENDOR_NAMA, A.SKKI_NO as PRK_NO, S.keterangan, z.PAKET_DESKRIPSI, A.SPJ_DESKRIPSI, A.SPJ_NILAI, A.SPJ_ADD_NILAI, 
				A.SPJ_TANGGAL_MULAI, A.SPJ_TANGGAL_AKHIR, A.SPJ_ADD_TANGGAL, (datediff(CURDATE(),a.SPJ_TANGGAL_MULAI)/ datediff(IFNULL(A.SPJ_ADD_TANGGAL,A.SPJ_TANGGAL_AKHIR),A.SPJ_TANGGAL_MULAI)) 
				AS DURASI_WAKTU, A.AREA_KODE, E.AREA_NAMA , MAX(D.PROGRESS_VALUE) AS PROGRESS_PEKERJAAN, B.PEMBAYARAN_NOMINAL, B.INPUT_PAYMENT_DATE, B.PEMBAYARAN_BASTP FROM tb_spj A LEFT JOIN 
				tb_pembayaran B ON A.SPJ_NO=B.SPJ_NO LEFT JOIN tb_progress D ON A.SPJ_NO=D.SPJ_NO LEFT JOIN tb_area E on A.AREA_KODE=E.AREA_KODE LEFT JOIN tb_vendor C ON A.VENDOR_ID=C.VENDOR_ID 
				LEFT JOIN tb_paket Z on A.PAKET_JENIS = Z.PAKET_JENIS LEFT JOIN tb_skko_i S on A.SKKI_NO=S.SKKI_NO  WHERE C.VENDOR_NAMA LIKE '%$vendor%' GROUP BY A.SPJ_NO ORDER BY B.PEMBAYARAN_NOMINAL desc";
    } elseif ($area!="" && $vendor!="") {
        /*$sql="SELECT DISTINCT a.spj_no, f.AREA_NAMA,
                                            b.vendor_nama,
                                            c.paket_deskripsi,
                                            (datediff(CURDATE(),a.SPJ_TANGGAL_MULAI)/ datediff(IFNULL(a.SPJ_ADD_TANGGAL,a.SPJ_TANGGAL_AKHIR),a.SPJ_TANGGAL_MULAi)),
                                            (select max(d.progress_value) from tb_progress d where d.spj_no = a.spj_no )
                                            FROM tb_spj a left join tb_vendor b on a.VENDOR_ID = b.VENDOR_ID
                                                          LEFT JOIN tb_paket c on a.PAKET_JENIS = c.PAKET_JENIS
                                                          LEFT JOIN tb_skko_i e on a.SKKI_NO = e.SKKI_NO
                                                          LEFT JOIN tb_area f on e.AREA_KODE = f.AREA_KODE
                                            WHERE f.AREA_KODE = $area and b.VENDOR_NAMA LIKE '%$vendor%'";*/
        

        $sql="SELECT A.SPJ_NO, C.VENDOR_NAMA, A.SKKI_NO as PRK_NO, S.keterangan, z.PAKET_DESKRIPSI, A.SPJ_DESKRIPSI, A.SPJ_NILAI, A.SPJ_ADD_NILAI, 
				A.SPJ_TANGGAL_MULAI, A.SPJ_TANGGAL_AKHIR, A.SPJ_ADD_TANGGAL, (datediff(CURDATE(),a.SPJ_TANGGAL_MULAI)/ datediff(IFNULL(A.SPJ_ADD_TANGGAL,A.SPJ_TANGGAL_AKHIR),A.SPJ_TANGGAL_MULAI)) 
				AS DURASI_WAKTU, A.AREA_KODE, E.AREA_NAMA , MAX(D.PROGRESS_VALUE) AS PROGRESS_PEKERJAAN, B.PEMBAYARAN_NOMINAL, B.INPUT_PAYMENT_DATE, B.PEMBAYARAN_BASTP FROM tb_spj A LEFT JOIN 
				tb_pembayaran B ON A.SPJ_NO=B.SPJ_NO LEFT JOIN tb_progress D ON A.SPJ_NO=D.SPJ_NO LEFT JOIN tb_area E on A.AREA_KODE=E.AREA_KODE LEFT JOIN tb_vendor C ON A.VENDOR_ID=C.VENDOR_ID 
				LEFT JOIN tb_paket Z on A.PAKET_JENIS = Z.PAKET_JENIS LEFT JOIN tb_skko_i S on A.SKKI_NO=S.SKKI_NO  WHERE A.AREA_KODE = $area AND C.VENDOR_NAMA LIKE '%$vendor%' GROUP BY A.SPJ_NO ORDER BY B.PEMBAYARAN_NOMINAL desc";
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
    $excel->writeLabel(0, 7, "No PRK");
    $excel->writeLabel(0, 8, "Keterangan PRK");
    $excel->writeLabel(0, 9, "Uraian Pekerjaan SPBJ");
    $excel->writeLabel(0, 10, "Rp SPBJ");
    $excel->writeLabel(0, 11, "Add Rp SPBJ");
    $excel->writeLabel(0, 12, "Tgl Mulai SPBJ");
    $excel->writeLabel(0, 13, "Tgl Akhir SPBJ");
    $excel->writeLabel(0, 14, "Add Tgl Akhir SPBJ");
    $excel->writeLabel(0, 15, "Rp Bayar SPBJ");
    $excel->writeLabel(0, 16, "Tgl Bayar SPBJ");
    $excel->writeLabel(0, 17, "BA Bayar SPBJ");
    
    for ($i=0;$i<count($data);$i++) {
        $current_no_spj = $data[$i][0];
        $current_nama_area = $data[$i][13];
        $current_nama_vendor = $data[$i][1];
        $current_jenis_pekerjaan = $data[$i][4];
        $current_durasi_waktu = $data[$i][10];
        $current_progress_pekerjaan =   ($data[$i][14] == "" ? 0 : $data[$i][14]) ;
        $current_no_prk = $data[$i][2];
        $current_keterangan_prk = $data[$i][3];
        $current_uraian_pekerjaan = $data[$i][5];
        $current_rp_spbj = $data[$i][6];
        $current_add_rp_spbj = $data[$i][7];
        $current_tgl_mulai_spbj = $data[$i][8];
        $current_tgl_akhir_spbj = $data[$i][9];
        $current_add_tgl_akhir_spbj = $data[$i][10];
        $current_rp_bayar_spbj = $data[$i][15];
        $current_tgl_bayar_spbj = $data[$i][16];
        $current_ba_bayar = $data[$i][17];
        
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
        $excel->writeLabel($a, 7, "$current_no_prk");
        $excel->writeLabel($a, 8, "$current_keterangan_prk");
        $excel->writeLabel($a, 9, "$current_uraian_pekerjaan");
        $excel->writeLabel($a, 10, "$current_rp_spbj");
        $excel->writeLabel($a, 11, "$current_add_rp_spbj");
        $excel->writeLabel($a, 12, "$current_tgl_mulai_spbj");
        $excel->writeLabel($a, 13, "$current_tgl_akhir_spbj");
        $excel->writeLabel($a, 14, "$current_add_tgl_akhir_spbj");
        $excel->writeLabel($a, 15, "$current_rp_bayar_spbj");
        $excel->writeLabel($a, 16, "$current_tgl_bayar_spbj");
        $excel->writeLabel($a, 17, "$current_ba_bayar");
    }
    $excel->EOF();
 
    exit();
?>
				