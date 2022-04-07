<?php
require_once "../inc/functions.php";
require_once "../inc/headers.php";

//Filtteroidaan POST-inputit
//orderFormiin syötetyt tiedot
$fname = filter_input(INPUT_POST, "etunimi");
$lname = filter_input(INPUT_POST, "sukunimi");
$address=filter_input(INPUT_POST, "osoite");
$zip=filter_input(INPUT_POST, "postinro");
$city=filter_input(INPUT_POST, "postitmp");
$email=filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL);
$phone=filter_input(INPUT_POST, "puhelinnro");

/* //Tarkistetaan onko muuttujia asetettu
if( !isset($fname) || !isset($lname) || !isset($address) || !isset($zip) || !isset($city) || !isset($email) || !isset($phone)){
    echo "Tietoja puuttui, tilaus ei onnistunut";
    exit;
} */

//Tarkistetaan, ettei tyhjiä arvoja muuttujissa
if( empty($fname) || empty($lname) || empty($address) || empty($zip) || empty($city) || empty($email) || empty($phone)){
    echo "Et voi asettaa tyhjiä arvoja!!";
    exit;
}

try{
    $db = openDB();
    //Suoritetaan parametrien lisääminen tietokantaan.
    $sql = "INSERT INTO tilaus (asiakasnro, tilauspvm) VALUES ((SELECT asiakasnro FROM as_tili where email=:email), curdate())";

    $statement = $db->prepare($sql);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();

    echo "Henkilön ".$fname." ".$lname." tilaus lisätty tietokantaan."; 
}catch(PDOException $e){
    echo "Tilausta ei voitu lisätä<br>";
    echo $e->getMessage();
    header("Location:http://localhost:3000/");
}

?>