<?php
if ($level == 1 || $level == 2) { ?>
    <div class="modal fade" id="addDetailActivity" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleEditModal" aria-hidden="true" aria-modal="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div id="load-add-detail-activity" style="display: none;">
                    <div class="modal-body">
                        <span class="spinner-border spinner-border-sm text-secondary" role="status" aria-hidden="true"></span>
                        loading......
                    </div>
                </div>
                <div class="add-detail-activity" id="add-detail-activity"></div>
            </div>
        </div>
    </div>
<?php } elseif ($level == 3) { ?>
    # code...
<?php } else {
    # code...
}
?>