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
if (isset($_POST['id'])) {
    $id_tim = decrypt($_POST['id']);
    $cekTim = mysqli_query($myConnection, "select * from tb_tim where id_tim = '$id_tim'");
    if (mysqli_num_rows($cekTim) > 0) {
        $viewCekTim = mysqli_fetch_array($cekTim);
?>
        <form action="setTeamList" method="post" role="form" enctype="multipart/form-data" autocomplete="off">
            <div class="modal-header">
                <h4><i class="bx bx-folder-plus"></i> Hapus Nama Tim/Divisi</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Tim</label>
                    <input type="text" class="form-control fw-bold" value="<?= $viewCekTim['nama_tim'] ?>" disabled aria-describedby="defaultFormControlHelp">
                </div>
                <div class="form-group">
                    <label class="form-label">Warna Tim</label>
                    <input class="form-control" type="color" value="<?= $viewCekTim['warna_tim'] ?>" disabled>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="hapus_data_tim">
                        <label class="form-check-label" for="hapus_data_tim">Saya yakin akan menghapus <strong>Data Tim</strong>.</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="key" value="<?= encrypt($id_tim); ?>">
                <button type="submit" name="delTeam" class="btn btn-info" id="hapusDataTim" disabled>Delete</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Batal</button>
            </div>
        </form>
        <script type="text/javascript">
            $('#hapus_data_tim').click(function() {
                if ($(this).is(':checked')) {

                    $('#hapusDataTim').removeAttr('disabled');

                } else {
                    $('#hapusDataTim').attr('disabled', true);
                }
            });
        </script>
<?php
    } else {
        echo '<div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Error</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <h2 class="text-center">Data Tidak Ditemukan</h2>
    </div>';
    }
} else {
    echo '<script type="text/javascript">
window.location = "../"
</script>';
}

?>