<div class="modal fade" id="actionCertBtn<?php echo $row['availID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form method="POST" action="availfunction.php">
        <input type="hidden" name="availID" value="<?php echo $row['availID']; ?>" />
        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable custom-modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Document</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="mb-3 row align-items-center">
                            <label for="txt_edit_cnum" class="col-sm-4 col-form-label text-start">Certificate #:</label>
                            <div class="col-sm-8">
                                <input name="txt_edit_cnum" class="form-control input-sm" type="text" value="<?php echo $row['availID']; ?>" readonly />
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="doc_type" class="col-sm-4 col-form-label text-start">Document Type:</label>
                            <div class="col-sm-8">
                                <input name="Document_Type" class="form-control input-sm" type="text" value="<?php echo $row['Document_Type']; ?>" readonly />
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="txt_edit_amount" class="col-sm-4 col-form-label text-start">Amount:</label>
                            <div class="col-sm-8">
                                <input name="amount" class="form-control input-sm" type="number" value="<?php echo $row['amount']; ?>" />
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="txt_edit_purpose" class="col-sm-4 col-form-label text-start">Status:</label>
                            <div class="col-sm-8">
                                <select name="status" class="form-control input-sm input-size" required>
                                    <option><?php echo $row['status']; ?></option>
                                    <option>--Select Status--</option>
                                    <option>Available</option>
                                    <option>Unavailable</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary" name="edit" value="Save" />
                </div>
            </div>
        </div>
    </form>
</div>
