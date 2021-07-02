<?php
include_once("lib/config.php");

    function select_skkio_no($area, $mysqli)
    {
        //$sql ="SELECT skki_no, keterangan FROM tb_skko_i a,tb_area b WHERE a.area_kode = b.area_kode AND b.area_kode = $area AND flag='0' AND TAHUN ='2018' AND SKKI_NO NOT LIKE 'dumping%'";
        //diubah tanggal 8 Februari 2019, permintaan dari Dumai (taufik) untuk menambah tahun 2019
        //$sql ="SELECT skki_no, keterangan FROM tb_skko_i a,tb_area b WHERE a.area_kode = b.area_kode AND b.area_kode = $area AND flag='0' AND (TAHUN ='2019' OR TAHUN='2019') AND SKKI_NO NOT LIKE 'dumping%'";
        $sql ="SELECT skki_no, keterangan FROM tb_skko_i a,tb_area b WHERE a.area_kode = b.area_kode AND b.area_kode = $area AND flag='0' AND (TAHUN ='2019' OR TAHUN='2020' OR TAHUN='2021') AND SKKI_NO NOT LIKE 'dumping%'";
        $resultQuery  = mysqli_query($mysqli, $sql);
        while ($rows = mysqli_fetch_row($resultQuery)) {
            $data[] = $rows;
        }
                

        return $data;
    }

    function select_paket_jenis($mysqli)
    {
        $sql ="SELECT paket_jenis, paket_deskripsi FROM tb_paket";
        $resultQuery  = mysqli_query($mysqli, $sql);
        while ($rows=mysqli_fetch_row($resultQuery)) {
            $data[] = $rows;
        }
        return $data;
    }
    
    function vendor_tersedia($mysqli, $var_paket_pekerjaan, $year)
    {
        $sql="select vendor_nama, fin_limit, fin_current, a.vendor_id
			from tb_vendor a, tb_fin_vendor b, tb_mapping_vendor c, tb_paket d
			where a.vendor_id = b.vendor_id
			and a.vendor_id = c.vendor_id
			and c.paket_jenis = d.paket_jenis
			and d.paket_jenis = $var_paket_pekerjaan
			and c.mapping_tahun = $year";
        $resultQuery  = mysqli_query($mysqli, $sql);
        while ($rows = mysqli_fetch_row($resultQuery)) {
            $data[] = $rows;
        }
        return $data;
    }

    function get_all_skki($area_kode, $mysqli)
    {
        $sql ="SELECT * FROM tb_skko_i WHERE area_kode = $area_kode";
        $resultQuery  = mysqli_query($mysqli, $sql);
        while ($rows = mysqli_fetch_array($resultQuery)) {
            $data[] = $rows;
        }
        return $data;
    }
    
    function select_vendor($mysqli)
    {
        $sql ="SELECT VENDOR_ID, VENDOR_NAMA FROM tb_vendor";
        $resultQuery = mysqli_query($mysqli, $sql);
        while ($rows = mysqli_fetch_array($resultQuery)) {
            $data[] = $rows;
        }
        return $data;
    }
    
    function select_spj_no($area_kode, $mysqli)
    {
        $sql ="SELECT a.spj_no FROM tb_spj a, tb_skko_i b WHERE a.skki_no = b.skki_no and b.area_kode = $area_kode";
        $resultQuery = mysqli_query($mysqli, $sql);
        while ($rows = mysqli_fetch_row($resultQuery)) {
            $data[] = $rows;
        }
        return $data;
    }
    
    function select_spj_no_termin($area_kode, $mysqli)
    {
        //$sql ="SELECT a.spj_no FROM tb_spj a, tb_skko_i b, tb_termin c WHERE a.skki_no = b.skki_no and a.spj_no = c.spj_no and b.area_kode = $area_kode and c.keterangan!='bayar 100' GROUP by c.spj_no"; di edit setelah -10 + 30
        $sql ="SELECT a.spj_no FROM tb_spj a, tb_skko_i b, tb_termin c WHERE a.skki_no = b.skki_no and a.spj_no = c.spj_no and a.area_kode = $area_kode and c.keterangan NOT IN ('bayar 90','bayar 100','bayar 130') GROUP by c.spj_no";
        $resultQuery = mysqli_query($mysqli, $sql);
        while ($rows = mysqli_fetch_row($resultQuery)) {
            $data[] = $rows;
        }
        return $data;
    }
    
    function select_spj_no_termins($area_kode, $mysqli)
    {
        $sql ="SELECT a.spj_no FROM tb_spj a, tb_skko_i b, tb_termin c WHERE a.skki_no = b.skki_no and a.spj_no = c.spj_no and a.area_kode = $area_kode and c.keterangan NOT IN ('bayar 90','bayar 100','bayar 130') GROUP by c.spj_no";
        $resultQuery = mysqli_query($mysqli, $sql);
        while ($rows = mysqli_fetch_row($resultQuery)) {
            $data[] = $rows;
        }
        return $data;
    }
    
    function select_progress($area_kode, $mysqli)
    {
        $sql ="SELECT a.spj_no FROM tb_spj a, tb_progress b WHERE a.spj_no = b.spj_no and a.area_kode = $area_kode";
        $resultQuery = mysqli_query($mysqli, $sql);
        while ($rows = mysqli_fetch_row($resultQuery)) {
            $data[] = $rows;
        }
        return $data;
    }
    
        function get_spj_by_area($area_kode, $mysqli)
        {
            $sql ="SELECT a.spj_no FROM tb_spj a WHERE a.area_kode = $area_kode";
            $resultQuery = mysqli_query($mysqli, $sql);
            while ($rows = mysqli_fetch_row($resultQuery)) {
                $data[] = $rows;
            }
            return $data;
        }

    function select_spj_no_paket($area_kode, $mysqli)
    {
        $sql ="SELECT a.spj_no, a.paket_jenis FROM tb_spj a, tb_skko_i b WHERE a.skki_no = b.skki_no and b.area_kode = $area_kode";
        $resultQuery = mysqli_query($mysqli, $sql);
        while ($rows = mysqli_fetch_row($resultQuery)) {
            $data[] = $rows;
        }
        return $data;
    }

    function select_nilai_add($spj_no, $area_kode, $mysqli)
    {
        //$sql ="SELECT ((A.PROGRESS_VALUE/100)*B.SPJ_ADD_NILAI) from tb_progress A, tb_spj B where A.SPJ_NO=B.SPJ_NO and A.SPJ_NO='$spj_no' ORDER BY A.PROGRESS_VALUE DESC LIMIT 1 ";
        //$sql="SELECT (C.PEMBAYARAN_NOMINAL-((A.PROGRESS_VALUE/100)*B.SPJ_ADD_NILAI)) from tb_progress A, tb_spj B, tb_pembayaran C where A.SPJ_NO=B.SPJ_NO=C.SPJ_NO and A.SPJ_NO='$spj_no' ORDER BY A.PROGRESS_VALUE DESC LIMIT 1";
        //echo $sql;
        $sql ="SELECT spj_add_nilai FROM `tb_spj` WHERE SPJ_NO ='$spj_no' and area_kode = $area_kode";
        $resultQuery = mysqli_query($mysqli, $sql);
        while ($rows = mysqli_fetch_row($resultQuery)) {
            $data[] = $rows;
        }
        return $data;
    }
    
    function select_nilai_adds($spj_no, $mysqli)
    {
        //$sql ="SELECT ((A.PROGRESS_VALUE/100)*B.SPJ_ADD_NILAI) from tb_progress A, tb_spj B where A.SPJ_NO=B.SPJ_NO and A.SPJ_NO='$spj_no' ORDER BY A.PROGRESS_VALUE DESC LIMIT 1 ";
        //$sql="SELECT (C.PEMBAYARAN_NOMINAL-((A.PROGRESS_VALUE/100)*B.SPJ_ADD_NILAI)) from tb_progress A, tb_spj B, tb_pembayaran C where A.SPJ_NO=B.SPJ_NO=C.SPJ_NO and A.SPJ_NO='$spj_no' ORDER BY A.PROGRESS_VALUE DESC LIMIT 1";
        //echo $sql;
        $sql ="SELECT spj_add_nilai FROM `tb_spj` WHERE SPJ_NO ='$spj_no'";
        $resultQuery = mysqli_query($mysqli, $sql);
        while ($rows = mysqli_fetch_row($resultQuery)) {
            $data[] = $rows;
        }
        return $data;
    }
    
    function select_nilai_add_keu($spj_no, $mysqli)
    {
        //$sql ="SELECT ((A.PROGRESS_VALUE/100)*B.SPJ_ADD_NILAI) from tb_progress A, tb_spj B where A.SPJ_NO=B.SPJ_NO and A.SPJ_NO='$spj_no' ORDER BY A.PROGRESS_VALUE DESC LIMIT 1 ";
        //$sql="SELECT (C.PEMBAYARAN_NOMINAL-((A.PROGRESS_VALUE/100)*B.SPJ_ADD_NILAI)) from tb_progress A, tb_spj B, tb_pembayaran C where A.SPJ_NO=B.SPJ_NO=C.SPJ_NO and A.SPJ_NO='$spj_no' ORDER BY A.PROGRESS_VALUE DESC LIMIT 1";
        //echo $sql;
        $sql ="SELECT spj_add_nilai FROM `tb_spj` WHERE SPJ_NO ='$spj_no'";
        $resultQuery = mysqli_query($mysqli, $sql);
        while ($rows = mysqli_fetch_row($resultQuery)) {
            $data[] = $rows;
        }
        return $data;
    }
    
    function insert_tb_spj($get_var_no_spj, $get_var_vendor, $get_var_no_skkio, $get_var_paket_pekerjaan, $get_var_nilai_spj, $get_var_mulai_berlaku, $get_var_akhir_berlaku, $get_var_deskripsi_pekerjaan, $mysqli)
    {
        $sql="INSERT INTO `tb_spj` VALUES ($get_var_no_spj, $get_var_vendor, '$get_var_no_skkio', $get_var_paket_pekerjaan, $get_var_nilai_spj, '$get_var_mulai_berlaku', '$get_var_akhir_berlaku', $get_var_deskripsi_pekerjaan);";
        $resultQuery = mysqli_query($mysqli, $sql);

        return $resultQuery;
    }

    function select_area($mysqli)
    {
        $sql ="SELECT area_kode, area_nama FROM tb_area ORDER BY AREA_KODE";
        $resultQuery = mysqli_query($mysqli, $sql);
        while ($rows = mysqli_fetch_row($resultQuery)) {
            $data[] = $rows;
        }
        return $data;
    }

    function select_area_by_code($kode, $mysqli)
    {
        $sql ="SELECT area_kode, area_nama FROM tb_area where area_kode = $kode";
        $resultQuery = mysqli_query($mysqli, $sql);
        while ($rows = mysqli_fetch_row($resultQuery)) {
            $data[] = $rows;
        }
        return $data;
    }
    
    function select_role($mysqli)
    {
        $sql ="SELECT * FROM tb_role ORDER BY role_id";
        $resultQuery = mysqli_query($mysqli, $sql);
        while ($rows = mysqli_fetch_row($resultQuery)) {
            $data[] = $rows;
        }
        return $data;
    }
    function select_role_filter($mysqli)
    {
        $sql ="SELECT * FROM tb_role where role_id not in (0,1, 6,7,8,9,10,11) ORDER BY role_id";
        $resultQuery = mysqli_query($mysqli, $sql);
        while ($rows = mysqli_fetch_row($resultQuery)) {
            $data[] = $rows;
        }
        return $data;
    }
    
    function select_penilaian_deskripsi($mysqli)
    {
        $sql ="SELECT * FROM penilaian_deskripsi";
        $resultQuery = mysqli_query($mysqli, $sql);
        while ($rows = mysqli_fetch_row($resultQuery)) {
            $data[] = $rows;
        }
        return $data;
    }
    
    function approval_query($offset, $rowsperpage, $mysqli)
    {
        $sql="SELECT a.SPJ_NO, e.AREA_NAMA, c.VENDOR_NAMA, d.PAKET_DESKRIPSI,a.SPJ_STATUS
				FROM tb_spj a, tb_skko_i b, tb_vendor c, tb_paket d, tb_area e
				WHERE a.SKKI_NO = b.SKKI_NO
				AND a.VENDOR_ID = c.VENDOR_ID
				AND  d.PAKET_JENIS = a.PAKET_JENIS
				AND  b.AREA_KODE = e.AREA_KODE
				AND a.SPJ_STATUS = 0
				LIMIT $offset, $rowsperpage";
                
        $resultQuery = mysqli_query($mysqli, $sql);
        while ($rows = mysqli_fetch_row($resultQuery)) {
            $data[] = $rows;
        }
        return $data;
    }
    
    function approve($spj, $mysqli)
    {
        $sql ="UPDATE tb_spj 
				SET SPJ_STATUS = 1
				WHERE SPJ_NO = '$spj'
				";
        $resultQuery = mysqli_query($mysqli, $sql);
        if ($resultQuery == 0) {
            echo '<script language="javascript">alert("Approval Gagal")</script>';
        } else {
            echo '<script language="javascript">alert("Approval Berhasil")</script>';
        }
    }
    
    function reject($spj, $mysqli)
    {
        $sql ="UPDATE tb_spj 
				SET SPJ_STATUS = 2
				WHERE SPJ_NO = '$spj'
				";
        $resultQuery = mysqli_query($mysqli, $sql);
        if ($resultQuery == 0) {
            echo '<script language="javascript">alert("Reject Gagal")</script>';
        } else {
            echo '<script language="javascript">alert("Reject Berhasil")</script>';
        }
    }

    function select_all_area($mysqli)
    {
        $sql ="SELECT * FROM tb_area";
        $resultQuery = mysqli_query($mysqli, $sql);
        while ($rows = mysqli_fetch_row($resultQuery)) {
            $data[] = $rows;
        }
        return $data;
    }

    function select_nama_area($area_kode, $mysqli)
    {
        $sql ="SELECT area_nama FROM tb_area where area_kode='$area_kode'";
        $resultQuery = mysqli_query($mysqli, $sql);
        while ($rows = mysqli_fetch_row($resultQuery)) {
            $data[] = $rows;
        }
        return $data;
    }

    function select_nama_vendor($vendor_id, $mysqli)
    {
        $sql ="SELECT vendor_nama FROM tb_vendor where vendor_id ='$vendor_id'";
        $resultQuery = mysqli_query($mysqli, $sql);
        while ($rows = mysqli_fetch_row($resultQuery)) {
            $data[] = $rows;
        }
        return $data;
    }

    function select_desk_paket($paket_id, $mysqli)
    {
        $sql ="SELECT PAKET_DESKRIPSI2 FROM tb_paket where paket_jenis ='$paket_id'";
        //echo $sql;
        $resultQuery = mysqli_query($mysqli, $sql);
        while ($rows = mysqli_fetch_row($resultQuery)) {
            $data[] = $rows;
        }
        return $data;
    }

        function get_desk_paket($paket_jenis, $mysqli)
        {
            $sql ="SELECT PAKET_DESKRIPSI FROM tb_paket where paket_jenis ='$paket_jenis'";
            $resultQuery = mysqli_query($mysqli, $sql);
            while ($rows = mysqli_fetch_row($resultQuery)) {
                $data[] = $rows;
            }
            return $data;
        }

    function select_perijinan($mysqli)
    {
        $sql ="SELECT * FROM tb_ijin";
        $resultQuery = mysqli_query($mysqli, $sql);
        while ($rows=mysqli_fetch_array($resultQuery)) {
            $data[] = $rows;
        }
        return $data;
    }

    function perijinan_add($var_spj_no, $var_surat_ijin_no, $var_tgl_surat, $var_pekerjaan, $var_kota_adm, $var_lokasi, $mysqli)
    {
        $sql="INSERT INTO `tb_ijin`(`spj_no`, `surat_ijin_no`, `tgl_surat`, `pekerjaan`, `kota_adm`, `lokasi`)
		VALUES ('$var_spj_no', '$var_surat_ijin_no', '$var_tgl_surat', '$var_pekerjaan', '$var_kota_adm', '$var_lokasi')";
        //echo $sql;
        $resultQuery = mysqli_query($mysqli, $sql);
        return $resultQuery;
    }

    function ba_survey_add($var_surat_ijin_no, $var_tgl_survey, $var_hasil_survey, $var_status, $mysqli)
    {
        $sql = "UPDATE `tb_ijin` SET `tgl_survey`='$var_tgl_survey',`hasil_survey`='$var_hasil_survey' ,`info_01`='$var_status' WHERE surat_ijin_no='$var_surat_ijin_no' ";
        //echo $sql;
        $resultQuery = mysqli_query($mysqli, $sql);
        return $resultQuery;
    }



    function skrd_add($var_surat_ijin_no, $var_tgl_terbit_skrd, $var_biaya_retribusi, $mysqli)
    {
        $sql = "UPDATE `tb_ijin` SET `tgl_terbit_skrd`='$var_tgl_terbit_skrd',`biaya_retribusi`='$var_biaya_retribusi' WHERE surat_ijin_no='$var_surat_ijin_no' ";
        //echo $sql;
        $resultQuery = mysqli_query($mysqli, $sql);
        return $resultQuery;
    }

    function bayar_retribusi_add($var_surat_ijin_no, $var_tgl_bayar_retrib, $mysqli)
    {
        $sql = "UPDATE `tb_ijin` SET `tgl_bayar_retribusi`='$var_tgl_bayar_retrib' WHERE surat_ijin_no='$var_surat_ijin_no' ";
        //echo $sql;
        $resultQuery = mysqli_query($mysqli, $sql);
        return $resultQuery;
    }

    function serah_dok_add($var_spj_no, $var_tgl_serah, $var_jum_dokumen, $var_keterangan, $var_status, $mysqli)
    {
        $sql = "INSERT INTO `tb_dokumen`(`spj_no`, `tgl_serah`, `jumlah_dok`, `keterangan`,`info_01`)
		VALUES ('$var_spj_no', '$var_tgl_serah', '$var_jum_dokumen', '$var_keterangan', '$var_status')";
        echo $sql;
        $resultQuery = mysqli_query($mysqli, $sql);
        return $resultQuery;
    }

    function skki_upload($skki_jenis, $skki_no, $area_kode, $skki_nilai, $skki_tgl, $paket, $revisi, $flag, $tahun, $mysqli)
    {
        $sql="INSERT INTO `tb_skko_i`(`SKKI_JENIS`, `SKKI_NO`, `AREA_KODE`, `SKKI_NILAI`, `SKKI_TANGGAL`, `paket_pekerjaan`, `revisi`, `flag`, `tahun`) VALUES ('$skki_jenis',
		'$skki_no',$area_kode,$skki_nilai,'$skki_tgl','$paket','$revisi',$flag,$tahun)";
        $resultQuery = mysqli_query($mysqli, $sql);
        //echo $sql;
        return $resultQuery;
    }

    function search_spj_by_no_surat_ptsp($var_surat_ijin_no, $mysqli)
    {
        $sql = "SELECT SPJ_NO FROM TB_IJIN WHERE surat_ijin_no ='$var_surat_ijin_no'";
        $resultQuery = mysqli_query($mysqli, $sql);
        while ($rows = mysqli_fetch_row($resultQuery)) {
            $data[] = $rows;
        }
        return $data;
    }

    function flag_revisi($var_spj_no, $var_status, $mysqli)
    {
        $sql = "UPDATE `tb_dokumen` SET `info_01`='$var_status' WHERE `spj_no`='$var_spj_no' ";
        echo $sql;
        $resultQuery = mysqli_query($mysqli, $sql);
        return $resultQuery;
    }


    function pagu_kontrak_edit($var_pagu_kontrak, $var_id_vendor, $var_id_paket, $mysqli)
    {
        $sql = "UPDATE `tb_pagu_kontrak` SET `PAGU_KONTRAK`=$var_pagu_kontrak WHERE VENDOR_ID=$var_id_vendor AND PAKET_JENIS = $var_id_paket";
        //echo $sql;
        $resultQuery = mysqli_query($mysqli, $sql);
        return $resultQuery;
    }

    function pagu_rating_edit($var_rating, $var_limit, $var_id_vendor, $mysqli)
    {
        $sql = "UPDATE `tb_fin_vendor` SET `RATING_LAPORAN_AUDIT`='$var_rating',`FIN_LIMIT`='$var_limit' WHERE VENDOR_ID='$var_id_vendor'";
        //echo $sql;
        $resultQuery = mysqli_query($mysqli, $sql);
        return $resultQuery;
    }

    function get_direksi($vendor_id, $mysqli)
    {
        $query = "SELECT DIREKSI_VENDOR from tb_vendor WHERE VENDOR_ID = $vendor_id";
        $resultQuery = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_array($resultQuery);
        return $row['DIREKSI_VENDOR'];
    }

    function get_no_pjn($vendor_id, $paket, $mysqli)
    {
        $query = "SELECT NO_PJN from tb_pagu_kontrak WHERE VENDOR_ID = $vendor_id AND PAKET_JENIS = $paket";
        $resultQuery = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_array($resultQuery);
        return $row['NO_PJN'];
    }

    function get_tgl_pjn($vendor_id, $paket, $mysqli)
    {
        $query = "SELECT TGL_PJN from tb_pagu_kontrak WHERE VENDOR_ID = $vendor_id AND PAKET_JENIS = $paket";
        $resultQuery = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_array($resultQuery);
        return $row['TGL_PJN'];
    }

    function get_email_vendor($vendor_id, $mysqli)
    {
        $query = "SELECT EMAIL from tb_vendor WHERE VENDOR_ID = $vendor_id";
        $resultQuery = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_array($resultQuery);
        return $row['EMAIL'];
    }

    function get_email_vendor_2($vendor_id, $mysqli)
    {
        $query = "SELECT EMAIL from tb_vendor WHERE VENDOR_ID = $vendor_id";
        $resultQuery = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_array($resultQuery);
        return $row['EMAIL_2'];
    }

    function get_email_by_username($username, $mysqli)
    {
        $query = "SELECT email from tb_user WHERE username = '$username'";
        $resultQuery = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_array($resultQuery);
        return $row['email'];
    }

    function get_email_by_jabatan($area, $jabatan, $mysqli)
    {
        $query = "SELECT email from tb_user WHERE AREA_KODE = $area and jabatan = '$jabatan'";
        $resultQuery = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_array($resultQuery);
        //echo $row['email'];
        return $row['email'];
    }

    function get_no_spp($vendor_id, $paket, $mysqli)
    {
        $query = "SELECT NO_SPP from tb_pagu_kontrak WHERE VENDOR_ID = $vendor_id AND PAKET_JENIS = $paket";
        $resultQuery = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_array($resultQuery);
        return $row['NO_SPP'];
    }

    function get_tgl_spp($vendor_id, $paket, $mysqli)
    {
        $query = "SELECT TGL_SPP from tb_pagu_kontrak WHERE VENDOR_ID = $vendor_id AND PAKET_JENIS = $paket";
        $resultQuery = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_array($resultQuery);
        return $row['TGL_SPP'];
    }

    function get_no_penawaran($vendor_id, $paket, $mysqli)
    {
        $query = "SELECT NO_PENAWARAN from tb_pagu_kontrak WHERE VENDOR_ID = $vendor_id AND PAKET_JENIS = $paket";
        $resultQuery = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_array($resultQuery);
        return $row['NO_PENAWARAN'];
    }

    function get_tgl_penawaran($vendor_id, $paket, $mysqli)
    {
        $query = "SELECT TGL_PENAWARAN from tb_pagu_kontrak WHERE VENDOR_ID = $vendor_id AND PAKET_JENIS = $paket";
        $resultQuery = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_array($resultQuery);
        //echo  $row['TGL_PENAWARAN'];
        return $row['TGL_PENAWARAN'];
    }

    function get_no_rks($vendor_id, $paket, $mysqli)
    {
        $query = "SELECT NO_RKS from tb_pagu_kontrak WHERE VENDOR_ID = $vendor_id AND PAKET_JENIS = $paket";
        $resultQuery = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_array($resultQuery);
        return $row['NO_RKS'];
    }

    function get_tgl_rks($vendor_id, $paket, $mysqli)
    {
        $query = "SELECT TGL_RKS from tb_pagu_kontrak WHERE VENDOR_ID = $vendor_id AND PAKET_JENIS = $paket";
        $resultQuery = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_array($resultQuery);
        return $row['TGL_RKS'];
    }

    function get_jenis_skk($skk, $mysqli)
    {
        $query = "SELECT SKKI_JENIS from tb_skko_i WHERE SKKI_NO = '$skk'";
        $resultQuery = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_array($resultQuery);
        return $row['SKKI_JENIS'];
    }

    function get_password($username, $mysqli)
    {
        $query = "SELECT PASSWORD from tb_user WHERE USERNAME = '$username'";
        $resultQuery = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_array($resultQuery);
        return $row['PASSWORD'];
    }

    function get_email($username, $mysqli)
    {
        $query = "SELECT email from tb_user WHERE USERNAME = '$username'";
        $resultQuery = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_array($resultQuery);
        return $row['email'];
    }

    function get_jabatan_vend($vendor_id, $mysqli)
    {
        $query = "SELECT jabatan from tb_vendor WHERE vendor_id = $vendor_id";
        $resultQuery = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_array($resultQuery);
        return $row['jabatan'];
    }
