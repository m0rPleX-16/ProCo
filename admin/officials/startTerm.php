<div id="startModal<?php echo $row['offID']; ?>" class="modal fade" tabindex="-1" aria-labelledby="addRecordModalLabel" aria-hidden="true">
    <form method="POST">
        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable custom-modal-dialog">
            <div class="modal-content">
                <div class="modal-header custom-modal-header">
                    <h4 class="modal-title">Start Term Confirmation</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid text-center">
                        <input type="hidden" value="<?php echo $row['offID']; ?>" name="hidden_id" id="hidden_id" />
                        <p>Are you sure you want to start the term of <br> <span style="font-weight: bold;"> <?php echo $row['Off_CName']; ?> </span> ?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-md" data-bs-dismiss="modal">No</button>
                    <input type="submit" class="btn btn-primary btn-md" name="btn_start" id="btn_start" value="Yes" />
                </div>
            </div>
        </div>
    </form>
</div>