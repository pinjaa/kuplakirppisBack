<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

try {
    $db = openDB();
} catch (PDOException $pdoex) {
    returnError($pdoex);
}