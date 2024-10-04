<!DOCTYPE html>
<html lang="no">
<head>
    <meta name ="viewport" content ="width=device-width, initial-scale=1">
    <meta charset="UTF-8"
    <title></title>
    <link rel ="stylesheet" href ="css/stylesheet-index.css">
</head>
<body>

<?php
global $conn;
require ("includes/dbh.inc.php");

//sql query data from table student
$STUDENT_sql ="SELECT * FROM STUDENT";
$STUDENT_result = $conn->query($STUDENT_sql);
?>

<ul id="mainNav">
    <li><a href="index.php" class="<?php if(basename($_SERVER['PHP_SELF']) == 'index.php'){echo 'active';} ?>">Main Menu</a></li>
    <li>
        <a href="#" class="<?php if (basename($_SERVER['PHP_SELF']) == 'dataAdd-courses.php' || basename($_SERVER['PHP_SELF']) == 'dataAdd-Students.php') {echo 'active';} ?>">Add Data ▾</a>
        <ul class="dropdown">
            <li><a href="dataAdd-courses.php" class="<?php if(basename($_SERVER['PHP_SELF']) == 'dataAdd-courses.php'){echo 'active';} ?>">Add courses</a></li>
            <li><a href="dataAdd-students.php" class="<?php if(basename($_SERVER['PHP_SELF']) == 'dataAdd-Students.php'){echo 'active';} ?>">Add students</a></li>
        </ul>
    </li>
    <li>
        <a href="#" class="<?php if (basename($_SERVER['PHP_SELF']) == 'dataRemove-courses.php' || basename($_SERVER['PHP_SELF']) == 'dataRemove-Students.php') {echo 'active';} ?>">Remove Data ▾</a>
        <ul class="dropdown">
            <li><a href="dataRemove-courses.php" class="<?php if(basename($_SERVER['PHP_SELF']) == 'dataRemove-courses.php'){echo 'active';} ?>">Remove courses</a></li>
            <li><a href="dataRemove-students.php" class="<?php if(basename($_SERVER['PHP_SELF']) == 'dataRemove-students.php'){echo 'active';} ?>">Remove students</a></li>
        </ul>
    </li>
    <li><a href="showAll-Students.php" class="<?php if(basename($_SERVER['PHP_SELF']) == 'showAll-Students.php'){echo 'active';} ?>">Show All Students</a></li>
    <li><a href="showAll-courses.php" class="<?php if(basename($_SERVER['PHP_SELF']) == 'showAll-courses.php'){echo 'active';} ?>">Show All Courses</a></li>
</ul>

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
                //display data in a loop untill there is no more data to display (rows = 0)
                if ($STUDENT_result->num_rows > 0) {
                    while($row = $STUDENT_result->fetch_assoc()) {
                        echo "<tr>
                                         <td>" . $row["brukernavn"] . "</td>
                                         <td>" . $row["fornavn"] . "</td>
                                         <td>" . $row["etternavn"] . "</td>
                                         <td>" . $row["klasseKode"] . "</td>
                                    </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No rows found</td></tr>";
                } ?>
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
                        echo '<option value="input_klasseKode">No options available</option>';
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
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    //input data into table STUDENT
    if (isset($_POST['submit_STUDENT'])){
        $input_brukernavn = mysqli_real_escape_string($conn, $_POST['input_brukernavn']);
        $input_fornavn = mysqli_real_escape_string($conn, $_POST['input_fornavn']);
        $input_etternavn = mysqli_real_escape_string($conn, $_POST['input_etternavn']);
        $input_klasseKode = mysqli_real_escape_string($conn, $_POST['input_klasseKode']);

        //Checking if brukernavn is filled out
        if (!$input_klasseKode) {
            echo "Error: klassekode er ikke fyllt ut";
        }
        //Checking if the brukernavn is longer than 3 characters
        if (strlen($input_brukernavn) > 3) {
            echo "Error: Data not saved, brukernavn only accepts a maximum length of 3 characters";
        } else {
            //make sure the primary key is unique warning
            $primarykeySTUDENT = "SELECT * FROM STUDENT WHERE brukernavn = '$input_brukernavn'";
            $result = mysqli_query($conn, $primarykeySTUDENT);

            if (($result->num_rows) > 0) {
                $tablePrimaryIntegrity = $result->fetch_assoc();
                echo "A 'brukernavn' with '" . $tablePrimaryIntegrity['brukernavn'] . "' already exists, duplicates of the 'brukernavn' row are not allowed because its the primary key of the table.";
            } else {
                //Everything looks good insert the student information into the table
                $sql_STUDENT_add = "INSERT into STUDENT VALUES ('$input_brukernavn', '$input_fornavn', '$input_etternavn', '$input_klasseKode')";

                if (mysqli_query($conn, $sql_STUDENT_add)) {
                    echo "The row was added sucessfully!";
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            }
        }
    }
}
?>

