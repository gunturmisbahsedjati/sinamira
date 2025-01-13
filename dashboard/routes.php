<?php
$do = explode("/", $_REQUEST['do']);
$opsi = $do[0];

define('PUB_DIR', dirname(__FILE__) . '/');

switch ($opsi) {
    case 'home':
        require_once(PUB_DIR . 'page/home.php');
        break;

        //modul
    case 'account':
        require_once(PUB_DIR . 'page/master/data-pengguna.php');
        break;
    case 'setAccount':
        require_once(PUB_DIR . 'page/master/data-pengguna/akun-aksi.php');
        break;

    case 'areaList':
        require_once(PUB_DIR . 'page/master/data-area.php');
        break;
    case 'setAreaList':
        require_once(PUB_DIR . 'page/master/data-area/area-aksi.php');
        break;

    case 'programList':
        require_once(PUB_DIR . 'page/kegiatan/data-program-kerja.php');
        break;
    case 'setProgramList':
        require_once(PUB_DIR . 'page/kegiatan/data-program-kerja/program-aksi.php');
        break;
    case 'activityList':
        require_once(PUB_DIR . 'page/kegiatan/data-kegiatan-program-kerja.php');
        break;
    case 'detailActivityList':
        require_once(PUB_DIR . 'page/kegiatan/data-kegiatan-program-kerja/detail-kegiatan-data-program-kerja.php');
        break;
    case 'setActivityList':
        require_once(PUB_DIR . 'page/kegiatan/data-kegiatan-program-kerja/kegiatan-aksi.php');
        break;

        //common fitur
    case 'setCommonFeature':
        require_once(PUB_DIR . 'page/common-fitur/common-fitur-aksi.php');
        break;
        //signout
    case 'logout':
        require_once(PUB_DIR . '../signout.php');
        break;

    default:
        require_once(PUB_DIR . 'page/home.php');
}
