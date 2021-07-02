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
                            <header class="panel-heading">tabel Keterangan rating Finansial </header>
                            <div class="panel-body table-responsive">
                                <div class="demo-html"></div>
                                <table id="" class="table table-striped table-bordered" cellspacing="0" width="100%">

                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Rating Laporan Audit</th>
                                            <th>Rating Laporan Inhouse</th>
                                            <th>Rating Kekayaan Minimum</th>
                                            <th>Rating Kekayaan Maximum</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $count = "SELECT * from  tb_rating";
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

                                        $sql = "SELECT * FROM TB_RATING where rating_laporan_audit!='-'";
                                        //echo  $sql;
                                        $resultQuery = mysqli_query($mysqli, $sql);
                                        while ($rows = mysqli_fetch_row($resultQuery)) {
                                            $data2[] = $rows;
                                        }
                                        for ($i = 0; $i < count($data2); $i++) {
                                            $rating     = $data2[$i][0];
                                            $rating_inhouse     = $data2[$i][1];
                                            $rating_kekayaan_min = $data2[$i][2];
                                            $rating_kekayaan_max = $data2[$i][3];
                                            $a = ($i + 1) + (($currentpage - 1) * $rowsperpage);

                                            echo "<tr><td>$a</td>
										  <td>$rating </a></td>
										  <td>$rating_inhouse</td>
										  <td>$rating_kekayaan_min</td>
										  <td>$rating_kekayaan_max</td>
										  ";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <section class="panel">
                            <header class="panel-heading">Tambah Finansial Vendor</header>
                            <div class="panel-body">

                                <form role="form" action="master_finansial_submit.php" method="post">
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
                                        <label for="Vendor">Pilih Rating Finansial</label>
                                        <select class="form-control m-b-10" name="var_rating" onchange="fetch_select(this.value);" required>
                                            <option value="">- Pilih Rating -</option>
                                            <?php
                                            $query2 = "SELECT rating_laporan_audit FROM TB_RATING where rating_laporan_audit!='-'";
                                            $resultQuery2 = mysqli_query($mysqli, $query2);
                                            while ($rows = mysqli_fetch_row($resultQuery2)) {
                                                $data2[] = $rows;
                                            }

                                            for ($a = 0; $a < count($data2); $a++) {
                                                $current_rating = $data2[$a][0]; ?>

                                                <option value="<?php echo $current_rating; ?>"><?php echo $current_rating; ?></option>

                                            <?php
                                            }
                                            ?>

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="Vendor">Limit Finansial</label>
                                        <input type="text" class="form-control m-b-10" name="isi_limit" id="new_select" required>

                                    </div>
                                    <button type="submit" class="btn btn-info"><a href="/khs_2020/kecepatan_kerja.php"></a>Submit</button>
                                </form>
                            </div>
                        </section>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <section class="panel">
                            <header class="panel-heading">tabel Limit Finansial </header>
                            <div class="panel-body table-responsive">
                                <div class="demo-html"></div>
                                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">

                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Vendor</th>
                                            <th>Rating Laporan Audit</th>
                                            <th>Finansial Limit</th>
                                            <th>Finansial Current</th>
                                            <th>Finansial Limit Pertama</th>
                                            <th>Rating Laporan Audit Pertama</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $count = "SELECT * from  tb_fin_vendor";
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

                                        $sql = "SELECT B.VENDOR_NAMA, A.RATING_LAPORAN_AUDIT, A.FIN_LIMIT, 
										A.FIN_CURRENT, A.FIN_LIMIT_PERTAMA,
										A.RATING_LAPORAN_AUDIT_PERTAMA, A.VENDOR_ID from tb_vendor B join tb_fin_vendor A 
									where B.vendor_id=A.vendor_id";
                                        //echo  $sql;
                                        $resultQuery = mysqli_query($mysqli, $sql);
                                        while ($rows = mysqli_fetch_row($resultQuery)) {
                                            $data3[] = $rows;
                                        }
                                        for ($i = 0; $i < count($data3); $i++) {
                                            $vendor_nama     = $data3[$i][0];
                                            $rating_laporan_audit     = $data3[$i][1];
                                            $fin_limit = $data3[$i][2];
                                            $fin_current = $data3[$i][3];
                                            $fin_limit_pertama = $data3[$i][4];
                                            $rating_laporan_audit_pertama = $data3[$i][5];
                                            $vendor_id = $data3[$i][6];
                                            $a = ($i + 1) + (($currentpage - 1) * $rowsperpage);
                                            $delete_action = "<a href='master_finansial_delete.php?vendor_id=$vendor_id'onclick='return confirm(\"Hapus Finansial: " . $vendor_nama . "?\")'>Delete</a>";


                                            echo "<tr><td>$a</td>
										  <td>$vendor_nama </a></td>
										  <td>$rating_laporan_audit</td>
										  <td>$fin_limit</td>
										  <td>$fin_current</td>
										  <td>$fin_limit_pertama</td>
										  <td>$rating_laporan_audit_pertama</td>
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

<script type="text/javascript">
    function fetch_select(val) {
        $.ajax({
            type: 'post',
            url: 'select_rating_kekayaan_isi.php',
            data: {
                get_option: val
            },
            success: function(response) {
                //  document.getElementById("new_select").innerHTML=response; 
                $("#new_select").val(response);
            }
        });
    }
</script>