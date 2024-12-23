<?php
session_start();
if (isset($_SESSION['status_login'])) {
	header('location:./');
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="UTF-8">
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<meta name="description" content="SI-NaMiRA BBPMP Provinsi Jawa Timur">
	<meta name="robots" content="index" />
	<meta name="name" content="SINaMiRA">
	<meta name="shot-name" content="SINaMiRA">
	<meta name="keywords" content="sinamira jatim, aplikasi manajemen pelaporan, bansm provinsi jawa timur, sinamira badan akreditasi nasional sekolah madrasah" />
	<meta name="author" content="Arghavan Barra Al Misbah" />
	<meta name="language" content="Indonesia" />
	<meta name="theme-color" content="#0d0072" />
	<meta http-equiv="expires" content="0">
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache, must-revalidate">
	<title>Si-NaMiRA | BBPMP Provinsi Jawa Timur</title>
	<!-- Favicon icon -->
	<link rel="icon" href="assets/images/logo.png" type="image/x-icon">

	<!-- font css -->
	<link rel="stylesheet" href="assets/fonts/font-awsome-pro/css/pro.min.css">
	<link rel="stylesheet" href="assets/fonts/feather.css">
	<link rel="stylesheet" href="assets/fonts/fontawesome.css">
	<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

	<!-- vendor css -->
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/customizer.css">
	<link rel="stylesheet" href="assets/css/login.css">
	<link rel="stylesheet" type="text/css" href="assets/js/plugins/sweetalert/sweetalert2.css">
	<script src="assets/js/plugins/sweetalert/sweetalert2.js"></script>


</head>

<!-- [ auth-signin ] start -->
<div id="preloader">
	<div class="jumper">
		<div></div>
		<div></div>
		<div></div>
	</div>
</div>
<div class="auth-wrapper">
	<div class="auth-content">
		<div class="card">
			<div class="row align-items-center text-center">
				<div class="col-md-12">
					<div class="card-body">
						<img src="assets/images/logo.png" width="35%" alt="" class="img-fluid mb-2">
						<h4 class="mb-1 text-5xl text-body font-weight-bold">Si-NaMiRA</h4>
						<h6 class="mb-3 text-md text-secondary">Sistem Manajemen Monitoring Program Kerja</h6>
						<form id="formAuthentication" class="mb-3" action="" method="POST">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i data-feather="user"></i></span>
								</div>
								<input type="text" class="form-control" id="username" name="username" placeholder="username">
							</div>
							<div class="input-group mb-4">
								<div class="input-group-prepend">
									<span class="input-group-text"><i data-feather="lock"></i></span>
								</div>
								<input type="password" class="form-control" id="password" name="password" placeholder="password">
							</div>

							<div class="mt-4">
								<button class="btn d-grid w-100 btn-login" type="submit">LOGIN</button>
								<button class="btn btn-loading d-none disabled d-grid w-100" type="button">
									<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
								</button>
							</div>
							<!-- <button class="btn btn-block btn-primary mb-4">LOGIN</button> -->


						</form>
						<p class="mb-0 text-muted">&copy; BBPMP Provinsi Jawa Timur <?= date('Y') ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- [ auth-signin ] end -->
<noscript>
	<div style="background:#333;opacity:0.8;filter:alpha(opacity=80);width:100%;height:100%;position:fixed;top:0px;z-index:1099;"></div>
	<div style="background:#000;width:70%;margin:0% 15%;;position:fixed;top:20%;z-index:1100;text-align:center;padding:4%;color:#fff;">
		<p>We're sorry but Si-NaMiRA doesn't work properly without JavaScript enabled. Please enable it to continue.</p>
	</div>
</noscript>
<!-- Required Js -->
<script src="assets/js/vendor-all.min.js"></script>
<script src="assets/js/plugins/bootstrap.min.js"></script>
<script src="assets/js/plugins/feather.min.js"></script>
<script src="assets/js/pcoded.min.js"></script>
<script src="assets/js/wizard.js"></script>


</body>

</html>