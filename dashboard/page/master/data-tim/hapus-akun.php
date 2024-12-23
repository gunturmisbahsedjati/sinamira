<?php
header('Access-Control-Allow-Origin: *');
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

if (isset($_POST['id']) && $_SESSION['level'] == 1) {
    $id_manajemen = decrypt($_POST['id']);
    $cekAkun = mysqli_query($myConnection, "select id_manajemen, nama_manajemen, user_manajemen, level_manajemen from akun_manajemen where soft_delete = 0 and id_manajemen = '$id_manajemen'");
    if (mysqli_num_rows($cekAkun) > 0) {
        $viewPeg = mysqli_fetch_array($cekAkun);
?>
        <form action="setAccount" method="post" role="form" enctype="multipart/form-data" autocomplete="off">
            <div class="modal-header">
                <h4><i class="bx bx-folder-plus"></i> Tambah Akun Manajemen</h4>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Akun</label>
                    <input type="text" class="form-control fw-bold" value="<?= $viewPeg['nama_manajemen'] ?>" aria-describedby="defaultFormControlHelp" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control fw-bold" value="<?= $viewPeg['user_manajemen'] ?>" aria-describedby="defaultFormControlHelp" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Level Akun</label>
                    <input type="text" class="form-control fw-bold" value="Petugas" aria-describedby="defaultFormControlHelp" disabled>
                </div>
                <div class="">
                    <div class="form-check">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="form-check-input" id="del_akun" name="cek">
                            <label class="form-check-label" for="del_akun">Saya yakin akan melakukan perubahan <strong>Data Akun</strong>.</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" value="<?= encrypt($viewPeg['id_manajemen']) ?>" name="_token">
                <button type="submit" name="delAccount" class="btn btn-info" id="delAkun" disabled><span class="tf-icons mdi mdi-delete"></span> Hapus</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Batal</button>
            </div>
        </form>
        <script type="text/javascript">
            $('#del_akun').click(function() {
                if ($(this).is(':checked')) {

                    $('#delAkun').removeAttr('disabled');

                } else {
                    $('#delAkun').attr('disabled', true);
                }
            });
        </script>
<?php } else {
        echo '<div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Error</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <h2 class="text-center">Data Tidak Ditemukan</h2>
    </div>';
    }
} else {
    echo '<div class="modal-header">
    <h3 class="modal-title" id="exampleModalLabel">Error</h3>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <h2 class="text-center">Data Tidak Ditemukan</h2>
</div>';
}


?>