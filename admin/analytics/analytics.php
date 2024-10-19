<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (!isset($_SESSION['admin_role']) || ($_SESSION['admin_role'] !== 'Administrator' && $_SESSION['admin_role'] !== 'Captain' && $_SESSION['admin_role'] !== 'Kagawad')) {
    header("Location: ../../login.php");
} else {
    ob_start();
    include_once '../DbConnection.php'; // Include the database connection file for image upload
    include_once '../../include/Crud.php';
    $dbConnection = new DbConnection();
    $conn = $dbConnection->getConnection();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="images/pcLogo.png">
    <title>Analytics | Profile Connect</title>
    <link rel="stylesheet" href="css/ana-style.css">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <!-- google charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.4/raphael-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
</head>

<body>
    <div class="wrapper">
        <?php include '../sidebar.php'; ?>
        <!-- Navigation Bar -->
        <div class="main">
            <?php include '../navbar.php'; ?>

            <main class="content px-3 py-4">
                <div class="container-fluid">
                    <h2 class="fw-bold fs-4 mb-3">Analytics and Reports</h2>
                    <hr>
                    <div class="row mb-2">
                        <div class="col-lg-7 mb-2" style="background-color: #FDF8F3; margin: 0 auto 20px;width: 100%;max-width:600px; border-radius:10px; box-shadow: 0 15px 40px rgba(12, 59, 46, 0.12)">
                            <div id="curve_chart" class="chart-container-curve"></div>
                        </div>
                        <div class="col-lg-5 mb-2" style="background-color: #FDF8F3; margin: 0 auto 20px;width: 100%;max-width:600px; border-radius:10px; box-shadow: 0 15px 40px rgba(12, 59, 46, 0.12);">
                            <div id="donutchart" class="chart-container-donut" ></div>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-lg-4 col-sm-12 mb-2" style="background-color: #FDF8F3; margin: 0 auto 20px;width:100%; max-width:400px; border-radius:10px; box-shadow: 0 15px 40px rgba(12, 59, 46, 0.12);">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <b style="font-size: 13px;">Resident Educational Attainment</b>
                                </div>
                                <div class="panel-body">
                                    <div id="morris-donut-chart1"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12 mb-2" style="background-color: #FDF8F3; margin: 0 auto 20px;width:100%;max-width:400px; border-radius:10px; box-shadow: 0 15px 40px rgba(12, 59, 46, 0.12);">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <b style="font-size: 13px;">Household Types by Family</b>
                                </div>
                                <div class="panel-body">
                                    <div id="morris-donut-chart2"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12 mb-2" style="background-color: #FDF8F3; margin: 0 auto 20px;width:100%;max-width:400px; border-radius:10px; box-shadow: 0 15px 40px rgba(12, 59, 46, 0.12);">
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <b style="font-size: 13px;">Families Income Level</b>
                                </div>
                                <div class="panel-body">
                                    <div id="morris-bar-chart1"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                            <div class="table-container mb-5">
                                <div class="col-md-8 mx-auto">
                                    <div class="buttons-container text-end">
                                        <form action="export.php" method="POST">
                                            <button class="btn" id="btnExport" type="submit" name="export" title="Export Reports and Analytics Data"
                                            ><i>Export File</i> <i class="lni lni-arrow-down-circle"></i> </button>
                                        </form>
                                    </div>
                                    <table class="table">
                                        <tbody>
                                            <?php
                                            // Query to get the required data from residents_tb
                                            $query = "SELECT AVG(Res_Age) AS AverageAge,
                                                            SUM(CASE WHEN Res_Age < 18 THEN 1 ELSE 0 END) AS TotalUnderage,
                                                            SUM(CASE WHEN Res_Age BETWEEN 18 AND 24 THEN 1 ELSE 0 END) AS TotalTeens,
                                                            SUM(CASE WHEN Res_Age BETWEEN 25 AND 64 THEN 1 ELSE 0 END) AS TotalAdults,
                                                            SUM(CASE WHEN Res_Age >= 65 THEN 1 ELSE 0 END) AS TotalSeniors,
                                                            SUM(CASE WHEN Res_Sex = 'Male' THEN 1 ELSE 0 END) AS TotalMale,
                                                            SUM(CASE WHEN Res_Sex = 'Female' THEN 1 ELSE 0 END) AS TotalFemale,
                                                            COUNT(*) AS TotalPopulation
                                                    FROM residents_tb";

                                            // Execute the query
                                            $result = $conn->query($query);

                                            // Check if query execution was successful
                                            if ($result && $result->num_rows > 0) {
                                                // Fetch data and populate the table
                                                $row = $result->fetch_assoc();
                                                echo "<tr>
                                                            <td class='tdHead'>Average Age</td>
                                                            <td class='tdContent'>" . round($row['AverageAge'], 1) . " Years Old</td>
                                                    </tr>";
                                                echo "<tr>
                                                            <td class='tdHead'>Total Underage</td>
                                                            <td class='tdContent'>" . $row['TotalUnderage'] . " - Children</td>
                                                    </tr>";
                                                echo "<tr>
                                                            <td class='tdHead'>Total Teens</td>
                                                            <td class='tdContent'>" . $row['TotalTeens'] . " - Young People</td>
                                                    </tr>";
                                                echo "<tr>
                                                            <td class='tdHead'>Total Adults</td>
                                                            <td class='tdContent'>" . $row['TotalAdults'] . " - Adults</td>
                                                    </tr>";
                                                echo "<tr>
                                                            <td class='tdHead'>Total Senior</td>
                                                            <td class='tdContent'>" . $row['TotalSeniors'] . " - Seniors</td>
                                                    </tr>";
                                                echo "<tr>
                                                            <td class='tdHead'>Total Male Population</td>
                                                            <td class='tdContent'>" . $row['TotalMale'] . " - Males</td>
                                                    </tr>";
                                                echo "<tr>
                                                            <td class='tdHead'>Total Female Population</td>
                                                            <td class='tdContent'>" . $row['TotalFemale'] . " - Females</td>
                                                    </tr>";
                                                echo "<tr>
                                                            <td class='tdHead'>Total Population</td>
                                                            <td class='tdContent'>" . $row['TotalPopulation'] . " - Population</td>
                                                    </tr>";
                                            } else {
                                                // No data found
                                                echo "<tr><td colspan='2' class='text-center'>No Record(s) Found!</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
            </main>
            <?php include "../../include/footer.php"; ?>
        </div>
    </div>
    <?php
    include "donutchart.php";
    include "barchart.php";
    include "linechart.php";
    include "piechart.php";
    ?>
</body>

</html>
<?php }
?>