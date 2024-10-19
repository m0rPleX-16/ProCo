<!DOCTYPE html>
<html id="clearance">

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
    $_SESSION['clr'] = filter_var($_GET['clearance']);
    include_once('../main_css.php'); ?>
    <div class="container">
        <div class="col" style="font-family:'Times New Roman', serif;">
        
                <div class="row">
                    <div style="height:20px;"></div>
                    <div class="col-3 mt-3 d-flex justify-content-start">
                        <img src="../../images/logo.webp" style="width:160px;height:160px;" >
                    </div>
                    <div class="col-6 text-center " style="font-size: 21px;">
                        <div style="height:10px;"></div>
                                <p style="font-family:'Old English Text MT', serif; margin:0;">Republika ng Pilipinas</p>
                                <b>TANGGAPAN NG PUNONG BARANGAY</b><br>
                                Barangay Catalunan Grande<br>
                                Distrito ng Talomo<br>
                                Lungsod ng Dabaw <br>
                                Tel No. 299-1097/Hotline:09327369036<br>
                        </div>
                    <div class="col-3 mt-3 d-flex justify-content-end">
                        <div style="height:30px;"></div>
                        <img src="../../images/lungsodngdavao.png" style="width:160px;height:160px;" >
                    </div>
                </div>
                <div style="height:20px;"></div>
               
                    
                    <div class="row" style="margin-top:20px; text-align: center; word-wrap: break-word;">
                        <?php
                        $qry = mysqli_query($conn, "SELECT * from officials_tb");
                        while ($row = mysqli_fetch_assoc($qry)) {
                            $position = htmlspecialchars($row['Off_Pos']);
                            $name = htmlspecialchars($row['Off_CName']);
                            switch ($position) {
                                case "Captain":
                                    echo '
                                <p>
                                    <b>' . strtoupper($name) . '</b><br>
                                    <span style="font-size:12px;">PUNONG BARANGAY</span>
                                </p>
                                ';
                                    break;
                                case "Kagawad(Ordinance)":
                                    echo '
                                <p>
                                    KAG. ' . strtoupper($name) . '<br>
                                    <span style="font-size:12px;">Sports / Law / Ordinance</span>
                                </p>
                                ';
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
                            }
                        }
                        ?>
                    </div>
                

                    <div class="col-10 mx-auto">
                        <div style="height:50px;"></div>
                        <p class="text-center" style="font-size: 24px; ">OFFICE OF THE BARANGAY CAPTAIN<br>
                        <b style="font-size: 38px;">CERTIFICATE OF RESIDENCY</b></p>
                        <div style="height:50px;"></div>

                        <p style="font-size: 21px; text-align:left;"><i>TO WHOM IT MAY CONCERN:</i></p>
                        <div style="height:30px;"></div>

                        <p style="font-size:21px;text-indent:40px;text-align: justify;">
                            This is to certify that 
                            <?php
                            $qry = mysqli_query($conn, "SELECT * FROM residents_tb r LEFT JOIN certificate_tb c ON c.Res_ID = r.id WHERE Res_ID = '" . $_GET['resident'] . "' and certID = '" . $_SESSION['clr'] . "' ");
                            while ($row = mysqli_fetch_assoc($qry)) {
                                $bdate = date_create($row['Res_Birth']);
                                $date = date_create($row['Issue_Date']);
                                echo ' <b>
                                ' . strtoupper($row['Res_Lname']) . ',
                                        ' . strtoupper($row['Res_Fname']) . '
                                    ' . strtoupper($row['Res_Mname']) . '</b>,
                                ';
                                }
                            ?>
                            of legal age, male/female/single/married/widow/widower, whose specimen signature appears below, is a <b>PERMANENT RESIDENT</b> of this Barangay Catalunan Grande, Talomo District, Davao City.
                        <br><br> </p>
                        <p style="font-size:21px;text-indent:40px;text-align: justify;">
                            Based on records of this office, she/he has been residing at Barangay Catalunan Grande, Talomo District, Davao City. <br> <br>
                        </p>
                        <p style="font-size:21px;text-indent:40px;text-align: justify;">
                            This <b>CERTIFICATION</b> is being issued upon the request of the above-named person for whatever legal purpose it may serve. <br> <br>
                        </p>
                        <p style="font-size:21px;text-indent:40px;text-align: justify;">
                            Issued this 
                            <?php
                            $qry = mysqli_query($conn, "SELECT * FROM residents_tb r LEFT JOIN certificate_tb c ON c.Res_ID = r.id WHERE Res_ID = '" . $_GET['resident'] . "' and certID = '" . $_SESSION['clr'] . "' ");
                            while ($row = mysqli_fetch_assoc($qry)) {
                                $bdate = date_create($row['Res_Birth']);
                                $date = date_create($row['Issue_Date']);
                                echo ' <b>
                                ' . strtoupper(date_format($date, "F j, o")) . ' </b>
                                ';
                                }
                            ?>
                            at Barangay Catalunan Grande, Talomo District, Davao City, Philippines.
                        <br></p>
                        <div style="height:50px;"></div>
                            <p style="font-size:21px; text-align:right;">
                            <b>
                                <?php
                                $qry = mysqli_query($conn, "SELECT * FROM officials_tb WHERE Off_Pos = 'Barangay Captain'");
                                while ($row = mysqli_fetch_assoc($qry)) {
                                    echo '
                                    ' . strtoupper($row['Off_CName']) . '<br>
                                    ';
                                }
                                ?>
                            </b>    
                            Barangay Captain
                            </p>
                        
                        <div style="height:30px;"></div>

                        <p style="font-size:21px; text-align:left;">
                        ___________________ <br>
                        Signature of Applicant
                        </p>
                        <div style="height:40px;"></div>

                        <p style="font-size:21px; text-align:left;">
                            Note: <br>
                            "Not valid without official seal"

                        </p>
                        
                        

                        
                    </div>
                    
                </div>
        </div>
    </div>
    <div style="height:100px;"></div>
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <button class="btn btn-primary noprint" id="printpagebutton" onclick="PrintElem('#clearance')"
                style="width:400px; height:60px; font-weight:bold; font-size:1.3rem;
                color:#EFE9E1; background:#0C3B2E; border:none; border-radius:30px;"
                onMouseOver="this.style.color='#FFBA00' "
                onMouseOut="this.style.color='#EFE9E1'"
                >
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