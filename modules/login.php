<?php
require_once "../inc/functions.php";
require_once "../inc/headers.php";

if(!isset($_SESSION["email"])) {
    try {
        login();
        //header("Location: http://localhost:3000/");
    }

    catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>';
    }
    
} else {
    logout();
}

function login() {

    $input = file_get_contents('php://input');
    $input = json_decode($input);

    $email = filter_var($input->email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pword = filter_var($input->pword, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    //Käynnistetään sessio, johon talletetaan käyttäjä, jos kirjautuminen onnistuu
    session_start();
    
 
  try{
     $db = openDB();
      //Haetaan käyttäjä annetulla sähköpostiosoitteella
      $sql = "SELECT * FROM kayttaja_tili WHERE email='$email'";
      $statement = $db->prepare($sql);
      $statement->execute();

      $rows = $db->query($sql)->fetchAll();
      $row = $statement->fetch();

      if(count($rows) <=0){
          $msg = "Käyttäjää ei löydy!!";
          $isAdmin = false;
          $success = false;
      }else if($email=="admin@admin.com" && $pword==$row["salasana"]) {

            $_SESSION["email"] = $email;
            $nimi = "admin";
            $isAdmin = true;
            $success = true;
            
            $msg = "Tervetuloa $nimi!";

      }else if(!password_verify($pword, $row["salasana"] )){
          $msg = "Väärä salasana!!";
          $isAdmin = false;
          $success = false;
      }else {
        //Jos käyttäjä tunnistettu, talletetaan käyttäjän tiedot sessioon
        $_SESSION["email"] = $email;

        if($row["admin_oikeus"] == 'K') {
            $isAdmin = true;
        }else {
            $isAdmin = false;
        }
        
        $nimi = $row["etunimi"];
        $statement->bindValue(':etunimi', $nimi ,PDO::PARAM_STR);

        $success = true;
        $msg = "Tervetuloa $nimi!";
      }

    header('Content-Type: application/json');
    echo json_encode(array(
        "msg" => $msg,
        "isAdmin" => $isAdmin,
        "success" => $success
    ));
  }catch(PDOException $e){
      echo "Kirjautuminen ei onnistunut<br>";
      echo $e->getMessage();
  }
}


function logout() {
    //Tyhjennetään ja tuhotaan nykyinen sessio.
    try{ 

        session_unset();
        session_destroy();
    }catch(Exception $e){
        session_unset();
        session_destroy();
        throw $e;
    }
}



?>




