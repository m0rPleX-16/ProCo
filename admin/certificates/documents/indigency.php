<div class="col-10 mx-auto">
    <div style="height:50px;"></div>
    <p class="text-center" style="font-size: 24px; ">OFFICE OF THE BARANGAY CAPTAIN<br>
        <b style="font-size: 38px;">CERTIFICATE OF INDIGENCY</b>
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
        of legal age, single/married/widow/widower and whose signature appears below, is a permanent resident of Barangay Catalunan Grande.
        <br><br>
    </p>
    <p style="font-size:21px;text-indent:40px;text-align: justify;">
        It is further certified that
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
        who is known to the undersigned, is a person of good character, a law-abiding citizen and has neither nor criminal record/s in this barangay as of this date and is one of the <b>INDIGENT</b> fellow in our community.
        <br><br>
    </p>
    <p style="font-size:21px;text-indent:40px;text-align: justify;">
        This certificate is being issued upon the request of the above-named person for whatever legal purpose it may serve him/her.
        <br>
    </p>
    <p style="font-size:21px;text-indent:40px;text-align: justify;">
        Done and issued this day of
        <?php
        $qry = mysqli_query($conn, "SELECT * FROM residents_tb r LEFT JOIN certificate_tb c ON c.Res_ID = r.id WHERE Res_ID = '" . $_GET['residentname'] . "' and certID = '" . $_SESSION['clr'] . "' ");
        while ($row = mysqli_fetch_assoc($qry)) {
            $bdate = date_create($row['Res_Birth']);
            $date = date_create($row['Issue_Date']);
            echo ' <b>
                                ' . strtoupper(date_format($date, "F j, o")) . '.
                                </b>
                                ';
        }
        ?>
        At Barangay Catalunan Grande.
        <br>
    </p>
    <div style="height:120px;"></div>
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

    <div style="height:80px;"></div>

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
