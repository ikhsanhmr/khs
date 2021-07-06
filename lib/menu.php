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
                                        "/khs/ba_survey.php", //16
                                        "/khs/skrd_input.php",//17
                                        "/khs/bayar_retribusi.php", //18
                                        "/khs/monitoring_perijinan.php",//19
                                        "/khs/penyerahan_dok.php", //20
                                        "/khs/upload_skki.php", //21
                                        "/khs/spj_view.php", //22
                                        "/khs/inp_user.php",//23
                                        "/khs/inp_user_all.php",//24
                                        "/khs/monitoring_target_realisasi.php",//25
                                        "/khs/history_pembayaran.php",//26
                                        "/khs/edit_finansial_vendor.php",//27
                                        "/khs/request_edit_finansial_vendor.php",//28
                                        "/khs/edit_pagu_vendor.php",//29
                                        "/khs/edit_progress.php",//30
                                        "/khs/vendor_khs.php",//31
                                        "/khs/penilaian_deskripsi.php",//32
                                        "/khs/penilaian_kriteria.php",//33
                                        "/khs/evaluasi_vendor.php",//34
                                        "/khs/verifikasi_evaluasi_mb.php",//35
                                        "/khs/verifikasi_evaluasi_mup3.php",//36
                                        "/khs/rekapitulasi_evaluasi.php",//37
                                        "/khs/rekapitulasi_evaluasi_global.php",//38
                                        "/khs/master_paket.php",//39
                                        "/khs/master_vendor.php",//40
                                        "/khs/master_pagu.php",//41
                                        "/khs/master_finansial.php",//42
                                        "/khs/master_mapping.php"//43
                                        );
    $role = $_SESSION['role'];
    $vis=[];
    $cls=[];
    if ($role==1) {
        $vis[24]="hidden";
    /* SEMUA BISA */
    } elseif ($role==2) {
        $vis[3]=$vis[30]=$vis[4]=$vis[5]=$vis[6]=$vis[7]=$vis[8]=$vis[10]=$vis[11]=$vis[13]=$vis[12]=$vis[14]=$vis[15]=$vis[16]=$vis[17]=$vis[18]=$vis[19]=$vis[20]=$vis[21]=$vis[24]=$vis[23]=$vis[22]=$vis[26]=$vis[28]=$vis[29]=$vis[32]=$vis[33]=$vis[34]=$vis[35]=$vis[38]=$vis[39]=$vis[40]=$vis[41]=$vis[42]=$vis[43]="hidden";
    } elseif ($role==3) {
        $vis[0]=$vis[1]=$vis[30]=$vis[3]=$vis[4]=$vis[6]=$vis[7]=$vis[8]=$vis[9]=$vis[10]=$vis[11]=$vis[12]=$vis[13]=$vis[14]=$vis[15]=$vis[16]=$vis[17]=$vis[18]=$vis[19]=$vis[20]=$vis[21]=$vis[24]=$vis[23]=$vis[22]=$vis[27]=$vis[28]=$vis[29]=$vis[31]=$vis[32]=$vis[33]=$vis[34]=$vis[35]=$vis[36]=$vis[37]=$vis[38]=$vis[39]=$vis[40]=$vis[41]=$vis[42]=$vis[43]="hidden";
    } elseif ($role==4) {
        $vis[1]=$vis[30]=$vis[4]=$vis[5]=$vis[7]=$vis[13]=$vis[21]=$vis[24]=$vis[23]=$vis[26]=$vis[27]=$vis[28]=$vis[29]=$vis[32]=$vis[33]=$vis[34]=$vis[36]=$vis[38]=$vis[39]=$vis[40]=$vis[41]=$vis[42]=$vis[43]="hidden";
    } elseif ($role==5) { //permintaan Pak Zul dan Pak Andi pas WFH (kamis, 3 Desember 2020) melalui Telepon, Adendum dibuka ke role pengawas atas rekomendasi dari UP2K - list spj ( WFH -03/03/2021 request mas dalie)
        $vis[0]=$vis[2]=$vis[3]=$vis[7]=$vis[8]=$vis[11]=$vis[12]=$vis[13]=$vis[21]=$vis[24]=$vis[10]=$vis[5]=$vis[23]=$vis[26]=$vis[27]=$vis[28]=$vis[29]=$vis[32]=$vis[33]=$vis[35]=$vis[36]=$vis[38]=$vis[39]=$vis[40]=$vis[41]=$vis[42]=$vis[43]="hidden";
    } elseif ($role==6) {
        $vis[0]=$vis[1]=$vis[30]=$vis[4]=$vis[7]=$vis[12]=$vis[13]=$vis[8]=$vis[12]=$vis[13]=$vis[21]=$vis[26]=$vis[27]=$vis[28]=$vis[29]=$vis[31]=$vis[32]=$vis[33]=$vis[34]=$vis[35]=$vis[36]=$vis[39]=$vis[40]=$vis[41]=$vis[42]=$vis[43]="hidden";
    } elseif ($role==7) {
        $vis[0]=$vis[1]=$vis[30]=$vis[2]=$vis[3]=$vis[4]=$vis[5]=$vis[6]=$vis[7]=$vis[8]=$vis[9]=$vis[10]=$vis[11]=$vis[12]=$vis[13]=$vis[14]=$vis[21]=$vis[26]=$vis[27]=$vis[28]=$vis[29]=$vis[31]=$vis[32]=$vis[33]=$vis[34]=$vis[35]=$vis[36]=$vis[39]=$vis[40]=$vis[41]=$vis[42]=$vis[43]="hidden";
    } elseif ($role == 8) {
        $vis[3]=$vis[4]=$vis[30]=$vis[5]=$vis[6]=$vis[7]=$vis[8]=$vis[10]=$vis[11]=$vis[13]=$vis[14]=$vis[15]=$vis[16]=$vis[17]=$vis[18]=$vis[19]=$vis[20]=$vis[26]=$vis[27]=$vis[28]=$vis[29]=$vis[31]=$vis[32]=$vis[33]=$vis[34]=$vis[35]=$vis[36]=$vis[39]=$vis[40]=$vis[41]=$vis[42]=$vis[43]="hidden";
    } elseif ($role == 9) {
        $vis[3]=$vis[4]=$vis[30]=$vis[5]=$vis[6]=$vis[7]=$vis[8]=$vis[10]=$vis[11]=$vis[13]=$vis[12]=$vis[14]=$vis[15]=$vis[16]=$vis[17]=$vis[18]=$vis[19]=$vis[20]=$vis[21]=$vis[26]=$vis[27]=$vis[28]=$vis[29]=$vis[31]=$vis[32]=$vis[33]=$vis[34]=$vis[35]=$vis[36]=$vis[39]=$vis[40]=$vis[41]=$vis[42]=$vis[43]="hidden";
    } elseif ($role == 10) {
        $vis[3]=$vis[4]=$vis[30]=$vis[5]=$vis[6]=$vis[7]=$vis[8]=$vis[10]=$vis[11]=$vis[13]=$vis[12]=$vis[14]=$vis[15]=$vis[16]=$vis[17]=$vis[18]=$vis[19]=$vis[20]=$vis[21]=$vis[26]=$vis[27]=$vis[28]=$vis[29]=$vis[31]=$vis[32]=$vis[33]=$vis[34]=$vis[35]=$vis[36]=$vis[39]=$vis[40]=$vis[41]=$vis[42]=$vis[43]="hidden";
    } elseif ($role==0) { //28/4/2021 buka penyerapan anggaran vis2
        $vis[3]=$vis[1]=$vis[30]=$vis[0]=$vis[4]=$vis[5]=$vis[6]=$vis[7]=$vis[8]=$vis[9]=$vis[10]=$vis[11]=$vis[13]=$vis[14]=$vis[15]=$vis[16]=$vis[17]=$vis[18]=$vis[19]=$vis[20]=$vis[21]=$vis[22]=$vis[26]=$vis[27]=$vis[28]=$vis[29]="hidden";
    } elseif ($role==11) {
        $vis[3]=$vis[4]=$vis[30]=$vis[5]=$vis[6]=$vis[7]=$vis[8]=$vis[10]=$vis[11]=$vis[13]=$vis[12]=$vis[14]=$vis[15]=$vis[16]=$vis[17]=$vis[18]=$vis[19]=$vis[20]=$vis[21]=$vis[24]=$vis[23]=$vis[22]=$vis[26]=$vis[27]=$vis[29]=$vis[34]=$vis[35]=$vis[36]=$vis[37]=$vis[39]=$vis[40]=$vis[41]=$vis[42]=$vis[43]="hidden";
    } elseif ($role==12) {
        $vis[3]=$vis[4]=$vis[30]=$vis[5]=$vis[6]=$vis[7]=$vis[8]=$vis[10]=$vis[11]=$vis[13]=$vis[12]=$vis[14]=$vis[15]=$vis[16]=$vis[17]=$vis[18]=$vis[19]=$vis[20]=$vis[21]=$vis[24]=$vis[23]=$vis[22]=$vis[26]=$vis[28]=$vis[27]=$vis[29]=$vis[32]=$vis[33]=$vis[34]=$vis[35]=$vis[36]=$vis[39]=$vis[40]=$vis[41]=$vis[42]=$vis[43]="hidden";
    } elseif ($role==13) {
        $vis[3]=$vis[4]=$vis[30]=$vis[5]=$vis[6]=$vis[7]=$vis[8]=$vis[10]=$vis[11]=$vis[13]=$vis[14]=$vis[15]=$vis[16]=$vis[17]=$vis[18]=$vis[19]=$vis[20]=$vis[21]=$vis[24]=$vis[23]=$vis[22]=$vis[26]=$vis[28]=$vis[27]=$vis[29]=$vis[31]=$vis[32]=$vis[33]=$vis[34]=$vis[35]=$vis[36]=$vis[37]=$vis[38]=$vis[39]=$vis[40]=$vis[41]=$vis[42]=$vis[43]="hidden";
    } elseif ($role==14) {
        $vis[3]=$vis[4]=$vis[30]=$vis[5]=$vis[6]=$vis[7]=$vis[8]=$vis[10]=$vis[11]=$vis[13]=$vis[12]=$vis[14]=$vis[15]=$vis[16]=$vis[17]=$vis[18]=$vis[19]=$vis[20]=$vis[21]=$vis[24]=$vis[23]=$vis[22]=$vis[26]=$vis[27]=$vis[28]=$vis[32]=$vis[33]=$vis[34]=$vis[35]=$vis[36]=$vis[37]=$vis[39]=$vis[40]=$vis[41]=$vis[42]=$vis[43]=$vis[29]="hidden";
    }

    for ($i=0;$i<count($pages);$i++) {
        if ($curr_page == $pages[$i]) {
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
	
			<li <?php //echo $vis[9]?> class="<?php //echo $cls[9]?>">
				<a href="dashboard.php">
					<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				</a>
			</li>
			<li <?php //echo $vis[39]?> class="<?php //echo $cls[39]?>">
				<a href="master_paket.php">
					<i class="fa fa-archive"></i> <span>Master Paket</span>
				</a>
			</li>
			<li <?php //echo $vis[40]?> class="<?php //echo $cls[40]?>">
				<a href="master_vendor.php">
					<i class="fa fa-male"></i> <span>Master Vendor</span>
				</a>
			</li>
			<li <?php //echo $vis[41]?> class="<?php //echo $cls[41]?>">
				<a href="master_pagu.php">
					<i class="fa fa-trophy"></i> <span>Master Pagu Vendor</span>
				</a>
			</li>
			<li <?php //echo $vis[42]?> class="<?php //echo $cls[42]?>">
				<a href="master_finansial.php">
					<i class="fa fa-credit-card"></i><span>Master Finansial Vendor</span>
				</a>
			</li>
			
			<li <?php //echo $vis[43]?> class="<?php //echo $cls[44]?>">
				<a href="master_mapping.php">
					<i class="fa fa-map-marker"></i><span>Master Mapping Vendor</span>
				</a>
			</li>
			
			<li <?php //echo $vis[0]?> class="<?php //echo $cls[0]?>">
				<a href="kontrol_finansial.php">
					<i class="fa fa-sitemap"></i> <span>Kontrol Finansial</span>
				</a>
			</li>
			<li <?php //echo $vis[27]?> class="<?php //echo $cls[27]?>">
				<a href="edit_finansial_vendor.php">
					<i class="fa fa-sitemap"></i> <span>Revisi Finansial Vendor</span>
				</a>
			</li>
			
			<li <?php //echo $vis[29]?> class="<?php //echo $cls[29]?>">
				<a href="edit_pagu_vendor.php">
					<i class="fa fa-envelope"></i> <span>Revisi Pagu Kontrak Vendor</span>
				</a>
			</li>
			
			<li <?php //echo $vis[28]?> class="<?php //echo $cls[28]?>">
				<a href="request_edit_finansial_vendor.php">
					<i class="fa fa-refresh"></i> <span>Request Update Finansial</span>
				</a>
			</li>
			
			<li <?php //echo $vis[1]?> class="<?php //echo $cls[1]?>">
				<a href="kecepatan_kerja.php">
					<i class="fa fa-fighter-jet"></i> <span>Kecepatan Kerja</span>
				</a>
			</li>
			<li <?php //echo $vis[30]?> class="<?php //echo $cls[30]?>">
				<a href="edit_progress.php">
					<i class="fa fa-key"></i> <span>Edit Progress Kerja</span>
				</a>
			</li>

			<li <?php //echo $vis[2]?> class="<?php //echo $cls[2]?>">
				<a href="penyerapan_anggaran.php">
					<i class="fa fa-cloud-download"></i> <span>Penyerapan Anggaran</span>
				</a>
			</li>

			<li <?php //echo $vis[25]?> class="<?php //echo $cls[25]?>">
				<a href="monitoring_target_realisasi.php">
					<i class="fa fa-book"></i><span>Detail SPJ</span>
				</a>
			</li>
			
			<li <?php //echo $vis[3]?> class="<?php //echo $cls[3]?>">
				<a href="seleksi_vendor.php">
					<i class="fa fa-truck"></i> <span>Input SPJ KHS</span>
				</a>
			</li>
			<li <?php //echo $vis[4]?> class="<?php //echo $cls[4]?>">
				<a href="inp_progress_kerja.php">
					<i class="fa fa-signal"></i><span>Input Progress Kerja</span>
				</a>
			</li>
			<li <?php //echo $vis[5]?> class="<?php //echo $cls[5]?>">
				<a href="inp_tagihan.php">
					<i class="fa fa-money"></i><span>Input Tagihan</span>
				</a>
			</li>
			
			<li <?php //echo $vis[7]?> class="<?php //echo $cls[7]?>">
				<a href="approval.php">
					<i class="fa fa-calendar"></i><span>Approval</span>
				</a>
			</li> 
		 <li <?php //echo $vis[8]?> class="<?php //echo $cls[8]?>">
				<a href="dl_spj.php">
					<i class="fa fa-globe"></i><span>Mengunduh SPJ</span>
				</a>
			</li>
			<li <?php //echo $vis[22]?> class="<?php //echo $cls[22]?>">
				<a href="spj_view.php">
					<i class="fa fa-folder-open"></i><span>List SPJ</span>
				</a>
			</li>
			<li <?php //echo $vis[10]?> class="<?php //echo $cls[10]?>">
				<a href="spj_view.php">
					<i class="fa fa-folder"></i><span>Edit SPJ</span>
				</a>
			</li>
			<li <?php //echo $vis[11]?> class="<?php //echo $cls[11]?>">
				<a href="spj_non_khs.php">
					<i class="fa fa-globe"></i><span>Input SPJ Non KHS</span>
				</a>
			</li>
			 <li <?php //echo $vis[12]?> class="<?php //echo $cls[12]?>">
				<a href="skkoi_view.php">
					<i class="fa fa-edit"></i><span>SKKI/O</span>
				</a>
			</li>
			<li <?php //echo $vis[13]?> class="<?php //echo $cls[13]?>">
				<a href="fin_vendor_view.php">
					<i class="fa fa-globe"></i><span>Edit Data Finansial vendor</span>
				</a>
			</li>
			<li <?php //echo $vis[6]?> class="<?php //echo $cls[6]?>">
				<a href="inp_addendum.php">
					<i class="fa fa-pencil"></i><span>Addendum</span>
				</a>
			</li>
			
			<!-- <li <?php //echo $vis[14]?> class="<?php //echo $cls[14]?>">
				<a href="list_amandemen.php">
					<i class="fa fa-pencil-square"></i><span>List Adendum</span>
					<i class="fa fa-globe"></i><span>List Amandemen</span>
				</a>
			</li> -->
			<li <?php //echo $vis[15]?> class="<?php //echo $cls[15]?>">
				<a href="perijinan.php">
					<i class="fa fa-globe"></i><span>Perijinan</span>
				</a>
			</li>
			<li <?php //echo $vis[16]?> class="<?php //echo $cls[16]?>">
				<a href="ba_survey.php">
					<i class="fa fa-globe"></i><span>BA Survey</span>
				</a>
			</li>
			<li <?php //echo $vis[17]?> class="<?php //echo $cls[17]?>">
				<a href="skrd_input.php">
					<i class="fa fa-globe"></i><span>SKRD</span>
				</a>
			</li>
			<li <?php //echo $vis[18]?> class="<?php //echo $cls[18]?>">
				<a href="bayar_retribusi.php">
					<i class="fa fa-globe"></i><span>Retribusi</span>
				</a>
			</li>
			<li <?php //echo $vis[19]?> class="<?php //echo $cls[19]?>">
				<a href="monitoring_perijinan.php">
					<i class="fa fa-globe"></i><span>Monitoring Perijinan</span>
				</a>
			</li>
			<li <?php //echo $vis[20]?> class="<?php //echo $cls[20]?>">
				<a href="penyerahan_dok.php">
					<i class="fa fa-globe"></i><span>Tambah Dokumen</span>
				</a>
			 </li>
			<li <?php //echo $vis[21]?> class="<?php //echo $cls[21]?>">
				<a href="upload_skki.php">
					<i class="fa fa-cloud-upload"></i><span>Upload Anggaran</span>
				</a>
			</li>
			<li <?php //echo $vis[23]?> class="<?php //echo $cls[23]?>">
				<a href="inp_user.php">
					<i class="fa fa-user"></i><span>Tambah User</span>
				</a>
			</li>
			<li <?php //echo $vis[24]?> class="<?php //echo $cls[24]?>">
				<a href="inp_user_all.php">
					<i class="fa fa-users"></i><span>Tambah User All</span>
				</a>
			</li>
			
			<li <?php //echo $vis[26]?> class="<?php //echo $cls[26]?>">
				<a href="history_pembayaran.php">
					<i class="fa fa-dollar	"></i><span>History Pembayaran</span>
				</a>
			</li>
			
			<li <?php //echo $vis[31]?> class="<?php //echo $cls[31]?>">
				<a href="vendor_khs.php">
					<i class="fa fa-users"></i><span>List Vendor</span>
				</a>
			</li>
			
			<li <?php //echo $vis[32]?> class="<?php //echo $cls[32]?>">
				<a href="penilaian_deskripsi.php">
					<i class="fa fa-lock"></i><span>Master Deskripsi Penilaian</span>
				</a>
			</li>
			
			<li <?php //echo $vis[33]?> class="<?php //echo $cls[33]?>">
				<a href="penilaian_kriteria.php">
					<i class="fa fa-key"></i><span>Master Penilaian Kriteria</span>
				</a>
			</li>
			
			<li <?php //echo $vis[34]?> class="<?php //echo $cls[34]?>">
				<a href="evaluasi_vendor.php">
					<i class="fa fa-trophy"></i><span>Evaluasi Vendor</span>
				</a>
			</li>
			
			<li <?php //echo $vis[35]?> class="<?php //echo $cls[35]?>">
				<a href="verifikasi_evaluasi_mb.php">
					<i class="fa fa-check-square-o"></i><span>Verifikasi Evaluasi MB</span>
				</a>
			</li>
			
			<li <?php //echo $vis[36]?> class="<?php //echo $cls[36]?>">
				<a href="verifikasi_evaluasi_mup3.php">
					<i class="fa fa-check-square-o"></i><span>Verifikasi Evaluasi MUP3</span>
				</a>
			</li>
			
			<li <?php //echo $vis[37]?> class="<?php //echo $cls[37]?>">
				<a href="rekapitulasi_evaluasi.php">
					<i class="fa fa-file-text"></i><span>Rekapitulasi Evaluasi</span>
				</a>
			</li>
			
			<li <?php //echo $vis[38]?> class="<?php //echo $cls[38]?>">
				<a href="rekapitulasi_evaluasi_global.php">
					<i class="fa fa-file-text"></i><span>Rekapitulasi Evaluasi Global</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>