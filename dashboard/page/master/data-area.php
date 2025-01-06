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
if ($level == 1 || $level == 2) {
?>
  <h4 class="text-secondary" id="data_area">Data Area</h4>
  <div class="row">
    <!-- [ sample-page ] start -->
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <div class="float-right">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addArea"><i data-feather="plus-circle"></i> Tambah</button>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive text-nowrap">
            <table id="team_table" class="table table-bordered table-hover" width="100%">
              <thead>
                <tr>
                  <th class="text-center text-nowrap align-middle" width="2%">No.</th>
                  <th class="text-center text-nowrap align-middle">Nama Area</th>
                  <th class="text-center text-nowrap align-middle" width="10%">Warna</th>
                  <th class="text-center text-nowrap align-middle" width="20%">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                $sqlAkun = mysqli_query($myConnection, "select * from tb_area where soft_delete = 0");
                while ($viewTim = mysqli_fetch_array($sqlAkun)) { ?>
                  <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td>Area <?= $viewTim['nama_area'] ?></td>
                    <td class="text-center">
                      <div style="height: 20px;width: auto;background-color: <?= $viewTim['warna_area'] ?>;"></div>
                    </td>
                    <td class="text-center">
                      <div class="btn-group mb-2 mr-2">
                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menu <span class="sr-only">Toggle Dropdown</span></button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="#!" data-toggle="modal" data-target="#editArea" data-id="<?= encrypt($viewTim['id_area']) ?>"><span class="text-info" data-feather="edit"></span> Edit</a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="#!" data-toggle="modal" data-target="#delArea" data-id="<?= encrypt($viewTim['id_area']) ?>"><span class="text-danger" data-feather="trash-2"></span> Hapus</a>
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

  <div class="modal fade" id="addArea" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleEditModal" aria-hidden="true" aria-modal="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div id="load-add-area" style="display: none;">
          <div class="modal-body">
            <span class="spinner-border spinner-border-sm text-secondary" role="status" aria-hidden="true"></span>
            loading......
          </div>
        </div>
        <div class="add-area" id="add-area"></div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="editArea" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleEditModal" aria-hidden="true" aria-modal="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div id="load-edit-area" style="display: none;">
          <div class="modal-body">
            <span class="spinner-border spinner-border-sm text-secondary" role="status" aria-hidden="true"></span>
            loading......
          </div>
        </div>
        <div class="edit-area" id="edit-area"></div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="delArea" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleDelModal" aria-hidden="true" aria-modal="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div id="load-del-area" style="display: none;">
          <div class="modal-body">
            <span class="spinner-border spinner-border-sm text-secondary" role="status" aria-hidden="true"></span>
            loading......
          </div>
        </div>
        <div class="del-area" id="del-area"></div>
      </div>
    </div>
  </div>
<?php
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
?>