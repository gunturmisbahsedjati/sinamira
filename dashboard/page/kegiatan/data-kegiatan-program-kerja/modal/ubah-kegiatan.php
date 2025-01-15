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
if (!isset($_POST['token']) && !isset($_POST['id'])) {
    echo '<div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Error</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
        <h2 class="text-center">SQL Injection Detected !</h2>
    </div>';
} else {
    $id_kegiatan = decrypt($_POST['id']);
    $thn_kegiatan = decrypt($_POST['token']);
    $cekKegiatan = mysqli_query($myConnection, "select tb_kegiatan.* 
    from tb_kegiatan 
    left join tb_program on tb_program.id_program = tb_kegiatan.id_program
    left join tb_area on tb_area.id_area = tb_kegiatan.id_area
    where tb_kegiatan.id_kegiatan = '$id_kegiatan' 
    and tb_kegiatan.thn_kegiatan = '$thn_kegiatan' 
    and tb_kegiatan.soft_delete =0");
    if (mysqli_num_rows($cekKegiatan) > 0) {
        $showFileKegiatan = mysqli_fetch_array($cekKegiatan);
        $tgl_awal = tanggal(substr($showFileKegiatan['tgl_awal'], 0, 10));
        $tgl_akhir = tanggal(substr($showFileKegiatan['tgl_akhir'], 0, 10));
?>
        <style>
            /* .bootstrap-select>.dropdown-menu {
                width: 100%;
                min-width: auto;
            } */
        </style>
        <form action="setActivityList" method="post" role="form" enctype="multipart/form-data" autocomplete="off">
            <div class="modal-header">
                <h4><i class="bx bx-folder-plus"></i> Ubah Kegiatan</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Program Kerja Area</label>
                    <select class="form-control border border-secondary program" title="Pilih program...." data-live-search="true" data-size="5" name="program" id="program">
                        <?php
                        $id_area = $showFileKegiatan['id_area'];
                        $sqlCekProgram = mysqli_query($myConnection, "select id_program, nama_program from tb_program where id_area = '$id_area' and soft_delete = 0");
                        while ($viewCekProgram = mysqli_fetch_array($sqlCekProgram)) {
                            $selected = ($viewCekProgram['id_program'] == $showFileKegiatan['id_program']) ? 'selected' : '';
                            echo '<option style="word-wrap:break-word;white-space:normal" value="' . encrypt($viewCekProgram['id_program']) . '" ' . $selected . '>' . $viewCekProgram['nama_program'] . '</option>
                            <option data-divider="true"></option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Kegiatan</label>
                    <input type="text" class="form-control fw-bold border border-secondary" name="nama_kegiatan" placeholder="Nama Kegiatan..." aria-describedby="defaultFormControlHelp" value="<?= $showFileKegiatan['nama_kegiatan'] ?>" required>
                    <small class="text-danger">*Maksimal 500 karakter</small>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Tanggal Awal</label>
                            <input class="form-control border-secondary" id="tgl-awal" placeholder="Awal Kegiatan" name="tgl_awal" value="<?= $tgl_awal ?>" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Tanggal Akhir</label>
                            <input class="form-control border-secondary" id="tgl-akhir" placeholder="Akhir Kegiatan" name="tgl_akhir" value="<?= $tgl_akhir ?>" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="ket">Keterangan Tambahan <i>(Opsional)</i></label>
                    <textarea class="form-control border border-secondary" id="ket" name="ket" rows="3"><?= $showFileKegiatan['ket'] ?></textarea>
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