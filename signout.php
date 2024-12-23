<style>
	.swal2-container {
		z-index: 2000;
	}
</style>
<script>
	const Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: 1500,
		timerProgressBar: true
	})
</script>
<div class="container-xxl flex-grow-1 container-p-y">
	<h4>Terima kasih telah menggunakan aplikasi ini</h4>
</div>
<?php
require_once 'inc/inc.library.php';
$isi = $_SESSION['nama_akun'] . " berhasil keluar dari sistem";
logout($isi);
// echo "<h1>Terima kasih telah menggunakan aplikasi ini</h1>";
// session_start(); // memulai session
//$_SESSION['email']='';
session_unset();
session_destroy();
echo "<script> Toast.fire({
	icon: 'success',
	title: 'Proses logout sistem.....'
}).then(function() {
	if (true) {
		window.location = './';
	}
});</script>";
?>