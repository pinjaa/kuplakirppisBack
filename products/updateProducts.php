<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

$url = parse_url(filter_input(INPUT_SERVER, 'PATH_INFO'), PHP_URL_PATH);
$parameters = explode('/',$url);
$category_id = $parameters[1];
$product_id = $parameters[2];

$input=json_decode(file_get_contents('php://input'));
$name=filter_var($input->name,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$price=filter_var($input->price,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$description=filter_var($input->description,FILTER_SANITIZE_FULL_SPECIAL_CHARS);

try{
    $db=openDB();
    $sql="update tuote SET tuotenimi = COALESCE(NULLIF('$name', ''), tuotenimi), hinta = COALESCE(NULLIF($price, ''), hinta), kuvaus = COALESCE(NULLIF('$description', ''), kuvaus) WHERE id = $product_id";
    executeInsert($db,$sql);
    $data=array('id'=>$product_id,'tuotenimi' => $name,'hinta' => $price, 'kuvaus' => $description);
    print json_encode($data);
}catch(PDOException $pdoex){
    returnError($pdoex);
}
  