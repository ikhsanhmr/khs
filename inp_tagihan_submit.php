<?php
    session_start();
    include_once("lib/config.php");
    include_once("lib/check.php");
    $get_var_no_spj = $_POST['var_no_spj'];
    $get_var_nominal_tagihan = str_replace(",", "", $_POST['var_nominal_tagihan']);
    $get_var_tanggal_bayar = date('Y-m-d', strtotime($_POST['var_tanggal_bayar']));
    $get_var_no_bastp = $_POST['var_no_bastp'];
    $get_var_deskripsi = $_POST['var_deskripsi'];
    $keterangan_bayar = $_POST['keterangan_bayar'];
    $vendor_id = $_POST['vendor_id'];
    $paket_jenis = $_POST['paket_jenis'];
    $skki_o_no = $_POST['skki_o_no'];
    $current_date = date('Y-m-d');
    $username = $_SESSION['username'];
    //echo $get_var_no_spj;


    mysqli_query($mysqli, "START TRANSACTION");
    $q = "select 
			CASE WHEN SPJ_ADD_NILAI  is NULL THEN SPJ_NILAI
			ELSE SPJ_ADD_NILAI									 
			END SPJ_NILAI
			from tb_spj where spj_no = '$get_var_no_spj'";
    $result = mysqli_query($mysqli, $q);
    while ($rows=mysqli_fetch_row($result)) {
        $data1[] = $rows;
    }
    
    $bandingkan_nilai_spj_awal = $data1[0][0];
    $seratus_tiga_puluh = (30/100)*$bandingkan_nilai_spj_awal;
    $lima_puluh = (50/100) * $bandingkan_nilai_spj_awal;
    $enam_puluh = (60/100) * $bandingkan_nilai_spj_awal;
    $sembilan_puluh = (90/100) * $bandingkan_nilai_spj_awal;
    $seratus = (100/100) * $bandingkan_nilai_spj_awal;
    
    $tujuh_puluh = (70/100) * $bandingkan_nilai_spj_awal;
    $empat_puluh = (40/100) * $bandingkan_nilai_spj_awal;
    $cek_seratus_tiga_puluh = (130/100)*$bandingkan_nilai_spj_awal;
    
    
    $qs = "select 
			SUM(PEMBAYARAN_NOMINAL) FROM tb_pembayaran where SPJ_NO='$get_var_no_spj'";
    $results = mysqli_query($mysqli, $qs);
    while ($rowss=mysqli_fetch_row($results)) {
        $data2[] = $rowss;
    }
    $yang_sudah_dibayar =str_replace(",", "", $data2[0][0]); ;
    
    $total_spj_mau_dibayarkan = $get_var_nominal_tagihan + $yang_sudah_dibayar;
    
    $q = "select coalesce(sum(pembayaran_nominal), 0 ) from tb_pembayaran  where spj_no = '$get_var_no_spj'";
    $result = mysqli_query($mysqli, $q);
    while ($rows=mysqli_fetch_row($result)) {
        $data2[] = $rows;
    }

        //if($data1[0][0]<=$data2[0][0]){
        if ($data1[0][0]>=$cek_seratus_tiga_puluh) {
            echo '<script language="javascript">alert("spj sudah lunas")</script>';
            echo '<script language="javascript">window.location = "inp_tagihan.php"</script>';
        //}else if($data2[0][0]+$get_var_nominal_tagihan > $data1[0][0] or $data2[0][0]+$get_var_nominal_tagihan != $seratus_tiga_puluh ){
        //}else if($data2[0][0]+$get_var_nominal_tagihan > $data1[0][0]){
            //echo '<script language="javascript">alert("spj yang dibayar lebih, progress harus 130%")</script>';
            //echo '<script language="javascript">window.location = "inp_tagihan.php"</script>';
        } elseif ($get_var_no_spj=="") {
            echo '<script language="javascript">alert("nomor spj harus di pilih")</script>';
            echo '<script language="javascript">window.location = "inp_tagihan.php"</script>';
        } elseif ($get_var_nominal_tagihan=="") {
            echo '<script language="javascript">alert("nominal tagihan harus di isi")</script>';
            echo '<script language="javascript">window.location = "inp_tagihan.php"</script>';
        } elseif (is_numeric($get_var_nominal_tagihan)==false) {
            echo '<script language="javascript">alert("nominal tagihan harus numerik")</script>';
            echo '<script language="javascript">window.location = "inp_tagihan.php"</script>';
        } elseif ($get_var_tanggal_bayar=="") {
            echo '<script language="javascript">alert("tanggal bayar harus di pilih")</script>';
            echo '<script language="javascript">window.location = "inp_tagihan.php"</script>';
        } elseif ($get_var_no_bastp=="") {
            echo '<script language="javascript">alert("nomor bastp harus di isi")</script>';
            echo '<script language="javascript">window.location = "inp_tagihan.php"</script>';
        } elseif ($get_var_deskripsi=="") {
            echo '<script language="javascript">alert("deskripsi pembayaran harus di isi")</script>';
            echo '<script language="javascript">window.location = "inp_tagihan.php"</script>';
        } else {
            
            /*$quer2 = mysqli_query($mysqli, "UPDATE TB_PAGU_KONTRAK A, TB_SPJ B
                                SET A.TERPAKAI = A.TERPAKAI - $get_var_nominal_tagihan
                                WHERE A.VENDOR_ID = B.VENDOR_ID
                                AND A.PAKET_JENIS = '$paket_jenis'
                                AND A.VENDOR_ID = '$vendor_id'");*/
            
            if ($total_spj_mau_dibayarkan <=  $data1[0][0]) {
                $quer = mysqli_query($mysqli, "UPDATE TB_FIN_VENDOR A, TB_SPJ B
								SET A.FIN_CURRENT = A.FIN_CURRENT - $get_var_nominal_tagihan 
								WHERE A.VENDOR_ID = B.VENDOR_ID 
								AND B.SPJ_NO = '$get_var_no_spj'
								AND A.VENDOR_ID = '$vendor_id'");
                    
                /*$quer2 = mysqli_query($mysqli, "UPDATE TB_PAGU_KONTRAK A
                            SET A.TERPAKAI = A.TERPAKAI - $get_var_nominal_tagihan
                            WHERE A.PAKET_JENIS = '$paket_jenis'
                            AND A.VENDOR_ID = '$vendor_id'");*/
                                
                $quer3 = mysqli_query($mysqli, "UPDATE tb_skko_i set SKKI_TERPAKAI=SKKI_TERPAKAI
								WHERE SKKI_NO='$skki_o_no'");
                                
            /*echo "UPDATE TB_PAGU_KONTRAK A
                        SET A.TERPAKAI = A.TERPAKAI - $get_var_nominal_tagihan
                        WHERE A.PAKET_JENIS = '$paket_jenis'
                        AND A.VENDOR_ID = '$vendor_id'";
            echo "<br/>";*/
            } elseif ($yang_sudah_dibayar==$bandingkan_nilai_spj_awal and $total_spj_mau_dibayarkan==$cek_seratus_tiga_puluh) {
                $quer = mysqli_query($mysqli, "UPDATE TB_FIN_VENDOR A, TB_SPJ B
								SET A.FIN_CURRENT = A.FIN_CURRENT 
								WHERE A.VENDOR_ID = B.VENDOR_ID 
								AND B.SPJ_NO = '$get_var_no_spj'
								AND A.VENDOR_ID = '$vendor_id'");
                
                /*$quer2 = mysqli_query($mysqli, "UPDATE TB_PAGU_KONTRAK A
                            SET A.TERPAKAI = A.TERPAKAI
                            WHERE A.PAKET_JENIS = '$paket_jenis'
                            AND A.VENDOR_ID = '$vendor_id'");*/
                                
                $quer3 = mysqli_query($mysqli, "UPDATE tb_skko_i set SKKI_TERPAKAI=(SKKI_TERPAKAI)+$seratus_tiga_puluh
								WHERE SKKI_NO='$skki_o_no'");
                                            
            /*echo "UPDATE TB_PAGU_KONTRAK A
                        SET A.TERPAKAI = A.TERPAKAI - $bandingkan_nilai_spj_awal
                        WHERE A.PAKET_JENIS = '$paket_jenis'
                        AND A.VENDOR_ID = '$vendor_id'";
            echo "<br/>";*/
            } elseif ($yang_sudah_dibayar==$lima_puluh and $total_spj_mau_dibayarkan==$cek_seratus_tiga_puluh) {
                $quer = mysqli_query($mysqli, "UPDATE TB_FIN_VENDOR A, TB_SPJ B
								SET A.FIN_CURRENT = A.FIN_CURRENT - $lima_puluh
								WHERE A.VENDOR_ID = B.VENDOR_ID 
								AND B.SPJ_NO = '$get_var_no_spj'
								AND A.VENDOR_ID = '$vendor_id'");
                
                /*$quer2 = mysqli_query($mysqli, "UPDATE TB_PAGU_KONTRAK A
                            SET A.TERPAKAI = A.TERPAKAI - $lima_puluh
                            WHERE A.PAKET_JENIS = '$paket_jenis'
                            AND A.VENDOR_ID = '$vendor_id'");*/
                                
                $quer3 = mysqli_query($mysqli, "UPDATE tb_skko_i set SKKI_TERPAKAI=(SKKI_TERPAKAI)+$seratus_tiga_puluh
								WHERE SKKI_NO='$skki_o_no'");
            } elseif ($yang_sudah_dibayar==0 and $total_spj_mau_dibayarkan==$cek_seratus_tiga_puluh) {
                $quer = mysqli_query($mysqli, "UPDATE TB_FIN_VENDOR A, TB_SPJ B
								SET A.FIN_CURRENT = A.FIN_CURRENT - $bandingkan_nilai_spj_awal
								WHERE A.VENDOR_ID = B.VENDOR_ID 
								AND B.SPJ_NO = '$get_var_no_spj'
								AND A.VENDOR_ID = '$vendor_id'");
                
                /*$quer2 = mysqli_query($mysqli, "UPDATE TB_PAGU_KONTRAK A
                            SET A.TERPAKAI = A.TERPAKAI - $bandingkan_nilai_spj_awal
                            WHERE A.PAKET_JENIS = '$paket_jenis'
                            AND A.VENDOR_ID = '$vendor_id'");*/
                                
                $quer3 = mysqli_query($mysqli, "UPDATE tb_skko_i set SKKI_TERPAKAI=(SKKI_TERPAKAI)+$seratus_tiga_puluh
								WHERE SKKI_NO='$skki_o_no'");
            } elseif ($yang_sudah_dibayar==$seratus_tiga_puluh and $total_spj_mau_dibayarkan==$cek_seratus_tiga_puluh) {
                $quer = mysqli_query($mysqli, "UPDATE TB_FIN_VENDOR A, TB_SPJ B
								SET A.FIN_CURRENT = A.FIN_CURRENT - $tujuh_puluh
								WHERE A.VENDOR_ID = B.VENDOR_ID 
								AND B.SPJ_NO = '$get_var_no_spj'
								AND A.VENDOR_ID = '$vendor_id'");
                
                /*$quer2 = mysqli_query($mysqli, "UPDATE TB_PAGU_KONTRAK A
                            SET A.TERPAKAI = A.TERPAKAI - $tujuh_puluh
                            WHERE A.PAKET_JENIS = '$paket_jenis'
                            AND A.VENDOR_ID = '$vendor_id'");*/
                                
                $quer3 = mysqli_query($mysqli, "UPDATE tb_skko_i set SKKI_TERPAKAI=(SKKI_TERPAKAI)+$seratus_tiga_puluh
								WHERE SKKI_NO='$skki_o_no'");
            } elseif ($yang_sudah_dibayar==$enam_puluh and $total_spj_mau_dibayarkan==$cek_seratus_tiga_puluh) {
                $quer = mysqli_query($mysqli, "UPDATE TB_FIN_VENDOR A, TB_SPJ B
								SET A.FIN_CURRENT = A.FIN_CURRENT - $empat_puluh
								WHERE A.VENDOR_ID = B.VENDOR_ID 
								AND B.SPJ_NO = '$get_var_no_spj'
								AND A.VENDOR_ID = '$vendor_id'");
                
                /*$quer2 = mysqli_query($mysqli, "UPDATE TB_PAGU_KONTRAK A
                            SET A.TERPAKAI = A.TERPAKAI - $empat_puluh
                            WHERE A.PAKET_JENIS = '$paket_jenis'
                            AND A.VENDOR_ID = '$vendor_id'");*/
                                
                $quer3 = mysqli_query($mysqli, "UPDATE tb_skko_i set SKKI_TERPAKAI=(SKKI_TERPAKAI)+$seratus_tiga_puluh
								WHERE SKKI_NO='$skki_o_no'");
            }
                
            $query = "insert into tb_pembayaran values('$get_var_no_spj','$get_var_nominal_tagihan','$get_var_tanggal_bayar','$get_var_no_bastp',CURDATE(),'$get_var_deskripsi','$username')";
            //echo $query;
            $resultQuery=mysqli_query($mysqli, $query);
            $query_keterangan_bayar = "update tb_termin SET keterangan='$keterangan_bayar' WHERE spj_no='$get_var_no_spj'";
            $resultQuery_keterangan=mysqli_query($mysqli, $query_keterangan_bayar);
            
            //if($resultQuery==1 and $quer==1 and $quer2==1 and $quer3==1 and $resultQuery_keterangan==1){
            if ($resultQuery==1 and $quer==1 and $quer3==1 and $resultQuery_keterangan==1) {
                echo '<script language="javascript">alert("Input Berhasil")</script>';
                echo '<script language="javascript">window.location = "inp_tagihan.php"</script>';
                mysqli_query($mysqli, "COMMIT");
            } else {
                /*echo "UPDATE TB_FIN_VENDOR A, TB_SPJ B
                            SET A.FIN_CURRENT = A.FIN_CURRENT - $get_var_nominal_tagihan
                            WHERE A.VENDOR_ID = B.VENDOR_ID
                            AND B.SPJ_NO = '$get_var_no_spj'
                            AND A.VENDOR_ID = '$vendor_id'";
                  echo "<br/>";
                  echo "insert into tb_pembayaran values('$get_var_no_spj',$get_var_nominal_tagihan,'$get_var_tanggal_bayar','$get_var_no_bastp',CURDATE(),'$get_var_deskripsi','$username')";
                  echo "<br/>";*/
                    
                echo '<script language="javascript">alert("Input Gagal")</script>';
                echo '<script language="javascript">window.location = "inp_tagihan.php"</script>';
                mysqli_query($mysqli, "ROLLBACK");
            }
        }
