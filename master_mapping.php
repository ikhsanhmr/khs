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
                            <header class="panel-heading">Tambah Mapping Vendor</header>
                            <div class="panel-body">

                                <form role="form" action="master_mapping_submit.php" method="post">
                                    <div class="form-group">
                                        <font color="red">catatan zona:</font>
                                        <br />
                                        Untuk PAKET 1,2,3,4 & 5 :
                                        <br />Pengisian Area Kode=Pilih per UP3;
                                        <br />Pengisian Zona sbb:
                                        <br />- UP3 Pekanbaru = 1;
                                        <br />- UP3 Dumai = 2;
                                        <br />- UP3 Tanjungpinang = 3;
                                        <br />- UP3 Rengat = 4
                                        <br /> <b>Untuk UP2D dan UP2K tidak perlu diisi,karena bebas memilih Vendor</b>
                                        <!--<br/>
									  Untuk PAKET 2,3,4 & 5 : Pengisian Area Kode=Kantor Wilayah WRKR; Pengisian Zona=0 -->
                                        <br />
                                        <br />
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
                                        <label for="Vendor">Area Kode</label>
                                        <select class="form-control m-b-10" name="area_kode">
                                            <option value="">- Pilih Area -</option>
                                            <?php
                                            $data_area = select_area($mysqli);
                                            for ($i = 0; $i < count($data_area); $i++) {
                                                $current_area_kode = $data_area[$i][0];
                                                $current_area_nama = $data_area[$i][1]; ?><option value="<?php echo $current_area_kode; ?>"><?php echo $current_area_nama; ?></option><?php
                                                                                                                                                                                    }
                                                                                                                                                                                        ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="Vendor">Tahun Mapping</label>
                                        <input type="text" class="form-control m-b-10" id="tahun_mapping" name="tahun_mapping" placeholder="misal: 2020" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="Vendor">Zona</label>
                                        <input type="text" class="form-control m-b-10" id="zona" name="zona" placeholder="sesuaikan dengan catatan" required>
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
                            <header class="panel-heading">tabel Mapping Vendor </header>
                            <div class="panel-body table-responsive">
                                <div class="demo-html"></div>
                                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Vendor</th>
                                            <th>Paket Jenis</th>
                                            <th>Area Kode</th>
                                            <th>Tahun Mapping</th>
                                            <th>Zona</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $count = "SELECT * from  tb_mapping_vendor";
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

                                        $sql = "SELECT A.AREA_NAMA, B.PAKET_DESKRIPSI, C.VENDOR_NAMA, D.MAPPING_TAHUN, D.ZONE ,D.VENDOR_ID, D.AREA_KODE, B.PAKET_JENIS
									from tb_area A JOIN tb_paket B JOIN TB_VENDOR C JOIN tb_mapping_vendor D 
									WHERE A.AREA_KODE=D.AREA_KODE AND B.PAKET_JENIS=D.PAKET_JENIS AND C.VENDOR_ID=D.VENDOR_ID";
                                        //echo  $sql;
                                        $resultQuery = mysqli_query($mysqli, $sql);
                                        while ($rows = mysqli_fetch_row($resultQuery)) {
                                            $data3[] = $rows;
                                        }
                                        for ($i = 0; $i < count($data3); $i++) {
                                            $area     = $data3[$i][0];
                                            $paket     = $data3[$i][1];
                                            $vendor = $data3[$i][2];
                                            $mapping = $data3[$i][3];
                                            $zone = $data3[$i][4];
                                            $vendor_ids = $data3[$i][5];
                                            $area_kode = $data3[$i][6];
                                            $paket_jenis = $data3[$i][7];
                                            $a = ($i + 1) + (($currentpage - 1) * $rowsperpage);
                                            $delete_action = "<a href='master_mapping_delete.php?area_kode=$area_kode&paket_jenis=$paket_jenis&vendor_id=$vendor_ids'onclick='return confirm(\"Hapus Mapping: " . $vendor . " ;" . $paket . " ;" . $area . "?\")'>Delete</a>";


                                            echo "<tr><td>$a</td>
										  <td>$vendor </a></td>
										  <td>$paket</td>
										  <td>$area</td>
										  <td>$mapping</td>
										  <td>$zone</td>
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