<?php
require_once '../../../../inc/inc.library.php';
?>
<div class="modal-header">
    <h3 class="modal-title" id="exampleModalLabel">Pilih Tahun Data Kegiatan</h3>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<form id="cekThnKegiatan" role="form" action="javascript:void(0)">
    <div class="modal-body">
        <div class="form-group">
            <select class="form-control fw-bold" id="byYearActivity" aria-label="Default select example">
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
        <button type="submit" class="btn btn-success">Lanjut</button>
        <!-- <button class="btn btn-danger" type="button" data-dismiss="modal">Batal</button> -->
    </div>
</form>
<script type="text/javascript">
    $('#cekThnKegiatan').submit(function(e) {
        let byYearActivity = document.getElementById("byYearActivity").value;
        window.location = "activityList?_token=" + byYearActivity;
    });
</script>