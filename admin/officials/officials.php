<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (!isset($_SESSION['admin_role']) || ($_SESSION['admin_role'] !== 'Administrator' && $_SESSION['admin_role'] !== 'Captain' && $_SESSION['admin_role'] !== 'Kagawad')) {
    header("Location: ../../login.php");
} else {
    ob_start();

    // Including the database connection file
    include_once('../../include/Crud.php');
    $crud = new Crud();

    // Fetch officials data
    $sql = "SELECT * FROM officials_tb";
    $result = $crud->read($sql);
?>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/x-icon" href="images/pcLogo.png">
        <title>Officials | Profile Connect</title>
        <link rel="stylesheet" href="../../css/off-style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

    </head>

    <body>
        <div class="wrapper">
            <?php require '../sidebar.php'; ?>
            <div class="main">
                <?php require '../navbar.php'; ?>
                <main class="content px-3 py-4">
                    <div class="container-fluid">
                        <h2 class="fw-bold fs-4 mb-2">Barangay Officials</h2>
                        <?php if (isset($_SESSION['message']) || isset($_SESSION['error'])) : ?>
                            <div class="alert alert-info text-center">
                                <?php echo isset($_SESSION['message']) ? $_SESSION['message'] : ''; ?>
                                <?php echo isset($_SESSION['error']) ? $_SESSION['error'] : ''; ?>
                            </div>
                            <?php unset($_SESSION['message']);
                            unset($_SESSION['error']); ?>
                        <?php endif; ?>
                        <hr>
                        <div class="row">
                            <div class="col-lg-3 d-flex justify-content-center">
                                <a id="viewButton" type="button" class="btn btn-primary" href="official_tree.php">
                                    <i class="lni lni-network"></i> View Officials</a>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-group d-flex justify-content-center align-items-center">
                                    <div class="search-box">
                                        <input id="search" type="search" placeholder="Search" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 d-flex justify-content-center gap-2">
                                <button id="addButton" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRecordModal">Add Official</button>
                                <button id="deleteButton" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteRecordModal">Delete Selected</button>
                            </div>
                        </div>
                        <div style="height:30px;"></div>
                        <div class="section-list">
                            <div class="table-container">
                                <form method="POST">
                                    <table id="dataTable" class="table table-hover">
                                        <thead>
                                            <tr class="table-header">
                                                <th style="width: 20px !important;">
                                                    <input type="checkbox" name="chk_delete[]" class="cbxMain" onchange="checkMain(this)" />
                                                </th>
                                                <th scope="col">Position</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Contact</th>
                                                <th scope="col">Address</th>
                                                <th scope="col">Term Start</th>
                                                <th scope="col">Term End</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = mysqli_fetch_array($result)) {
                                                echo '
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" name="chk_delete[]" class="chk_delete"
                                                                    value="' . $row['offID'] . '" />
                                                            </td>
                                                            <td id="tdTable">' . $row['Off_Pos'] . '</td>
                                                            <td id="tdTable">' . $row['Off_CName'] . '</td>
                                                            <td id="tdTable">' . $row['Off_Contact'] . '</td>
                                                            <td id="tdTable">' . $row['Off_Address'] . '</td>
                                                            <td id="tdTable">' . $row['Off_TermStart'] . '</td>
                                                            <td id="tdTable">' . $row['Off_TermEnd'] . '</td>
                                                            <td id="tdTable" class="d-flex justify-content-center">
                                                                <button type="button" id="editButton"
                                                                    class="btn btn-primary btn-sm editButton"
                                                                    data-id="' . $row['offID'] . '"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editModal' . $row['offID'] . '">
                                                                        <i class="lni lni-pencil" ></i>Edit
                                                                </button>';

                                                // Check if term has ended
                                                $today = date("Y-m-d");
                                                if ($today > $row['Off_TermEnd']) {
                                                    echo '<button type="button"
                                                                class="btn btn-success btn-sm startButton"
                                                                data-id="' . $row['offID'] . '"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#startModal' . $row['offID'] . '">
                                                                <i class="fa fa-minus-circle"
                                                                    aria-hidden="true"></i> Start
                                                            </button>';
                                                } else {
                                                    echo '<button type="button" id="endButton"
                                                                    class="btn btn-danger btn-sm endButton"
                                                                    data-id="' . $row['offID'] . '"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#endModal' . $row['offID'] . '">
                                                                    <i class="fa fa-minus-circle"
                                                                        aria-hidden="true"></i> End
                                                                </button>';
                                                }
                                                echo '</td>
                                                        </tr>';

                                                // Include modals
                                                include('edit_modal.php');
                                                include('endTerm.php');
                                                include('startTerm.php');
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <?php include('delete_modal.php'); ?>
                                </form>
                            </div>
                        </div>

                    </div>
                </main>
                <?php include '../../include/footer.php' ?>
            </div>
        </div>
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
        </script>
        <?php include('add_modal.php'); ?>
        <?php include "function.php"; ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                $(".editButton").click(function() {
                    var id = $(this).data("id");
                    $('#editModal' + id).modal('show');
                });

                $(".startButton").click(function() {
                    var id = $(this).data("id");
                    $('#startModal' + id).modal('show');
                });

                $(".endButton").click(function() {
                    var id = $(this).data("id");
                    $('#endModal' + id).modal('show');
                });
            });
        </script>
    </body>

</html>
<?php }
?>