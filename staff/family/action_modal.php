<!-- Edit -->
<div class="modal fade" id="edit<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable custom-modal-dialog">
        <div class="modal-content">
            <div class="modal-header custom-modal-header">
                <h4 class="modal-title" id="editModalLabel<?php echo $row['id']; ?>">Edit Family</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" action="function.php?id=<?php echo $row['id']; ?>">
                        <div class="row justify-content-start">
                            <div class="mb-3 row align-items-center">
                                <label for="id" class="col-sm-4 col-form-label text-start">Family ID:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="id" value="<?php echo isset($row['id']) ? htmlspecialchars($row['id']) : ''; ?>" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="resIDInputEdit<?php echo $row['id']; ?>" class="col-sm-4 col-form-label text-start">Resident ID:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="Res_ID" id="resIDInputEdit<?php echo $row['id']; ?>" value="<?php echo isset($row['FamilyHeadName']) ? htmlspecialchars($row['FamilyHeadName']) : ''; ?>" autocomplete="off">
                                    <div id="resIDListEdit<?php echo $row['id']; ?>" class="list-group"></div>
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="Fam_LName" class="col-sm-4 col-form-label text-start">Family Head:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="Fam_LName" id="nameInputEdit<?php echo $row['id']; ?>" value="<?php echo isset($row['Fam_LName']) ? htmlspecialchars($row['Fam_LName']) : ''; ?>">
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="Fam_Address" class="col-sm-4 col-form-label text-start">Address:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="Fam_Address" value="<?php echo isset($row['Fam_Address']) ? htmlspecialchars($row['Fam_Address']) : ''; ?>">
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="Fam_Income" class="col-sm-4 col-form-label text-start">Income:</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" name="Fam_Income" value="<?php echo isset($row['Fam_Income']) ? htmlspecialchars($row['Fam_Income']) : ''; ?>">
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="Fam_Contact" class="col-sm-4 col-form-label text-start">Contacts:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="Fam_Contact" value="<?php echo isset($row['Fam_Contact']) ? htmlspecialchars($row['Fam_Contact']) : ''; ?>">
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="Fam_MCount" class="col-sm-4 col-form-label text-start">Member Count:</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" name="Fam_MCount" value="<?php echo isset($row['Fam_MCount']) ? htmlspecialchars($row['Fam_MCount']) : ''; ?>">
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
</div>
<!-- /.modal -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#resIDInputEdit<?php echo $row['id']; ?>').keyup(function() {
            var query = $(this).val();
            if (query != '') {
                $.ajax({
                    url: 'resident_fetch.php',
                    method: 'POST',
                    data: {
                        query: query
                    },
                    success: function(data) {
                        console.log("Data fetched: ", data); // Debug: Log fetched data
                        $('#resIDListEdit<?php echo $row['id']; ?>').fadeIn();
                        $('#resIDListEdit<?php echo $row['id']; ?>').html(data);
                    }
                });
            } else {
                $('#resIDListEdit<?php echo $row['id']; ?>').fadeOut();
                $('#resIDListEdit<?php echo $row['id']; ?>').html('');
            }
        });

        $(document).on('click', '.resIDItem', function() {
            var id = $(this).data('id'); // Get the ID from data attribute
            var name = $(this).data('name'); // Get the name from data attribute

            console.log("Selected ID: ", id); // Debug: Log the selected ID
            console.log("Selected Name: ", name); // Debug: Log the selected name

            $('#resIDInputEdit<?php echo $row['id']; ?>').val(name + ' (' + id + ')'); // Set the input value to Name (ID)
            $('#nameInputEdit<?php echo $row['id']; ?>').val(name); // Set the Family Head input to the selected name
            $('#resIDListEdit<?php echo $row['id']; ?>').fadeOut();
        });
    });
</script>