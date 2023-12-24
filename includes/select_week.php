<?php
    session_start();

    if (isset($_SESSION["employee_id"])) {
        $id_employee = $_SESSION["employee_id"];
    }

    echo "<br>";
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

    <form method="post" action="" id="week_form" class="week_form submit_form">
        <select class="sel" name="selected_week">
            <?php
                $weeks_sql = "SELECT DISTINCT
                    DATE_ADD(date, INTERVAL 1 - DAYOFWEEK(date) DAY) AS sun,
                    DATE_ADD(date, INTERVAL 7 - DAYOFWEEK(date) DAY) AS sat
                FROM employee_schedule
                WHERE idemployees = $id_employee
                ORDER BY sun";
                $week_result = $conn->query($weeks_sql);
                if ($week_result->num_rows > 0){
                    while($week_row = $week_result -> fetch_assoc()){
                        ?>
                        <option value="<?php echo $week_row['sun']; ?> " class="opt"
                        <?php
                        if(sameWeek($base_date, $week_row['sun'])){echo 'selected'.' class="default_week"';}?>>
                        <?php echo date('M d Y', strtotime($week_row['sun']))." - ".date('M d Y', strtotime($week_row['sat'])); ?></option>
                        <?php
                    }
                }
            ?>
        </select>   
        <input type="submit" value="SELECT" class="submit_btn">
    </form>
