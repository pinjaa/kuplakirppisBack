<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

$uri = parse_url(filter_input(INPUT_SERVER,'PATH_INFO'),PHP_URL_PATH);
$parameters = explode('/',$uri);

$searchPhrase = $parameters[1];

try {
    $db = openDb();
    $sql = "select * from tuote where tuotenimi like '%$searchPhrase%'";
    selectAsJson($db,$sql);
} 
catch (PDOException $pdoex) {
    returnError($pdoex);
}