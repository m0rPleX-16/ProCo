<?php
ob_start();

// Including the database connection file
include_once('../../include/Crud.php');
$crud = new Crud();

// Fetch officials data
$sql = "SELECT * FROM officials_tb";
$result = $crud->read($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>  
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" type="image/x-icon" href="images/pcLogo.png">
    <title>Officials | Profile Connect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100..900;1,100..900&family=Silkscreen:wght@400;700&display=swap" rel="stylesheet">
</head>

<body style="background-color:#EFE9E1;">
    
    <div class="container">
        <div style="height:30px;"></div>
        <button id="returnBtn" class="btn btn-primary" onclick="window.location.href='officials.php'" 
        style="margin-left:20px; font-family:'Poppins', sans-serif; border-radius:8px; width:220px; height:40px; font-size:1rem; border-color:#5A70A7;
        background-color: #5A70A7; color:#FDF8F3; font-weight:700; border:none; cursor: pointer;"
        >Return to Officials</button>
        <center>
            <h2 id="officialsTitle" style="	color:#0C3B2E;">Officials' Tree</h2>
        </center>
  
        <div class="row">
            <div class="tree">
                <ul>
                    <?php
                    // Fetch all officials
                    while ($row = mysqli_fetch_assoc($result)) {
                        $position = $row['Off_Pos'];
                        $fullname = $row['Off_CName'];
                        $image = "../../offImg/" . $row['Off_Img']; // Construct the image source path

                        // Check position and create hierarchy
                        if ($position === 'Barangay Captain') {
                            echo "<li><a href='#'><img src='{$image}'><span>Barangay Captain</span><br>{$fullname}</a>";
                            echo "<ul>";
                            // Fetch Secretary and Treasurer under Barangay Captain
                            $sql_sec_treas = "SELECT * FROM officials_tb WHERE Off_Pos IN ('Barangay Secretary', 'Barangay Treasurer')";
                            $result_sec_treas = $crud->read($sql_sec_treas);
                            while ($row_sec_treas = mysqli_fetch_assoc($result_sec_treas)) {
                                $fullname_sec_treas = $row_sec_treas['Off_CName'];
                                $image_sec_treas = "../../offImg/" . $row_sec_treas['Off_Img'];
                                $position_sec_treas = $row_sec_treas['Off_Pos'];
                                echo "<li><a href='#'><img src='{$image_sec_treas}'><span>{$position_sec_treas}</span><br>{$fullname_sec_treas}</a></li>";
                            }
                            echo "</ul>";
                            // Start Kagawads branch
                            echo "<ul>";
                        } elseif ($position === 'Kagawad (Ordinance)' || $position === 'Kagawad (Public Safety)' || $position === 'Kagawad (Tourism)' || $position === 'Kagawad (Budget & Finance)' || $position === 'Kagawad (Agriculture)' || $position === 'Kagawad (Education)' || $position === 'Kagawad (Infrastructure)') {
                            echo "<li><a href='#'><img src='{$image}'><span>Kagawad</span><br>{$fullname}</a></li>";
                        }
                    }
                    ?>
                    </li>
                </ul>
                <?php
                // Fetch SK Chairman separately and display at the bottom
                $sql_sk_chairman = "SELECT * FROM officials_tb WHERE Off_Pos = 'SK Chairman'";
                $result_sk_chairman = $crud->read($sql_sk_chairman);
                while ($row_sk_chairman = mysqli_fetch_assoc($result_sk_chairman)) {
                    $fullname_sk_chairman = $row_sk_chairman['Off_CName'];
                    $image_sk_chairman = "../../offImg/" . $row_sk_chairman['Off_Img'];
                    echo "<ul>";
                    echo "<li><a href='#'><img src='{$image_sk_chairman}'><span>SK Chairman</span><br>{$fullname_sk_chairman}</a></li>";
                    echo "</ul>";
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>