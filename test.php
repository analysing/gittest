<?php
require_once 'functions.php';
class Db
{

}

class Mdl
{
	public $db;

	public function __construct()
	{
		$this->db = new Db();
	}
}

class Mdl2
{
	public $db;

	public function __construct($db)
	{
		echo 'bill';
		$this->db = $db;
	}

	static public function test()
	{
		echo 'ivy';
	}
}

$m = new Mdl();

// $m2 = new Mdl2((new Db())); // 解决依赖
Mdl2::test();

$r = new ReflectionClass('PDO');
if ($m instanceof Mdl2) {
	echo 'ivy';
}else echo 'bill';

echo '<br>';
$message = 'hello';

// 没有 "use"
/*$example = function () {
    var_dump($message);
};
echo $example();*/

// 继承 $message
$example = function () use ($message) {
    var_dump($message);
};
echo $example();

$example = function ($message) {
	var_dump($message);
};
echo $example($message);

echo '<br>';
// session_start();
// echo session_id();

function normal($i = 1, $sum = 0)
{
	do {
		$sum += $i;
		$i++;
	} while($i <= 10);
	return $sum;
}
echo '<br>', normal();

function recursive($i = 1, $sum = 0)
{
	if ($i > 10) return $sum;
	$sum += $i;
	echo $sum ,'<br>';
	recursive(++$i, $sum);
}
echo recursive();

// 2018-06-15 23:02:00
// 2018-06-15 23:59:00
echo '<br>', strtotime(date('Y-m-d') . " 23:02:00") ,'<br>';
echo strtotime(date('Y-m-d') . ' 23:59:00');
echo '<br>', substr('JSLH8061418302505831P', -9, 8) ,'<br>';
var_dump(filter_var('0.0.0.0',  FILTER_VALIDATE_IP)); // 成功返回原字串，失败返回false
echo '<br>', strlen('fca4c61d0fa7');

/*echo $b = 'bill';
function reference(&$a = '')
{
	$a = 'ivy';
	return true;
}
var_dump(reference($b));
echo $b;*/
echo '<br>', -round(0.00999, 1) ,'<br>';
$sample = ['01', '02', '03'];
shuffle($sample);
$openCode = implode(' ', $sample);
echo $openCode;

$str = 'string';
$chars = preg_split('//', $str, -1, PREG_SPLIT_NO_EMPTY);
print_r($chars);

echo date('Y-m-d H:i:s', 1530605722);
$mobile = '19984241111';
var_dump(preg_match('`^1[3|4|5|7|8|9][0-9]{9}$`', $mobile));

$sql = 'select * from test limit 1';
echo $sql = trim($sql . (stripos($sql, 'LIMIT 1') === false ? ' LIMIT 1' : ''));

/*function test()
{
	static $i = 0;
	echo ++$i ,'<br>';
}
$i = 1;
test();
test();
test();
test();*/
class test
{
	public static $i;
	public $name;
	public static $profile = 'hahaha..';

	public function __construct()
	{
		echo 'bill';
	}

	public function isNamed()
	{
		if (isset($this->name)) {
			echo 'ivy';
		} else echo 'bill';
	}

	public static function t1()
	{
		self::$i++;
	}

	public function t2()
	{
		$this->name = 'ivy';
		echo $this->name .' testing';
	}
}
/**
* T1
*/
class T1 extends test
{
	private $aa = 'bb';
	public $bb = 'vv';
	static public $instance;

	function __construct()
	{
		parent::__construct();
		echo 'ivyivy';
	}

	public function t2()
	{
		parent::t2();
		echo 'test';
	}

	public function __get($name)
	{
        if (isset($this->$name)) {
        	echo 'hahaha...';
            return $this->$name;
        }
        return null;
	}

	static public function getClass()
	{
		self::$instance = new self();
		return self::$instance;
	}

}
test::t1();
echo test::$i;
(new test)->isNamed();
// (new test)->$profile;

$bool = false;
if (!($t = $bool)) {
	echo 'ivy';
} else echo 'bill';

$a = 1;$b = 2;
echo $GLOBALS['b'];
function t1()
{
	global $b;
	echo $GLOBALS['a'];
	$b = $GLOBALS['a'] + $b;
}
t1();
echo $b;
$t1 = new T1();
$t1->t2();
echo '<br>', $t1->aa ,'<br>', $t1->bb ,'<br>';

$issue = '20180715-0001';
$date = substr($issue, 0, 8); // date
echo '<br>', $date ,'<br>';
var_dump(stripos($issue, '-'));
$symbol = stripos($issue, '-') !== false ? '-' : ''; // symbol
echo '<br>', $num = ltrim(substr($issue, 8), '-'); // num
echo '<br>ivy: ', $length = strlen($num);
// echo '<br>', ++$num;
echo '<br>', $next_num = sprintf("%0{$length}d", ++$num); // next num
echo '<br>', $next_date = date('Ymd', strtotime($date) + 24 * 60 * 60); // next date
echo '<br>', $next_issue = $date . $symbol . $next_num; // next issue
echo '<br>', $time = strtotime(date("Y-m-d 23:59:59", strtotime("-1 day")));
echo '<br>';
$b = null;
if ($b == null) {
	echo 'ivy';
} else echo 'bill';
// echo $i;
$i = 1.03652969;
$i = floor($i * 100000) / 1000;
echo number_format($i, 3) .'%';

$arr = ['name' => 'ivy', 'birth' => '93-05-01', 'profile' => ['hello ivy', 'bill']];
if (array_key_exists('birth', $arr)) {
	echo '<br>', $arr['birth'];
} else echo '<br>', $arr['profile'][0];

$arr = array(
0 =>
  array (
    'rebate' => '9.5',
    'prizeMode' => 1990,
    'prizeShow' => '1990/995',
  ),
1 =>
  array (
    'rebate' => '9.4',
    'prizeMode' => 1988,
    'prizeShow' => '1988/994',
  ),
);
$arr[0] = array_shift($arr);
echo '<pre>';
print_r($arr);
echo '</pre>';

$username = 'bill@ivy?xiaolu？xiaohui，xiaohaha,joker-aa|bb$cc%dd';
if ($arr = preg_split('/\s*[,\?？,，\-\|\$%@]\s*/',trim($username),-1,PREG_SPLIT_NO_EMPTY)) {
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
} else echo '5555'; // 逗号 空格 ? @ - | $ %

$arr = ['bill66', 'bill66', 'bill88', 'bill00', 'bill00', 'bill99'];
$unique = array_unique($arr);
$diff = array_diff_assoc($arr, $unique);
var_dump($diff);

$arr = [7, 7, 7, 7];
if (count($arr) != count(array_unique($arr))) {
	echo 'ivyivy'; // output
} else echo 'bill';

/*$sum = 0;
for ($i=0; $i < 28; $i++) { 
	$sum += $arr[$i];
	$arr[$i] *= 2;
}*/
trigger_error('ivy1234', E_USER_WARNING);
/*echo '<br>', $n;
echo '<pre>';
print_r($arr);
echo '</pre>';*/

echo '<pre>';
print_r(explode(',', 'bill666'));
echo '</pre>';

echo date('Y-m-d H:i:s', 1526556369);
echo '<br>', date('Y-m-d H:i:s', 1533358308);
$arr = ['name' => ''];
var_dump(intval('-1|1'));

$date = '';
if ($date == date('Y-m-d', strtotime($date))) {
	echo 'ivyivy';
} else echo 'bill';
echo '<pre>';
var_dump(T1::getClass());
echo '</pre>';
echo str_replace('0', 'i', '0123401234');
echo '<br>', preg_replace('/^0/', 'i', '0123401234');
$arr = [
	['name' => 'bill', 'profile' => 'hahaha..'],
	['name' => 'ivy', 'profile' => 'hello ivy'],
];
var_dump(end($arr)['name']);
echo 'hello world';

/**
* combo
*/
/*class Combo
{
	static $tmpArr;

	static public function zuhe($arr,$begin){
        if(!is_array($arr)) return ;
        $N = count($arr);
        if($begin == $N-1 || $begin >$N || $begin <0) return ;
        //循环将初始值与第i个值交换后进行组合
        for($i = $begin;$i < $N;$i++){
            $t = $arr[$begin];
            $arr[$begin] = $arr[$i];
            $arr[$i] = $t;
            if($i!==$begin){//i==begin时的数已经输出过
                self::$tmpArr[]  = $arr;
            }
            self::zuhe($arr,$begin+1);
            $t = $arr[$begin];
            $arr[$begin] = $arr[$i];
            $arr[$i] = $t;

        }
    }

    static public function getRes()
    {
    	return self::$tmpArr;
    }
}*/
// Combo::zuhe([1, 2, 3, 4, 5], 0);
// echo '<pre>';
// var_dump(Combo::$tmpArr);
// echo '</pre>';

/*echo '<pre>';
print_r($_SERVER);
echo '</pre>';*/

echo '<br>', $s = password_hash('aa123456', PASSWORD_DEFAULT) ,'<br>';

var_dump(password_verify('aa123456', '851ccbe4fe0034389124d37d69f7ebb9'));
echo '<br>', substr('GD58100304411421933P', -9, 8);
echo '<br>', 11 & 4;
$delay_day = 0;
echo '<br>', date('Y-m-d', strtotime('-' . $delay_day . ' days')) ,'<br>';

session_name('bill00');
session_start();
$_SESSION['gender'] = 'female';
echo 'ivy: ', session_id() ,' ', session_name();
var_dump(('2018-10-18 23:00:00' < date('Y-m-d 00:00:00') ? true : false));
function cmp($a, $b)
{
    if ($a == $b) {
        return 0;
    }
    return ($a > $b) ? -1 : 1;
}

$a = array(3, 2, 5, 6, 1);

usort($a, "cmp");

echo '<pre>';
print_r($a);
echo '</pre>';

$a = ['bill', 'ivy', 'sa', 'admin', 'root', 'c' => 0];
$b = [['a' => 'aa', 'b' => 'bb', 'c' => 'cc'], ['a' => 'apple', 'b' => 'boy', 'c' => 'cat']];
echo '<pre>';
print_r($a);
print_r(array_reverse($a));
print_r(array_spec_key($b, 'b'));
echo '</pre>';
if (!empty($a['c'])) {
    echo 'hahahahahahaha';
} else echo 'xixiixixixix';

function array_spec_key($array, $key, $unset_key = false)
{
    if (empty($array) || !is_array($array)) {
        return array();
    }

    $new_array = array();
    foreach ($array AS $value) {
        if (!isset($value[$key])) {
            continue;
        }
        $value_key = $value[$key];
        if ($unset_key === true) {
            unset($value[$key]);
        }
        $new_array[$value_key] = $value;
    }

    return $new_array;
}

/**
 * A
 */
class AClass
{
    public function test()
    {
        return 'hahaha';
    }
}

/**
 * B
 */
class BClass extends AClass
{
    public function test()
    {
        return 'xixixi';
    }
}

/**
 * C
 */
class CClass
{
    public function doTest(AClass $obj)
    {
        echo $obj->test();
    }
}

$b = new BClass();
$c = new CClass();
$c->doTest($b);

var_dump(empty(1));
echo '<br>', date('Y-m-d H:i:s', 1541419105);
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

$a = ['issue' => json_encode(['name' => 'bill', 'email' => 'bill@user.com', 'profile' => 'hahaha..']), 'issue1' => json_encode(['name' => 'ivy', 'email' => 'ivy@user.com', 'profile' => 'hello world'])];
echo '<pre>';
var_dump($a);
$b = json_decode(json_encode($a), true);
var_dump(json_decode($b['issue'], true)); // 不能解开内部的json
echo '</pre>';

eval('$a = [2,2,4,5,1,4,4];');
eval("\$a = [2,2,4,5,1,4,4];");
// $a = '[2,2,4,5,1,4,4]';
var_dump($a);
echo '<pre>';
var_dump(unserialize('a:1:{i:0;a:9:{s:6:"is_use";s:1:"1";s:10:"start_time";s:8:"05:00:00";s:14:"first_end_time";s:8:"09:07:00";s:8:"end_time";s:8:"23:59:59";s:5:"cycle";s:3:"300";s:8:"end_sale";s:2:"60";s:9:"drop_time";s:2:"60";s:9:"code_time";s:1:"0";s:9:"frag_sort";s:1:"0";}}'));
echo '</pre>';

$data = ['a', 'a', 'a', 'a', 'b', 'b', 'a', 'b', 'b', 'b', 'b', 'b', 'b', 'b', 'b', 'b', 'a', 'a'];


$arr = dewdrop_handle($data);
$dewdrop = get_last_dewdrop($arr);
$arr = add_element($arr, 'a');
echo '<pre>';
print_r($arr);
print_r($dewdrop);
echo '</pre>';
echo '<table>';
for ($i=0; $i < count($arr); $i++) { 
    echo '<tr>';
    for ($j=0; $j < 8; $j++) { 
        echo '<td>', isset($arr[$i][$j]) ? $arr[$i][$j] : '' ,'</td>';
    }
    echo '</tr>';
}
echo '</table>';
// echo implode(',', 1);
echo '8线';
// echo 'QQ1123089414905096P';
// echo number_format('10,000.0000', 4);
echo '<br>', date('Y-m-d H:i:s', 1543049008);
// var_dump(openssl_pkey_get_private(file_get_contents('rsa_private_key.pem')));
// require_once 'Rsa.php';
// $r = new Rsa();
// $res = $r->publicEncrypt(base64_encode('hello ivy'));
// echo '<br>privateKey:', $r->privateKey;
// echo '<br>publicKey:', $r->publicKey;
// echo '<br>decrypt:', base64_decode($r->privateDecrypt($res));
// $wx = 'wx_sdf45123';
// var_dump(preg_match('`^[a-zA-Z0-9][a-zA-Z0-9_\-]{5,19}$`', $wx));
function chk_prize($prize, $open_zodiac, $zodiac = '狗')
{
    $level = 0;
    $betZodiac = explode('_', $prize); // 家禽_野兽
    if ($betZodiac[0] == '家禽') {
        $arr = ['猪','狗','鸡','羊','马','牛'];
        if (in_array($open_zodiac, $arr)) {
            $level = in_array($zodiac, $arr) ? 2 : 1;
        }
    }
    if ($betZodiac[0] == '野兽' || isset($betZodiac[1])) {
        $arr = ['鼠','猴','蛇','龙','兔','虎'];
        if (in_array($open_zodiac, $arr)) {
            $level = in_array($zodiac, $arr) ? 2 : 1;
        }
    }
    return $level;
}
echo '<br>', chk_prize('家禽_野兽', '马');
var_dump(json_decode(null, true));
$a = [['name' => 'bill'], ['name' => 'ivy']];
echo '<br>', current($a)['name'];
$issue = '2018150';
echo $next_issue = substr(++$issue, 0, 4) == 2017 ? $issue : date('Y') .'001';
$path = 'https://m.xy0test.com//images_fh/upload/2017/12/1514266527757.jpg';
preg_match('@.*(images_fh.*)$@', $path, $macth);
echo $s = isset($macth[1]) ? $macth[1] : '';
$arr = ['n1' => 'bill', 'n2' => 'ivy'];
$res = '{"errorCode":0,"message":"操作成功","result":{"businessCode":0,"data":{"preDrawCode":"05,06,10,12,14,15,21,24,26,28,33,40,44,56,57,61,65,67,68,80,01","drawIssue":926698,"drawTime":"2018-12-17 17:25:00","preDrawTime":"2018-12-17 17:20:00","preDrawDate":"2018-12-17 00:00:00","preDrawIssue":926697,"drawCount":100,"sumNum":732,"sumBigSmall":-1,"sumSingleDouble":-1,"sdrawCount":"","singleDoubleCount":-1,"frontBehindCount":1,"sumBsSd":4,"sumWuXing":2,"status":0,"frequency":"","lotCode":10014,"iconUrl":"","shelves":1,"groupCode":7,"lotName":"北京快乐8","totalCount":179,"serverTime":"2018-12-17 17:21:26","index":100},"message":"操作成功"}}';
echo '<pre>';
// print_r(unserialize('a:22:{i:1962;i:20000000;i:1960;i:20000000;i:1958;i:20000000;i:1956;i:1020000000;i:1954;i:940000000;i:1952;s:8:"10000000";i:1950;s:8:"10000000";i:1940;s:8:"10000000";i:1930;s:8:"10000000";i:1920;s:8:"10000000";i:1910;s:8:"10000000";i:1900;s:8:"10000000";i:1890;s:8:"10000000";i:1880;s:8:"10000000";i:1870;s:8:"10000000";i:1860;s:8:"10000000";i:1850;s:8:"10000000";i:1840;s:8:"10000000";i:1830;s:8:"10000000";i:1820;s:8:"10000000";i:1810;s:8:"10000000";i:1800;s:8:"10000000";}'));
print_r(json_decode('{"time":1544671997869,"current":{"periodNumber":925911,"awardTime":"2018-12-13 11:30:00","awardNumbers":"05,08,09,15,20,30,42,43,45,48,49,52,53,56,60,61,64,71,72,74","pan":"3"},"next":{"periodNumber":925912,"awardTime":"2018-12-13 11:35:00","awardTimeInterval":102130,"delayTimeInterval":15}}', true));
// echo date('Y-m-d H:i:s', 1544671997);
echo rand(100000, 999999) . time();
print_r($arr);
array_unshift($arr, 'hahaha..');
print_r($arr);
array_unshift($arr, 'xixixi..');
print_r($arr);
print_r(json_decode($res, true));
echo '</pre>';
var_dump(preg_match('`^\d,\d,\d$`i', '1,1,1'));
echo '<br>', substr(md5('latest1'), 8, 16);
if ('2.0' > '1.9.9') {
    echo 'ivyivy ', ('2.0.14' - '1.9.9');
} else echo 'bill';
var_dump(!'1');

function breakUpdateTime($start_time,$end_time,$days = 6 ){
    if(empty($start_time) || empty($end_time)){
        return [];
    }
    $qitianqian = date('Y-m-d',strtotime('-'.$days.' days'));
    //算上今天 七天前的数据
    if(strtotime($end_time)<strtotime($qitianqian)){
        return [
            'now' => [],
            'history' => ['start_time'=>$start_time,'end_time'=>$end_time],
        ];
    }else if(strtotime($start_time)<strtotime($qitianqian)&&strtotime($end_time)>= strtotime($qitianqian)){
        return [
            'now' => ['start_time'=>$qitianqian,'end_time'=>$end_time],
            'history' => ['start_time'=>$start_time,'end_time'=>$qitianqian],
        ];
    }else{
        return [
            'now' => ['start_time'=>$start_time,'end_time'=>$end_time],
            'history' => [],
        ];
    }
}
$arr = breakUpdateTime('2018-12-18', '2018-12-18');
var_dump($arr);
echo '2018-12-21 18:50:00<br>', date('Y-m-d H:i:s', 1545404532);
echo '<br>', microtime(true);
echo '<br>', microtime();
$dom = new DOMDocument();
// var_dump($dom);
var_dump($dom->loadHTMLFile('test2.html'));
// var_dump($dom);
// echo $dom->saveHTML();
$div = $dom->getElementsByTagName('div');
// var_dump($div);
foreach ($div as $k => $v) {
    // var_dump($v);
    echo $k ,': ', $v->nodeValue , PHP_EOL;
}
$arr = dom_to_array($div[0]);
// $arr = dom2array($div[0]);
// var_dump($arr);
// var_dump($arr['div']['#text'][0]);

$s = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
        <response>
            <resData foo="1">
                <contact:infData xmlns:contact="http://example.com/contact-1.0" bar="1">
                    <contact:status s="value1"/>
                    <contact:status s="value2"/>
                    <contact:status s="value3"/>
                    <contact:status s="value4"/>
                </contact:infData>
            </resData>
        </response>';

$xml = new DOMDocument();
$xml->loadXML($s);
$xmlArray = xml_to_array($xml);
echo '<pre>';
print_r($xmlArray);
echo '</pre>';
echo date('Y-m-d H:i:s', 1536562291) ,'<br>', date('Y-m-d H:i:s', 1545740404);
$i = '2.1.1';
echo '<br>', (float)$i;

$codes = explode(',', '4,6,3,9,7,2,5,10,1,8');
var_dump($codes);
foreach ($codes as $codeKey => &$codeValue) {
    $codeValue = str_pad($codeValue, 2, 0, STR_PAD_LEFT);
}
var_dump($codes);
$number = implode(' ', $codes);
echo $number;
if (!preg_match('`^([01]\d\s){9}[01]\d$`Ui', $number)) {
    echo 'bill';
} else echo 'ivy';
echo '<br>', substr(md5('res5'), 8, 16) ,'<br>', substr(md5('latest5'), 8, 16);

function sumColor($color)
    {
        $c_arr = [1 => 0, 2 => 0, 3 => 0];
        $r = $s = end($color);
        for ($i=0; $i < 7; $i++) { 
            if ($color[$i] == 1) $c_arr[1]++;
            elseif ($color[$i] == 2) $c_arr[2]++;
            elseif ($color[$i] == 3) $c_arr[3]++;
        }
        $max = max($c_arr);
        $min = min($c_arr);
        if ($max > 3 || ($max == 3 && $min == 2)) {
            $r = array_search($max, $c_arr);
        } elseif (array_search($min, $c_arr) == $s) {
            $r = 4;
        }
        return $r;
    }
echo '<br>ivy1234:', sumColor([2,2,1,1,1,2,3]);

$a = array (
  592 =>
  array (
    'member_link_id' => 592,
    'amount' => '300000.00',
  ),
);
echo '<br>', array_sum(array_column($a, 'amount'));
echo '<br>', strtotime(date('2018-12-29'));
preg_match('/[\w][\w-]*\.(?:com\.cn|com|cn|co|net|org|gov|cc|biz|info)(\?|\/|$)/isU', 'http://www.xy0test.com', $addurl);
var_dump($addurl);

if (!empty($addurl)) {
    echo str_replace($addurl[1], '', $addurl[0]);
}
if ('010' == '0010') {
    echo 'hello 8xian:', trim(addslashes("001'")), intval(-1);
} else echo 'hello bill';
echo abs(-15);

$v = '/images_fh/upload/2018/12/1545909171359.gif';
preg_match('@.*(images_fh.*)$@', $v, $macth);
var_dump($macth);

$a = [['name' => 'bill', 'a' => 'aa'], ['name' => 'i', 'b' => 'bb']];
echo reset($a)['name'];
echo '<br>', date('Y-m-d H:i:s');

$tmpArr = explode(',', '2,9,5,1,8,6,4,7,3,10');
for ($i=0; $i < 10; $i++) { 
    $tmpArr[$i] = sprintf('%02d', $tmpArr[$i]);
}
$tmpNumber = implode(' ', $tmpArr);
if (!preg_match('`^([01]\d\s){9}[01]\d$`Ui', $tmpNumber)) 
    echo 'hello bill';
else echo 'hello joker';

if (preg_match('`^(\d{2}\s{1}){9}\d{2}$`', $tmpNumber))
    echo 'hello world';
else echo 'hello ivy';

$x = $y = $z = $i = 0;
$arr = [];
for ($x=0; $x < 10; $x++) { 
    for ($y=0; $y < 10; $y++) { 
        for ($z=0; $z < 10; $z++) { 
            $sum = $x + $y + $z;
            if (isset($arr[$sum])) $arr[$sum]++;
            else $arr[$sum] = 1;
            $i++;
        }
    }
}
echo '<br>', $i;
echo date('Y-m-d H:i:s', 1548759835) ,'<br>', date('Y-m-d H:i:s', 1548759942);
// var_dump(preg_match('`^[a-zA-Z0-9_\-]{6,20}$`', '1234789999'));
// 
// hset(lottery, issue, info);
// set(lottery, issue);
// zadd(lottery, issue, )
// hget(key, field) 获取hash，key键、field域
// hset(key, field, value) 设置hash，value值
// zadd(key, score, member) 设置sorted set有序集合，score分（排序分值，可重复），member成员（值，唯一）
// zremrangebyrank(key, start, stop) 移除sorted set，start开始索引，stop停止索引，按rank移除
// zremrangebyscore(key, min, max) 根据score移除key的member，score介于min和max之间
// zrem(key, member, member...) 移除key的member
// zrange(key, start, stop, [withscores]) 获取有序集合（递增），withscores带上分数
// zrevrange(key, start, stop, [withscores]) 获取有序集合（递减），withscores带上分数
// zrangebyscore(key, min, max, [withscores]) 获取有序集合，分数介于min和max之间（顺序）
// zrevrangebyscore(key, max, min, [withscores]) 获取有序集合，分数介于min和max之间(逆序)
// zcard(key) 获取有序集合个数
// zcount(key, min, max) 获取有序集合分数在min和max之间的成员数
// zincrby(key, increment, member) 为member成员的score值加上增量increment
// zrank(key, member) 获取member的排名，从0开始，递增
// zrevrank(key, member) 获取member的排名，从0开始，递减
// zscore(key, member) 获取member的score
// zunionstore(key, destination, numkeys, key, [key]...) numkeys个key的并集放入destination
// zinterstore(key, destination, numkeys, key, [key]...) numkeys个key的交集放入destination
// result_pc 北京PC28开奖结果
// yc_pc 北京PC28预测
// result_jnd 加拿大PC28
// yc_jnd
// result_xj_10 新疆PC28 新疆时时彩
// yc_xj
// result_cq_10 重庆PC28 重庆时时彩
// yc_cq
// result_pk_10 北京PK10
// result_nc_10 幸运农场
// result_gd_10 广东快乐十分
// result_six_10 六合彩
// re11_six 六合彩
// result_dm
// 抓奖-存入数据库（mysql、redis）-显示
// 不断读redis
// redis应用
// 限制接口请求频率
// 雏鹰企业、瞪羚企业、潜在独角兽企业、独角兽企业、平台生态型龙头企业
// 47.90.98.84 5922
// 47.52.65.220 2259
// 47.52.72.102 2259
// 描述
// 请求地址
// 请求方法
// 请求参数
// 响应参数
// 请求示例

// 公共请求参数

// 公共响应参数
// code 0success 1error
// msg

// hset(lottery1-10, issue, info);
// hvals(lottery1-10); // 获取所有info
// hkeys(lottery1-10); // 获取所有issue
// hget(lottery1-10, issue); // 根据issue获取info
// zadd(latest, issue, lottery1-10); // 保存最新的奖期，插入时设置
// zscore(latest, lottery1-10); // 获取某个彩种最新奖期
// in_array(issue, hkeys); // 没有则加
// hset(lottery1-10, i, issue); // 获取单期时设置
// in_array(zscore, hvals); // 没有则设置，使用最新奖期检测
// 默认保存200期的数据，定期清理超过200期数据
// 
// 拉取奖期时插入数据库和redis
// 
// 
// 

// 
// 获取奖励
// 放在user表时count() > 5，根据member_link_id在member_link找到user_id
// 放在member_link表时根据user_id在member_link找到记录，count(members) > 5
// 报表统计
// member_link
// id, user_id, code, old_code(buyaole), link(不要吧？), members(buyaole,在users表加个字段还是直接用这个呢？), member_num(buyaole), normal_num(不要了), remark(buyaole), created, creater, updated, updater
// 
// 
// 
// 游戏平台-Java-PHP-
// 钱包中心：提供接口，不对外网开放
// 玩游戏：选择平台-点击进入游戏大厅-PHP-Java-进入第三方游戏大厅
// 游戏记录：
// 中间件
// 转账记录：用户余额转入转出游戏平台，充值、提款（打码稽核）
// api中心：对前台提供数据
// 代理中心：返水、占成
// 会员中心：返水
// 
// 开奖网
// 抓奖
// 彩种
// 开奖详情
// 刮奖
// 开奖结果
// 数据统计
// 露珠走势
// 行情走势
// 预测
// 技巧/资讯
// 
// 购彩大厅-彩种-玩法组-玩法-赔率-玩法说明
// 开奖结果
// 开奖走势
// 彩种分类
// 自营彩、非自营彩
// 彩票资讯
// 
// 注册（会员管理、邀请码、层级管理）
// 登录（会员在线、强制登出）
// 充值（充值管理、充值优惠）
// 投注（投注记录、投注返水、代理输赢占成、彩种、玩法、追号、抓号、开奖、判奖、派奖、结算）
// 提现（稽核）
// 
// 会员
// 等级
// 特权
// 积分商城
// 
// 入口
// PC(appfront)
// wap(apphtml5)
// Vue(appserver)
// backend(appadmin)
// console(console)
// 第三方api(appapi)
// 
// 个人中心
//  个人账变
//  个人充提/充值/提现
//  登录/资金密码修改
//  银行卡资料管理
//  投注记录
//  追号记录
//  站内信
//  电子钱包
// 
// 代理中心
//  会员管理
//  新增会员/代理/邀请码
//  佣金系统
//  团队投注报表
//  团队存提报表
//  团队盈亏报表
//  团队账变报表
//  团队汇总报表
// 
// 选择彩种
// 轮播图
// 用户菜单
// 推荐彩种
// 六合彩特码推荐
// 幸运走势
// 中奖排行
// 彩票资讯
// 帮助导航
//  帮助中心
// 
// 购彩大厅
//  按照彩种区分
//  开奖详情
//  倒计时
//  玩法
//  最近开奖
//  今日投注
//  返点
//  奖金
//  投注/追号
//  开奖提醒
// 开奖结果
// 手机购彩
// 开奖走势
//  走势图
// 优惠活动
// 彩票资讯
// 客服
// 
// 弄清楚边界
// 
// 博客
// 后台模板
// 用户、用户组、权限组管理
// crm
// 彩票资讯
// 博客+笔记
// 
// 尽量参与到每一个环节
// 
// 开会
// 列举所有问题，
// 提出解决方案，
// 画草图讨论，
// 并做好会议纪要
// 
// 杀开判派
// 抓开判派
// 
// xiecheng
// serverless
// 
// 1688.com
// login.1688.com 登录
// s.1688.com 搜索
// 
// 有赞
// udesk
// 
// 腾讯分分彩出现数据超过2期（含2期）未更新，重复号码现象，当期将不出开奖结果，直至数据恢复正常
// 
// if u change nothing,nothing will be changed.