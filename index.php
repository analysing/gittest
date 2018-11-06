<?php
echo 'hello ivy';
session_name('bill00');
session_start();
echo '<br>', $_SESSION['gender'];

defined('CTRL_PATH') or define('CTRL_PATH', __DIR__ .'/controllers/');
defined('VIEW_PATH') or define('VIEW_PATH', __DIR__ .'/views/');
defined('VENDOR_PATH') or define('VENDOR_PATH', __DIR__ .'/vendors/');
defined('CONF_PATH') or define('CONF_PATH', __DIR__ .'/configs/');
defined('EXT')       or define('EXT', '.php');

$c = filter_input(INPUT_GET, 'c'); // controller
$a = filter_input(INPUT_GET, 'a'); // action
!$c && $c = 'Index';
!$a && $a = 'index';

// 自动加载
spl_autoload_register(function ($c) {
    if (is_file(CTRL_PATH . $c . EXT)) {
        require CTRL_PATH ."\\". $c . EXT;
    }elseif (is_file(__DIR__ .'/'. $c . EXT)) {
        require __DIR__ .'/'. $c . EXT;
    }else{
        exit('找不到相应类');
    }
});

$class = "\\controllers\\". $c;
$obj = new $class();
$obj->$a();
