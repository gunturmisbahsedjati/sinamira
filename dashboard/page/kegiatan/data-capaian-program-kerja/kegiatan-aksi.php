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
    } elseif (isset($_POST['updateCalEvent']) && isset($_POST['_token'])) {
        $id_kegiatan = mysqli_escape_string($myConnection, $_POST['_token']);
        $status_kegiatan = mysqli_escape_string($myConnection, $_POST['status_kegiatan']);
        if ($level == 1 || $level == 2) {
            $cekKegiatan = mysqli_query($myConnection, "select * from tb_kegiatan where id_kegiatan = '$id_kegiatan' and soft_delete = 0");
            if (mysqli_num_rows($cekKegiatan) > 0) {
                $viewCekKegiatan = mysqli_fetch_array($cekKegiatan);
                $statusKegiatan = mysqli_query($myConnection, "update tb_kegiatan set status_kegiatan = '$status_kegiatan' where id_kegiatan = '$id_kegiatan' and soft_delete = 0");
                if ($statusKegiatan) {
                    $_SESSION['alert'] = "Toast.fire({icon: 'success',title: 'Status Kegiatan berhasil diupdate'})";
                    echo '<script> window.location="./"; </script>';
                } else {
                    $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Status Kegiatan gagal diupdate'})";
                    echo '<script> window.location="./"; </script>';
                }
            } else {
                $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'SQL Injection Detected !'})";
                echo '<script> window.location="./"; </script>';
            }
        } elseif ($level == 3) {
            $area = $_SESSION['akses_tim'];
            $cekJab = mysqli_query($myConnection, "select * from tb_kegiatan where id_kegiatan = '$id_kegiatan' and id_area = '$area' and soft_delete = 0");
            if (mysqli_num_rows($cekJab) > 0) {
                $statusKegiatan = mysqli_query($myConnection, "update tb_kegiatan set status_kegiatan = '$status_kegiatan' where id_kegiatan = '$id_kegiatan' and id_area = '$area' and soft_delete = 0");
                if ($statusKegiatan) {
                    $_SESSION['alert'] = "Toast.fire({icon: 'success',title: 'Status Kegiatan berhasil diupdate'})";
                    echo '<script> window.location="./"; </script>';
                } else {
                    $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Status Kegiatan gagal diupdate'})";
                    echo '<script> window.location="./"; </script>';
                }
            } else {
                $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Anda Tidak Memiliki Hak Akses !'})";
                echo '<script> window.location="./"; </script>';
            }
        } else {
            $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'SQL Injection Detected !'})";
            echo '<script> window.location="./"; </script>';
        }
    } elseif (isset($_POST['uploadDocActivities']) && isset($_POST['_token'])  && isset($_POST['_key'])) {
        $code = time() . '' . uniqid();
        $id_kegiatan = decrypt(mysqli_escape_string($myConnection, $_POST['_key']));
        $thn_kegiatan = decrypt(mysqli_escape_string($myConnection, $_POST['_token']));
        // $cekUndangan = isset($_POST['cek-surat-undangan']) ? 5 : 17;
        // // echo $_POST['cek-surat-undangan'] . '<br>';
        // $cekSK = isset($_POST['cek-sk']) ? 5 : 17;
        // $cekPanduan = isset($_POST['cek-panduan']) ? 5 : 17;
        // $cekST = isset($_POST['cek-st']) ? 5 : 17;
        // $cekDH = isset($_POST['cek-dh']) ? 5 : 17;
        // $cekNotula = isset($_POST['cek-notula']) ? 5 : 17;
        // $cekHK = isset($_POST['cek-hk']) ? 5 : 17;
        // $cekDok = isset($_POST['cek-dok']) ? 5 : 17;

        $cekKegiatan = mysqli_query($myConnection, "select * from tb_kegiatan where id_kegiatan = '$id_kegiatan' and soft_delete = 0");
        if (mysqli_num_rows($cekKegiatan) > 0) {
            $showFile = mysqli_fetch_array($cekKegiatan);
            if (!isset($_POST['cek-surat-undangan'])) {
                if (isset($_FILES['surat_undangan']['name']) && $_FILES['surat_undangan']['name'] != '') {
                    $file_surat_undangan = $_FILES['surat_undangan']['name'];
                    $size_file_surat_undangan = $_FILES['surat_undangan']['size'];
                    $tmp_file_surat_undangan = $_FILES['surat_undangan']['tmp_name'];
                    $tmp           = explode('.', $file_surat_undangan);
                    $fileExtension = strtolower(end($tmp));
                    $file_surat_undangan_name = $id_kegiatan . '_' . $code . '_surat_undangan.' . $fileExtension;
                    $path_file_surat_undangan = 'dokumen_kegiatan/surat_undangan/' . $file_surat_undangan_name;
                    move_uploaded_file($tmp_file_surat_undangan, $path_file_surat_undangan);
                } else {
                    if ($showFile['file_surat_undangan'] != 1 && $showFile['file_surat_undangan'] != '' && $showFile['file_surat_undangan'] != 0) {
                        $file_surat_undangan_name = $showFile['file_surat_undangan'];
                        // $file_surat_undangan_name = "nama file lama";
                    } else {
                        $file_surat_undangan_name = '';
                    }
                    // $file_surat_undangan_name = 1;
                }
            } else {
                $file_surat_undangan_name = 0;
            }

            // echo 'surat undangan ' . $file_surat_undangan_name . '<br>';
            // echo  $showFile['file_surat_undangan'] . '<br>';
            // // echo $_POST['cek-surat-undangan'] . '<br>';

            if (!isset($_POST['cek-sk'])) {
                if (isset($_FILES['sk_kegiatan']['name']) && $_FILES['sk_kegiatan']['name'] != '') {
                    $file_sk = $_FILES['sk_kegiatan']['name'];
                    $size_file_sk = $_FILES['sk_kegiatan']['size'];
                    $tmp_file_sk = $_FILES['sk_kegiatan']['tmp_name'];
                    $tmp           = explode('.', $file_sk);
                    $fileExtension = strtolower(end($tmp));
                    $file_sk_name = $id_kegiatan . '_' . $code . '_sk.' . $fileExtension;
                    $path_file_sk = 'dokumen_kegiatan/sk_kegiatan/' . $file_sk_name;
                    move_uploaded_file($tmp_file_sk, $path_file_sk);
                } else {
                    if ($showFile['file_sk_kegiatan'] != 1 && $showFile['file_sk_kegiatan'] != '' && $showFile['file_sk_kegiatan'] != 0) {
                        $file_sk_name = $showFile['file_sk_kegiatan'];
                    } else {
                        $file_sk_name = '';
                    }
                    // $file_sk_name = 1;
                }
            } else {
                $file_sk_name = 0;
            }


            if (!isset($_POST['cek-panduan'])) {
                if (isset($_FILES['panduan_kegiatan']['name']) && $_FILES['panduan_kegiatan']['name'] != '') {
                    $file_panduan = $_FILES['panduan_kegiatan']['name'];
                    $size_file_panduan = $_FILES['panduan_kegiatan']['size'];
                    $tmp_file_panduan = $_FILES['panduan_kegiatan']['tmp_name'];
                    $tmp           = explode('.', $file_panduan);
                    $fileExtension = strtolower(end($tmp));
                    $file_panduan_name = $id_kegiatan . '_' . $code . '_panduan.' . $fileExtension;
                    $path_file_panduan = 'dokumen_kegiatan/panduan/' . $file_panduan_name;
                    move_uploaded_file($tmp_file_panduan, $path_file_panduan);
                } else {
                    if ($showFile['file_panduan'] != 1 && $showFile['file_panduan'] != '' && $showFile['file_panduan'] != 0) {
                        $file_panduan_name = $showFile['file_panduan'];
                    } else {
                        $file_panduan_name = '';
                    }
                    // $file_panduan_name = 1;
                }
            } else {
                $file_panduan_name = 0;
            }

            if (!isset($_POST['cek-st'])) {
                if (isset($_FILES['surat_tugas']['name']) && $_FILES['surat_tugas']['name'] != '') {
                    $file_st = $_FILES['surat_tugas']['name'];
                    $size_file_st = $_FILES['surat_tugas']['size'];
                    $tmp_file_st = $_FILES['surat_tugas']['tmp_name'];
                    $tmp           = explode('.', $file_st);
                    $fileExtension = strtolower(end($tmp));
                    $file_st_name = $id_kegiatan . '_' . $code . '_st.' . $fileExtension;
                    $path_file_st = 'dokumen_kegiatan/surat_tugas/' . $file_st_name;
                    move_uploaded_file($tmp_file_st, $path_file_st);
                } else {
                    if ($showFile['file_surat_tugas'] != 1 && $showFile['file_surat_tugas'] != '' && $showFile['file_surat_tugas'] != 0) {
                        $file_st_name = $showFile['file_surat_tugas'];
                    } else {
                        $file_st_name = '';
                    }
                    // $file_st_name = 1;
                }
            } else {
                $file_st_name = 0;
            }

            if (!isset($_POST['cek-dh'])) {
                if (isset($_FILES['dh']['name']) && $_FILES['dh']['name'] != '') {
                    $file_dh = $_FILES['dh']['name'];
                    $size_file_dh = $_FILES['dh']['size'];
                    $tmp_file_dh = $_FILES['dh']['tmp_name'];
                    $tmp           = explode('.', $file_dh);
                    $fileExtension = strtolower(end($tmp));
                    $file_dh_name = $id_kegiatan . '_' . $code . '_dh.' . $fileExtension;
                    $path_file_dh = 'dokumen_kegiatan/daftar_hadir/' . $file_dh_name;
                    move_uploaded_file($tmp_file_dh, $path_file_dh);
                } else {
                    if ($showFile['file_daftar_hadir'] != 1 && $showFile['file_daftar_hadir'] != '' && $showFile['file_daftar_hadir'] != 0) {
                        $file_dh_name = $showFile['file_daftar_hadir'];
                    } else {
                        $file_dh_name = '';
                    }
                    // $file_dh_name = 1;
                }
            } else {
                $file_dh_name = 0;
            }

            if (!isset($_POST['cek-notula'])) {
                if (isset($_FILES['notula']['name']) && $_FILES['notula']['name'] != '') {
                    $file_notula = $_FILES['notula']['name'];
                    $size_file_notula = $_FILES['notula']['size'];
                    $tmp_file_notula = $_FILES['notula']['tmp_name'];
                    $tmp           = explode('.', $file_notula);
                    $fileExtension = strtolower(end($tmp));
                    $file_notula_name = $id_kegiatan . '_' . $code . '_notula.' . $fileExtension;
                    $path_file_notula = 'dokumen_kegiatan/notula/' . $file_notula_name;
                    move_uploaded_file($tmp_file_notula, $path_file_notula);
                } else {
                    if ($showFile['file_notula'] != 1 && $showFile['file_notula'] != '' && $showFile['file_notula'] != 0) {
                        $file_notula_name = $showFile['file_notula'];
                    } else {
                        $file_notula_name = '';
                    }
                    // $file_notula_name = 1;
                }
            } else {
                $file_notula_name = 0;
            }

            if (!isset($_POST['cek-hk'])) {
                if (isset($_FILES['hasil_kegiatan']['name']) && $_FILES['hasil_kegiatan']['name'] != '') {
                    $file_hk = $_FILES['hasil_kegiatan']['name'];
                    $size_file_hk = $_FILES['hasil_kegiatan']['size'];
                    $tmp_file_hk = $_FILES['hasil_kegiatan']['tmp_name'];
                    $tmp           = explode('.', $file_hk);
                    $fileExtension = strtolower(end($tmp));
                    $file_hk_name = $id_kegiatan . '_' . $code . '_hasil_kegiatan.' . $fileExtension;
                    $path_file_hk = 'dokumen_kegiatan/hasil_kegiatan/' . $file_hk_name;
                    move_uploaded_file($tmp_file_hk, $path_file_hk);
                } else {
                    if ($showFile['file_hasil_kegiatan'] != 1 && $showFile['file_hasil_kegiatan'] != '' && $showFile['file_hasil_kegiatan'] != 0) {
                        $file_hk_name = $showFile['file_hasil_kegiatan'];
                    } else {
                        $file_hk_name = '';
                    }
                    // $file_hk_name = 1;
                }
            } else {
                $file_hk_name = 0;
            }

            if (!isset($_POST['cek-dok'])) {
                if (isset($_FILES['dokumentasi']['name']) && $_FILES['dokumentasi']['name'] != '') {
                    $file_dok = $_FILES['dokumentasi']['name'];
                    $size_file_dok = $_FILES['dokumentasi']['size'];
                    $tmp_file_dok = $_FILES['dokumentasi']['tmp_name'];
                    $tmp           = explode('.', $file_dok);
                    $fileExtension = strtolower(end($tmp));
                    $file_dok_name = $id_kegiatan . '_' . $code . '_dok_kegiatan.' . $fileExtension;
                    $path_file_dok = 'dokumen_kegiatan/dokumentasi/' . $file_dok_name;
                    move_uploaded_file($tmp_file_dok, $path_file_dok);
                } else {
                    if ($showFile['file_dokumentasi'] != 1 && $showFile['file_dokumentasi'] != '' && $showFile['file_dokumentasi'] != 0) {
                        $file_dok_name = $showFile['file_dokumentasi'];
                    } else {
                        $file_dok_name = '';
                    }
                }
            } else {
                $file_dok_name = 0;
            }

            $queryUpload = 'update tb_kegiatan set ';
            if ($file_surat_undangan_name != '' || $file_surat_undangan_name == 0 || $showFile['file_surat_undangan'] == 1) {
                $queryUpload .= 'file_surat_undangan = "' . $file_surat_undangan_name . '", ';
            } else {
                $queryUpload .= 'file_surat_undangan = "' . $showFile['file_surat_undangan'] . '", ';
            }
            if ($file_sk_name != '' || $file_sk_name == 0) {
                $queryUpload .= 'file_sk_kegiatan = "' . $file_sk_name . '", ';
            } else {
                $queryUpload .= 'file_sk_kegiatan = "' . $showFile['file_sk_kegiatan'] . '", ';
            }
            if ($file_panduan_name != '' || $file_panduan_name == 0) {
                $queryUpload .= 'file_panduan = "' . $file_panduan_name . '", ';
            } else {
                $queryUpload .= 'file_panduan = "' . $showFile['file_panduan'] . '", ';
            }
            if ($file_st_name != '' || $file_st_name == 0) {
                $queryUpload .= 'file_surat_tugas = "' . $file_st_name . '", ';
            } else {
                $queryUpload .= 'file_surat_tugas = "' . $showFile['file_surat_tugas'] . '", ';
            }
            if ($file_dh_name != '' || $file_dh_name == 0) {
                $queryUpload .= 'file_daftar_hadir = "' . $file_dh_name . '", ';
            } else {
                $queryUpload .= 'file_daftar_hadir = "' . $showFile['file_daftar_hadir'] . '", ';
            }
            if ($file_notula_name != '' || $file_notula_name == 0) {
                $queryUpload .= 'file_notula = "' . $file_notula_name . '", ';
            } else {
                $queryUpload .= 'file_notula = "' . $showFile['file_notula'] . '", ';
            }
            if ($file_hk_name != '' || $file_hk_name == 0) {
                $queryUpload .= 'file_hasil_kegiatan = "' . $file_hk_name . '", ';
            } else {
                $queryUpload .= 'file_hasil_kegiatan = "' . $showFile['file_hasil_kegiatan'] . '", ';
            }
            if ($file_dok_name != '' || $file_dok_name == 0) {
                $queryUpload .= 'file_dokumentasi = "' . $file_dok_name . '" ';
            } else {
                $queryUpload .= 'file_dokumentasi = "' . $showFile['file_dokumentasi'] . '" ';
            }

            $queryUpload .= 'where id_kegiatan = "' . $id_kegiatan . '" and thn_kegiatan = "' . $thn_kegiatan . '" and soft_delete = 0';

            $updateKegiatan = mysqli_query($myConnection, $queryUpload);

            if ($updateKegiatan) {
                $_SESSION['alert'] = "Toast.fire({icon: 'success',title: 'Dokumen Kegiatan berhasil diupload'})";
                echo '<script> window.location="detailActivityList?_token=' . encrypt($thn_kegiatan) . '&_key=' . encrypt($showFile['id_area']) . '"; </script>';
            } else {
                $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Dokumen Kegiatan gagal diupload'})";
                echo '<script> window.location="detailActivityList?_token=' . encrypt($thn_kegiatan) . '&_key=' . encrypt($showFile['id_area']) . '"; </script>';
            }

            // echo $queryUpload . '<br>';


            // echo 'surat undangan ' . $file_surat_undangan_name . '<br>';
            // echo 'sk ' . $file_sk_name . '<br>';
            // echo 'panduan ' . $file_panduan_name . '<br>';
            // echo 'st ' . $file_st_name . '<br>';
            // echo 'dh ' . $file_dh_name . '<br>';
            // echo 'notula ' . $file_notula_name . '<br>';
            // echo 'hk ' . $file_hk_name . '<br>';
            // echo 'dok ' . $file_dok_name . '<br>';
        } else {
            $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'SQL Injection Detected !'})";
            echo '<script> window.location="programList"; </script>';
        }
    } else {
        $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'SQL Injection Detected !'})";
        echo '<script> window.location="programList"; </script>';
    }
} elseif (in_array(3, $arrayAkses)) {
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

        if ($id_area == $_SESSION['akses_tim']) {
            $insertKegiatan = mysqli_query($myConnection, "insert into tb_kegiatan (id_kegiatan, id_program, nama_kegiatan, tgl_awal, tgl_akhir, thn_kegiatan, id_area, ket, created_by, created_date) values ('$code2', '$id_program','$nama_kegiatan','$tgl_awal','$tgl_akhir','$thn','$id_area','$ket','$created_by', NOW())");
            if ($insertKegiatan) {
                $_SESSION['alert'] = "Toast.fire({icon: 'success',title: 'Data Kegiatan berhasil ditambahkan'})";
                echo '<script> window.location="detailActivityList?_token=' . encrypt($thn) . '&_key=' . encrypt($id_area) . '"; </script>';
            } else {
                $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Data Kegiatan gagal ditambahkan'})";
                echo '<script> window.location="detailActivityList?_token=' . encrypt($thn) . '&_key=' . encrypt($id_area) . '"; </script>';
            }
        } else {
            $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'SQL Injection Detected !'})";
            echo '<script> window.location="detailActivityList?_token=' . encrypt($thn) . '&_key=' . encrypt($id_area) . '"; </script>';
        }
    } elseif (isset($_POST['updateCalEvent']) && isset($_POST['_token'])) {
        $id_kegiatan = mysqli_escape_string($myConnection, $_POST['_token']);
        $status_kegiatan = mysqli_escape_string($myConnection, $_POST['status_kegiatan']);
        $area = $_SESSION['akses_tim'];
        $cekJab = mysqli_query($myConnection, "select * from tb_kegiatan where id_kegiatan = '$id_kegiatan' and id_area = '$area' and soft_delete = 0");
        if (mysqli_num_rows($cekJab) > 0) {
            $statusKegiatan = mysqli_query($myConnection, "update tb_kegiatan set status_kegiatan = '$status_kegiatan' where id_kegiatan = '$id_kegiatan' and id_area = '$area' and soft_delete = 0");
            if ($statusKegiatan) {
                $_SESSION['alert'] = "Toast.fire({icon: 'success',title: 'Status Kegiatan berhasil diupdate'})";
                echo '<script> window.location="./"; </script>';
            } else {
                $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Status Kegiatan gagal diupdate'})";
                echo '<script> window.location="./"; </script>';
            }
        } else {
            $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Anda Tidak Memiliki Hak Akses !'})";
            echo '<script> window.location="./"; </script>';
        }
    } elseif (isset($_POST['updateStatusActivity']) && isset($_POST['_id'])  && isset($_POST['_key'])) {
        $id_kegiatan = decrypt(mysqli_escape_string($myConnection, $_POST['_id']));
        $thn = decrypt(mysqli_escape_string($myConnection, $_POST['_key']));
        $status_kegiatan = decrypt(mysqli_escape_string($myConnection, $_POST['status_keg']));

        $cekKegiatan = mysqli_query($myConnection, "select * from tb_kegiatan where id_kegiatan = '$id_kegiatan' and thn_kegiatan = '$thn' and soft_delete = 0");
        if (mysqli_num_rows($cekKegiatan) > 0) {
            $viewCekKegiatan = mysqli_fetch_array($cekKegiatan);
            if ($viewCekKegiatan['id_area'] == $_SESSION['akses_tim']) {
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
                echo '<script> window.location="detailActivityList?_token=' . encrypt($thn) . '&_key=' . encrypt($viewCekKegiatan['id_area']) . '"; </script>';
            }
        } else {
            $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'SQL Injection Detected !'})";
            echo '<script> window.location="detailActivityList"; </script>';
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

            if ($viewCekKegiatan['id_area'] == $_SESSION['akses_tim']) {
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
                echo '<script> window.location="detailActivityList?_token=' . encrypt($thn) . '&_key=' . encrypt($viewCekKegiatan['id_area']) . '"; </script>';
            }
        } else {
            $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'SQL Injection Detected !'})";
            echo '<script> window.location="detailActivityList"; </script>';
        }
    } elseif (isset($_POST['uploadDocActivities']) && isset($_POST['_token'])  && isset($_POST['_key'])) {
        $code = time() . '' . uniqid();
        $id_kegiatan = decrypt(mysqli_escape_string($myConnection, $_POST['_key']));
        $thn_kegiatan = decrypt(mysqli_escape_string($myConnection, $_POST['_token']));

        $cekKegiatan = mysqli_query($myConnection, "select * from tb_kegiatan where id_kegiatan = '$id_kegiatan' and soft_delete = 0");
        if (mysqli_num_rows($cekKegiatan) > 0) {
            $showFile = mysqli_fetch_array($cekKegiatan);
            if ($_SESSION['akses_tim'] == $showFile['id_area']) {
                if (!isset($_POST['cek-surat-undangan'])) {
                    if (isset($_FILES['surat_undangan']['name']) && $_FILES['surat_undangan']['name'] != '') {
                        $file_surat_undangan = $_FILES['surat_undangan']['name'];
                        $size_file_surat_undangan = $_FILES['surat_undangan']['size'];
                        $tmp_file_surat_undangan = $_FILES['surat_undangan']['tmp_name'];
                        $tmp           = explode('.', $file_surat_undangan);
                        $fileExtension = strtolower(end($tmp));
                        $file_surat_undangan_name = $id_kegiatan . '_' . $code . '_surat_undangan.' . $fileExtension;
                        $path_file_surat_undangan = 'dokumen_kegiatan/surat_undangan/' . $file_surat_undangan_name;
                        move_uploaded_file($tmp_file_surat_undangan, $path_file_surat_undangan);
                    } else {
                        if ($showFile['file_surat_undangan'] != 1 && $showFile['file_surat_undangan'] != '' && $showFile['file_surat_undangan'] != 0) {
                            $file_surat_undangan_name = $showFile['file_surat_undangan'];
                        } else {
                            $file_surat_undangan_name = '';
                        }
                    }
                } else {
                    $file_surat_undangan_name = 0;
                }

                if (!isset($_POST['cek-sk'])) {
                    if (isset($_FILES['sk_kegiatan']['name']) && $_FILES['sk_kegiatan']['name'] != '') {
                        $file_sk = $_FILES['sk_kegiatan']['name'];
                        $size_file_sk = $_FILES['sk_kegiatan']['size'];
                        $tmp_file_sk = $_FILES['sk_kegiatan']['tmp_name'];
                        $tmp           = explode('.', $file_sk);
                        $fileExtension = strtolower(end($tmp));
                        $file_sk_name = $id_kegiatan . '_' . $code . '_sk.' . $fileExtension;
                        $path_file_sk = 'dokumen_kegiatan/sk_kegiatan/' . $file_sk_name;
                        move_uploaded_file($tmp_file_sk, $path_file_sk);
                    } else {
                        if ($showFile['file_sk_kegiatan'] != 1 && $showFile['file_sk_kegiatan'] != '' && $showFile['file_sk_kegiatan'] != 0) {
                            $file_sk_name = $showFile['file_sk_kegiatan'];
                        } else {
                            $file_sk_name = '';
                        }
                    }
                } else {
                    $file_sk_name = 0;
                }


                if (!isset($_POST['cek-panduan'])) {
                    if (isset($_FILES['panduan_kegiatan']['name']) && $_FILES['panduan_kegiatan']['name'] != '') {
                        $file_panduan = $_FILES['panduan_kegiatan']['name'];
                        $size_file_panduan = $_FILES['panduan_kegiatan']['size'];
                        $tmp_file_panduan = $_FILES['panduan_kegiatan']['tmp_name'];
                        $tmp           = explode('.', $file_panduan);
                        $fileExtension = strtolower(end($tmp));
                        $file_panduan_name = $id_kegiatan . '_' . $code . '_panduan.' . $fileExtension;
                        $path_file_panduan = 'dokumen_kegiatan/panduan/' . $file_panduan_name;
                        move_uploaded_file($tmp_file_panduan, $path_file_panduan);
                    } else {
                        if ($showFile['file_panduan'] != 1 && $showFile['file_panduan'] != '' && $showFile['file_panduan'] != 0) {
                            $file_panduan_name = $showFile['file_panduan'];
                        } else {
                            $file_panduan_name = '';
                        }
                    }
                } else {
                    $file_panduan_name = 0;
                }

                if (!isset($_POST['cek-st'])) {
                    if (isset($_FILES['surat_tugas']['name']) && $_FILES['surat_tugas']['name'] != '') {
                        $file_st = $_FILES['surat_tugas']['name'];
                        $size_file_st = $_FILES['surat_tugas']['size'];
                        $tmp_file_st = $_FILES['surat_tugas']['tmp_name'];
                        $tmp           = explode('.', $file_st);
                        $fileExtension = strtolower(end($tmp));
                        $file_st_name = $id_kegiatan . '_' . $code . '_st.' . $fileExtension;
                        $path_file_st = 'dokumen_kegiatan/surat_tugas/' . $file_st_name;
                        move_uploaded_file($tmp_file_st, $path_file_st);
                    } else {
                        if ($showFile['file_surat_tugas'] != 1 && $showFile['file_surat_tugas'] != '' && $showFile['file_surat_tugas'] != 0) {
                            $file_st_name = $showFile['file_surat_tugas'];
                        } else {
                            $file_st_name = '';
                        }
                    }
                } else {
                    $file_st_name = 0;
                }

                if (!isset($_POST['cek-dh'])) {
                    if (isset($_FILES['dh']['name']) && $_FILES['dh']['name'] != '') {
                        $file_dh = $_FILES['dh']['name'];
                        $size_file_dh = $_FILES['dh']['size'];
                        $tmp_file_dh = $_FILES['dh']['tmp_name'];
                        $tmp           = explode('.', $file_dh);
                        $fileExtension = strtolower(end($tmp));
                        $file_dh_name = $id_kegiatan . '_' . $code . '_dh.' . $fileExtension;
                        $path_file_dh = 'dokumen_kegiatan/daftar_hadir/' . $file_dh_name;
                        move_uploaded_file($tmp_file_dh, $path_file_dh);
                    } else {
                        if ($showFile['file_daftar_hadir'] != 1 && $showFile['file_daftar_hadir'] != '' && $showFile['file_daftar_hadir'] != 0) {
                            $file_dh_name = $showFile['file_daftar_hadir'];
                        } else {
                            $file_dh_name = '';
                        }
                    }
                } else {
                    $file_dh_name = 0;
                }

                if (!isset($_POST['cek-notula'])) {
                    if (isset($_FILES['notula']['name']) && $_FILES['notula']['name'] != '') {
                        $file_notula = $_FILES['notula']['name'];
                        $size_file_notula = $_FILES['notula']['size'];
                        $tmp_file_notula = $_FILES['notula']['tmp_name'];
                        $tmp           = explode('.', $file_notula);
                        $fileExtension = strtolower(end($tmp));
                        $file_notula_name = $id_kegiatan . '_' . $code . '_notula.' . $fileExtension;
                        $path_file_notula = 'dokumen_kegiatan/notula/' . $file_notula_name;
                        move_uploaded_file($tmp_file_notula, $path_file_notula);
                    } else {
                        if ($showFile['file_notula'] != 1 && $showFile['file_notula'] != '' && $showFile['file_notula'] != 0) {
                            $file_notula_name = $showFile['file_notula'];
                        } else {
                            $file_notula_name = '';
                        }
                    }
                } else {
                    $file_notula_name = 0;
                }

                if (!isset($_POST['cek-hk'])) {
                    if (isset($_FILES['hasil_kegiatan']['name']) && $_FILES['hasil_kegiatan']['name'] != '') {
                        $file_hk = $_FILES['hasil_kegiatan']['name'];
                        $size_file_hk = $_FILES['hasil_kegiatan']['size'];
                        $tmp_file_hk = $_FILES['hasil_kegiatan']['tmp_name'];
                        $tmp           = explode('.', $file_hk);
                        $fileExtension = strtolower(end($tmp));
                        $file_hk_name = $id_kegiatan . '_' . $code . '_hasil_kegiatan.' . $fileExtension;
                        $path_file_hk = 'dokumen_kegiatan/hasil_kegiatan/' . $file_hk_name;
                        move_uploaded_file($tmp_file_hk, $path_file_hk);
                    } else {
                        if ($showFile['file_hasil_kegiatan'] != 1 && $showFile['file_hasil_kegiatan'] != '' && $showFile['file_hasil_kegiatan'] != 0) {
                            $file_hk_name = $showFile['file_hasil_kegiatan'];
                        } else {
                            $file_hk_name = '';
                        }
                    }
                } else {
                    $file_hk_name = 0;
                }

                if (!isset($_POST['cek-dok'])) {
                    if (isset($_FILES['dokumentasi']['name']) && $_FILES['dokumentasi']['name'] != '') {
                        $file_dok = $_FILES['dokumentasi']['name'];
                        $size_file_dok = $_FILES['dokumentasi']['size'];
                        $tmp_file_dok = $_FILES['dokumentasi']['tmp_name'];
                        $tmp           = explode('.', $file_dok);
                        $fileExtension = strtolower(end($tmp));
                        $file_dok_name = $id_kegiatan . '_' . $code . '_dok_kegiatan.' . $fileExtension;
                        $path_file_dok = 'dokumen_kegiatan/dokumentasi/' . $file_dok_name;
                        move_uploaded_file($tmp_file_dok, $path_file_dok);
                    } else {
                        if ($showFile['file_dokumentasi'] != 1 && $showFile['file_dokumentasi'] != '' && $showFile['file_dokumentasi'] != 0) {
                            $file_dok_name = $showFile['file_dokumentasi'];
                        } else {
                            $file_dok_name = '';
                        }
                    }
                } else {
                    $file_dok_name = 0;
                }

                $queryUpload = 'update tb_kegiatan set ';
                if ($file_surat_undangan_name != '' || $file_surat_undangan_name == 0 || $showFile['file_surat_undangan'] == 1) {
                    $queryUpload .= 'file_surat_undangan = "' . $file_surat_undangan_name . '", ';
                } else {
                    $queryUpload .= 'file_surat_undangan = "' . $showFile['file_surat_undangan'] . '", ';
                }
                if ($file_sk_name != '' || $file_sk_name == 0) {
                    $queryUpload .= 'file_sk_kegiatan = "' . $file_sk_name . '", ';
                } else {
                    $queryUpload .= 'file_sk_kegiatan = "' . $showFile['file_sk_kegiatan'] . '", ';
                }
                if ($file_panduan_name != '' || $file_panduan_name == 0) {
                    $queryUpload .= 'file_panduan = "' . $file_panduan_name . '", ';
                } else {
                    $queryUpload .= 'file_panduan = "' . $showFile['file_panduan'] . '", ';
                }
                if ($file_st_name != '' || $file_st_name == 0) {
                    $queryUpload .= 'file_surat_tugas = "' . $file_st_name . '", ';
                } else {
                    $queryUpload .= 'file_surat_tugas = "' . $showFile['file_surat_tugas'] . '", ';
                }
                if ($file_dh_name != '' || $file_dh_name == 0) {
                    $queryUpload .= 'file_daftar_hadir = "' . $file_dh_name . '", ';
                } else {
                    $queryUpload .= 'file_daftar_hadir = "' . $showFile['file_daftar_hadir'] . '", ';
                }
                if ($file_notula_name != '' || $file_notula_name == 0) {
                    $queryUpload .= 'file_notula = "' . $file_notula_name . '", ';
                } else {
                    $queryUpload .= 'file_notula = "' . $showFile['file_notula'] . '", ';
                }
                if ($file_hk_name != '' || $file_hk_name == 0) {
                    $queryUpload .= 'file_hasil_kegiatan = "' . $file_hk_name . '", ';
                } else {
                    $queryUpload .= 'file_hasil_kegiatan = "' . $showFile['file_hasil_kegiatan'] . '", ';
                }
                if ($file_dok_name != '' || $file_dok_name == 0) {
                    $queryUpload .= 'file_dokumentasi = "' . $file_dok_name . '" ';
                } else {
                    $queryUpload .= 'file_dokumentasi = "' . $showFile['file_dokumentasi'] . '" ';
                }

                $queryUpload .= 'where id_kegiatan = "' . $id_kegiatan . '" and thn_kegiatan = "' . $thn_kegiatan . '" and soft_delete = 0';

                // echo $queryUpload;

                $updateKegiatan = mysqli_query($myConnection, $queryUpload);

                if ($updateKegiatan) {
                    $_SESSION['alert'] = "Toast.fire({icon: 'success',title: 'Dokumen Kegiatan berhasil diupload'})";
                    echo '<script> window.location="detailActivityList?_token=' . encrypt($thn_kegiatan) . '&_key=' . encrypt($showFile['id_area']) . '"; </script>';
                } else {
                    $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'Dokumen Kegiatan gagal diupload'})";
                    echo '<script> window.location="detailActivityList?_token=' . encrypt($thn_kegiatan) . '&_key=' . encrypt($showFile['id_area']) . '"; </script>';
                }
            } else {
                $_SESSION['alert'] = "Toast.fire({icon: 'error',title: 'SQL Injection Detected !'})";
                echo '<script> window.location="detailActivityList?_token=' . encrypt($thn_kegiatan) . '&_key=' . encrypt($showFile['id_area']) . '"; </script>';
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
