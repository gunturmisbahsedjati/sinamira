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
if (!isset($_POST['id'])) {
    echo '<div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Error</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
        <h2 class="text-center">SQL Injection Detected !</h2>
    </div>';
} else {
    $id_program = decrypt($_POST['id']);
    $sqlCekProgram = mysqli_query($myConnection, "select * from tb_program where id_program ='$id_program' and soft_delete =0");
    if (mysqli_num_rows($sqlCekProgram) > 0) {
        $viewCekProgram = mysqli_fetch_array($sqlCekProgram);
?>
        <form action="setInstrumentList" method="post" role="form" enctype="multipart/form-data" autocomplete="off">
            <div class="modal-header">
                <h4><i class="bx bx-folder-plus"></i> Capaian Program Kerja</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label font-weight-bold"><?= $viewCekProgram['nama_program'] ?></label>
                </div>
                <div class="form-group">
                    <label for="uraian">Uraian Capaian</label>
                    <textarea class="form-control" id="uraian" name="uraian" rows="4"><?= ($viewCekProgram['uraian']) ?></textarea>
                </div>
                <div class="form-group">
                    <label for="hambatan">Hambatan Capaian</label>
                    <textarea class="form-control" id="hambatan" name="hambatan" rows="4"><?= ($viewCekProgram['hambatan']) ?></textarea>
                </div>
                <div class="form-group">
                    <label for="langkah_antisipasi">Langkah Antisipasi</label>
                    <textarea class="form-control" id="langkah_antisipasi" name="langkah_antisipasi" rows="4"><?= ($viewCekProgram['langkah_antisipasi']) ?></textarea>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="edit_data_capaian">
                        <label class="form-check-label" for="edit_data_capaian">Saya yakin akan melakukan perubahan <strong>Data Program</strong>.</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="_token" value="<?= encrypt($viewCekProgram['id_program']) ?>">
                <input type="hidden" name="_key" value="<?= encrypt($viewCekProgram['thn_program']) ?>">
                <input type="hidden" name="_id" value="<?= encrypt($viewCekProgram['id_area']) ?>">
                <button type="submit" name="addInstrumentTeam" class="btn btn-success" id="updateDataCapaian" disabled>Update</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Batal</button>
            </div>
        </form>
        <script type="text/javascript">
            $('#edit_data_capaian').click(function() {
                if ($(this).is(':checked')) {

                    $('#updateDataCapaian').removeAttr('disabled');

                } else {
                    $('#updateDataCapaian').attr('disabled', true);
                }
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