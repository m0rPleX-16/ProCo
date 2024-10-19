<?php
// Start session
session_start();
if (!isset($_SESSION["staff_email"]) || $_SESSION["staff_role"] !== 'Staff' && $_SESSION["status"] !== 'On Going Term') {
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="../../images/pcLogo.png">
    <title>Officials | Profile Connect</title>
    <link rel="stylesheet" href="./css/off-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="wrapper">
        <?php include '../sidebar.php'; ?>
        <!-- Navigation Bar -->
        <div class="main">
            <?php include '../navbar.php'; ?>

            <main class="content px-3 py-4">
                <div class="container-fluid">
                    <h2 class="fw-bold fs-4 mb-2">Barangay Officials</h2>
                    <div class="buttons-container text-end mb-4">
                        <a id="viewButton" type="button" class="btn btn-primary" href="official_tree.php">Tree View</a>
                    </div>
                    <div class="section-list">
                        <div class="table-responsive table-container">
                            <table id="dataTable" class="table table-hover mx-auto"> <!-- Added mx-auto class for centering -->
                                <thead>
                                    <tr class="table-header">
                                        <th scope="col">Position</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Contact</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Term Start</th>
                                        <th scope="col">Term End</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($result as $row) : ?>
                                    <tr>
                                        <td id="tdTable"><?php echo $row['Off_Pos']; ?></td>
                                        <td id="tdTable"><?php echo $row['Off_CName']; ?></td>
                                        <td id="tdTable"><?php echo $row['Off_Contact']; ?></td>
                                        <td id="tdTable"><?php echo $row['Off_Address']; ?></td>
                                        <td id="tdTable"><?php echo $row['Off_TermStart']; ?></td>
                                        <td id="tdTable"><?php echo $row['Off_TermEnd']; ?></td>
                                        <td id="tdTable"><?php echo $row['Off_Status']; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <?php include "../../include/footer.php" ?>
        </div>
    </div>
</body>

</html>
<?php }
?>
