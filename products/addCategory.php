<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

$input= json_decode(file_get_contents('php://input'));
$name=filter_var($input->name,FILTER_SANITIZE_FULL_SPECIAL_CHARS);

try{
    $db=openDB();
    $sql="insert into kategoria (ktg_nimi) values ('$name')";
    executeInsert($db, $sql);
    $data=array('id' =>$db->lastInsertID(),'name'=>$name);
    print json_encode($data);
}catch(PDOException $pdoex){
    returnError($pdoex);
}
  