/*
SQLyog Community v13.1.6 (64 bit)
MySQL - 5.7.24 : Database - db_khs
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_khs` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_khs`;

/*Table structure for table `penilaian_deskripsi` */

DROP TABLE IF EXISTS `penilaian_deskripsi`;

CREATE TABLE `penilaian_deskripsi` (
  `id_deskripsi` int(11) NOT NULL AUTO_INCREMENT,
  `deskripsi` varchar(200) NOT NULL,
  `bobot` int(11) NOT NULL,
  PRIMARY KEY (`id_deskripsi`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `penilaian_deskripsi` */

insert  into `penilaian_deskripsi`(`id_deskripsi`,`deskripsi`,`bobot`) values 
(1,'Mutu',30),
(2,'SDM dan Keuangan',15),
(5,'Lingkungan, K3 & APD',30),
(6,'Administrasi',10),
(7,'Komunikasi dan Responsiveness',15);

/*Table structure for table `penilaian_kriteria` */

DROP TABLE IF EXISTS `penilaian_kriteria`;

CREATE TABLE `penilaian_kriteria` (
  `id_kriteria` int(11) NOT NULL AUTO_INCREMENT,
  `id_deskripsi` int(11) NOT NULL,
  `kriteria` varchar(200) NOT NULL,
  `bobot` decimal(16,2) NOT NULL,
  PRIMARY KEY (`id_kriteria`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

/*Data for the table `penilaian_kriteria` */

insert  into `penilaian_kriteria`(`id_kriteria`,`id_deskripsi`,`kriteria`,`bobot`) values 
(1,1,'Ketaatan terhadap standard kontruksi yang berlaku sesuai kontrak',2.00),
(2,1,'Kemampuan menyelesaikan pekerjaan tepat waktu',2.00),
(3,1,'Tersedianya peralatan kerja yang sesuai dengan bidang pekerjaan yang sesuai dengan bidang pekerjaan yang dilaksanakan',1.00),
(4,1,'Unjuk kerja peralatan/barang setelah komisioning/beroperasi dan selama masa garansi',1.00),
(5,2,'Kompetensi Pengawas pekerjaan',0.50),
(6,2,'Mempunyai regu pelaksana yang kompeten',0.50),
(7,2,'Hubungan industrial Karyawan (Hubungan Kerja Internal KSO)',0.50),
(8,2,'Kemampuan keuangan dalam pembiayaan proyek',1.50),
(9,5,'Kelengkapan peralatan APD',2.00),
(10,5,'Kedisiplinan Penggunaan APD',1.00),
(11,5,'Kualitas peralatan APD',1.00),
(12,5,'Penerapan rambu-rambu dalam pekerjaan',1.00),
(13,5,'Keamanan dan kebersihan tempat kerja',1.00),
(14,6,'Ketaatan terhadap peraturan Pemerintah dan PLN',0.40),
(15,6,'Kelengkapan Dokumen sebelum Pekerjaan dimulai (IK,SOP,Approval Drawing / Design)',0.40),
(16,6,'Kelengkapan Dokumen saat pelaksanaan pekerjaan (Overall Schedule Project dan S-Curve dan monitoring nilai perkiraan realisasi progress)',0.40),
(17,6,'Kelengkapan Dokumen setelah pekerjaan selesai (Hasil Site Test & Komisioning)',0.40),
(18,6,'Kecepatan penyerahan dokumen pekerjaan ke PLN untuk penyelesaian penagihan kontrak',0.40),
(19,7,'Kemudahan untuk dihubungi dalam berkoordinasi dengan Tim Direksi Pekerjaan/lapangan/pengawas',0.40),
(20,7,'Kemudahan bekerjasama dengan unit setempat',0.60),
(21,7,'Kecepatan kemampuan menyelesaikan masalah sosial di lapangan',1.00),
(22,7,'Kecepatan kemampuan menyelesaikan masalah teknis di lapangan',1.00);

/*Table structure for table `penilaian_nilai` */

DROP TABLE IF EXISTS `penilaian_nilai`;

CREATE TABLE `penilaian_nilai` (
  `id_nilai` int(11) NOT NULL AUTO_INCREMENT,
  `id_kriteria` int(11) NOT NULL,
  `spj_no` varchar(100) NOT NULL,
  `nilai` int(11) NOT NULL,
  `bobot` decimal(16,2) NOT NULL,
  `id_deskripsi` int(11) NOT NULL,
  PRIMARY KEY (`id_nilai`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `penilaian_nilai` */

/*Table structure for table `tb_addendum` */

DROP TABLE IF EXISTS `tb_addendum`;

CREATE TABLE `tb_addendum` (
  `ADDENDUM_NO` varchar(300) NOT NULL,
  `SPJ_NO` varchar(100) NOT NULL,
  `ADDENDUM_NILAI` decimal(16,0) NOT NULL,
  `ADDENDUM_TANGGAL_AKHIR` date NOT NULL,
  `ADDENDUM_DESKRIPSI` text NOT NULL,
  `ADDENDUM_INPUT_DATE` date NOT NULL,
  `ADDENDUM_INPUT_USER` varchar(30) NOT NULL,
  `TGL_ADDENDUM` date NOT NULL,
  `ADENDUM_TARGET` decimal(16,4) NOT NULL,
  `TARGET_AWAL` decimal(16,4) NOT NULL,
  PRIMARY KEY (`ADDENDUM_NO`,`SPJ_NO`),
  KEY `SPJ_NO` (`SPJ_NO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_addendum` */

/*Table structure for table `tb_area` */

DROP TABLE IF EXISTS `tb_area`;

CREATE TABLE `tb_area` (
  `AREA_KODE` int(11) NOT NULL,
  `AREA_NAMA` varchar(100) NOT NULL,
  `AREA_ZONE` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`AREA_KODE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_area` */

insert  into `tb_area`(`AREA_KODE`,`AREA_NAMA`,`AREA_ZONE`) values 
(54000,'UIWSU',0);

/*Table structure for table `tb_dokumen` */

DROP TABLE IF EXISTS `tb_dokumen`;

CREATE TABLE `tb_dokumen` (
  `id_dok` int(100) NOT NULL AUTO_INCREMENT,
  `nama_dok` varchar(100) NOT NULL,
  `spj_no` varchar(100) NOT NULL,
  `tgl_serah` date NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `jumlah_dok` int(30) NOT NULL,
  `revisi-ke` int(30) NOT NULL,
  `info_01` int(30) NOT NULL COMMENT '0= MURNI; 1=REVISI',
  `info_02` int(30) NOT NULL,
  `info_03` int(30) NOT NULL,
  `info_04` int(30) NOT NULL,
  `info_05` int(30) NOT NULL,
  PRIMARY KEY (`id_dok`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_dokumen` */

/*Table structure for table `tb_fin_vendor` */

DROP TABLE IF EXISTS `tb_fin_vendor`;

CREATE TABLE `tb_fin_vendor` (
  `VENDOR_ID` int(11) NOT NULL,
  `RATING_LAPORAN_AUDIT` varchar(5) NOT NULL,
  `FIN_LIMIT` decimal(16,0) NOT NULL,
  `FIN_CURRENT` decimal(16,2) NOT NULL,
  `FIN_LIMIT_PERTAMA` decimal(16,0) NOT NULL,
  `RATING_LAPORAN_AUDIT_PERTAMA` varchar(5) NOT NULL,
  PRIMARY KEY (`VENDOR_ID`),
  KEY `FK_RELATIONSHIP_3` (`RATING_LAPORAN_AUDIT`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_fin_vendor` */

/*Table structure for table `tb_fin_vendor_update` */

DROP TABLE IF EXISTS `tb_fin_vendor_update`;

CREATE TABLE `tb_fin_vendor_update` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) NOT NULL,
  `rating_laporan_audit_sebelum_update` varchar(5) NOT NULL,
  `rating_laporan_audit_setelah_update` varchar(5) NOT NULL,
  `fin_limit_sebelum_update` decimal(16,0) NOT NULL,
  `fin_limit_setelah_update` decimal(16,0) NOT NULL,
  `fin_update_user` varchar(30) NOT NULL,
  `fin_update_date` date NOT NULL,
  `file_bukti` varchar(256) NOT NULL,
  `status` varchar(10) NOT NULL,
  `update_by` varchar(100) NOT NULL,
  `update_date` date NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_fin_vendor_update` */

/*Table structure for table `tb_ijin` */

DROP TABLE IF EXISTS `tb_ijin`;

CREATE TABLE `tb_ijin` (
  `spj_no` varchar(100) NOT NULL,
  `surat_ijin_no` varchar(100) NOT NULL,
  `tgl_surat` date NOT NULL,
  `pekerjaan` varchar(100) NOT NULL,
  `kota_adm` varchar(30) NOT NULL,
  `lokasi` varchar(100) NOT NULL,
  `tgl_survey` date DEFAULT NULL,
  `hasil_survey` varchar(100) DEFAULT NULL,
  `skrd_no` varchar(100) DEFAULT NULL,
  `tgl_terbit_skrd` date DEFAULT NULL,
  `biaya_retribusi` int(11) DEFAULT NULL,
  `tgl_bayar_retribusi` date DEFAULT NULL,
  `tgl_surat_keluar` date DEFAULT NULL,
  `info_01` varchar(100) DEFAULT NULL COMMENT '0= BA; 1=REVISI',
  `info_02` varchar(100) DEFAULT NULL,
  `info_03` varchar(100) DEFAULT NULL,
  `info_04` varchar(100) DEFAULT NULL,
  `info_05` varchar(100) DEFAULT NULL,
  `info_06` varchar(100) DEFAULT NULL,
  `info_07` varchar(100) DEFAULT NULL,
  `info_08` varchar(100) DEFAULT NULL,
  `info_09` varchar(100) DEFAULT NULL,
  `info_10` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_ijin` */

/*Table structure for table `tb_mapping_vendor` */

DROP TABLE IF EXISTS `tb_mapping_vendor`;

CREATE TABLE `tb_mapping_vendor` (
  `AREA_KODE` int(11) NOT NULL,
  `PAKET_JENIS` int(11) NOT NULL,
  `VENDOR_ID` int(11) NOT NULL,
  `MAPPING_TAHUN` int(11) NOT NULL,
  `ZONE` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`AREA_KODE`,`PAKET_JENIS`,`VENDOR_ID`,`MAPPING_TAHUN`),
  KEY `FK_RELATIONSHIP_5` (`PAKET_JENIS`),
  KEY `FK_RELATIONSHIP_6` (`VENDOR_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_mapping_vendor` */

/*Table structure for table `tb_pagu_kontrak` */

DROP TABLE IF EXISTS `tb_pagu_kontrak`;

CREATE TABLE `tb_pagu_kontrak` (
  `VENDOR_ID` int(11) NOT NULL,
  `PAKET_JENIS` int(11) NOT NULL,
  `PAGU_KONTRAK` decimal(16,0) NOT NULL,
  `TERPAKAI` decimal(16,4) NOT NULL,
  `RANKING` int(11) NOT NULL DEFAULT '0',
  `NO_PJN` varchar(500) DEFAULT NULL,
  `TGL_PJN` date DEFAULT NULL,
  `NO_RKS` varchar(500) DEFAULT NULL,
  `TGL_RKS` date DEFAULT NULL,
  `NO_SPP` varchar(500) DEFAULT NULL,
  `TGL_SPP` date DEFAULT NULL,
  `NO_PENAWARAN` varchar(500) DEFAULT NULL,
  `TGL_PENAWARAN` date DEFAULT NULL,
  `PAGU_KONTRAK_SBLM_UPDATE` decimal(16,0) NOT NULL,
  PRIMARY KEY (`VENDOR_ID`,`PAKET_JENIS`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_pagu_kontrak` */

/*Table structure for table `tb_pagu_kontrak_update` */

DROP TABLE IF EXISTS `tb_pagu_kontrak_update`;

CREATE TABLE `tb_pagu_kontrak_update` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) NOT NULL,
  `paket_jenis` int(11) NOT NULL,
  `pagu_kontrak_sebelum_update` decimal(16,0) NOT NULL,
  `pagu_kontrak_setelah_update` decimal(16,0) NOT NULL,
  `file_bukti` varchar(256) NOT NULL,
  `update_by` varchar(100) NOT NULL,
  `update_date` date NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_pagu_kontrak_update` */

/*Table structure for table `tb_paket` */

DROP TABLE IF EXISTS `tb_paket`;

CREATE TABLE `tb_paket` (
  `PAKET_JENIS` int(11) NOT NULL,
  `PAKET_DESKRIPSI` varchar(50) NOT NULL,
  `SATUAN` varchar(20) NOT NULL,
  `PAKET_DESKRIPSI2` varchar(500) DEFAULT NULL,
  `STATUS` int(11) NOT NULL COMMENT '0 disable 1 enable',
  PRIMARY KEY (`PAKET_JENIS`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_paket` */

insert  into `tb_paket`(`PAKET_JENIS`,`PAKET_DESKRIPSI`,`SATUAN`,`PAKET_DESKRIPSI2`,`STATUS`) values 
(1,'PAKET 1 (KHSJ SR, APP)','Pelanggan','PAKET 1 (PEMASANGAN SAMBUNGAN RUMAH DAN PEMASANGAN ALAT PEMBATAS DAN PENGUKUR APP 1 PHASA, 3 PHASA TEGANGAN RENDAH TAHUN 2019)',1),
(2,'PAKET 2 (KHSJ SUTM 20 kV pada Tiang Besi)','kMS','PAKET 2 (PEMBANGUNAN JARINGAN DISTRIBUSI SUTM 20 KV PADA TIANG BESI)',1),
(3,'PAKET 3 (KHSJ SUTM 20 kV pada Tiang Beton)','kMS','PAKET 3 (PEMBANGUNAN JARINGAN DISTRIBUSI SUTM 20 KV PADA TIANG BETON',1),
(4,'PAKET 4 (KHSJ JTR & GARDU DISTRIBUSI 20 kV','kMS','PAKET 4 (PEMBANGUNAN JARINGAN DISTRIBUSI TEGANGAN RENDAH DAN GARDU DISTRIBUSI 20 KV)',1),
(5,'PAKET 5 (KHSJ SKTM & GARDU HUBUNG 20 kV)','kMS','PAKET 5 (PEMBANGUNAN JARINGAN DISTRIBUSI SALURAN KABEL TEGANGAN MENENGAH (SKTM) DAN GARDU HUBUNG (GH)  20 KV)',1);

/*Table structure for table `tb_pembayaran` */

DROP TABLE IF EXISTS `tb_pembayaran`;

CREATE TABLE `tb_pembayaran` (
  `SPJ_NO` varchar(100) NOT NULL,
  `PEMBAYARAN_NOMINAL` decimal(16,2) NOT NULL,
  `PEMBAYARAN_TANGGAL` date NOT NULL,
  `PEMBAYARAN_BASTP` varchar(30) DEFAULT NULL,
  `INPUT_PAYMENT_DATE` date NOT NULL,
  `PEMBAYARAN_DESKRIPSI` text,
  `PEMBAYARAN_INPUT_USER` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_pembayaran` */

/*Table structure for table `tb_progress` */

DROP TABLE IF EXISTS `tb_progress`;

CREATE TABLE `tb_progress` (
  `SPJ_NO` varchar(100) NOT NULL,
  `PROGRESS_DATE` date NOT NULL,
  `PROGRESS_PENGAWAS` varchar(30) NOT NULL,
  `PROGRESS_NOTES` varchar(300) NOT NULL,
  `PROGRESS_VALUE` int(11) NOT NULL,
  `REALISASI` int(11) DEFAULT '0',
  `INPUT_PROGRESS_DATE` date NOT NULL,
  `PROGRESS_INPUT_USER` varchar(30) NOT NULL,
  PRIMARY KEY (`SPJ_NO`,`PROGRESS_DATE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_progress` */

/*Table structure for table `tb_rating` */

DROP TABLE IF EXISTS `tb_rating`;

CREATE TABLE `tb_rating` (
  `RATING_LAPORAN_AUDIT` varchar(3) NOT NULL,
  `RATING_LAPORAN_INHOUSE` varchar(4) NOT NULL,
  `RATING_KEKAYAAN_MIN` decimal(16,0) NOT NULL,
  `RATING_KEKAYAAN_MAX` decimal(16,0) NOT NULL,
  PRIMARY KEY (`RATING_LAPORAN_AUDIT`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_rating` */

insert  into `tb_rating`(`RATING_LAPORAN_AUDIT`,`RATING_LAPORAN_INHOUSE`,`RATING_KEKAYAAN_MIN`,`RATING_KEKAYAAN_MAX`) values 
('-','-',0,0),
('1A ','1AA',1000000000,1799999999),
('2A ','2AA',1800000000,3599999999),
('3A ','3AA',3600000000,17999999999),
('4A ','4AA',18000000000,84999999999),
('5A ','5AA',85000000000,85000000000),
('A ','AA',900000000,999999999),
('B ','BB',815000000,899999999),
('C ','CC',725000000,814999999),
('D ','DD',550000000,724999999),
('E ','EE',450000000,549999999),
('F ','FF',280000000,449999999),
('G ','GG',100000000,279999999),
('H ','HH',0,99999999),
('N','N',0,0),
('NB','NB',0,0),
('NQ','NQ',0,0),
('O','O',0,0);

/*Table structure for table `tb_role` */

DROP TABLE IF EXISTS `tb_role`;

CREATE TABLE `tb_role` (
  `role_id` int(11) NOT NULL,
  `role_nama` varchar(50) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_role` */

insert  into `tb_role`(`role_id`,`role_nama`) values 
(0,'Admin UIWSU'),
(1,'admin'),
(2,'Manager'),
(3,'KSA'),
(4,'Pengadaan'),
(5,'Pengawas'),
(6,'APD'),
(7,'Perijinan'),
(8,'admin bidang'),
(9,'Admin Lakdan'),
(10,'Admin Rendan'),
(11,'Pejabat Pengadaan'),
(12,'Monitor Kanwil'),
(13,'Input SKKIO'),
(14,'Perencanaan Kanwil');

/*Table structure for table `tb_skko_i` */

DROP TABLE IF EXISTS `tb_skko_i`;

CREATE TABLE `tb_skko_i` (
  `SKKI_JENIS` char(4) NOT NULL,
  `SKKI_NO` varchar(100) NOT NULL,
  `AREA_KODE` int(11) NOT NULL,
  `SKKI_NILAI` decimal(16,0) NOT NULL,
  `SKKI_TERPAKAI` decimal(16,2) NOT NULL DEFAULT '0.00',
  `SKKI_TANGGAL` date NOT NULL,
  `paket_pekerjaan` varchar(100) DEFAULT NULL,
  `revisi` int(11) DEFAULT '0',
  `flag` int(11) NOT NULL DEFAULT '0',
  `tahun` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `update_by` varchar(100) NOT NULL,
  `update_date` date NOT NULL,
  PRIMARY KEY (`SKKI_NO`),
  KEY `FK_RELATIONSHIP_1` (`AREA_KODE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_skko_i` */

/*Table structure for table `tb_spj` */

DROP TABLE IF EXISTS `tb_spj`;

CREATE TABLE `tb_spj` (
  `SPJ_NO` varchar(100) NOT NULL,
  `VENDOR_ID` int(11) NOT NULL,
  `SKKI_NO` varchar(100) NOT NULL,
  `PAKET_JENIS` int(11) DEFAULT NULL,
  `SPJ_NILAI` decimal(16,0) NOT NULL,
  `SPJ_TANGGAL_MULAI` date NOT NULL,
  `SPJ_TANGGAL_AKHIR` date NOT NULL,
  `SPJ_DESKRIPSI` varchar(300) DEFAULT NULL,
  `SPJ_STATUS` int(11) NOT NULL COMMENT '0 = KHS; 1=NON KHS',
  `SPJ_ADD_NILAI` decimal(16,0) NOT NULL,
  `SPJ_ADD_TANGGAL` date DEFAULT NULL,
  `SPJ_INPUT_DATE` date NOT NULL,
  `SPJ_INPUT_USER` varchar(30) NOT NULL,
  `SPJ_TARGET` decimal(16,4) DEFAULT '0.0000',
  `AREA_KODE` int(11) NOT NULL,
  `NAMA_MANAGER` varchar(50) DEFAULT NULL,
  `DIREKSI_PEKERJAAN` varchar(50) DEFAULT NULL,
  `NOMOR_PJN` varchar(50) DEFAULT NULL,
  `TGL_PJN` date DEFAULT NULL,
  `DIREKSI_LAPANGAN` varchar(100) DEFAULT NULL,
  `gangguan` int(11) NOT NULL DEFAULT '0',
  `PPN` decimal(16,4) NOT NULL,
  `MIN_PPN` decimal(16,4) NOT NULL,
  `SPJ_TARGET_AWAL` decimal(16,4) NOT NULL,
  `tanggal_addendum` date NOT NULL DEFAULT '0000-00-00',
  `tgl_bastp` date NOT NULL,
  `pengawas_lap` varchar(100) NOT NULL,
  PRIMARY KEY (`SPJ_NO`,`SKKI_NO`),
  KEY `FK_RELATIONSHIP_10` (`PAKET_JENIS`),
  KEY `FK_RELATIONSHIP_8` (`SKKI_NO`),
  KEY `FK_RELATIONSHIP_9` (`VENDOR_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_spj` */

/*Table structure for table `tb_termin` */

DROP TABLE IF EXISTS `tb_termin`;

CREATE TABLE `tb_termin` (
  `spj_no` varchar(100) NOT NULL,
  `termin_1` int(11) NOT NULL,
  `termin_2` int(11) DEFAULT NULL,
  `termin_3` int(11) DEFAULT '0',
  `termin_4` int(11) DEFAULT '0',
  `termin_5` int(11) DEFAULT '0',
  `status` int(11) NOT NULL COMMENT '0= non termin;1= termin',
  `keterangan` varchar(20) NOT NULL,
  `evaluasi` int(11) NOT NULL DEFAULT '0',
  `verifikasi_mb` int(11) NOT NULL DEFAULT '0',
  `catatan_verifikasi_mb` text NOT NULL,
  `verifikasi_mup3` int(11) NOT NULL DEFAULT '0',
  `catatan_verifikasi_mup3` text NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_termin` */

/*Table structure for table `tb_upload_dok` */

DROP TABLE IF EXISTS `tb_upload_dok`;

CREATE TABLE `tb_upload_dok` (
  `id_dok` int(11) NOT NULL AUTO_INCREMENT,
  `spj_no` varchar(100) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `file_dok` varchar(100) NOT NULL,
  PRIMARY KEY (`id_dok`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_upload_dok` */

/*Table structure for table `tb_user` */

DROP TABLE IF EXISTS `tb_user`;

CREATE TABLE `tb_user` (
  `USERNAME` varchar(30) NOT NULL,
  `role_id` int(11) NOT NULL,
  `AREA_KODE` int(11) NOT NULL,
  `PASSWORD` varchar(50) NOT NULL,
  `USER_STATUS` int(1) NOT NULL DEFAULT '0',
  `email` varchar(500) DEFAULT NULL,
  `jabatan` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`USERNAME`),
  KEY `FK_RELATIONSHIP_7` (`AREA_KODE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_user` */

insert  into `tb_user`(`USERNAME`,`role_id`,`AREA_KODE`,`PASSWORD`,`USER_STATUS`,`email`,`jabatan`) values 
('admin',1,54000,'admin',2,'fadli.januar@pln.co.id','AASTI');

/*Table structure for table `tb_vendor` */

DROP TABLE IF EXISTS `tb_vendor`;

CREATE TABLE `tb_vendor` (
  `VENDOR_ID` int(11) NOT NULL,
  `VENDOR_NAMA` varchar(100) NOT NULL,
  `TAHUN` int(11) NOT NULL,
  `DIREKSI_VENDOR` varchar(500) DEFAULT NULL,
  `EMAIL` varchar(500) DEFAULT NULL,
  `TELEPON` varchar(50) DEFAULT NULL,
  `STATUS` int(11) NOT NULL DEFAULT '0' COMMENT 'Blocked 1, Unblocked 0',
  `EMAIL_2` varchar(500) DEFAULT NULL,
  `JABATAN` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`VENDOR_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_vendor` */

/*Table structure for table `tb_vendor_non_khs` */

DROP TABLE IF EXISTS `tb_vendor_non_khs`;

CREATE TABLE `tb_vendor_non_khs` (
  `SPJ_NO` varchar(100) NOT NULL,
  `NAMA_VENDOR` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_vendor_non_khs` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
