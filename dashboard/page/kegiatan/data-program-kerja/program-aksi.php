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

if (in_array(1, $arrayAkses)) {
    if (isset($_POST['addProgram']) && isset($_POST['_token'])) {
        $code2 = time() . '-' . uniqid();
        $code = strtoupper($code2);
        $created_by = $_SESSION['id'];
        $nama_program = htmlspecialchars(mysqli_escape_string($myConnection, $_POST['nama_program']));
        $id_jenis_program = decrypt(mysqli_escape_string($myConnection, $_POST['jenis_program']));
        $id_area_program = decrypt(mysqli_escape_string($myConnection, $_POST['area_program']));
        $ket = htmlspecialchars(mysqli_escape_string($myConnection, $_POST['ket']));
        $token = decrypt(mysqli_escape_string($myConnection, $_POST['_token']));

        $insertProgram = mysqli_query($myConnection, "insert into tb_program (id_program, nama_program, id_jenis_program, id_area, ket, thn_program, soft_delete, created_by, created_date) values ('$code2', '$nama_program', '$id_jenis_program', '$id_area_program',  '$ket', '$token', '0', '$created_by', NOW())");
        if ($insertProgram) {
            $_SESSION['alert'] = "Toast.fire({icon: 'success',title: 'Data Program berhasil ditambahkan'})";
            echo '<script> window.location="programList?_token=' . encrypt($token) . '"; </script>';
        } else {
            $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Data Program gagal ditambahkan'})";
            echo '<script> window.location="programList?_token=' . encrypt($token) . '"; </script>';
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
