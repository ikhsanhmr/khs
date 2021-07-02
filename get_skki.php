<?php
session_Start();
include_once("lib/config.php");
include_once("lib/check.php");

$get_spj = $_GET['no_spj'];

//$get_spj = 'SPJ/BELANJA';
//$spj = isset($_GET['no_spj']) ? intval($_GET['no_spj']) : 0;
//$area = isset($_GET['area']) ? intval($_GET['area']) : 0;
$query = "SELECT skki_no FROM TB_SPJ WHERE SPJ_NO = '$get_spj'";
$result = mysqli_query($query);
$res = array();
while ($rows = mysqli_fetch_array($result))
{
    $res[] = $rows;
}
echo json_encode($res);
?>