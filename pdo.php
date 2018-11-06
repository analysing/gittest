<?php
require_once 'Mysql.class.php';
$conf = require 'config.php';

$obj = new Mysql($conf);
var_dump($obj);
echo '<pre>';
var_dump($obj->fetchCol('select name from test'));
echo '</pre>';
$pdo = $obj->getPdo();
$res = $pdo->prepare('select * from test');
$res->execute();
$res->setFetchMode(PDO::FETCH_ASSOC);
if ($res !== false) {
    $row = $res->fetchColumn(1);

    if ($row !== NULL) {
        echo 'ivy: <pre>';
        var_dump($row);
        echo '</pre>';
    } else {
        echo 'ivyivy';
    }
} else {
    echo 'bill';
}