<!-- Add New -->
<div class="modal fade" id="addRecordModal" tabindex="-1" aria-labelledby="addRecordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable custom-modal-dialog">
        <div class="modal-content">
            <div class="modal-header custom-modal-header">
                <h5 class="modal-title" id="addRecordModalLabel">Add Household</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="function.php">
                    <div class="container-fluid">
                        <div class="mb-3 row align-items-center">
                            <label for="famid" class="col-sm-4 col-form-label text-start">Family Head Search:</label>
                            <div class="col-sm-8">
                                <input type="search" class="form-control" name="famID" id="familyIDInput" autocomplete="off">
                                <div id="familyIDList" class="list-group"></div>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="houseown" class="col-sm-4 col-form-label text-start">Ownership:</label>
                            <div class="col-sm-8">
                                <select name="ownership" class="form-control input-sm input-size" required>
                                    <option value="">N/A</option>
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
                            <label for="type" class="col-sm-4 col-form-label text-start">Household Type:</label>
                            <div class="col-sm-8">
                                <select name="type" class="form-control input-sm input-size" required>
                                    <option value="">N/A</option>
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
                        <button id="saveButton" type="submit" class="btn btn-primary" name="add">Save</button>
                        <button id="cancelButton" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#familyIDInput').keyup(function() {
            var query = $(this).val();
            if (query != '') {
                $.ajax({
                    url: 'family_fetch.php',
                    method: 'POST',
                    data: {query: query},
                    success: function(data) {
                        $('#familyIDList').fadeIn();
                        $('#familyIDList').html(data);
                    }
                });
            } else {
                $('#familyIDList').fadeOut();
                $('#familyIDList').html('');
            }
        });

        $(document).on('click', '.familyIDItem', function() {
            $('#familyIDInput').val($(this).text());
            $('#familyIDList').fadeOut();
        });
    });
</script>
