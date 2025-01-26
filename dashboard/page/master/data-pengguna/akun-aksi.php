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

if (in_array(1, $arrayAkses) || in_array(2, $arrayAkses)) {
    if (isset($_POST['addAccount'])) {

        $pegKey = mysqli_escape_string($myConnection, $_POST['pegawai']);
        $user_manajemen = mysqli_escape_string($myConnection, $_POST['nama_pengguna']);

        $outputResult = [];
        $cekPeg = getDetailEmployee($keySiratu, $pegKey);
        $pegJSON = @file_get_contents($cekPeg);
        $pegArr = json_decode($pegJSON, true);
        if ($pegArr['status']['code'] == '200') {
            $i = 1;
            $resultPeg = isset($pegArr['results']) ? $pegArr['results'] : array();
            foreach ($resultPeg as $arrPeg) {
                $idResult = $arrPeg['id_peg'];
                $nameResult = $arrPeg['nama_peg'];
                $nipResult = $arrPeg['nip'];
            }
            // $id_peg = mysqli_escape_string($myConnection, decrypt($_POST['pegawai']));
            $cekId = mysqli_query($myConnection, "select id_peg from akun_manajemen where soft_delete = 0 and user_manajemen = '$user_manajemen' ");
            if (mysqli_num_rows($cekId) > 0) {
                $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Data Akun gagal ditambahkan, Username sudah digunakan'})";
                echo "<script> window.location='account'; </script>";
            } else {
                $code2 = time() . '' . uniqid();
                $code = strtoupper($code2);
                $created_by = $_SESSION['id'];
                $pass_manajemen = encrypt(mysqli_escape_string($myConnection, $_POST['kata_sandi']));
                $level_manajemen = mysqli_escape_string($myConnection, decrypt($_POST['level']));
                $area_manajemen = isset($_POST['akses_area']) && $level_manajemen == 3 ?  decrypt(mysqli_escape_string($myConnection, $_POST['akses_area'])) : '';


                $sqlInput = "insert into akun_manajemen (id_manajemen, user_manajemen, pass_manajemen, nama_manajemen, id_peg, level_manajemen, area_manajemen, status_manajemen, created_by) values ('$code', '$user_manajemen', '$pass_manajemen', '$nameResult', '$idResult', '$level_manajemen', '$area_manajemen', 'aktif', '$created_by')";
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
        $id_manajemen = mysqli_escape_string($myConnection, decrypt($_POST['_key']));
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
