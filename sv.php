<?php
session_start();
include_once('lib/config.php');
include_once('lib/function.php');
include_once('lib/check.php');
include_once('lib/terbilang.php');

$kode_area  = $_SESSION['area'];
$area       = select_nama_area($kode_area, $mysqli);
$nama_area  = $area[0][0];

function format_indo($date)
{
    $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

    $tahun = substr($date, 0, 4);
    $bulan = substr($date, 5, 2);
    $tgl   = substr($date, 8, 2);

    $result = $tgl . " " . $BulanIndo[(int)$bulan - 1] . " " . $tahun;
    return ($result);
}

if (!isset($_POST['var_no_spj'])) {
    echo "<script language='javascript'>window.location = 'dl_spj.php'</script>";
} else {
    $no_spj = $_POST['var_no_spj'];
    if (!isset($_POST['var_nama_manager'])) {
        $nama_manager = $_POST['nama_manager'];
        if ($nama_manager == "") {
            echo "<script language='javascript'>window.location = 'dl_spj.php?err=1'</script>";
        }
    } else {
        $nama_manager =  $_POST['var_nama_manager'];
    }

    if ($no_spj == "") {
        echo "<script language='javascript'>window.location = 'dl_spj.php?err=2'</script>";
    }

    $today_f    = date('Y-m-d');
    $today      = format_indo($today_f);

    $no_pjn     = $_POST['var_no_pjn'];
    $tgl_pjn_f  = date('Y-m-d', strtotime($_POST['var_tgl_pjn']));
    $tgl_pjn    = format_indo($tgl_pjn_f);


    $getdata_query = mysqli_query($mysqli, "select * from tb_spj where spj_no = '$no_spj'");
    while ($data_spj = mysqli_fetch_array($getdata_query)) {
        $spj_data[] = $data_spj;
    }

    $dir_vendor     = get_direksi($spj_data[0][1], $mysqli);
    $vendor         = $spj_data[0][1];
    $skkio          = $spj_data[0][2];
    $paket_kerja    = $spj_data[0][3];
    $spj            = $spj_data[0][4];
    $dir_pkj        = $spj_data[0][16];
    $dir_lpg        = $spj_data[0][19];
    $mulai          = date('d-m-Y', strtotime($spj_data[0][5]));
    $sampai         = date('Y-m-d', strtotime($spj_data[0][6]));
    $deskripsi      = $spj_data[0][7];

    $no_pjn     = get_no_pjn($vendor, $paket_kerja, $mysqli);
    $tgl_pjn_f  = date('Y-m-d', strtotime(get_tgl_pjn($vendor, $paket_kerja, $mysqli)));
    $tgl_pjn    = format_indo($tgl_pjn_f);


    $q = "select vendor_nama,paket_deskripsi2
                from tb_vendor a, tb_paket b, tb_mapping_vendor c 
                where a.vendor_id = c.vendor_id
                and c.paket_jenis = b.paket_jenis
                and b.paket_jenis = $paket_kerja
                and a.vendor_id = '$vendor'";
    $p = mysqli_query($mysqli, $q);
    while ($rows2 = mysqli_fetch_array($p)) {
        $data2[] = $rows2;
    }

    $v = select_nama_vendor($vendor, $mysqli);
    $nama_vendor = $v[0][0];

    $p = select_desk_paket($paket_kerja, $mysqli);
    $paket_deskripsi = $p[0][0];

    $ss = "select skki_tanggal from tb_skko_i WHERE skki_no = '$skkio'";
    //echo $ss;
    $skki_search = mysqli_query($mysqli, $ss);
    while ($data_skki = mysqli_fetch_row($skki_search)) {
        $skki_data[] = $data_skki;
    }

    $tgl_skkio_f    = date('Y-m-d', strtotime($skki_data[0][0]));
    $tgl_skkio      = format_indo($tgl_skkio_f);

    $tgl_sampai = format_indo($sampai);
    $HITUNG_HARI = $sampai - $mulai;

?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Dashboard KHS</title>
        <style type="text/css">
            body {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
                font: 13pt "Times New Roman";
            }

            .page {
                width: 210mm;
                min-height: 297mm;
                padding: 20mm;
                margin: auto;
                border-radius: 5px;
                background: white;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            }

            #printarea {
                padding: 10px 0;
                width: 800px;
                margin: auto;
                font: Times New Roman;
                font-size: 12;
            }

            @page {
                size: A4;
                margin: 25mm 25mm 25mm 25mm;

            }

            @media print {

                html,
                body {
                    width: 210mm;
                    height: 297mm;
                }

                .page {
                    margin: 0;
                    border: initial;
                    border-radius: initial;
                    width: initial;
                    min-height: initial;
                    box-shadow: initial;
                    background: initial;
                    page-break-after: always;
                    font-size: 14.5pt;
                }
            }

            @media print {
                #non-printable {
                    display: none;
                }

                #printarea {
                    display: block;
                }

                .tablesorter thead tr {
                    height: 30px;
                    background: #E6E6E6;
                    text-align: left;
                    text-indent: 10px;
                    cursor: pointer;
                }
            }
        </style>
        <script type="text/javascript">
            function printpage() {
                window.print()
            }
        </script>
    </head>

    <body class="page" id="printarea">
        <table width="901" border="0">
            <tr>
                <td height="113" colspan="5">
                    <p>&nbsp;</p>
                </td>
            </tr>
            <tr>
                <td>Nomor</td>
                <td>:</td>
                <td><?php echo $no_spj; ?></td>
                <td width="230">&nbsp;</td>
                <td width="314"><?php /*echo $nama_area;*/ ?>JAKARTA, <?php echo $today; ?></td>
            </tr>
            <tr>
                <td>Surat Sdr. No.</td>
                <td>:</td>
                <td></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td> 1 (satu) berkas</td>
                <td>&nbsp;</td>
                <td>Kepada:</td>
            </tr>
            <!--
        <tr>
            <td>Sifat</td>
            <td>:</td>
            <td>Segera</td>
            <td>&nbsp;</td>
            <td>Kepada:</td>
        </tr>
        -->
            <tr>
                <td width="112">Perihal</td>
                <td width="6">:</td>
                <td width="217"><em><strong>Pesanan Jasa</strong></em></td>
                <td>&nbsp;</td>
                <td><?php echo $nama_vendor; ?></td>
            </tr>

            <tr>
                <td colspan="5">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="5">UP : Direktur Utama</td>
            </tr>
            <tr>
                <td height="21" colspan="5">
                    <p align="justify">Menunjuk Perjanjian Nomor : <?php echo $no_pjn; ?> tanggal <?php echo $tgl_pjn; ?> Tentang Pekerjaan Jasa - <?php echo $paket_deskripsi; ?>, mohon dapat dilaksanakan Pekerjaan Jasa dengan rincian sebagai berikut:</p>
                </td>
            </tr>
        </table>

        <table width="901" style="border-collapse: collapse; border: 1px solid black;">

            <?
            $jumlah = $spj;
            $ppn     = $jumlah * 0.1;
            $total     = $jumlah + $ppn;
            $jaminan_pelaksanaan = $jumlah * 0.04;
            ?>
            <tr class="p-border">
                <td width="64">
                    <div align="center"><strong>No</strong></div>
                </td>
                <td width="299" colspan="-22">
                    <div align="center"><strong>Jenis Pekerjaan</strong></div>
                </td>
                <td width="85">
                    <div align="center"><strong>Sat</strong></div>
                </td>
                <td width="85">
                    <div align="center"><strong>Vol</strong></div>
                </td>
                <td width="170">
                    <div align="center"><strong>Harga Satuan</strong></div>
                </td>
                <td width="170">
                    <div align="center"><strong>Jumlah</strong></div>
                </td>
            </tr>
            <tr>
                <td>
                    <div align="center">1</div>
                </td>
                <td colspan="-22"><?php echo $deskripsi; ?></td>
                <td>
                    <div align="center">Lot</div>
                </td>
                <td>
                    <div align="center">1</div>
                </td>
                <td>
                    <div align="center"><?php echo number_format($spj); ?></div>
                </td>
                <td>
                    <div align="center"><?php echo number_format($jumlah); ?></div>
                </td>
            </tr>
            <tr>
                <td colspan="4" rowspan="3">&nbsp;</td>
                <td><strong>Jumlah</strong></td>
                <td>
                    <div align="center"><? echo number_format($jumlah); ?></div>
                </td>
            </tr>
            <tr>
                <td><strong>Ppn 10%</strong></td>
                <td>
                    <div align="center"><? echo number_format($ppn); ?></div>
                </td>
            </tr>
            <tr>
                <td><strong>Jumlah + PPN 10%</strong></td>
                <td>
                    <div align="center"><? echo number_format($total); ?></div>
                </td>
            </tr>
            <tr>
                <td colspan="4">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6">
                    <font size="3"><strong><i>Terbilang : <?php echo terbilang(str_replace(",", "", $total)); ?></i> </strong></font>
                </td>
            </tr>
        </table>

        <table width="902" border="0">
            <tr>
                <td colspan="2">
                    <ol>
                        <li>
                            <div align="justify">Waktu penyerahan pekerjaan (BASTP) harus dilakukan paling lambat <?php //echo $HITUNG_HARI;
                                                                                                                    ?> 50 (Lima Puluh) hari kalender sejak ditandatanganinya Surat Pesanan Jasa atau sampai dengan <?php echo $tgl_sampai; ?></div>
                        </li>
                        <!--
                <li>
                    <div align="justify">
                    Jaminan Pelaksanaan 4% dari Nilai SPJ atau sebesar <strong>Rp. <?php // echo number_format($jaminan_pelaksanaan);
                                                                                    ?>
                    </strong></div>
                </li>
                -->
                        <li>
                            <div align="justify">Sumber dana untuk pembayaran SPJ ini adalah dari <?php echo $skkio; ?> tanggal <? echo $tgl_skkio; ?></div>
                        </li>
                        <li>
                            <div align="justify">Sebagai Direksi Pekerjaan adalah <?php echo $dir_pkj; ?>, dan <?php echo $dir_lpg ?> sebagai Direksi Lapangan</div>
                        </li>
                        <li>
                            <div align="justify">RAB, Gambar, Metode kerja dan TOR Terlampir</div>
                        </li>
                        <li>
                            <div align="justify">Dalam melaksanakan pekerjaan Pelaksana harus mematuhi dan menerapkan aturan K2/K3</div>
                        </li>
                        <!--
                <li>
                    <div align="justify">Sebagai bukti persetujuan Saudara, harap Surat Pesanan Jasa ini dikembalikan disertai dengan Jaminan Pelaksanaan sesuai 2 butir di surat ini paling lambat 7(Tujuh) Hari Kerja atau tanggal </div>
                </li>
                <li>
                    <div align="justify">Jika Jaminan Pelaksanaan tidak diserahkan sesuai dengan waktu tersebut, maka Surat Pesanan Jasa ini dinyatakan BATAL dengan sendirinya.</div>
                </li>
                -->
                    </ol>
                </td>
            </tr>

            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">Demikian atas perhatian Saudara kami ucapkan terima kasih.</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>

                <td width="441">
                    <div align="center"><b>Setuju Melaksanakan,</b></div>
                </td>

            </tr>
            <tr>

                <td width="441">
                    <div align="center"><strong><?php echo $nama_vendor; ?></strong></div>
                </td>
                <td width="451">
                    <div align="center"><strong>MANAJER</strong></div>
                </td>
            </tr>
            <tr>
                <td>
                    <div align="center"><strong>Direktur Utama</strong></div>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <div align="center"><?php echo strtoupper($dir_vendor) ?></div>
                </td>
                <!--nama dir vendor-->
                <td>
                    <div align="center"><?php echo $nama_manager; ?></div>
                </td>
                <!--nama manajer-->
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">Tembusan: </td>
            </tr>
            <tr>
                <td colspan="2">
                    <ol>
                        <li>General Manager</li>
                        <li>MAN KON, DIST, REN, AGA</li>
                        <li>DM RENKON, DALKON, RENSIS</li>
                        <li>Pejabat Perencana Pengadaan</li>
                        <li>Pejabat Pelaksana Pengadaan</li>
                    </ol>
                </td>
            </tr>
        </table>

        <div id="non-printable">
            <br>
            <center><input type="button" value="Print Laporan" onclick="printpage();"></center>
        </div>

    </body>

    </html>

<?
}
?>