<?php
if ($level == 1 || $level == 2) { ?>
    <div class="modal fade" id="addInstrumentAdmin" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleEditModal" aria-hidden="true" aria-modal="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div id="load-add-instrument-admin" style="display: none;">
                    <div class="modal-body">
                        <span class="spinner-border spinner-border-sm text-secondary" role="status" aria-hidden="true"></span>
                        loading......
                    </div>
                </div>
                <div class="add-instrument-admin" id="add-instrument-admin"></div>
            </div>
        </div>
    </div>
<?php } elseif ($level == 3) { ?>
    <!-- halaman anggota -->
    <div class="modal fade" id="addInstrumentTeam" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleEditModal" aria-hidden="true" aria-modal="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div id="load-add-instrument-team" style="display: none;">
                    <div class="modal-body">
                        <span class="spinner-border spinner-border-sm text-secondary" role="status" aria-hidden="true"></span>
                        loading......
                    </div>
                </div>
                <div class="add-instrument-team" id="add-instrument-team"></div>
            </div>
        </div>
    </div>
<?php } else {
    // halaman tidak ditemukan
}
?>