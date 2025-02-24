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
    $cekKegiatan = mysqli_query($myConnection, "select tb_kegiatan.*, tb_program.nama_program, tb_area.nama_area
    from tb_kegiatan 
    left join tb_program on tb_program.id_program = tb_kegiatan.id_program
    left join tb_area on tb_area.id_area = tb_kegiatan.id_area
    where tb_kegiatan.id_kegiatan = '$id_kegiatan' 
    and tb_kegiatan.thn_kegiatan = '$thn_kegiatan' 
    and tb_kegiatan.soft_delete =0");
    if (mysqli_num_rows($cekKegiatan) > 0) {
        $showFileKegiatan = mysqli_fetch_array($cekKegiatan);
        $tgl_awal = Indonesia2Tgl(substr($showFileKegiatan['tgl_awal'], 0, 10));
        $tgl_akhir = Indonesia2Tgl(substr($showFileKegiatan['tgl_akhir'], 0, 10));
?>
        <style>
            /* .bootstrap-select>.dropdown-menu {
                width: 100%;
                min-width: auto;
            } */
        </style>
        <form action="setActivityList" method="post" role="form" enctype="multipart/form-data" autocomplete="off">
            <div class="modal-header">
                <h4><i class="bx bx-folder-plus"></i> Hapus Kegiatan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label font-weight-bold">Area Kerja</label>
                    <p><?= $showFileKegiatan['nama_area'] ?></p>
                </div>
                <div class="form-group">
                    <label class="form-label font-weight-bold">Nama Program Kerja</label>
                    <p><?= $showFileKegiatan['nama_program'] ?></p>
                </div>
                <div class="form-group">
                    <label class="form-label font-weight-bold">Nama Kegiatan</label>
                    <p><?= $showFileKegiatan['nama_kegiatan'] ?></p>
                </div>
                <div class="form-group">
                    <label class="form-label font-weight-bold">Pelaksanaan</label>
                    <p><?= $tgl_awal . ' s/d ' . $tgl_akhir ?></p>
                </div>
                <div class="form-group">
                    <label class="form-label font-weight-bold">Keterangan Tambahan</label>
                    <p><?= $showFileKegiatan['ket'] == '' || $showFileKegiatan['ket'] == NULL ? '-' : $showFileKegiatan['ket'] ?></p>
                </div>
                <div class="form-group mt-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="del-kegiatan">
                        <label class="form-check-label" for="del-kegiatan">Saya yakin akan menghapus <strong>Data Kegiatan</strong>.</label>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <input type="hidden" name="_id" value="<?= encrypt($showFileKegiatan['id_kegiatan']) ?>">
                <input type="hidden" name="_key" value="<?= $_POST['token'] ?>">
                <button type="submit" name="delActivity" class="btn btn-danger" id="hapusKeg" disabled>Hapus</button>
            </div>
        </form>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#del-kegiatan').click(function() {
                    if ($(this).is(':checked')) {
                        $('#hapusKeg').removeAttr('disabled');
                    } else {
                        $('#hapusKeg').attr('disabled', true);
                    }
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