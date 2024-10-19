<!-- Add New -->
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
                        <div class="row justify-content-start">
                            <div class="mb-3 row align-items-center">
                                <label for="Res_ID" class="col-sm-4 col-form-label text-start">Search Head Name:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="Res_ID" id="resIDInput" autocomplete="off">
                                    <div id="resIDList" class="list-group"></div>
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="lastname" class="col-sm-4 col-form-label text-start">Family Head:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="Fam_LName" placeholder="e.g. Dela Cruz">
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="address" class="col-sm-4 col-form-label text-start">Address:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="Fam_Address" placeholder="e.g. Juan">
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="income" class="col-sm-4 col-form-label text-start">Income:</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" name="Fam_Income" placeholder="e.g. 50,000">
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="contact" class="col-sm-4 col-form-label text-start">Contact:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="Fam_Contact" placeholder="e.g. 091234567890">
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="memcount" class="col-sm-4 col-form-label text-start">Member Count:</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" name="Fam_MCount" placeholder="e.g. 5">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="saveButton" type="submit" class="btn btn-primary" name="add">Save</button>
                            <button id="cancelButton" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#resIDInput').keyup(function() {
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
                        $('#resIDList').fadeIn();
                        $('#resIDList').html(data);
                    }
                });
            } else {
                $('#resIDList').fadeOut();
                $('#resIDList').html('');
            }
        });

        $(document).on('click', '.resIDItem', function() {
            var id = $(this).data('id'); // Get the ID from data attribute
            var name = $(this).data('name'); // Get the name from data attribute

            console.log("Selected ID: ", id); // Debug: Log the selected ID
            console.log("Selected Name: ", name); // Debug: Log the selected name

            $('#resIDInput').val(id + ' (' + name + ')'); // Set the input value to Name (ID)
            $('#nameInput').val(name); // Set the Family Head input to the selected name
            $('#resIDList').fadeOut();
        });
    });
</script>