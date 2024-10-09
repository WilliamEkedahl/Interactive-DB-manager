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
