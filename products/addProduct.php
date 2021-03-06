<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

$input=json_decode(file_get_contents('php://input'));
$name=filter_var($input->name,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$price=filter_var($input->price,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$image=filter_var($input->image,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$description=filter_var($input->description,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$categoryID=filter_var($input->categoryID,FILTER_SANITIZE_FULL_SPECIAL_CHARS);

try{
    $db=openDB();
    $sql="insert into tuote (tuotenimi,hinta,image,kuvaus,ktg_nro) values('$name',$price, '$image','$description',$categoryID)";
    executeInsert($db,$sql);
    $data=array('id'=>$db->lastInsertID(),'tuotenimi' => $name,'hinta' => $price, 'image' => $image, 'kuvaus' => $description, 'ktg_nro' => $categoryID);
    print json_encode($data);
}catch(PDOException $pdoex){
    returnError($pdoex);
}