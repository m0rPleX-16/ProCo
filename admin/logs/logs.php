<!DOCTYPE html>
<html>

<?php
session_start();

if (!isset($_SESSION['admin_role']) || ($_SESSION['admin_role'] !== 'Administrator' && $_SESSION['admin_role'] !== 'Captain' && $_SESSION['admin_role'] !== 'Kagawad')) {
    header("Location: ../../login.php");
    exit();
} else {
    ob_start();
    include_once('../../include/Crud.php');

    $crud = new Crud();

    // Fetch data
    $sql = "SELECT * FROM logs ORDER BY logdate DESC";
    $result = $crud->read($sql);
?>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/x-icon" href="images/pcLogo.png">
        <title>Logs || Profile Connect</title>
        <!-- Bootstrap CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="../../css/logs-style.css">
        <!-- Lineicons -->
        <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    </head>

    <body>
        <div class="wrapper">
            <!-- Left side column. contains the logo and sidebar -->
            <?php include('../sidebar.php'); ?>
            <!-- Right side column. Contains the navbar and content of the page -->
            <div class="main">
                <?php include('../navbar.php'); ?>
                <main class="content px-3 py-4">
                    <div class="container-fluid">
                        <h2 class="fw-bold fs-4 mb-3">Action Logs</h2>
                        <!-- Main content -->
                        <div class="row">
                            <div class="col-lg-3 items-controller d-flex justify-content-start">
                                <select name="itemschoices" id="itemperpage" style="height:30px; margin-top:15px;">
                                    <option value="10" selected>10</option>
                                    <option value="20">20</option>
                                    <option value="40">40</option>
                                </select>
                                <h6 class="d-flex align-items-center" style="margin-left:8px; margin-top:12px; margin-bottom:0;"> Records Shown</h6>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-group d-flex justify-content-center">
                                    <div class="search-box" style="margin-top:13px; margin-left:30px;">
                                        <input id="search" type="search" placeholder="Search" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="height:30px;"></div>
                        <div class="section-list">
                            <div class="table-container">
                                <form method="POST">
                                    <table id="dataTable" class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">User</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = mysqli_fetch_array($result)) {
                                                echo '
                                                <tr>
                                                    <td>' . $row['user'] . '</td>
                                                    <td>' . $row['logdate'] . '</td>
                                                    <td>' . $row['action'] . '</td>
                                                </tr>
                                            ';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </form>
                                <div class="bottom-field">
                                    <ul class="pagination">
                                        <li class="prev"><a href="#" id="prev">&#139;</a></li>
                                        <!-- page number here -->
                                        <li class="next"><a href="#" id="next">&#155;</a></li>
                                    </ul>
                                </div>
                            </div><!-- /.box-body -->
                        </div> <!-- /.row -->
                    </div><!-- /.content -->
                </main>
                <?php include '../../include/footer.php' ?>
            </div>
        </div><!-- ./wrapper -->
        <!-- jQuery 2.0.2 -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="script/pagination.js"></script>
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
    </body>
<?php } ?>

</html>