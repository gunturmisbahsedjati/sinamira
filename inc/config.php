<?php

//konfigurasi api
$keySiratu = "e10adc3949ba59abbe56e057f20f883e";
$urlApiSiratu = "http://202.51.106.30/api-siratu/api/";
$hariIni = date('Y-m-d');
$thnIni = date('Y');
// $hariIni = '2023-01-02';


//fungsi umum start
function http_request($url)
{
    // persiapkan curl
    $ch = curl_init();

    // set url 
    curl_setopt($ch, CURLOPT_URL, $url);

    // set user agent    
    // curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

    // return the transfer as a string 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // $output contains the output string 
    $output = curl_exec($ch);

    // tutup curl 
    curl_close($ch);

    // mengembalikan hasil curl
    return $output;
}

function encPass($str)
{
    $string1 = "cassie";
    $string2 = "violeta";
    $md5_string1 = md5($string1);
    $md5_string2 = md5($string2);
    $text1 = substr($md5_string1, 0, 4);
    $text2 = substr($md5_string2, 0, 4);
    $enc = base64_encode(base64_encode($text1 . $str . $text2));
    return $enc;
}


//fungsi siratu
function getAllEmployee($keySiratu)
{
    global $urlApiSiratu;
    $api_url_siratu  = $urlApiSiratu . "getPegawai.php?apikey=" . urlencode($keySiratu);
    return $api_url_siratu;
}
function getDetailEmployee($keySiratu, $pegKey)
{
    global $urlApiSiratu;
    $api_url_siratu  = $urlApiSiratu . "getDetailPegawai.php?apikey=" . urlencode($keySiratu) . "&pegkey=" . urlencode($pegKey);
    return $api_url_siratu;
}
