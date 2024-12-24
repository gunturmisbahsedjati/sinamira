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
<h4 class="text-secondary" id="data_tim">Data Tim</h4>
<div class="row">
  <!-- [ sample-page ] start -->
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="float-right">
          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addTeam"><i data-feather="plus-circle"></i> Tambah</button>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive text-nowrap">
          <table id="team_table" class="table table-bordered table-hover" width="100%">
            <thead>
              <tr>
                <th class="text-center text-nowrap align-middle" width="2%">No.</th>
                <th class="text-center text-nowrap align-middle">Nama Tim</th>
                <th class="text-center text-nowrap align-middle" width="10%">Warna</th>
                <th class="text-center text-nowrap align-middle" width="20%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              $sqlAkun = mysqli_query($myConnection, "select * from tb_tim where soft_delete = 0");
              while ($viewTim = mysqli_fetch_array($sqlAkun)) { ?>
                <tr>
                  <td class="text-center"><?= $no++ ?></td>
                  <td><?= $viewTim['nama_tim'] ?></td>
                  <td class="text-center">
                    <div style="height: 20px;width: auto;background-color: <?= $viewTim['warna_tim'] ?>;"></div>
                  </td>
                  <td class="text-center">
                    <div class="btn-group mb-2 mr-2">
                      <button type="button" class="btn btn-sm btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menu <span class="sr-only">Toggle Dropdown</span></button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="#!" data-toggle="modal" data-target="#editTeam" data-id="<?= encrypt($viewTim['id_tim']) ?>"><span class="text-info" data-feather="edit"></span> Edit</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#!" data-toggle="modal" data-target="#delTeam" data-id="<?= encrypt($viewTim['id_tim']) ?>"><span class="text-danger" data-feather="trash-2"></span> Hapus</a>
                      </div>
                    </div>
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

<div class="modal fade" id="addTeam" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleEditModal" aria-hidden="true" aria-modal="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div id="load-add-team" style="display: none;">
        <div class="modal-body">
          <span class="spinner-border spinner-border-sm text-secondary" role="status" aria-hidden="true"></span>
          loading......
        </div>
      </div>
      <div class="add-team" id="add-team"></div>
    </div>
  </div>
</div>
<div class="modal fade" id="editTeam" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleEditModal" aria-hidden="true" aria-modal="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div id="load-edit-team" style="display: none;">
        <div class="modal-body">
          <span class="spinner-border spinner-border-sm text-secondary" role="status" aria-hidden="true"></span>
          loading......
        </div>
      </div>
      <div class="edit-team" id="edit-team"></div>
    </div>
  </div>
</div>
<div class="modal fade" id="delTeam" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleDelModal" aria-hidden="true" aria-modal="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div id="load-del-team" style="display: none;">
        <div class="modal-body">
          <span class="spinner-border spinner-border-sm text-secondary" role="status" aria-hidden="true"></span>
          loading......
        </div>
      </div>
      <div class="del-team" id="del-team"></div>
    </div>
  </div>
</div>