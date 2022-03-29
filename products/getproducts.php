<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

$url = parse_url(filter_input(INPUT_SERVER, 'PATH_INFO'), PHP_URL_PATH);
$parameters = explode('/',$url);
$category_id = $parameters[1];

try {
    $db = openDB();
    
    $sql = "select * from kategoria where ktg_nro = $category_id";
    $query = $db->query($sql);
    $category = $query->fetch(PDO::FETCH_ASSOC);

    $sql = "select * from tuote where ktg_nro = $category_id";
    $query = $db->query($sql);
    $products = $query->fetchAll(PDO::FETCH_ASSOC);

    header('HTTP/1.1 200 OK');
    echo json_encode(array(
        "category" => $category['ktg_nimi'],
        "products" => $products
    )); 
}
catch (PDOException $pdoex) {
    returnError($pdoex);
}