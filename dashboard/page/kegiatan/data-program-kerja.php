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
                                          where tb_program.soft_delete = 0");
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
                      <button type="button" class="btn btn-primary btn-xs" title="Edit Program" data-toggle="modal" data-target="#editProgram" data-id="<?= encrypt($showProgram['id_program']) ?>"><i data-feather="edit"></i></button>
                      <button type="button" class="btn btn-danger btn-xs" title="Hapus Program" data-toggle="modal" data-target="#delProgram" data-id="<?= encrypt($showProgram['id_program']) ?>"><i data-feather="trash"></i></button>
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

  <div class="modal fade" id="addProgram" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleEditModal" aria-hidden="true" aria-modal="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div id="load-add-program" style="display: none;">
          <div class="modal-body">
            <span class="spinner-border spinner-border-sm text-secondary" role="status" aria-hidden="true"></span>
            loading......
          </div>
        </div>
        <div class="add-program" id="add-program"></div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="editProgram" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleEditModal" aria-hidden="true" aria-modal="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div id="load-edit-program" style="display: none;">
          <div class="modal-body">
            <span class="spinner-border spinner-border-sm text-secondary" role="status" aria-hidden="true"></span>
            loading......
          </div>
        </div>
        <div class="edit-program" id="edit-program"></div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="delProgram" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleDelModal" aria-hidden="true" aria-modal="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div id="load-del-program" style="display: none;">
          <div class="modal-body">
            <span class="spinner-border spinner-border-sm text-secondary" role="status" aria-hidden="true"></span>
            loading......
          </div>
        </div>
        <div class="del-program" id="del-program"></div>
      </div>
    </div>
  </div>
<?php
} elseif (isset($_GET['_token']) && ($level == 3)) {
  $id_area = $_SESSION['akses_tim'];
?>
  <h4 class="text-secondary" id="data_program">Data Program Kerja Tahun <?= decrypt($_GET['_token']) ?></h4>
  <div class="row">
    <!-- [ sample-page ] start -->
    <div class="col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table id="program_table" class="table table-bordered table-hover" width="100%">
              <thead>
                <tr>
                  <th class="text-center align-middle">No.</th>
                  <th class="text-center align-middle">Area</th>
                  <th class="text-center align-middle">Program</th>
                  <th class="text-center align-middle">Jenis</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                $sqlProgram = mysqli_query($myConnection, "select tb_program.*, tb_area.nama_area, tb_area.warna_area, tb_jenis_program.jenis_program
                                          from tb_program
                                          left join tb_area on tb_area.id_area = tb_program.id_area
                                          left join tb_jenis_program on tb_jenis_program.id_jenis_program = tb_program.id_jenis_program
                                          where tb_program.soft_delete = 0");
                while ($showProgram = mysqli_fetch_array($sqlProgram)) {
                ?>
                  <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td>
                      <i data-feather="square" style="fill: <?= $showProgram['warna_area'] ?>;color:transparent"></i> <?= $showProgram['nama_area'] ?>
                    </td>
                    <td style="word-wrap:break-word;white-space:normal"><?= $showProgram['nama_program'] ?></td>
                    <td><?= $showProgram['jenis_program'] ?></td>
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