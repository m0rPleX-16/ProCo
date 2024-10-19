<?php
// Include your database connection file here
include_once('../DbConnection.php');

// Create a new instance of the DbConnection class
$dbConnection = new DbConnection();
$conn = $dbConnection->getConnection();

if (isset($_POST['query'])) {
    $query = $_POST['query'];
    $sql = "SELECT id, Res_Fname, Res_Mname, Res_Lname, email FROM residents_tb WHERE Res_Fname LIKE '%$query%' OR Res_Lname LIKE '%$query%'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<a href="#" class="list-group-item list-group-item-action resIDItem" data-email="'.$row['email'].'" data-id="'.$row['id'].'" data-name="'.$row['Res_Lname'].', '.$row['Res_Fname'].' '.$row['Res_Mname'].'">'.$row['id'].' - '.$row['Res_Lname'].', '.$row['Res_Fname'].' '.$row['Res_Mname'].'</a>';
            }
        } else {
            echo '<div class="list-group-item">No results found</div>';
        }
    } else {
        echo '<div class="list-group-item">Error: '.mysqli_error($conn).'</div>';
    }
}
?>
