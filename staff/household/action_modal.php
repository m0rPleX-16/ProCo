<!-- Edit -->
<div class="modal fade" id="edit<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable custom-modal-dialog">
        <div class="modal-content">
            <div class="modal-header custom-modal-header">
                <h4 class="modal-title" id="myModalLabel">Edit Household</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="function.php?id=<?php echo $row['id']; ?>">
                    <div class="container-fluid">
                        <div class="mb-3 row align-items-center">
                            <label for="houseID" class="col-sm-4 col-form-label text-start">Household ID:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="id" value="<?php echo $row['id']; ?>" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="famID" class="col-sm-4 col-form-label text-start">Family Head Name:</label>
                            <div class="col-sm-8">
                                <?php
                                // Assuming $row contains data from families_tb query
                                $id = $row['id'];
                                $famHeadName = $row['FamHeadName'];
                                ?>
                                <input type="text" class="form-control" name="famID" id="familyIDInput<?php echo $id; ?>" autocomplete="off" value="<?php echo $id . ' - ' . $famHeadName; ?>">
                                <div id="familyIDList<?php echo $id; ?>" class="list-group"></div>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="houseown" class="col-sm-4 col-form-label text-start">Ownership:</label>
                            <div class="col-sm-8">
                                <select name="ownership" class="form-control input-sm input-size" required>
                                    <option value="<?php echo $row['Household_Ownership']; ?>"><?php echo $row['Household_Ownership']; ?></option>
                                    <option value="N/A">N/A</option>
                                    <option value="Sole Ownership">Sole Ownership</option>
                                    <option value="Joints Ownership">Joints Ownership</option>
                                    <option value="Tenants in Common">Tenants in Common</option>
                                    <option value="Freehold Property">Freehold Property</option>
                                    <option value="Leasehold Property">Leasehold Property</option>
                                    <option value="Shared Freehold">Shared Freehold</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="type" class="col-sm-4 col-form-label text-start">Type:</label>
                            <div class="col-sm-8">
                                <select name="type" class="form-control input-sm input-size" required>
                                    <option value="<?php echo $row['Household_Type']; ?>"><?php echo $row['Household_Type']; ?></option>
                                    <option value="N/A">N/A</option>
                                    <option value="Apartment">Apartment</option>
                                    <option value="Condominium">Condominium</option>
                                    <option value="Room Rental">Room Rental</option>
                                    <option value="Shared Housing">Shared Housing</option>
                                    <option value="Mobile Home">Mobile Home</option>
                                    <option value="Duplex">Duplex</option>
                                </select>
                            </div>
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
<!-- /.modal -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        var modalId = <?php echo $row['id']; ?>;
        $('#familyIDInput' + modalId).keyup(function() {
            var query = $(this).val();
            if (query != '') {
                $.ajax({
                    url: 'family_fetch.php',
                    method: 'POST',
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('#familyIDList' + modalId).fadeIn();
                        $('#familyIDList' + modalId).html(data);
                    }
                });
            } else {
                $('#familyIDList' + modalId).fadeOut();
                $('#familyIDList' + modalId).html('');
            }
        });

        $(document).on('click', '.familyIDItem', function() {
            var id = $(this).data('id'); // Get the ID from data attribute
            var name = $(this).text(); // Get the name from the list item
            $('#familyIDInput' + modalId).val(name); // Set the input value to the name only
            $('#familyIDList' + modalId).fadeOut();
        });
    });
</script>