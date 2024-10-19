<?php
session_start();
// Check user role and redirect if not authorized
$allowed_roles = ['Administrator', 'Captain', 'Kagawad'];
if (!isset($_SESSION['admin_role']) || !in_array($_SESSION['admin_role'], $allowed_roles)) {
    header("Location: ../../login.php");
    exit; // Terminate script execution after redirect
} else {
    ob_start();
    require_once('../DbConnection.php');
    include_once('../../include/Crud.php');

    // Include necessary files and initialize objects
    $dbConnection = new DbConnection();
    $crud = new Crud();
    $conn = $dbConnection->getConnection();

    //fetch data
    $sql = "SELECT availID, Document_Type, amount, status FROM avail_cert";
    $result = $crud->read($sql);
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="shortcut icon" type="x-icon" href="images/pcLogo.png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <title>Certificates | Profile Connect</title>
        <link rel="stylesheet" href="../../css/tran-style.css">
    </head>

    <body>
        <div class="wrapper">
            <?php include '../sidebar.php'; ?>
            <div class="main">
                <?php include '../navbar.php'; ?>
                <!-- MAIN -->
                <main class="content px-3 py-4">
                    <div class="container-fluid">
                        <h2 class="fw-bold fs-4 mb-3">Managing Documents</h2>
                        <?php if (isset($_SESSION['message']) || isset($_SESSION['error'])) : ?>
                            <div class="alert alert-info text-center">
                                <?php
                                if (isset($_SESSION['message'])) {
                                    echo $_SESSION['message'];
                                    unset($_SESSION['message']);
                                }
                                if (isset($_SESSION['error'])) {
                                    echo $_SESSION['error'];
                                    unset($_SESSION['error']);
                                }
                                ?>
                            </div>
                        <?php endif; ?>
                        <hr>
                        <section class="content">
                            <?php if ($_SESSION['admin_role'] == "Administrator") : ?>
                                <div class="row">
                                    <div class="box">
                                        <div class="box-header">
                                            <div class="row" style="padding:10px;">
                                                <div class="col d-flex justify-content-end">
                                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addModal" id="addCertificate"><i class="fa fa-user-plus" aria-hidden="true" style="margin-right:5px;"></i> Add Document</button>
                                                    <?php if ($_SESSION['admin_role'] == "Administrator") : ?>
                                                        <button id="deleteButton" type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteRecordModal">Remove Selected <i> 'Disapproved' </i> Documents</button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-body table-responsive">
                                            <ul class="nav nav-tabs" id="myTab">

                                                <li class="nav-item" style="margin-right:5px;"><a class="nav-link active" id="approved-tab" data-bs-toggle="tab" href="#approved">Approved</a></li>
                                                <li class="nav-item" style="margin-right:5px;"><a class="nav-link" id="disapproved-tab" data-bs-toggle="tab" href="#disapproved">Disapproved</a></li>
                                                <li class="nav-item"><a class="nav-link" id="new-tab" data-bs-toggle="tab" href="#new">Documents Available</a></li>
                                            </ul>
                                            <form method="POST" id="generateForm">
                                                <div class="tab-content">
                                                    <div id="new" class="tab-pane fade ">
                                                        <table class="table no-border-radius">
                                                            <thead>
                                                                <tr>
                                                                    <th>Document #</th>
                                                                    <th>Document Type</th>
                                                                    <th>Amount</th>
                                                                    <th>Status</th>
                                                                    <th>Options</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($result as $key => $row) { ?>
                                                                    <tr>
                                                                        <td><?php echo $row['availID']; ?></td>
                                                                        <td><?php echo $row['Document_Type']; ?></td>
                                                                        <td>₱ <?php echo number_format($row['amount'], 2); ?></td>
                                                                        <td><?php echo $row['status']; ?></td>
                                                                        <td class="d-flex justify-content-center align-items-center">
                                                                            <button type="button" id="editDocAvailable" class="btn btn-success btn-sm btn-edit actionCertBtn" data-bs-target="#actionCertBtn<?php echo $row['availID']; ?>" data-bs-toggle="modal" data-availID="<?php echo $row['availID']; ?>">
                                                                                <i class="lni lni-pencil"></i>Edit</button>
                                                                        </td>
                                                                    </tr>
                                                                    <?php include "action_cert.php"; ?>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div id="approved" class="tab-pane fade show active">
                                                        <table id="table_approved" class="table no-border-radius">
                                                            <thead>
                                                                <tr>
                                                                    <th>Certificate No.</th>
                                                                    <th>Resident Name</th>
                                                                    <th>Document Type</th>
                                                                    <th>Purpose</th>
                                                                    <th>Amount</th>
                                                                    <th style="width: 15% !important;">Option</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $query = "SELECT *, CONCAT(r.Res_Lname, ', ', r.Res_Fname, ' ', r.Res_Mname) as residentname, p.Res_ID as pid 
                                                                    FROM certificate_tb p 
                                                                    LEFT JOIN residents_tb r ON r.id = p.Res_ID  
                                                                    WHERE Issuance_Status = 'Approved'";
                                                                $result = mysqli_query($conn, $query) or die('Error: ' . mysqli_error($conn));
                                                                while ($row = mysqli_fetch_array($result)) {
                                                                    echo '<tr>
                                                                            <td>' . $row['certID'] . '</td>
                                                                            <td>' . $row['residentname'] . '</td>
                                                                            <td>' . $row['Document_Type'] . '</td>
                                                                            <td>' . $row['Purpose'] . '</td>
                                                                            <td>₱ ' . number_format($row['Amount'], 2) . '</td>
                                                                            <td>
                                                                                <button type="button" id="editDocApproved" class="btn btn-success btn-sm btn-edit editModalButton" data-pid="' . $row['pid'] . '">
                                                                                <i class="lni lni-pencil" ></i>Edit
                                                                                </button>
                                                                                <a target="_blank" href="document_print.php?residentname=' . $row['Res_ID'] . '&certID=' . $row['certID'] . '&Document_Type=' . $row['Document_Type'] . '&val=' . base64_encode($row['certID'] . '|' . $row['residentname'] . '|' . $row['Issue_Date']) . '" id="genDocApproved" class="btn btn-primary btn-sm">
                                                                                <i class="lni lni-printer"></i>Print</a></td>
                                                                            </td>
                                                                        </tr>';
                                                                    include "edit_modal.php";
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div id="disapproved" class="tab-pane fade">
                                                        <table id="table_disapproved" class="table no-border-radius">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 20px !important;">
                                                                        <input type="checkbox" name="chk_delete[]" class="cbxMain" onchange="checkMain(this)" />
                                                                    </th>
                                                                    <th>Resident Name</th>
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
                                                                $result = mysqli_query($conn, $query) or die('Error: ' . mysqli_error($conn));
                                                                while ($row = mysqli_fetch_array($result)) {
                                                                    echo '<tr>
                                                                        <td>
                                                                            <input type="checkbox" name="chk_delete[]" class="chk_delete" value="' . $row['certID'] . '" />
                                                                        </td>
                                                                        <td>' . $row['residentname'] . '</td>
                                                                        <td>' . $row['Document_Type'] . '</td>
                                                                        <td>' . $row['Purpose'] . '</td>
                                                                        <td>' . $row['Remarks'] . '</td>
                                                                    </tr>';
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <?php include "deleteModal.php"; ?>
                                            </form>
                                        </div>
                                    </div>
                                    <?php include "add_modal.php"; ?>
                                    <?php include "function.php"; ?>

                                    <?php include "availfunction.php"; ?>
                                </div>
                            <?php elseif ($_SESSION['admin_role'] == "Captain" || $_SESSION['admin_role'] == "Kagawad") : ?>
                                <div class="row">
                                    <div class="box">
                                        <div class="box-body table-responsive">
                                            <form method="POST" action="function.php">
                                                <table id="table" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Certificate ID</th>
                                                            <th>Resident Name</th>
                                                            <th>Document Type</th>
                                                            <th>Purpose</th>
                                                            <th style="width: 25% !important;">Option</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $query = "SELECT *, CONCAT(r.Res_Lname, ', ', r.Res_Fname, ' ', r.Res_Mname) as residentname, p.Res_ID as pid 
                                                                FROM certificate_tb p 
                                                                LEFT JOIN residents_tb r ON r.id = p.Res_ID  
                                                                WHERE Issuance_Status = 'New'";
                                                        $result = mysqli_query($conn, $query) or die('Error: ' . mysqli_error($conn));
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            echo '
                                                            <tr>
                                                                <td>' . $row['certID'] . '</td>
                                                                <td>' . $row['residentname'] . '</td>
                                                                <td>' . $row['Document_Type'] . '</td>	
                                                                <td>' . $row['Purpose'] . '</td>
                                                                <td>
                                                                    <button type="button" class="btn btn-success btn-sm approveBtn" data-bs-target="#approveModal' . $row['pid'] . '" data-bs-toggle="modal" id="btn_approve"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Approve</button>
                                                                    <button type="button" class="btn btn-danger btn-sm disapproveBtn" data-bs-target="#disapproveModal' . $row['pid'] . '" data-bs-toggle="modal" id="btn_disapprove"><i class="fa fa-thumbs-down" aria-hidden="true"></i> Disapprove</button>
                                                                </td>
                                                            </tr>
                                                            ';
                                                            include "approve_modal.php";
                                                            include "disapprove_modal.php";
                                                            include "function.php";
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </section>
                    </div>
                </main>
                <?php include('../../include/footer.php'); ?>
            </div>
        </div>
        <!-- Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            $(document).ready(function() {
                $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                    var target = $(e.target).attr("href");
                    $('html, body').animate({
                        scrollTop: $(target).offset().top
                    }, 500);
                });
                $('#addCertificate').click(function() {
                    $('#addModal').modal('show');
                });
                $(".actionCertBtn").click(function() {
                    var availID = $(this).data("availID");
                    $('#actionCertBtn' + availID).modal('show');
                });
                $('.approveBtn').click(function() {
                    var pid = $(this).data("pid");
                    $('#approveModal' + pid).modal('show');
                });

                $('.disapproveBtn').click(function() {
                    var pid = $(this).data("pid");
                    $('#disapproveModal' + pid).modal('show');
                });

                $(".editModalButton").click(function() {
                    var pid = $(this).data("pid");
                    $('#editModal' + pid).modal('show');
                });
            });
        </script>


    </body>

    </html>
<?php } ?>