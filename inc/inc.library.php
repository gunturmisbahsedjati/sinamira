<?php
function utf8ize($mixed)
{
	if (is_array($mixed)) {
		foreach ($mixed as $key => $value) {
			$mixed[$key] = utf8ize($value);
		}
	} elseif (is_string($mixed)) {
		return mb_convert_encoding($mixed, "UTF-8", "UTF-8");
	}
	return $mixed;
}
$bulanIndonesia = array(
	"1" => "Januari",
	"2" => "Februari",
	"3" => "Maret",
	"4" => "April",
	"5" => "Mei",
	"6" => "Juni",
	"7" => "Juli",
	"8" => "Agustus",
	"9" => "September",
	"10" => "Oktober",
	"11" => "November",
	"12" => "Desember"
);

# Pengaturan tanggal komputer
date_default_timezone_set("Asia/Jakarta");

$arraysm = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20];
$arraypkbm = [21, 22, 23, 24, 25, 26, 27, 28];
$arraypaud = [29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39];

#fungsi get jenjang
function getJenjang($rumpun)
{
	$rumpun_sm = '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20';
	$rumpun_pkbm = '21,22,23,24,25,26,27,28';
	$rumpun_paud = '29,30,31,32,33,34,35,36,37,38,39';
	$no_rumpun = '0';

	if ($rumpun == 'sm') {
		$filterRumpun = $rumpun_sm;
	} elseif ($rumpun == 'paud') {
		$filterRumpun = $rumpun_paud;
	} elseif ($rumpun == 'pkbm') {
		$filterRumpun = $rumpun_pkbm;
	} else {
		$filterRumpun = $no_rumpun;
	}

	return $filterRumpun;
}

# Fungsi untuk membalik tanggal dari format English (Y-m-d) -> Indo (d-m-Y)
function Indonesia2Tgl($tanggal)
{
	$namaBln = array(
		"01" => "Januari",
		"02" => "Februari",
		"03" => "Maret",
		"04" => "April",
		"05" => "Mei",
		"06" => "Juni",
		"07" => "Juli",
		"08" => "Agustus",
		"09" => "September",
		"10" => "Oktober",
		"11" => "November",
		"12" => "Desember"
	);

	$tgl = substr($tanggal, 8, 2);
	$bln = substr($tanggal, 5, 2);
	$thn = substr($tanggal, 0, 4);
	$tanggal = "$tgl " . $namaBln[$bln] . " $thn";
	return $tanggal;
}

function hariTgl($tgl)
{
	$dayList = array(
		'Sun' => 'Minggu',
		'Mon' => 'Senin',
		'Tue' => 'Selasa',
		'Wed' => 'Rabu',
		'Thu' => 'Kamis',
		'Fri' => 'Jumat',
		'Sat' => 'Sabtu'
	);
	$tgl = $dayList[date('D', strtotime($tgl))];
	return $tgl;
}

function angka2Bln($bulan)
{
	$namaBln = array(
		"1" => "Januari",
		"2" => "Februari",
		"3" => "Maret",
		"4" => "April",
		"5" => "Mei",
		"6" => "Juni",
		"7" => "Juli",
		"8" => "Agustus",
		"9" => "September",
		"10" => "Oktober",
		"11" => "November",
		"12" => "Desember"
	);

	$bulan = $namaBln[$bulan];
	return $bulan;
}
function angka2BlnKapital($bulan)
{
	$namaBln = array(
		"1" => "JANUARI",
		"2" => "FEBRUARI",
		"3" => "MARET",
		"4" => "APRIL",
		"5" => "MEI",
		"6" => "JUNI",
		"7" => "JULI",
		"8" => "AGUSTUS",
		"9" => "SEPTEMBER",
		"10" => "OKTOBER",
		"11" => "NOVEMBER",
		"12" => "DESEMBER"
	);

	$bulan = $namaBln[$bulan];
	return $bulan;
}
function tanggal($tanggal)
{
	$tgl = substr($tanggal, 8, 2);
	$bln = substr($tanggal, 5, 2);
	$thn = substr($tanggal, 0, 4);
	$tanggal = "$tgl-$bln-$thn";
	return $tanggal;
}
function utanggal($tanggal)
{
	$tgl = substr($tanggal, 8, 2);
	$bln = substr($tanggal, 5, 2);
	$thn = substr($tanggal, 0, 4);
	$tanggal = "$tgl-$bln-$thn";
	return $tanggal;
}
function hitungHari($myDate1, $myDate2)
{
	$myDate1 = strtotime($myDate1);
	$myDate2 = strtotime($myDate2);

	return ($myDate2 - $myDate1) / (24 * 3600);
}

function selesihHari($tgl1, $tgl2)
{
	$tgl1 = new DateTime($tgl1);
	$tgl2 = new DateTime($tgl2);
	$d = $tgl2->diff($tgl1)->days + 1;
	return $d;
}

# Fungsi untuk membuat format rupiah pada angka (uang)
function format_angka($angka)
{
	$hasil =  number_format($angka, 0, ",", ".");
	return $hasil;
}

function anggaran_bulat($angka)
{
	$hasil =  number_format($angka, 0, ",", "");
	return $hasil;
}

# Fungsi untuk format tanggal, dipakai plugins Callendar
function form_tanggal($nama, $value = '')
{
	echo " <input type='text' name='$nama' id='$nama' size='11' maxlength='20' value='$value'/>&nbsp;
	<img src='images/calendar-add-icon.png' align='top' style='cursor:pointer; margin-top:7px;' alt='kalender'onclick=\"displayCalendar(document.getElementById('$nama'),'dd-mm-yyyy',this)\"/>			
	";
}
function IntervalDays($CheckIn, $CheckOut)
{
	$CheckInX = explode("-", $CheckIn);
	$CheckOutX =  explode("-", $CheckOut);
	$date1 =  mktime(0, 0, 0, $CheckInX[1], $CheckInX[2], $CheckInX[0]);
	$date2 =  mktime(0, 0, 0, $CheckOutX[1], $CheckOutX[2], $CheckOutX[0]);
	$interval = ($date2 - $date1) / (3600 * 24);
	return  $interval;
}

function acakangka($panjang)
{
	$karakter = '1234567890';
	$string = '';
	for ($i = 0; $i < $panjang; $i++) {
		$pos = rand(0, strlen($karakter) - 1);
		$string .= $karakter[$pos];
	}
	return $string;
}
function acakhuruf1($panjang)
{
	$karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$string = '';
	for ($i = 0; $i < $panjang; $i++) {
		$pos = rand(0, strlen($karakter) - 1);
		$string .= $karakter[$pos];
	}
	return $string;
}
function acakhuruf($panjang)
{
	$karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$string = '';
	for ($i = 0; $i < $panjang; $i++) {
		$pos = rand(0, strlen($karakter) - 1);
		$string .= $karakter[$pos];
	}
	return $string;
}
function encrypt($str)
{
	$string1 = "cassie";
	$string2 = "barra";
	$md5_string1 = md5($string1);
	$md5_string2 = md5($string2);
	$text1 = substr($md5_string1, 0, 4);
	$text2 = substr($md5_string2, 0, 4);
	$enc = base64_encode(base64_encode($text1 . $str . $text2));
	return $enc;
}

function decrypt($str)
{
	$dec1 = base64_decode(base64_decode($str));
	$strlen = strlen($dec1);
	$strlenkey = $strlen - 8;
	$pass = substr($dec1, 4, $strlenkey);
	return $pass;
}
function penyebut($nilai)
{
	$nilai = abs($nilai);
	$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	$temp = "";
	if ($nilai < 12) {
		$temp = " " . $huruf[$nilai];
	} else if ($nilai < 20) {
		$temp = penyebut($nilai - 10) . " belas";
	} else if ($nilai < 100) {
		$temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
	} else if ($nilai < 200) {
		$temp = " seratus" . penyebut($nilai - 100);
	} else if ($nilai < 1000) {
		$temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
	} else if ($nilai < 2000) {
		$temp = " seribu" . penyebut($nilai - 1000);
	} else if ($nilai < 1000000) {
		$temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
	} else if ($nilai < 1000000000) {
		$temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
	} else if ($nilai < 1000000000000) {
		$temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
	} else if ($nilai < 1000000000000000) {
		$temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
	}
	return $temp;
}

function terbilang($nilai)
{
	if ($nilai < 0) {
		$hasil = "minus " . trim(penyebut($nilai));
	} else {
		$hasil = trim(penyebut($nilai));
	}
	return $hasil;
}

function filterString($text)
{
	$find = array(" ", ":", "-", "/");
	$text = str_replace($find, "", $text);
	$text = strtoupper($text);
	return $text;
}

function getStatusAbsen($x)
{
	if ($x == 1) {
		$y = '<span class="badge bg-primary">Hadir</span>';
	} elseif ($x == 2) {
		$y = '<span class="badge bg-warning">Sakit</span>';
	} elseif ($x == 3) {
		$y = '<span class="badge bg-info">Ijin</span>';
	} elseif ($x == 4) {
		$y = '<span class="badge bg-danger">Alpha</span>';
	} else {
		$y = '<span class="badge bg-secondary">---</span>';
	}
	return $y;
}

function getStatusAbsen2($x)
{
	if ($x == 1) {
		$y = '&#128504;';
	} elseif ($x == 2) {
		$y = '<strong class="text-primary">S</strong>';
	} elseif ($x == 3) {
		$y = '<strong style="color:#00764b;">I</strong>';
	} elseif ($x == 4) {
		$y = '<strong class="text-danger">A</strong>';
	} else {
		$y = '-';
	}
	return $y;
}

function getStatusAbsenExport($x)
{
	if ($x == 1) {
		$y = 'v';
	} elseif ($x == 2) {
		$y = 'S';
	} elseif ($x == 3) {
		$y = 'I';
	} elseif ($x == 4) {
		$y = 'A';
	} else {
		$y = '-';
	}
	return $y;
}

function arrayHari($bulan, $tahun)
{
	$hari_terakhir = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

	$tgl_awal = '1-' . $bulan . '-' . $tahun;
	$tgl_akhir = $hari_terakhir . '-' . $bulan . '-' . $tahun;

	$tgl_awal = date_create_from_format('d-m-Y', $tgl_awal);
	$tgl_awal = date_format($tgl_awal, 'Y-m-d');
	$tgl_awal = strtotime($tgl_awal);

	$tgl_akhir = date_create_from_format('d-m-Y', $tgl_akhir);
	$tgl_akhir = date_format($tgl_akhir, 'Y-m-d');
	$tgl_akhir = strtotime($tgl_akhir);

	$hariefektif = array();
	$minggu = array();

	for ($i = $tgl_awal; $i <= $tgl_akhir; $i += (60 * 60 * 24)) {
		if (date('w', $i) !== '0' && date('w', $i) !== '7') {
			$hariefektif[] = $i;
		} else {
			$minggu[] = $i;
		}
	}
	$arrayDate = [];
	foreach ($hariefektif as $value) {
		$arrayDate[] = date('d', $value);
	}
	// $array_tgl_efektif = implode('","', $arrayDate);

	return $arrayDate;
}

function bersihkan($string)
{
	$find = array(" ", ":", "-", ".");
	$hasil = str_replace($find, "", $string);
	return $hasil;
}

function bersihkanInsert($string)
{
	$find = array("'", "`");
	$hasil = str_replace($find, " ", $string);
	return $hasil;
}

//pengecekean file pdf
$max_size_pdf    = 1000 * 1000;
$maxsizepdf = 2097152;
$arrayCekEks = [];
$arrayCekSize = [];
$arrayPDF = ["pdf", "PDF", "Pdf"];
$arrayResultEks = [1, 1, 1];
$arrayResultSize = [1, 1, 1];

function cekFile() {}


function hitung_umur($tanggal_lahir)
{
	$birthDate = new DateTime($tanggal_lahir);
	$today = new DateTime("today");
	if ($birthDate > $today) {
		exit("0 tahun 0 bulan 0 hari");
	}
	$y = $today->diff($birthDate)->y;
	$m = $today->diff($birthDate)->m;
	$d = $today->diff($birthDate)->d;
	// return $y . " tahun " . $m . " bulan " . $d . " hari";
	return $y . " tahun";
}



function login($tindak)
{
	$ip = $_SERVER['REMOTE_ADDR'];
	$jam = date('d m Y H: i');
	//$hal=$_SERVER[‘REQUEST_URI’];
	$isi = "[ " . $ip . " ] " . $jam . " - " . $tindak . "\n";
	$_logfilename = "../log/log-" . date("m-Y") . ".txt";
	//// 
	if (!file_exists($_logfilename)) {
		$_logfilehandler = fopen($_logfilename, 'a+');
		@fwrite($_logfilehandler, "# File Logging System By: Animasiku Studio #\n");
		@fopen($_logfilename, 'a+');
		@fwrite($_logfilehandler, $isi);
		@fclose($_logfilehandler);
		@fclose($_logfilehandler);
	} else {
		$_logfilehandler = fopen($_logfilename, 'a+');
		@fopen($_logfilename, 'a+');
		@fwrite($_logfilehandler, $isi);
		@fclose($_logfilehandler);
	};
};

function logout($tindak)
{
	$ip = $_SERVER['REMOTE_ADDR'];
	$jam = date('d m Y H: i');
	//$hal=$_SERVER[‘REQUEST_URI’];
	$isi = "[ " . $ip . " ] " . $jam . " - " . $tindak . "\n";
	$_logfilename = "log/log-" . date("m-Y") . ".txt";
	//// 
	if (!file_exists($_logfilename)) {
		$_logfilehandler = fopen($_logfilename, 'a+');
		@fwrite($_logfilehandler, "# File Logging System By: Animasiku Studio #\n");
		@fopen($_logfilename, 'a+');
		@fwrite($_logfilehandler, $isi);
		@fclose($_logfilehandler);
		@fclose($_logfilehandler);
	} else {
		$_logfilehandler = fopen($_logfilename, 'a+');
		@fopen($_logfilename, 'a+');
		@fwrite($_logfilehandler, $isi);
		@fclose($_logfilehandler);
	};
};

function singkatString($string, $repl, $limit)
{
	if (strlen($string) > $limit) {
		return substr($string, 0, $limit) . $repl;
	} else {
		return $string;
	}
}



function getUrlNow()
{
	return ltrim($_SERVER['REQUEST_URI'], '/');
}
