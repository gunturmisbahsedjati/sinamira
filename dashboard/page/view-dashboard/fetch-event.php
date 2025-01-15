<?php
// require_once "db.php";
// include_once '../vendor/inc.library.php';
// header('Content-Type: application/json');

// // $json = array();
// $sqlQuery = "SELECT ts.id_sub_kegiatan as id_sub,
// ts.status_sub_kegiatan as id_status_sub,
// sk.status as status_sub,
// tk.nama_kegiatan as description,
// ts.metode_kegiatan as metode,
// ts.tempat_keg as tempat,
// ts.volume_peserta as peserta,
// ts.volume_petugas as petugas,
// ts.nama_sub_kegiatan as title,
// ts.tgl_awal as start,
// ts.tgl_akhir as end,
// tse.color as color,
// ts.seksi_sub_kegiatan as kunci,
// tse.nama_seksi as nama_seksi
// FROM tb_sub_kegiatan as ts
// join tb_kegiatan as tk on tk.id_kegiatan = ts.id_kegiatan
// join tb_seksi as tse on tse.id_seksi = ts.seksi_sub_kegiatan
// join status_kegiatan as sk on sk.id = ts.status_sub_kegiatan
// where tk.soft_delete = 0 and ts.soft_delete=0 and tse.soft_delete=0";

// $result = mysqli_query($conn, $sqlQuery);
// $eventArray = [];
// while ($row = mysqli_fetch_array($result)) {
//     array_push($eventArray, $row);
//     // echo $row['description'] . '<br>';
// }

// mysqli_free_result($result);

// mysqli_close($conn);
// // echo json_last_error_msg();
// echo json_encode(utf8ize($eventArray, true));
// // var_dump($eventArray);
include_once '../../../inc/inc.koneksi.php';

$json = array();
$sqlQuery = "select tb_kegiatan.nama_kegiatan as title,
tb_kegiatan.tgl_awal as start,
tb_kegiatan.tgl_akhir as end,
tb_program.nama_program as nama_program,
tb_area.nama_area as nama_area,
tb_area.warna_area as color
from tb_kegiatan 
left join tb_program on tb_kegiatan.id_program = tb_program.id_program
left join tb_area on tb_kegiatan.id_area = tb_area.id_area
where tb_kegiatan.soft_delete = 0";

$result = mysqli_query($myConnection, $sqlQuery);
$eventArray = array();
while ($row = mysqli_fetch_assoc($result)) {
    array_push($eventArray, $row);
}
mysqli_free_result($result);

mysqli_close($myConnection);
echo json_encode($eventArray);
