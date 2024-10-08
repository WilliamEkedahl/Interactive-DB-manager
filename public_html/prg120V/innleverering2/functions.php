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

function sqlquerySelectAll($conn, $from) {
    global $messages;
    $sql = "SELECT * FROM $from ";
    $result = $conn->query($sql);

    if (!$result) {
        $messages[] = "Query Error: " . $conn->error;
        return []; // Return an empty array
    }

    // fetch the data as an associative array
    return $result->fetch_all(MYSQLI_ASSOC);
}

//eco the creating and the closing of the table and then loop through and echo the data in between with closing brackets for each row / loop through
//$fields as $field - loops through the array $fields and saves each passthrough to the value $field

function displayData($sqlQueryData, $fields){
    global $messages;
    if (!is_array($sqlQueryData) || ($sqlQueryData === 0)){
        echo "<tr><td colspan='" . count($fields) . "'>No rows found</td></tr>";
    } else {
        foreach ($sqlQueryData as $row) {
            echo "<tr>";

            foreach ($fields as $field) {
                if (isset($row[$field])) {
                echo "<td>" . htmlspecialchars($row[$field]) . "</td>";
            } else {
                echo "<td></td>"; // Empty cell for missing fields
            }
        }
        echo "</tr>";
        }
    }
}

/*Explained in php in 24hours by mat zandstra p. 101, 102
$tag is the tag the message should be displayed in, $txt is the message or text that is visitable and $func
is an optional function for styling in this case making the (primary key) underlined.

function createTable($tag, $txt, $func=""){
    if (function_exists($func))
        $txt =  $func($txt);
    return "<$tag>$txt</$tag>"
}
                <tr>
                    <th><u>brukernavn</u></th>
                    <th>fornavn</th>
                    <th>etternavn</th>
                    <th>klasseKode</th>
                </tr>
/*/

//Dynamic listbox to only include the Options that exist in the KLASSE table USED 3x
/*
$listBox_Sql = "SELECT klasseKode FROM KLASSE";
$result = mysqli_query($conn, $listBox_Sql);
//Options for listbox
if ($result->num_rows > 0)
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . ($row['klasseKode']) . ' "> ' . ($row['klasseKode']) . '</option>';
    } else {
    echo '<option value="input_klasseKode">No options available</option>';
}
*/

/* MORE FUNCTION THAT NEED TO BE IMPLEMENTED */

/*
if (isset($_POST['submit_STUDENT'])) { USED 4x
    $input_brukernavn = mysqli_real_escape_string($conn, $_POST['input_brukernavn']);
    $input_fornavn = mysqli_real_escape_string($conn, $_POST['input_fornavn']);
    $input_etternavn = mysqli_real_escape_string($conn, $_POST['input_etternavn']);
    $input_klasseKode = mysqli_real_escape_string($conn, $_POST['input_klasseKode']);
*/
//4
/* $sqlQueryData =sqlquerySelectAll($conn,'STUDENT' //where 'brukernavn'); */

/*if ($_SERVER["REQUEST_METHOD"] == "POST"){
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
            */
?>



