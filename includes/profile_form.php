
<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 0);

session_start();
include 'db_conn.php'; 
?>
<div class="content">
    <h3 style="color: #333390AA">SELECT EMPLOYEE</h3>
    <form method="post" action="" id="employee_form" class="employee_form submit_form">
        <select class="sel" name="idemployee">
        <?php
            $sql = "SELECT idemployees, CONCAT(first_name,' ',last_name) as full_name 
                    FROM hrm_project.employees
                    WHERE idemployees <= 30 OR idemployees = 123";
            $result = $conn->query($sql);
            if ($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    ?>
                    <option value="<?php echo $row['idemployees']; ?>">
                        <?php echo $row['full_name']; ?>
                    </option>
                    <?php
                }
            }
            ?>
        </select>   
        <input type="submit" value="SELECT" class="submit_btn">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['idemployee'])) {
            // Retrieve the selected employee ID from the form
            $id_employee = $_POST['idemployee'];

            $_SESSION["employee_id"] = $id_employee;

            header("Location: select_week.php");
            exit();
        }
    }
    ?>

