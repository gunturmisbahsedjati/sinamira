<?php
include_once 'inc/inc.koneksi.php';
include_once 'inc/inc.library.php';
include_once 'inc/config.php';
if (!isset($_SESSION['status_login'])) {
    echo '<script type="text/javascript">
    window.location = "account"
    </script>';
    exit;
}
$arrayAkses = explode(",", $_SESSION['level']);

if (in_array(1, $arrayAkses)) {
    if (isset($_POST['addAccount'])) {

        $id_manajemen = mysqli_escape_string($myConnection, decrypt($_POST['pegawai']));
        // echo $id_manajemen . '<br>';
        $outputResult = [];
        $cekPeg = getDetailsPegSinadinByID($keySinadin, $id_manajemen);
        $pegJSON = @file_get_contents($cekPeg);
        $pegArr = json_decode($pegJSON, true);
        if ($pegArr['status']['code'] == '200') {
            $i = 1;
            $resultPeg = isset($pegArr['results']) ? $pegArr['results'] : array();
            foreach ($resultPeg as $arrPeg) {
                $outputResult = $arrPeg;
            }
            $cekId = mysqli_query($myConnection, "select id_manajemen from akun_manajemen where soft_delete = 0 and id_manajemen = '$outputResult[id_manajemen]'");
            if (mysqli_num_rows($cekId) > 0) {
                $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Data Akun gagal ditambahkan, Duplikat Akun'})";
                echo "<script> window.location='account'; </script>";
            } else {
                $sqlInput = "insert into akun_manajemen (id_manajemen, user_manajemen, pass_manajemen, nama_manajemen, id_peg, level_manajemen, status_manajemen, created_by) values ('$outputResult[id_manajemen]', '$outputResult[user_manajemen]', '$outputResult[pass_manajemen]', '$outputResult[nama_manajemen]', '$outputResult[id_peg]', '$outputResult[level_manajemen]', '$outputResult[status_manajemen]', '$outputResult[created_by]')";
                // echo $sqlInput;
                $inputAkun = mysqli_query($myConnection, $sqlInput);
                if ($inputAkun) {
                    $_SESSION['alert'] = "Toast.fire({icon: 'success',title: 'Data Akun berhasil ditambahkan'})";
                    echo "<script> window.location='account'; </script>";
                } else {
                    $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Data Akun gagal ditambahkan'})";
                    echo "<script> window.location='account'; </script>";
                }
            }
        } else {
            $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'SQL Injection terdeteksi'})";
            echo "<script> window.location='account'; </script>";
        }
    } elseif (isset($_POST['delAccount'])) {
        $id_manajemen = mysqli_escape_string($myConnection, decrypt($_POST['_token']));
        $cekId = mysqli_query($myConnection, "select id_manajemen from akun_manajemen where soft_delete = 0 and id_manajemen = '$id_manajemen'");
        if (mysqli_num_rows($cekId) > 0) {
            $sqlDelete = "delete from akun_manajemen where id_manajemen = '$id_manajemen'";
            $deleteAkun = mysqli_query($myConnection, $sqlDelete);
            if ($deleteAkun) {
                $_SESSION['alert'] = "Toast.fire({icon: 'success',title: 'Data Akun berhasil dihapus'})";
                echo "<script> window.location='account'; </script>";
            } else {
                $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Data Akun gagal dihapus'})";
                echo "<script> window.location='account'; </script>";
            }
        } else {
            $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'SQL Injection terdeteksi'})";
            echo "<script> window.location='account'; </script>";
        }
    } else {
        $_SESSION['alert'] = "Toast.fire({icon: 'success',title: 'Failed Load Page....'})";
        echo "<script> window.location='account'; </script>";
    }
} else {
    echo '<script type="text/javascript">
    window.location = "./"
    </script>';
}
