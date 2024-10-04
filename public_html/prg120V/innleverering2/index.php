<?php
session_start();                                   /* TODO MAKE A NAV MENU, ON THE TOP / SIDE,
                                                                  +MAKE A PAGE FOR KLASSE ONE FOR STUDENT
                                                       + 2 MORE THAT ONLY SHOW ALL STUDENT & ALL KLASSE  IN A BIG TABLE OVER THE ENTIRE SCREEN
                                                                 +FIX WARNING "input_klasseKode Undefined array key
                                                                 + FIGURE OUT CLOSING / OPENING DB CONNECTION*/
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
//Connect database connection file with require
require "includes/dbh.inc.php";

//sql query data from table klasse
$KLASSE_sql = "SELECT * FROM KLASSE";
$KLASSE_result = $conn->query($KLASSE_sql);

//sql query data from table student
$STUDENT_sql ="SELECT * FROM STUDENT";
$STUDENT_result = $conn->query($STUDENT_sql);
?>

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
        <br/>
        <div class="form_add-KLASSE">
            <p><strong>Add rows into KLASSE table</strong></p>
            <form action="data-add.php" method="POST" id="klasse-add" name="klasseform">
                <label for="klasseKode"><u>klasseKode</u></label> <br/>
                <input type="text" id="klasseKode" name="input_klasseKode" placeholder="IT1" required> <br/>
                <label for="klassenavn">klassenavn</label> <br/>
                <input type="text" id="klassenavn"  name="input_klassenavn" placeholder="IT og ledelse 1. år"> <br/>
                <label for="studiumKode">studiumKode</label> <br/>
                <input type="text" id="studiumKode" name="input_studiumkode" placeholder="ITLED"> <br/> <br/>
                <input type ="submit" value ="Add" id ="submitKLASSE" name ="submit_KLASSE" />
                <a href="data-remove.php?type=KLASSE&klasseKode=<?php echo urlencode($input_klasseKode); ?>" onclick="return confirm('Are you sure you want to delete this data?');">
                    <input type="button" value="Delete" id="deleteKLASSE"/>
                </a>
            </form>
        </div>
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
            <form action="data-add.php" method="POST" id="klasse-add" name="klasseform">
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
                <a href="data-remove.php?type=STUDENT&brukernavn=<?php echo urlencode($input_brukernavn); ?>" onclick="return confirm('Are you sure you want to delete this data?');">
                    <input type="button" value="Delete" id="deleteSTUDENT"/>
                </a>
            </form>
        </div>
    </div>
</div>
</body>
</html>

<?php
//close database connection
 //$conn->close();
?>
