<?php
    session_start();
    require_once "Excel/Excel.class.php";
    require_once "lib/config.php";
    $area = $_GET['area'];
    
    if ($area=="") {
        $sql="select a.skki_no, 
					d.area_nama, 
					a.skki_nilai,
					(select count(b.spj_no) from tb_spj b where b.skki_no = a.skki_no ) as jml_spj,
					(select sum(b.SPJ_ADD_NILAI) from tb_spj b where b.skki_no = a.skki_no) as total_spj,
					(select sum(b.pembayaran_nominal) from tb_pembayaran b, tb_spj c where b.spj_no = c.spj_no and c.skki_no = a.skki_no) as total_bayar,
					a.SKKI_NILAI - SKKI_TERPAKAI as sisa_skki 
						from tb_skko_i a, tb_area d
					where d.area_kode = a.area_kode
						order by d.area_kode, a.skki_no";
    } else {
        $sql="select a.skki_no, 
					d.area_nama, 
					a.skki_nilai,
					(select count(b.spj_no) from tb_spj b where b.skki_no = a.skki_no ) as jml_spj,
					(select sum(b.SPJ_ADD_NILAI) from tb_spj b where b.skki_no = a.skki_no) as total_spj,
					(select sum(b.pembayaran_nominal) from tb_pembayaran b, tb_spj c where b.spj_no = c.spj_no and c.skki_no = a.skki_no) as total_bayar,
					a.SKKI_NILAI - SKKI_TERPAKAI as sisa_skki
						from tb_skko_i a, tb_area d
					where d.area_kode = a.area_kode
                       	and d.AREA_KODE = $area
							order by d.area_kode, a.skki_no";
    }

    $resultQuery=mysqli_query($mysqli, $sql);
    while ($rows=mysqli_fetch_row($resultQuery)) {
        $data[] = $rows;
    }
    
    $excel = new Excel();
    $excel->setHeader('penyerapan anggaran.xls');
    $excel->BOF();
    
    //header
    $excel->writeLabel(0, 0, "No");
    $excel->writeLabel(0, 1, "Nama Area");
    $excel->writeLabel(0, 2, "No SKKO/SKKI");
    $excel->writeLabel(0, 3, "Nilai SKKO/I");
    $excel->writeLabel(0, 4, "Sisa SKKO/I");
    $excel->writeLabel(0, 5, "Jumlah SPJ Terbit");
    $excel->writeLabel(0, 6, "Total Nilai SPJ");
    $excel->writeLabel(0, 7, "Penyerapan SKKO/I");
    $excel->writeLabel(0, 8, "Pembayaran SPJ");
    $excel->writeLabel(0, 9, "Pembayaran SKKO/I");
    for ($i=0;$i<count($data);$i++) {
        $current_nama_area = $data[$i][1];
        $current_no_skko = $data[$i][0];
        $current_nominal_skko = $data[$i][2];
        $current_jumlah_spj = $data[$i][3];
        $current_nominal_spj = $data[$i][4];
        $current_persentasi_pembayaran_spj = $data[$i][5];
        
        $b=floor($current_nominal_spj/$current_nominal_skko*100);
        $nominal = number_format($current_nominal_spj);
        $nominal2 = number_format($current_nominal_skko);
        $sisa_skki = number_format($data[$i][6]);

        $a=$i+1;
        $c=floor($current_persentasi_pembayaran_spj/$current_nominal_spj*100);
        $d=floor($current_persentasi_pembayaran_spj/$current_nominal_skko*100);
        
        $excel->writeLabel($a, 0, "$a");
        $excel->writeLabel($a, 1, "$current_nama_area");
        $excel->writeLabel($a, 2, "$current_no_skko");
        $excel->writeLabel($a, 3, "Rp.$nominal2");
        $excel->writeLabel($a, 4, "Rp.$sisa_skki");
        $excel->writeLabel($a, 5, "$current_jumlah_spj");
        $excel->writeLabel($a, 6, "Rp.$nominal");
        $excel->writeLabel($a, 7, "$b%");
        $excel->writeLabel($a, 8, "$c%");
        $excel->writeLabel($a, 9, "$d%");
    }
    
    $excel->EOF();
 
    exit();
