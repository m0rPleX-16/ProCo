<!-- Delete -->
<div class="modal fade" id="delete<?php echo $row['eventID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Cancel Event</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid text-center">
                    <h5>Are you sure you want to cancel the event?</h5>
                    <h2>Event Name: <b><?php echo $row['Event_Name']; ?></b></h2>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="function.php?eventID=<?php echo $row['eventID']; ?>&action=cancel" class="btn btn-danger">Yes</a>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->

<!-- Edit -->
<div class="modal fade" id="edit<?php echo $row['eventID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable custom-modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Edit Event</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" action="function.php?eventID=<?php echo $row['eventID']; ?>">
                        <div class="mb-3 row align-items-center">
                            <label for="eventID" class="col-sm-4 col-form-label text-start">Event ID:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="eventID" value="<?php echo $row['eventID']; ?>" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="Off_ID" class="col-sm-4 col-form-label text-start">Official ID:</label>
                            <div class="col-sm-8">
                                <select class="form-select" name="Off_ID" id="officialSelect" required>
                                    <option selected disabled>-- Select Official --</option>
                                    <?php foreach ($officials as $official) : ?>
                                        <option value="<?php echo $official['offID']; ?>" <?php echo ($official['offID'] == $row['Off_ID']) ? 'selected' : ''; ?>><?php echo $official['Off_Pos'] . ' ' . $official['Off_CName']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="Event_Name" class="col-sm-4 col-form-label text-start">Event Name:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="Event_Name" value="<?php echo $row['Event_Name']; ?>">
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="Event_Date" class="col-sm-4 col-form-label text-start">Event Date:</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="Event_Date" value="<?php echo $row['Event_Date']; ?>">
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="Event_Location" class="col-sm-4 col-form-label text-start">Event Location:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="Event_Location" value="<?php echo $row['Event_Location']; ?>">
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="Event_Description" class="col-sm-4 col-form-label text-start">Event Description:</label>
                            <div class="col-sm-8">
                                <textarea type="text" class="form-control" name="Event_Description"><?php echo $row['Event_Description']; ?></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="Event_Status" class="col-sm-4 col-form-label text-start">Event Status:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="Event_Status" value="<?php echo $row['Event_Status']; ?>">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="cancelButton" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button id="saveButton" type="submit" class="btn btn-primary" name="edit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>