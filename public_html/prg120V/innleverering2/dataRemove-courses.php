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
require_once 'functions.php';

//sql query data from table klasse
$KLASSE_sql = "SELECT * FROM KLASSE";
$KLASSE_result = $conn->query($KLASSE_sql);
?>

<comment Using basename and $_SERVER [PHP_SELF] php self is the filemane of the currently executed script compared to a predetermined name manually
         and matching it with that for example 'index.php' if they match apply active color in css by echoing that it is active.> </comment>

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
                }
                ?>
            </table>
        </div>
        <br/>
        <div class="form-removeCourses">
            <p><strong>Velg en KlasseKode for og slette en klasse fra tabellen</strong></p>
            <form action="dataRemove-courses.php" method="POST" id="removeCourses" name="removeCourseForm">
                <label for="klaseKode"><U>klasseKode</U></label> <br/>
                <select name="input_klassekode" id="klassekode">
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
                <a href="dataRemove-students.php" onclick="return confirm('Are you sure you want to delete this data?');">
                    <input type="button" value="Delete" id="deleteKLASSE"/>
                </a>
            </form>
        </div>
    </div>
</div>
<?

//Using mysqli_real_escape_string to escape characters and protect against SQL INJECTION.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//input data into table KLASSE
if (isset($_POST['submit_KLASSE'])) {
$input_klasseKode = mysqli_real_escape_string($conn, $_POST["input_klasseKode"]);

//sql remove data from database

$sqlDelete = "DELETE FROM KLASSE WHERE klaseKode=()";




?>


</body>
</html>