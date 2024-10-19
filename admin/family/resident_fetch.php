<?php
// Include your database connection file here
include_once('../DbConnection.php');

// Create a new instance of the DbConnection class
$dbConnection = new DbConnection();
$conn = $dbConnection->getConnection();

if(isset($_POST["query"])) {
    $output = '';
    $query = "SELECT * FROM residents_tb WHERE Res_Lname LIKE '%".$_POST["query"]."%' OR Res_Fname LIKE '%".$_POST["query"]."%' OR Res_Mname LIKE '%".$_POST["query"]."%'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            // Debug: Log the row data
            error_log(print_r($row, true));
            // Output the resident ID and name in data attributes for easy retrieval
            $output .= '<li class="list-group-item resIDItem" data-id="'.$row["id"].'" data-name="'.$row["Res_Lname"].', '.$row["Res_Fname"].' '.$row["Res_Mname"].'">'.$row["Res_Lname"].', '.$row["Res_Fname"].' '.$row["Res_Mname"].'</li>';
        }
    } else {
        $output .= '<li class="list-group-item">No matching names found</li>';
    }

    echo $output;
}
?>
