<div id="disapproveModal<?php echo $row['pid'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form method="POST">
        <div class="modal-dialog modal-sm" style="width:300px !important;">
            <div class="modal-content">
                <!-- Modal content -->
                <div class="modal-header">
                <h5 class="modal-title" id="addRecordModalLabel">Disapprove Request</h5>
                <button id="addButton" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" value="<?php echo $row['certID']; ?>" name="hidden_id" id="hidden_id_disapprove_<?php echo $row['certID']; ?>" />
                    <p>Are you sure you want to disapprove this certificate? If yes, please give your remarks:</p>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txt_remarks">Remarks:</label>
                                <input name="txt_remarks" id="txt_remarks_<?php echo $row['pid']; ?>" class="form-control input-sm" type="text" placeholder="Remarks" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm btn_disapprove" name="btn_disapprove" data-certID="<?php echo $row['pid']; ?>">Disapprove</button>
                </div>
            </div>
        </div>
    </form>
</div>