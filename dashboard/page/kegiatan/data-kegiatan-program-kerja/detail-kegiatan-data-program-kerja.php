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
if (isset($_GET['_token']) && isset($_GET['_key']) && ($level == 1 || $level == 2)) {
  $thn = decrypt($_GET['_token']);
  $area = decrypt($_GET['_key']);
  $cekArea = mysqli_query($myConnection, "select * from tb_area where id_area = '$area' and soft_delete = 0");
  if (mysqli_num_rows($cekArea) > 0) {
    $viewArea = mysqli_fetch_array($cekArea);
    echo '<div class="row mb-2">
    <div class="col-6"><h4 class="" id="data_detail_program">
    Program Kerja Area <span class="font-weight-bolder" style="color:' . $viewArea['warna_area'] . '">' . $viewArea['nama_area'] . '</span> Tahun ' . decrypt($_GET['_token']) . '
    </h4>
    </div>
    <div class="col-6">
    <div class="float-right">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addDetailActivity" data-token="' . encrypt($area) . '" data-key="' . encrypt($thn) . '"><i data-feather="plus-circle"></i> Tambah Kegiatan</button>
          </div>
          </div>
          </div>
    ';

    //tampil program
    $sqlProgramArea = mysqli_query($myConnection, "select tb_program.*, tb_jenis_program.jenis_program
                                          from tb_program
                                          left join tb_jenis_program on tb_jenis_program.id_jenis_program = tb_program.id_jenis_program
                                          where tb_program.soft_delete = 0 and tb_program.id_area = '$area'");
    while ($showProgramArea = mysqli_fetch_array($sqlProgramArea)) {
      $id_program = $showProgramArea['id_program'];
      $id_area = $showProgramArea['id_area'];
?>
      <div class="card">
        <div class="card-body">
          <label class="form-label"><?= '<span class="font-weight-bold">' . $showProgramArea['nama_program'] . '</span><br> Jenis Program : ' . $showProgramArea['jenis_program'] ?></label>
          <div class="table-responsive">
            <table id="" class="table table-bordered table-hover" width="100%">
              <thead>
                <tr>
                  <th class="text-center align-middle" rowspan="8">No.</th>
                  <th class="text-center align-middle" rowspan="8">Pelaksanaan</th>
                  <th class="text-center align-middle" rowspan="8">Nama Kegiatan</th>
                  <th class="text-center align-middle" colspan="8">Dokumen Kegiatan</th>
                  <th class="text-center align-middle" rowspan="8">Aksi</th>
                </tr>
                <tr>
                  <th class="text-center align-middle">Surat<br>Undangan</th>
                  <th class="text-center align-middle">SK<br>Kegiatan</th>
                  <th class="text-center align-middle">Panduan</th>
                  <th class="text-center align-middle">Surat<br>Tugas</th>
                  <th class="text-center align-middle">Daftar<br>Hadir</th>
                  <th class="text-center align-middle">Notula</th>
                  <th class="text-center align-middle">Hasil<br>Kegiatan</th>
                  <th class="text-center align-middle">Dokumentasi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $cekKegiatan = mysqli_query($myConnection, "select * from tb_kegiatan where id_program = '$id_program' and id_area = '$id_area' and soft_delete = 0");
                if (mysqli_num_rows($cekKegiatan) > 0) {
                  $no = 1;
                  while ($showKegiatan = mysqli_fetch_array($cekKegiatan)) {
                    $tgl_awal = Indonesia2Tgl(substr($showKegiatan['tgl_awal'], 0, 10));
                    $tgl_akhir = Indonesia2Tgl(substr($showKegiatan['tgl_akhir'], 0, 10));
                ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td class="text-center"><?= $tgl_awal . '<br>s/d<br>' . $tgl_akhir ?></td>
                      <td><?= $showKegiatan['nama_kegiatan'] ?></td>
                      <td>1</td>
                      <td>2</td>
                      <td>3</td>
                      <td>4</td>
                      <td>5</td>
                      <td>6</td>
                      <td>7</td>
                      <td>8</td>
                      <td></td>
                    </tr>
                <?php
                  }
                } else {
                  echo '
                  <tr>
                  <th class="text-center align-middle bg-secondary text-white" colspan="12">Belum Ada Data Kegiatan</th>
                </tr>
                  ';
                }

                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
  <?php
    }
    include 'common-modal-kegiatan.php';
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
} elseif (isset($_GET['_token']) && ($level == 3)) {
  $id_area = $_SESSION['akses_tim'];
  ?>
  <h4 class="text-secondary" id="data_program">Data Program Kerja Tahun <?= decrypt($_GET['_token']) ?></h4>
  <div class="row">
    <!-- [ sample-page ] start -->

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