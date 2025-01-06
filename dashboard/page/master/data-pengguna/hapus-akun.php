<?php
header('Access-Control-Allow-Origin: *');
session_start();
include_once '../../../../inc/inc.koneksi.php';
include_once '../../../../inc/inc.library.php';
include_once '../../../../inc/config.php';
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
    $id_manajemen = decrypt($_POST['id']);
    $sqlAkun = mysqli_query($myConnection, "select akun_manajemen.*, db_level_akun.ket as level, tb_area.nama_area as area
    from akun_manajemen
    left join db_level_akun on db_level_akun.id_level_akun = akun_manajemen.level_manajemen
    left join tb_area on tb_area.id_area = akun_manajemen.area_manajemen
    where akun_manajemen.id_manajemen = '$id_manajemen'");
    if (mysqli_num_rows($sqlAkun) > 0) {
        $viewCekAkun = mysqli_fetch_array($sqlAkun);
        if ($viewCekAkun['level_manajemen'] == 3) {
            $akses = "\nAkses " . $viewCekAkun['area'];
        } else {
            $akses = '';
        }

?>
        <form action="setAccount" method="post" role="form" enctype="multipart/form-data" autocomplete="off">
            <div class="modal-header">
                <h4><i class="bx bx-folder-plus"></i> Hapus Akun Manajemen</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Pegawai</label>
                    <input type="text" class="form-control fw-bold" value="<?= $viewCekAkun['nama_manajemen'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control fw-bold" value="<?= $viewCekAkun['user_manajemen'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label class="form-label">Hak Akses</label>
                    <textarea class="form-control fw-bold" readonly><?= $viewCekAkun['level'] . '' . $akses ?></textarea>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="hapus_data_akun">
                        <label class="form-check-label" for="hapus_data_akun">Saya yakin akan menghapus <strong>Data Pengguna</strong>.</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="_key" value="<?= encrypt($id_manajemen) ?>">
                <button type="submit" name="delAccount" class="btn btn-info" id="hapusDataAkun" disabled>Hapus</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Batal</button>
            </div>
        </form>
        <script type="text/javascript">
            $('#hapus_data_akun').click(function() {
                if ($(this).is(':checked')) {

                    $('#hapusDataAkun').removeAttr('disabled');

                } else {
                    $('#hapusDataAkun').attr('disabled', true);
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