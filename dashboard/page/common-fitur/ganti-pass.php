<?php
session_start();
include_once '../../../inc/inc.koneksi.php';
include_once '../../../inc/inc.library.php';
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
$sqlCekPass = mysqli_query($myConnection, "select pass_manajemen from akun_manajemen where id_manajemen ='$id' and soft_delete =0");
if (mysqli_num_rows($sqlCekPass) > 0) {
?>
    <form action="setCommonFeature" method="post" role="form" enctype="multipart/form-data" autocomplete="off">
        <div class="modal-header">
            <h4><i class="bx bx-folder-plus"></i> Ganti Kata Sandi</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label class="form-label">Kata Sandi Lama</label>
                <input type="text" class="form-control fw-bold" placeholder="isi kata sandi saat ini...." name="sandi_lama" aria-describedby="defaultFormControlHelp" required>
            </div>
            <div class="form-group">
                <label class="form-label">Kata Sandi Baru</label>
                <input type="text" class="form-control fw-bold" placeholder="isi kata sandi baru...." name="sandi_baru" aria-describedby="defaultFormControlHelp" required>
            </div>
            <div class="form-group">
                <label class="form-label">Konfirmasi Sandi Baru</label>
                <input type="text" class="form-control fw-bold" placeholder="isi kata sandi baru...." name="konfirmasi_baru" aria-describedby="defaultFormControlHelp" required>
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="edit_data_pass">
                    <label class="form-check-label" for="edit_data_pass">Saya yakin akan melakukan perubahan <strong>Kata Sandi</strong>.</label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" name="url" value="<?= $_POST['url'] ?>">
            <button type="submit" name="changePassword" class="btn btn-success" id="updateDataPass" disabled>Simpan</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Batal</button>
        </div>
    </form>
    <script type="text/javascript">
        $('#edit_data_pass').click(function() {
            if ($(this).is(':checked')) {
                $('#updateDataPass').removeAttr('disabled');
            } else {
                $('#updateDataPass').attr('disabled', true);
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
?>