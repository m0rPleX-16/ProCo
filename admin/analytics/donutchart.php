<script>
    Morris.Donut({
        element: 'morris-donut-chart1',
        data: [{
            label: "No schooling completed",
            value: <?php
                    $q = mysqli_query($conn, "SELECT * FROM residents_tb WHERE Res_Education = 'No schooling completed' ");
                    $numrow = mysqli_num_rows($q);
                    echo $numrow;
                    ?>
        }, {
            label: "Elementary",
            value: <?php
                    $q = mysqli_query($conn, "SELECT * FROM residents_tb WHERE Res_Education = 'Elementary' ");
                    $numrow = mysqli_num_rows($q);
                    echo $numrow;
                    ?>
        }, {
            label: "High school, undergraduate",
            value: <?php
                    $q = mysqli_query($conn, "SELECT * FROM residents_tb WHERE Res_Education = 'High school, undergraduate' ");
                    $numrow = mysqli_num_rows($q);
                    echo $numrow;
                    ?>
        }, {
            label: "High school graduate",
            value: <?php
                    $q = mysqli_query($conn, "SELECT * FROM residents_tb WHERE Res_Education = 'High school graduate' ");
                    $numrow = mysqli_num_rows($q);
                    echo $numrow;
                    ?>
        }, {
            label: "College, undergraduate",
            value: <?php
                    $q = mysqli_query($conn, "SELECT * FROM residents_tb WHERE Res_Education = 'College, undergraduate' ");
                    $numrow = mysqli_num_rows($q);
                    echo $numrow;
                    ?>
        }, {
            label: "Vocational",
            value: <?php
                    $q = mysqli_query($conn, "SELECT * FROM residents_tb WHERE Res_Education = 'Vocational' ");
                    $numrow = mysqli_num_rows($q);
                    echo $numrow;
                    ?>
        }, {
            label: "Bachelors degree",
            value: <?php
                    $q = mysqli_query($conn, "SELECT * FROM residents_tb WHERE Res_Education = 'Bachelors degree' ");
                    $numrow = mysqli_num_rows($q);
                    echo $numrow;
                    ?>
        }, {
            label: "Masters degree",
            value: <?php
                    $q = mysqli_query($conn, "SELECT * FROM residents_tb WHERE Res_Education = 'Masters degree' ");
                    $numrow = mysqli_num_rows($q);
                    echo $numrow;
                    ?>
        }, {
            label: "Doctorate degree",
            value: <?php
                    $q = mysqli_query($conn, "SELECT * FROM residents_tb WHERE Res_Education = 'Doctorate degree' ");
                    $numrow = mysqli_num_rows($q);
                    echo $numrow;
                    ?>
        }],
        resize: true,
        colors: ['#CE6396', '#CE9C63', '#79B181', '#8179B1','#55765A','#E4DF59','#56617D','#23C5B1', '#4C60C6']
    });
    Morris.Donut({
        element: 'morris-donut-chart2',
        data: [{
            label: "Apartment",
            value: <?php
                    $q = mysqli_query($conn, "SELECT * FROM household_tb WHERE Household_Type = 'Apartment' ");
                    $numrow = mysqli_num_rows($q);
                    echo $numrow;
                    ?>
        }, {
            label: "Condominium",
            value: <?php
                    $q = mysqli_query($conn, "SELECT * FROM household_tb WHERE Household_Type = 'Condominium' ");
                    $numrow = mysqli_num_rows($q);
                    echo $numrow;
                    ?>
        }, {
            label: "Room Rental",
            value: <?php
                    $q = mysqli_query($conn, "SELECT * FROM household_tb WHERE Household_Type = 'Room Rental' ");
                    $numrow = mysqli_num_rows($q);
                    echo $numrow;
                    ?>
        }, {
            label: "Shared Housing",
            value: <?php
                    $q = mysqli_query($conn, "SELECT * FROM household_tb WHERE Household_Type = 'Shared Housing' ");
                    $numrow = mysqli_num_rows($q);
                    echo $numrow;
                    ?>
        }, {
            label: "Mobile Housing",
            value: <?php
                    $q = mysqli_query($conn, "SELECT * FROM household_tb WHERE Household_Type = 'Mobile Housing' ");
                    $numrow = mysqli_num_rows($q);
                    echo $numrow;
                    ?>
        }, {
            label: "Duplex",
            value: <?php
                    $q = mysqli_query($conn, "SELECT * FROM household_tb WHERE Household_Type = 'Duplex' ");
                    $numrow = mysqli_num_rows($q);
                    echo $numrow;
                    ?>
        }],
        resize: true,
        colors: ['#CE6396', '#CE9C63', '#79B181', '#8179B1','#55765A','#E4DF59','#56617D','#23C5B1', '#4C60C6']
    });
</script>