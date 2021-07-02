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
} );

</script>

<?php session_start();
include_once("lib/head.php");
include_once("lib/check.php");
$sql = "SELECT COUNT(spj_no) FROM tb_spj where spj_status=0";
                            $result = mysqli_query($mysqli, $sql);
                            $r = mysqli_fetch_row($result);
                            $numrows = $r[0];

                            // number of rows to show per page
                            $rowsperpage = 5;
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

$data = approval_query($offset, $rowsperpage, $mysqli);
if (isset($_POST['approve'])) {
    approve($data[$_POST['approve']][0], $mysqli);
    echo '<script language="javascript">window.location = "Approval.php"</script>';
}
if (isset($_POST['reject'])) {
    reject($data[$_POST['reject']][0], $mysqli);
    echo '<script language="javascript">window.location = "Approval.php"</script>';
}
?>

	<body class="skin-black">
        <?php include("lib/header.php"); ?> 
		
				<div class="wrapper row-offcanvas row-offcanvas-left">
                    <!-- Left side column. contains the logo and sidebar -->
                    <?php include("lib/menu.php");?>

                    <aside class="right-side">

                <!-- Main content -->
                <section class="content">



    <div class="row">
		<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">Approval</header>
			<div class="panel-body table-responsive">
			<form class="form-horizontal tasi-form" method="post" action="Approval.php">
				<div class="demo-html"></div>
				<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>	
						<tr>
							<th>SPJ</th>
							<th>Area</th>
							<th>Vendor</th>
							<th>Jenis Pekerjaan</th>
							<th>Action</th>
						</tr>
					
					</thead>	
						<?php
                        
                                
                            
                            for ($i=0;$i<count($data);$i++) {
                                $current_spj_no = $data[$i][0];
                                $current_area_nama = $data[$i][1];
                                $current_vendor_nama = $data[$i][2];
                                $current_paket_deskripsi = $data[$i][3];
                                $current_spj_status = $data[$i][4];
                                
                                
                                echo "<tr>
									  <td>$current_spj_no</td>
									  <td>$current_area_nama</td>
									  <td>$current_vendor_nama</td>
									  <td>$current_paket_deskripsi</td>
									  <td><button type='submit' class='btn btn-success' name='approve' value= $i>Approve</button>
									  <button type='submit' class='btn btn-danger' name='reject' value= $i>Reject</button></td>
									  </tr>";
                            }
                            
                        ?>
						
					
				</table>
			</form>
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
                               echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=1'><<</a></li> ";
                               // get previous page num
                               $prevpage = $currentpage - 1;
                               // show < link to go back to 1 page
                               echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'><</a></li> ";
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
                                     echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$x'>$x</a></li> ";
                                  } // end else
                               } // end if
                            } // end for

                            // if not on last page, show forward and last page links
                            if ($currentpage != $totalpages) {
                               // get next page
                               $nextpage = $currentpage + 1;
                                // echo forward link for next page
                               echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage'>></a></li> ";
                               // echo forward link for lastpage
                               echo " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages'>>></a></li> ";
                            } // end if
                            /****** end build pagination links
                            echo "</ul>
                            </div>
                        </div>
                    </section>
                </div>";******/
                ?>
			</div>
		</section>
		</div>
	</div>
                </section>
            </aside>

        </div>
	
<?php include("lib/footer.php");?>
	</body>
</html>