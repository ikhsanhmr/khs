-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 02, 2021 at 07:55 AM
-- Server version: 8.0.23
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_khs_update`
--

-- --------------------------------------------------------

--
-- Table structure for table `penilaian_deskripsi`
--

CREATE TABLE `penilaian_deskripsi` (
  `id_deskripsi` int NOT NULL,
  `deskripsi` varchar(200) NOT NULL,
  `bobot` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penilaian_deskripsi`
--

INSERT INTO `penilaian_deskripsi` (`id_deskripsi`, `deskripsi`, `bobot`) VALUES
(1, 'Mutu', 30),
(2, 'SDM dan Keuangan', 15),
(5, 'Lingkungan, K3 & APD', 30),
(6, 'Administrasi', 10),
(7, 'Komunikasi dan Responsiveness', 15);

-- --------------------------------------------------------

--
-- Table structure for table `penilaian_kriteria`
--

CREATE TABLE `penilaian_kriteria` (
  `id_kriteria` int NOT NULL,
  `id_deskripsi` int NOT NULL,
  `kriteria` varchar(200) NOT NULL,
  `bobot` decimal(16,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penilaian_kriteria`
--

INSERT INTO `penilaian_kriteria` (`id_kriteria`, `id_deskripsi`, `kriteria`, `bobot`) VALUES
(1, 1, 'Ketaatan terhadap standard kontruksi yang berlaku sesuai kontrak', '2.00'),
(2, 1, 'Kemampuan menyelesaikan pekerjaan tepat waktu', '2.00'),
(3, 1, 'Tersedianya peralatan kerja yang sesuai dengan bidang pekerjaan yang sesuai dengan bidang pekerjaan yang dilaksanakan', '1.00'),
(4, 1, 'Unjuk kerja peralatan/barang setelah komisioning/beroperasi dan selama masa garansi', '1.00'),
(5, 2, 'Kompetensi Pengawas pekerjaan', '0.50'),
(6, 2, 'Mempunyai regu pelaksana yang kompeten', '0.50'),
(7, 2, 'Hubungan industrial Karyawan (Hubungan Kerja Internal KSO)', '0.50'),
(8, 2, 'Kemampuan keuangan dalam pembiayaan proyek', '1.50'),
(9, 5, 'Kelengkapan peralatan APD', '2.00'),
(10, 5, 'Kedisiplinan Penggunaan APD', '1.00'),
(11, 5, 'Kualitas peralatan APD', '1.00'),
(12, 5, 'Penerapan rambu-rambu dalam pekerjaan', '1.00'),
(13, 5, 'Keamanan dan kebersihan tempat kerja', '1.00'),
(14, 6, 'Ketaatan terhadap peraturan Pemerintah dan PLN', '0.40'),
(15, 6, 'Kelengkapan Dokumen sebelum Pekerjaan dimulai (IK,SOP,Approval Drawing / Design)', '0.40'),
(16, 6, 'Kelengkapan Dokumen saat pelaksanaan pekerjaan (Overall Schedule Project dan S-Curve dan monitoring nilai perkiraan realisasi progress)', '0.40'),
(17, 6, 'Kelengkapan Dokumen setelah pekerjaan selesai (Hasil Site Test & Komisioning)', '0.40'),
(18, 6, 'Kecepatan penyerahan dokumen pekerjaan ke PLN untuk penyelesaian penagihan kontrak', '0.40'),
(19, 7, 'Kemudahan untuk dihubungi dalam berkoordinasi dengan Tim Direksi Pekerjaan/lapangan/pengawas', '0.40'),
(20, 7, 'Kemudahan bekerjasama dengan unit setempat', '0.60'),
(21, 7, 'Kecepatan kemampuan menyelesaikan masalah sosial di lapangan', '1.00'),
(22, 7, 'Kecepatan kemampuan menyelesaikan masalah teknis di lapangan', '1.00');

-- --------------------------------------------------------

--
-- Table structure for table `penilaian_nilai`
--

CREATE TABLE `penilaian_nilai` (
  `id_nilai` int NOT NULL,
  `id_kriteria` int NOT NULL,
  `spj_no` varchar(100) NOT NULL,
  `nilai` int NOT NULL,
  `bobot` decimal(16,2) NOT NULL,
  `id_deskripsi` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_addendum`
--

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
  `TARGET_AWAL` decimal(16,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_area`
--

CREATE TABLE `tb_area` (
  `AREA_KODE` int NOT NULL,
  `AREA_NAMA` varchar(100) NOT NULL,
  `AREA_ZONE` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_area`
--

INSERT INTO `tb_area` (`AREA_KODE`, `AREA_NAMA`, `AREA_ZONE`) VALUES
(54000, 'UIWSU', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_dokumen`
--

CREATE TABLE `tb_dokumen` (
  `id_dok` int NOT NULL,
  `nama_dok` varchar(100) NOT NULL,
  `spj_no` varchar(100) NOT NULL,
  `tgl_serah` date NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `jumlah_dok` int NOT NULL,
  `revisi-ke` int NOT NULL,
  `info_01` int NOT NULL COMMENT '0= MURNI; 1=REVISI',
  `info_02` int NOT NULL,
  `info_03` int NOT NULL,
  `info_04` int NOT NULL,
  `info_05` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_fin_vendor`
--

CREATE TABLE `tb_fin_vendor` (
  `VENDOR_ID` int NOT NULL,
  `RATING_LAPORAN_AUDIT` varchar(5) NOT NULL,
  `FIN_LIMIT` decimal(16,0) NOT NULL,
  `FIN_CURRENT` decimal(16,2) NOT NULL,
  `FIN_LIMIT_PERTAMA` decimal(16,0) NOT NULL,
  `RATING_LAPORAN_AUDIT_PERTAMA` varchar(5) NOT NULL,
  `UPDATE_BY` varchar(100) NOT NULL,
  `UPDATE_DATE` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_fin_vendor`
--

INSERT INTO `tb_fin_vendor` (`VENDOR_ID`, `RATING_LAPORAN_AUDIT`, `FIN_LIMIT`, `FIN_CURRENT`, `FIN_LIMIT_PERTAMA`, `RATING_LAPORAN_AUDIT_PERTAMA`, `UPDATE_BY`, `UPDATE_DATE`) VALUES
(1, '1A ', '100', '1.00', '100', '1A ', 'admin', '2021-07-02 11:26:19');

-- --------------------------------------------------------

--
-- Table structure for table `tb_fin_vendor_update`
--

CREATE TABLE `tb_fin_vendor_update` (
  `no` int NOT NULL,
  `vendor_id` int NOT NULL,
  `rating_laporan_audit_sebelum_update` varchar(5) NOT NULL,
  `rating_laporan_audit_setelah_update` varchar(5) NOT NULL,
  `fin_limit_sebelum_update` decimal(16,0) NOT NULL,
  `fin_limit_setelah_update` decimal(16,0) NOT NULL,
  `fin_update_user` varchar(30) NOT NULL,
  `fin_update_date` date NOT NULL,
  `file_bukti` varchar(256) NOT NULL,
  `status` varchar(10) NOT NULL,
  `update_by` varchar(100) NOT NULL,
  `update_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_ijin`
--

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
  `biaya_retribusi` int DEFAULT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `tb_mapping_vendor`
--

CREATE TABLE `tb_mapping_vendor` (
  `AREA_KODE` int NOT NULL,
  `PAKET_JENIS` int NOT NULL,
  `VENDOR_ID` int NOT NULL,
  `MAPPING_TAHUN` int NOT NULL,
  `ZONE` int NOT NULL DEFAULT '0',
  `UPDATE_BY` varchar(100) NOT NULL,
  `UPDATE_DATE` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_mapping_vendor`
--

INSERT INTO `tb_mapping_vendor` (`AREA_KODE`, `PAKET_JENIS`, `VENDOR_ID`, `MAPPING_TAHUN`, `ZONE`, `UPDATE_BY`, `UPDATE_DATE`) VALUES
(54000, 1, 1, 2021, 0, 'admin', '2021-07-02 11:26:44');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pagu_kontrak`
--

CREATE TABLE `tb_pagu_kontrak` (
  `VENDOR_ID` int NOT NULL,
  `PAKET_JENIS` int NOT NULL,
  `PAGU_KONTRAK` decimal(16,0) NOT NULL,
  `TERPAKAI` decimal(16,4) NOT NULL,
  `RANKING` int NOT NULL DEFAULT '0',
  `NO_PJN` varchar(500) DEFAULT NULL,
  `TGL_PJN` date DEFAULT NULL,
  `NO_RKS` varchar(500) DEFAULT NULL,
  `TGL_RKS` date DEFAULT NULL,
  `NO_SPP` varchar(500) DEFAULT NULL,
  `TGL_SPP` date DEFAULT NULL,
  `NO_PENAWARAN` varchar(500) DEFAULT NULL,
  `TGL_PENAWARAN` date DEFAULT NULL,
  `PAGU_KONTRAK_SBLM_UPDATE` decimal(16,0) NOT NULL,
  `TGL_AKHIR` date NOT NULL,
  `UPDATE_BY` varchar(100) NOT NULL,
  `UPDATE_DATE` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_pagu_kontrak`
--

INSERT INTO `tb_pagu_kontrak` (`VENDOR_ID`, `PAKET_JENIS`, `PAGU_KONTRAK`, `TERPAKAI`, `RANKING`, `NO_PJN`, `TGL_PJN`, `NO_RKS`, `TGL_RKS`, `NO_SPP`, `TGL_SPP`, `NO_PENAWARAN`, `TGL_PENAWARAN`, `PAGU_KONTRAK_SBLM_UPDATE`, `TGL_AKHIR`, `UPDATE_BY`, `UPDATE_DATE`) VALUES
(1, 1, '99009', '1.0000', 4, '09877/0888', '2021-07-02', '098/088', '2021-07-02', '0990/0099', '2021-07-02', '0990/099', '2021-07-02', '0', '2021-07-02', 'admin', '2021-07-02 11:25:40');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pagu_kontrak_update`
--

CREATE TABLE `tb_pagu_kontrak_update` (
  `no` int NOT NULL,
  `vendor_id` int NOT NULL,
  `paket_jenis` int NOT NULL,
  `pagu_kontrak_sebelum_update` decimal(16,0) NOT NULL,
  `pagu_kontrak_setelah_update` decimal(16,0) NOT NULL,
  `file_bukti` varchar(256) NOT NULL,
  `update_by` varchar(100) NOT NULL,
  `update_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_paket`
--

CREATE TABLE `tb_paket` (
  `PAKET_JENIS` int NOT NULL,
  `PAKET_DESKRIPSI` varchar(50) NOT NULL,
  `SATUAN` varchar(20) NOT NULL,
  `PAKET_DESKRIPSI2` varchar(500) DEFAULT NULL,
  `STATUS` int NOT NULL COMMENT '0 disable 1 enable',
  `UPDATE_BY` varchar(100) NOT NULL,
  `UPDATE_DATE` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_paket`
--

INSERT INTO `tb_paket` (`PAKET_JENIS`, `PAKET_DESKRIPSI`, `SATUAN`, `PAKET_DESKRIPSI2`, `STATUS`, `UPDATE_BY`, `UPDATE_DATE`) VALUES
(1, 'PAKET 1 ( KHS)', 'kMS', 'PAKET 1 (PEMASANGAN SAMBUNGAN RUMAH DAN PEMASANGAN ALAT PEMBATAS DAN PENGUKUR APP 1 PHASA', 1, 'admin', '2021-07-02 11:24:17');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pembayaran`
--

CREATE TABLE `tb_pembayaran` (
  `SPJ_NO` varchar(100) NOT NULL,
  `PEMBAYARAN_NOMINAL` decimal(16,2) NOT NULL,
  `PEMBAYARAN_TANGGAL` date NOT NULL,
  `PEMBAYARAN_BASTP` varchar(30) DEFAULT NULL,
  `INPUT_PAYMENT_DATE` date NOT NULL,
  `PEMBAYARAN_DESKRIPSI` text,
  `PEMBAYARAN_INPUT_USER` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_progress`
--

CREATE TABLE `tb_progress` (
  `SPJ_NO` varchar(100) NOT NULL,
  `PROGRESS_DATE` date NOT NULL,
  `PROGRESS_PENGAWAS` varchar(30) NOT NULL,
  `PROGRESS_NOTES` varchar(300) NOT NULL,
  `PROGRESS_VALUE` int NOT NULL,
  `REALISASI` int DEFAULT '0',
  `INPUT_PROGRESS_DATE` date NOT NULL,
  `PROGRESS_INPUT_USER` varchar(30) NOT NULL,
  `NO_TUG9` varchar(100) NOT NULL,
  `TGL_TUG9` date NOT NULL,
  `NO_TUG10` varchar(100) NOT NULL,
  `TGL_TUG10` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_rating`
--

CREATE TABLE `tb_rating` (
  `RATING_LAPORAN_AUDIT` varchar(3) NOT NULL,
  `RATING_LAPORAN_INHOUSE` varchar(4) NOT NULL,
  `RATING_KEKAYAAN_MIN` decimal(16,0) NOT NULL,
  `RATING_KEKAYAAN_MAX` decimal(16,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_rating`
--

INSERT INTO `tb_rating` (`RATING_LAPORAN_AUDIT`, `RATING_LAPORAN_INHOUSE`, `RATING_KEKAYAAN_MIN`, `RATING_KEKAYAAN_MAX`) VALUES
('-', '-', '0', '0'),
('1A ', '1AA', '1000000000', '1799999999'),
('2A ', '2AA', '1800000000', '3599999999'),
('3A ', '3AA', '3600000000', '17999999999'),
('4A ', '4AA', '18000000000', '84999999999'),
('5A ', '5AA', '85000000000', '85000000000'),
('A ', 'AA', '900000000', '999999999'),
('B ', 'BB', '815000000', '899999999'),
('C ', 'CC', '725000000', '814999999'),
('D ', 'DD', '550000000', '724999999'),
('E ', 'EE', '450000000', '549999999'),
('F ', 'FF', '280000000', '449999999'),
('G ', 'GG', '100000000', '279999999'),
('H ', 'HH', '0', '99999999'),
('N', 'N', '0', '0'),
('NB', 'NB', '0', '0'),
('NQ', 'NQ', '0', '0'),
('O', 'O', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tb_role`
--

CREATE TABLE `tb_role` (
  `role_id` int NOT NULL,
  `role_nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_role`
--

INSERT INTO `tb_role` (`role_id`, `role_nama`) VALUES
(0, 'Admin WRKR'),
(1, 'admin'),
(2, 'Manager'),
(3, 'KSA'),
(4, 'Pengadaan'),
(5, 'Pengawas'),
(6, 'APD'),
(7, 'Perijinan'),
(8, 'admin bidang'),
(9, 'Admin Lakdan'),
(10, 'Admin Rendan'),
(11, 'Pejabat Pengadaan'),
(12, 'Monitor Kanwil'),
(13, 'Input SKKIO'),
(14, 'Perencanaan Kanwil');

-- --------------------------------------------------------

--
-- Table structure for table `tb_skko_i`
--

CREATE TABLE `tb_skko_i` (
  `SKKI_JENIS` char(4) NOT NULL,
  `SKKI_NO` varchar(100) NOT NULL,
  `AREA_KODE` int NOT NULL,
  `SKKI_NILAI` decimal(16,0) NOT NULL,
  `SKKI_TERPAKAI` decimal(16,2) NOT NULL DEFAULT '0.00',
  `SKKI_TANGGAL` date NOT NULL,
  `paket_pekerjaan` varchar(100) DEFAULT NULL,
  `revisi` int DEFAULT '0',
  `flag` int NOT NULL DEFAULT '0',
  `tahun` int NOT NULL,
  `keterangan` text NOT NULL,
  `update_by` varchar(100) NOT NULL,
  `update_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_spj`
--

CREATE TABLE `tb_spj` (
  `SPJ_NO` varchar(100) NOT NULL,
  `VENDOR_ID` int NOT NULL,
  `SKKI_NO` varchar(100) NOT NULL,
  `PAKET_JENIS` int DEFAULT NULL,
  `SPJ_NILAI` decimal(16,0) NOT NULL,
  `SPJ_TANGGAL_MULAI` date NOT NULL,
  `SPJ_TANGGAL_AKHIR` date NOT NULL,
  `SPJ_DESKRIPSI` varchar(300) DEFAULT NULL,
  `SPJ_STATUS` int NOT NULL COMMENT '0 = KHS; 1=NON KHS',
  `SPJ_ADD_NILAI` decimal(16,0) NOT NULL,
  `SPJ_ADD_TANGGAL` date DEFAULT NULL,
  `SPJ_INPUT_DATE` date NOT NULL,
  `SPJ_INPUT_USER` varchar(30) NOT NULL,
  `SPJ_TARGET` decimal(16,4) DEFAULT '0.0000',
  `AREA_KODE` int NOT NULL,
  `NAMA_MANAGER` varchar(50) DEFAULT NULL,
  `DIREKSI_PEKERJAAN` varchar(50) DEFAULT NULL,
  `NOMOR_PJN` varchar(50) DEFAULT NULL,
  `TGL_PJN` date DEFAULT NULL,
  `DIREKSI_LAPANGAN` varchar(100) DEFAULT NULL,
  `gangguan` int NOT NULL DEFAULT '0',
  `PPN` decimal(16,4) NOT NULL,
  `MIN_PPN` decimal(16,4) NOT NULL,
  `SPJ_TARGET_AWAL` decimal(16,4) NOT NULL,
  `tanggal_addendum` date NOT NULL DEFAULT '0000-00-00',
  `tgl_bastp` date NOT NULL,
  `pengawas_lap` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_termin`
--

CREATE TABLE `tb_termin` (
  `spj_no` varchar(100) NOT NULL,
  `termin_1` int NOT NULL,
  `termin_2` int DEFAULT NULL,
  `termin_3` int DEFAULT '0',
  `termin_4` int DEFAULT '0',
  `termin_5` int DEFAULT '0',
  `status` int NOT NULL COMMENT '0= non termin;1= termin',
  `keterangan` varchar(20) NOT NULL,
  `evaluasi` int NOT NULL DEFAULT '0',
  `verifikasi_mb` int NOT NULL DEFAULT '0',
  `catatan_verifikasi_mb` text NOT NULL,
  `verifikasi_mup3` int NOT NULL DEFAULT '0',
  `catatan_verifikasi_mup3` text NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_upload_dok`
--

CREATE TABLE `tb_upload_dok` (
  `id_dok` int NOT NULL,
  `spj_no` varchar(100) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `file_dok` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `USERNAME` varchar(30) NOT NULL,
  `role_id` int NOT NULL,
  `AREA_KODE` int NOT NULL,
  `PASSWORD` varchar(50) NOT NULL,
  `USER_STATUS` int NOT NULL DEFAULT '0',
  `email` varchar(500) DEFAULT NULL,
  `jabatan` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`USERNAME`, `role_id`, `AREA_KODE`, `PASSWORD`, `USER_STATUS`, `email`, `jabatan`) VALUES
('admin', 1, 54000, 'admin', 0, 'hermanxphp@gmail.com', 'AASTI'),
('test', 1, 54000, 'plnriau@635', 0, 'test@test.com', 'AASTI');

-- --------------------------------------------------------

--
-- Table structure for table `tb_vendor`
--

CREATE TABLE `tb_vendor` (
  `VENDOR_ID` int NOT NULL,
  `VENDOR_NAMA` varchar(100) NOT NULL,
  `TAHUN` int NOT NULL,
  `DIREKSI_VENDOR` varchar(500) DEFAULT NULL,
  `EMAIL` varchar(500) DEFAULT NULL,
  `TELEPON` varchar(50) DEFAULT NULL,
  `STATUS` int NOT NULL DEFAULT '0' COMMENT 'Blocked 1, Unblocked 0',
  `EMAIL_2` varchar(500) DEFAULT NULL,
  `JABATAN` varchar(100) DEFAULT NULL,
  `UPDATE_BY` varchar(100) NOT NULL,
  `UPDATE_DATE` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_vendor`
--

INSERT INTO `tb_vendor` (`VENDOR_ID`, `VENDOR_NAMA`, `TAHUN`, `DIREKSI_VENDOR`, `EMAIL`, `TELEPON`, `STATUS`, `EMAIL_2`, `JABATAN`, `UPDATE_BY`, `UPDATE_DATE`) VALUES
(1, 'PT XXX', 2021, 'Budi Doremi', 'hermanxphp@gmail.com', '0893442424', 0, NULL, 'Direktur Utama', 'admin', '2021-07-02 11:24:48');

-- --------------------------------------------------------

--
-- Table structure for table `tb_vendor_non_khs`
--

CREATE TABLE `tb_vendor_non_khs` (
  `SPJ_NO` varchar(100) NOT NULL,
  `NAMA_VENDOR` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `penilaian_deskripsi`
--
ALTER TABLE `penilaian_deskripsi`
  ADD PRIMARY KEY (`id_deskripsi`);

--
-- Indexes for table `penilaian_kriteria`
--
ALTER TABLE `penilaian_kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indexes for table `penilaian_nilai`
--
ALTER TABLE `penilaian_nilai`
  ADD PRIMARY KEY (`id_nilai`);

--
-- Indexes for table `tb_addendum`
--
ALTER TABLE `tb_addendum`
  ADD PRIMARY KEY (`ADDENDUM_NO`,`SPJ_NO`),
  ADD KEY `SPJ_NO` (`SPJ_NO`);

--
-- Indexes for table `tb_area`
--
ALTER TABLE `tb_area`
  ADD PRIMARY KEY (`AREA_KODE`);

--
-- Indexes for table `tb_dokumen`
--
ALTER TABLE `tb_dokumen`
  ADD PRIMARY KEY (`id_dok`);

--
-- Indexes for table `tb_fin_vendor`
--
ALTER TABLE `tb_fin_vendor`
  ADD PRIMARY KEY (`VENDOR_ID`),
  ADD KEY `FK_RELATIONSHIP_3` (`RATING_LAPORAN_AUDIT`);

--
-- Indexes for table `tb_fin_vendor_update`
--
ALTER TABLE `tb_fin_vendor_update`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `tb_mapping_vendor`
--
ALTER TABLE `tb_mapping_vendor`
  ADD PRIMARY KEY (`AREA_KODE`,`PAKET_JENIS`,`VENDOR_ID`,`MAPPING_TAHUN`),
  ADD KEY `FK_RELATIONSHIP_5` (`PAKET_JENIS`),
  ADD KEY `FK_RELATIONSHIP_6` (`VENDOR_ID`);

--
-- Indexes for table `tb_pagu_kontrak`
--
ALTER TABLE `tb_pagu_kontrak`
  ADD PRIMARY KEY (`VENDOR_ID`,`PAKET_JENIS`);

--
-- Indexes for table `tb_pagu_kontrak_update`
--
ALTER TABLE `tb_pagu_kontrak_update`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `tb_paket`
--
ALTER TABLE `tb_paket`
  ADD PRIMARY KEY (`PAKET_JENIS`);

--
-- Indexes for table `tb_progress`
--
ALTER TABLE `tb_progress`
  ADD PRIMARY KEY (`SPJ_NO`,`PROGRESS_DATE`);

--
-- Indexes for table `tb_rating`
--
ALTER TABLE `tb_rating`
  ADD PRIMARY KEY (`RATING_LAPORAN_AUDIT`);

--
-- Indexes for table `tb_role`
--
ALTER TABLE `tb_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `tb_skko_i`
--
ALTER TABLE `tb_skko_i`
  ADD PRIMARY KEY (`SKKI_NO`),
  ADD KEY `FK_RELATIONSHIP_1` (`AREA_KODE`);

--
-- Indexes for table `tb_spj`
--
ALTER TABLE `tb_spj`
  ADD PRIMARY KEY (`SPJ_NO`,`SKKI_NO`),
  ADD KEY `FK_RELATIONSHIP_10` (`PAKET_JENIS`),
  ADD KEY `FK_RELATIONSHIP_8` (`SKKI_NO`),
  ADD KEY `FK_RELATIONSHIP_9` (`VENDOR_ID`);

--
-- Indexes for table `tb_termin`
--
ALTER TABLE `tb_termin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_upload_dok`
--
ALTER TABLE `tb_upload_dok`
  ADD PRIMARY KEY (`id_dok`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`USERNAME`),
  ADD KEY `FK_RELATIONSHIP_7` (`AREA_KODE`);

--
-- Indexes for table `tb_vendor`
--
ALTER TABLE `tb_vendor`
  ADD PRIMARY KEY (`VENDOR_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `penilaian_deskripsi`
--
ALTER TABLE `penilaian_deskripsi`
  MODIFY `id_deskripsi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `penilaian_kriteria`
--
ALTER TABLE `penilaian_kriteria`
  MODIFY `id_kriteria` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `penilaian_nilai`
--
ALTER TABLE `penilaian_nilai`
  MODIFY `id_nilai` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_dokumen`
--
ALTER TABLE `tb_dokumen`
  MODIFY `id_dok` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_fin_vendor_update`
--
ALTER TABLE `tb_fin_vendor_update`
  MODIFY `no` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_pagu_kontrak_update`
--
ALTER TABLE `tb_pagu_kontrak_update`
  MODIFY `no` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_termin`
--
ALTER TABLE `tb_termin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_upload_dok`
--
ALTER TABLE `tb_upload_dok`
  MODIFY `id_dok` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_vendor`
--
ALTER TABLE `tb_vendor`
  MODIFY `VENDOR_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
