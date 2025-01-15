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

// if (in_array(1, $arrayAkses)) {
if (isset($_POST['addActivity']) && isset($_POST['_token'])  && isset($_POST['_key'])) {
    $code2 = time() . '-' . uniqid();
    $code = strtoupper($code2);
    $created_by = $_SESSION['id'];
    $id_program = decrypt(mysqli_escape_string($myConnection, $_POST['program']));
    $nama_kegiatan = htmlspecialchars(mysqli_escape_string($myConnection, bersihkanInsert($_POST['nama_kegiatan'])));
    $tgl_awal = substr($_POST['tgl_awal'], 6, 4) . '-' . substr($_POST['tgl_awal'], 3, 2) . '-' . substr($_POST['tgl_awal'], 0, 2);
    $tgl_akhir = substr($_POST['tgl_akhir'], 6, 4) . '-' . substr($_POST['tgl_akhir'], 3, 2) . '-' . substr($_POST['tgl_akhir'], 0, 2) . ' 23:59:59';
    $ket = htmlspecialchars(mysqli_escape_string($myConnection, bersihkanInsert($_POST['ket'])));

    $id_area = decrypt(mysqli_escape_string($myConnection, $_POST['_token']));
    $thn = decrypt(mysqli_escape_string($myConnection, $_POST['_key']));

    $insertKegiatan = mysqli_query($myConnection, "insert into tb_kegiatan (id_kegiatan, id_program, nama_kegiatan, tgl_awal, tgl_akhir, thn_kegiatan, id_area, ket, created_by, created_date) values ('$code2', '$id_program','$nama_kegiatan','$tgl_awal','$tgl_akhir','$thn','$id_area','$ket','$created_by', NOW())");
    if ($insertKegiatan) {
        $_SESSION['alert'] = "Toast.fire({icon: 'success',title: 'Data Kegiatan berhasil ditambahkan'})";
        echo '<script> window.location="detailActivityList?_token=' . encrypt($thn) . '&_key=' . encrypt($id_area) . '"; </script>';
    } else {
        $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Data Kegiatan gagal ditambahkan'})";
        echo '<script> window.location="detailActivityList?_token=' . encrypt($thn) . '&_key=' . encrypt($id_area) . '"; </script>';
    }
} elseif (isset($_POST['editActivity']) && isset($_POST['_id'])  && isset($_POST['_key'])) {
    $created_by = $_SESSION['id'];
    $id_program = decrypt(mysqli_escape_string($myConnection, $_POST['program']));
    $nama_kegiatan = htmlspecialchars(mysqli_escape_string($myConnection, bersihkanInsert($_POST['nama_kegiatan'])));
    $tgl_awal = substr($_POST['tgl_awal'], 6, 4) . '-' . substr($_POST['tgl_awal'], 3, 2) . '-' . substr($_POST['tgl_awal'], 0, 2);
    $tgl_akhir = substr($_POST['tgl_akhir'], 6, 4) . '-' . substr($_POST['tgl_akhir'], 3, 2) . '-' . substr($_POST['tgl_akhir'], 0, 2) . ' 23:59:59';
    $ket = htmlspecialchars(mysqli_escape_string($myConnection, bersihkanInsert($_POST['ket'])));

    $id_kegiatan = decrypt(mysqli_escape_string($myConnection, $_POST['_id']));
    $thn = decrypt(mysqli_escape_string($myConnection, $_POST['_key']));

    $cekKegiatan = mysqli_query($myConnection, "select * from tb_kegiatan where id_kegiatan = '$id_kegiatan' and thn_kegiatan = '$thn' and soft_delete = 0");
    if (mysqli_num_rows($cekKegiatan) > 0) {
        $viewCekKegiatan = mysqli_fetch_array($cekKegiatan);
        $updateKegiatan = mysqli_query($myConnection, "update tb_kegiatan set id_program = '$id_program', nama_kegiatan = '$nama_kegiatan', tgl_awal = '$tgl_awal', tgl_akhir = '$tgl_akhir', ket = '$ket' where id_kegiatan = '$id_kegiatan' and thn_kegiatan = '$thn' and soft_delete = 0");
        if ($updateKegiatan) {
            $_SESSION['alert'] = "Toast.fire({icon: 'success',title: 'Data Kegiatan berhasil diupdate'})";
            echo '<script> window.location="detailActivityList?_token=' . encrypt($thn) . '&_key=' . encrypt($viewCekKegiatan['id_area']) . '"; </script>';
        } else {
            $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Data Kegiatan gagal diupdate'})";
            echo '<script> window.location="detailActivityList?_token=' . encrypt($thn) . '&_key=' . encrypt($viewCekKegiatan['id_area']) . '"; </script>';
        }
    } else {
        $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'SQL Injection Detected !'})";
        echo '<script> window.location="detailActivityList"; </script>';
    }
} elseif (isset($_POST['delActivity']) && isset($_POST['_id'])  && isset($_POST['_key'])) {
    $id_kegiatan = decrypt(mysqli_escape_string($myConnection, $_POST['_id']));
    $thn = decrypt(mysqli_escape_string($myConnection, $_POST['_key']));

    $cekKegiatan = mysqli_query($myConnection, "select * from tb_kegiatan where id_kegiatan = '$id_kegiatan' and thn_kegiatan = '$thn' and soft_delete = 0");
    if (mysqli_num_rows($cekKegiatan) > 0) {
        $viewCekKegiatan = mysqli_fetch_array($cekKegiatan);
        $delKegiatan = mysqli_query($myConnection, "update tb_kegiatan set soft_delete = 1 where id_kegiatan = '$id_kegiatan' and thn_kegiatan = '$thn' and soft_delete = 0");
        if ($delKegiatan) {
            $_SESSION['alert'] = "Toast.fire({icon: 'success',title: 'Data Kegiatan berhasil dihapus'})";
            echo '<script> window.location="detailActivityList?_token=' . encrypt($thn) . '&_key=' . encrypt($viewCekKegiatan['id_area']) . '"; </script>';
        } else {
            $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Data Kegiatan gagal dihapus'})";
            echo '<script> window.location="detailActivityList?_token=' . encrypt($thn) . '&_key=' . encrypt($viewCekKegiatan['id_area']) . '"; </script>';
        }
    } else {
        $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'SQL Injection Detected !'})";
        echo '<script> window.location="detailActivityList"; </script>';
    }
} elseif (isset($_POST['updateStatusActivity']) && isset($_POST['_id'])  && isset($_POST['_key'])) {
    $id_kegiatan = decrypt(mysqli_escape_string($myConnection, $_POST['_id']));
    $thn = decrypt(mysqli_escape_string($myConnection, $_POST['_key']));
    $status_kegiatan = decrypt(mysqli_escape_string($myConnection, $_POST['status_keg']));

    $cekKegiatan = mysqli_query($myConnection, "select * from tb_kegiatan where id_kegiatan = '$id_kegiatan' and thn_kegiatan = '$thn' and soft_delete = 0");
    if (mysqli_num_rows($cekKegiatan) > 0) {
        $viewCekKegiatan = mysqli_fetch_array($cekKegiatan);
        $delKegiatan = mysqli_query($myConnection, "update tb_kegiatan set status_kegiatan = '$status_kegiatan' where id_kegiatan = '$id_kegiatan' and thn_kegiatan = '$thn' and soft_delete = 0");
        if ($delKegiatan) {
            $_SESSION['alert'] = "Toast.fire({icon: 'success',title: 'Status Kegiatan berhasil diupdate'})";
            echo '<script> window.location="detailActivityList?_token=' . encrypt($thn) . '&_key=' . encrypt($viewCekKegiatan['id_area']) . '"; </script>';
        } else {
            $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Status Kegiatan gagal diupdate'})";
            echo '<script> window.location="detailActivityList?_token=' . encrypt($thn) . '&_key=' . encrypt($viewCekKegiatan['id_area']) . '"; </script>';
        }
    } else {
        $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'SQL Injection Detected !'})";
        echo '<script> window.location="detailActivityList"; </script>';
    }
} else {
    $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'SQL Injection Detected !'})";
    echo '<script> window.location="programList"; </script>';
}
// } else {
//     echo '<script type="text/javascript">
//     window.location = "./"
//     </script>';
// }
