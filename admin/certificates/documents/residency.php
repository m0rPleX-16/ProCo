<div class="col-10 mx-auto">
    <div style="height:50px;"></div>
    <p class="text-center" style="font-size: 24px; ">OFFICE OF THE BARANGAY CAPTAIN<br>
        <b style="font-size: 38px;">CERTIFICATE OF RESIDENCY</b>
    </p>
    <div style="height:50px;"></div>

    <p style="font-size: 21px; text-align:left;"><i>TO WHOM IT MAY CONCERN:</i></p>
    <div style="height:30px;"></div>

    <p style="font-size:21px;text-indent:40px;text-align: justify;">
        This is to certify that
        <?php
        $qry = mysqli_query($conn, "SELECT * FROM residents_tb r LEFT JOIN certificate_tb c ON c.Res_ID = r.id WHERE Res_ID = '" . $_GET['residentname'] . "' and certID = '" . $_SESSION['clr'] . "' ");
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
        <br><br>
    </p>
    <p style="font-size:21px;text-indent:40px;text-align: justify;">
        Based on records of this office, she/he has been residing at Barangay Catalunan Grande, Talomo District, Davao City. <br> <br>
    </p>
    <p style="font-size:21px;text-indent:40px;text-align: justify;">
        This <b>CERTIFICATION</b> is being issued upon the request of the above-named person for whatever legal purpose it may serve. <br> <br>
    </p>
    <p style="font-size:21px;text-indent:40px;text-align: justify;">
        Issued this
        <?php
        $qry = mysqli_query($conn, "SELECT * FROM residents_tb r LEFT JOIN certificate_tb c ON c.Res_ID = r.id WHERE Res_ID = '" . $_GET['residentname'] . "' and certID = '" . $_SESSION['clr'] . "' ");
        while ($row = mysqli_fetch_assoc($qry)) {
            $bdate = date_create($row['Res_Birth']);
            $date = date_create($row['Issue_Date']);
            echo ' <b>
                                ' . strtoupper(date_format($date, "F j, o")) . ' </b>
                                ';
        }
        ?>
        at Barangay Catalunan Grande, Talomo District, Davao City, Philippines.
        <br>
    </p>
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