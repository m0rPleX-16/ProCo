<!DOCTYPE html>
<html lang="en">
<?php
session_start();

if (!isset($_SESSION['admin_role']) || ($_SESSION['admin_role'] !== 'Administrator' && $_SESSION['admin_role'] !== 'Captain' && $_SESSION['admin_role'] !== 'Kagawad')) {
    header("Location: ../../login.php");
} else {
    ob_start();
    include_once('../../include/Crud.php');

    $crud = new Crud();

    function calculateAge($birthdate)
    {
        $dob = new DateTime($birthdate);
        $now = new DateTime();
        $difference = $now->diff($dob);
        return $difference->y;
    }

    $sql = "SELECT * FROM residents_tb";
    $result = $crud->read($sql);

    // Update age in the database only if it's different
    foreach ($result as $key => $row) {
        $new_age = calculateAge($row['Res_Birth']);
        if ($new_age != $row['Res_Age']) {
            $update_sql = "UPDATE residents_tb SET Res_Age = '$new_age' WHERE id = {$row['id']}";
            $crud->execute($update_sql);
        }
    }
?>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="shortcut icon" type="x-icon" href="images/pcLogo.png">
        <link rel="stylesheet" href="css/res-style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <title>Resident | Profile Connect</title>
    </head>

    <body>
        <div class="wrapper">
            <?php require '../sidebar.php'; ?>
            <div class="main">
                <?php require '../navbar.php'; ?>
                <!-- MAIN -->
                <main class="content px-3 py-4">
                    <div class="container-fluid">
                        <h2 class="fw-bold fs-4 mb-3">Residents' Records </h2>
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
                                <button id="addButton" type="button" class="btn btn-primary" style="margin-top:13px;">Add Record</button>
                            </div>
                        </div>
                        <div style="height:30px;"></div>
                        <div class="section-list">
                            <div class="table-container">
                                <table id="dataTable" class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Resident ID</th>
                                            <th scope="col">Image</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Age</th>
                                            <th scope="col">Date of Birth</th>
                                            <th scope="col">Marital Status</th>
                                            <th scope="col">Sex</th>
                                            <th scope="col">Contact Number</th>
                                            <th scope="col">Address</th>
                                            <th scope="col">Years</th>
                                            <th scope="col">Education</th>
                                            <th scope="col">Religion</th>
                                            <th scope="col">Nationality</th>
                                            <th scope="col">Vital Status</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Displays the rows of inserted data of residents -->
                                        <?php foreach ($result as $key => $row) { ?>
                                            <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td><img src="../../resImg/<?php echo $row['Res_Img']; ?>" width="50px" alt="Resident Image"></td>
                                                <td><?php echo $row['Res_Lname'] . ', ' . $row['Res_Fname'] . ' ' . $row['Res_Mname']; ?>
                                                </td>
                                                <td><?php echo calculateAge($row['Res_Birth']); ?></td>
                                                <td><?php echo $row['Res_Birth']; ?></td>
                                                <td><?php echo $row['Res_MarStatus']; ?></td>
                                                <td><?php echo $row['Res_Sex']; ?></td>
                                                <td><?php echo $row['Res_Contacts']; ?></td>
                                                <td><?php echo $row['Res_Address']; ?></td>
                                                <td><?php echo $row['Res_Years']; ?></td>
                                                <td><?php echo $row['Res_Education']; ?></td>
                                                <td><?php echo $row['Res_Religion']; ?></td>
                                                <td><?php echo $row['Res_Nationality']; ?></td>
                                                <td><?php echo $row['Res_VitalStatus']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-success editButton" data-id="<?php echo $row['id']; ?>"><i class="lni lni-pencil"></i>Edit</button>
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
                <?php include "../../include/footer.php" ?>
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                $("#addButton").click(function() {
                    $('#addRecordModal').modal('show');
                });

                // Event delegation for edit buttons
                $(document).on('click', '.editButton', function() {
                    var id = $(this).data("id");
                    $('#edit' + id).modal('show');
                });
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    </body>

</html>
<?php }
?>