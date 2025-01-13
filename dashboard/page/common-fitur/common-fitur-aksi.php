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

if ($_SESSION['id'] && $_SESSION['username']) {
    if (isset($_POST['changePassword']) && isset($_POST['url'])) {
        $id_manajemen = $_SESSION['id'];
        $sandi_baru = mysqli_escape_string($myConnection, $_POST['sandi_baru']);
        $konfirmasi_baru = mysqli_escape_string($myConnection, $_POST['konfirmasi_baru']);
        $url = mysqli_escape_string($myConnection, $_POST['url']);
        $urlNow = ($url == 'TWpNNU9UazNZekU9' || $url == '') ? './' : decrypt($url);
        if ($sandi_baru == $konfirmasi_baru) {
            $sandi_lama = mysqli_escape_string($myConnection, $_POST['sandi_lama']);
            $encPassLama = encrypt($sandi_lama);
            $sqlPass = mysqli_query($myConnection, "select pass_manajemen from akun_manajemen where id_manajemen = '$id_manajemen' and soft_delete =0");
            if (mysqli_num_rows($sqlPass) > 0) {
                $showPass = mysqli_fetch_array($sqlPass);
                if ($showPass['pass_manajemen'] == $encPassLama) {
                    $updatePass = mysqli_query($myConnection, "update akun_manajemen set pass_manajemen = '$encPassLama' where id_manajemen = '$id_manajemen' and soft_delete =0");
                    if ($updatePass) {
                        $_SESSION['alert'] = "Toast.fire({icon: 'success',title: 'Kata Sandi berhasil diubah !'})";
                        echo '<script> window.location="' . $urlNow . '"; </script>';
                    } else {
                        $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Kata Sandi gagal diubah !'})";
                        echo '<script> window.location="' . $urlNow . '"; </script>';
                    }
                } else {
                    $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'SQL Injection Detected !'})";
                    echo '<script> window.location="' . $urlNow . '"; </script>';
                }
            } else {
                $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'SQL Injection Detected !'})";
                echo '<script> window.location="' . $urlNow . '"; </script>';
            }
        } else {
            $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Kata Sandi Baru dan Konfirmasi Sandi Baru Tidak Cocok'})";
            echo '<script> window.location="' . $urlNow . '"; </script>';
        }
    } elseif (isset($_POST['editProgram'])) {
        $nama_program = htmlspecialchars(mysqli_escape_string($myConnection, $_POST['nama_program']));
        $id_jenis_program = decrypt(mysqli_escape_string($myConnection, $_POST['jenis_program']));
        $id_area_program = decrypt(mysqli_escape_string($myConnection, $_POST['area_program']));
        $ket = htmlspecialchars(mysqli_escape_string($myConnection, $_POST['ket']));
        $id_program = decrypt(mysqli_escape_string($myConnection, $_POST['_token']));

        $sqlCekProgram = mysqli_query($myConnection, "select * from tb_program where id_program = '$id_program' and soft_delete = 0");
        if (mysqli_num_rows($sqlCekProgram) > 0) {
            $viewCekProgram = mysqli_fetch_array($sqlCekProgram);
            $updateProgram = mysqli_query($myConnection, "update tb_program set 
            nama_program = '$nama_program',
            id_jenis_program = '$id_jenis_program',
            id_area = '$id_area_program',
            ket = '$ket'
            where id_program = '$id_program' and soft_delete = 0");
            if ($updateProgram) {
                $_SESSION['alert'] = "Toast.fire({icon: 'success',title: 'Data Tim berhasil diubah'})";
                echo '<script> window.location="programList?_token=' . encrypt($viewCekProgram['thn_program']) . '"; </script>';
            } else {
                $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Data Tim gagal diubah'})";
                echo '<script> window.location="programList?_token=' . encrypt($viewCekProgram['thn_program']) . '"; </script>';
            }
        } else {
            $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'SQL Injection Detected !'})";
            echo '<script> window.location="programList"; </script>';
        }
    } elseif (isset($_POST['delProgram'])) {
        $id_program = decrypt($_POST['_token']);
        $sqlID = mysqli_query($myConnection, "select * from tb_program where id_program = '$id_program' and soft_delete = 0");
        if (mysqli_num_rows($sqlID) > 0) {
            $viewCekProgram = mysqli_fetch_array($sqlID);
            $deleteProgram = mysqli_query($myConnection, "update tb_program set soft_delete = 1 where id_program = '$id_program' and soft_delete = 0");
            if ($deleteProgram) {
                $_SESSION['alert'] = "Toast.fire({icon: 'success',title: 'Data Program berhasil dihapus'})";
                echo '<script> window.location="programList?_token=' . encrypt($viewCekProgram['thn_program']) . '"; </script>';
            } else {
                $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Data Program gagal dihapus'})";
                echo '<script> window.location="programList?_token=' . encrypt($viewCekProgram['thn_program']) . '"; </script>';
            }
        } else {
            $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'SQL Injection Detected !'})";
            echo '<script> window.location="programList"; </script>';
        }
    } else {
        $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'SQL Injection Detected !'})";
        echo '<script> window.location="programList"; </script>';
    }
} else {
    echo '<script type="text/javascript">
    window.location = "./"
    </script>';
}
