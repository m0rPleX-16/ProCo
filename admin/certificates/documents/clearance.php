<?php
// Ensure database connection is established
require_once '../DbConnection.php';
$dbConnection = new DbConnection();
$conn = $dbConnection->getConnection();
// Sanitize input
$residentname = isset($_GET['residentname']) ? intval($_GET['residentname']) : 0;
$clr = isset($_SESSION['clr']) ? intval($_SESSION['clr']) : 0;

// Fetch data from database
$qry = mysqli_query($conn, "
    SELECT 
        r.Res_Lname, r.Res_Fname, r.Res_Mname, r.Res_Birth,
        c.Purpose, c.Issue_Date, c.certID,
        o.Off_CName
    FROM 
        residents_tb r
    LEFT JOIN 
        certificate_tb c ON c.Res_ID = r.id
    LEFT JOIN 
        officials_tb o ON o.Off_Pos = 'Barangay Captain'
    WHERE 
        r.id = '$residentname' AND c.certID = '$clr'
");

if ($row = mysqli_fetch_assoc($qry)) {
    $bdate = date_create($row['Res_Birth']);
    $issue_date = date_create($row['Issue_Date']);
    $off_cname = strtoupper($row['Off_CName']);
    $res_name = strtoupper($row['Res_Lname'] . ', ' . $row['Res_Fname'] . ' ' . $row['Res_Mname']);
    $purpose = strtoupper($row['Purpose']);
    $cert_id = strtoupper($row['certID']);
    $formatted_issue_date = strtoupper(date_format($issue_date, "F j, o"));
} else {
    echo "No data found for the given resident and certificate.";
    exit;
}
?>

<div class="container">
    <div class="col-10 mx-auto">
        <div style="height:50px;"></div>
        <p class="text-center" style="font-size: 24px;">
            OFFICE OF THE BARANGAY CAPTAIN<br>
            <b style="font-size: 38px;">BARANGAY CLEARANCE</b>
        </p>
        <div style="height:50px;"></div>

        <p style="font-size: 21px; text-align:left;"><i>TO WHOM IT MAY CONCERN:</i></p>
        <div style="height:30px;"></div>

        <p style="font-size:21px;text-indent:40px;text-align: justify;">
            This is to certify that <b><?= $res_name ?></b>,
            of legal age, male/female/single/married/widow/widower with residence and postal address at Barangay Igpit, Opol, Misamis Oriental has no derogatory record filed in our Barangay Office.
            <br><br>
        </p>
        <p style="font-size:21px;text-indent:40px;text-align: justify;">
            The above-named individual who is a bonafide resident of this barangay is a person of good moral character, peace-loving, and civic-minded citizen. <br><br>
        </p>
        <p style="font-size:21px;text-indent:40px;text-align: justify;">
            This clearance is hereby issued in connection with the subject's application for <b><?= $purpose ?></b>,
            and for whatever legal purpose it may serve her/his best.
            <br>
        </p>
        <div style="height:120px;"></div>
        <p style="font-size:21px; text-align:right;">
            <b><?= $off_cname ?></b><br>
            Barangay Captain
        </p>

        <div style="height:80px;"></div>

        <p style="font-size:21px; text-align:left;">
            ___________________ <br>
            Signature of Applicant
        </p>
        <div style="height:40px;"></div>

        <p style="font-size:21px; text-align:left;">
            CTC No.: <b><?= $cert_id ?></b><br>
            Issued at: <b>Catalunan Grande OFFICE</b><br>
            Issued on: <b><?= $formatted_issue_date ?></b><br>
        </p>
    </div>
</div>
