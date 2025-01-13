<?php
require_once 'inc.koneksi.php';
require_once 'inc.library.php';
$username = htmlspecialchars($_POST['username']);
$password = htmlspecialchars($_POST['password']);
// $enc =md5($password);
$string1 = "cassie";
$string2 = "barra";
$md5_string1 = md5($string1);
$md5_string2 = md5($string2);
$text1 = substr($md5_string1, 0, 4);
$text2 = substr($md5_string2, 0, 4);
$enc = base64_encode(base64_encode($text1 . $password . $text2));
//$sql = "select * from member where user_manajemen=$username";
//$hasil = mysql_query($sql);
$num = mysqli_query($myConnection, "SELECT * FROM akun_manajemen WHERE user_manajemen='$username' and pass_manajemen='$enc' and status_manajemen = 'aktif' and soft_delete = 0 ");
$akun = mysqli_fetch_array($num);

session_start();
//$_SESSION['nama_pengguna']		= $akun['nama_pengguna'];
$isi = $akun['nama_manajemen'] . " berhasil login";
login($isi);
$_SESSION['username'] = $akun['user_manajemen'];
$_SESSION['id'] = $akun['id_manajemen'];
$_SESSION['level'] = $akun['level_manajemen'];
$_SESSION['akses_tim'] = $akun['area_manajemen'];
$_SESSION['nama_akun'] = $akun['nama_manajemen'];
$_SESSION['soft_delete'] = $akun['soft_delete'];
$_SESSION['status_login'] = true;
$_SESSION["login_time_stamp"] = time();
$arrayAkses = explode(",", $_SESSION['level']);

//$_SESSION['kode_akun']		= $akun['kode_akun'];
//$_SESSION['user_uuid']		= $akun['user_uuid'];

//echo $akun['email'];
