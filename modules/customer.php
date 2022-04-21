<?php

require_once "../inc/headers.php";
require_once "../inc/functions.php";
/*Filtteroidaan POST-inputit
//orderFormiin syötetyt tiedot
$tuote = filter_input(INPUT_POST, "tuotenimi");
$hinta = filter_input(INPUT_POST, "hinta");
$kategoria = filter_input(INPUT_POST, "ktg_nro");
//$image=filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL);
$kuvaus=filter_input(INPUT_POST, "kuvaus");

/* //Tarkistetaan onko muuttujia asetettu
if( !isset($fname) || !isset($lname) || !isset($address) || !isset($zip) || !isset($city) || !isset($email) || !isset($phone)){
    echo "Tietoja puuttui, tilaus ei onnistunut";
    exit;
} 

//Tarkistetaan, ettei tyhjiä arvoja muuttujissa
if( empty($fname) || empty($lname) || empty($email) || empty($phone)){
    echo "Et voi asettaa tyhjiä arvoja!!";
    exit;
}

try{
    $db = openDB();
    //Suoritetaan parametrien lisääminen tietokantaan.
    $sql = "INSERT INTO tuote(tuotenimi, hinta,kategoria, kuvaus) values (?,?,?,?)";
   

   $statement = $db->prepare($sql);
   $statement->bindParam(1, $tuote);
   $statement->bindParam(2, $hinta);
   $statement->bindParam(3, $kategoria);
   //$statement->bindParam(3, $image);
    $statement->bindParam(4,$kuvaus);
    $statement->execute();

    echo "Palaute lähetetty"; 
}catch(PDOException $e){
    echo "Palautetta ei voitu lähettää<br>";
    echo $e->getMessage();
    header("Location:http://localhost:3000/");
}
 */

 $text = filter_input(INPUT_POST,'test',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
 
 if (isset($_FILES['file'])) {

    if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $filename = $_FILES['file']['name'];
        $type = $_FILES['file']['type'];

        if ($type === 'image/png') {
            $path ='../uploads/' . basename($filename);

            if (move_uploaded_file($_FILES['file']['tmp_name'],$path)) {
                $data = array('filename' => $filename, 'type' => $type,'text' => $text);
                echo json_encode($data);
            } else {
                echo 'Error saving file to upload';
            }
        } else {
            echo 'Wrong file type';
        }
    } else {
        echo 'Error uploading file';
    }
 } else  {
     echo 'File was not submitted.';
 }
?>