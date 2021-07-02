
<?php
	if(!isset($_SESSION['isLogin'])){
		echo '<script language="javascript">alert("Log in terlebih dahulu")</script>';
		echo '<script language="javascript">window.location = "index.php"</script>';
	}else if($_SESSION['isLogin']==false){
		echo '<script language="javascript">alert("Log in terlebih dahulu")</script>';
		echo '<script language="javascript">window.location = "index.php"</script>';
	}else{
		$role = $_SESSION['role'];
		$pages = array("/khs_2020/kontrol_finansial.php", //0
						"/khs_2020/kecepatan_kerja.php", //1
						"/khs_2020/penyerapan_anggaran.php", //2
						"/khs_2020/seleksi_vendor.php", //3
						"/khs_2020/inp_progress_kerja.php",//4
						"/khs_2020/inp_tagihan.php", //5
						"/khs_2020/inp_addendum.php",//6
						"/khs_2020/approval.php",//7
						"/khs_2020/dl_spj.php",//8
						"/khs_2020/spj_view.php", //9
						"/khs_2020/edit_finansial_vendor.php", //10
						"/khs_2020/request_edit_finansial_vendor.php", //11
						"/khs_2020/evaluasi_vendor.php", //12
						"/khs_2020/verifikasi_evaluasi_mb.php", //13
						"/khs_2020/verifikasi_evaluasi_mup3.php",//14
						"/khs_2020/edit_finansial_vendor.php",//15
						"/khs_2020/master_paket.php",//16
						"/khs_2020/master_vendor.php",//17
						"/khs_2020/master_pagu.php",//18
						"/khs_2020/master_finansial.php",//19
						"/khs_2020/master_mapping.php"//20
						);
		if($role==1){
			/* Bisa Semua */
		}else if($role==2){
			if(strtolower($_SERVER['REQUEST_URI']) == $pages[3] or strtolower($_SERVER['REQUEST_URI']) == $pages[4] 
				or strtolower($_SERVER['REQUEST_URI']) == $pages[5] or strtolower($_SERVER['REQUEST_URI']) == $pages[6] 
				or strtolower($_SERVER['REQUEST_URI']) == $pages[7] or strtolower($_SERVER['REQUEST_URI']) == $pages[8] 
				or strtolower($_SERVER['REQUEST_URI']) == $pages[11] or strtolower($_SERVER['REQUEST_URI']) == $pages[12]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[13] or strtolower($_SERVER['REQUEST_URI']) == $pages[9]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[16] or strtolower($_SERVER['REQUEST_URI']) == $pages[17]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[18] or strtolower($_SERVER['REQUEST_URI']) == $pages[19]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[20]){
				echo '<script language="javascript">alert("Tidak punya hak akses")</script>';
				echo '<script language="javascript">window.location = "kontrol_finansial.php"</script>';
			}
		}else if($role==3){
			if(strtolower($_SERVER['REQUEST_URI']) == $pages[0] or strtolower($_SERVER['REQUEST_URI']) == $pages[1] 
			or strtolower($_SERVER['REQUEST_URI']) == $pages[3] or strtolower($_SERVER['REQUEST_URI']) == $pages[4] 
			or strtolower($_SERVER['REQUEST_URI']) == $pages[6] or strtolower($_SERVER['REQUEST_URI']) == $pages[7] 
			or strtolower($_SERVER['REQUEST_URI']) == $pages[8] or strtolower($_SERVER['REQUEST_URI']) == $pages[9] 
			or strtolower($_SERVER['REQUEST_URI']) == $pages[10] or strtolower($_SERVER['REQUEST_URI']) == $pages[11]
			or strtolower($_SERVER['REQUEST_URI']) == $pages[12] or strtolower($_SERVER['REQUEST_URI']) == $pages[13]
			or strtolower($_SERVER['REQUEST_URI']) == $pages[14] or strtolower($_SERVER['REQUEST_URI']) == $pages[15]
			or strtolower($_SERVER['REQUEST_URI']) == $pages[16] or strtolower($_SERVER['REQUEST_URI']) == $pages[17]
			or strtolower($_SERVER['REQUEST_URI']) == $pages[18] or strtolower($_SERVER['REQUEST_URI']) == $pages[19]
			or strtolower($_SERVER['REQUEST_URI']) == $pages[20]){
				echo '<script language="javascript">alert("Tidak punya hak akses")</script>';
				echo '<script language="javascript">window.location = "inp_tagihan.php"</script>';
			}
		}else if($role==4){
			if(strtolower($_SERVER['REQUEST_URI']) == $pages[1] or strtolower($_SERVER['REQUEST_URI']) == $pages[4] 
				or strtolower($_SERVER['REQUEST_URI']) == $pages[5] or strtolower($_SERVER['REQUEST_URI']) == $pages[7]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[10] or strtolower($_SERVER['REQUEST_URI']) == $pages[12]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[14] or strtolower($_SERVER['REQUEST_URI']) == $pages[15]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[16] or strtolower($_SERVER['REQUEST_URI']) == $pages[17]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[18] or strtolower($_SERVER['REQUEST_URI']) == $pages[19]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[20] or strtolower($_SERVER['REQUEST_URI']) == $pages[11]){
				echo '<script language="javascript">alert("Tidak punya hak akses")</script>';
				echo '<script language="javascript">window.location = "seleksi_vendor.php"</script>';
			}
		}else if($role==5){
			if(strtolower($_SERVER['REQUEST_URI']) == $pages[0] or strtolower($_SERVER['REQUEST_URI']) == $pages[2] 
				or strtolower($_SERVER['REQUEST_URI']) == $pages[3] or strtolower($_SERVER['REQUEST_URI']) == $pages[5] 
				//or strtolower($_SERVER['REQUEST_URI']) == $pages[6] //permintaan Pak Zul dan Pak Andi pas WFH (kamis, 3 Desember 2020) melalui Telepon, Adendum dibuka ke role pengawas atas rekomendasi dari UP2K list spj ( WFH -03/03/2021 request mas dalie)
				or strtolower($_SERVER['REQUEST_URI']) == $pages[7] 
				or strtolower($_SERVER['REQUEST_URI']) == $pages[8] 
				or strtolower($_SERVER['REQUEST_URI']) == $pages[10] or strtolower($_SERVER['REQUEST_URI']) == $pages[11]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[13] or strtolower($_SERVER['REQUEST_URI']) == $pages[14]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[15]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[16] or strtolower($_SERVER['REQUEST_URI']) == $pages[17]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[18] or strtolower($_SERVER['REQUEST_URI']) == $pages[19]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[20]){
				echo '<script language="javascript">alert("Tidak punya hak akses")</script>';
				echo '<script language="javascript">window.location = "inp_progress_kerja.php"</script>';
			}
		}else if($role==11){
			if(strtolower($_SERVER['REQUEST_URI']) == $pages[3] or strtolower($_SERVER['REQUEST_URI']) == $pages[4] 
			or strtolower($_SERVER['REQUEST_URI']) == $pages[5] or strtolower($_SERVER['REQUEST_URI']) == $pages[6] 
			or strtolower($_SERVER['REQUEST_URI']) == $pages[7] or strtolower($_SERVER['REQUEST_URI']) == $pages[8] 
			or strtolower($_SERVER['REQUEST_URI']) == $pages[10] 
			or strtolower($_SERVER['REQUEST_URI']) == $pages[12] or strtolower($_SERVER['REQUEST_URI']) == $pages[13]
			or strtolower($_SERVER['REQUEST_URI']) == $pages[14] or strtolower($_SERVER['REQUEST_URI']) == $pages[15]
			or strtolower($_SERVER['REQUEST_URI']) == $pages[16] or strtolower($_SERVER['REQUEST_URI']) == $pages[17]
			or strtolower($_SERVER['REQUEST_URI']) == $pages[18] or strtolower($_SERVER['REQUEST_URI']) == $pages[19]
			or strtolower($_SERVER['REQUEST_URI']) == $pages[20]){
				echo '<script language="javascript">alert("Tidak punya hak akses")</script>';
				echo '<script language="javascript">window.location = "kontrol_finansial.php"</script>';
			}
		}else if($role==12){	
			if(strtolower($_SERVER['REQUEST_URI']) == $pages[3] or strtolower($_SERVER['REQUEST_URI']) == $pages[4] 
				or strtolower($_SERVER['REQUEST_URI']) == $pages[5] or strtolower($_SERVER['REQUEST_URI']) == $pages[6] 
				or strtolower($_SERVER['REQUEST_URI']) == $pages[7] or strtolower($_SERVER['REQUEST_URI']) == $pages[8] 
				or strtolower($_SERVER['REQUEST_URI']) == $pages[10] or strtolower($_SERVER['REQUEST_URI']) == $pages[14]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[11] or strtolower($_SERVER['REQUEST_URI']) == $pages[12]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[15]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[13] or strtolower($_SERVER['REQUEST_URI']) == $pages[9]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[16] or strtolower($_SERVER['REQUEST_URI']) == $pages[17]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[18] or strtolower($_SERVER['REQUEST_URI']) == $pages[19]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[20]){
				echo '<script language="javascript">alert("Tidak punya hak akses")</script>';
				echo '<script language="javascript">window.location = "kontrol_finansial.php"</script>';
			}
	}else if($role==13){
			if(strtolower($_SERVER['REQUEST_URI']) == $pages[3] or strtolower($_SERVER['REQUEST_URI']) == $pages[4] 
				or strtolower($_SERVER['REQUEST_URI']) == $pages[5] or strtolower($_SERVER['REQUEST_URI']) == $pages[6] 
				or strtolower($_SERVER['REQUEST_URI']) == $pages[7] or strtolower($_SERVER['REQUEST_URI']) == $pages[8] 
				or strtolower($_SERVER['REQUEST_URI']) == $pages[10] or strtolower($_SERVER['REQUEST_URI']) == $pages[14]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[11] or strtolower($_SERVER['REQUEST_URI']) == $pages[12]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[15]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[13] or strtolower($_SERVER['REQUEST_URI']) == $pages[9]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[16] or strtolower($_SERVER['REQUEST_URI']) == $pages[17]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[18] or strtolower($_SERVER['REQUEST_URI']) == $pages[19]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[20]){
				echo '<script language="javascript">alert("Tidak punya hak akses")</script>';
				echo '<script language="javascript">window.location = "kontrol_finansial.php"</script>';
			}
	}else if($role==14){
			if(strtolower($_SERVER['REQUEST_URI']) == $pages[3] or strtolower($_SERVER['REQUEST_URI']) == $pages[4] 
				or strtolower($_SERVER['REQUEST_URI']) == $pages[5] or strtolower($_SERVER['REQUEST_URI']) == $pages[6] 
				or strtolower($_SERVER['REQUEST_URI']) == $pages[7] or strtolower($_SERVER['REQUEST_URI']) == $pages[8] 
				or strtolower($_SERVER['REQUEST_URI']) == $pages[10] or strtolower($_SERVER['REQUEST_URI']) == $pages[14]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[11] or strtolower($_SERVER['REQUEST_URI']) == $pages[12]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[15]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[13] or strtolower($_SERVER['REQUEST_URI']) == $pages[9]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[16] or strtolower($_SERVER['REQUEST_URI']) == $pages[17]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[18] or strtolower($_SERVER['REQUEST_URI']) == $pages[19]
				or strtolower($_SERVER['REQUEST_URI']) == $pages[20]){
				echo '<script language="javascript">alert("Tidak punya hak akses")</script>';
				echo '<script language="javascript">window.location = "kontrol_finansial.php"</script>';
			}
	}
	}
?>