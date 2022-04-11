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
    $db->beginTransaction();
    //Suoritetaan parametrien lisääminen tietokantaan.
    //$sql = "INSERT INTO tilaus (asiakasnro, tilauspvm) VALUES ((SELECT asiakasnro FROM as_tili where email=:email), curdate())"; jos kirjautuneena

    $sql = "INSERT INTO as_tili (etunimi, sukunimi, email, osoite, postinro, postitmp, puhelinnro) VALUES (?,?,?,?,?,?,?);";

    $statement = $db->prepare($sql);
    $statement->bindParam(1, $fname, PDO::PARAM_STR);
    $statement->bindParam(2, $lname, PDO::PARAM_STR);
    $statement->bindParam(3, $email, PDO::PARAM_STR);
    $statement->bindParam(4, $address, PDO::PARAM_STR);
    $statement->bindParam(5, $zip, PDO::PARAM_STR);
    $statement->bindParam(6, $city, PDO::PARAM_STR);
    $statement->bindParam(7, $phone, PDO::PARAM_STR);
    $statement->execute();

    $sql = "INSERT INTO tilaus (asiakasnro, tilauspvm) VALUES ((SELECT asiakasnro FROM as_tili where email=:email), curdate())";

    $statement = $db->prepare($sql);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();

    $db->commit();

    echo "Henkilön ".$fname." ".$lname." tilaus lisätty tietokantaan."; 
}catch(PDOException $e){
    $db->rollBack();
    echo "Tilausta ei voitu lisätä<br>";
    echo $e->getMessage();
    header("Location:http://localhost:3000/");
}

?>