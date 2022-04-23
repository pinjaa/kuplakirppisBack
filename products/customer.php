<?php

require_once "../inc/headers.php";
require_once "../inc/functions.php";
//Filtteroidaan POST-inputit
//orderFormiin syötetyt tiedot



$input=json_decode(file_get_contents('php://input'));
$name=filter_var($input->name,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$price=filter_var($input->price,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//$image=filter_var($input->image,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$description=filter_var($input->description,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$categoryID=filter_var($input->categoryID,FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$text = filter_input(INPUT_POST,'test',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
try{
    $db=openDB();
    if (isset($_FILES['file'])) {

        if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $filename = $_FILES['file']['name'];
            $type = $_FILES['file']['type'];
    
            if ($type === 'image/png') {
                $path ='../uploads/' . basename($filename);
    
                if (move_uploaded_file($_FILES['file']['tmp_name'],$path)) {
                    $dataS = array('filename' => $filename, 'type' => $type,'text' => $text);
                    
                    $sql="insert into tuote (tuotenimi,hinta,image,kuvaus,ktg_nro) values('$name',$price,'$text','$description',$categoryID)";
                   
                    $data=array('id'=>$db->lastInsertID(),'name' => $name,'price' => $price,'image' => $text, 'kuvaus' => $description, 'ktg_nro' => $categoryID);
                    echo json_encode($dataS);
                    executeInsert($db,$sql);
                    print json_encode($data);
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

  
}catch(PDOException $pdoex){
    returnError($pdoex);
}
 

 
 
 
?>