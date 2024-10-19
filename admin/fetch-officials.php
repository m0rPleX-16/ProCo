<?php
// Include the database connection file
include_once('DbConnection.php');

// Create a new instance of the DbConnection class
$dbConnection = new DbConnection();
$connection = $dbConnection->getConnection();

// SQL query to fetch officials' data
$sql = "SELECT offID, Off_CName FROM officials_tb";

// Execute the query
$result = $connection->query($sql);

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Fetch the rows and store them in an array
    $officials = array();
    while ($row = $result->fetch_assoc()) {
        $officials[] = $row;
    }
    // Encode the array as JSON and output it
    echo json_encode($officials);
} else {
    // If no rows were returned, output an empty array
    echo json_encode([]);
}
?>
