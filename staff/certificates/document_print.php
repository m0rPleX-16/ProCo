<!DOCTYPE html>
<html id="document">

<head>
    <style>
        @media print {
            .noprint {
                visibility: hidden;
            }
        }

        @page {
            size: auto;
            margin: 4mm;
        }
    </style>
    <link rel="shortcut icon" type="x-icon" href="images/pcLogo.png">
    <title>Print Document</title>
</head>

<body class="skin-black">
    <?php
    session_start();
    require_once('../DbConnection.php');
    include_once('../../include/Crud.php');

    // Include necessary files and initialize objects
    $dbConnection = new DbConnection();
    $crud = new Crud();
    $conn = $dbConnection->getConnection();

    if (!isset($_SESSION['role'])) {
        header("Location: ../../login.php");
        exit; // Add exit to stop further execution if redirecting
    }

    ob_start();

    // Sanitize and set session variables
    if (isset($_GET['certID']) && isset($_GET['Document_Type'])) {
        $_SESSION['clr'] = filter_var($_GET['certID'], FILTER_SANITIZE_SPECIAL_CHARS);
        $_SESSION['Document_Type'] = filter_var($_GET['Document_Type'], FILTER_SANITIZE_SPECIAL_CHARS);
    } else {
        echo "certID or Document_Type not provided.";
        exit; // Add exit to stop further execution if parameters are missing
    }

    include_once('../main_css.php');
    ?>
    <!-- Your HTML content here -->
    <div class="container">
        <div class="col" style="font-family:'Times New Roman', serif;">
            <div class="row">
                <div style="height:20px;"></div>
                <div class="col-4 d-flex justify-content-start">
                    <img src="../../images/logo.webp" style="width:160px;height:160px;">
                </div>
                <div class="col-4 text-center" style="font-size: 21px;"><b>
                        <div style="height:10px;"></div>
                        <p style="font-family:'Old English Text MT', serif; margin:0;">Republic of the Philippines</p>
                        Municipality of Davao<br>
                        Province of Davao Del Sur<br>
                        BARANGAY CATALUNAN GRANDE<br>
                        Tel. 999-0000<br>
                    </b>
                </div>
                <div class="col-4 d-flex justify-content-end">
                    <div style="height:30px;"></div>
                    <img src="../../images/lungsodngdavao.png" style="width:160px;height:160px;">
                </div>
            </div>
            <div class="row" style="margin-top:20px; text-align: center; word-wrap: break-word;">
                <?php
                $qry = mysqli_query($conn, "SELECT * from officials_tb");
                while ($row = mysqli_fetch_assoc($qry)) {
                    $position = htmlspecialchars($row['Off_Pos']);
                    $name = htmlspecialchars($row['Off_CName']);
                    switch ($position) {
                        case "Captain":
                            echo '<p><b>' . strtoupper($name) . '</b><br><span style="font-size:12px;">PUNONG BARANGAY</span></p>';
                            break;
                        case "Kagawad(Ordinance)":
                            echo '<p>KAG. ' . strtoupper($name) . '<br><span style="font-size:12px;">Sports / Law / Ordinance</span></p>';
                            break;
                        case "Kagawad(Public Safety)":
                            echo '
                                    <p>
                                        KAG. ' . strtoupper($name) . '<br>
                                        <span style="font-size:12px;">Public Safety / Peace and Order</span>
                                    </p>
                                    ';
                            break;
                        case "Kagawad(Tourism)":
                            echo '
                                    <p>
                                        KAG. ' . strtoupper($name) . '<br>
                                        <span style="font-size:12px;">Culture & Arts / Tourism / Womens Sector</span>
                                    </p>
                                    ';
                            break;
                        case "Kagawad(Budget & Finance)":
                            echo '
                                    <p>
                                        KAG. ' . strtoupper($name) . '<br>
                                        <span style="font-size:12px;">Budget & Finance / Electrification</span>
                                    </p>
                                    ';
                            break;
                        case "Kagawad(Agriculture)":
                            echo '
                                    <p>
                                        KAG. ' . strtoupper($name) . '<br>
                                        <span style="font-size:12px;">Agriculture / Livelihood / Farmers Sector / PWD Sector</span>
                                    </p>
                                    ';
                            break;
                        case "Kagawad(Education)":
                            echo '
                                    <p>
                                        KAG. ' . strtoupper($name) . '<br>
                                        <span style="font-size:12px;">Health & Sanitation / Education</span>
                                    </p>
                                    ';
                            break;
                        case "Kagawad(Infrastructure)":
                            echo '
                                    <p>
                                        KAG. ' . strtoupper($name) . '<br>
                                        <span style="font-size:12px;">Infrastructure / Labor Sector / Environment / Beautification</span>
                                    </p>
                                    ';
                            break;
                            // Add cases for other positions
                    }
                }
                ?>
            </div>
            <?php
            $documentType = $_SESSION['Document_Type']; // Use the selected document type

            switch ($documentType) {
                case 'Clearance':
                    include 'documents/clearance.php';
                    break;
                case 'Indigency':
                    include 'documents/indigency.php';
                    break;
                case 'Low Income':
                    include 'documents/low_income.php';
                    break;
                case 'Residency':
                    include 'documents/residency.php';
                    break;
                case 'CEDULA':
                    include 'documents/cedula.php';
                    break;
                default:
                    echo "Invalid document type.";
                    break;
            }
            ?>
        </div>
    </div>

    <!-- Print Button -->
    <div class="text-center">
        <div class="col-12 d-flex justify-content-center">
            <button class="btn btn-primary noprint" id="printpagebutton" onclick="PrintElem('#document')" style="width:400px; height:60px; font-weight:bold; font-size:1.3rem;
                color:#EFE9E1; background:#0C3B2E; border:none; border-radius:30px;" onMouseOver="this.style.color='#FFBA00' " onMouseOut="this.style.color='#EFE9E1'">
                Print Transaction
            </button>
        </div>
    </div>
    <script>
        function PrintElem(elem) {
            window.print();
        }

        function Popup(data) {
            var mywindow = window.open('', 'my div', 'height=400,width=600');
            //mywindow.document.write('<html><head><title>my div</title>');
            /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
            //mywindow.document.write('</head><body class="skin-black" >');
            var printButton = document.getElementById("printpagebutton");
            //Set the print button visibility to 'hidden' 
            printButton.style.visibility = 'hidden';
            mywindow.document.write(data);
            //mywindow.document.write('</body></html>');

            mywindow.document.close(); // necessary for IE >= 10
            mywindow.focus(); // necessary for IE >= 10

            mywindow.print();

            printButton.style.visibility = 'visible';
            mywindow.close();

            return true;
        }
    </script>

</body>

</html>
