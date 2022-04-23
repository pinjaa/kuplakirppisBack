<?php
require_once "../inc/functions.php";
require_once "../inc/headers.php";

//Filtteroidaan POST-inputit (ei käytetä string-filtteriä, koska deprekoitunut)
//Jos parametria ei löydy, funktio palauttaa null
$fname = filter_input(INPUT_POST, "etunimi");
$lname = filter_input(INPUT_POST, "sukunimi");
$pword=filter_input(INPUT_POST, "salasana");
$email=filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL);
$user = filter_input(INPUT_POST,"user_type");



try{
    $db = openDB();
    if($user == null) {
        $user = 'E';
        //Suoritetaan parametrien lisääminen tietokantaan.
        $sql = "INSERT INTO kayttaja_tili (etunimi, sukunimi, salasana, email, admin_oikeus) VALUES (?,?,?,?,?)";
        $statement = $db->prepare($sql);
        $statement->bindParam(1, $fname);
        $statement->bindParam(2, $lname);

        $hashpw= password_hash($pword, PASSWORD_DEFAULT);
        password_verify($pword, $hashpw);
        $statement->bindParam(3, $hashpw);
        $statement->bindParam(4,$email);
        $statement->bindParam(5,$user);
        $statement->execute();
        
        $string = "Tervetuloa sinut on lisätty tietokantaan sähköpostilla ";

        $parts = [];
        $tok = strtok($string, " ");
        while ($tok !== false) {
            $parts[] = $tok;
            $tok = strtok(" ");
        }
        echo json_encode($parts),"\n";
        header("Location: http://localhost:3000/pages/Register");
    } else {
        //Suoritetaan parametrien lisääminen tietokantaan.
        $sql = "INSERT INTO kayttaja_tili (etunimi, sukunimi, salasana, email, admin_oikeus) VALUES (?,?,?,?,?)";
        $statement = $db->prepare($sql);
        $statement->bindParam(1, $fname);
        $statement->bindParam(2, $lname);
        
        $hashpw= password_hash($pword, PASSWORD_DEFAULT);
        password_verify($pword, $hashpw);
        $statement->bindParam(3, $hashpw);
        $statement->bindParam(4,$email);
        $statement->bindParam(5,$user);
        $statement->execute();

       // print json_encode("Tervetuloa ".$fname." ".$lname.". Sinut on lisätty tietokantaan sähköpostilla "."$email");
        header("Location: http://localhost:3000/pages/Register");
    }
    
}catch(PDOException $e){
  //echo "Käyttäjää ei voitu lisätä<br>";
    echo $e->getMessage();
    //header("Location: http://localhost:3000/");
}

?>