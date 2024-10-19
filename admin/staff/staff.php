<!DOCTYPE html>
<html lang="en">
<?php
//start session
session_start();
if (!isset($_SESSION['admin_role']) || ($_SESSION['admin_role'] !== 'Administrator' && $_SESSION['admin_role'] !== 'Captain' && $_SESSION['admin_role'] !== 'Kagawad')) {
    header("Location: ../../login.php");
} else {
    ob_start();
    //crud with database connection
    include_once('../../include/Crud.php');

    $crud = new Crud();

    //fetch data
    $sql = "SELECT * FROM staff_tb";
    $result = $crud->read($sql);
?>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="shortcut icon" type="x-icon" href="../../images/pcLogo.png">
        <title>Staff | Profile Connect</title>
        <link rel="stylesheet" href="css/staff-style.css">
    </head>

    <body>
        <div class="wrapper">
            <?php include '../sidebar.php'; ?>
            <div class="main">
                <?php include '../navbar.php'; ?>
                <!-- MAIN -->
                <main class="content px-3 py-4">
                    <div class="container-fluid">
                        <h2 class="fw-bold fs-4 mb-3">Staff Record</h2>
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
                                <button id="addButton" type="button" class="btn btn-primary" style="margin-top:13px;">Add Staff</button>
                            </div>
                        </div>
                        <div style="height:30px;"></div>
                        <div class="section-list">
                            <div class="table-container">
                                <table id="dataTable" class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Resident ID</th>
                                            <th scope="col">Staff Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Displays the rows of inserted data of residents -->
                                        <?php foreach ($result as $key => $row) { ?>
                                            <tr>
                                                <td><?php echo $row['Res_ID']; ?></td>
                                                <td><?php echo $row['Staff_Name']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['status']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-success editButton" data-id="<?php echo $row['staffID']; ?>"><i class="lni lni-pencil"></i>Edit</button>
                                                </td>
                                                <?php include('action_modal.php'); ?>
                                            </tr>
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
                        if (e.target.id === 'prev' || e.target.id === 'next') {
                            if (e.target.id === 'next' && limit === 5) {
                                limit = 6; // Change limit to 6 when next arrow is pressed from 5
                            }
                            setTimeout(initSearch, 500); // Adjust timeout as necessary
                        }
                    }
                });
            });
        </script>
        <?php include('add_modal.php') ?>
        <?php include('action_modal.php'); ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                $("#addButton").click(function() {
                    $('#addRecordModal').modal('show');
                });

                $(".editButton").click(function() {
                    var id = $(this).data("id");
                    $('#edit' + id).modal('show');
                });
            });
        </script>
    </body>

</html>
<?php }
?>