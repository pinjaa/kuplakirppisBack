<?php
require_once "../inc/functions.php";
require_once "../inc/headers.php";

$input = file_get_contents('php://input');
$input = json_decode($input);

//Filtteroidaan POST-inputit (ei käytetä string-filtteriä, koska deprekoitunut)
//Jos parametria ei löydy, funktio palauttaa null
$fname = filter_var($input->fname, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$lname = filter_var($input->lname, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$pword=filter_var($input->pword, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email=filter_var($input->email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$user = filter_var($input->user, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

try{
    $db = openDB();
    if($user == null) {
        $user = 'E';
        //Suoritetaan parametrien lisääminen tietokantaan.
        $sql = "INSERT INTO kayttaja_tili (etunimi, sukunimi, salasana, email, admin_oikeus) VALUES (?,?,?,?,?)";
        $statement = $db->prepare($sql);
        $statement->bindParam(1, $fname, PDO::PARAM_STR);
        $statement->bindParam(2, $lname, PDO::PARAM_STR);
        
        $hashpw= password_hash($pword, PASSWORD_DEFAULT);
        password_verify($pword, $hashpw);
        $statement->bindParam(3, $hashpw, PDO::PARAM_STR);
        $statement->bindParam(4,$email, PDO::PARAM_STR);
        $statement->bindParam(5,$user, PDO::PARAM_STR);
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
        $statement->bindParam(1, $fname, PDO::PARAM_STR);
        $statement->bindParam(2, $lname, PDO::PARAM_STR);
        
        $hashpw= password_hash($pword, PASSWORD_DEFAULT);
        password_verify($pword, $hashpw);
        $statement->bindParam(3, $hashpw, PDO::PARAM_STR);
        $statement->bindParam(4,$email, PDO::PARAM_STR);
        $statement->bindParam(5,$user, PDO::PARAM_STR);
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