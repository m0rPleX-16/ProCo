<?php
session_start();

if (!isset($_SESSION['staff_email']) || $_SESSION["staff_role"] !== 'Staff' || $_SESSION["status"] !== 'On Going Term') {
    // Redirect to the login page
    header("Location: ../../login.php");
    exit;
} else {
    ob_start();
    // Including the database connection file
    include_once('../DbConnection.php');
    include_once('../../include/Crud.php');

    // Error trapping: Check if the included files are loaded
    if (!class_exists('DbConnection') || !class_exists('Crud')) {
        die("Error: Required classes are missing.");
    }

    $dbConnection = new DbConnection();
    $crud = new Crud();
    $con = $dbConnection->getConnection();

    // Error trapping: Check if the database connection is established
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    // Function to sanitize user input
    function handleReqRequest($crud, $con)
    {
        if (isset($_POST['btn_req'])) {
            // Check if staff member is logged in
            if (!isset($_SESSION['staff_user_id'])) {
                // Redirect or handle unauthorized access
                header("Location: login.php");
                exit();
            }

            // Get staff ID from session
            $user_id = $crud->escape_string($_SESSION['staff_user_id']);

            // Escape the input to prevent SQL injection
            $residentID = $crud->escape_string($_POST['resID']);
            $availID = $crud->escape_string($_POST['txt_type']); // Get the availID directly
            $txt_purpose = $crud->escape_string($_POST['txt_purpose']);
            $status = 'New';
            $date = date('Y-m-d');

            // Calculate cease date 7 days from now
            $cease_date = date('Y-m-d', strtotime('+7 days'));

            // Initialize $document_type with a default value
            $document_type = "Unknown";
            $amount = "Unknown";
            $txt_remarks = "Unknown";

            // Prepare the SQL statement to fetch the Document_Type based on availID
            $stmt_document_type = $con->prepare("SELECT Document_Type, amount FROM avail_cert WHERE availID = ?");
            if (!$stmt_document_type) {
                die("Prepare failed: " . $con->error);
            }

            $stmt_document_type->bind_param("i", $availID);
            $stmt_document_type->execute();
            $stmt_document_type->store_result();

            // Check if the query returned a result
            if ($stmt_document_type->num_rows > 0) {
                $stmt_document_type->bind_result($document_type, $amount);
                $stmt_document_type->fetch();
            } else {
                echo "Error: No document type found for the given availID.";
            }

            // Close the statement
            $stmt_document_type->close();

            // Prepare the SQL statement to insert into certificate_tb
            $stmt_insert_certificate = $con->prepare("INSERT INTO certificate_tb (Res_ID, Staff_ID, Docs_ID, Document_Type, Purpose, Remarks, Issue_Date, Cease_Date, RecordedBy, Issuance_Status, Amount) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            if (!$stmt_insert_certificate) {
                die("Prepare failed: " . $con->error);
            }

            // Bind parameters
            $stmt_insert_certificate->bind_param("iiissssssss", $residentID, $user_id, $availID, $document_type, $txt_purpose, $txt_remarks, $date, $cease_date, $_SESSION['staff_username'], $status, $amount);

            // Execute the statement
            $stmt_insert_certificate->execute();

            // Check for successful insertion
            if ($stmt_insert_certificate->affected_rows > 0) {
                header("location: " . $_SERVER['REQUEST_URI']);
                exit();
            } else {
                echo "Error: " . $stmt_insert_certificate->error;
            }

            // Close the statement
            $stmt_insert_certificate->close();
        }
    }

    // Handle form submission for editing docs
    if (isset($_POST['btn_save'])) {
        // Retrieve form data
        $clearanceId = $_POST['hidden_id'];
        $newPurpose = $_POST['txt_edit_purpose'];

        // Update the database with new data
        $stmt_update_clearance = $con->prepare("UPDATE certificate_tb SET Purpose = ? WHERE certID = ?");
        if (!$stmt_update_clearance) {
            die("Prepare failed: " . $con->error);
        }

        $stmt_update_clearance->bind_param("si", $newPurpose, $clearanceId);
        $stmt_update_clearance->execute();

        // Check for successful update
        if ($stmt_update_clearance->affected_rows > 0) {
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        } else {
            echo "Error updating clearance: " . $stmt_update_clearance->error;
        }

        // Close the statement
        $stmt_update_clearance->close();
    }

    handleReqRequest($crud, $con);
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="x-icon" href="images/pcLogo.png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <title>Transaction | Profile Connect</title>
        <link rel="stylesheet" href="../../css/tran-style.css">
    </head>

    <body>
        <div class="wrapper">
            <?php include '../sidebar.php'; ?>
            <div class="main">
                <?php include '../navbar.php'; ?>
                <main class="content px-3 py-4">
                    <div class="container-fluid">
                        <h2 class="fw-bold fs-4 mb-3">Document Transactions</h2>
                        <hr>
                        <?php if ($_SESSION['staff_role'] == "Staff") { ?>
                            <div class="row">
                                <div class="box">
                                    <div class="box-header">
                                        <div style="padding:10px;">
                                            <div class="col d-flex justify-content-end">
                                                <!-- Button to trigger the Request Clearance Modal -->
                                                <button type="button" class="btn btn-success btn-sm" id="requestClearanceBtn" style="margin-right: 5px;"><i class="fa fa-user-plus" aria-hidden="true"></i> Request Document</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-body table-responsive">
                                        <ul class="nav nav-tabs" id="myTab">
                                            <li class="nav-item" style="margin-right:5px;"><a class="nav-link active" id="new-tab" data-bs-toggle="tab" href="#new">New</a></li>
                                            <li class="nav-item" style="margin-right:5px;"><a class="nav-link" id="approved-tab" data-bs-toggle="tab" href="#approved">Approved</a></li>
                                            <li class="nav-item"><a class="nav-link" id="disapproved-tab" data-bs-toggle="tab" href="#disapproved">Disapproved</a></li>
                                        </ul>
                                        <form method="POST" id="generateForm">
                                            <div class="tab-content">
                                                <div id="new" class="tab-pane fade show active">
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Resident Name</th>
                                                                <th>Purpose</th>
                                                                <th>Document Type</th>
                                                                <th>Amount</th>
                                                                <th>Recorded By</th>
                                                                <th>Issued On</th>
                                                                <th>Due On</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $stmt = $con->prepare("SELECT *, CONCAT(r.Res_Lname, ', ', r.Res_Fname, ' ', r.Res_Mname) as residentname, a.Document_Type, a.amount
                                                                       FROM certificate_tb p 
                                                                       LEFT JOIN residents_tb r ON r.id = p.Res_ID 
                                                                       LEFT JOIN avail_cert a ON a.availID = p.Docs_ID 
                                                                       WHERE p.Issuance_Status = 'New'");
                                                            $stmt->execute();
                                                            $result = $stmt->get_result();

                                                            // Fetch data from the result set
                                                            while ($row = $result->fetch_assoc()) {
                                                                echo '<tr>
                                                    <td>' . $row['residentname'] . '</td>
                                                    <td>' . $row['Purpose'] . '</td>
                                                    <td>' . $row['Document_Type'] . '</td>
                                                    <td>₱ ' . number_format($row['amount'], 2) . '</td>
                                                    <td>' . $row['RecordedBy'] . '</td>
                                                    <td>' . $row['Issue_Date'] . '</td>
                                                    <td>' . $row['Cease_Date'] . '</td>
                                                    </tr>';
                                                            }

                                                            $stmt->close();
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div id="approved" class="tab-pane">
                                                    <table id="table_approved" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Certificate #</th>
                                                                <th>Resident Name</th>
                                                                <th>Document Type</th>
                                                                <th>Purpose</th>
                                                                <th>Amount</th>
                                                                <th style="width: 15% !important;">Option</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $query = "SELECT *, CONCAT(r.Res_Lname, ', ', r.Res_Fname, ' ', r.Res_Mname) as residentname, p.Res_ID as pid, a.amount
                                                                FROM certificate_tb p 
                                                                LEFT JOIN residents_tb r ON r.id = p.Res_ID
                                                                LEFT JOIN avail_cert a ON a.availID = p.Docs_ID   
                                                                WHERE Issuance_Status = 'Approved'";
                                                            $result = mysqli_query($con, $query) or die('Error: ' . mysqli_error($conn));
                                                            while ($row = mysqli_fetch_array($result)) {
                                                                echo '<tr>
                                                                        <td>' . $row['certID'] . '</td>
                                                                        <td>' . $row['residentname'] . '</td>
                                                                        <td>' . $row['Document_Type'] . '</td>
                                                                        <td>' . $row['Purpose'] . '</td>
                                                                        <td>₱ ' . number_format($row['amount'], 2) . '</td>
                                                                        <td>
                                                                                <button type="button" id="editDocApproved" class="btn btn-success btn-sm btn-edit editModalButton" data-pid="' . $row['pid'] . '">
                                                                                <i class="lni lni-pencil" ></i>Edit
                                                                                </button>
                                                                                <a target="_blank" href="document_print.php?residentname=' . $row['Res_ID'] . '&certID=' . $row['certID'] . '&Document_Type=' . $row['Document_Type'] . '&val=' . base64_encode($row['certID'] . '|' . $row['residentname'] . '|' . $row['Issue_Date']) . '" id="genDocApproved" class="btn btn-primary btn-sm">
                                                                                <i class="lni lni-printer"></i>Print</a></td>
                                                                            </td>
                                                                      </tr>
                                                                      ';
                                                                include "edit_modal.php";
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div id="disapproved" class="tab-pane">
                                                    <table id="table" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 20px !important;"><input type="checkbox" name="chk_delete[]" class="cbxMain" onchange="checkMain(this)" /></th>
                                                                <th>Certificate #</th>
                                                                <th>Document Type</th>
                                                                <th>Purpose</th>
                                                                <th>Remarks</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $query = "SELECT *, CONCAT(r.Res_Lname, ', ', r.Res_Fname, ' ', r.Res_Mname) as residentname, p.Res_ID as pid 
                                                         FROM certificate_tb p 
                                                         LEFT JOIN residents_tb r ON r.id = p.Res_ID  
                                                         WHERE Issuance_Status = 'Disapproved'";
                                                            $result = mysqli_query($con, $query) or die('Error: ' . mysqli_error($conn));
                                                            while ($row = mysqli_fetch_array($result)) {
                                                                echo '<tr>
                                                                <td><input type="checkbox" name="chk_delete[]" class="chk_delete" value="' . $row['pid'] . '" /></td>
                                                                <td>' . $row['certID'] . '</td>
                                                                <td>' . $row['Document_Type'] . '</td>
                                                                <td>' . $row['Purpose'] . '</td>
                                                                <td>' . $row['Remarks'] . '</td>
                                                                </tr>';
                                                            }

                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- Other tabs and content here -->
                                            </div>
                                        </form>
                                        <?php
                                        include "lengthstay_error.php";
                                        include "req_modal.php";
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#myTab a').click(function(e) {
                    e.preventDefault();
                    $(this).tab('show');
                    $('.tab-pane').removeClass('active show');
                    $($(this).attr('href')).addClass('active show');
                });

                $('#requestClearanceBtn').click(function() {
                    $('#reqModal').modal('show');
                });

                $(".editButton").click(function() {
                    var pid = $(this).data("pid");
                    $('#editModal' + pid).modal('show');
                });
            });
        </script>
    </body>

    </html>
<?php } ?>