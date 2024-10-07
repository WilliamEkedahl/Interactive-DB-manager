<?php
/* The isActive function Explained it has 4 parts

1. The Declaration
function isActive($pageName)
The function takes one paramater $pageName which is the string representing the name of the php file for example index.php

2. basename ($_SERVER['PHP_SELF'])
$_SERVER An array that contains information for example headers, paths, and lots more information that is created by the webserver
PHP_SELF -The full file name of the currently executing script. including the path
basename() PHP function that extracts only the filename from a path.

So by using the PHP_SELF we are specifying how to use the superglobal $_SERVER
but $_SERVER['PHP_SELF'] returns the root location so in my example 274640/public_html/prg120V/innleverering2/index.php
so we use basename() and then we get only index.php Perfect! now we can compare in the last part of the function.

3. Comparison so the basename compared with the current page name, '$pageName' whole comparison 'basename($_SERVER)['PHP_SELF']) == $pageName'
If they are the same meaning that the user is currently on the same page as the server indicates then the ternary operator in part 4 will be true and we apply the 'active' css styling.

4. Ternary Operator code: ? 'active' : '' (basially a short if-else statement)

true:  (if basename and pageName match) code - ? 'active'
the function returns the string 'active'
false: (if basename and pageName **do not** match) code - '';
the function returns an empty string



 */ //comments on how the IsActive function works

//handels cases for everyting except the dropdown
function isActive($pageName) {
    return basename($_SERVER['PHP_SELF']) == $pageName ? 'active' : '';
}
//handles cases for if a dropdown menu is active showing both the page and the general dropdown menu as active
function dropdownIsActive($pageName1, $pageName2){
    $currentPage = basename($_SERVER['PHP_SELF']);
    return ($currentPage == $pageName1 || $currentPage == $pageName2) ? 'active' : '';
}



/*/
//Dynamic listbox to only include the Options that exist in the KLASSE table USED 3x
$listBox_Sql = "SELECT klasseKode FROM KLASSE";
$result = mysqli_query($conn, $listBox_Sql);
//Options for listbox
if ($result->num_rows > 0)
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . ($row['klasseKode']) . ' "> ' . ($row['klasseKode']) . '</option>';
    } else {
    echo '<option value="input_klasseKode">No options available</option>';
}


/* MORE FUNCTION THAT NEED TO BE IMPLEMENTED */


/* if ($KLASSE_result->num_rows > 0) { USED 6X!
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
*/
/*
2 ONE AND 2 WORK TOGETHER would be best with one function for both USED 8x!
$STUDENT_sql ="SELECT * FROM STUDENT";
$STUDENT_result = $conn->query($STUDENT_sql);
*/
function sqlquerySelectAll($conn, $from){
    $allowedTables = ['KLASSE', 'STUDENT'];
    if (!in_array($from, $allowedTables)) {
        die("Invalid table specified");
    }
    $sql = "SELECT * FROM $from";
    $result = $conn->query($sql);

    if (!$result) {
        die ("Query from database failed" . $conn->error);
    }

    return $result->fetchAll(MYSQLI_ASSOC);
}


/*
if (isset($_POST['submit_STUDENT'])) { USED 4x
    $input_brukernavn = mysqli_real_escape_string($conn, $_POST['input_brukernavn']);
    $input_fornavn = mysqli_real_escape_string($conn, $_POST['input_fornavn']);
    $input_etternavn = mysqli_real_escape_string($conn, $_POST['input_etternavn']);
    $input_klasseKode = mysqli_real_escape_string($conn, $_POST['input_klasseKode']);


4

*/
?>



