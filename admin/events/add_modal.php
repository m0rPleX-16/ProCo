<!-- Add -->
<div class="modal fade" id="addRecordModal" tabindex="-1" aria-labelledby="addRecordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable custom-modal-dialog">
        <div class="modal-content">
            <div class="modal-header custom-modal-header">
                <h5 class="modal-title" id="addRecordModalLabel">Add Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" action="function.php">
                        <div class="mb-3 row align-items-center">
                            <label for="Off_ID" class="col-sm-4 col-form-label text-start">Official Name:</label>
                            <div class="col-sm-8">
                                <select class="form-select" name="Off_ID" id="officialSelect">
                                    <option selected disabled>-- Select Official --</option>
                                    <?php foreach ($officials as $row) : ?>
                                        <option value="<?php echo $row['offID']; ?>"><?php echo $row['Off_Pos'] . '. ' . $row['Off_CName']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="Event_Name" class="col-sm-4 col-form-label text-start">Event Name:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="Event_Name" placeholder="e.g. Funrun!">
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="Event_Date" class="col-sm-4 col-form-label text-start">Event Date:</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="Event_Date">
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="Event_Location" class="col-sm-4 col-form-label text-start">Event Location:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="Event_Location" placeholder="e.g. Zone #">
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="Event_Description" class="col-sm-4 col-form-label text-start">Event Description:</label>
                            <div class="col-sm-8">
                                <textarea type="text" class="form-control" name="Event_Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="cancelButton" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button id="saveButton" type="submit" class="btn btn-primary" name="add">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>