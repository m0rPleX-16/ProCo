<?php
// Start session
session_start();
if (!isset($_SESSION['admin_role']) || ($_SESSION['admin_role'] !== 'Administrator' && $_SESSION['admin_role'] !== 'Captain' && $_SESSION['admin_role'] !== 'Kagawad')) {
    header("Location: ../../login.php");
} else {
    ob_start();
    // Including the database connection file
    include_once('../../include/Crud.php');

    $crud = new Crud();

    // Fetch events data with official names
    $sql = "SELECT e.*, o.Off_CName, o.Off_Pos 
            FROM events_tb e 
            INNER JOIN officials_tb o ON e.Off_ID = o.offID";
    $result = $crud->read($sql);

    // Fetch officials data for the dropdown
    $sqlOfficials = "SELECT offID, Off_Pos, Off_CName FROM officials_tb";
    $officials = $crud->read($sqlOfficials);
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="x-icon" href="images/pcLogo.png">
        <title>Events | Profile Connect</title>
        <!-- css -->
        <link rel="stylesheet" href="css/cal-style.css">
    </head>

    <body>
        <div class="wrapper">
            <?php include '../sidebar.php'; ?>
            <!-- Navigation Bar -->
            <div class="main">
                <?php include '../navbar.php'; ?>
                <main class="content px-3 py-4">
                    <div class="container-fluid">
                        <div class="mb-3">
                            <h3 class="fw-bold fs-4 mb-4">Events Calendar</h3>
                            <hr>
                            <?php if (isset($_SESSION['message']) || isset($_SESSION['error'])) : ?>
                                <div class="alert alert-info text-center">
                                    <?php echo isset($_SESSION['message']) ? $_SESSION['message'] : ''; ?>
                                    <?php echo isset($_SESSION['error']) ? $_SESSION['error'] : ''; ?>
                                </div>
                                <?php unset($_SESSION['message']);
                                unset($_SESSION['error']); ?>
                            <?php endif; ?>
                            <br>
                            <div class="row">
                                <div class="col-lg-3 items-controller d-flex justify-content-start">
                                    <select name="itemschoices" id="itemperpage" style="height:30px; margin-top:15px;">
                                        <option value="05" selected>05</option>
                                        <option value="10">10</option>
                                        <option value="15">15</option>
                                    </select>
                                    <h6 class="d-flex align-items-center" style="margin-left:8px; margin-bottom:0;"> Records Shown</h6>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-group d-flex justify-content-center">
                                        <div class="search-box" style="margin-top:13px;">
                                            <input id="search" type="search" placeholder="Search" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 buttons-container d-flex justify-content-center mb-2">
                                    <button id="btnAdd" type="button" class="btn" data-bs-toggle="modal" data-bs-target="#addRecordModal">Add Event</button>
                                </div>
                            </div>
                            <div style="height:30px;"></div>
                            <div class="section-list">
                                <div class="table-container">
                                    <table id="eventTable" class="table">
                                        <thead>
                                            <tr>
                                                <th id="main-header" colspan="7">Upcoming Events</th>
                                            </tr>
                                            <tr id="content-header">
                                                <th>Proposed Official</th>
                                                <th>Event</th>
                                                <th>Event Date</th>
                                                <th>Event Location</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th>Options</th>
                                            </tr>
                                        </thead>
                                        <tbody id="event-body">
                                            <?php foreach ($result as $row) { ?>
                                                <tr>
                                                    <td><?php echo $row['Off_Pos'] . ' ' . $row['Off_CName']; ?></td>
                                                    <td><?php echo $row['Event_Name']; ?></td>
                                                    <td><?php echo $row['Event_Date']; ?></td>
                                                    <td><?php echo $row['Event_Location']; ?></td>
                                                    <td><?php echo $row['Event_Description']; ?></td>
                                                    <td><?php echo $row['Event_Status']; ?></td>
                                                    <td class="d-flex justify-content-center">
                                                        <button type="button" id="editBtn" class="btn btn-success editButton" data-id="<?php echo $row['eventID']; ?>" data-bs-toggle="modal" data-bs-target="#edit<?php echo $row['eventID']; ?>">
                                                            <i class="lni lni-pencil"></i>Edit
                                                        </button>
                                                        <button type="button" id="cnclButton" class="btn btn-danger cnclButton" data-id="<?php echo $row['eventID']; ?>" data-bs-toggle="modal" data-bs-target="#delete<?php echo $row['eventID']; ?>">
                                                            Cancel
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php include('action_modal.php'); ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="bottom-field">
                                    <ul class="pagination">
                                        <li class="prev"><a href="#" id="prev">&#139;</a></li>
                                        <!-- page number here -->
                                        <li class="next"><a href="#" id="next">&#155;</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <?php include "../../include/footer.php"; ?>
            </div>
        </div>
        <?php include('add_modal.php'); ?>
        <?php include('action_modal.php'); ?>
        <script type="text/javascript" src="../../script/pagination.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                // Initialize search functionality
                function initSearch() {
                    const tr = document.querySelectorAll("tbody tr");
                    const search = document.getElementById("search");

                    search.addEventListener("keyup", e => {
                        const text = e.target.value.toLowerCase();
                        tr.forEach(row => {
                            const tds = row.querySelectorAll("td");
                            let rowContainsText = false;
                            tds.forEach(td => {
                                if (td.innerText.toLowerCase().includes(text)) {
                                    rowContainsText = true;
                                }
                            });
                            row.style.display = rowContainsText ? "" : "none";
                        });
                    });
                }
                // Call initSearch on page load
                initSearch();
                // Reinitialize search functionality after pagination
                document.querySelector('.pagination').addEventListener('click', (e) => {
                    if (e.target.tagName === 'A') {
                        setTimeout(initSearch, 500); // Adjust timeout as necessary
                    }
                });
            });

            $(document).ready(function() {
                $(".editButton").click(function() {
                    var id = $(this).data("id");
                    $('#edit' + id).modal('show');
                });

                $(".cnclButton").click(function() {
                    var id = $(this).data("id");
                    $('#delete' + id).modal('show');
                });
            });
        </script>
    </body>

    </html>
<?php } ?>