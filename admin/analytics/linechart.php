<?php 
// Function to retrieve population growth data
function getPopulationGrowthData($conn) {
    $sql = "SELECT YEAR(Res_Birth) AS Year, COUNT(*) AS Population FROM residents_tb GROUP BY YEAR(Res_Birth)";
    $result = $conn->query($sql);
    $data = array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = array($row['Year'], (int)$row['Population']);
        }
    }

    return $data;
}

$populationGrowthData = getPopulationGrowthData($conn);
?>

<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawCharts);

    function drawCharts() {
        // Line Chart Data
        var lineChartData = new google.visualization.DataTable();
        lineChartData.addColumn('string', 'Year');
        lineChartData.addColumn('number', 'Population');
        lineChartData.addRows(<?php echo json_encode($populationGrowthData); ?>);

        var lineChartOptions = {
            title: 'Population Growth',
            curveType: 'function',
            backgroundColor: '#FDF8F3',
            legend: {
                position: 'bottom'
            },
            colors: ['#0C3B2E'],
            fontName: 'Poppins'
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        lineChart.draw(lineChartData, lineChartOptions);
    }
</script>
