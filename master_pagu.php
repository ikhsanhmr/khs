<?php session_start();
include_once('lib/head.php');
include_once("lib/check.php"); ?>

<script type="text/javascript" src="js/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="datatables/media/css/dataTables.bootstrap.css">
<link rel="stylesheet" type="text/css" href="datatables/examples/resources/syntax/shCore.css">
<style type="text/css" class="init">

</style>

<script type="text/javascript" language="javascript" src="datatables/media/js/jquery.dataTables.js">
</script>
<script type="text/javascript" language="javascript" src="datatables/media/js/dataTables.bootstrap.js">
</script>
<script type="text/javascript" language="javascript" src="datatables/examples/resources/syntax/shCore.js">
</script>

<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>


<body class="skin-black">
    <?php include("lib/header.php"); ?>

    <div class="wrapper row-offcanvas row-offcanvas-left">
        <!-- Left side column. contains the logo and sidebar -->
        <?php include("lib/menu.php"); ?>
        <aside class="right-side">

            <!-- Main content -->
            <section class="content">

                <div class="row">
                    <div class="col-md-12">
                        <section class="panel">
                            <header class="panel-heading">Tambah Vendor Pekerjaan</header>
                            <div class="panel-body">

                                <form role="form" action="master_pagu_submit.php" method="post">
                                    <div class="form-group">
                                        <label for="Vendor">Vendor</label>
                                        <select class="form-control m-b-10" name="vendor_id" id="vendor_id" required>
                                            <option value="">- Pilih Vendor -</option>
                                            <?php
                                            //$data=select_spj_no($kode_area); eidel ubah
                                            $data = select_vendor($mysqli);
                                            for ($i = 0; $i < count($data); $i++) {
                                                $vendor_id = $data[$i][0];
                                                $vendor_nama = $data[$i][1]; ?>
                                                <option value='<?php echo $vendor_id; ?>'><?php echo $vendor_nama; ?></option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="Vendor">Paket Jenis</label>
                                        <select class="form-control m-b-10" name="paket_jenis" id="paket_jenis" required>
                                            <option value="">- Pilih Paket -</option>
                                            <?php
                                            //$data=select_spj_no($kode_area); eidel ubah
                                            $data1 = select_paket_jenis($mysqli);
                                            for ($i = 0; $i < count($data1); $i++) {
                                                $paket_jenis = $data1[$i][0];
                                                $paket_deskripsi = $data1[$i][1]; ?>
                                                <option value='<?php echo $paket_jenis; ?>'><?php echo $paket_deskripsi; ?></option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="Vendor">Nilai Pagu Kontrak Vendor</label>
                                        <input type="text" class="form-control" placeholder="misal: 1479233070" name="nilai_pagu" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="Vendor">Rangking</label>
                                        <input type="text" class="form-control" name="rangking" placeholder="misal: 4">
                                    </div>

                                    <div class="form-group">
                                        <label for="Vendor">Nomor Perjanjian </label>
                                        <input type="text" class="form-control" placeholder="misal: 0034.PJ/HKM.00.01/WRKR/2018" name="no_pjn" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Tanggal Perjanjian</label>
                                        <input type="date" class="form-control" name="tgl_pjn" id="tgl_pjn" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Nomor RKS</label>
                                        <input type="text" class="form-control" name="no_rks" id="no_rks" placeholder="misal: 076.RKS/PRen-P/WRKR/2017" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Tanggal RKS</label>
                                        <input type="date" class="form-control" name="tgl_rks" id="tgl_rks" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Nomor SPP</label>
                                        <input type="text" class="form-control" name="no_spp" id="no_spp" placeholder="misal: 0070/DAN.02.03/WRKR/2018" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Tanggal SPP</label>
                                        <input type="date" class="form-control" name="tgl_spp" id="tgl_spp" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Nomor Penawaran</label>
                                        <input type="text" class="form-control" name="no_penawaran" id="no_penawaran" placeholder="misal: 017/P-TT/PKB/I/2018" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Tanggal Penawaran</label>
                                        <input type="date" class="form-control" name="tgl_penawaran" id="tgl_penawaran" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Tanggal Berakhir Kontrak</label>
                                        <input type="date" class="form-control" name="tgl_akhir" id="tgl_akhir" required>
                                    </div>

                                    <button type="submit" class="btn btn-info">Submit</button>
                                </form>
                            </div>
                        </section>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <section class="panel">
                            <header class="panel-heading">tabel pagu vendor </header>
                            <div class="panel-body table-responsive">
                                <div class="demo-html"></div>
                                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">

                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Vendor</th>
                                            <th>Paket Jenis</th>
                                            <th>Nilai Pagu Kontrak</th>
                                            <th>Rangking</th>
                                            <th>Nomor PJN</th>
                                            <th>Tanggal PJN</th>
                                            <th>Nomor RKS</th>
                                            <th>Tanggal RKS</th>
                                            <th>Nomor SPP</th>
                                            <th>Tanggal SPP</th>
                                            <th>Nomor Penawaran</th>
                                            <th>Tanggal Penawaran</th>
                                            <th>Tanggal Berakhir Kontrak</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $count = "SELECT * from  tb_pagu_kontrak";
                                        $count_res = mysqli_query($mysqli, $count);
                                        $r = mysqli_fetch_row($count_res);
                                        $numrows = $r[0];

                                        // number of rows to show per page
                                        $rowsperpage = 10;
                                        // find out total pages
                                        $totalpages = ceil($numrows / $rowsperpage);

                                        // get the current page or set a default
                                        if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
                                            // cast var as int
                                            $currentpage = (int) $_GET['currentpage'];
                                        } else {
                                            // default page num
                                            $currentpage = 1;
                                        } // end if

                                        // if current page is greater than total pages...
                                        if ($currentpage > $totalpages) {
                                            // set current page to last page
                                            $currentpage = $totalpages;
                                        } // end if
                                        // if current page is less than first page...
                                        if ($currentpage < 1) {
                                            // set current page to first page
                                            $currentpage = 1;
                                        } // end if

                                        // the offset of the list, based on current page
                                        $offset = ($currentpage - 1) * $rowsperpage;

                                        $sql = "SELECT B.VENDOR_NAMA, A.PAKET_JENIS, A.PAGU_KONTRAK, A.RANKING, A.NO_PJN,
									A.TGL_PJN, A.NO_RKS, A.TGL_RKS, A.NO_SPP, A.TGL_SPP, A.NO_PENAWARAN, A.TGL_PENAWARAN, A.VENDOR_ID, TGL_AKHIR
										FROM tb_pagu_kontrak A JOIN tb_vendor B WHERE A.VENDOR_ID=B.VENDOR_ID";
                                        $resultQuery = mysqli_query($mysqli, $sql);
                                        while ($rows = mysqli_fetch_row($resultQuery)) {
                                            $data2[] = $rows;
                                        }
                                        for ($i = 0; $i < count($data2); $i++) {
                                            $vendor_nama     = $data2[$i][0];
                                            $paket_jeniss     = $data2[$i][1];
                                            $pagu_kontrak = $data2[$i][2];
                                            $rangking = $data2[$i][3];
                                            $no_pjn = $data2[$i][4];
                                            $tgl_pjn = $data2[$i][5];
                                            $no_rks = $data2[$i][6];
                                            $tgl_rks = $data2[$i][7];
                                            $no_spp = $data2[$i][8];
                                            $tgl_spp = $data2[$i][9];
                                            $no_penawaran = $data2[$i][10];
                                            $tgl_penawaran = $data2[$i][11];
                                            $vendor_ids = $data2[$i][12];
                                            $tgl_akhir = $data2[$i][13];
                                            $a = ($i + 1) + (($currentpage - 1) * $rowsperpage);
                                            $edit_action = "<a href='master_pagu_edit.php?vendor_id=$vendor_ids&paket_jenis=$paket_jeniss'>Edit</a>";
                                            $delete_action = "<a href='master_pagu_delete.php?vendor_id=$vendor_ids&paket_jenis=$paket_jeniss'onclick='return confirm(\"Hapus : " . $vendor_nama . " di paket " . $paket_jeniss . "?\")'>Delete</a>";

                                            echo "<tr><td>$a</td>
										  <td>$vendor_nama </a></td>
										  <td>$paket_jeniss</td>
										  <td>$pagu_kontrak</td>
										  <td>$rangking</td>
										  <td>$no_pjn</td>
										  <td>$tgl_pjn</td>
										  <td>$no_rks</td>
										  <td>$tgl_rks</td>
										  <td>$no_spp</td>
										  <td>$tgl_spp</td>
										  <td>$no_penawaran</td>
										  <td>$tgl_penawaran</td>
										  <td>$tgl_akhir</td>
										  <td>$edit_action</td>
										  <td>$delete_action</td>
										  ";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
            </section>

        </aside>
    </div>

    <?php include("lib/footer.php"); ?>
</body>

</html>