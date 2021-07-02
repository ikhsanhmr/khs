<style>
.dropbtn {
    background-color: #4CAF50;
    color: white;
    padding: 16px;
    font-size: 16px;
    border: none;
    cursor: pointer;
}

.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {background-color: #f1f1f1}

.dropdown:hover .dropdown-content {
    display: block;
}

.dropdown:hover .dropbtn {
    background-color: #3e8e41;
}
</style>

<?php
	//session_start();
	$curr_page = strtolower($_SERVER['REQUEST_URI']);
	$pages = array("/khs/kontrol_finansial.php", //0
						"/khs/kecepatan_kerja.php",//1
						"/khs/penyerapan_anggaran.php",//2
						"/khs/seleksi_vendor.php",//3
						"/khs/inp_progress_kerja.php",//4
						"/khs/inp_tagihan.php",//5
						"/khs/inp_addendum.php",//6
						"/khs/approval.php",//7
						"/khs/dl_spj.php",//8
						"/khs/dashboard.php",//9
						"/khs/spj_view.php",//10
						"/khs/spj_non_khs.php",//11
						"/khs/skkoi_view.php",//12
						"/khs/fin_vendor_view.php",//13
						"/khs/list_amandemen.php",//14
						"/khs/perijinan.php", //15
						"/khs//ba_survey.php", //16
						"/khs/skrd_input.php",//17
						"/khs/bayar_retribusi.php", //18
						"/khs/monitoring_perijinan.php",//19
						"/khs/penyerahan_dok.php", //20
						"upload_skki.php", //21
						"spj_view.php",//22
						"/khs/inp_user.php",//23
						"/khs/inp_user_all.php",);//24
						
	$role = $_SESSION['role'];
	$vis=[];
	$cls=[];
	if($role==1){
		/* SEMUA BISA */
	}else if($role==2){
		$vis[3]=$vis[4]=$vis[5]=$vis[6]=$vis[7]=$vis[8]=$vis[10]=$vis[11]=$vis[13]=$vis[12]=$vis[14]=$vis[15]=$vis[16]=$vis[17]=$vis[18]=$vis[19]=$vis[20]=$vis[21]="hidden";
	}else if($role==3){
		$vis[0]=$vis[1]=$vis[3]=$vis[4]=$vis[6]=$vis[7]=$vis[8]=$vis[9]=$vis[10]=$vis[11]=$vis[12]=$vis[13]=$vis[14]=$vis[15]=$vis[16]=$vis[17]=$vis[18]=$vis[19]=$vis[20]=$vis[21]="hidden";
	}else if($role==4){
		$vis[1]=$vis[2]=$vis[4]=$vis[5]=$vis[7]=$vis[9]=$vis[12]=$vis[13]=$vis[21]="hidden";
	}else if($role==5){
		$vis[0]=$vis[2]=$vis[3]=$vis[5]=$vis[6]=$vis[7]=$vis[8]=$vis[9]=$vis[10]==$vis[11]=$vis[12]=$vis[13]=$vis[21]="hidden";
	}else if($role==6){
		$vis[0]=$vis[1]=$vis[4]=$vis[7]=$vis[12]=$vis[13]=$vis[8]=$vis[12]=$vis[13]=$vis[21]="hidden";
	}else if($role==7){
		$vis[0]=$vis[1]=$vis[2]=$vis[3]=$vis[4]=$vis[5]=$vis[6]=$vis[7]=$vis[8]=$vis[9]=$vis[10]=$vis[11]=$vis[12]=$vis[13]=$vis[14]=$vis[21]="hidden";
	}else if($role == 8){
		$vis[3]=$vis[4]=$vis[5]=$vis[6]=$vis[7]=$vis[8]=$vis[10]=$vis[11]=$vis[13]=$vis[14]=$vis[15]=$vis[16]=$vis[17]=$vis[18]=$vis[19]=$vis[20]="hidden";
	}else if($role == 9){
		$vis[3]=$vis[4]=$vis[5]=$vis[6]=$vis[7]=$vis[8]=$vis[10]=$vis[11]=$vis[13]=$vis[12]=$vis[14]=$vis[15]=$vis[16]=$vis[17]=$vis[18]=$vis[19]=$vis[20]=$vis[21]="hidden";
	}else if($role == 10){
		$vis[3]=$vis[4]=$vis[5]=$vis[6]=$vis[7]=$vis[8]=$vis[10]=$vis[11]=$vis[13]=$vis[12]=$vis[14]=$vis[15]=$vis[16]=$vis[17]=$vis[18]=$vis[19]=$vis[20]=$vis[21]="hidden";
	}

	for($i=0;$i<count($pages);$i++){
		if($curr_page == $pages[$i]){
			$cls[$i]="active";
		}
	}
?>
<aside class="left-side sidebar-offcanvas">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- /.search form -->
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu">
			<li <?php echo $vis[9]?> class="<?php echo $cls[9]?>">
				<a href="dashboard.php">
					<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				</a>
			</li>
			<li <?php echo $vis[0]?> class="<?php echo $cls[0]?>">
				<a href="kontrol_finansial.php">
					<i class="fa fa-dashboard"></i> <span>Kontrol Finansial</span>
				</a>
			</li>
			<li <?php echo $vis[1]?> class="<?php echo $cls[1]?>">
				<a href="kecepatan_kerja.php">
					<i class="fa fa-dashboard"></i> <span>Kecepatan Kerja</span>
				</a>
			</li>

			<li <?php echo $vis[2]?> class="<?php echo $cls[2]?>">
				<a href="penyerapan_anggaran.php">
					<i class="fa fa-dashboard"></i> <span>Penyerapan Anggaran</span>
				</a>
			</li>

			<li <?php echo $vis[16]?> class="<?php echo $cls[16]?>">
				<a href="monitoring_target_realisasi.php">
					<i class="fa fa-globe"></i><span>Detail SPJ</span>
				</a>
			</li>
			
			<li <?php echo $vis[3]?> class="<?php echo $cls[3]?>">
				<a href="seleksi_vendor.php">
					<i class="fa fa-globe"></i> <span>Input SPJ KHS</span>
				</a>
			</li>
			<li <?php echo $vis[4]?> class="<?php echo $cls[4]?>">
				<a href="inp_progress_kerja.php">
					<i class="fa fa-globe"></i><span>Input Progress Kerja</span>
				</a>
			</li>
			<li <?php echo $vis[5]?> class="<?php echo $cls[5]?>">
				<a href="inp_tagihan.php">
					<i class="fa fa-globe"></i><span>Input Tagihan</span>
				</a>
			</li>
			<li <?php echo $vis[6]?> class="<?php echo $cls[6]?>">
				<a href="inp_addendum.php">
					<i class="fa fa-globe"></i><span>Addendum</span>
				</a>
			</li>
			<li <?php echo $vis[7]?> class="<?php echo $cls[7]?>">
				<a href="approval.php">
					<i class="fa fa-globe"></i><span>Approval</span>
				</a>
			</li>
			<!-- <li <?php echo $vis[8]?> class="<?php echo $cls[8]?>">
				<a href="dl_spj.php">
					<i class="fa fa-globe"></i><span>Mengunduh SPJ</span>
				</a>
			</li> -->

			<li <?php echo $vis[22]?> class="<?php echo $cls[22]?>">
				<a href="spj_view.php">
					<i class="fa fa-globe"></i><span>List SPJ</span>
				</a>
			</li>
			<li <?php echo $vis[10]?> class="<?php echo $cls[10]?>">
				<a href="spj_view.php">
					<i class="fa fa-globe"></i><span>Edit SPJ</span>
				</a>
			</li>
			<li <?php echo $vis[11]?> class="<?php echo $cls[11]?>">
				<a href="spj_non_khs.php">
					<i class="fa fa-globe"></i><span>Input SPJ Non KHS</span>
				</a>
			</li>
			 <li <?php echo $vis[12]?> class="<?php echo $cls[12]?>">
				<a href="skkoi_view.php">
					<i class="fa fa-globe"></i><span>ADD / Edit SKKI/O</span>
				</a>
			</li>
			<!-- <li <?php echo $vis[13]?> class="<?php echo $cls[13]?>">
				<a href="fin_vendor_view.php">
					<i class="fa fa-globe"></i><span>Edit Data Finansial vendor</span>
				</a>
			</li> -->
			<li <?php echo $vis[14]?> class="<?php echo $cls[14]?>">
				<a href="list_amandemen.php">
					<i class="fa fa-globe"></i><span>List Amandemen</span>
				</a>
			</li>
			<li <?php echo $vis[15]?> class="<?php echo $cls[15]?>">
				<a href="perijinan.php">
					<i class="fa fa-globe"></i><span>Perijinan</span>
				</a>
			</li>
			<li <?php echo $vis[16]?> class="<?php echo $cls[16]?>">
				<a href="ba_survey.php">
					<i class="fa fa-globe"></i><span>BA Survey</span>
				</a>
			</li>
			<li <?php echo $vis[17]?> class="<?php echo $cls[17]?>">
				<a href="skrd_input.php">
					<i class="fa fa-globe"></i><span>SKRD</span>
				</a>
			</li>
			<li <?php echo $vis[18]?> class="<?php echo $cls[18]?>">
				<a href="bayar_retribusi.php">
					<i class="fa fa-globe"></i><span>Retribusi</span>
				</a>
			</li>
			<li <?php echo $vis[19]?> class="<?php echo $cls[19]?>">
				<a href="monitoring_perijinan.php">
					<i class="fa fa-globe"></i><span>Monitoring Perijinan</span>
				</a>
			</li>
			<li <?php echo $vis[20]?> class="<?php echo $cls[20]?>">
				<a href="penyerahan_dok.php">
					<i class="fa fa-globe"></i><span>Tambah Dokumen</span>
				</a>
			</li>
			<li <?php echo $vis[21]?> class="<?php echo $cls[21]?>">
				<a href="upload_skki.php">
					<i class="fa fa-globe"></i><span>Upload Anggaran</span>
				</a>
			</li>
			<li <?php echo $vis[12]?> class="<?php echo $cls[23]?>">
				<a href="inp_user.php">
					<i class="fa fa-globe"></i><span>Tambah User</span>
				</a>
			</li>
			<li <?php echo $vis[24]?> class="<?php echo $cls[24]?>">
				<a href="inp_user_all.php">
					<i class="fa fa-globe"></i><span>Tambah User All</span>
				</a>
			</li>
			
			
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>