<?php
require_once 'inc.koneksi.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
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
	//$sql = "select * from akun_manajemen where user_manajemen=$username and pass_manajemen=$password";
	//$hasil = mysql_query($sql);
	$num = mysqli_num_rows(mysqli_query($myConnection, "SELECT * FROM akun_manajemen WHERE user_manajemen='$username' and pass_manajemen='$enc' and status_manajemen = 'aktif' and soft_delete = 0 "));
	if ($num > 0) {
		echo 1;
	} else {
		echo 0;
	}
} else {
	echo "What are you doing?";
}
