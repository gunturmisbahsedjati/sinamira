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
                $cekKegiatan = mysqli_query($myConnection, "select tb_kegiatan.*, tb_status_kegiatan.deskripsi, tb_status_kegiatan.warna 
                from tb_kegiatan 
                left join tb_status_kegiatan on tb_status_kegiatan.status = tb_kegiatan.status_kegiatan
                where tb_kegiatan.id_program = '$id_program' and tb_kegiatan.id_area = '$id_area' and tb_kegiatan.soft_delete = 0
                order by tb_kegiatan.tgl_awal, tb_kegiatan.tgl_akhir asc");
                if (mysqli_num_rows($cekKegiatan) > 0) {
                  $no = 1;
                  while ($showKegiatan = mysqli_fetch_array($cekKegiatan)) {
                    $tgl_awal = Indonesia2Tgl(substr($showKegiatan['tgl_awal'], 0, 10));
                    $tgl_akhir = Indonesia2Tgl(substr($showKegiatan['tgl_akhir'], 0, 10));

                    if ($showKegiatan['file_surat_undangan'] == NULL || $showKegiatan['file_surat_undangan'] == '') {
                      $isiSU = '<span class="font-weight-bold text-danger">X</span>';
                      $bgSU = '';
                    } elseif ($showKegiatan['file_surat_undangan'] == '0') {
                      $isiSU = '<span class="font-weight-bold text-primary">&mdash;</span>';
                      $bgSU = 'bg-secondary2';
                    } elseif ($showKegiatan['file_surat_undangan'] != NULL || $showKegiatan['file_surat_undangan'] != '' || $showKegiatan['file_surat_undangan'] != '0') {
                      $isiSU = '
                     <button type="button" class="btn btn-primary btn-xs" title="Edit Program" data-toggle="modal" data-target="#editProgram" data-id="' . encrypt($showProgram['id_program']) . '"><i data-feather="edit"></i></button>
                     <button type="button" class="btn btn-danger btn-xs" title="Hapus Program" data-toggle="modal" data-target="#delProgram" data-id="' . encrypt($showProgram['id_program']) . '"><i data-feather="trash"></i></button>';
                      $bgSU = '';
                    } else {
                      $isiSU = '';
                      $bgSU = '';
                    }

                    if ($showKegiatan['file_sk_kegiatan'] == NULL || $showKegiatan['file_sk_kegiatan'] == '') {
                      $isiSK = '<span class="font-weight-bold text-danger">X</span>';
                      $bgSK = '';
                    } elseif ($showKegiatan['file_sk_kegiatan'] == '0') {
                      $isiSK = '<span class="font-weight-bold text-primary">&mdash;</span>';
                      $bgSK = 'bg-secondary2';
                    } elseif ($showKegiatan['file_sk_kegiatan'] != NULL || $showKegiatan['file_sk_kegiatan'] != '' || $showKegiatan['file_sk_kegiatan'] != '0') {
                      $isiSK = '
                     <button type="button" class="btn btn-primary btn-xs" title="Edit Program" data-toggle="modal" data-target="#editProgram" data-id="' . encrypt($showProgram['id_program']) . '"><i data-feather="edit"></i></button>
                     <button type="button" class="btn btn-danger btn-xs" title="Hapus Program" data-toggle="modal" data-target="#delProgram" data-id="' . encrypt($showProgram['id_program']) . '"><i data-feather="trash"></i></button>';
                      $bgSK = '';
                    } else {
                      $isiSK = '';
                      $bgSK = '';
                    }

                    if ($showKegiatan['file_panduan'] == NULL || $showKegiatan['file_panduan'] == '') {
                      $isiPanduan = '<span class="font-weight-bold text-danger">X</span>';
                      $bgPanduan = '';
                    } elseif ($showKegiatan['file_panduan'] == '0') {
                      $isiPanduan = '<span class="font-weight-bold text-primary">&mdash;</span>';
                      $bgPanduan = 'bg-secondary2';
                    } elseif ($showKegiatan['file_panduan'] != NULL || $showKegiatan['file_panduan'] != '' || $showKegiatan['file_panduan'] != '0') {
                      $isiPanduan = '
                     <button type="button" class="btn btn-primary btn-xs" title="Edit Program" data-toggle="modal" data-target="#editProgram" data-id="' . encrypt($showProgram['id_program']) . '"><i data-feather="edit"></i></button>
                     <button type="button" class="btn btn-danger btn-xs" title="Hapus Program" data-toggle="modal" data-target="#delProgram" data-id="' . encrypt($showProgram['id_program']) . '"><i data-feather="trash"></i></button>';
                      $bgPanduan = '';
                    } else {
                      $isiPanduan = '';
                      $bgPanduan = '';
                    }

                    if ($showKegiatan['file_surat_tugas'] == NULL || $showKegiatan['file_surat_tugas'] == '') {
                      $isiST = '<span class="font-weight-bold text-danger">X</span>';
                      $bgST = '';
                    } elseif ($showKegiatan['file_surat_tugas'] == '0') {
                      $isiST = '<span class="font-weight-bold text-primary">&mdash;</span>';
                      $bgST = 'bg-secondary2';
                    } elseif ($showKegiatan['file_surat_tugas'] != NULL || $showKegiatan['file_surat_tugas'] != '' || $showKegiatan['file_surat_tugas'] != '0') {
                      $isiST = '
                     <button type="button" class="btn btn-primary btn-xs" title="Edit Program" data-toggle="modal" data-target="#editProgram" data-id="' . encrypt($showProgram['id_program']) . '"><i data-feather="edit"></i></button>
                     <button type="button" class="btn btn-danger btn-xs" title="Hapus Program" data-toggle="modal" data-target="#delProgram" data-id="' . encrypt($showProgram['id_program']) . '"><i data-feather="trash"></i></button>';
                      $bgST = '';
                    } else {
                      $isiST = '';
                      $bgST = '';
                    }

                    if ($showKegiatan['file_daftar_hadir'] == NULL || $showKegiatan['file_daftar_hadir'] == '') {
                      $isiDH = '<span class="font-weight-bold text-danger">X</span>';
                      $bgDH = '';
                    } elseif ($showKegiatan['file_daftar_hadir'] == '0') {
                      $isiDH = '<span class="font-weight-bold text-primary">&mdash;</span>';
                      $bgDH = 'bg-secondary2';
                    } elseif ($showKegiatan['file_daftar_hadir'] != NULL || $showKegiatan['file_daftar_hadir'] != '' || $showKegiatan['file_daftar_hadir'] != '0') {
                      $isiDH = '
                     <button type="button" class="btn btn-primary btn-xs" title="Edit Program" data-toggle="modal" data-target="#editProgram" data-id="' . encrypt($showProgram['id_program']) . '"><i data-feather="edit"></i></button>
                     <button type="button" class="btn btn-danger btn-xs" title="Hapus Program" data-toggle="modal" data-target="#delProgram" data-id="' . encrypt($showProgram['id_program']) . '"><i data-feather="trash"></i></button>';
                      $bgDH = '';
                    } else {
                      $isiDH = '';
                      $bgDH = '';
                    }

                    if ($showKegiatan['file_notula'] == NULL || $showKegiatan['file_notula'] == '') {
                      $isiNotula = '<span class="font-weight-bold text-danger">X</span>';
                      $bgNotula = '';
                    } elseif ($showKegiatan['file_notula'] == '0') {
                      $isiNotula = '<span class="font-weight-bold text-primary">&mdash;</span>';
                      $bgNotula = 'bg-secondary2';
                    } elseif ($showKegiatan['file_notula'] != NULL || $showKegiatan['file_notula'] != '' || $showKegiatan['file_notula'] != '0') {
                      $isiNotula = '
                     <button type="button" class="btn btn-primary btn-xs" title="Edit Program" data-toggle="modal" data-target="#editProgram" data-id="' . encrypt($showProgram['id_program']) . '"><i data-feather="edit"></i></button>
                     <button type="button" class="btn btn-danger btn-xs" title="Hapus Program" data-toggle="modal" data-target="#delProgram" data-id="' . encrypt($showProgram['id_program']) . '"><i data-feather="trash"></i></button>';
                      $bgNotula = '';
                    } else {
                      $isiNotula = '';
                      $bgNotula = '';
                    }

                    if ($showKegiatan['file_hasil_kegiatan'] == NULL || $showKegiatan['file_hasil_kegiatan'] == '') {
                      $isiHK = '<span class="font-weight-bold text-danger">X</span>';
                      $bgHK = '';
                    } elseif ($showKegiatan['file_hasil_kegiatan'] == '0') {
                      $isiHK = '<span class="font-weight-bold text-primary">&mdash;</span>';
                      $bgHK = 'bg-secondary2';
                    } elseif ($showKegiatan['file_hasil_kegiatan'] != NULL || $showKegiatan['file_hasil_kegiatan'] != '' || $showKegiatan['file_hasil_kegiatan'] != '0') {
                      $isiHK = '
                     <button type="button" class="btn btn-primary btn-xs" title="Edit Program" data-toggle="modal" data-target="#editProgram" data-id="' . encrypt($showProgram['id_program']) . '"><i data-feather="edit"></i></button>
                     <button type="button" class="btn btn-danger btn-xs" title="Hapus Program" data-toggle="modal" data-target="#delProgram" data-id="' . encrypt($showProgram['id_program']) . '"><i data-feather="trash"></i></button>';
                      $bgHK = '';
                    } else {
                      $isiHK = '';
                      $bgHK = '';
                    }

                    if ($showKegiatan['file_dokumentasi'] == NULL || $showKegiatan['file_dokumentasi'] == '') {
                      $isiDok = '<span class="font-weight-bold text-danger">X</span>';
                      $bgDok = '';
                    } elseif ($showKegiatan['file_dokumentasi'] == '0') {
                      $isiDok = '<span class="font-weight-bold text-primary">&mdash;</span>';
                      $bgDok = 'bg-secondary2';
                    } elseif ($showKegiatan['file_dokumentasi'] != NULL || $showKegiatan['file_dokumentasi'] != '' || $showKegiatan['file_dokumentasi'] != '0') {
                      $isiDok = '
                     <button type="button" class="btn btn-primary btn-xs" title="Edit Program" data-toggle="modal" data-target="#editProgram" data-id="' . encrypt($showProgram['id_program']) . '"><i data-feather="edit"></i></button>
                     <button type="button" class="btn btn-danger btn-xs" title="Hapus Program" data-toggle="modal" data-target="#delProgram" data-id="' . encrypt($showProgram['id_program']) . '"><i data-feather="trash"></i></button>';
                      $bgDok = '';
                    } else {
                      $isiDok = '';
                      $bgDok = '';
                    }

                ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td class="text-center"><?= $tgl_awal . '<br>s/d<br>' . $tgl_akhir ?></td>
                      <td style="white-space: pre-line;"><?= $showKegiatan['nama_kegiatan'] . '<br><i class="font-weight-bold text-' . $showKegiatan['warna'] . '">Status : ' . $showKegiatan['deskripsi'] . '</i>' ?></td>
                      <td class="text-center <?= $bgSU ?>"><?= $isiSU ?></td>
                      <td class="text-center <?= $bgSK ?>"><?= $isiSK ?></td>
                      <td class="text-center <?= $bgPanduan ?>"><?= $isiPanduan ?></td>
                      <td class="text-center <?= $bgST ?>"><?= $isiST ?></td>
                      <td class="text-center <?= $bgDH ?>"><?= $isiDH ?></td>
                      <td class="text-center <?= $bgNotula ?>"><?= $isiNotula ?></td>
                      <td class="text-center <?= $bgHK ?>"><?= $isiHK ?></td>
                      <td class="text-center <?= $bgDok ?>"><?= $isiDok ?></td>
                      <td class="text-center">
                        <button type="button" class="btn btn-success btn-xs" title="Ubah Status Kegiatan" data-toggle="modal" data-target="#updateStatusActivity" data-id="<?= encrypt($showKegiatan['id_kegiatan']) ?>" data-token="<?= encrypt($showKegiatan['thn_kegiatan']) ?>"><i data-feather="star"></i></button>
                        <button type="button" class="btn btn-primary btn-xs" title="Upload File Kegiatan" data-toggle="modal" data-target="#uploadFileActivity" data-id="<?= encrypt($showKegiatan['id_kegiatan']) ?>" data-token="<?= encrypt($showKegiatan['thn_kegiatan']) ?>"><i data-feather="upload"></i></button>
                        <button type="button" class="btn btn-info btn-xs" title="Ubah Data Kegiatan" data-toggle="modal" data-target="#editDetailActivity" data-id="<?= encrypt($showKegiatan['id_kegiatan']) ?>" data-token="<?= encrypt($showKegiatan['thn_kegiatan']) ?>"><i data-feather="edit"></i></button>
                        <button type="button" class="btn btn-danger btn-xs" title="Hapus Data Kegiatan" data-toggle="modal" data-target="#delDetailActivity" data-id="<?= encrypt($showKegiatan['id_kegiatan']) ?>" data-token="<?= encrypt($showKegiatan['thn_kegiatan']) ?>"><i data-feather="trash"></i></button>
                      </td>
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