<?php
include_once 'inc/inc.koneksi.php';
include_once 'inc/inc.library.php';
if (!isset($_SESSION['status_login'])) {
    echo '<script type="text/javascript">
    window.location = "teamList"
    </script>';
    exit;
}
$arrayAkses = explode(",", $_SESSION['level']);

if (in_array(1, $arrayAkses)) {
    if (isset($_POST['addTeam'])) {
        $code2 = time() . '-' . uniqid();
        $code = strtoupper($code2);
        $created_by = $_SESSION['id'];
        $nama_tim = htmlspecialchars(mysqli_escape_string($myConnection, $_POST['nama_tim']));
        $warna_tim = $_POST['colorpicker_value'];

        $cekWarna = mysqli_query($myConnection, "select * from tb_tim where warna_tim = '$warna_tim' ");
        if (mysqli_num_rows($cekWarna) > 0) {
            $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Kode Warna sudah terpakai'})";
            echo "<script> window.location='teamList'; </script>";
        } else {
            $insertShopping = mysqli_query($myConnection, "insert into tb_tim (id_tim, nama_tim, warna_tim, created_date) values ('$code2', '$nama_tim', '$warna_tim', NOW())");
            if ($insertShopping) {
                $_SESSION['alert'] = "Toast.fire({icon: 'success',title: 'Data Tim berhasil ditambahkan'})";
                echo "<script> window.location='teamList'; </script>";
            } else {
                $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Data Tim gagal ditambahkan'})";
                echo "<script> window.location='teamList'; </script>";
            }
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
