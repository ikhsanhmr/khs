<?php
    session_start();
    include_once("lib/head.php");
    
    $area_kode=$_SESSION['area'];
    //$get_var_nama_manager = $_POST['var_nama_manager'];
    $get_var_no_skkio = $_POST['var_no_skkio'];
    //$get_var_paket_pekerjaan = $_POST['var_paket_pekerjaan'];
    //$get_var_vendor = $_POST['var_vendor'];
    $get_var_deskripsi_pekerjaan = $_POST['var_deskripsi_pekerjaan'];
    $get_var_no_spj = $_POST['var_no_spj'];
    $get_var_nama_vendor = $_POST['var_nama_vendor'];
    $get_var_nilai_spj = str_replace(",", "", $_POST['var_nilai_spj']);
    $get_var_mulai_berlaku = date('Y-m-d', strtotime($_POST['var_mulai_berlaku']));
    $get_var_akhir_berlaku = date('Y-m-d', strtotime($_POST['var_akhir_berlaku']));

    $get_var_ppn 				= str_replace(",", "", $_POST['ppn']);
    $get_var_min_ppn 			= str_replace(",", "", $_POST['min_ppn']);

    $today = date('Y-m-d');
    $username = $_SESSION['username'];
    
    /*if($get_var_paket_pekerjaan==1){
        $check = mysqli_query($mysqli, "select a.vendor_id from tb_fin_vendor a,tb_mapping_vendor b where a.vendor_id = b.vendor_id and a.vendor_id=$get_var_vendor and b.area_kode=$area_kode and b.paket_jenis=$get_var_paket_pekerjaan");
        $check_res = mysqli_fetch_array($check);
        if($check_res[0][0]==""){
            $get_var_paket_pekerjaan=2;
        }
    }*/
    
    mysqli_query($mysqli, "START TRANSACTION");
    /*$fin_current = mysqli_query($mysqli, "SELECT fin_limit, fin_current FROM tb_fin_vendor WHERE vendor_id = $get_var_vendor");
    while($rows=mysqli_fetch_array($fin_current)){
                                $data[]=$rows;
                            }*/
    $skki_terpakai = mysqli_query($mysqli, "SELECT skki_terpakai, skki_nilai FROM tb_skko_i WHERE skki_no = '$get_var_no_skkio'");
    while ($rows=mysqli_fetch_array($skki_terpakai)) {
        $skki[]=$rows;
    }

    /*if($get_var_nama_manager==""){
        echo '<script language="javascript">alert("nama manager tidak boleh kosong")</script>';
        echo '<script language="javascript">window.location = "seleksi_vendor.php"</script>';
    }else*/
    if ($get_var_no_skkio=="") {
        echo '<script language="javascript">alert("nomor skki/o harus di pilih")</script>';
        echo '<script language="javascript">window.location = "spj_non_khs.php"</script>';
    } elseif ($get_var_deskripsi_pekerjaan=="") {
        echo '<script language="javascript">alert("deskripsi pekerjaan tidak boleh kosong")</script>';
        echo '<script language="javascript">window.location = "spj_non_khs.php"</script>';
    } elseif ($get_var_no_spj=="") {
        echo '<script language="javascript">alert("nomor spj tidak boleh kosong")</script>';
        echo '<script language="javascript">window.location = "spj_non_khs.php"</script>';
    } elseif ($get_var_nilai_spj=="") {
        echo '<script language="javascript">alert("nilai spj tidak boleh kosong")</script>';
        echo '<script language="javascript">window.location = "spj_non_khs.php"</script>';
    } elseif ($get_var_mulai_berlaku=="" || $get_var_akhir_berlaku=="") {
        echo '<script language="javascript">alert("tanggal berlaku spj harus di pilih")</script>';
        echo '<script language="javascript">window.location = "spj_non_khs.php"</script>';
    } elseif ($get_var_mulai_berlaku > $get_var_akhir_berlaku) {
        echo '<script language="javascript">alert("tanggal mulai harus lebih kecil dari tanggal akhir")</script>';
        echo '<script language="javascript">window.location = "spj_non_khs.php"</script>';
    } elseif (($skki[0][0]+$get_var_nilai_spj) > $skki[0][1]) {
        echo '<script language="javascript">alert("nilai spj lebih dari nilai skki")</script>';
        echo '<script language="javascript">window.location = "spj_non_khs.php"</script>';
    } else {
        $query1 = "UPDATE tb_skko_i SET skki_terpakai = skki_terpakai + $get_var_nilai_spj WHERE skki_no = '$get_var_no_skkio'";
        $skki_upd =mysqli_query($mysqli, $query1);
        /*$query2 = "UPDATE tb_fin_vendor SET fin_current = fin_current+$get_var_nilai_spj WHERE vendor_id = $get_var_vendor;";
        $result=mysqli_query($mysqli, $query2);*/
        $query_vendor = "INSERT INTO tb_vendor_non_khs VALUES ('$get_var_no_spj','$get_var_nama_vendor')";
        $vendorInsert=mysqli_query($mysqli, $query_vendor);

        $query = "INSERT INTO tb_spj (
								SPJ_NO,
								VENDOR_ID,
								SKKI_NO,
								PAKET_JENIS,
								SPJ_NILAI,
								SPJ_TANGGAL_MULAI,
								SPJ_TANGGAL_AKHIR,
								SPJ_DESKRIPSI,
								SPJ_STATUS,
								SPJ_ADD_NILAI,
								SPJ_INPUT_DATE,
								SPJ_INPUT_USER,
								SPJ_ADD_TANGGAL,
								AREA_KODE,
								PPN,
								MIN_PPN
								)
					VALUES ('$get_var_no_spj',
							 106, 
							 '$get_var_no_skkio', 
							 0, 
							 $get_var_nilai_spj, 
							 '$get_var_mulai_berlaku', 
							 '$get_var_akhir_berlaku', 
							 '$get_var_deskripsi_pekerjaan',
							 1,
							 $get_var_nilai_spj,
							 CURDATE(),
							 '$username',
							 '$get_var_akhir_berlaku',
							 $area_kode,
							 $get_var_ppn,
							 $get_var_min_ppn
							 );";
        $resultQuery=mysqli_query($mysqli, $query);
        /*$q = "select vendor_nama,paket_deskripsi
        from tb_vendor a, tb_paket b, tb_mapping_vendor c
        where a.vendor_id = c.vendor_id
        and c.paket_jenis = b.paket_jenis
        and a.vendor_id = '$get_var_vendor'";
        $p=mysqli_query($mysqli, $q);
        while($rows2=mysqli_fetch_array($p)){
            $data2[]=$rows2;
        }*/
        if ($resultQuery==1 and $skki_upd==1 and $vendorInsert==1) {
            mysqli_query($mysqli, "COMMIT"); ?>
			
			<body class="skin-black">
			<!--include file header-->
			<?php include("lib/header.php");
            //session_start()?>	

			<div class="wrapper row-offcanvas row-offcanvas-left">
				<!-- Left side column. contains the logo and sidebar -->
				<?php include("lib/menu.php"); ?>

				<aside class="right-side">

					<!-- Main content -->
					<section class="content">
						
						<div class="row">
							<div class="col-md-12">
								<section class="panel">
									<header class="panel-heading">Input Berhasil</header>

									<div class="panel-body">
										<div>
											<form method="post" action="dl_pdf_spj_non_khs.php">
												<input name="var_nama_manager" value="<?php echo $get_var_nama_manager?>" hidden>
												<input name="var_no_spj" value="<?php echo $get_var_no_spj?>" hidden>
												
												<button type="submit" class="btn btn-info" onclick="document.getElementById('submitForm').submit()">Download</button>
											</form>	
										</div> 
											<?php
        } else {
            ?>
			<script language="javascript">alert("input spj gagal")</script>
			<script language="javascript">window.location = "spj_non_khs.php"</script>
			<?php
            mysqli_query($mysqli, "ROLLBACK");
        } ?>
									</div>
								</section>
							</div>
						</div>
					</section><!-- /.content -->
				</aside><!-- /.right-side -->
			</div>
		<?php include("lib/footer.php"); ?>
	</body>
			
			
			
			
			
			<?php
    }
    
    
?>