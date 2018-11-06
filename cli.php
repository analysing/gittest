<?php
require_once 'functions.php';
require_once 'Mysql.class.php';
$conf = require_once 'config.php';
$now = time();
$st = date('Y-m-d H:i:s', strtotime('-10 minutes', $now));
$et = date('Y-m-d H:i:s', $now);
echo chgUTC($st) ,' ', chgUTC($et);
// 转账记录begin
$cond = [
    'Operator' => $conf['testOperatorId'], // X-Operator 經營方代碼
    'Key' => $conf['testKey'], // X-Key 經營方API金鑰
    'SDate' => chgUTC($st), // 转换UTC 格式 : YYYY-MM-DD HH:MM:SS, 時區為 : GMT+0 "查詢區間區間限制為十分鐘"
    'EDate' => chgUTC($et), // 转换UTC 格式 : YYYY-MM-DD HH:MM:SS, 時區為 : GMT+0 "查詢區間區間限制為十分鐘"
    // 'Provider' => 'og', // 可選項，遊戲供應商 允許值: "og"
    // 'PlayerID' => $username, // 可選項，玩家賬號
    // 'TransferCode' => , // 可選項，交易紀錄編號(客戶提供的備註或系統生成皆可)
    // 'Exact' => , // 可選項，預設True True - PlayerID 精確查詢 False - PlayerID 模糊查詢 允許值: "True", "False"
];
// 测试
$test_res = curl_post($conf['testReportUrl'] .'Transfer', $cond);
$test_res = json_decode($test_res, true);
transfer($test_res, $conf, 0);
sleep(12);
/*Array
(
    [Message] => Only one query is allowed every 10 seconds.
    [State] => Error
)*/

// 正式
$st = date('Y-m-d H:i:s', strtotime('-10 minutes', $now));
$et = date('Y-m-d H:i:s', $now); // 拉取15分钟前的数据
$cond['Operator'] = $conf['operatorId'];
$cond['Key'] = $conf['key'];
$cond['SDate'] = chgUTC($st);
$cond['EDate'] = chgUTC($et);
$res = curl_post($conf['reportUrl'] .'Transfer', $cond);
$res = json_decode($res, true);
transfer($res, $conf);
sleep(12);
// 转账记录end

// 注单查询begin
$test_res = $res = [];
$st = date('Y-m-d H:i:s', strtotime('-25 minutes', $now));
$et = date('Y-m-d H:i:s', strtotime('-15 minutes', $now)); // 拉取15分钟前的数据
$cond = [
	'Operator' => $conf['testOperatorId'], // X-Operator 經營方代碼
	'Key' => $conf['testKey'], // X-Key 經營方API金鑰
	'SDate' => chgUTC($st), // 转换UTC 格式 : YYYY-MM-DD HH:MM:SS, 時區為 : GMT+0 "查詢區間區間限制為十分鐘"
    'EDate' => chgUTC($et), // 转换UTC 格式 : YYYY-MM-DD HH:MM:SS, 時區為 : GMT+0 "查詢區間區間限制為十分鐘"
    // 'Provider' => 'og', // 可選項，遊戲供應商 允許值: "og"
    // 'PlayerID' => $username, // 可選項，玩家賬號
    // 'TransactionNumber' => , // 可選項，注單編號
    // 'Exact' => , // 可選項，預設True True - PlayerID 精確查詢 False - PlayerID 模糊查詢 允許值: "True", "False"
];
// 测试
$test_res = curl_post($conf['testReportUrl'] .'Transaction', $cond);
$test_res = json_decode($test_res, true);
transaction($test_res, $conf, 0);
sleep(12);

// 正式
$st = date('Y-m-d H:i:s', strtotime('-20 minutes', $now));
$et = date('Y-m-d H:i:s', strtotime('-10 minutes', $now)); // 拉取15分钟前的数据
$cond['Operator'] = $conf['operatorId'];
$cond['Key'] = $conf['key'];
$cond['SDate'] = chgUTC($st);
$cond['EDate'] = chgUTC($et);
$res = curl_post($conf['reportUrl'] .'Transaction', $cond);
$res = json_decode($res, true);
transaction($res, $conf);
// 注单查询end
echo 'asdf';

function transfer($test_res, $conf, $is_formal = 1)
{
	$dbh = new Mysql($conf);
	if (!isset($test_res['State']) && !empty($test_res)) {
		$file = __DIR__ .'/transfer.txt';
		$file = str_replace("\\", '/', $file);
		$fp = fopen($file, 'w+');
		foreach ($test_res as $k => $v) {
			$data = $v;
			unset($data['id']);
			$data['res_id'] = $v['id'];
			$data['res_username'] = $v['username'];
			$data['username'] = strtolower(str_replace('MOG_', '', $v['username']));
			$data['createtime'] = substr($v['createtime'], 6, -5);
			$data['is_formal'] = $is_formal;
			fwrite($fp, implode("\t", $data). "\n");
		}
		fclose($fp);
		$tbl = 'og_transfer';
		$col = implode(',', array_keys($data));
		$num = $dbh->exec("load data infile '$file' ignore into table $tbl CHARACTER SET {$conf['db_charset']} ($col)");
		// unlink($file);
		// echo $num;
	}
}

function transaction($test_res, $conf, $is_formal = 1)
{
	$dbh = new Mysql($conf);
	if (!isset($test_res['State']) && !empty($test_res)) {
		$file = __DIR__ .'/transaction.txt';
		$file = str_replace("\\", '/', $file);
		$fp = fopen($file, 'w+');
		foreach ($test_res as $k => $v) {
			$data = $v;
			$data['username'] = strtolower(str_replace('mog_', '', $v['membername']));
			$data['bettingdate'] = substr($v['bettingdate'], 6, -5);
			$data['is_formal'] = $is_formal;
			fwrite($fp, implode("\t", $data). "\n");
		}
		fclose($fp);
		$tbl = 'og_transaction';
		$col = implode(',', array_keys($data));
		$num = $dbh->exec("load data infile '$file' ignore into table $tbl CHARACTER SET {$conf['db_charset']} ($col)");
		unlink($file);
	}
}

/**
* test
*/
class P
{
    
    function __construct()
    {
        echo 'chushihuachenggong.';
    }

    public function say()
    {
        echo 'hello';
    }
}

$p = new P();
$p->say();

echo 'there are  ', $argc ,' parameters';
print_r($argv);
