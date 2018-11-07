<?php
    /*//initialize curl
    $ch = curl_init();
    //set headers
    $headers = array(
    'X-Operator: xxx',
    'X-Key: xxx'
    );
    //set url
    curl_setopt($ch, CURLOPT_URL, 'http://api01.oriental-game.com:8085/token');
    //set header to curl
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //Timeout in seconds
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    //curl exercute
    $authToken = curl_exec($ch);
    //json decode
    $obj = json_decode($authToken, true);
    //get token
    $token = $obj['data']['token'];
    // echo $token;
    var_dump($obj);
    //print token
    //echo $authToken;*/

// https://xy0.4188886.com/index.jsp?&a=login 测试前端
// https://91966.com 正式前端

$url = 'api01.oriental-game.com:8085/';
$reportUrl = 'mucho.oriental-game.com:8057/';
$operatorId = 'mog003';
$key = '4k706tpYPT';
echo 'asdfsadfa';
// step1获取token
$res = curl_opt($url .'token', '', [], 'get', $operatorId, $key);
echo '<br>xxxx';
$token_json = json_decode($res);
if ($token_json->status != 'success') {
    var_dump($token_json);
    exit();
}
$token = $token_json->data->token;
// var_dump($token);

/*$res = curl_opt($url .'game-providers', $token);
$res = json_decode($res);
echo '<br>', 'gongyingshangliebiao';
debug($res);*/

/*// 取得游戏列表
$res = curl_opt($url .'games', $token);
$res = json_decode($res);
echo '<br>youxiliebiao';
debug($res);*/

// step2查看游戏供应商(范例游戏商id= 5)
$provider_id = 1;
/*$res = curl_opt($url .'game-providers/'. $provider_id, $token);
$res = json_decode($res);
debug($res);*/

/*// step3查看游戏与代号(范例游戏id=332)
$game_id = 1;
$res = curl_opt($url .'games/'. $game_id, $token);
$res = json_decode($res);
debug($res);
$game_code = $res->data->game->code;
echo $game_code;*/

/*// step4查看玩家username 用于产生游戏密钥
$res = curl_opt($url .'players', $token);
$res = json_decode($res);
debug($res);
$username = $res->data->players[0]->username;*/
$username = 'bill666';
echo $username;

$res = curl_opt($url ."game-providers/$provider_id/balance", $token, ['username' => $username]);
$res = json_decode($res);
debug($res);

/*// step5产生游戏密钥(key)
$res = curl_opt($url ."game-providers/$provider_id/games/$game_code/key", $token, ['username' => $username]);
$res = json_decode($res);
debug($res);
if ($res->status != 'success') {
    debug(['username' => $username]);
    exit('获取游戏秘钥失败');
}
$game_key = $res->data->key;
echo $game_key;

// step6 Play game
$res = curl_opt($url ."game-providers/$provider_id/play", $token, ['key' => $game_key, 'type' => 'desktop']);
$res = json_decode($res);
debug($res);
if ($res->status != 'success') {
    exit('获取游戏链接失败');
}
$url = $res->data->url;
echo "<a href='$url'>进入游戏</a>";*/

// 用户注册
$info = [
    'username' => 'jeff@pro', // 用戶名. 最小長度: 5 最大長度: 22
    'currency' => 'CNY', // 匯率代碼 預設CNY 允許值: "CNY", "IDR", "JPY", "KRW", "MYR", "THB", "TWD", "USD", "VND"
    'country' => 'China', // 國籍代碼 預設China
    'fullname' => 'secret', // 使用者全名
    'email' => 'secret@gmail.com', // 使用者郵箱
    'language' => 'cn', // 遊戲預設語言 預設en 允許值: "en - 英語", "cn - 簡體中文", "kr - 韓語"
    'birthdate' => date('Y-m-d'), // 使用者出生日期 ISO-8601 格式
];
$res = curl_opt($url .'register', $token, $info, 'post');
echo '<pre>';
print_r($info);
var_dump($res);
echo '</pre>';
function chgUTC($d) 
{
    // $t = strtotime('-8 hours', strtotime($d));
    // return date('Y-m-d H:i:s', $t);
    return date('Y-m-d H:i:s', strtotime('-8 hours', strtotime($d)));
}
/*$cond = [
    'Operator' => $operatorId, // X-Operator 經營方代碼
    'Key' => $key, // X-Key 經營方API金鑰
    'SDate' => chgUTC('2018-03-22 14:10:00'), // 转换UTC 格式 : YYYY-MM-DD HH:MM:SS, 時區為 : GMT+0 "查詢區間區間限制為十分鐘"
    'EDate' => chgUTC('2018-03-22 14:20:00'), // 转换UTC 格式 : YYYY-MM-DD HH:MM:SS, 時區為 : GMT+0 "查詢區間區間限制為十分鐘"
    // 'Provider' => 'og', // 可選項，遊戲供應商 允許值: "og"
    // 'PlayerID' => $username, // 可選項，玩家賬號
    // 'TransferCode' => , // 可選項，交易紀錄編號(客戶提供的備註或系統生成皆可)
    // 'Exact' => , // 可選項，預設True True - PlayerID 精確查詢 False - PlayerID 模糊查詢 允許值: "True", "False"
];
$res = curl_post($reportUrl .'Transfer', $cond);
$res = json_decode($res, true);
debug($res);*/


/**
 * 打印信息
 * @param  mixed $msg
 * @return [type]
 */
function debug($msg = '')
{
    echo '<pre>';
    print_r($msg);
    echo '</pre>';
}

function curl_post($url, $data = [])
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HEADER, 0); // 不输出header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 不直接打印结果而是返回结果
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Timeout in seconds
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); //取消身份验证
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

    $res = curl_exec($ch);

    // 错误处理
    if (curl_errno($ch)) {
        // $info = curl_getinfo($ch);
        // var_dump($info);
        exit('Curl error: ' . curl_error($ch));
    }
    curl_close($ch); // 关闭句柄

    return $res;
}

/**
 * curl操作
 * @param  string 请求链接
 * @param  string token
 * @param  array  请求数据
 * @param  string 请求方式：get、post
 * @param  string 获取token时的经营方代码
 * @param  string 获取token时的key
 * @return mixed
 */
function curl_opt($url, $token = '', $data = [], $method = 'get', $operatorId = '', $key = '')
{
    // initialize curl
    $ch = curl_init();
    // set headers
    if ($token) {
        $headers = [
            "X-Token: $token"
        ];
    }else{
        $headers = [
            "X-Operator: $operatorId",
            "X-Key: $key"
        ];
    }
    
    switch ($method) {
        case 'get':
            $separate = $data ? '?' : '';
            curl_setopt($ch, CURLOPT_URL, $url . $separate . http_build_query($data)); // set url
            break;
        case 'post':
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            break;
        default:
            exit('不支持的请求方式！');
            break;
    }
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // set header to curl
    curl_setopt($ch, CURLOPT_HEADER, 0); // 不输出header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 不直接打印结果而是返回结果
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Timeout in seconds
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); //取消身份验证
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

    $res = curl_exec($ch);
    $info = curl_getinfo($ch);

    // 错误处理
    if (curl_errno($ch)) {
        // $info = curl_getinfo($ch);
        // var_dump($info);
        exit('Curl error: ' . curl_error($ch));
    }
    curl_close($ch); // 关闭句柄

    return $res;
}
?>