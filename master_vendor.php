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

                                <form role="form" action="master_vendor_submit.php" method="post">
                                    <div class="form-group">
                                        <label for="Area">Nama Vendor</label>
                                        <input type="text" class="form-control" placeholder="Huruf KAPITAL misal : PT XXXX" name="vendor_nama" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="Vendor">Tahun Pekerjaan</label>
                                        <input type="text" class="form-control" placeholder="misal: 2020" name="tahun" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="Vendor">Direksi Vendor</label>
                                        <input type="text" class="form-control" placeholder="misal: Budi Supardi" name="direksi_vendor" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="Vendor">Jabatan</label>
                                        <input type="text" class="form-control" name="jabatan" value="Direktur Utama" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="Vendor">Email </label>
                                        <input type="text" class="form-control" placeholder="misal: ptx@gmail.com" name="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="Vendor">Telepon</label>
                                        <input type="text" class="form-control" placeholder="misal: 08123456789" name="telepon" required>
                                    </div>
                                    <button type="submit" class="btn btn-info"><a href="/khs/kecepatan_kerja.php"></a>Submit</button>
                                </form>
                            </div>
                        </section>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <section class="panel">
                            <header class="panel-heading">tabel vendor pekerjaan</header>
                            <div class="panel-body table-responsive">
                                <div class="demo-html"></div>
                                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">

                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Vendor</th>
                                            <th>Tahun</th>
                                            <th>Direksi Vendor</th>
                                            <th>Email</th>
                                            <th>Telepon</th>
                                            <th>Jabatan</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $count = "SELECT * from tb_vendor";
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

                                        $sql = "SELECT vendor_nama, tahun, direksi_vendor, email, telepon, jabatan,vendor_id from tb_vendor";
                                        // echo  $sql;
                                        $resultQuery = mysqli_query($mysqli, $sql);
                                        while ($rows = mysqli_fetch_row($resultQuery)) {
                                            $data[] = $rows;
                                        }
                                        for ($i = 0; $i < count($data); $i++) {
                                            $vendor_nama     = $data[$i][0];
                                            $tahun     = $data[$i][1];
                                            $direksi_vendor = $data[$i][2];
                                            $email = $data[$i][3];
                                            $telepon = $data[$i][4];
                                            $jabatan = $data[$i][5];
                                            $vendor_id = $data[$i][6];
                                            $a = ($i + 1) + (($currentpage - 1) * $rowsperpage);
                                            $delete_action = "<a href='master_vendor_delete.php?vendor_id=$vendor_id' onclick='return confirm(\"Hapus : " . $vendor_nama . "?\")'>Delete</a>";
                                            $edit_action = "<a href='master_vendor_edit.php?vendor_id=$vendor_id'>Edit</a>";

                                            echo "<tr><td>$a</td>
										  <td>$vendor_nama </a></td>
										  <td>$tahun</td>
										  <td>$direksi_vendor</td>
										  <td>$email</td>
										  <td>$telepon</td>
										  <td>$jabatan</td>
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