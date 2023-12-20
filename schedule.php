<!DOCTYPE html>
<html>
    <head>
        <title>show records</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
        <?php include('templates/header.html'); ?>
        <div class="content">

                <?php
                    include "db_conn.php";
                    include "functions.php";

                    $date_range_query = "SELECT MIN(DATE) as min_date, MAX(date) as max_date
                                    FROM employee_schedule";
                    $date_range = $conn->query($date_range_query);
                    if ($date_range->num_rows == 1) {
                        $row = $date_range->fetch_assoc();
                        $min_date = $row['min_date'];
                        $max_date = $row['max_date'];
                    }

                    $current_date = new DateTime();
                    $base_date = $current_date->format('Y-m-d'); 

                    ?>

                    <select class="sel" name="selected_week">
                        <?php
                            $week_dict = array();
                            $weeks_sql = "SELECT DISTINCT
                                DATE_ADD(date, INTERVAL 1 - DAYOFWEEK(date) DAY) AS sun,
                                DATE_ADD(date, INTERVAL 7 - DAYOFWEEK(date) DAY) AS sat
                            FROM employee_schedule;";
                            $week_result = $conn->query($weeks_sql);

                            if ($week_result->num_rows > 0){
                                $counter = 0;
                                while($week_row = $week_result -> fetch_assoc()){
                                    ?>
                                    <option value="<?php echo $counter; ?> " class="opt"
                                    <?php 
                                    if(sameWeek($base_date, $week_row['sun'])){echo 'selected'.' class="default_week"';}?>>
                                    <?php echo date('M d Y', strtotime($week_row['sun']))." - ".date('M d Y', strtotime($week_row['sat'])); ?></option>
                                    <?php $week_dict[$counter] = $week_row['sun'];
                                    $counter++;

                                }
                            }
                        ?>
                    </select>

                    <a href="schedule.php" id="schedule_link"><button>Go to Schedule</button></a>

                    <script>

                        document.querySelector('button').addEventListener('click', function() {
                            var selectedWeek = document.querySelector('.sel').value;
                            var scheduleLink = document.getElementById('schedule_link');

                            if (selectedWeek) {
                                scheduleLink.href = 'schedule.php?week=' + encodeURIComponent(selectedWeek);
                            }
                        });
                    </script>

            <div class="week">
                    <?php

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if (isset($_POST['is_wfh']) && isset($_POST['idschedule'])) {
                            $is_wfh = $_POST['is_wfh'];
                            $idschedule = $_POST['idschedule'];

                            $updateSql = "UPDATE employee_schedule SET is_wfh = '$is_wfh' WHERE idSchedule = '$idschedule'";
                            if ($conn->query($updateSql) === TRUE) {
                                echo "";
                            } else {
                                echo "Error updating record: " . $conn->error;
                            }
                        }
                    }

                    if(!isset($_GET['week'])){
                        $week = 0;
                    }
                    else{
                        $week = $_GET['week'];
                    }
                        
                    $week_value = $week_dict[$week];

                    $sql = "CALL weekly_task('$week_value');";

                    $result = $conn->query($sql);
                    if ($result->num_rows > 0){
                        while($row = $result -> fetch_assoc()){
                            ?>
                            <?php echo "<div class='day'>" ?>
                                <div class="day_details details">
                                    <p class="date"><?php echo date('M d Y', strtotime($row['date']))?></p>
                                    <p class="dayname"><?php echo $row['day']?></p>
                                </div>
                                <div class="time_details details">
                                    <!-- <p class="shift"><?php echo $row['shift']?></p> -->
                                    <p class="time_frame"><?php echo $row['time']?></p>
                                </div>

                                <p class="task"><?php echo $row['task_name']?></p>
                                <p class="task_desc"><?php echo $row['task_description']?></p>

                                <form action="" method="post" class="submit_form">
                                    <input type="hidden" name="idschedule" value="<?php echo $row['idschedule']; ?>">
                                    <select name="is_wfh" id="is_wfh" class="sel">
                                        <option class="opt" value="0"<?php if ($row['is_wfh'] == '0') echo ' selected'; ?>>ON-SITE</option>
                                        <option class="opt" value="1"<?php if ($row['is_wfh'] == '1') echo ' selected'; ?>>REMOTE</option>
                                    </select>
                                    <input type="submit" value="CONFIRM" class="submit_btn">
                                </form>
                            <?php echo "</div>";
                        }
                    }else{
                        echo "0 resluts";
                    }

                    $conn->close();
                ?>
            </div>
        </div>   
        <?php include('templates/footer.html'); ?>
    </body>
</html>


<script>
    window.onload = function() {
        var dayElements = document.getElementsByClassName('day');
        
        if (dayElements.length === 0) {
            document.getElementById('week_form').submit();
        }
    };
</script>
