<?php
session_start();                                   /*, TODO FIX DELETE STUDENT + FIGURE OUT CLOSING / OPENING DB CONNECTION*/
//check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
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
//all the required files that are used are here
//Connect database connection file with require
require "includes/dbh.inc.php";
//Connect functions functionality from functions file
require_once 'functions.php';
?>
<?php
//sql query data from table klasse
$KLASSE_sql = "SELECT * FROM KLASSE";
$KLASSE_result = $conn->query($KLASSE_sql);

//sql query data from table student
$STUDENT_sql ="SELECT * FROM STUDENT";
$STUDENT_result = $conn->query($STUDENT_sql);
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
                //display data in a loop untill there is no more data to display (rows = 0)
                if ($KLASSE_result->num_rows > 0) {
                    while($row = $KLASSE_result->fetch_assoc()) {
                        echo "<tr>
                                 <td>" . $row["klasseKode"] . "</td>
                                 <td>" . $row["klassenavn"] . "</td>
                                 <td>" . $row["studiumKode"] . "</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No rows found</td></tr>";
                } ?>
            </table>
        </div>
        <br/>
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
        </div>
    </div>
</div>
</body>
</html>

<?php
//close database connection
 //$conn->close();
?>
