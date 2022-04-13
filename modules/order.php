<?php
require_once "../inc/functions.php";
require_once "../inc/headers.php";

$input = file_get_contents('php://input');
$input = json_decode($input);

//Filtteroidaan POST-inputit
//orderFormiin syötetyt tiedot
$fname = filter_var($input->etunimi, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$lname = filter_var($input->sukunimi, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$address=filter_var($input->osoite, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$zip=filter_var($input->postinro, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$city=filter_var($input->postitmp, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email=filter_var($input->email, FILTER_SANITIZE_EMAIL);
$phone=filter_var($input->puhelinnro, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

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

    $sql = "INSERT INTO as_tili (etunimi, sukunimi, email, osoite, postinro, postitmp, puhelinnro) VALUES ('" .
        filter_var($fname, FILTER_SANITIZE_FULL_SPECIAL_CHARS) . "','" .
        filter_var($lname, FILTER_SANITIZE_FULL_SPECIAL_CHARS) . "','" .
        filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS) . "','" .
        filter_var($address, FILTER_SANITIZE_FULL_SPECIAL_CHARS) . "','" .
        filter_var($zip, FILTER_SANITIZE_FULL_SPECIAL_CHARS) . "','" .
        filter_var($city, FILTER_SANITIZE_FULL_SPECIAL_CHARS) . "','" .
        filter_var($phone, FILTER_SANITIZE_FULL_SPECIAL_CHARS)
    . "')";

    $customer_id = executeInsert($db, $sql);

    $sql = "INSERT INTO tilaus (asiakasnro, tilauspvm) VALUES ($customer_id, curdate())";

    $order_id = executeInsert($db, $sql);

    $db->commit();

    header('HTTP/1.1 200 OK');
    $data = array('id' => $customer_id);
    echo json_encode($data);

    echo "Henkilön ".$fname." ".$lname." tilaus lisätty tietokantaan."; 
}catch(PDOException $e){
    $db->rollBack();
    echo "Tilausta ei voitu lisätä<br>";
    echo $e->getMessage();
    header("Location:http://localhost:3000/");
}

?>