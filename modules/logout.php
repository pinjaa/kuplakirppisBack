<?php
require_once "../inc/functions.php";
require_once "../inc/headers.php";

if(isset($_SESSION["email"])) {
    try {
        logout();
        //header("Location: http://localhost:3000/");
    }

    catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>';
    }
}  
function logout() {

    $input = file_get_contents('php://input');
    $input = json_decode($input);
  

  //tuhotaan sesssio.
  session_unset();
  session_destroy();
 

 
  /* 
  ei toimi tervetuloa uudelleen


  try{ 
     $db = openDB();
      //Haetaan käyttäjä annetulla sähköpostiosoitteella
      $sql = "SELECT * FROM kayttaja_tili";
      $statement = $db->prepare($sql);
      $statement->execute();

      $row = $statement->fetch();

        $name = $row["etunimi"];
        $statement->bindValue(':etunimi', $name ,PDO::PARAM_STR);
        echo "Tervetuloa uudelleen $name";
 
  }catch(PDOException $e){
      echo "Kirjautuminen ei onnistunut<br>";
      echo $e->getMessage();
  }
} */

}
?>




