<?php
if(isset($_POST['get_option']))
{
 include_once("lib/config.php");

 $state = $_POST['get_option'];
 $find=mysqli_query($mysqli, "select RATING_KEKAYAAN_MAX from tb_rating where RATING_LAPORAN_AUDIT='$state'");
 while($row=mysqli_fetch_array($find))
 {
  echo "".$row['RATING_KEKAYAAN_MAX']."";
 }
 exit;
}
