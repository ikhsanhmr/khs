<?php
session_start();

include_once("lib/config.php");

    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = " SELECT * FROM tb_user WHERE USERNAME ='$username' AND PASSWORD = '$password' ";
    $queryResult = mysqli_query($mysqli, $query);
    $data = mysqli_fetch_array($queryResult);
    // var_dump($data);
    // die;
    $user_status = $data['USER_STATUS'];
    // var_dump($user_status);
    // die;
    if ($data == null) {
        echo '<script language="javascript">alert("Username / Password salah!")</script>';
        echo '<script language="javascript">window.location = "index.php"</script>';
    } elseif ($user_status==1) {
        echo '<script language="javascript">alert("Akun anda belum diverifikasi oleh Admin!")</script>';
        echo '<script language="javascript">window.location = "index.php"</script>';
    } else {
        $_SESSION['isLogin'] = true;
        $_SESSION['username'] = $data['USERNAME'];
        $_SESSION['role'] = $data['role_id'];
        $_SESSION['area'] = $data['AREA_KODE'];
            
        if ($data['role_id']==1) {
            $url = "dashboard.php";
        } elseif ($data['role_id']==2) {
            $url = "dashboard.php";
        } elseif ($data['role_id']==3) {
            $url = "inp_tagihan.php";
        } elseif ($data['role_id']==4) {
            $url = "seleksi_vendor.php";
        } elseif ($data['role_id']==5) {
            $url = "kecepatan_kerja.php";
        } elseif ($data['role_id']==6) {
            $url = "dashboard.php";
        } elseif ($data['role_id']==7) {
            $url = "penyerahan_dok.php";
        } elseif ($data['role_id']==8) {
            $url = "dashboard.php";
        } elseif ($data['role_id']==9) {
            $url = "dashboard.php";
        } elseif ($data['role_id']==10) {
            $url = "dashboard.php";
        } elseif ($data['role_id']==0) {
            $url = "inp_user_all.php";
        } elseif ($data['role_id']==11) {
            $url = "request_edit_finansial_vendor.php";
        } elseif ($data['role_id']==12) {
            $url = "dashboard.php";
        } elseif ($data['role_id']==13) {
            $url = "skkoi_view.php";
        } elseif ($data['role_id']==14) {
            $url = "edit_pagu_vendor.php";
        }

        echo "<script language='javascript'>window.location = '$url'</script>";
    }
