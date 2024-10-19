<?php
// Include your database connection file here
include_once('../DbConnection.php');

// Create a new instance of the DbConnection class
$dbConnection = new DbConnection();
$conn = $dbConnection->getConnection();

if(isset($_POST["query"])) {
    $output = '';
    $query = "SELECT * FROM families_tb WHERE Fam_LName LIKE ?";
    $stmt = $conn->prepare($query);
    $searchTerm = '%' . $_POST["query"] . '%';
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $output .= '<li class="list-group-item familyIDItem" data-id="'.$row["id"].'">'.$row['id'].' - '.$row["Fam_LName"].'</li>';
        }
    } else {
        $output .= '<li class="list-group-item">No matching names found</li>';
    }

    echo $output;
}
?>
