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

    case 'teamList':
        require_once(PUB_DIR . 'page/master/data-nama-tim.php');
        break;
    case 'setTeamList':
        require_once(PUB_DIR . 'page/master/data-tim/tim-aksi.php');
        break;

        //signout
    case 'logout':
        require_once(PUB_DIR . '../signout.php');
        break;

    default:
        require_once(PUB_DIR . 'page/home.php');
}
