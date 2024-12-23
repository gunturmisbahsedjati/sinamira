<?php
header('Access-Control-Allow-Origin: *');
session_start();
include_once '../../../../inc/inc.koneksi.php';
include_once '../../../../inc/inc.library.php';
include_once '../../../../inc/config.php';
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
?>
<form action="setAccount" method="post" role="form" enctype="multipart/form-data" autocomplete="off">
    <div class="modal-header">
        <h4><i class="bx bx-folder-plus"></i> Tambah Akun Manajemen</h4>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Pilih Pegawai</label>
            <select class="form-control" title="Pilih Pegawai...." data-live-search="true" data-size="5" name="pegawai" id="pegawai">
                <?php
                $peg = getPegSinadin($keySinadin);
                $reqPeg = http_request($peg);
                $cekPeg = json_decode($reqPeg, true);
                if ($cekPeg['status']['code'] == '200') {
                    $peg = 1;
                    $viewPeg = isset($cekPeg['results']) ? $cekPeg['results'] : array();
                } else {
                    $peg = 0;
                }
                if ($peg) {
                    $no = 1;
                    foreach ($viewPeg as $viewPegArray) {
                        echo '<option value="' . encrypt($viewPegArray['id_manajemen']) . '">' . $viewPegArray['nama_manajemen'] . '</option>';
                    }
                }
                ?>
            </select>
            <small class="text-danger">Data Pegawai yang telah memiliki akun SINADIN</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Akun</label>
            <input type="text" class="form-control fw-bold" id="nama" aria-describedby="defaultFormControlHelp" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control fw-bold" id="username" aria-describedby="defaultFormControlHelp" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Level Akun</label>
            <input type="text" class="form-control fw-bold" id="level" aria-describedby="defaultFormControlHelp" disabled>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" name="addAccount" class="btn btn-success">Simpan</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Batal</button>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function() {
        $('#pegawai').selectpicker();
        $('#pegawai').change(function() {
            var $option = $(this).find('option:selected');
            var token = $option.val();
            $.ajax({
                type: "post",
                url: "dashboard/page/master/akun_manajemen/cari-pegawai",
                data: {
                    'token': token
                },
                success: function(data) {
                    $('#nama').val(data.nama);
                    $('#username').val(data.username);
                    $('#level').val(data.level);
                },
                error: err => console.log(err)
            });
        });

    });
</script>