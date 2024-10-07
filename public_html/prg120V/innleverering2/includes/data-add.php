<?php                                     /* ***TODO ADD AJAX SHIFT TO SUCESS PAGE TO UPDATE AUTOMATICALLY AND NOT HAVE TO SEND 2 REQUESTS */
global $conn;
require("includes/dbh.inc.php");
require("index.php");

//Using mysqli_real_escape_string to escape characters and protect against SQL INJECTION.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //input data into table KLASSE
        if (isset($_POST['submit_KLASSE'])) {
            $input_klasseKode = mysqli_real_escape_string($conn, $_POST["input_klasseKode"]);
            $input_klassenavn = mysqli_real_escape_string($conn, $_POST["input_klassenavn"]);
            $input_studiumkode = mysqli_real_escape_string($conn, $_POST["input_studiumkode"]);

            if (!$input_klasseKode){
                echo "Error: KlasseKode is not filled out";
            }
            // Check if the klasseKode is longer than 3 character if TRUE print Error
            if (strlen($input_klasseKode) > 3) {
                echo "Error: Data not saved, KlasseKode only accepts a maximum length of 3 characters";
            } else {
                //make sure the primary key is unique
                //Query the database with sql to check all values that matches the values of $input_klassekode. to check for duplictes.
                $primarykeyKLASSE = "SELECT * FROM KLASSE WHERE klasseKode = '$input_klasseKode'";
                $result = mysqli_query($conn, $primarykeyKLASSE);

                if (($result->num_rows) > 0) {
                    $rowPrimaryIntegrity = $result->fetch_assoc(); //grabs the row and stores it in a associative array.
                    echo "A klasseKode with '" . $rowPrimaryIntegrity['klasseKode'] . "' already exists, duplicates of the klasseKode row are not allowed because its the primary key of the table.";
                } else {
                    $sql_KLASSE_add = "INSERT into KLASSE VALUES ('$input_klasseKode', '$input_klassenavn', '$input_studiumkode')";

                    if (mysqli_query($conn, $sql_KLASSE_add)) {
                        // Redirect to success page
                        header("Location: success.php");
                        exit();
                    } else {
                        echo "Error: " . mysqli_error($conn);
                    }
                }
            }
        }

        //input data into table STUDENT
        if (isset($_POST['submit_STUDENT'])) {
            $input_brukernavn = mysqli_real_escape_string($conn, $_POST['input_brukernavn']);
            $input_fornavn = mysqli_real_escape_string($conn, $_POST['input_fornavn']);
            $input_etternavn = mysqli_real_escape_string($conn, $_POST['input_etternavn']);
            $input_klasseKode = mysqli_real_escape_string($conn, $_POST['input_klasseKode']);

            //Checking if brukernavn is filled out
            if (!$input_klasseKode){
                echo "Error: klassekode er ikke fyllt ut";
            }
            //Checking if the brukernavn is longer than 3 characters
            if (strlen($input_brukernavn) > 3) {
                echo "Error: Data not saved, brukernavn only accepts a maximum length of 3 characters";
            } else {
                //make sure the primary key is unique warning
                $primarykeySTUDENT = "SELECT * FROM STUDENT WHERE brukernavn = '$input_brukernavn'";
                $result = mysqli_query($conn, $primarykeySTUDENT);

                if (($result->num_rows) > 0) {
                    $tablePrimaryIntegrity = $result->fetch_assoc();
                    echo "A 'brukernavn' with '" . $tablePrimaryIntegrity['brukernavn'] . "' already exists, duplicates of the 'brukernavn' row are not allowed because its the primary key of the table.";
                } else {
                    //Everything looks good insert the student information into the table
                    $sql_STUDENT_add = "INSERT into STUDENT VALUES ('$input_brukernavn', '$input_fornavn', '$input_etternavn', '$input_klasseKode')";

                    if (mysqli_query($conn, $sql_STUDENT_add)) {
                        echo "The row was added sucessfully!";
                    } else {
                        echo "Error: " .mysqli_error($conn);
                    }
                }
            }
        }
    }
                    /*   **** REFERENTIAL INTEGRITY HANDELING ***** Solved by using a drop boc */
/*  //check to make sure the user does not break referential integrity rules
    $RefIntegritySTUDENT = "SELECT * FROM KLASSE WHERE klasseKode = '$input_klasseKode'";
    $result = mysqli_query($conn, $RefIntegritySTUDENT); */

/* else {    **** REFERENTIAL INTEGRITY HANDELING *****

               //Check if the provided 'klasseKode' exists in the 'KLASSE' table
               $refIntegritySTUDENT = "SELECT * FROM KLASSE WHERE klasseKode = 'klasseKode'";
               $resultKLASSE = mysqli_query($conn, $refIntegritySTUDENT);

               //'Klasssekode' not found in the 'KLASSE' table
               if (mysqli_num_rows($result) == 0) {
                   $rowReferentialIntegrity = $result->fetch_assoc();
                   echo "The klasseKode '" . $input_klasseKode . "' needs to be created in the KLASSE TABLE firt, to maintain referential Integrity";
               } */


/* for (int i = 0; i != 0; i++){
   $input_klasseKode
} */

//prepare("INSERT INTO

//statement -> bind_param
//Prepared statements

//write list
//strcasecmp
//.innerhtml

//fetch_assoc()

?>
