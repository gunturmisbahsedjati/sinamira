<?php
session_start();
include_once '../../../../inc/inc.koneksi.php';
include_once '../../../../inc/inc.library.php';
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
        <form action="setProgramList" method="post" role="form" enctype="multipart/form-data" autocomplete="off">
            <div class="modal-header">
                <h4><i class="bx bx-folder-plus"></i> Edit Program Kerja</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Program</label>
                    <input type="text" class="form-control fw-bold" value="<?= $viewCekProgram['nama_program'] ?>" name="nama_program" aria-describedby="defaultFormControlHelp" required>
                    <small class="text-danger">*Maksimal 500 karakter</small>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Jenis Program</label>
                            <select class="form-control fw-bold" name="jenis_program" aria-label="Default select example" required>
                                <option disabled>Pilih Jenis Program Kerja</option>
                                <?php
                                $sqlJenis = mysqli_query($myConnection, "select * from tb_jenis_program");
                                while ($showJenis = mysqli_fetch_array($sqlJenis)) {
                                    $selectProgram = $showJenis['id_jenis_program'] == $viewCekProgram['id_jenis_program'] ? 'selected' : '';
                                    echo '<option value="' . encrypt($showJenis['id_jenis_program']) . '" ' . $selectProgram . '>' . $showJenis['jenis_program'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Area Program</label>
                            <select class="form-control fw-bold" name="area_program" aria-label="Default select example" required>
                                <option disabled>Pilih Area Program Kerja</option>
                                <?php
                                $sqlJenis = mysqli_query($myConnection, "select * from tb_area where soft_delete = 0");
                                while ($showJenis = mysqli_fetch_array($sqlJenis)) {
                                    $selectJenis = $showJenis['id_area'] == $viewCekProgram['id_area'] ? 'selected' : '';
                                    echo '<option value="' . encrypt($showJenis['id_area']) . '" ' . $selectJenis . '>' . $showJenis['nama_area'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="ket">Keterangan <i>(Opsional)</i></label>
                    <textarea class="form-control" id="ket" name="ket" rows="3"><?= nl2br($viewCekProgram['ket']) ?></textarea>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="edit_data_program">
                        <label class="form-check-label" for="edit_data_program">Saya yakin akan melakukan perubahan <strong>Data Program</strong>.</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="_token" value="<?= encrypt($viewCekProgram['id_program']) ?>">
                <button type="submit" name="editProgram" class="btn btn-success" id="updateDataProgram" disabled>Update</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Batal</button>
            </div>
        </form>
        <script type="text/javascript">
            $('#edit_data_program').click(function() {
                if ($(this).is(':checked')) {

                    $('#updateDataProgram').removeAttr('disabled');

                } else {
                    $('#updateDataProgram').attr('disabled', true);
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