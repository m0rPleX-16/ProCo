<!-- Request Certificate Modal -->
<?php
$type = "SELECT availID, Document_Type FROM avail_cert WHERE status = 'Available'";
$doctype = $crud->read($type);
?>
<div class="modal fade" id="reqModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form method="POST">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Manage Documents</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="mb-3 row align-items-center">
                            <label for="txt_purpose" class="col-sm-3 col-form-label text-start">Purpose:</label>
                            <div class="col-sm-8">
                                <input name="txt_purpose" class="form-control input-sm" type="text" placeholder="Purpose" required/>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="txt_type" class="col-sm-3 col-form-label text-start">Document Type:</label>
                            <div class="col-sm-8">
                                <select name="txt_type" class="form-select" required>
                                    <option selected disabled>-- Select Document --</option>
                                    <?php foreach ($doctype as $row) : ?>
                                        <option value="<?php echo $row['availID']; ?>"><?php echo $row['Document_Type']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="Res_ID" class="col-sm-3 col-form-label text-start">Resident Search:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="resID" id="resIDInput" autocomplete="off">
                                <div id="resIDList" class="list-group"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary" name="btn_req" value="Request Document" />
                </div>
            </div>
        </div>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#resIDInput').keyup(function() {
            var query = $(this).val();
            if (query != '') {
                $.ajax({
                    url: 'residents_fetch.php',
                    method: 'POST',
                    data: { query: query },
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
            var email = $(this).data('email'); // Get the email from data attribute

            console.log("Selected ID: ", id); // Debug: Log the selected ID
            console.log("Selected Name: ", name); // Debug: Log the selected name
            console.log("Selected Email: ", email); // Debug: Log the selected email

            $('#resIDInput').val(id); // Set the input value to Name
            $('#Staff_Name').val(name); // Set the Name field value
            $('#email').val(email); // Set the Email field value
            $('#resIDList').fadeOut();
        });
    });
</script>
