<div id="approveModal<?php echo $row['pid'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form method="POST">
        <div class="modal-dialog modal-sm" style="width:300px !important;">
            <div class="modal-content">
                <!-- Modal content -->
                <div class="modal-header">
                <h5 class="modal-title" id="addRecordModalLabel">Approve Request</h5>
                <button id="addButton" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" value="<?php echo $row['certID']; ?>" name="hidden_id" id="hidden_id_approve_<?php echo $row['certID']; ?>" />
                    <p>Are you sure you want to approve this certificate?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary btn-sm btn_approve" name="btn_approve" data-pid="<?php echo $row['pid']; ?>" value="Approve" />
                </div>
            </div>
        </div>
    </form>
</div>