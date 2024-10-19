<!-- Add New -->
<div class="modal fade" id="addRecordModal" tabindex="-1" aria-labelledby="addRecordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable custom-modal-dialog">
        <div class="modal-content">
            <div class="modal-header custom-modal-header">
                <h5 class="modal-title" id="addRecordModalLabel">Add Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="function.php" enctype="multipart/form-data">
                    <div class="row justify-content-start">
                        <div class="col-md-6">
                            <div class="mb-3 row align-items-center">
                                <label for="image" class="col-sm-4 col-form-label text-start">Resident's Image:</label>
                                <div class="col-sm-6">
                                    <img id="previewImage" src="https://bootdey.com/img/Content/avatar/avatar7.png" class="card-img-top" alt="Profile Image" style="width:100px; height:auto;">
                                    <input type="file" class="form-control" name="image" id="image" accept="image/jpeg,image/png,image/bmp" required>
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="lastname" class="col-sm-4 col-form-label text-start">Last Name:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="lastname" placeholder="e.g. Dela Cruz" required>
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="middleinital" class="col-sm-4 col-form-label text-start">Middle Initial:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="middleinitial" placeholder="e.g. Santos" required>
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="firstname" class="col-sm-4 col-form-label text-start">First Name:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="firstname" placeholder="e.g. Juan" required>
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="age" class="col-sm-4 col-form-label text-start">Age:</label>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control" name="age" placeholder="e.g. 31" required>
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="birth" class="col-sm-4 col-form-label text-start">Date of Birth:</label>
                                <div class="col-sm-6">
                                    <input type="date" class="form-control" name="birth" required>
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="status" class="col-sm-4 col-form-label text-start">Marital Status:</label>
                                <div class="col-sm-6">
                                    <select name="status" class="form-control input-sm input-size" required>
                                        <option>N/A</option>
                                        <option>Single</option>
                                        <option>Married</option>
                                        <option>Widowed</option>
                                        <option>Divorced</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="sex" class="col-sm-4 col-form-label text-start">Sex:</label>
                                <div class="col-sm-6">
                                    <select name="sex" class="form-control input-sm input-size" required>
                                        <option>N/A</option>
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- another column  -->
                        <div class="col-md-6">
                            <div class="mb-3 row align-items-center">
                                <label for="contact" class="col-sm-4 col-form-label text-start">Contact Number:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="contact" placeholder="e.g. 09123456789" required>
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="address" class="col-sm-4 col-form-label text-start">Address:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="address" placeholder="e.g. ..." required>
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="year" class="col-sm-4 col-form-label text-start">Year/s of Residency:</label>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control" name="year" placeholder="e.g. #" required>
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="educ" class="col-sm-4 col-form-label text-start">Education:</label>
                                <div class="col-sm-6">
                                    <select name="educ" class="form-control input-sm input-size" required>
                                        <option>No schooling completed</option>
                                        <option>Elementary</option>
                                        <option>High School, undergraduate</option>
                                        <option>High School Graduate</option>
                                        <option>College, undergraduate</option>
                                        <option>Vocational</option>
                                        <option>Bachelors degree</option>
                                        <option>Masters degree</option>
                                        <option>Doctorate degree</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="religion" class="col-sm-4 col-form-label text-start">Religion:</label>
                                <div class="col-sm-6">
                                    <select name="religion" class="form-control input-sm input-size" required>
                                        <option>No religion</option>
                                        <option>Roman Catholic</option>
                                        <option>Christian</option>
                                        <option>Muslim</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="nationality" class="col-sm-4 col-form-label text-start">Nationality:</label>
                                <div class="col-sm-6">
                                    <select name="nationality" class="form-control input-sm input-size" required>
                                        <option>Filipino</option>
                                        <option>Foreign</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="health" class="col-sm-4 col-form-label text-start">Vital Status:</label>
                                <div class="col-sm-6">
                                    <select name="health" class="form-control input-sm input-size" required>
                                        <option>Unknown</option>
                                        <option>Alive</option>
                                        <option>Deceased</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="email" class="col-sm-4 col-form-label text-start">Email:</label>
                                <div class="col-sm-6">
                                    <input type="email" class="form-control" name="email" placeholder="e.g. sample@sample.com" required>
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="password" class="col-sm-4 col-form-label text-start">Password:</label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input name="password" type="password" class="form-control fs-6 custom-input" placeholder="Password" id="password" required>
                                        <button type="button" class="btn btn-outline-secondary" id="showPassword">
                                            <i class='bx bx-show'></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
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
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<script>
    const imgInput = document.getElementById('image');
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