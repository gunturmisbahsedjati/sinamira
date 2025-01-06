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
    $cekTim = mysqli_query($myConnection, "select * from tb_area where id_area = '$id_area'");
    if (mysqli_num_rows($cekTim) > 0) {
        $viewCekTim = mysqli_fetch_array($cekTim);
?>
        <form action="setAreaList" method="post" role="form" enctype="multipart/form-data" autocomplete="off">
            <div class="modal-header">
                <h4><i class="bx bx-folder-plus"></i> Edit Nama Area</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Area</label>
                    <input type="text" class="form-control fw-bold" value="<?= $viewCekTim['nama_area'] ?>" name="nama_area" aria-describedby="defaultFormControlHelp">
                </div>
                <div class="form-group">
                    <label class="form-label">Warna Tim</label>
                    <input class="form-control" type="color" value="<?= $viewCekTim['warna_area'] ?>" name="colorpicker_value" id="colorpicker">
                    <small class="text-danger">*Klik area warna untuk mengubah warna</small>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="edit_data_area">
                        <label class="form-check-label" for="edit_data_area">Saya yakin akan melakukan perubahan <strong>Data Area</strong>.</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="key" value="<?= encrypt($id_area); ?>">
                <button type="submit" name="editArea" class="btn btn-info" id="updateDataTim" disabled>Update</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Batal</button>
            </div>
        </form>
        <script type="text/javascript">
            $('#edit_data_area').click(function() {
                if ($(this).is(':checked')) {

                    $('#updateDataTim').removeAttr('disabled');

                } else {
                    $('#updateDataTim').attr('disabled', true);
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