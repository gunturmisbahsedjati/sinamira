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
    $sqlCekProgram = mysqli_query($myConnection, "select tb_program.*, tb_area.nama_area, tb_area.warna_area, tb_jenis_program.jenis_program
                                          from tb_program
                                          left join tb_area on tb_area.id_area = tb_program.id_area
                                          left join tb_jenis_program on tb_jenis_program.id_jenis_program = tb_program.id_jenis_program
                                          where tb_program.id_program = '$id_program' and tb_program.soft_delete = 0 and tb_program.soft_delete =0");
    if (mysqli_num_rows($sqlCekProgram) > 0) {
        $viewCekProgram = mysqli_fetch_array($sqlCekProgram);
?>
        <form action="setProgramList" method="post" role="form" enctype="multipart/form-data" autocomplete="off">
            <div class="modal-header">
                <h4><i class="bx bx-folder-plus"></i> Hapus Program Kerja</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label text-muted">Nama Program</label>
                    <p><?= $viewCekProgram['nama_program'] ?></p>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label text-muted">Jenis Program</label>
                            <p><?= $viewCekProgram['jenis_program'] ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label text-muted">Area Program</label>
                            <p><?= $viewCekProgram['nama_area'] ?></p>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="ket" class="form-label text-muted">Keterangan <i>(Opsional)</i></label>
                    <p><?= $viewCekProgram['ket'] ?></p>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="del_data_program">
                        <label class="form-check-label" for="del_data_program">Saya yakin akan menghapus <strong>Data Program</strong> ini.</label>
                    </div>
                </div>
                <small class="text-danger font-weight-bold">*Catatan:<br>Penghapusan Data Program dapat mempengaruhi Data Kegiatan yang telah terinput.</small>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="_token" value="<?= encrypt($viewCekProgram['id_program']) ?>">
                <button type="submit" name="delProgram" class="btn btn-danger" id="delDataProgram" disabled>Hapus</button>
            </div>
        </form>
        <script type="text/javascript">
            $('#del_data_program').click(function() {
                if ($(this).is(':checked')) {

                    $('#delDataProgram').removeAttr('disabled');

                } else {
                    $('#delDataProgram').attr('disabled', true);
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