<!-- Edit -->
<div class="modal fade" id="edit<?php echo $row['staffID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Edit Staff</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" action="function.php?staffID=<?php echo $row['staffID']; ?>">
                        <div class="mb-3 row align-items-center">
                            <label for="staffID" class="col-sm-4 col-form-label text-start">StaffID:</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="staffID" value="<?php echo $row['staffID']; ?>" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="eventname" class="col-sm-4 col-form-label text-start">Resident ID:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="Res_ID" value="<?php echo $row['Res_ID']; ?>">
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="address" class="col-sm-4 col-form-label text-start">Staff Name:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="Staff_Name" value="<?php echo $row['Staff_Name']; ?>">
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="income" class="col-sm-4 col-form-label text-start">Email:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="email" value="<?php echo $row['email']; ?>">
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="password" class="col-sm-4 col-form-label text-start">Password:</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input name="password" type="password" class="form-control fs-6 custom-input" placeholder="Password" id="password" required>
                                    <button type="button" class="btn btn-outline-secondary" id="showPassword">
                                        <i class='bx bx-show'></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="type" class="col-sm-4 col-form-label text-start">Status:</label>
                            <div class="col-sm-8">
                                <select name="status" class="form-control input-size" required>
                                    <?php echo '<option>' . $row['status'] . '</option>' ?>
                                    <option>--Select Status--</option>
                                    <option>On Going Term</option>
                                    <option>End Term</option>
                                    <option>Not Active</option>
                                </select>
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
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<script>
    document.getElementById('showPassword').addEventListener('click', function() {
        var passField = document.getElementById('password');
        if (passField.type === 'password') {
            passField.type = 'text';
            this.classList.add('active');
        } else {
            passField.type = 'password';
            this.classList.remove('active');
        }
    });
</script>