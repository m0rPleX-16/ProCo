<div class="col-10 mx-auto">
    <div style="height:50px;"></div>
    <p class="text-center" style="font-size: 24px; ">OFFICE OF THE BARANGAY CAPTAIN<br>
        <b style="font-size: 38px;">CERTIFICATE OF LOW INCOME</b>
    </p>
    <div style="height:50px;"></div>

    <p style="font-size: 21px; text-align:left;"><i>TO WHOM IT MAY CONCERN:</i></p>
    <div style="height:30px;"></div>

    <p style="font-size:21px;text-indent:40px;text-align: justify;">
        This is to certify that
        <?php
        $qry = mysqli_query($conn, "SELECT r.Res_Lname, r.Res_Fname, r.Res_Mname, r.Res_Age, r.Res_Address, r.Res_Birth, c.Issue_Date, c.certID 
                                    FROM residents_tb r 
                                    LEFT JOIN certificate_tb c ON c.Res_ID = r.id 
                                    WHERE r.id = '" . $_GET['residentname'] . "' AND c.certID = '" . $_SESSION['clr'] . "'");
        if ($row = mysqli_fetch_assoc($qry)) {
            $bdate = date_create($row['Res_Birth']);
            $date = date_create($row['Issue_Date']);
            echo ' <b>' . strtoupper($row['Res_Lname']) . ', ' . strtoupper($row['Res_Fname']) . ' ' . strtoupper($row['Res_Mname']) . '</b>, ' . strtoupper($row['Res_Age']) . ' years old is a resident of Barangay <b>' . strtoupper($row['Res_Address']) . '</b>, Davao City.';
        } else {
            echo ' Resident information not found.';
        }
        ?>
        <br><br>
    </p>
    <p style="font-size:21px;text-indent:40px;text-align: justify;">
        This certification is being issued upon the request of above-named person for whatever legal purpose it may serve her/him best. <br> <br>
    </p>
    <p style="font-size:21px;text-indent:40px;text-align: justify;">
        Issued this
        <?php
        if (isset($row)) {
            echo ' <b>' . strtoupper(date_format($date, "F j, o")) . '</b> at the Office of the Barangay Captain, Barangay Catalunan Grande, Talomo District, Davao City, Philippines.';
        }
        ?>
        <br>
    </p>
    <div style="height:120px;"></div>
    <p style="font-size:21px; text-align:right;">
        <b>
            <?php
            $qry = mysqli_query($conn, "SELECT Off_CName FROM officials_tb WHERE Off_Pos = 'Barangay Captain'");
            if ($row = mysqli_fetch_assoc($qry)) {
                echo strtoupper($row['Off_CName']) . '<br>';
            }
            ?>
        </b>
        Barangay Captain
    </p>
    <div style="height:70px;"></div>
    <p style="font-size:21px; text-align:right;">
        <b>"Not valid if without official seal."</b>
    </p>

    <div style="height:40px;"></div>

    <p style="font-size:21px; text-align:left;">
        <b>AMOUNT PAID: 80.00 pesos</b>

        <br>
        O.R. No.:
        <?php
        if (isset($row)) {
            echo ' <b>' . strtoupper($row['ORNo']) . '</b>';
        }
        ?>
        <br>
    </p>
</div>
