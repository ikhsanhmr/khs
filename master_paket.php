<?php session_start();
include_once("lib/head.php");
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
                            <header class="panel-heading">Tambah Paket Pekerjaan</header>
                            <div class="panel-body">

                                <form role="form" action="master_paket_submit.php" method="post">
                                    <div class="form-group">
                                        <label for="Area">Paket Jenis</label>
                                        <input type="text" class="form-control" placeholder="misal : 1" name="paket_jenis" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="Vendor">Deskripsi Paket</label>
                                        <input type="text" class="form-control" placeholder="misal: PAKET 1 (KHSJ SR, APP)" name="paket_deskripsi" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="Vendor">Satuan</label>
                                        <input type="text" class="form-control" placeholder="misal: kMS" name="satuan" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="Vendor">Keterangan Paket</label>
                                        <input type="text" class="form-control" placeholder="misal: PAKET 1 (PEMASANGAN SAMBUNGAN RUMAH DAN PEMASANGAN ALAT PEMBATAS DAN PENGUKUR APP 1 PHASA, 3 PHASA TEGANGAN RENDAH TAHUN 2018)" name="paket_deskripsi2" require>
                                        <input type="hidden" class="form-control" name="status" value="1">
                                    </div>
                                    <button type="submit" class="btn btn-info">
                                        <a href="/khs_2020/kecepatan_kerja.php"></a>Submit</button>
                                </form>
                            </div>
                        </section>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <section class="panel">
                            <header class="panel-heading">tabel paket pekerjaan</header>
                            <div class="panel-body table-responsive">
                                <div class="demo-html"></div>
                                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">

                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Paket Jenis</th>
                                            <th>Paket Deskripsi</th>
                                            <th>Satuan</th>
                                            <th>Keterangan Paket</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $count = "SELECT * from tb_paket";
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

                                        $sql = "SELECT paket_jenis, paket_deskripsi, satuan, paket_deskripsi2 from tb_paket";
                                        //echo  $sql;
                                        $resultQuery = mysqli_query($mysqli, $sql);
                                        while ($rows = mysqli_fetch_row($resultQuery)) {
                                            $data[] = $rows;
                                        }
                                        for ($i = 0; $i < count($data); $i++) {
                                            $paket_jenis     = $data[$i][0];
                                            $paket_deskripsi     = $data[$i][1];
                                            $satuan = $data[$i][2];
                                            $paket_deskripsi2 = $data[$i][3];
                                            $a = ($i + 1) + (($currentpage - 1) * $rowsperpage);
                                            $delete_action = "<a href='master_paket_delete.php?paket_jenis=$paket_jenis' onclick='return confirm(\"Hapus : " . $paket_deskripsi . "?\")'>Delete</a>";

                                            echo "<tr><td>$a</td>
										  <td>$paket_jenis </a></td>
										  <td>$paket_deskripsi</td>
										  <td>$satuan</td>
										  <td>$paket_deskripsi2</td>
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