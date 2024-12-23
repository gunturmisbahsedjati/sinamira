<?php
require_once '../../../../inc/inc.koneksi.php';
require_once '../../../../inc/inc.library.php';
require_once '../../../../inc/config.php';

header("Content-Type:application/json");

if (isset($_POST['token'])) {
    $outputResult = [];
    $id = decrypt($_POST['token']);
    $cekPeg = getPegSinadinByID($id);
    $pegJSON = @file_get_contents($cekPeg);
    $pegArr = json_decode($pegJSON, true);
    if ($pegArr['status']['code'] == '200') {
        $resultPeg = isset($pegArr['results']) ? $pegArr['results'] : array();
        foreach ($resultPeg as $arrPeg) {
            $outputResult['nama'] = $arrPeg['nama_manajemen'];
            $outputResult['username'] = $arrPeg['user_manajemen'];
            $outputResult['id'] = $arrPeg['id_manajemen'];
            $outputResult['level'] = $arrPeg['ket'];
        }
    }
} else {
    $outputResult['nama'] = 'Error';
    $outputResult['username'] = 'Error';
    $outputResult['id'] = 'Error';
    $outputResult['level'] = 'Error';
}


echo json_encode($outputResult);
