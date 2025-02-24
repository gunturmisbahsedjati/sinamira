<?php
session_start();
include_once '../../../../../inc/inc.koneksi.php';
include_once '../../../../../inc/inc.library.php';
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
if (!isset($_POST['token']) && !isset($_POST['key'])) {
    echo '<div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Error</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
        <h2 class="text-center">SQL Injection Detected !</h2>
    </div>';
} else {
    $id_area = decrypt($_POST['token']);
    $cekArea = mysqli_query($myConnection, "select id_area from tb_area where id_area = '$id_area' and soft_delete =0");
    if (mysqli_num_rows($cekArea) > 0) {
?>
        <style>
            /* .bootstrap-select>.dropdown-menu {
                width: 100%;
                min-width: auto;
            } */
        </style>
        <form action="setActivityList" method="post" role="form" enctype="multipart/form-data" autocomplete="off">
            <div class="modal-header">
                <h4><i class="bx bx-folder-plus"></i> Tambah Kegiatan</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Program Kerja Area</label>
                    <select class="form-control border border-secondary program" title="Pilih program...." data-live-search="true" data-size="5" name="program" id="program">
                        <?php
                        $sqlCekProgram = mysqli_query($myConnection, "select id_program, nama_program from tb_program where id_area = '$id_area' and soft_delete = 0");
                        while ($viewCekProgram = mysqli_fetch_array($sqlCekProgram)) {
                            echo '<option style="word-wrap:break-word;white-space:normal" value="' . encrypt($viewCekProgram['id_program']) . '">' . $viewCekProgram['nama_program'] . '</option>
                            <option data-divider="true"></option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Kegiatan</label>
                    <input type="text" class="form-control fw-bold border border-secondary" name="nama_kegiatan" placeholder="Nama Kegiatan..." aria-describedby="defaultFormControlHelp" required>
                    <small class="text-danger">*Maksimal 500 karakter</small>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Tanggal Awal</label>
                            <input class="form-control border-secondary" id="tgl-awal" placeholder="Awal Kegiatan" name="tgl_awal" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Tanggal Akhir</label>
                            <input class="form-control border-secondary" id="tgl-akhir" placeholder="Akhir Kegiatan" name="tgl_akhir" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="ket">Keterangan Tambahan <i>(Opsional)</i></label>
                    <textarea class="form-control border border-secondary" id="ket" name="ket" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="_token" value="<?= $_POST['token'] ?>">
                <input type="hidden" name="_key" value="<?= $_POST['key'] ?>">
                <button type="submit" name="addActivity" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Batal</button>
            </div>
        </form>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#program').selectpicker('destroy');
                $('#program').selectpicker();
            });
            $(function() {

                $('#tgl-awal').datepicker({
                    uiLibrary: 'bootstrap4',
                    format: 'dd-mm-yyyy'
                });
                $('#tgl-akhir').datepicker({
                    uiLibrary: 'bootstrap4',
                    format: 'dd-mm-yyyy'
                });
            });
        </script>
<?php
    } else {
        echo '<div class="modal-header">
    <h3 class="modal-title" id="exampleModalLabel">Error</h3>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <h2 class="text-center">Data Tidak Ditemukan</h2>
</div>';
    }
}
?>