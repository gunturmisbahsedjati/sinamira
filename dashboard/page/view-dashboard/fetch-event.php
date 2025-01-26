<?php
// session_start();
// if (empty($_SESSION['username'])) {
//     echo "URL Not Found";
// } else {

include_once '../../../inc/inc.koneksi.php';

$json = array();
$sqlQuery = "select tb_kegiatan.nama_kegiatan as title,
tb_kegiatan.tgl_awal as start,
tb_kegiatan.tgl_akhir as end,
tb_program.nama_program as nama_program,
tb_area.nama_area as nama_area,
tb_kegiatan.id_area as id_area,
tb_area.warna_area as color,
tb_kegiatan.id_kegiatan as id_kegiatan,
tb_kegiatan.status_kegiatan as status_kegiatan
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
// }
