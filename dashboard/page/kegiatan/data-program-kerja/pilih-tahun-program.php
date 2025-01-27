<?php
require_once '../../../../inc/inc.library.php';
?>
<div class="modal-header">
    <h3 class="modal-title" id="exampleModalLabel">Pilih Tahun Data Program</h3>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<form id="cekThnProgram" role="form" action="javascript:void(0)">
    <div class="modal-body">
        <div class="form-group">
            <select class="form-control fw-bold" id="byYearProgram" aria-label="Default select example">
                <option selected="" disabled>Pilih Tahun Program Kerja</option>
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
    $('#cekThnProgram').submit(function(e) {
        let byYearProgram = document.getElementById("byYearProgram").value;
        window.location = "programList?_token=" + byYearProgram;
    });
</script>