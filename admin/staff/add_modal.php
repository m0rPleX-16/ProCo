<!-- Add New Staff Modal -->
<div class="modal fade" id="addRecordModal" tabindex="-1" aria-labelledby="addRecordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRecordModalLabel">Manage Staff</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addStaffForm" method="POST" action="function.php">
                    <div class="container-fluid">
                        <div class="mb-3 row align-items-center">
                            <label for="Res_ID" class="col-sm-4 col-form-label text-start">Search Staff Name:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="Res_ID" id="resIDInput" autocomplete="off">
                                <div id="resIDList" class="list-group"></div>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="Staff_Name" class="col-sm-4 col-form-label text-start">Name:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="Staff_Name" name="Staff_Name">
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="email" class="col-sm-4 col-form-label text-start">Email:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="email" name="email">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#resIDInput').keyup(function() {
            var query = $(this).val();
            if (query != '') {
                $.ajax({
                    url: 'residents_fetch.php',
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

            $('#resIDInput').val(name); // Set the input value to Name
            $('#resIDList').fadeOut();
        });

        // Show/hide password functionality
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

        // Populate form fields based on input
        $(document).ready(function() {
            // Your existing code for autocomplete and other functionalities

            // Populate form fields based on input
            $(document).on('click', '.resIDItem', function() {
                var id = $(this).data('id'); // Get the ID from data attribute
                var name = $(this).data('name'); // Get the name from data attribute
                var email = $(this).data('email'); // Get the email from data attribute

                console.log("Selected ID: ", id + name); // Debug: Log the selected ID
                console.log("Selected Name: ", name); // Debug: Log the selected name
                console.log("Selected Email: ", email); // Debug: Log the selected email

                $('#resIDInput').val(id); // Set the input value to Name
                $('#Staff_Name').val(name); // Set the Name field value
                $('#email').val(email); // Set the Email field value
                // You can add additional logic here to populate other fields based on the input
            });

            // Optional: If you want to update email field as the user types
            $('#resIDInput').on('input', function() {
                var name = $(this).val(); // Get the typed name
                $('#email').val(name); // Update the Email field with the typed name
            });
        });
    });
</script>