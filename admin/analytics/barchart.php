<script>
    Morris.Bar({
        element: 'morris-bar-chart1',
        data: [
            <?php
                $qry = mysqli_query($conn, "SELECT Fam_Income, COUNT(*) AS cnt FROM families_tb GROUP BY Fam_Income");
                while($row = mysqli_fetch_array($qry)) {
                    echo "{y: '".$row['Fam_Income']."', a: '".$row['cnt']."'},";
                }
            ?>
        ],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['Number of Families'],
        hideHover: 'auto',
        barColors: ['#79B181', '#8179B1', '#CE9C63']
    });
</script>