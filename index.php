<?php
session_start();
require_once 'inc/inc.koneksi.php';
if (!isset($_SESSION['username'])) {
    header('location:/');
} else {
    $username = $_SESSION['username'];
    $nama_akun = $_SESSION['nama_akun'];
    $id = $_SESSION['id'];
    $level = $_SESSION['level'];
    $arrayAkses = explode(",", $_SESSION['level']);
    if (time() - $_SESSION["login_time_stamp"] > 86400) {
        session_unset();
        session_destroy();
        header("location:auth-signin");
    }
}

if (!isset($_SESSION['status_login'])) {
    header('location:auth-signin');
    exit;
}

$cek_status_akun = mysqli_num_rows(mysqli_query($myConnection, "SELECT * FROM akun_manajemen WHERE user_manajemen='$username' and id_manajemen = '$id' and level_manajemen = '$level' and status_manajemen = 'aktif' and soft_delete = 0 "));
if ($cek_status_akun == 0) {
    session_destroy();
    header("location:./");
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
    <meta name="keywords" content="sinamira jatim, aplikasi monitoring program kerja, bbpmp provinsi jawa timur, sinamira bbpmp provinsi jawa timur" />
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

    <!-- font css -->
    <link rel="stylesheet" href="assets/fonts/font-awsome-pro/css/pro.min.css">
    <link rel="stylesheet" href="assets/fonts/feather.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome.css">

    <!-- vendor css -->

    <link rel="stylesheet" href="assets/css/plugins/datatable.css">
    <link rel="stylesheet" href="assets/css/plugins/datatable-bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="assets/js/plugins/sweetalert/sweetalert2.css">
    <script src="assets/js/plugins/sweetalert/sweetalert2.js"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="assets/js/plugins/fullcalendar/fullcalendar.css">
    <link rel="stylesheet" type="text/css" href="assets/js/plugins/fullcalendar/fullcalendar.print.css" media='print'>
    <link rel="stylesheet" href="assets/css/style.css?rev=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/customizer.css">



</head>

<!-- <body class="" style="margin:0;" onload="loadingPage()"> -->

<body>
    <!-- [ Pre-loader ] start -->
    <!-- <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div> -->
    <!-- [ Pre-loader ] End -->
    <!-- [ Mobile header ] start -->
    <div class="pc-mob-header pc-header">
        <div class="pcm-logo">
            <img src="assets/images/logo.png" alt="" width="47px" class="logo logo-lg">
            <span class="text-white font-weight-bold text-2xl">Si-NaMiRA</span>
        </div>
        <div class="pcm-toolbar">
            <a href="#!" class="pc-head-link" id="mobile-collapse">
                <div class="hamburger hamburger--arrowturn">
                    <div class="hamburger-box">
                        <div class="hamburger-inner"></div>
                    </div>
                </div>
                <!-- <i data-feather="menu"></i> -->
            </a>
            <a href="#!" class="pc-head-link" id="header-collapse">
                <i data-feather="align-right"></i>
            </a>
        </div>
    </div>
    <!-- [ Mobile header ] End -->

    <!-- [ navigation menu ] start -->
    <?php
    include_once 'dashboard/sidebar.php';
    include_once 'dashboard/header.php'
    ?>
    <!-- [ navigation menu ] end -->
    <!-- [ Header ] start -->

    <!-- [ Header ] end -->

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pcoded-content">
            <!-- <div class="lds-spinner" id="loader">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div style="display:none;" id="content"> -->
            <div>
                <?php include_once 'dashboard/routes.php'; ?>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
    <noscript>
        <div style="background:#333;opacity:0.8;filter:alpha(opacity=80);width:100%;height:100%;position:fixed;top:0px;z-index:1099;"></div>
        <div style="background:#000;width:70%;margin:0% 15%;;position:fixed;top:20%;z-index:1100;text-align:center;padding:4%;color:#fff;">
            <p>We're sorry but Si-NaMiRA doesn't work properly without JavaScript enabled. Please enable it to continue.</p>
        </div>
    </noscript>
    <!-- Warning Section Ends -->
    <!-- Required Js -->

    <!-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script> -->

    <script src="assets/js/vendor-all.min.js"></script>
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <script src="assets/js/plugins/feather.min.js"></script>
    <script src="assets/js/pcoded.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
    <script src="assets/js/plugins/clipboard.min.js"></script>
    <script src="assets/js/uikit.min.js"></script>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap4.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
    <script src="assets/js/plugins/moment/moment.min.js"></script>
    <script src="assets/js/plugins/fullcalendar/fullcalendar.js"></script>
    <script src="assets/js/plugins/fullcalendar/locale-all.js"></script>
    <script src="assets/js/plugins/fullcalendar/gcal.js"></script>
    <script src="assets/js/wizard.js?rev=<?php echo time(); ?>"></script>
</body>

</html>