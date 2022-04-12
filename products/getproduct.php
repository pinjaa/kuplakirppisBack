<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

$url = parse_url(filter_input(INPUT_SERVER, 'PATH_INFO'), PHP_URL_PATH);
$parameters = explode('/',$url);
$category_id = $parameters[1];
$product_id = $parameters[2];

try {
    $db = openDB();
    
    $sql = "select ktg_nro from kategoria where ktg_nro = $category_id";
    $query = $db->query($sql);
    $category = $query->fetch(PDO::FETCH_ASSOC); 

    $sql = "select * from tuote where id = $product_id";
    $query = $db->query($sql);
    $product = $query->fetchAll(PDO::FETCH_ASSOC);

    header('HTTP/1.1 200 OK');
    echo json_encode(array(
        "category" => $category['ktg_nro'],
        "product" => $product
    )); 
}
catch (PDOException $pdoex) {
    returnError($pdoex);
}