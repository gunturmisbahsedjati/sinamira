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
?>
<form action="setTeamList" method="post" role="form" enctype="multipart/form-data" autocomplete="off">
    <div class="modal-header">
        <h4><i class="bx bx-folder-plus"></i> Tambah Nama Tim/Divisi</h4>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Nama Tim</label>
            <input type="text" class="form-control fw-bold" name="nama_tim" aria-describedby="defaultFormControlHelp">
        </div>
        <div class="mb-3">
            <label class="form-label">Warna Tim</label>
            <input class="form-control" type="color" value="#666EE8" name="colorpicker_value" id="colorpicker">
            <small class="text-danger">*Klik area warna untuk mengubah warna</small>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" name="addTeam" class="btn btn-success">Simpan</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Batal</button>
    </div>
</form>
<script type="text/javascript">

</script>