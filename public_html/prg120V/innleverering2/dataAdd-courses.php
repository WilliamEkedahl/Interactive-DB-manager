<!DOCTYPE html>
<html lang="no">
<head>
    <meta name ="viewport" content ="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>Add courses</title>
    <link rel ="stylesheet" href ="css/stylesheet-index.css">
</head>
<body>

<?php
global $conn;
require ("includes/dbh.inc.php");
require_once 'functions.php';

/* Using basename and $_SERVER [PHP_SELF] php self is the filemane of the currently executed script compared to a predetermined name manually
and matching it with that for example 'index.php' if they match apply active color in css by echoing that it is active.> */
?>
<nav class="mainNav">
    <ul id="mainNav-list">
        <li><a href="index.php" class="<?php echo isActive ('index.php');?>" >Main Menu</a></li>
        <li>
            <a href="#" class="<?php echo dropdownIsActive('dataAdd-courses.php', 'dataAdd-students.php'); ?>" >Add Data ▾</a>
            <ul class="dropdown">
                <li><a href="dataAdd-courses.php" class="<?php echo isActive ('dataAdd-courses.php');?>" >Add Courses</a></li>
                <li><a href="dataAdd-students.php" class="<?php echo isActive ('dataAdd-students.php');?>" >Add Students</a></li>
            </ul>
        </li>
        <li>
            <a href="#" class="<?php echo dropdownIsActive('dataRemove-courses.php','dataRemove-students.php')?>" >Remove Data ▾</a>
            <ul class="dropdown">
                <li><a href="dataRemove-courses.php" class="<?php echo isActive ('dataRemove-courses.php'); ?>" >Remove Courses</a></li>
                <li><a href="dataRemove-students.php" class="<?php echo isActive ('dataRemove-students.php'); ?>" >Remove Students</a></li>
            </ul>
        </li>
        <li><a href="showAll-Students.php" class="<?php echo isActive ('showAll-Students.php'); ?>" >Show All Students</a></li>
        <li><a href="showAll-courses.php" class="<?php echo isActive ('showAll-courses.php');?>" >Show All Courses</a></li>
    </ul>
</nav>

<div class ="grid-container-outer">
    <div class ="grid-container-inner">
        <div class="tabell" id="klasseTabell">
            <table>
                <p> <strong> KLASSE </strong></p> <br/>
                <tr>
                    <th><u>klasseKode</u></th>
                    <th>klassenavn</th>
                    <th>studiumKode</th>
                </tr>
<?php
//described in functions.php
$sqlQueryData = sqlquerySelectAll($conn, 'KLASSE');

$fields = ['klasseKode', 'klassenavn', 'studiumKode'];

displayData($sqlQueryData, $fields);
?>
            </table>
        </div>
        <br/>
        <div class="form_add-KLASSE">
            <p><strong>Add rows into KLASSE table</strong></p>
            <form action="dataAdd-courses.php" method="POST" id="klasse-add" name="klasseform">
                <label for="klasseKode"><u>klasseKode</u></label> <br/>
                <input type="text" id="klasseKode" name="input_klasseKode" placeholder="IT1" required> <br/>
                <label for="klassenavn">klassenavn</label> <br/>
                <input type="text" id="klassenavn"  name="input_klassenavn" placeholder="IT og ledelse 1. år"> <br/>
                <label for="studiumKode">studiumKode</label> <br/>
                <input type="text" id="studiumKode" name="input_studiumkode" placeholder="ITLED"> <br/> <br/>
                <input type ="submit" value ="Add" id ="submitKLASSE" name ="submit_KLASSE" />
            </form>
        </div>
    </div>
</div>

<?php
//Using mysqli_real_escape_string to escape characters and protect against SQL INJECTION.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //input data into table KLASSE
    if (isset($_POST['submit_KLASSE'])) {
        $input_klasseKode = mysqli_real_escape_string($conn, $_POST["input_klasseKode"]);
        $input_klassenavn = mysqli_real_escape_string($conn, $_POST["input_klassenavn"]);
        $input_studiumkode = mysqli_real_escape_string($conn, $_POST["input_studiumkode"]);

        if (!$input_klasseKode) {
            echo "Error: KlasseKode is not filled out";
        }
        // Check if the klasseKode is longer than 3 character if TRUE print Error
        if (strlen($input_klasseKode) > 3) {
            echo "Error: Data not saved, KlasseKode only accepts a maximum length of 3 characters";
        } else {
            //make sure the primary key is unique
            //Query the database with sql to check all values that matches the values of $input_klassekode. to check for duplictes.
            $primarykeyKLASSE = "SELECT * FROM KLASSE WHERE klasseKode = '$input_klasseKode'";
            $result = mysqli_query($conn, $primarykeyKLASSE);

            if (($result->num_rows) > 0) {
                $rowPrimaryIntegrity = $result->fetch_assoc(); //grabs the row and stores it in a associative array.
                echo "A klasseKode with '" . $rowPrimaryIntegrity['klasseKode'] . "' already exists, duplicates of the klasseKode row are not allowed because its the primary key of the table.";
            } else {
                $sql_KLASSE_add = "INSERT into KLASSE VALUES ('$input_klasseKode', '$input_klassenavn', '$input_studiumkode')";

                if (mysqli_query($conn, $sql_KLASSE_add)) {
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            }
        }
    }
}
?>
</body>
</html>



