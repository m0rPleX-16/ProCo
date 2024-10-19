<?php
// Fetch all necessary fields from residents_tb
$sql = "SELECT id, Res_Fname, Res_Lname, Res_Mname, Res_Contacts, Res_Address, email FROM residents_tb";
$residents = $crud->read($sql);
?>
<!-- Your HTML code for modal -->
<div class="modal fade" id="addRecordModal" tabindex="-1" aria-labelledby="addRecordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable custom-modal-dialog">
        <div class="modal-content">
            <div class="modal-header custom-modal-header">
                <h5 class="modal-title" id="addRecordModalLabel">Add Official</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" action="function.php" enctype="multipart/form-data">
                        <div class="mb-3 row align-items-center">
                            <label for="resID" class="col-sm-4 col-form-label text-start">Resident ID:</label>
                            <div class="col-sm-8">
                                <select class="form-select" id="residentSelect" name="Res_ID">
                                    <option selected disabled>-- Select Resident --</option>
                                    <?php foreach ($residents as $key => $row) : ?>
                                        <option value="<?php echo $row['id']; ?>" data-officialname="<?php echo $row['Res_Lname'] . ', ' . $row['Res_Fname'] . ' ' . $row['Res_Mname']; ?>" data-contact="<?php echo $row['Res_Contacts']; ?>" data-address="<?php echo $row['Res_Address']; ?>">
                                            <?php echo $row['Res_Lname'] . ', ' . $row['Res_Fname'] . ' ' . $row['Res_Mname']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="offPos" class="col-sm-4 col-form-label text-start">Position:</label>
                            <div class="col-sm-8">
                                <select name="Off_Pos" class="form-control input=sm input-size" required>
                                    <option selected="" disabled="">-- Select Positions -- </option>
                                    <option value="Barangay Captain">Barangay Captain</option>
                                    <option value="Kagawad (Ordinance)">Barangay Kagawad(Ordinance)</option>
                                    <option value="Kagawad (Public Safety)">Barangay Kagawad(Public Safety)</option>
                                    <option value="Kagawad (Tourism)">Barangay Kagawad(Tourism)</option>
                                    <option value="Kagawad (Budget & Finance)">Barangay Kagawad(Budget & Finance)</option>
                                    <option value="Kagawad (Agriculture)">Barangay Kagawad(Agriculture)</option>
                                    <option value="Kagawad (Education)">Barangay Kagawad(Education)</option>
                                    <option value="Kagawad (Infrastructure)">Barangay Kagawad(Infrastracture)</option>
                                    <option value="SK Chairman">SK Chairman</option>
                                    <option value="Barangay Secretary">Barangay Secretary</option>
                                    <option value="Barangay Treasurer">Barangay Treasurer</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="offname" class="col-sm-4 col-form-label text-start">Official Name:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="nameInput" placeholder="e.g. Ipsum, Lorem" name="Off_CName">
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="contact" class="col-sm-4 col-form-label text-start">Contact Number:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="contactInput" placeholder="e.g. 09123456789" name="Off_Contact">
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="address" class="col-sm-4 col-form-label text-start">Address:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="addressInput" placeholder="e.g. Davao City" name="Off_Address">
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="startTerm" class="col-sm-4 col-form-label text-start">Term Start:</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="termStart" name="Off_TermStart">
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="endTerm" class="col-sm-4 col-form-label text-start">Term End:</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="termEnd" name="Off_TermEnd">
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="image" class="col-sm-4 col-form-label text-start">Official's Image:</label>
                            <div class="col-sm-6">
                                <img id="previewImage" src="https://bootdey.com/img/Content/avatar/avatar7.png" class="card-img-top" alt="Profile Image" style="width:100px; height:auto;">
                                <input type="file" class="form-control" name="Off_Img" id="Off_Img" accept="image/jpeg,image/png,image/bmp" required>
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

<script>
    document.getElementById('residentSelect').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        document.getElementById('nameInput').value = selectedOption.getAttribute('data-officialname');
        document.getElementById('contactInput').value = selectedOption.getAttribute('data-contact');
        document.getElementById('addressInput').value = selectedOption.getAttribute('data-address');
    });
</script>
<script>
    const imgInput = document.getElementById('Off_Img');
    const previewImage = document.getElementById('previewImage');

    imgInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                previewImage.src = event.target.result;
            }
            reader.readAsDataURL(file);
        } else {
            // Reset to the default placeholder image if no file is selected
            previewImage.src = '<?php echo $row['Res_Img']; ?>';
        }
    });
</script>
<script>
    $(document).ready(function() {
        // Use the appropriate ID for the start term input
        $('#termStart').change(function() {
            var startterm = $(this).val();
            // Set the minimum value for the end term input
            $('#termEnd').attr('min', startterm);
        });
    });
</script>