<?php
if ($level == 1 || $level == 2 || $level == 3) { ?>
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
    <div class="modal fade" id="editDetailActivity" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleEditModal" aria-hidden="true" aria-modal="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div id="load-edit-detail-activity" style="display: none;">
                    <div class="modal-body">
                        <span class="spinner-border spinner-border-sm text-secondary" role="status" aria-hidden="true"></span>
                        loading......
                    </div>
                </div>
                <div class="edit-detail-activity" id="edit-detail-activity"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="delDetailActivity" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleEditModal" aria-hidden="true" aria-modal="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div id="load-del-detail-activity" style="display: none;">
                    <div class="modal-body">
                        <span class="spinner-border spinner-border-sm text-secondary" role="status" aria-hidden="true"></span>
                        loading......
                    </div>
                </div>
                <div class="del-detail-activity" id="del-detail-activity"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="uploadFileActivity" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleEditModal" aria-hidden="true" aria-modal="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div id="load-upload-file-activity" style="display: none;">
                    <div class="modal-body">
                        <span class="spinner-border spinner-border-sm text-secondary" role="status" aria-hidden="true"></span>
                        loading......
                    </div>
                </div>
                <div class="upload-file-activity" id="upload-file-activity"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateStatusActivity" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleEditModal" aria-hidden="true" aria-modal="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div id="load-update-status-activity" style="display: none;">
                    <div class="modal-body">
                        <span class="spinner-border spinner-border-sm text-secondary" role="status" aria-hidden="true"></span>
                        loading......
                    </div>
                </div>
                <div class="update-status-activity" id="update-status-activity"></div>
            </div>
        </div>
    </div>
<?php } elseif ($level == 3) { ?>
    <!-- halaman anggota -->
<?php } else {
    // halaman tidak ditemukan
}
?>