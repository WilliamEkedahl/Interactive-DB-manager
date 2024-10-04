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

//sql query data from table klasse
$KLASSE_sql = "SELECT * FROM KLASSE";
$KLASSE_result = $conn->query($KLASSE_sql);
?>

<comment Using basename and $_SERVER [PHP_SELF] php self is the filemane of the currently executed script compared to a predetermined name manually
         and matching it with that for example 'index.php' if they match apply active color in css by echoing that it is active.> </comment>

<ul id="mainNav">
    <li><a href="index.php" class="<?php if(basename($_SERVER['PHP_SELF']) == 'index.php'){echo 'active';} ?>">Main Menu</a></li>
    <li>
        <a href="#" class="<?php if (basename($_SERVER['PHP_SELF']) == 'dataAdd-courses.php' || basename($_SERVER['PHP_SELF']) == 'dataAdd-Students.php') {echo 'active';} ?>">Add Data ▾</a>
        <ul class="dropdown">
            <li><a href="dataAdd-courses.php" class="<?php if(basename($_SERVER['PHP_SELF']) == 'dataAdd-courses.php'){echo 'active';} ?>">Add Courses</a></li>
            <li><a href="dataAdd-students.php" class="<?php if(basename($_SERVER['PHP_SELF']) == 'dataAdd-Students.php'){echo 'active';} ?>">Add Students</a></li>
        </ul>
    </li>
    <li>
        <a href="#" class="<?php if (basename($_SERVER['PHP_SELF']) == 'dataRemove-courses.php' || basename($_SERVER['PHP_SELF']) == 'dataRemove-Students.php') {echo 'active';} ?>">Remove Data ▾</a>
        <ul class="dropdown">
            <li><a href="dataRemove-courses.php" class="<?php if(basename($_SERVER['PHP_SELF']) == 'dataRemove-courses.php'){echo 'active';} ?>">Remove Courses</a></li>
            <li><a href="dataRemove-students.php" class="<?php if(basename($_SERVER['PHP_SELF']) == 'dataRemove-students.php'){echo 'active';} ?>">Remove Students</a></li>
        </ul>
    </li>
    <li><a href="showAll-Students.php" class="<?php if(basename($_SERVER['PHP_SELF']) == 'showAll-Students.php'){echo 'active';} ?>">Show All Students</a></li>
    <li><a href="showAll-courses.php" class="<?php if(basename($_SERVER['PHP_SELF']) == 'showAll-courses.php'){echo 'active';} ?>">Show All Courses</a></li>
</ul>

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
    </div>

</head>
<body>