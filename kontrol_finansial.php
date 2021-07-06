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
                                        <select class="form-control m-b-10" name="area">
                                            <option value="">-Pilih Area-</option>
                                            <?php
                                            $data_area = select_area($mysqli);
                                            for ($i = 0; $i < count($data_area); $i++) {
                                                $current_area_kode = $data_area[$i][0];
                                                $current_area_nama = $data_area[$i][1]; ?>
                                                <option value="<?php echo $current_area_kode; ?>"><?php echo $current_area_nama; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="Vendor">Nama Vendor</label>
                                        <input type="text" class="form-control" placeholder="Vendor" name="vendor">
                                    </div>

                                    <div class="form-group">
                                        <label for="Area">Tahun</label>
                                        <input class="year form-control date-pick" id="tahun" name="tahun" placeholder="Tahun">
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
                            <header class="panel-heading">DATA FINANSIAL VENDOR</header>
                            <div class="panel-body table-responsive">

                                <!--<table class="table table-hover">-->
                                <div class="demo-html"></div>
                                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">

                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Vendor</th>
                                            <th>Rating</th>
                                            <th>Kekuatan Finansial</th>
                                            <th>Pagu Kontrak</th>
                                            <th>% Kontrak</th>
                                            <th>Sisa Finansial</th>
                                            <th></th>
                                            <th>Total Area</th>
                                            <th>Jenis Pekerjaan</th>
                                            <?php if ($_SESSION['role'] == 1) { ?>
                                                <th>Actions Pagu Kontrak</th>
                                                <th>Actions Pagu Rating</th>
                                            <?php } elseif ($_SESSION['role'] == 9) { ?>
                                                <th>Actions Pagu Kontrak</th>
                                            <?php } elseif ($_SESSION['role'] == 10) { ?>
                                                <th>Actions Pagu Rating</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        //Table
                                        $area = $_GET['area'];


                                        $vendor = $_GET['vendor'];
                                        $ftahun = isset($_GET['tahun']) ? $_GET['tahun'] : $FISCAL_YEAR;

                                        if ($area == "" && $vendor == "" && $tahun == "") {
                                            $count = "SELECT count(e.vendor_nama) FROM
									(SELECT DISTINCT b.paket_jenis, a.vendor_id, a.rating_laporan_audit, a.fin_limit, a.fin_limit - a.fin_current as sisa, (select COUNT(d.AREA_KODE) from tb_mapping_vendor d where d.VENDOR_ID = a.vendor_id and d.PAKET_JENIS = b.paket_jenis) as jumlah_area
									from
									tb_fin_vendor a left join tb_mapping_vendor b on a.vendor_id = b.vendor_id) as x 
									left join tb_paket c on c.paket_jenis = x.paket_jenis 
									inner join tb_vendor e on e.vendor_id = x.vendor_id";
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

                                            $sql = "SELECT e.vendor_nama, x.rating_laporan_audit, x.fin_limit, x.sisa, x.jumlah_area, c.paket_deskripsi, x.vendor_id, x.paket_jenis,
									(select pk.pagu_kontrak from tb_pagu_kontrak pk where pk.vendor_id = x.vendor_id and pk.paket_jenis = x.paket_jenis  ) as PAGU_KONTRAK,
									(select ((pk.terpakai/pk.pagu_kontrak)*100) from tb_pagu_kontrak pk where pk.vendor_id = x.vendor_id and pk.paket_jenis = x.paket_jenis  ) as PERSEN_KONTRAK FROM
									(SELECT DISTINCT b.paket_jenis, a.vendor_id, a.rating_laporan_audit, a.fin_limit, a.fin_limit - a.fin_current as sisa, (select COUNT(d.AREA_KODE) from tb_mapping_vendor d where d.VENDOR_ID = a.vendor_id and d.PAKET_JENIS = b.paket_jenis) as jumlah_area
									from
									tb_fin_vendor a left join tb_mapping_vendor b on a.vendor_id = b.vendor_id) as x 
									left join tb_paket c on c.paket_jenis = x.paket_jenis 
									inner join tb_vendor e on e.vendor_id = x.vendor_id
									WHERE e.TAHUN = $ftahun
									AND c.STATUS = 1";
                                        }
                                        /*LIMIT $offset, $rowsperpage";*/ elseif ($vendor == "" && $area != "") {
                                            $count = "select count(e.vendor_nama) from
									(select distinct b.paket_jenis, a.vendor_id, a.rating_laporan_audit, a.fin_limit, a.fin_limit - a.fin_current as sisa, (select COUNT(d.AREA_KODE) from tb_mapping_vendor d where d.VENDOR_ID = a.vendor_id and d.PAKET_JENIS = b.paket_jenis) as jumlah_area, b.area_kode
									from
									tb_fin_vendor a left join tb_mapping_vendor b on a.vendor_id = b.vendor_id) as x 
									left join tb_paket c on c.paket_jenis = x.paket_jenis 
									inner join tb_vendor e on e.vendor_id = x.vendor_id
									WHERE x.AREA_KODE = $area
									ORDER BY e.TAHUN desc";
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

                                            $sql = "select e.vendor_nama, x.rating_laporan_audit, x.fin_limit, x.sisa, x.jumlah_area, c.paket_deskripsi, x.vendor_id, x.paket_jenis,
									(select pk.pagu_kontrak from tb_pagu_kontrak pk where pk.vendor_id = x.vendor_id and pk.paket_jenis = x.paket_jenis  ) as PAGU_KONTRAK,
									(select ((pk.terpakai/pk.pagu_kontrak)*100) from tb_pagu_kontrak pk where pk.vendor_id = x.vendor_id and pk.paket_jenis = x.paket_jenis  ) as PERSEN_KONTRAK from
									(select distinct b.paket_jenis, a.vendor_id, a.rating_laporan_audit, a.fin_limit, a.fin_limit - a.fin_current as sisa, (select COUNT(d.AREA_KODE) from tb_mapping_vendor d where d.VENDOR_ID = a.vendor_id and d.PAKET_JENIS = b.paket_jenis) as jumlah_area, b.area_kode
									from
									tb_fin_vendor a left join tb_mapping_vendor b on a.vendor_id = b.vendor_id) as x 
									left join tb_paket c on c.paket_jenis = x.paket_jenis 
									inner join tb_vendor e on e.vendor_id = x.vendor_id
									AND x.AREA_KODE = $area
									";
                                        } elseif ($area == "" && $vendor != "") {
                                            $count = "select count(e.vendor_nama) from
									(select distinct b.paket_jenis, a.vendor_id, a.rating_laporan_audit, a.fin_limit, a.fin_limit - a.fin_current as sisa, (select COUNT(d.AREA_KODE) from tb_mapping_vendor d where d.VENDOR_ID = a.vendor_id and d.PAKET_JENIS = b.paket_jenis) as jumlah_area
									from
									tb_fin_vendor a left join tb_mapping_vendor b on a.vendor_id = b.vendor_id) as x 
									left join tb_paket c on c.paket_jenis = x.paket_jenis 
									inner join tb_vendor e on e.vendor_id = x.vendor_id
									and e.VENDOR_NAMA like '%$vendor%'";
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

                                            $sql = "select e.vendor_nama, x.rating_laporan_audit, x.fin_limit, x.sisa, x.jumlah_area, c.paket_deskripsi, x.vendor_id, x.paket_jenis,
									(select pk.pagu_kontrak from tb_pagu_kontrak pk where pk.vendor_id = x.vendor_id and pk.paket_jenis = x.paket_jenis  ) as PAGU_KONTRAK,
									(select ((pk.terpakai/pk.pagu_kontrak)*100) from tb_pagu_kontrak pk where pk.vendor_id = x.vendor_id and pk.paket_jenis = x.paket_jenis  ) as PERSEN_KONTRAK from
									(select distinct b.paket_jenis, a.vendor_id, a.rating_laporan_audit, a.fin_limit, a.fin_limit - a.fin_current as sisa, (select COUNT(d.AREA_KODE) from tb_mapping_vendor d where d.VENDOR_ID = a.vendor_id and d.PAKET_JENIS = b.paket_jenis) as jumlah_area
									from
									tb_fin_vendor a left join tb_mapping_vendor b on a.vendor_id = b.vendor_id) as x 
									left join tb_paket c on c.paket_jenis = x.paket_jenis 
									inner join tb_vendor e on e.vendor_id = x.vendor_id
									and e.VENDOR_NAMA like '%$vendor%'
									";
                                        } elseif ($area != "" && $vendor != "") {
                                            $count = "select count(e.vendor_nama) from
									(select distinct b.paket_jenis, a.vendor_id, a.rating_laporan_audit, a.fin_limit, a.fin_limit - a.fin_current as sisa, (select COUNT(d.AREA_KODE) from tb_mapping_vendor d where d.VENDOR_ID = a.vendor_id and d.PAKET_JENIS = b.paket_jenis) as jumlah_area, b.area_kode
									from
									tb_fin_vendor a left join tb_mapping_vendor b on a.vendor_id = b.vendor_id) as x 
									left join tb_paket c on c.paket_jenis = x.paket_jenis 
									inner join tb_vendor e on e.vendor_id = x.vendor_id
									WHERE x.AREA_KODE = $area and e.VENDOR_NAMA like '%$vendor%'";
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

                                            $sql = "select e.vendor_nama, x.rating_laporan_audit, x.fin_limit, x.sisa, x.jumlah_area, c.paket_deskripsi, x.vendor_id, x.paket_jenis,
									(select pk.pagu_kontrak from tb_pagu_kontrak pk where pk.vendor_id = x.vendor_id and pk.paket_jenis = x.paket_jenis  ) as PAGU_KONTRAK,
									(select ((pk.terpakai/pk.pagu_kontrak)*100) from tb_pagu_kontrak pk where pk.vendor_id = x.vendor_id and pk.paket_jenis = x.paket_jenis  ) as PERSEN_KONTRAK from
									(select distinct b.paket_jenis, a.vendor_id, a.rating_laporan_audit, a.fin_limit, a.fin_limit - a.fin_current as sisa, (select COUNT(d.AREA_KODE) from tb_mapping_vendor d where d.VENDOR_ID = a.vendor_id and d.PAKET_JENIS = b.paket_jenis) as jumlah_area, b.area_kode
									from
									tb_fin_vendor a left join tb_mapping_vendor b on a.vendor_id = b.vendor_id) as x 
									left join tb_paket c on c.paket_jenis = x.paket_jenis 
									inner join tb_vendor e on e.vendor_id = x.vendor_id
									WHERE x.AREA_KODE = $area and e.VENDOR_NAMA like '%$vendor%'
									";
                                        }

                                        $resultQuery = mysqli_query($mysqli, $sql);
                                        while ($rows = mysqli_fetch_array($resultQuery)) {
                                            $data[] = $rows;
                                        }

                                        for ($i = 0; $i < count($data); $i++) {
                                            $current_nama_vendor         = $data[$i][0];
                                            $current_rating             = $data[$i][1];
                                            $current_financial             = $data[$i][2];
                                            $current_sisa_financial     = $data[$i][3];
                                            $current_jmlh_area             = $data[$i][4];
                                            $current_jenis_pekerjaan     = $data[$i][5];
                                            $current_no_vendor             = $data[$i][6];
                                            $current_paket_jenis         = $data[$i][7];
                                            $current_pagu_kontrak         = $data[$i][8];
                                            $current_persen_kontrak         = $data[$i][9];

                                            $a         = ($i + 1) + (($currentpage - 1) * $rowsperpage);
                                            $b         = floor($current_sisa_financial / $current_financial * 100);
                                            if ($b >= 75) {
                                                $class = "badge badge-success";
                                            } elseif ($b >= 50) {
                                                $class = "badge badge-info";
                                            } elseif ($b >= 25) {
                                                $class = "badge badge-warning";
                                            } else {
                                                $class = "badge badge-danger";
                                            };
                                            $current_financial = number_format($current_financial);
                                            $current_sisa_financial = number_format($current_sisa_financial);
                                            $current_pagu_kontrak = number_format($current_pagu_kontrak);
                                            if ($_SESSION['role'] == 1) {
                                                echo "<tr><td>$a</td>
								  <td><a href='status.php?id=$current_no_vendor&id2=$current_paket_jenis'>$current_nama_vendor</a></td>
								  <td>$current_rating</td>
								  <td>Rp.$current_financial</td>
								  <td>Rp.$current_pagu_kontrak</td>
								  <td>$current_persen_kontrak</td>
								  <td>Rp.$current_sisa_financial </td>
								  <td><span class='$class'>$b%</span></td>
								  <td>$current_jmlh_area</td>
								  <td>$current_jenis_pekerjaan</td>
								  <td><a href='pagu_kontrak_edit.php?vendor_id=$current_no_vendor&paket_id=$current_paket_jenis'>Edit</a></td>
								  <td><a href='pagu_rating_edit.php?vendor_id=$current_no_vendor'>Edit</a></td>
								  </tr>	
								  ";
                                            } elseif ($_SESSION['role'] == 9) {
                                                echo "<tr><td>$a</td>
								  <td><a href='status.php?id=$current_no_vendor&id2=$current_paket_jenis'>$current_nama_vendor</a></td>
								  <td>$current_rating</td>
								  <td>Rp.$current_financial</td>
								  <td>Rp.$current_pagu_kontrak</td>
								  <td>$current_persen_kontrak</td>
								  <td>Rp.$current_sisa_financial </td>
								  <td><span class='$class'>$b%</span></td>
								  <td>$current_jmlh_area</td>
								  <td>$current_jenis_pekerjaan</td>
								  <td><a href='pagu_kontrak_edit.php?vendor_id=$current_no_vendor&paket_id=$current_paket_jenis'>Edit</a></td>
								  </tr>	
								  ";
                                            } elseif ($_SESSION['role'] == 10) {
                                                echo "<tr><td>$a</td>
								  <td><a href='status.php?id=$current_no_vendor&id2=$current_paket_jenis'>$current_nama_vendor</a></td>
								  <td>$current_rating</td>
								  <td>Rp.$current_financial</td>
								  <td>Rp.$current_pagu_kontrak</td>
								  <td>$current_persen_kontrak</td>
								  <td>Rp.$current_sisa_financial </td>
								  <td><span class='$class'>$b%</span></td>
								  <td>$current_jmlh_area</td>
								  <td>$current_jenis_pekerjaan</td>
								  <td><a href='pagu_rating_edit.php?vendor_id=$current_no_vendor'>Edit</a></td>
								  </tr>	
								  ";
                                            } else {
                                                echo "<tr><td>$a</td>
								  <td><a href='status.php?id=$current_no_vendor&id2=$current_paket_jenis'>$current_nama_vendor</a></td>
								  <td>$current_rating</td>
								  <td>Rp.$current_financial</td>
								  <td>Rp.$current_pagu_kontrak</td>
								  <td>$current_persen_kontrak</td>
								  <td>Rp.$current_sisa_financial </td>
								  <td><span class='$class'>$b%</span></td>
								  <td>$current_jmlh_area</td>
								  <td>$current_jenis_pekerjaan</td>
								  </tr>";
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <?php
                                /******  build the pagination links
                        // range of num links to show
                        $range = 5;
                        echo "<div class='col-md-12'>
                                <section class='panel'>
                                    <div class='panel-body'>
                                        <div class='text-center'>
                                            <ul class='pagination'>";
                        // if not on page 1, don't show back links
                        if ($currentpage > 1) {
                           // show << link to go back to page 1
                           echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=1&area=$area&vendor=$vendor'><<</a></li> ";
                           // get previous page num
                           $prevpage = $currentpage - 1;
                           // show < link to go back to 1 page
                           echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage&area=$area&vendor=$vendor'><</a></li> ";
                        } // end if

                        // loop to show links to range of pages around current page
                        for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
                           // if it's a valid page number...
                           if (($x > 0) && ($x <= $totalpages)) {
                              // if we're on current page...
                              if ($x == $currentpage) {
                                 // 'highlight' it but don't make a link
                                 echo "<li><a href='#'><b>$x</b></a></li>";
                              // if not current page...
                              } else {
                                 // make it a link
                                 echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$x&area=$area&vendor=$vendor'>$x</a></li> ";
                              } // end else
                           } // end if
                        } // end for

                        // if not on last page, show forward and last page links
                        if ($currentpage != $totalpages) {
                           // get next page
                           $nextpage = $currentpage + 1;
                            // echo forward link for next page
                           echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage&area=$area&vendor=$vendor'>></a></li> ";
                           // echo forward link for lastpage
                           echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages&area=$area&vendor=$vendor'>>></a></li> ";
                        } // end if
                        /****** end build pagination links
                        echo "</ul>
                        </div>
                    </div>
                </section>
            </div>";*/
                                ?>
                                <p class="text-center"><a href="kontrol_finansial_excel.php?area=<?php echo $area; ?>&vendor=<?php echo $vendor; ?>" class='btn btn-success center'>Export Excel</a></p>

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