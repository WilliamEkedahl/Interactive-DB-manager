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
    <title>Remove students</title>
    <link rel ="stylesheet" href ="css/stylesheet-update.css">
</head>
<body>

<?php
require ("includes/dbh.inc.php");
require_once 'functions.php';

//check if the connection is valid
if (!$conn) {
    die( $messages[] = "Database connection failed: " . mysqli_connect_error());
}
// Variable to store messages
$messages = [];
//Using mysqli_real_escape_string to escape characters and protect against SQL INJECTION.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//input data into table KLASSE'
    if (isset($_POST['delete_STUDENT'])) {

        $input_brukernavn = trim(mysqli_real_escape_string($conn, $_POST["input_brukernavn"]));

        //sql remove data from database
        $sqlDelete = "DELETE FROM STUDENT WHERE brukernavn='$input_brukernavn'";

        // Execute the query
        if (mysqli_query($conn, $sqlDelete)) {
            $messages[] = "The row '" . $input_brukernavn . "' was deleted successfully!";
        } else {
            // Print the error if query execution fails
            $messages[] = "Error: " . mysqli_error($conn);
        }
    }
}
//described in functions.php
$sqlQueryData = sqlquerySelectAll($conn, 'STUDENT');

//define the fields to be displayed in an array
$fields = ["brukernavn", "fornavn", "etternavn", "klasseKode"];
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
                <?php displayData($sqlQueryData, $fields); //display data inside the table?>
            </table>
        </div>
        <br/>
        <div class="form-removeStudents">
            <p><strong>Velg ett brukernavn for og slette en student fra tabellen</strong></p>
            <form method="POST"  action="dataRemove-students.php"  id="removeStudents" name="removeStudentForm">
                <label for="brukernavn"><U>brukernavn</U></label> <br/>
                <select name="input_brukernavn" id="brukernavn" required>
                    <?php
                    //Dynamic listbox to only include the Options that exist in the KLASSE table
                    $listBox_Sql = "SELECT brukernavn FROM STUDENT";
                    $result = mysqli_query($conn, $listBox_Sql);
                    //Options for listbox
                    if ($result->num_rows > 0)
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="'. ($row['brukernavn']) .' "> ' . ($row['brukernavn']) . '</option>';
                        } else {
                        echo '<option value="input_brukernavn">No options available</option>';
                    }
                    ?>
                </select>
                <br/><br/>
                    <input type="submit" value="Delete" id="deleteSTUDENT" name ="delete_STUDENT" onclick="return confirm('Are you sure you want to delete this data?');"/>
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
