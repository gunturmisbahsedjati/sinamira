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
    $id_area = decrypt($_POST['id']);
    $cekArea = mysqli_query($myConnection, "select * from tb_area where id_area = '$id_area'");
    if (mysqli_num_rows($cekArea) > 0) {
        $viewCekArea = mysqli_fetch_array($cekArea);
?>
        <form action="setAreaList" method="post" role="form" enctype="multipart/form-data" autocomplete="off">
            <div class="modal-header">
                <h4><i class="bx bx-folder-plus"></i> Hapus Nama Area/Divisi</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Area</label>
                    <input type="text" class="form-control fw-bold" value="<?= $viewCekArea['nama_area'] ?>" disabled aria-describedby="defaultFormControlHelp">
                </div>
                <div class="form-group">
                    <label class="form-label">Warna Area</label>
                    <input class="form-control" type="color" value="<?= $viewCekArea['warna_area'] ?>" disabled>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="hapus_data_area">
                        <label class="form-check-label" for="hapus_data_area">Saya yakin akan menghapus <strong>Data Area</strong>.</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="key" value="<?= encrypt($id_area); ?>">
                <button type="submit" name="delArea" class="btn btn-info" id="hapusDataArea" disabled>Delete</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Batal</button>
            </div>
        </form>
        <script type="text/javascript">
            $('#hapus_data_area').click(function() {
                if ($(this).is(':checked')) {

                    $('#hapusDataArea').removeAttr('disabled');

                } else {
                    $('#hapusDataArea').attr('disabled', true);
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
} else {
    echo '<script type="text/javascript">
window.location = "../"
</script>';
}

?>