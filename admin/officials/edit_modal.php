<?php
$sql = "SELECT Res_Fname, Res_Lname, Res_Mname FROM residents_tb";
$residents = $crud->read($sql);
?>
<!-- Edit Modal -->
<div id="editModal<?php echo $row['offID']; ?>" class="modal fade" tabindex="-1" aria-labelledby="addRecordModalLabel" aria-hidden="true">
    <form method="POST" enctype="multipart/form-data">
        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable custom-modal-dialog">
            <div class="modal-content">
                <div class="modal-header custom-modal-header">
                    <h4 class="modal-title">Edit Officials Info</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="mb-3 row align-items-center">
                            <input type="hidden" value="<?php echo $row['offID']; ?>" name="hidden_id" id="hidden_id" />
                            <div class="mb-3 row align-items-center">
                                <label for="Res_ID" class="col-sm-4 col-form-label text-start">Resident ID:</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" value="<?php echo $row['Res_ID']; ?>" name="Res_ID" readonly />
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="Off_Pos" class="col-sm-4 col-form-label text-start">Position:</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" value="<?php echo $row['Off_Pos']; ?>" readonly />
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="Off_CName" class="col-sm-4 col-form-label text-start">Fullname:</label>
                                <div class="col-sm-8">
                                    <input name="Off_CName" class="form-control" type="text" value="<?php echo $row['Off_CName']; ?>" />
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center"">
                                <label for=" Off_Contact" class="col-sm-4 col-form-label text-start">Contact #:</label>
                                <div class="col-sm-8">
                                    <input name="Off_Contact" class="form-control" type="text" value="<?php echo $row['Off_Contact']; ?>" />
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="Off_Address" class="col-sm-4 col-form-label text-start">Address:</label>
                                <div class="col-sm-8">
                                    <input name="Off_Address" class="form-control" type="text" value="<?php echo $row['Off_Address']; ?>" />
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="Off_TermStart" class="col-sm-4 col-form-label text-start">Start Term:</label>
                                <div class="col-sm-8">
                                    <input name="Off_TermStart" class="form-control" type="date" value="<?php echo $row['Off_TermStart']; ?>" />
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="Off_TermEnd" class="col-sm-4 col-form-label text-start">End Term:</label>
                                <div class="col-sm-8">
                                    <input name="Off_TermEnd" class="form-control" type="date" value="<?php echo $row['Off_TermEnd']; ?>" />
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="image" class="col-sm-4 col-form-label text-start">Official's Image:</label>
                                <div class="col-sm-6">
                                    <img id="previewImage" src="../../offImg/<?php echo $row['Off_Img']; ?>" class="card-img-top" alt="Profile Image" style="width:100px; height:auto;">
                                    <input type="file" class="form-control" name="Off_Img" id="Off_Img" accept="image/jpeg,image/png,image/bmp">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="cancelButton" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="saveButton" type="submit" class="btn btn-primary" name="edit">Save</button>
                </div>
            </div>
        </div>
    </form>
</div>

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