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
            include('includes/select_week.php');
            ?>
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

                        if (isset($_POST['selected_week'])) {
                            echo "<div hidden class='check_form'></div>";
                            
                            $selected_week = $_POST['selected_week'];

                            $sql = "CALL weekly_task('$selected_week', ".$id_employee.");";

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

                                        <?php
                                            $is_passed = strtotime($row['date']) <= time();
                                        ?>
                                        <form action="" method="post" class="submit_form">
                                            <input type="hidden" name="idschedule" value="<?php echo $row['idschedule']; ?>">
                                            <select name="is_wfh" id="is_wfh" class="sel" <?php if ($is_passed) echo 'disabled'; ?>>
                                                <option class="opt" value="0"<?php if ($row['is_wfh'] == '0') echo ' selected'; ?>>ON-SITE</option>
                                                <option class="opt" value="1"<?php if ($row['is_wfh'] == '1') echo ' selected'; ?>>REMOTE</option>
                                            </select>
                                            <input type="submit" value="CONFIRM" class="<?php echo ($is_passed) ? 'disabled_btn' : 'submit_btn';?>" <?php if ($is_passed) echo 'disabled'; ?>>
                                        </form>
                                    <?php echo "</div>";
                                }
                            }else{
                                echo "0 resluts";
                            }
                        }
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
