<!DOCTYPE html>
<html>
    <head>
        <title>show records</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link href="css/style.css" rel="stylesheet">
        <link href="css/chartjs.css" rel="stylesheet">
    </head>
    <body>
        <?php include('templates/header.html'); ?>
        <div class="content">
                <?php 
                include "db_conn.php";
                include "functions.php";
                include('includes/select_week.php');
                
                echo "<div class='charts'>";

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST['selected_week'])) {
                        $week = $_POST['selected_week'];
                        $sql = "call chart_info('$week')";
                        
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0){
                            $ids = array();
                            $data = array();
                            while($row = $result -> fetch_assoc()){
                                $chartData = array(
                                    "onsite" => $row['onsite'],
                                    "remote" => $row['remote']
                                );

                                $chart_id = array(
                                    "id" => 'id_'.$row['date']
                                );
                                $data[] = $chartData;
                                $ids[] = $chart_id;

                                ?>
                                <div class="daily_chart">
                                    <h3 class="chart_label"><?php echo $row['day_of_week']?></h3>
                                    <h4 class="chart_label"><?php echo date('M d Y', strtotime($row['date']))?>
                                    <br>
                                    <canvas id="<?php echo 'id_'.$row['date']?>" class="chart_canvas"></canvas>
                                </div>
                                <?php
                            }
                        }
                        $jsonData = json_encode($data);
                        $jsonIds = json_encode($ids);

                    }
                }
                echo "</div>";
                ?>

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    var data = <?php echo $jsonData; ?>;
                    var ids = <?php echo $jsonIds; ?>;


                    for (let i = 0; i < ids.length; i++) {
                        console.log(ids[i].id);

                        var ctx = document.getElementById(ids[i].id)
                        new Chart(ctx, {
                            type: 'pie',
                            data : {
                            datasets: [{
                                data: [data[i].remote, data[i].onsite],
                                    backgroundColor: [
                                        'rgba(0, 100, 255, 1)',
                                        'rgba(50, 200,255, 1)'
                                    ],
                                    borderColor: 'transparent',
                            }],
                        
                            labels: [
                                'Remote',
                                'On-site',
                            ]},
                            options: {
                                plugins: {
                                    title: {
                                        display: true,
                                        text: 'Remote and On-site ratio',  
                                        color: 'rgb(100,100,150)'
                                    },
                                    legend:{
                                        labels: {
                                            color: 'rgb(100,100,150)'
                                        },
                                    }
                                }
                            }
                            });
                        }

                </script>

        </div>
        <?php include('templates/footer.html'); ?>
    </body>
</html>

<script>
    window.onload = function() {
        var Elements = document.getElementsByClassName('daily_chart');
        
        if (Elements.length === 0) {
            document.getElementById('week_form').submit();
        }
    };
</script>