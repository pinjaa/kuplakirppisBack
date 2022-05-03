<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

try {
    $db = openDB();
    selectAsJson($db, 'select * from kayttaja_tili');
} catch (PDOException $pdoex) {
    returnError($pdoex);
}