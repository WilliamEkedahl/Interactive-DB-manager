<?php
session_start();                               
global $conn;
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
    <meta charset="UTF-8">
    <title>Show all students</title>
    <link rel ="stylesheet" href ="css/stylesheet-update.css">
</head>
<body>
<?php
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

<div class ="grid-container-outer">
    <div class="grid-container-inner">
        <div class="tabell" id="StudentTabell">
            <table>
                <p class="studentTitle"> <strong> STUDENT </strong> </p> <br/>
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
    </div>
</div>
</body>
</html>
