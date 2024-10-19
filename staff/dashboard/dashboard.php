<!DOCTYPE html>
<html lang="en">

<?php
session_start();
if (!isset($_SESSION['staff_email']) || $_SESSION["staff_role"] !== 'Staff' || $_SESSION["status"] !== 'On Going Term') {
    // Redirect to the login page
    header("Location: ../../login.php");
    exit;
} else {
    ob_start();
    $is_invalid = true;

    include "../main_css.php";
    include_once('../../include/Crud.php');
    $dbConnection = new DbConnection();
    $conn = $dbConnection->getConnection();
    $crud = new Crud();

    // Check if alert message has been displayed
    if (!isset($_SESSION['alertDisplayed'])) {
        // Set flag to indicate that alert message has been displayed
        $_SESSION['alertDisplayed'] = true;
        // Set alert message to be displayed
        $showAlertMessage = true;
    } else {
        // Alert message has already been displayed, do not show again
        $showAlertMessage = false;
    }

    // Fetch events data with official names
    $sql = "SELECT e.*, o.Off_CName, o.Off_Pos 
                FROM events_tb e 
                INNER JOIN officials_tb o ON e.Off_ID = o.offID";
    $events_result = $crud->read($sql);

?>
    <link rel="stylesheet" href="../../css/main-style.css">
    <title>Dashboard | Profile Connect</title>

    <body>

        <div class="wrapper">
            <?php include '../sidebar.php'; ?>
            <div class="main">
                <?php if ($is_invalid && $showAlertMessage) : ?>
                    <div class="alert alert-primary alert-message" role="alert">
                        You are logged in as Staff!
                    </div>
                <?php endif; ?>
                <?php include '../navbar.php'; ?>
                <main class="content px-3 py-4">
                    <div class="container-fluid">
                        <h3 style="color:#0C3B2E; font-weight:700;">Staff Dashboard</h3>
                        <section class="content">
                            <div class="row">
                                <!-- left column -->
                                <div class="box d-flex">
                                    <div class="col-md-3 col-sm-6 col-xs-12" style="margin-right: 10px;"><br>
                                        <div class="info-box">
                                            <a href="../resident/resident.php"><span class="info-box-icon" style="color:#6D9773; margin-top:15px;"><i class="fa fa-users"></i></span></a>

                                            <div class="info-box-content">
                                                <span class="info-box-text">Total Residents</span>
                                                <span class="info-box-number">
                                                    <?php
                                                    $q = mysqli_query($conn, "SELECT * from residents_tb");
                                                    $num_rows = mysqli_num_rows($q);
                                                    echo $num_rows;
                                                    ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12" style="margin-right: 10px;"><br>
                                        <div class="info-box">
                                            <a href="../household/household.php"><span class="info-box-icon bg-aqua" style="color:#6D9773;margin-top:15px;"><i class="fa fa-home"></i></span></a>

                                            <div class="info-box-content">
                                                <span class="info-box-text">Total Households</span>
                                                <span class="info-box-number">
                                                    <?php
                                                    $q = mysqli_query($conn, "SELECT * from household_tb");
                                                    $num_rows = mysqli_num_rows($q);
                                                    echo $num_rows;
                                                    ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12" style="margin-right: 10px;"><br>
                                        <div class="info-box">
                                            <a href="../certificates/certificates.php"><span class="info-box-icon bg-aqua" style="color:#6D9773;margin-top:15px;"><i class="fa fa-file"></i></span></a>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Total Documents</span>
                                                <span class="info-box-number">
                                                    <?php
                                                    $q = mysqli_query($conn, "SELECT * from certificate_tb where Issuance_Status = 'Approved' ");
                                                    $num_rows = mysqli_num_rows($q);
                                                    echo $num_rows;
                                                    ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <div class="row">
                            <div class="col col-lg-8 mb-4">
                                <div class="row">
                                    <h4 id="titleEvents" class="d-flex justify-content-center">Upcoming Events</h4>
                                    <div class="col-lg-4 items-controller d-flex justify-content-center">
                                        <select name="itemschoices" id="itemperpage" style="height:30px; margin-top:15px;">
                                            <option value="05" selected>05</option>
                                            <option value="10">10</option>
                                            <option value="15">15</option>
                                        </select>
                                        <h6 class="d-flex align-items-center" style="margin-left:8px; margin-top:15px;"> Records Shown</h6>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="input-group d-flex justify-content-center">
                                            <div class="search-box" style="margin-top:13px;">
                                                <input id="search" type="search" placeholder="Search" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div style="height:20px;"></div>

                                <div class="section-list">
                                    <div class="table-container">
                                        <table id="dataTable" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Proposed Official</th>
                                                    <th>Event</th>
                                                    <th>Event Date</th>
                                                    <th>Event Location</th>
                                                    <th>Description</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($events_result as $event_row) { ?>
                                                    <tr>
                                                        <td><?php echo $event_row['Off_Pos'] . ' ' . $event_row['Off_CName']; ?></td>
                                                        <td><?php echo $event_row['Event_Name']; ?></td>
                                                        <td><?php echo $event_row['Event_Date']; ?></td>
                                                        <td><?php echo $event_row['Event_Location']; ?></td>
                                                        <td><?php echo $event_row['Event_Description']; ?></td>
                                                        <td><?php echo $event_row['Event_Status']; ?></td>
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
                            <!-- Rest of the dashboard content -->
                            <div class="col col-lg-4">
                                <div class="row" id="calendar">
                                    <header>
                                        <p class="current-date"></p>
                                        <div class="icons">
                                            <span id="prev" class="material-symbols-rounded">chevron_left</span>
                                            <span id="next" class="material-symbols-rounded">chevron_right</span>
                                        </div>
                                    </header>
                                    <div class="calendar">
                                        <ul class="weeks">
                                            <li>Sun</li>
                                            <li>Mon</li>
                                            <li>Tue</li>
                                            <li>Wed</li>
                                            <li>Thu</li>
                                            <li>Fri</li>
                                            <li>Sat</li>
                                        </ul>
                                        <ul class="days"></ul>
                                    </div>
                                </div>
                                <div class="row" id="to-do">
                                    <div class="todo-app">
                                        <h4>
                                            To-Do List
                                        </h4>
                                        <div class="col">
                                            <div class="row">
                                                <input type="text" id="input-box" placeholder="Add your task">


                                                <button onclick="addTask()">
                                                    <i class="lni lni-plus"></i>
                                                </button>

                                            </div>
                                        </div>

                                        <ul id="list-container">

                                        </ul>
                                    </div>
                                </div>
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
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE JS -->
        <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
    </body>
    <script src="../../script/script.js"></script>
    </body>

</html>
<?php }
?>