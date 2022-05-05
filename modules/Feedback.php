<?php
require_once "../inc/functions.php";
require_once "../inc/headers.php";

//Filtteroidaan POST-inputit
$fname = filter_input(INPUT_POST, "etunimi");
$lname = filter_input(INPUT_POST, "sukunimi");
$email=filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL);
$phone=filter_input(INPUT_POST, "puhelinnro");

try{
    $db = openDB();
    $msg = "Palaute lähetetty";
    echo json_encode($msg) ;
}catch(PDOException $e){
    echo "Palautetta ei voitu lähettää<br>";
    echo $e->getMessage();
    header("Location:http://localhost:3000/");
}

?>