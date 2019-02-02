<?php
namespace test;
echo 'hello ivy';

$config = require_once 'configs/main.php';
echo '<pre>';
var_dump($config);
echo '</pre>';

/**
 * test
 */
class Test
{
    public $a = 'ivy';
}

// use test\Test;
$name = 'Test';
$class_name = 'test\\'. $name;
$obj = new $class_name();
echo $obj->a;
