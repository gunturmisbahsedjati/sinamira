<?php
// include_once '../../../../inc/inc.library.php';
$thn = decrypt($_GET['_token']);
$area = decrypt($_GET['_key']);
$cekArea = mysqli_query($myConnection, "select * from tb_area where id_area = '$area' and soft_delete = 0");
if (mysqli_num_rows($cekArea) > 0 && $akses_area == $area) {
    $viewArea = mysqli_fetch_array($cekArea);
?>
    <div class="row mb-2">
        <div class="col-6">
            <h4 class="" id="data_capaian_kinerja_detail_program">
                Capaian Program Kerja Area <span class="font-weight-bolder" style="color:<?= $viewArea['warna_area'] ?>"><?= $viewArea['nama_area'] ?></span> Tahun <?= $thn ?>
            </h4>
        </div>
        <div class="col-6">

        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="instrument_table" class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center align-middle" rowspan="2">No.</th>
                            <th class="text-center align-middle" rowspan="2">Program</th>
                            <th class="text-center align-middle" colspan="2">Kegiatan</th>
                            <th class="text-center align-middle" rowspan="2">Uraian</th>
                            <th class="text-center align-middle" rowspan="2">Hambatan</th>
                            <th class="text-center align-middle" rowspan="2">Langkah<br>Antisipasi</th>
                        </tr>
                        <tr>
                            <th class="text-center align-middle">Target</th>
                            <th class="text-center align-middle">Capaian</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $sqlProgram = mysqli_query($myConnection, "select tb_program.*, tb_area.nama_area, tb_area.warna_area, tb_jenis_program.jenis_program
                                          from tb_program
                                          left join tb_area on tb_area.id_area = tb_program.id_area
                                          left join tb_jenis_program on tb_jenis_program.id_jenis_program = tb_program.id_jenis_program
                                          where tb_program.soft_delete = 0 and tb_program.id_area = '$area' and tb_program.thn_program = '$thn'");
                        while ($showProgram = mysqli_fetch_array($sqlProgram)) {
                            $id_program = $showProgram['id_program'];
                            $sqlJmlArea = mysqli_query($myConnection, "select tb_area.*,
                                (select count(id_program) from tb_program where id_area = tb_area.id_area and soft_delete = 0 and id_program = '$id_program') as jml_program,
                                (select count(id_kegiatan) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and id_program = '$id_program') as jml_kegiatan,
                                (select count(id_kegiatan) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and status_kegiatan = 0 and id_program = '$id_program') as jml_belum,
                                (select count(id_kegiatan) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and status_kegiatan = 1 and id_program = '$id_program') as jml_sudah,
                                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_surat_undangan is not null and file_surat_undangan != 0 and file_surat_undangan != '') and id_program = '$id_program') as jml_sudah_upload_file_surat_undangan,
                                (select count(file_surat_undangan) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_surat_undangan = 0 and file_surat_undangan != '') and id_program = '$id_program') as jml_non_upload_file_surat_undangan,
                                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and id_program = '$id_program') as jml_semua_file_surat_undangan,
                                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_sk_kegiatan is not null and file_sk_kegiatan != 0 and file_sk_kegiatan != '') and id_program = '$id_program') as jml_sudah_upload_file_sk_kegiatan,
                                (select count(file_sk_kegiatan) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_sk_kegiatan = 0 and file_sk_kegiatan != '') and id_program = '$id_program') as jml_non_upload_file_sk_kegiatan,
                                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and id_program = '$id_program') as jml_semua_file_sk_kegiatan,
                                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_panduan is not null and file_panduan != 0 and file_panduan != '') and id_program = '$id_program') as jml_sudah_upload_file_panduan,
                                (select count(file_panduan) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_panduan = 0 and file_panduan != '') and id_program = '$id_program') as jml_non_upload_file_panduan,
                                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and id_program = '$id_program') as jml_semua_file_panduan,
                                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_surat_tugas is not null and file_surat_tugas != 0 and file_surat_tugas != '') and id_program = '$id_program') as jml_sudah_upload_file_surat_tugas,
                                (select count(file_surat_tugas) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_surat_tugas = 0 and file_surat_tugas != '') and id_program = '$id_program') as jml_non_upload_file_surat_tugas,
                                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and id_program = '$id_program') as jml_semua_file_surat_tugas,
                                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_daftar_hadir is not null and file_daftar_hadir != 0 and file_daftar_hadir != '') and id_program = '$id_program') as jml_sudah_upload_file_daftar_hadir,
                                (select count(file_daftar_hadir) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_daftar_hadir = 0 and file_daftar_hadir != '') and id_program = '$id_program') as jml_non_upload_file_daftar_hadir,
                                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and id_program = '$id_program') as jml_semua_file_daftar_hadir,
                                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_notula is not null and file_notula != 0 and file_notula != '') and id_program = '$id_program') as jml_sudah_upload_file_notula,
                                (select count(file_notula) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_notula = 0 and file_notula != '') and id_program = '$id_program') as jml_non_upload_file_notula,
                                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and id_program = '$id_program') as jml_semua_file_notula,
                                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_hasil_kegiatan is not null and file_hasil_kegiatan != 0 and file_hasil_kegiatan != '') and id_program = '$id_program') as jml_sudah_upload_file_hasil_kegiatan,
                                (select count(file_hasil_kegiatan) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_hasil_kegiatan = 0 and file_hasil_kegiatan != '') and id_program = '$id_program') as jml_non_upload_file_hasil_kegiatan,
                                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and id_program = '$id_program') as jml_semua_file_hasil_kegiatan,
                                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_dokumentasi is not null and file_dokumentasi != 0 and file_dokumentasi != '') and id_program = '$id_program') as jml_sudah_upload_file_dokumentasi,
                                (select count(file_dokumentasi) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_dokumentasi = 0 and file_dokumentasi != '') and id_program = '$id_program') as jml_non_upload_file_dokumentasi,
                                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and id_program = '$id_program') as jml_semua_file_dokumentasi
                                from tb_area
                                where tb_area.soft_delete = 0 ");
                            $jmlKegiatan = 0;
                            $jmlSudah = 0;
                            $keselesaian = 0;
                            $jmlKeselesaian = 0;
                            while ($cekJml = mysqli_fetch_array($sqlJmlArea)) {
                                $jmlKegiatan += $cekJml['jml_kegiatan'];
                                $jmlSudah += $cekJml['jml_sudah'];
                                $jml_file_yang_harus_upload = $cekJml['jml_semua_file_surat_undangan'] + $cekJml['jml_semua_file_sk_kegiatan'] + $cekJml['jml_semua_file_panduan'] + $cekJml['jml_semua_file_surat_tugas'] + $cekJml['jml_semua_file_daftar_hadir'] + $cekJml['jml_semua_file_notula'] + $cekJml['jml_semua_file_hasil_kegiatan'] + $cekJml['jml_semua_file_dokumentasi'];
                                $jml_file_yang_sudah_upload = $cekJml['jml_sudah_upload_file_surat_undangan'] + $cekJml['jml_sudah_upload_file_sk_kegiatan'] + $cekJml['jml_sudah_upload_file_panduan'] + $cekJml['jml_sudah_upload_file_surat_tugas'] + $cekJml['jml_sudah_upload_file_daftar_hadir'] + $cekJml['jml_sudah_upload_file_notula'] + $cekJml['jml_sudah_upload_file_hasil_kegiatan'] + $cekJml['jml_sudah_upload_file_dokumentasi'];
                                $jml_file_yang_non_upload = $cekJml['jml_non_upload_file_surat_undangan'] + $cekJml['jml_non_upload_file_sk_kegiatan'] + $cekJml['jml_non_upload_file_panduan'] + $cekJml['jml_non_upload_file_surat_tugas'] + $cekJml['jml_non_upload_file_daftar_hadir'] + $cekJml['jml_non_upload_file_notula'] + $cekJml['jml_non_upload_file_hasil_kegiatan'] + $cekJml['jml_non_upload_file_dokumentasi'];
                                $keselesaian += $jml_file_yang_sudah_upload == 0 ? 0 : round(($jml_file_yang_sudah_upload / ($jml_file_yang_harus_upload - $jml_file_yang_non_upload)) * 100, 1);
                            }
                        ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td style="word-wrap:break-word;white-space:normal">
                                    <?= $showProgram['nama_program'] . '<br>Jenis : ' . $showProgram['jenis_program'] ?><br>
                                    <button type="button" class="btn btn-primary btn-sm" title="Klik untuk mengisi capaian" data-toggle="modal" data-target="#addInstrumentTeam" data-id="<?= encrypt($showProgram['id_program']) ?>"><i data-feather="search"></i> Capaian</button>
                                </td>
                                <td class="text-center"><?= $jmlKegiatan ?></td>
                                <td class="">
                                    <?php
                                    echo 'Terlaksana : ' . $jmlSudah . '<br>';
                                    echo 'Unggahan : <label class="form-label">' . $keselesaian . ' %</label><div class="progress border border-secondary"><div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="' . $keselesaian . '" aria-valuemin="0" aria-valuemax="100" style="width:' . $keselesaian . '%; background-color:' . $showProgram['warna_area'] . ' !important;"></div></div>';
                                    ?>
                                </td>
                                <td><?= nl2br($showProgram['uraian']) ?></td>
                                <td><?= nl2br($showProgram['hambatan']) ?></td>
                                <td><?= nl2br($showProgram['langkah_antisipasi']) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <small class="font-weight-bold text-danger">Kolom Capaian Kegiatan dihitung otomatis berdasarkan dengan kegiatan yang sudah terlaksana dan sudah unggah dokumen kegiatan</small>
            </div>
        </div>
    </div>
<?php
    include 'common-modal-capaian.php';
} else {
    echo '<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card border border-primary col-6">
      <div class="card-body">
        <h2>Nyari apa.... 🤣</h2>
        <p>Error 404<br>Object not found!<br>The requested URL was not found on this server.</p>
      </div>
    </div>
  </div>';
}
//    
// } else {
//     echo '<div class="container-xxl flex-grow-1 container-p-y">
// <div class="card border border-primary col-6">
// <div class="card-body">
//   <h2>Nyari apa.... 🤣</h2>
//   <p>Error 404<br>Object not found!<br>The requested URL was not found on this server.</p>
// </div>
// </div>
// </div>';
// }

?>