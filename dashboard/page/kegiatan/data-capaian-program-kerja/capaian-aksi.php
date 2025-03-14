<?php
include_once 'inc/inc.koneksi.php';
include_once 'inc/inc.library.php';
if (!isset($_SESSION['status_login'])) {
    echo '<script type="text/javascript">
    window.location = "./"
    </script>';
    exit;
}
$arrayAkses = explode(",", $_SESSION['level']);

if (in_array(1, $arrayAkses) || in_array(2, $arrayAkses)) {
    if (isset($_POST['addInstrumentTeam']) && isset($_POST['_token'])) {
        $id_program = decrypt($_POST['_token']);
        $thn_program = decrypt($_POST['_key']);
        $area = decrypt($_POST['_id']);
        $uraian = htmlspecialchars(mysqli_escape_string($myConnection, bersihkanInsert($_POST['uraian'])));
        $hambatan = htmlspecialchars(mysqli_escape_string($myConnection, bersihkanInsert($_POST['hambatan'])));
        $langkah_antisipasi = htmlspecialchars(mysqli_escape_string($myConnection, bersihkanInsert($_POST['langkah_antisipasi'])));


        $cekProgram = mysqli_query($myConnection, "select * from tb_program where id_program = '$id_program' and id_area = '$area' and soft_delete = 0");
        if (mysqli_num_rows($cekProgram) > 0) {
            $add = mysqli_query($myConnection, "update tb_program set uraian = '$uraian', hambatan = '$hambatan', langkah_antisipasi = '$langkah_antisipasi' where id_program = '$id_program' and id_area = '$area' and soft_delete = 0");
            if ($add) {
                $_SESSION['alert'] = "Toast.fire({icon: 'success',title: 'Dokumen Kegiatan berhasil diupload'})";
                echo '<script> window.location="detailInstrumentList?_token=' . encrypt($thn_program) . '&_key=' . encrypt($area) . '"; </script>';
            } else {
                $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Dokumen Kegiatan gagal diupload'})";
                echo '<script> window.location="detailInstrumentList?_token=' . encrypt($thn_program) . '&_key=' . encrypt($area) . '"; </script>';
            }
        } else {
            $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Anda Tidak Memiliki Hak Akses !'})";
            echo '<script> window.location="./"; </script>';
        }
    } else {
        $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'SQL Injection Detected !'})";
        echo '<script> window.location="./"; </script>';
    }
} elseif (in_array(3, $arrayAkses)) {
    if (isset($_POST['addInstrumentTeam']) && isset($_POST['_token'])) {
        $id_program = decrypt($_POST['_token']);
        $thn_program = decrypt($_POST['_key']);
        $uraian = htmlspecialchars(mysqli_escape_string($myConnection, bersihkanInsert($_POST['uraian'])));
        $hambatan = htmlspecialchars(mysqli_escape_string($myConnection, bersihkanInsert($_POST['hambatan'])));
        $langkah_antisipasi = htmlspecialchars(mysqli_escape_string($myConnection, bersihkanInsert($_POST['langkah_antisipasi'])));
        $area = $_SESSION['akses_tim'];

        $cekProgram = mysqli_query($myConnection, "select * from tb_program where id_program = '$id_program' and id_area = '$area' and soft_delete = 0");
        if (mysqli_num_rows($cekProgram) > 0) {
            $add = mysqli_query($myConnection, "update tb_program set uraian = '$uraian', hambatan = '$hambatan', langkah_antisipasi = '$langkah_antisipasi' where id_program = '$id_program' and id_area = '$area' and soft_delete = 0");
            if ($add) {
                $_SESSION['alert'] = "Toast.fire({icon: 'success',title: 'Dokumen Kegiatan berhasil diupload'})";
                echo '<script> window.location="detailInstrumentList?_token=' . encrypt($thn_program) . '&_key=' . encrypt($area) . '"; </script>';
            } else {
                $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Dokumen Kegiatan gagal diupload'})";
                echo '<script> window.location="detailInstrumentList?_token=' . encrypt($thn_program) . '&_key=' . encrypt($area) . '"; </script>';
            }
        } else {
            $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Anda Tidak Memiliki Hak Akses !'})";
            echo '<script> window.location="./"; </script>';
        }
    } else {
        $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'SQL Injection Detected !'})";
        echo '<script> window.location="./"; </script>';
    }
} else {
    echo '<script type="text/javascript">
    window.location = "./"
    </script>';
}
