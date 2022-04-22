<?php
require_once "../inc/functions.php";
require_once "../inc/headers.php";

//Filtteroidaan POST-inputit (ei käytetä string-filtteriä, koska deprekoitunut)
//Jos parametria ei löydy, funktio palauttaa null
$fname = filter_input(INPUT_POST, "etunimi");
$lname = filter_input(INPUT_POST, "sukunimi");
$pword=filter_input(INPUT_POST, "salasana");
$email=filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL);
/*
//Tarkistetaan onko muttujia asetettu
if( !isset($fname) || !isset($lname) || !isset($pword)|| !isset($email)){
    echo "Parametreja puuttui!! Ei voida lisätä henkilöä";
    exit;
}

//Tarkistetaan, ettei tyhjiä arvoja muuttujissa
if( empty($fname) || empty($lname) || empty($pword)|| empty($email)){
    echo "Et voi asettaa tyhjiä arvoja!!";
    exit;
}*/

try{
    $db = openDB();
    //Suoritetaan parametrien lisääminen tietokantaan.
    $sql = "INSERT INTO kayttaja_tili (etunimi, sukunimi, salasana, email) VALUES (?,?,?,?)";
    $statement = $db->prepare($sql);
    $statement->bindParam(1, $fname);
    $statement->bindParam(2, $lname);
    
    
    $hashpw= password_hash($pword, PASSWORD_DEFAULT);
    password_verify($pword, $hashpw);
    $statement->bindParam(3, $hashpw);
    $statement->bindParam(4,$email);
    $statement->execute();

    echo json_encode("Tervetuloa ".$fname." ".$lname.". Sinut on lisätty tietokantaan sähköpostilla "."$email");
    header("Location:http://localhost:3000/pages/Register");
}catch(PDOException $e){
  //echo "Käyttäjää ei voitu lisätä<br>";
   // echo $e->getMessage();
    header("Location:http://localhost:3000/");
}

?>