<!DOCTYPE html>
<html lang="no">
<head>
    <meta name ="viewport" content ="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>Remove courses</title>
    <link rel ="stylesheet" href ="css/stylesheet-update.css">
</head>
<body>

<?php
global $conn;
require ("includes/dbh.inc.php");
require_once 'functions.php';

// Variable to store messages
$messages = [];
//Using mysqli_real_escape_string to escape characters and protect against SQL INJECTION.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//input data into table KLASSE'
    if (isset($_POST['delete_KLASSE'])) {
        $input_klasseKode = trim(mysqli_real_escape_string($conn, $_POST["input_klasseKode"]));

        //sql remove data from database
        $sqlDelete = "DELETE FROM KLASSE WHERE klasseKode='$input_klasseKode'";

        try {
            if (mysqli_query($conn, $sqlDelete)) {
                $messages[] =  "The row '" . $input_klasseKode . "' was deleted sucessfully";
            }
        } catch (Exception $mysqli_sql_exception) {
            $messages[] =  " Error you can not Remove the row before you have removed the Student with the same class code in the STUDENT table";
        }
    }
}
//described in functions.php
$sqlQueryData = sqlquerySelectAll($conn, 'KLASSE');

$fields = ['klasseKode', 'klassenavn', 'studiumKode'];
?>

<nav class="mainNav">
    <ul id="mainNav-list">
        <li><a href="index.php" class="<?php echo isActive ('index.php');?>" >Main Menu</a></li>
        <li>
            <a href="#" class="<?php echo dropdownIsActive('dataAdd-courses.php', 'dataAdd-students.php'); ?>" >Add Data ▾</a>
            <ul class="dropdown">
                <li><a href="dataAdd-courses.php" class="<?php echo isActive ('dataAdd-courses.php');?>" >Add Courses</a></li>
                <li><a href="dataAdd-students.php" class="<?php echo isActive ('dataAdd-students.php');?>" >Add Students</a></li>
                <li><a href="dataAdd-register.php" class="<?php echo isActive ('dataAdd-register.php');?>" >Register for courses</a></li>
            </ul>
        </li>
        <li>
            <a href="#" class="<?php echo dropdownIsActive('dataRemove-courses.php','dataRemove-students.php')?>" >Remove Data ▾</a>
            <ul class="dropdown">
                <li><a href="dataRemove-courses.php" class="<?php echo isActive ('dataRemove-courses.php'); ?>" >Remove Courses</a></li>
                <li><a href="dataRemove-students.php" class="<?php echo isActive ('dataRemove-students.php'); ?>" >Remove Students</a></li>
                <li><a href="dataRemove-register.php" class="<?php echo isActive ('dataRemove-register.php');?>" >Unregister for courses</a></li>
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
                <?php displayData($sqlQueryData, $fields); // Display the data inside the table?>
            </table>
        </div>
        <br/>
        <div class="form-removeCourses">
            <p><strong>Velg en KlasseKode for og slette en klasse fra tabellen</strong></p>
            <form  method="POST" action="dataRemove-courses.php"  id="removeCourses" name="removeCourseForm">
                <label for="klaseKode"><U>klasseKode</U></label> <br/>
                <select name="input_klasseKode" id="klassekode" required>
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
                    <input type="submit" value="Delete" id="deleteKLASSE" name="delete_KLASSE" onclick="return confirm('Are you sure you want to delete this data?');"/>
            </form>
             <div class="messages" id="printmessages">
                <?php if (!empty($messages)): ?>
                <ul>
                    <?php foreach ($messages as $message): ?>
                        <li id="sentmessage" class="<?php echo strpos($message, 'Error') == 0 ? 'success' : 'error'; ?>">
                            <?php echo htmlspecialchars($message); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
