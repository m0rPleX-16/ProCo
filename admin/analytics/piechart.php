<?php 
// Function to retrieve categorized demographic data
function getDemographicData($conn) {
    $sql = "
        SELECT 
            CASE 
                WHEN Res_Age BETWEEN 0 AND 3 THEN 'Toddlers & Infants'
                WHEN Res_Age BETWEEN 4 AND 5 THEN 'Preschoolers'
                WHEN Res_Age BETWEEN 6 AND 12 THEN 'Children'
                WHEN Res_Age BETWEEN 13 AND 19 THEN 'Teenagers'
                WHEN Res_Age BETWEEN 20 AND 39 THEN 'Young Adults'
                WHEN Res_Age BETWEEN 40 AND 59 THEN 'Middle-aged Adults'
                ELSE 'Seniors'
            END AS Age_Category, 
            COUNT(*) AS Count 
        FROM residents_tb 
        GROUP BY Age_Category";
        
    $result = $conn->query($sql);
    $data = array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = array($row['Age_Category'], (int)$row['Count']);
        }
    }

    return $data;
}

$demographicData = getDemographicData($conn);
?>

<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawCharts);

    function drawCharts() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Demographic');
        data.addColumn('number', 'Population');
        data.addRows(<?php echo json_encode($demographicData); ?>);

        var options = {
            title: 'Demographic Population',
            pieHole: 0.4,
            backgroundColor: '#FDF8F3',
            fontName: 'Poppins',
            colors: ['#79B181', '#8179B1', '#CE9C63', '#CE6396']
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
    }
</script>