<?php
session_start();
require_once '../../../../inc/inc.library.php';
?>
<div class="modal-header">
    <h3 class="modal-title" id="exampleModalLabel">Pilih Tahun Capaian Kinerja</h3>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<form id="cekThnKegiatan" role="form" action="javascript:void(0)">
    <div class="modal-body">
        <div class="form-group">
            <select class="form-control fw-bold" id="byYearInstrument" aria-label="Default select example">
                <option selected="" disabled>Pilih Tahun Kegiatan</option>
                <?php
                $sekarang = date('Y');
                for ($i = $sekarang - 1; $i <= $sekarang + 1; $i++) {
                    echo '<option value=' . encrypt($i);
                    if ($i == $sekarang) {
                        echo ' selected ';
                    }
                    echo '>' . $i . '</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <input type="hidden" id="_key" value="<?= encrypt($_SESSION['akses_tim']) ?>">
        <input type="hidden" id="_id" value="<?= encrypt($_SESSION['level']) ?>">
        <button type="submit" class="btn btn-success">Lanjut</button>
    </div>
</form>
<script type="text/javascript">
    $('#cekThnKegiatan').submit(function(e) {
        let byYearInstrument = document.getElementById("byYearInstrument").value;
        let byKey = document.getElementById("_key").value;
        let byID = document.getElementById("_id").value;
        if (byID == 'TWpNNU9UTTVOMk14') {
            window.location = "detailInstrumentList?_token=" + byYearInstrument + "&_key=" + byKey;
        } else {
            window.location = "instrumentList?_token=" + byYearInstrument;
        }
    });
</script>