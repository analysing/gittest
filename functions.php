<?php
if (!function_exists('curl_post')) {
	/**
	 * post请求
	 * @param  string $url  请求地址
	 * @param  array  $data 请求参数
	 * @return mixed       请求结果
	 */
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
}

if (!function_exists('curl_opt')) {
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

	    // 错误处理
	    if (curl_errno($ch)) {
	        // $info = curl_getinfo($ch);
	        // var_dump($info);
	        exit('Curl error: ' . curl_error($ch));
	    }
	    curl_close($ch); // 关闭句柄

	    return $res;
	}
}

if (!function_exists('debug')) {
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
}

if (!function_exists('chgUTC')) {
	/**
	 * PRC转UTC时间
	 * @param  string $d 时间，格式: YYYY-MM-DD HH:MM:SS
	 * @return string    转换后时间，格式: YYYY-MM-DD HH:MM:SS
	 */
	function chgUTC($d) 
	{
	    // $t = strtotime('-8 hours', strtotime($d));
	    // return date('Y-m-d H:i:s', $t);
	    return date('Y-m-d H:i:s', strtotime('-8 hours', strtotime($d)));
	}
}

if (!function_exists('record_log')) {
	function record_log($msg)
	{
		
	}
}

if (!function_exists('combination')) {
    /**
     * 组合枚举
     * @param  array $a 一维数组
     * @param  integer $m 每组元素个数
     * @return array    二维数组
     */
    function combination($a, $m) {
        $r = [];

        $n = count($a);
        if ($m <= 0 || $m > $n) {
            return $r;
        }

        for ($i=0; $i<$n; $i++) {
            $t = array($a[$i]);
            if ($m == 1) {
                $r[] = $t;
            } else {
                $b = array_slice($a, $i+1);
                $c = combination($b, $m-1);
                foreach ($c as $v) {
                    $r[] = array_merge($t, $v);
                }
            }
        }

        return $r;
    }
}

if (!function_exists('combo_count')) {
    /**
     * 获取组合个数，相当于数学c(m, n)
     * @param  integer $c c的下标
     * @param  integer $l c的上标
     * @return integer    组合个数
     */
    function combo_count($c, $l)
    {
        if ($c <= $l) return 1;
        $sum = $lsum = 1;
        for ($i=0; $i < $l; $i++) { 
            $sum *= ($c - $i);
            $lsum *= ($l - $i);
        }

        return $sum/$lsum;
    }
}

if (!function_exists('checkBankCard')) {
	/*
	* Description:  银行卡号Luhm校验
	* Luhm校验规则：16位银行卡号（19位通用）
	* 1.将未带校验位的 15（或18）位卡号从右依次编号 1 到 15（18），位于奇数位号上的数字乘以 2。
	* 2.将奇位乘积的个十位全部相加，再加上所有偶数位上的数字。
	* 3.将加法和加上校验位能被 10 整除。
	*/
	function checkBankCard($bankno)
	{
		if (!preg_match('`^\d+$`', $bankno)) {
			echo 'jjj';
			return false;
		}
		$len = strlen($bankno);
		$lastNum = substr($bankno, $len - 1, 1);                //取出最后一位（与luhm进行比较）
		$topNum = substr($bankno, 0, $len - 1);                 //根据卡号数取出前15或18位
		$topLen = strlen($topNum);
		$reverseNo = array();                               //存放前15位或18位的逆序数字
		$j = 0;
		//前15或18位倒序存进数组
		for ($i = $topLen - 1; $i >= 0; $i--) {
			$reverseNo[$j] = $topNum{$i};
			$j++;
		}
		$oddlt = array();                                   //奇数位*2的积 <9
		$oddgt = array();                                   //奇数位*2的积 >9
		$even = array();                                    //偶数位数组
		$revLen = count($reverseNo);
		for ($m = 0; $m < $revLen; $m++) {
			if (($m + 1) % 2 == 1) {//奇数位
				if (intval($reverseNo[$m]) * 2 < 9) {
					$oddlt[$m] = intval($reverseNo[$m]) * 2;
				} else {
					$oddgt[$m] = intval($reverseNo[$m]) * 2;
				}
			} else {//偶数位
				$even[$m] = $reverseNo[$m];
			}
		}
		$oddgt_child1 = array();                        //奇数位*2 >9 的分割之后的数组个位数
		$oddgt_child2 = array();                        //奇数位*2 >9 的分割之后的数组十位数
		$oddgtLen = count($oddgt);
		foreach ($oddgt as $k => $v) {
			$oddgt_child1[$k] = intval($oddgt[$k] % 10);
			$oddgt_child2[$k] = intval($oddgt[$k] / 10);
		}

		$sumOddlt = array_sum($oddlt);                       //奇数位*2 < 9 的数组之和
		$sumEven = array_sum($even);                         //偶数位数组之和
		$sumOddChild1 = array_sum($oddgt_child1);            //奇数位*2 >9 的分割之后的数组个位数之和
		$sumOddChild2 = array_sum($oddgt_child2);            //奇数位*2 >9 的分割之后的数组十位数之和
		//计算总和
		$sumTotal = $sumOddlt + $sumEven + $sumOddChild1 + $sumOddChild2;

		//计算Luhm值
		$key = intval($sumTotal) % 10 == 0 ? 10 : intval($sumTotal) % 10;
		$luhm = 10 - $key;
		echo '<br>', $lastNum ,' ', $luhm;

		if ($lastNum == $luhm) {
			return true;
		} else {
			return false;
		}
	}
}

function C($array, $base, $delimiter = '')
{
	if (!is_array($array) || count($array) < $base) {
		return array();
	} elseif (count($array) == $base) {   //相同只能一种可能，直接输出
		return array(implode($delimiter, $array));
	}

	if ($base == 1) {
		return $array;
	}

	$result = $resultIndex = array();
	$initStr = $teminalStr = '';
	for ($i = 0; $i < $base; $i++) {
		$teminalStr .= '1';
	}
	$initStr = $teminalStr;
	for ($i = $base; $i < count($array); $i++) {
		$initStr .= '0';
	}
	$resultIndex[] = $initStr;

	while (substr($initStr, -$base) != $teminalStr) {
		$parts = explode('10', $initStr, 2);
		$initStr = strOrder($parts[0], 'DESC') . '01' . $parts[1];
		$resultIndex[] = $initStr;
	}

	//替换转成对应元素
	foreach ($resultIndex as $v) {
		$tmp = '';
		for ($i = 0; $i < count($array); $i++) {
			if ($v{$i} == '1') {
				$tmp .= $array[$i] . $delimiter;
			}
		}
		$result[] = trim($tmp, $delimiter);
	}

	return $result;
}

function strOrder($str = '', $orderBy = 'ASC')
{
	if ($str == '' || !isset($str{1})) {
		return $str;
	}
	$parts = str_split($str);
	if ($orderBy == 'DESC') {
		rsort($parts);
	} else {
		sort($parts);
	}
	return implode('', $parts);
}

function getClientIP()
{
	$ip = $_SERVER['REMOTE_ADDR'];
	if (isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP'] != '') {
		$ip = explode(',', $_SERVER['HTTP_CLIENT_IP']);
		$ip = $ip[0];
	} elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '')
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

	return $ip;
}

function dom2array($node){
    $result = array();
    if($node->nodeType == XML_TEXT_NODE) {
        $result = $node->nodeValue;
    }
    else {
        if($node->hasAttributes()) {
            $attributes = $node->attributes;
            if(!is_null($attributes)) 
                foreach ($attributes as $index=>$attr) 
                    $result[$attr->name] = $attr->value;
        }
        if($node->hasChildNodes()){
            $children = $node->childNodes;
            for($i=0;$i<$children->length;$i++) {
                $child = $children->item($i);
                if($child->nodeName != '#text')
                if(!isset($result[$child->nodeName]))
                    $result[$child->nodeName] = dom2array($child);
                else {
                    $aux = $result[$child->nodeName];
                    $result[$child->nodeName] = array( $aux );
                    $result[$child->nodeName][] = dom2array($child);
                }
            }
        }
    }
    return $result;
} 

function dom_to_array($root)
{
    $result = array();

    if ($root->hasAttributes())
    {
        $attrs = $root->attributes;

        foreach ($attrs as $i => $attr)
            $result[$attr->name] = $attr->value;
    }

    if ($root->hasChildNodes()) {
        $children = $root->childNodes;

        if ($children->length == 1)
        {
            $child = $children->item(0);

            if ($child->nodeType == XML_TEXT_NODE)
            {
                $result['_value'] = $child->nodeValue;

                if (count($result) == 1)
                    return $result['_value'];
                else
                    return $result;
            }
        }

        $group = array();

        for($i = 0; $i < $children->length; $i++)
        {
            $child = $children->item($i);

            if (!isset($result[$child->nodeName]))
                $result[$child->nodeName] = dom_to_array($child);
            else
            {
                if (!isset($group[$child->nodeName]))
                {
                    $tmp = $result[$child->nodeName];
                    $result[$child->nodeName] = array($tmp);
                    $group[$child->nodeName] = 1;
                }

                $result[$child->nodeName][] = dom_to_array($child);
            }
        }
    }

    return $result;
}

function xml_to_array($root) {
    $result = array();

    if ($root->hasAttributes()) {
        $attrs = $root->attributes;
        foreach ($attrs as $attr) {
            $result['@attributes'][$attr->name] = $attr->value;
        }
    }

    if ($root->hasChildNodes()) {
        $children = $root->childNodes;
        if ($children->length == 1) {
            $child = $children->item(0);
            if ($child->nodeType == XML_TEXT_NODE) {
                $result['_value'] = $child->nodeValue;
                return count($result) == 1
                    ? $result['_value']
                    : $result;
            }
        }
        $groups = array();
        foreach ($children as $child) {
            if (!isset($result[$child->nodeName])) {
                $result[$child->nodeName] = xml_to_array($child);
            } else {
                if (!isset($groups[$child->nodeName])) {
                    $result[$child->nodeName] = array($result[$child->nodeName]);
                    $groups[$child->nodeName] = 1;
                }
                $result[$child->nodeName][] = xml_to_array($child);
            }
        }
    }

    return $result;
}

/**
 * 将数据转换成露珠形式
 * $data = ['a', 'a', 'a', 'a', 'b', 'b', 'a', 'b', 'b', 'b', 'b', 'b', 'b', 'b', 'b', 'b', 'a', 'a'];
 * ->
 * $arr = [
 *     0 => [0 => 'a', 1 => 'b', 2 => 'a', 3 => 'b', 4 => 'a'],
 *     1 => [0 => 'a', 1 => 'b', 3 => 'b', 4 => 'a'],
 *     2 => [0 => 'a', 3 => 'b'],
 *     3 => [0 => 'a', 3 => 'b'],
 *     4 => [3 => 'b'],
 *     5 => [3 => 'b'],
 *     6 => [3 => 'b'],
 *     7 => [3 => 'b'],
 *     8 => [3 => 'b'],
 * ];
 * @param  array $data 原始数据
 * @return array       处理后的数据
 */
function dewdrop_handle($data)
{
    $arr = [];
    $i = $j = 0;
    $z = $data[0];
    unset($data[0]);
    $arr[$i][$j] = $z;

    foreach ($data as $k => $v) {
        if ($v == $z) {
            $arr[++$i][$j] = $v;
        } else {
            $i = 0;
            $arr[$i][++$j] = $v;
            $z = $v;
        }
    }
    return $arr;
}

/**
 * 获取最后一个露珠
 * @param  array $data 露珠数据
 * @return array       0露珠，1数组下标，2数组下标
 */
function get_last_dewdrop($data)
{
    $c = count($data);
    $cc = count(current($data));
    $s = '';
    $x = $y = '';
    for ($i=0; $i < $c; $i++) { 
        $k = array_keys($data[$i]);
        if (end($k) == ($cc - 1)) {
            $x = $i;
            $y = $cc - 1;
            $s = $data[$x][$y];
        }
    }
    return [$s, $x, $y];
}

/**
 * 新增露珠
 * @param array $data 露珠数据
 * @param string $e    露珠
 */
function add_element($data, $e)
{
    list($dewdrop, $x, $y) = get_last_dewdrop($data);
    if ($e == $dewdrop) {
        $data[($x + 1)][$y] = $e;
    } else {
        $data[0][($y + 1)] = $e;
    }
    return $data;
}