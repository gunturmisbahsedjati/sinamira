<?php
$time_start = microtime(true);
require_once './inc/inc.koneksi.php';
require_once './inc/inc.library.php';
if (empty($_SESSION['username'])) {
  header('location:../../../');
} else {
  $username = $_SESSION['username'];
  $id = $_SESSION['id'];
  $level = $_SESSION['level'];
  $arrayAkses = explode(",", $_SESSION['level']);
}
if (!isset($_SESSION['status_login'])) {
  echo '<script type="text/javascript">
    window.location = "./"
    </script>';
  exit;
}
if (isset($_SESSION['alert'])) : ?>
  <script>
    let Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true
    })
    <?php
    echo $_SESSION['alert'];
    unset($_SESSION['alert']);
    ?>
  </script>
<?php endif ?>
<?php
if (isset($_GET['_token']) && ($level == 1 || $level == 2)) {
  $thn = decrypt($_GET['_token']);
?>
  <h4 class="text-secondary" id="data_kegiatan">Data Kegiatan Program Kerja Tahun <?= decrypt($_GET['_token']) ?></h4>
  <div class="row">
    <!-- [ sample-page ] start -->
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="activity_table" class="table table-bordered table-hover" width="100%">
              <thead>
                <tr>
                  <th class="text-center align-middle" rowspan="2">No.</th>
                  <th class="text-center align-middle" rowspan="2">Area<br>Pelaksana</th>
                  <th class="text-center align-middle" colspan="2">Jumlah</th>
                  <th class="text-center align-middle" colspan="3">Progress Kegiatan</th>
                  <th class="text-center align-middle" rowspan="2">Aksi</th>
                </tr>
                <tr>
                  <th class="text-center align-middle">Program<br>Kerja</th>
                  <th class="text-center align-middle">Kegiatan</th>
                  <th class="text-center align-middle">Belum<br>Terlaksana</th>
                  <th class="text-center align-middle">Sudah<br>Terlaksana</th>
                  <th class="text-center align-middle">Unggah<br>Dokumen</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                $sqlArea = mysqli_query($myConnection, "select tb_area.*,
                (select count(id_program) from tb_program where id_area = tb_area.id_area and soft_delete = 0 and thn_program = '$thn') as jml_program,
                (select count(id_kegiatan) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and thn_kegiatan = '$thn') as jml_kegiatan,
                (select count(id_kegiatan) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and status_kegiatan = 0 and thn_kegiatan = '$thn') as jml_belum,
                (select count(id_kegiatan) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and status_kegiatan = 1 and thn_kegiatan = '$thn') as jml_sudah,
                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_surat_undangan is not null and file_surat_undangan != 0 and file_surat_undangan != '') and thn_kegiatan = '$thn') as jml_sudah_upload_file_surat_undangan,
                (select count(file_surat_undangan) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_surat_undangan = 0 and file_surat_undangan != '') and thn_kegiatan = '$thn') as jml_non_upload_file_surat_undangan,
                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and thn_kegiatan = '$thn') as jml_semua_file_surat_undangan,
                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_sk_kegiatan is not null and file_sk_kegiatan != 0 and file_sk_kegiatan != '') and thn_kegiatan = '$thn') as jml_sudah_upload_file_sk_kegiatan,
                (select count(file_sk_kegiatan) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_sk_kegiatan = 0 and file_sk_kegiatan != '') and thn_kegiatan = '$thn') as jml_non_upload_file_sk_kegiatan,
                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and thn_kegiatan = '$thn') as jml_semua_file_sk_kegiatan,
                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_panduan is not null and file_panduan != 0 and file_panduan != '') and thn_kegiatan = '$thn') as jml_sudah_upload_file_panduan,
                (select count(file_panduan) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_panduan = 0 and file_panduan != '') and thn_kegiatan = '$thn') as jml_non_upload_file_panduan,
                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and thn_kegiatan = '$thn') as jml_semua_file_panduan,
                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_surat_tugas is not null and file_surat_tugas != 0 and file_surat_tugas != '') and thn_kegiatan = '$thn') as jml_sudah_upload_file_surat_tugas,
                (select count(file_surat_tugas) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_surat_tugas = 0 and file_surat_tugas != '') and thn_kegiatan = '$thn') as jml_non_upload_file_surat_tugas,
                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and thn_kegiatan = '$thn') as jml_semua_file_surat_tugas,
                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_daftar_hadir is not null and file_daftar_hadir != 0 and file_daftar_hadir != '') and thn_kegiatan = '$thn') as jml_sudah_upload_file_daftar_hadir,
                (select count(file_daftar_hadir) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_daftar_hadir = 0 and file_daftar_hadir != '') and thn_kegiatan = '$thn') as jml_non_upload_file_daftar_hadir,
                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and thn_kegiatan = '$thn') as jml_semua_file_daftar_hadir,
                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_notula is not null and file_notula != 0 and file_notula != '') and thn_kegiatan = '$thn') as jml_sudah_upload_file_notula,
                (select count(file_notula) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_notula = 0 and file_notula != '') and thn_kegiatan = '$thn') as jml_non_upload_file_notula,
                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and thn_kegiatan = '$thn') as jml_semua_file_notula,
                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_hasil_kegiatan is not null and file_hasil_kegiatan != 0 and file_hasil_kegiatan != '') and thn_kegiatan = '$thn') as jml_sudah_upload_file_hasil_kegiatan,
                (select count(file_hasil_kegiatan) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_hasil_kegiatan = 0 and file_hasil_kegiatan != '') and thn_kegiatan = '$thn') as jml_non_upload_file_hasil_kegiatan,
                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and thn_kegiatan = '$thn') as jml_semua_file_hasil_kegiatan,
                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_dokumentasi is not null and file_dokumentasi != 0 and file_dokumentasi != '') and thn_kegiatan = '$thn') as jml_sudah_upload_file_dokumentasi,
                (select count(file_dokumentasi) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and (file_dokumentasi = 0 and file_dokumentasi != '') and thn_kegiatan = '$thn') as jml_non_upload_file_dokumentasi,
                (select count(*) from tb_kegiatan where id_area = tb_area.id_area and soft_delete = 0 and thn_kegiatan = '$thn') as jml_semua_file_dokumentasi
                from tb_area
                where tb_area.soft_delete = 0 ");
                while ($viewArea = mysqli_fetch_array($sqlArea)) {
                  $jml_file_yang_harus_upload = $viewArea['jml_semua_file_surat_undangan'] + $viewArea['jml_semua_file_sk_kegiatan'] + $viewArea['jml_semua_file_panduan'] + $viewArea['jml_semua_file_surat_tugas'] + $viewArea['jml_semua_file_daftar_hadir'] + $viewArea['jml_semua_file_notula'] + $viewArea['jml_semua_file_hasil_kegiatan'] + $viewArea['jml_semua_file_dokumentasi'];
                  $jml_file_yang_sudah_upload = $viewArea['jml_sudah_upload_file_surat_undangan'] + $viewArea['jml_sudah_upload_file_sk_kegiatan'] + $viewArea['jml_sudah_upload_file_panduan'] + $viewArea['jml_sudah_upload_file_surat_tugas'] + $viewArea['jml_sudah_upload_file_daftar_hadir'] + $viewArea['jml_sudah_upload_file_notula'] + $viewArea['jml_sudah_upload_file_hasil_kegiatan'] + $viewArea['jml_sudah_upload_file_dokumentasi'];
                  $jml_file_yang_non_upload = $viewArea['jml_non_upload_file_surat_undangan'] + $viewArea['jml_non_upload_file_sk_kegiatan'] + $viewArea['jml_non_upload_file_panduan'] + $viewArea['jml_non_upload_file_surat_tugas'] + $viewArea['jml_non_upload_file_daftar_hadir'] + $viewArea['jml_non_upload_file_notula'] + $viewArea['jml_non_upload_file_hasil_kegiatan'] + $viewArea['jml_non_upload_file_dokumentasi'];
                  $jml_keselesaian = $jml_file_yang_sudah_upload == 0 ? 0 : round(($jml_file_yang_sudah_upload / ($jml_file_yang_harus_upload - $jml_file_yang_non_upload)) * 100, 1);
                ?>
                  <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td>
                      <i data-feather="square" style="fill: <?= $viewArea['warna_area'] ?>;color:transparent"></i> <?= $viewArea['nama_area'] ?>
                    </td>
                    <td class="text-center"><?= $viewArea['jml_program'] ?></td>
                    <td class="text-center"><?= $viewArea['jml_kegiatan'] ?></td>
                    <td class="text-center"><?= $viewArea['jml_belum'] ?></td>
                    <td class="text-center"><?= $viewArea['jml_sudah'] ?></td>
                    <td class="text-center">
                      <label class="form-label"><?= $jml_keselesaian ?> %</label>
                      <div class="progress border border-secondary">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="<?= $jml_keselesaian ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $jml_keselesaian ?>%; background-color:<?= $viewArea['warna_area'] ?> !important;"></div>
                      </div>
                    </td>
                    <td class="text-center text-nowarp">
                      <a href="detailActivityList?_token=<?= $_GET['_token'] ?>&_key=<?= encrypt($viewArea['id_area']) ?>" class="btn btn-primary btn-xs" title="cek program area"><i data-feather="search"></i></a>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
            <?= "Process took " . number_format(microtime(true) - $time_start, 2) . " seconds."; ?>
          </div>
        </div>
      </div>
    </div>
    <!-- [ sample-page ] end -->
  </div>
<?php
} elseif (isset($_GET['_token']) && ($level == 3)) {
  $id_area = $_SESSION['akses_tim'];
  $thn = decrypt($_GET['_token']);
?>
  <h4 class="text-secondary" id="data_program">Data Program Kerja Tahun <?= decrypt($_GET['_token']) ?></h4>
  <div class="row">
    <!-- [ sample-page ] start -->
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <div class="float-right">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addProgram" data-token="<?= $_GET['_token'] ?>"><i data-feather="plus-circle"></i> Tambah</button>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="program_table" class="table table-bordered table-hover" width="100%">
              <thead>
                <tr>
                  <th class="text-center align-middle">No.</th>
                  <th class="text-center align-middle">Area</th>
                  <th class="text-center align-middle">Program</th>
                  <th class="text-center align-middle">Jenis</th>
                  <th class="text-center align-middle">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                $sqlProgram = mysqli_query($myConnection, "select tb_program.*, tb_area.nama_area, tb_area.warna_area, tb_jenis_program.jenis_program
                                          from tb_program
                                          left join tb_area on tb_area.id_area = tb_program.id_area
                                          left join tb_jenis_program on tb_jenis_program.id_jenis_program = tb_program.id_jenis_program
                                          where tb_program.soft_delete = 0 and tb_program.id_area = '$id_area' and tb_program.thn_program = '$thn'");
                while ($showProgram = mysqli_fetch_array($sqlProgram)) {
                ?>
                  <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td>
                      <i data-feather="square" style="fill: <?= $showProgram['warna_area'] ?>;color:transparent"></i> <?= $showProgram['nama_area'] ?>
                    </td>
                    <td style="word-wrap:break-word;white-space:normal"><?= $showProgram['nama_program'] ?></td>
                    <td><?= $showProgram['jenis_program'] ?></td>
                    <td class="text-center text-nowarp">
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
            <?= "Process took " . number_format(microtime(true) - $time_start, 2) . " seconds."; ?>
          </div>
        </div>
      </div>
    </div>
    <!-- [ sample-page ] end -->
  </div>
<?php } else {
  echo '<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card border border-primary col-6">
      <div class="card-body">
        <h2>Nyari apa.... 🤣</h2>
        <p>Error 404<br>Object not found!<br>The requested URL was not found on this server.</p>
      </div>
    </div>
  </div>';
}
?>