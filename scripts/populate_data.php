<?php
include 'db_conn.php';

    $employee_schedule = [[1,1],[2,1],[3,2],[4,2],
                        [5,3],[6,3],[7,1],[8,1],
                        [9,2],[10,2],[11,3],[12,3],
                        [13,1],[14,1],[15,2],[16,2],
                        [17,3],[18,3],[19,1],[20,1],
                        [21,2],[22,2],[23,3],[24,3],
                        [25,1],[26,1],[27,2],[28,2],
                        [29,3],[30,3],[123,2]];


    $onsites = [9,14,15,16,17,18,19];

    $dates = ['2023-12-24', '2023-12-25', '2023-12-26', '2023-12-27', '2023-12-28', '2023-12-29', '2023-12-30', '2023-12-31',
            '2024-01-01', '2024-01-02', '2024-01-03', '2024-01-04', '2024-01-05', '2024-01-06'];

    foreach($dates as $date){
        foreach($employee_schedule as $sched){
            $emp_id = $sched[0];
            $shift = $sched[1];
            $taskid = rand(1,21);

            if (in_array($taskid, $onsites)){
                $is_remote = 0;
            }else{
                $is_remote = rand(0,1);
            }

            echo $emp_id."\n";
            echo $date."\n";
            echo $shift."\n";
            echo $taskid."\n";
            echo $is_remote."\n\n";

            
            $sql = "INSERT INTO employee_schedule(idemployees, date, idshift, idtask_assignment, is_wfh)
                    VALUES('$emp_id', '$date', '$shift', '$taskid', '$is_remote')";
            
            if ($conn->query($sql) === TRUE) {
                echo "New record inserted successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }


        }
    }



?>