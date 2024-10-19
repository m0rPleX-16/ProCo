<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable custom-modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRecordModalLabel">Manage Certificates</h5>
                <button id="addButton" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="availfunction.php">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="mb-3 row align-items-center">
                            <label for="txt_type" class="col-sm-4 col-form-label text-start">Document Type:</label>
                            <div class="col-sm-8">
                                <input id="txt_type" name="Document_Type" class="form-control" type="text" placeholder="CEDULA, etc" />
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="txt_amount" class="col-sm-4 col-form-label text-start">Amount:</label>
                            <div class="col-sm-8">
                                <input id="txt_amount" name="amount" class="form-control" type="number" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="cancelButton" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button id="saveButton" type="submit" class="btn btn-primary" name="add">Add Document</button>
                </div>
            </form>
        </div>
    </div>
</div>