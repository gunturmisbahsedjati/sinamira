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
if (!isset($_POST['token']) && !isset($_POST['id'])) {
    echo '<div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Error</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
        <h2 class="text-center">SQL Injection Detected !</h2>
    </div>';
} else {
    $id_kegiatan = decrypt($_POST['id']);
    $thn_kegiatan = decrypt($_POST['token']);
    $cekKegiatan = mysqli_query($myConnection, "select tb_kegiatan.* 
    from tb_kegiatan 
    left join tb_program on tb_program.id_program = tb_kegiatan.id_program
    left join tb_area on tb_area.id_area = tb_kegiatan.id_area
    where tb_kegiatan.id_kegiatan = '$id_kegiatan' 
    and tb_kegiatan.thn_kegiatan = '$thn_kegiatan' 
    and tb_kegiatan.soft_delete =0");
    if (mysqli_num_rows($cekKegiatan) > 0) {
        $showFileKegiatan = mysqli_fetch_array($cekKegiatan);
        $tgl_awal = Indonesia2Tgl(substr($showFileKegiatan['tgl_awal'], 0, 10));
        $tgl_akhir = Indonesia2Tgl(substr($showFileKegiatan['tgl_akhir'], 0, 10));
?>
        <form action="setActivityList" method="post" role="form" enctype="multipart/form-data" autocomplete="off">
            <div class="modal-header">
                <h4><i class="bx bx-folder-plus"></i> Upload Dokumen Kegiatan</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label text-muted font-weight-bold">Deskripsi Kegiatan :</label>
                    <p><?= $showFileKegiatan['nama_kegiatan'] . '<br>Tanggal Pelaksanaan : ' . $tgl_awal . ' s/d ' . $tgl_akhir ?></p>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="surat_undangan" class="fw-bold form-label">File Surat Undangan </label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" accept=".pdf" onchange="ValidateSingleInputpdf(this);ValidateSize2MB(this);" class="custom-file-input upload-pdf" name="surat_undangan" id="surat_undangan">
                                    <label class="custom-file-label file-pdf" for="surat_undangan">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <input class="form-check-input-file border border-info" type="checkbox" name="cek-surat-undangan" id="cek-surat-undangan" type="checkbox" aria-label="Checkbox for following text input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sk_kegiatan" class="fw-bold form-label">File SK Kegiatan</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" accept=".pdf" onchange="ValidateSingleInputpdf(this);ValidateSize2MB(this);" class="custom-file-input upload-pdf" name="sk_kegiatan" id="sk_kegiatan">
                                    <label class="custom-file-label file-pdf" for="sk_kegiatan">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <input class="form-check-input-file border border-info" type="checkbox" name="cek-sk" id="cek-sk" type="checkbox" aria-label="Checkbox for following text input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="panduan" class="fw-bold form-label">File Panduan</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" accept=".pdf" onchange="ValidateSingleInputpdf(this);ValidateSize2MB(this);" class="custom-file-input upload-pdf" id="panduan">
                                    <label class="custom-file-label file-pdf" for="panduan">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <input class="form-check-input-file border border-info" type="checkbox" name="cek-panduan" id="cek-panduan" type="checkbox" aria-label="Checkbox for following text input">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="surat_tugas" class="fw-bold form-label">File Surat Tugas</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" accept=".pdf" onchange="ValidateSingleInputpdf(this);ValidateSize2MB(this);" class="custom-file-input upload-pdf" name="surat_tugas" id="surat_tugas">
                                    <label class="custom-file-label file-pdf" for="surat_tugas">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <input class="form-check-input-file border border-info" type="checkbox" name="cek-st" id="cek-st" type="checkbox" aria-label="Checkbox for following text input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dh" class="fw-bold form-label">File Daftar Hadir</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" accept=".pdf" onchange="ValidateSingleInputpdf(this);ValidateSize2MB(this);" class="custom-file-input upload-pdf" name="dh" id="dh">
                                    <label class="custom-file-label file-pdf" for="dh">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <input class="form-check-input-file border border-info" type="checkbox" name="cek-dh" id="cek-dh" type="checkbox" aria-label="Checkbox for following text input">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="notula" class="fw-bold form-label">File Notula</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" accept=".pdf" onchange="ValidateSingleInputpdf(this);ValidateSize2MB(this);" class="custom-file-input upload-pdf" name="notula" id="notula">
                                    <label class="custom-file-label file-pdf" for="notula">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <input class="form-check-input-file border border-info" type="checkbox" name="cek-notula" id="cek-notula" type="checkbox" aria-label="Checkbox for following text input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="hasil_kegiatan" class="fw-bold form-label">File Hasil Kegiatan</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" accept=".pdf" onchange="ValidateSingleInputpdf(this);ValidateSize2MB(this);" class="custom-file-input upload-pdf" name="hasil_kegiatan" id="hasil_kegiatan">
                                    <label class="custom-file-label file-pdf" for="hasil_kegiatan">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <input class="form-check-input-file border border-info" type="checkbox" name="cek-hk" id="cek-hk" type="checkbox" aria-label="Checkbox for following text input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dokumentasi" class="fw-bold form-label">File Dokumentasi</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" accept=".pdf" onchange="ValidateSingleInputpdf(this);ValidateSize2MB(this);" class="custom-file-input upload-pdf" name="dokumentasi" id="dokumentasi">
                                    <label class="custom-file-label file-pdf" for="dokumentasi">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <input class="form-check-input-file border border-info" type="checkbox" name="cek-dok" id="cek-dok" type="checkbox" aria-label="Checkbox for following text input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="setuju-upload">
                        <label class="form-check-label" for="setuju-upload">Saya yakin akan mengunggah <strong>Dokumen Kegiatan</strong>.</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="_token" value="<?= $_POST['token'] ?>">
                <input type="hidden" name="_key" value="<?= $_POST['id'] ?>">
                <button type="submit" name="" class="btn btn-success" disabled id="upload-btn">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Batal</button>
            </div>
        </form>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.upload-pdf').on('change', function() {
                    let fileName = $(this).val().split('\\').pop();
                    $(this).next('.file-pdf').addClass("selected").html(fileName);
                });

                $('#cek-surat-undangan').click(function() {
                    if ($(this).is(':checked')) {
                        $('#surat_undangan').attr('disabled', true);
                    } else {
                        $('#surat_undangan').removeAttr('disabled');

                    }
                });
                $('#cek-panduan').click(function() {
                    if ($(this).is(':checked')) {
                        $('#panduan').attr('disabled', true);
                    } else {
                        $('#panduan').removeAttr('disabled');

                    }
                });
                $('#cek-st').click(function() {
                    if ($(this).is(':checked')) {
                        $('#surat_tugas').attr('disabled', true);
                    } else {
                        $('#surat_tugas').removeAttr('disabled');

                    }
                });
                $('#cek-dh').click(function() {
                    if ($(this).is(':checked')) {
                        $('#dh').attr('disabled', true);
                    } else {
                        $('#dh').removeAttr('disabled');

                    }
                });
                $('#cek-notula').click(function() {
                    if ($(this).is(':checked')) {
                        $('#notula').attr('disabled', true);
                    } else {
                        $('#notula').removeAttr('disabled');

                    }
                });
                $('#cek-hk').click(function() {
                    if ($(this).is(':checked')) {
                        $('#hasil_kegiatan').attr('disabled', true);
                    } else {
                        $('#hasil_kegiatan').removeAttr('disabled');

                    }
                });
                $('#cek-sk').click(function() {
                    if ($(this).is(':checked')) {
                        $('#sk_kegiatan').attr('disabled', true);
                    } else {
                        $('#sk_kegiatan').removeAttr('disabled');

                    }
                });
                $('#cek-dok').click(function() {
                    if ($(this).is(':checked')) {
                        $('#dokumentasi').attr('disabled', true);
                    } else {
                        $('#dokumentasi').removeAttr('disabled');

                    }
                });

                $('#setuju-upload').click(function() {
                    if ($(this).is(':checked')) {
                        $('#upload-btn').removeAttr('disabled');
                    } else {
                        $('#upload-btn').attr('disabled', true);
                    }
                });

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