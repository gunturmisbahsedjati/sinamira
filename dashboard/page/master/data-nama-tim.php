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
              $sqlAkun = mysqli_query($myConnection, "select * from tb_tim where soft_delete =0");
              while ($viewAkun = mysqli_fetch_array($sqlAkun)) { ?>
                <tr>
                  <td class="text-center"><?= $no++ ?></td>
                  <td><?= $viewAkun['nama_tim'] ?></td>
                  <td class="text-center">
                    <div style="height: 20px;width: auto;background-color: <?= $viewAkun['warna_tim'] ?>;"></div>
                  </td>
                  <td class="text-center">
                    <button type="button" class="btn btn-sm btn-icon btn-danger" title="Hapus Akses Pegawai" data-bs-toggle="modal" data-bs-target="#delAccount" data-id="<?= encrypt($viewAkun['id_tim']) ?>">
                      <span class="tf-icons mdi mdi-delete"></span>
                    </button>
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