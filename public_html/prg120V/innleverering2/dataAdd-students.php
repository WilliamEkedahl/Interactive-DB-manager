<!DOCTYPE html>
<html lang="no">
<head>
    <meta name ="viewport" content ="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>Add students</title>
    <link rel ="stylesheet" href ="css/stylesheet-index.css">
</head>
<body>

<?php
global $conn;
require ("includes/dbh.inc.php");
require_once 'functions.php';
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

<div class="grid-container-outer">
    <div class ="grid-container-inner">
        <div class="tabell" id="StudentTabell">
            <table>
                <p> <strong> STUDENT </strong> </p> <br/>
                <tr>
                    <th><u>brukernavn</u></th>
                    <th>fornavn</th>
                    <th>etternavn</th>
                    <th>klasseKode</th>
                </tr>
<?php
//described in functions.php
//sql query data from table student by using a function in functions.php that stores the data in an associative array, set the result to correspond to the other method.
$sqlQueryData = sqlquerySelectAll($conn, 'STUDENT');

//define the fields to be displayed in an array
$fields = ["brukernavn", "fornavn", "etternavn", "klasseKode"];

//display data in the array untill the array is empty
displayData($sqlQueryData, $fields);
?>
            </table>
        </div>
        <br/>
        <div class="form_add-STUDENT">
            <p><strong>Add rows into STUDENT table</strong></p>
            <form action="dataAdd-students.php" method="POST" id="klasse-add" name="klasseform">
                <label for="brukernavn"><u>brukernavn</u></label> <br/>
                <input type="text" id="brukernavn" name="input_brukernavn" placeholder="gb" required> <br/>
                <label for="fornavn">fornavn</label> <br/>
                <input type="text" id="fornavn"  name="input_fornavn" placeholder="Geir"> <br/>
                <label for="etternavn">etternavn</label> <br/>
                <input type="text" id="etternavn" name="input_etternavn" placeholder="Bjarvin"> <br/>
                <label for="klasseKode">klasseKode</label> <br/>
                <select name="input_klasseKode" id="klasseKode">
<?php
//Dynamic listbox to only include the Options that exist in the KLASSE table
$listBox_Sql = "SELECT klasseKode FROM KLASSE";
$result = mysqli_query($conn, $listBox_Sql);
//Options for listbox
if ($result->num_rows > 0)
    while ($row = $result->fetch_assoc()) {
        echo '<option value="'. ($row['klasseKode']) .' "> ' . ($row['klasseKode']) . '</option>';
    } else {
    echo '<option value="">No options available</option>';
}
?>
                </select>
                <br/><br/>
                <input type ="submit" value ="Add" id ="submitSTUDENT" name ="submit_STUDENT" />
            </form>
        </div>
    </div>
</div>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //input data into table STUDENT
    if (isset($_POST['submit_STUDENT'])) {
        $input_brukernavn = mysqli_real_escape_string($conn, $_POST['input_brukernavn']);
        $input_fornavn = mysqli_real_escape_string($conn, $_POST['input_fornavn']);
        $input_etternavn = mysqli_real_escape_string($conn, $_POST['input_etternavn']);
        $input_klasseKode = mysqli_real_escape_string($conn, $_POST['input_klasseKode']);
        //Checking if brukernavn is filled out
        if (empty($input_klasseKode)) {
            echo "Error: klassekode er ikke fyllt ut";
            return;
        }
        //Checking if the brukernavn is longer than 3 characters
        if (strlen($input_brukernavn) > 3) {
            echo "Error: Data not saved, brukernavn only accepts a maximum length of 3 characters";
            return;
        }

        //make sure the primary key is unique warning
        //prepares the SELECT query to check for primarykey integrity
        $stmt_select = $conn->prepare("SELECT * FROM STUDENT WHERE brukernavn = ?");
        //Bind the paramater (brukernavn) to the prepared statement
        if ($stmt_select) {
            $stmt_select->bind_param("s", $input_brukernavn);
            //Execute statement
            try {
                $stmt_select->execute();
            } catch (Exception $ex) {
                echo "the error is caught here"
            }
            //fetch result
            $result = $stmt_select->get_result();

            if (($result->num_rows) > 0) {
                $tablePrimaryIntegrity = $result->fetch_assoc();
                echo "A 'brukernavn' with '" . $tablePrimaryIntegrity['brukernavn'] . "' already exists, duplicates of the 'brukernavn' row are not allowed because its the primary key of the table.";
            } else {
                //Everything looks good insert the student information into the table "ssss" represents 4 strings
                $stmt_insert = $conn->prepare("INSERT into STUDENT (brukernavn, fornavn, etternavn, klasseKode) VALUES (?,?,?,?)");

                if ($stmt_insert) { //check if the prepare for insert was sucessfull
                    $stmt_insert->bind_param("ssss", $input_brukernavn, $input_fornavn, $input_etternavn, $input_klasseKode);

                    if ($stmt_insert->execute()) {
                        echo "The row was added sucessfully!";
                    } else {
                     //   echo "Error: " . $stmt_insert->error;
                    }
                    //close statement
                    $stmt_insert->close();
                } else {
                    // Prepare failed for INSERT
                    echo "Error preparing statement for INSERT: " . $conn->error;
                }
            }
            //close the select statement
            $stmt_select->close();
        }
    }
}
?>

