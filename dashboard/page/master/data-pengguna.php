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
  <h4 class="text-secondary" id="data_akun_manajemen">Data Pengguna</h4>
  <div class="row">
    <!-- [ sample-page ] start -->
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <div class="float-right">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addAccount"><i data-feather="plus-circle"></i> Tambah</button>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive text-nowrap">
            <table id="account_table" class="table table-bordered table-hover" width="100%">
              <thead>
                <tr>
                  <th class="text-center text-nowrap align-middle">No.</th>
                  <th class="text-center text-nowrap align-middle">Username</th>
                  <th class="text-center text-nowrap align-middle">Nama</th>
                  <th class="text-center text-nowrap align-middle">Akses</th>
                  <th class="text-center text-nowrap align-middle">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                $sqlAkun = mysqli_query($myConnection, "select akun_manajemen.*, db_level_akun.ket
              from akun_manajemen
              left join db_level_akun on db_level_akun.id_level_akun = akun_manajemen.level_manajemen
              where akun_manajemen.soft_delete = 0
              and akun_manajemen.id_manajemen not in ('36daf4c0c9652712fd970ebacbe082fc')");
                // if (mysqli_num_rows($sqlAkun) >= 0) {
                //   echo '<tr><td class="text-center font-weight-bold" colspan="5">Belum ada data</td></tr>';
                // } else {
                while ($viewAkun = mysqli_fetch_array($sqlAkun)) { ?>
                  <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= $viewAkun['user_manajemen'] ?></td>
                    <td><?= $viewAkun['nama_manajemen'] ?></td>
                    <td><?php
                        if ($viewAkun['level_manajemen'] == 3) {
                          $akses = $viewAkun['area_manajemen'];
                          $showAkses = mysqli_fetch_array(mysqli_query($myConnection, "select nama_area from tb_area where id_area = '$akses' and soft_delete = 0"));
                          echo $viewAkun['ket'] . '<br>Area ' . $showAkses['nama_area'];
                        } else {
                          echo $viewAkun['ket'];
                        }
                        ?></td>
                    <td class="text-center">
                      <button type="button" class="btn btn-sm btn-icon btn-danger" title="Hapus Akses Pegawai" data-toggle="modal" data-target="#delAccount" data-id="<?= encrypt($viewAkun['id_manajemen']) ?>">
                        <span class="" data-feather="trash-2"></span>
                      </button>
                    </td>
                  </tr>
                <?php
                  //}
                } ?>
              </tbody>
            </table>
            <?= "Process took " . number_format(microtime(true) - $time_start, 2) . " seconds."; ?>
          </div>
        </div>
      </div>
    </div>
    <!-- [ sample-page ] end -->
  </div>

  <div class="modal fade" id="addAccount" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleEditModal" aria-modal="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div id="load-add-account" style="display: none;">
          <div class="modal-body">
            <span class="spinner-border spinner-border-sm text-secondary" role="status" aria-hidden="true"></span>
            loading......
          </div>
        </div>
        <div class="add-account" id="add-account"></div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="delAccount" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleEditModal" aria-modal="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div id="load-del-account" style="display: none;">
          <div class="modal-body">
            <span class="spinner-border spinner-border-sm text-secondary" role="status" aria-hidden="true"></span>
            loading......
          </div>
        </div>
        <div class="del-account" id="del-account"></div>
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