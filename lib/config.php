<?php
// $mysqli_host			= "localhost";
// $mysqli_user			= "root";
// $mysqli_password		= "";
// //$mysqli_password		= "";
// $mysqli_database		= "db_khs";

// $conn = mysqli_connect($mysqli_host,$mysqli_user,$mysqli_password);
// mysqli_select_db($mysqli_database);
// error_reporting(0);

$mysqli = new mysqli("localhost", "root", "", "db_khs");

// Check connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}
