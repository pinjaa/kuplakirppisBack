<?php
require_once "../inc/functions.php";
require_once "../inc/headers.php";


 //Käynnistetään sessio, johon talletetaan käyttäjä, jos kirjautuminen onnistuu
 session_start();
/*  $fname = filter_input(INPUT_POST, "etunimi");
 $lname = filter_input(INPUT_POST, "sukunimi"); */
 $email = filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL);
 $pword = filter_input(INPUT_POST, "salasana");


 //Tarkistetaan onko muttujia asetettu
 if( !isset($email) || !isset($pword) ){
     echo "Parametreja puuttui!! Ei voida kirjautua.";
     exit;
 }
 

 //Tarkistetaan, ettei tyhjiä arvoja muuttujissa
 if( empty($email) || empty($pword) ){
     echo "Et voi asettaa tyhjiä arvoja!!";
     exit;
 }

 try{
    $db = openDB();
     //Haetaan käyttäjä annetulla sähköpostiosoitteella
     $sql = "SELECT * FROM as_tili WHERE email=?";
     $statement = $db->prepare($sql);
     $statement->bindParam(1, $email);
     $statement->execute();

     if($statement->rowCount() <=0){
         echo "Käyttäjää ei löydy!!";
         exit;
     }
 
     $row = $statement->fetch();

     //Tarkistetaan käyttäjän antama salasana tietokannan salasanaa vasten
     if(!password_verify($pword, $row["salasana"] )){
         echo "Väärä salasana!!";
         exit;
     }

     //Jos käyttäjä tunnistettu, talletetaan käyttäjän tiedot sessioon
     $_SESSION["email"] = $email;
    /*  $_SESSION["fname"] = $row["etunimi"];
     $_SESSION["lname"] = $row["sukunimi"]; */

     echo "Tervetuloa. Kirjautuminen onnistui "."$email"; 

 }catch(PDOException $e){
     echo "Kirjautuminen ei onnistunut<br>";
     echo $e->getMessage();
         //Ohjataan takaisin etusivulle
         header("Location:http://localhost:3000/");
 }
?>




