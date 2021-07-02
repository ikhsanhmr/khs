<?php
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
include_once("lib/GLOBAL_VAR.php");
?>

<link type="text/css" href="css/bootstrap-datepicker.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>

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
                            <header class="panel-heading">Search Criteria</header>
                            <div class="panel-body">

                                <form role="form">
                                    <div class="form-group">
                                        <label for="Area">Area</label>

                                    </div>

                                    <div class="form-group">
                                        <label for="Vendor">Nama Vendor</label>
                                        <input type="text" class="form-control" placeholder="Vendor" name="vendor">
                                    </div>

                                    <button type="submit" class="btn btn-info"> <a href="/khs_2020/kecepatan_kerja.php"></a>Submit</button>
                                </form>
                            </div>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <section class="panel">
                            <header class="panel-heading">DATA FINANSIAL VENDOR </header>
                            <div class="panel-body table-responsive">

                                <!--<table class="table table-hover">-->
                                <div class="demo-html"></div>
                                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">

                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Vendor</th>
                                            <th>Rating</th>
                                            <th>Finansial Sebelum Update</th>
                                            <!--<th>Finansial Setelah Update</th>
									<th>Finansial Update User</th>
									<th>Finansial Update Tanggal</th>-->
                                            <th>Revisi Finansial</th>
                                            <th>History Finansial</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        //Table
                                        $area = $_GET['area'];
                                        $vendor = $_GET['vendor'];
                                        $ftahun = isset($_GET['tahun']) ? $_GET['tahun'] : $FISCAL_YEAR;

                                        if ($vendor == "") {
                                            $count = "SELECT COUNT(VENDOR_ID) FROM tb_vendor";
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

                                            $sql = "SELECT A.VENDOR_ID,  A.VENDOR_NAMA, b.RATING_LAPORAN_AUDIT, 
									b.FIN_LIMIT FROM tb_vendor a, tb_fin_vendor B  WHERE a.VENDOR_ID=b.VENDOR_ID";
                                        }
                                        /*LIMIT $offset, $rowsperpage";*/ elseif ($vendor !== "") {
                                            $count = "SELECT COUNT(VENDOR_ID) FROM tb_vendor";
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

                                            $sql = "SELECT A.VENDOR_ID,  A.VENDOR_NAMA, b.RATING_LAPORAN_AUDIT, 
									b.FIN_LIMIT FROM tb_vendor a, tb_fin_vendor B  WHERE a.VENDOR_ID=b.VENDOR_ID";
                                        } elseif ($vendor != "") {
                                            $count = " SELECT A.VENDOR_ID,  A.VENDOR_NAMA, b.RATING_LAPORAN_AUDIT, 
										b.FIN_LIMIT FROM tb_vendor a, tb_fin_vendor B  WHERE a.VENDOR_ID=b.VENDOR_ID
										and A.VENDOR_NAMA like '%$vendor%'";
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

                                            $sql = "SELECT A.VENDOR_ID,  A.VENDOR_NAMA, b.RATING_LAPORAN_AUDIT, 
										b.FIN_LIMIT FROM tb_vendor a, tb_fin_vendor B  WHERE a.VENDOR_ID=b.VENDOR_ID
										and A.VENDOR_NAMA like '%$vendor%''
									";
                                        }

                                        $resultQuery = mysqli_query($mysqli, $sql);
                                        while ($rows = mysqli_fetch_array($resultQuery)) {
                                            $data[] = $rows;
                                        }

                                        for ($i = 0; $i < count($data); $i++) {
                                            $current_id_vendor             = $data[$i][0];
                                            $current_nama_vendor         = $data[$i][1];
                                            $current_rating             = $data[$i][2];
                                            $current_financial             = $data[$i][3];

                                            $a         = ($i + 1) + (($currentpage - 1) * $rowsperpage);
                                            $b         = floor($current_sisa_financial / $current_financial * 100);


                                            echo "<tr><td>$a</td>
								  <td>$current_nama_vendor</td>
								  <td>$current_rating</td>
								  <td>Rp.$current_financial</td>
								  <td><a href='edit_finansial_vendor_form.php?vendor_id=$current_id_vendor'>Revisi Finansial</a></td>
								  <td><a href='history_finansial.php?vendor_id=$current_id_vendor'>History</a></td>
								  </tr>	
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
    <script type="text/javascript">
        $('.year').datepicker({
            minViewMode: 2,
            format: 'yyyy',
            autoclose: true
        });
    </script>
    <?php include("lib/footer.php"); ?>
</body>

</html>