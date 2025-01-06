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
        <div class="form-group">
            <label class="form-label">Pilih Pegawai</label>
            <select class="form-control border border-secondary" title="Pilih Pegawai...." data-live-search="true" data-size="5" name="pegawai" id="pegawai">
                <?php
                $peg = getAllEmployee($keySiratu);
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
                        echo '<option value="' . encrypt($viewPegArray['id_peg']) . '">' . $viewPegArray['nama_peg'] . '</option>';
                    }
                }
                ?>
            </select>
            <small class="text-danger">Data Pegawai diambil dari Data SIRATU</small>
        </div>
        <div class="form-group">
            <label class="form-label">Username</label>
            <input type="text" class="form-control fw-bold" name="nama_pengguna" aria-describedby="defaultFormControlHelp">
        </div>
        <div class="form-group">
            <label class="form-label">Password</label>
            <input type="text" class="form-control fw-bold" name="kata_sandi" aria-describedby="defaultFormControlHelp">
        </div>
        <div class="form-group">
            <label class="form-label">Pilih Hak Akses</label>
            <select class="form-control border border-secondary" title="Pilih Hak Akses...." name="level" id="level">
                <?php
                $sqlLevel = mysqli_query($myConnection, "select id_level_akun, ket from db_level_akun where id_level_akun !=1");
                while ($viewLevel = mysqli_fetch_array($sqlLevel)) {
                    echo '<option value="' . encrypt($viewLevel['id_level_akun']) . '">' . $viewLevel['ket'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group" id="optionArea" style="display: none;">
            <label class="form-label">Pilih Akses Area</label>
            <select class="form-control border border-secondary" title="Pilih Hak Akses Area...." name="akses_area" id="akses_area">
                <?php
                $sqlLevel = mysqli_query($myConnection, "select id_area, nama_area from tb_area where soft_delete = 0");
                while ($viewLevel = mysqli_fetch_array($sqlLevel)) {
                    echo '<option value="' . encrypt($viewLevel['id_area']) . '">' . $viewLevel['nama_area'] . '</option>';
                }
                ?>
            </select>
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
        $('#level').selectpicker();

        $('#level').change(function() {
            let getValueLevel = document.getElementById("level");
            let valueLevel = getValueLevel.value;
            if (valueLevel == 'TWpNNU9UTTVOMk14') {
                $('#akses_area').selectpicker();
                document.getElementById("optionArea").style.display = "block";
            } else {
                document.getElementById("optionArea").style.display = "none";
            }
        });
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