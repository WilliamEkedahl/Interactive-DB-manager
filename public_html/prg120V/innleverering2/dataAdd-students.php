<!DOCTYPE html>
<html lang="no">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>Add students</title>
    <link rel="stylesheet" href="css/stylesheet-update.css">
</head>
<body>

<?php
global $conn;
require("includes/dbh.inc.php");
require_once 'functions.php';

// Variable to store messages
$messages = [];

// Using mysqli_real_escape_string to escape characters and protect against SQL INJECTION.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Input data into the STUDENT table
    if (isset($_POST['submit_STUDENT'])) {
        $input_brukernavn = mysqli_real_escape_string($conn, $_POST['input_brukernavn']);
        $input_fornavn = mysqli_real_escape_string($conn, $_POST['input_fornavn']);
        $input_etternavn = mysqli_real_escape_string($conn, $_POST['input_etternavn']);
        $input_klasseKode = mysqli_real_escape_string($conn, $_POST['input_klasseKode']);

        // Validate input
        if (empty($input_klasseKode)) {
            $messages[] = "Error: klassekode er ikke fyllt ut";
        } elseif (strlen($input_brukernavn) > 7) {
            $messages[] = "Error: Data not saved, brukernavn only accepts a maximum length of 7 characters";
        } else {
            // Start transaction to prevent auto-increment gaps
            $conn->begin_transaction();  // START TRANSACTION

            try {
                // Check if a student is already registered in a course
                $stmt_select = $conn->prepare("SELECT * FROM STUDENT WHERE brukernavn = ? AND klasseKode = ?");
                if ($stmt_select) {
                    $stmt_select->bind_param("ss", $input_brukernavn, $input_klasseKode);
                    $stmt_select->execute();
                    $result = $stmt_select->get_result();

                    if ($result->num_rows > 0) {
                        $tablePrimaryIntegrity = $result->fetch_assoc();
                        $messages[] = "Error: 'brukernavn' with '" . htmlspecialchars($tablePrimaryIntegrity['brukernavn']) . "' is already registered for that course " . htmlspecialchars($input_klasseKode);
                    } else {
                        // Insert the new row
                        $stmt_insert = $conn->prepare("INSERT INTO STUDENT (brukernavn, fornavn, etternavn, klasseKode) VALUES (?,?,?,?)");
                        if ($stmt_insert) {
                            $stmt_insert->bind_param("ssss", $input_brukernavn, $input_fornavn, $input_etternavn, $input_klasseKode);
                            if ($stmt_insert->execute()) {
                                $messages[] = "The row was added successfully!";
                                $conn->commit();  // COMMIT TRANSACTION ON SUCCESS
                            } else {
                                throw new Exception("Error executing statement for INSERT: " . $conn->error);
                            }
                            $stmt_insert->close();
                        } else {
                            throw new Exception("Error preparing statement for INSERT: " . $conn->error);
                        }
                    }
                    $stmt_select->close();
                }
            } catch (Exception $e) {
                $conn->rollback();  // ROLLBACK TRANSACTION ON ERROR
                $messages[] = $e->getMessage();
            }
        }
    }
}
// Fetch the updated data
$sqlQueryData = sqlquerySelectAll($conn, 'STUDENT');
// Define the fields to be displayed in an array
$fields = ["id", "brukernavn", "fornavn", "etternavn", "klasseKode"];
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
    <div class="grid-container-inner">
        <div class="tabell" id="StudentTabell">
            <table>
                <p><strong>STUDENT</strong></p><br/>
                <tr>
                    <th><u>ID</u></th>
                    <th>brukernavn</th>
                    <th>fornavn</th>
                    <th>etternavn</th>
                    <th>klasseKode</th>
                </tr>
                <?php displayData($sqlQueryData, $fields); // Display the data inside the table?>
            </table>
        </div>
        <br/>
        <div class="form_add-STUDENT">
            <p><strong>Add rows into STUDENT table</strong></p>
            <form action="" method="POST" id="klasse-add" name="klasseform">
                <label for="brukernavn"><u>brukernavn</u></label><br/>
                <input type="text" id="brukernavn" name="input_brukernavn" placeholder="274640" required><br/>
                <label for="fornavn">fornavn</label><br/>
                <input type="text" id="fornavn" name="input_fornavn" placeholder="William"><br/>
                <label for="etternavn">etternavn</label><br/>
                <input type="text" id="etternavn" name="input_etternavn" placeholder="Ekedahl"><br/>
                <label for="klasseKode">klasseKode</label><br/>
                <select name="input_klasseKode" id="klasseKode">
                    <?php
                    // Dynamic listbox to only include the options from the KLASSE table
                    $listBox_Sql = "SELECT klasseKode FROM KLASSE";
                    $result = mysqli_query($conn, $listBox_Sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . ($row['klasseKode']) . '"> ' . ($row['klasseKode']) . '</option>';
                        }
                    } else {
                        echo '<option value="">No options available</option>';
                    }
                    ?>
                </select><br/><br/>
                <input type="submit" value="Add" id="submitSTUDENT" name="submit_STUDENT" />
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
