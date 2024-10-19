<?php
if (isset($_POST['export'])) {

    include ('connection.php');


    $SQL1 = "SELECT COUNT(*) as NumberofHousehold, ROUND(Fam_Income,-1) as Income FROM families_tb GROUP BY Fam_Income";
    $SQL2 = "SELECT COUNT(*) as NumberofHousehold, Household_Type FROM household_tb GROUP BY Household_Type";
    $SQL3 = "SELECT COUNT(*) as NumberofResident , Res_Age FROM residents_tb GROUP BY Res_Age";
    $SQL4 = "SELECT COUNT(*) as NumberofResident, Res_Education FROM residents_tb GROUP BY Res_Education";

    $arrsql = array($SQL1, $SQL2, $SQL3, $SQL4);
    $arrhead = array("Families Income Level", "Number of Households per Type", "Age", "Resident Educational Attainment");
    
    // Create a new instance of mysqli
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    
    foreach (array_combine($arrsql, $arrhead) as $value => $headers) {
        $header = "$headers\n";
        $result = '';

        // Execute the query
        $exportData = $conn->query($value) or die("Sql error : " . $conn->error);

        // Get the number of fields
        $fields = $exportData->field_count;

        // Get field names
        $field_names = [];
        while ($field_info = $exportData->fetch_field()) {
            $field_names[] = $field_info->name;
        }
        $header .= implode("\t", $field_names) . "\n";

        // Fetch data
        while ($row = $exportData->fetch_row()) {
            $line = '';
            foreach ($row as $value) {
                if ((!isset($value)) || ($value == "")) {
                    $value = "\t";
                } else {
                    $value = str_replace('"', '""', $value);
                    $value = '"' . $value . '"' . "\t";
                }
                $line .= $value;
            }
            $result .= trim($line) . "\n";
        }
        $result = str_replace("\r", "", $result);

        if ($result == "") {
            $result = "\nNo Record(s) Found!\n";
        }

        // Output headers and data
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=barangay.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        print "$header\n$result\n\n";
    }
    // Close connection
    $conn->close();
}
?>
