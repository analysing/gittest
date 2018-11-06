<?php
// echo 'hello world';
extract(['a' => 'aa', 'b' => 'bb', 'c' => 'cc']);
// $content = 'hello world again';
require 'views/test.html';
$conf = require 'configs/main.php';
$dbh = new \PDO("mysql:host={$conf['db_host']};dbname={$conf['db_name']};charset={$conf['db_charset']};port={$conf['db_port']}", $conf['db_user'], $conf['db_pass']);
var_dump($dbh);

echo time();
echo '<br>', date('Y-m-t', strtotime('-1 month')); // 上个月最后一天

/*register_shutdown_function(function(){
    echo 'the end';
});*/

echo '<br>', floor((0.1 + 0.7) * 10) ,'<br>';
$arr = [1, 2, 3];
shuffle($arr);
print_r($arr);

class A
{
    static public function getClass($className = __CLASS__)
    {
        return $className;
    }
}

class B extends A
{

}

echo '<br>', B::getClass() ,'<br>';
echo substr(md5('ivy1234'), 8, 16);
echo strlen('cd15776cf44e82ca');
session_id('ivy1234');
$sess_path = session_save_path() .'/test';
if (!is_dir($sess_path)) mkdir($sess_path);
session_save_path($sess_path);
session_start();
if (isset($_SESSION)) {
    echo 'exists';
} else echo 'not exists';
$_SESSION['name'] = 'ivy';
session_name('bill');
echo '<br>', session_id() ,'<br>', session_name() ,'<br>';
// session_create_id('bill-');
echo session_id() ,'<br>', $sess_path ,'<br>';
echo '<pre>';
print_r($_SESSION);
echo '</pre>';

if (!isset($_SESSION)) {
    $sess_path = session_save_path() .'/cpweb';
    !is_dir($sess_path) && mkdir($sess_path);
    session_save_path($sess_path);
}
$str = 'hello ivy';
$key = 'str';
var_export(!!$$key);

// node data.js
// 注册 d
// 登录 d
// 充值
// 下注 d
// 提款
// 登出 d

// 开奖 d
// 判奖 d
// 结算 d
// 派彩 d
