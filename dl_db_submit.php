<?php
// define ("DB_HOST", "localhost");
// define ("DB_USER", "root");
// define ("DB_PASS","adadech");
// define ("DB_NAME","khs-test");

include_once('lib/config.php');

// $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
// $db = mysqli_select_db(DB_NAME, $link) or die("Couldn't select database");

$get_table = $_POST['var_tabel'];
if ($get_table==1) {
    $table_name = "tb_spj";
    $setExcelName = "KHS - Data SPJ";
} elseif ($get_table==2) {
    $table_name = "tb_skko_i";
    $setExcelName = "KHS - Data SKKI/O";
}

$setCounter = 0;
$setMainHeader="";
$setData="";

$setSql = "select * from ".$table_name;

$setRec = mysqli_query($mysqli, $setSql);

$setCounter = mysqli_num_fields($setRec);

for ($i = 0; $i < $setCounter; $i++) {
    $setMainHeader .= mysqli_field_name($setRec, $i)."\t";
}

while ($rec = mysqli_fetch_row($setRec)) {
    $rowLine = '';
    foreach ($rec as $value) {
        if (!isset($value) || $value == "") {
            $value = "\t";
        } else {
            //It escape all the special charactor, quotes from the data.
            $value = strip_tags(str_replace('"', '""', $value));
            $value = '"' . $value . '"' . "\t";
        }
        $rowLine .= $value;
    }
    $setData .= trim($rowLine)."\n";
}
  $setData = str_replace("\r", "", $setData);

if ($setData == "") {
    $setData = "\nno matching records found\n";
}

$setCounter = mysqli_num_fields($setRec);



//This Header is used to make data download instead of display the data
 header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=".$setExcelName."_Reoprt.xls");

header("Pragma: no-cache");
header("Expires: 0");

//It will print all the Table row as Excel file row with selected column name as header.
echo ucwords($setMainHeader)."\n".$setData."\n";
