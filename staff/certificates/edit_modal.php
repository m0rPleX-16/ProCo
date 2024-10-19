<div class="modal fade" id="editModal<?php echo $row['pid']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form method="POST">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Clearance</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <input type="hidden" value="<?php echo $row['certID'] ?>" name="hidden_id" id="hidden_id" />
                        <div class="mb-3 row align-items-center">
                            <label for="txt_edit_cnum" class="col-sm-4 col-form-label text-start">Certificate #:</label>
                            <div class="col-sm-8">
                                <input name="txt_edit_cnum" class="form-control input-sm" type="text" value="<?php echo $row['certID'] ?>" readonly />
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="resident" class="col-sm-4 col-form-label text-start">Resident:</label>
                            <div class="col-sm-8">
                                <input class="form-control input-sm" type="text" value="<?php echo $row['residentname'] ?>" readonly />
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="txt_edit_purpose" class="col-sm-4 col-form-label text-start">Purpose:</label>
                            <div class="col-sm-8">
                                <input name="txt_edit_purpose" class="form-control input-sm" type="text" value="<?php echo $row['Purpose'] ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancel" />
                    <input type="submit" class="btn btn-primary" name="btn_save" value="Save" />
                </div>
            </div>
        </div>
    </form>
</div>