<?php session_start(); ?>
<html>
<?php
    include_once("lib/config.php");
    $time = time();
    if (isset($_SESSION)) {
        $name = $_SESSION['username'];
        $status = " UPDATE tb_user set USER_STATUS = 0,USER_LAST_ACTIVITY= '$time' WHERE username ='$name' ";
    }
    mysqli_query($mysqli, $status);
    //setcookie(session_name(),'',100);
    if (isset($_SESSION)) {
        session_unset();
        session_destroy();
    }
    ?>
	<!--<META HTTP-EQUIV="refresh" CONTENT="3;URL=index.php">-->
	<script language="javascript">window.location = "index.php"</script>
</html>