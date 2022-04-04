<?php
require_once "../inc/functions.php";
require_once "../inc/headers.php";


 //Käynnistetään sessio, johon talletetaan käyttäjä, jos kirjautuminen onnistuu
 session_start();

 $fname = filter_input(INPUT_POST, "etunimi");
 $lname = filter_input(INPUT_POST, "sukunimi");
 $uname=filter_input(INPUT_POST, "tunnus");
 $pword=filter_input(INPUT_POST, "salasana");
 $email=filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL);

 //Tarkistetaan onko muttujia asetettu
 if( !isset($uname) || !isset($pword) ){
     echo "Parametreja puuttui!! Ei voida kirjautua.";
     exit;
 }

 //Tarkistetaan, ettei tyhjiä arvoja muuttujissa
 if( empty($uname) || empty($pword) ){
     echo "Et voi asettaa tyhjiä arvoja!!";
     exit;
 }

 try{
     //Haetaan käyttäjä annetulla käyttäjänimellä
     $sql = "SELECT * FROM person WHERE username=?";
     $statement = $pdo->prepare($sql);
     $statement->bindParam(1, $uname);
     $statement->execute();

     if($statement->rowCount() <=0){
         echo "Käyttäjää ei löydy!!";
         exit;
     }
 
     $row = $statement->fetch();

     //Tarkistetaan käyttäjän antama salasana tietokannan salasanaa vasten
     if(!password_verify($pword, $row["password"] )){
         echo "Väärä salasana!!";
         exit;
     }

     //Jos käyttäjä tunnistettu, talletetaan käyttäjän tiedot sessioon
     $_SESSION["username"] = $uname;
     $_SESSION["fname"] = $row["firstname"];
     $_SESSION["lname"] = $row["lastname"];

     //Ohjataan takaisin etusivulle
     header("Location: ../../public/index.php"); 

 }catch(PDOException $e){
     echo "Kirjautuminen ei onnistunut<br>";
     echo $e->getMessage();
 }






?>