<?php
include_once 'inc/inc.koneksi.php';
include_once 'inc/inc.library.php';
if (!isset($_SESSION['status_login'])) {
    echo '<script type="text/javascript">
    window.location = "areaList"
    </script>';
    exit;
}
$arrayAkses = explode(",", $_SESSION['level']);

if (in_array(1, $arrayAkses)) {
    if (isset($_POST['addArea'])) {
        $code2 = time() . '-' . uniqid();
        $code = strtoupper($code2);
        $created_by = $_SESSION['id'];
        $nama_area = htmlspecialchars(mysqli_escape_string($myConnection, $_POST['nama_area']));
        $warna_area = $_POST['colorpicker_value'];

        $cekWarna = mysqli_query($myConnection, "select * from tb_area where warna_area = '$warna_area' ");
        if (mysqli_num_rows($cekWarna) > 0) {
            $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Kode Warna sudah terpakai'})";
            echo "<script> window.location='areaList'; </script>";
        } else {
            $insertTeam = mysqli_query($myConnection, "insert into tb_area (id_area, nama_area, warna_area, created_date) values ('$code2', '$nama_area', '$warna_area', NOW())");
            if ($insertTeam) {
                $_SESSION['alert'] = "Toast.fire({icon: 'success',title: 'Data Area berhasil ditambahkan'})";
                echo "<script> window.location='areaList'; </script>";
            } else {
                $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Data Area gagal ditambahkan'})";
                echo "<script> window.location='areaList'; </script>";
            }
        }
    } elseif (isset($_POST['editArea'])) {
        $id_area = decrypt($_POST['key']);
        $sqlID = mysqli_query($myConnection, "select id_area from tb_area where id_area = '$id_area' and soft_delete = 0");
        if (mysqli_num_rows($sqlID) > 0) {
            $nama_area = htmlspecialchars(mysqli_escape_string($myConnection, $_POST['nama_area']));
            $warna_area = $_POST['colorpicker_value'];
            $updateTeam = mysqli_query($myConnection, "update tb_area set nama_area = '$nama_area', warna_area = '$warna_area' where id_area = '$id_area'");
            if ($updateTeam) {
                $_SESSION['alert'] = "Toast.fire({icon: 'success',title: 'Data Area berhasil diubah'})";
                echo "<script> window.location='areaList'; </script>";
            } else {
                $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Data Area gagal diubah'})";
                echo "<script> window.location='areaList'; </script>";
            }
        } else {
            $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'SQL Injection Detected !'})";
            echo '<script> window.location="areaList"; </script>';
        }
    } elseif (isset($_POST['delArea'])) {
        $id_area = decrypt($_POST['key']);
        $sqlID = mysqli_query($myConnection, "select id_area from tb_area where id_area = '$id_area' and soft_delete = 0");
        if (mysqli_num_rows($sqlID) > 0) {
            $updateTeam = mysqli_query($myConnection, "update tb_area set soft_delete = 1 where id_area = '$id_area'");
            if ($updateTeam) {
                $_SESSION['alert'] = "Toast.fire({icon: 'success',title: 'Data Area berhasil dihapus'})";
                echo "<script> window.location='areaList'; </script>";
            } else {
                $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Data Area gagal dihapus'})";
                echo "<script> window.location='areaList'; </script>";
            }
        } else {
            $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'SQL Injection Detected !'})";
            echo '<script> window.location="areaList"; </script>';
        }
    } else {
        $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'SQL Injection Detected !'})";
        echo '<script> window.location="areaList"; </script>';
    }
} else {
    echo '<script type="text/javascript">
    window.location = "./"
    </script>';
}
