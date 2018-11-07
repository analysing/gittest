<?php
require_once 'Mysql.class.php';
$conf = require 'compare_method_conf.php';

$db = new Mysql($conf);
$mg_tbl = 'method_groups';
$m_tbl = 'methods';
$pg_tbl = 'prize_groups';
$p_tbl = 'prizes';
$s_lottery_id = $conf['s_lottery_id'];
$t_lottery_id = $conf['t_lottery_id'];
$sql = "select * from $mg_tbl where 1 ";
$s_data = $db->fetchAll($sql .'and lottery_id = '. $s_lottery_id);
$t_data = $db->fetchAll($sql .'and lottery_id = '. $t_lottery_id);
if (($count = count($s_data) - count($t_data)) <= 0) {
    echo '都一样或源数据行数少于目标数据';exit();
}
$mg_max_id = $db->getAutoIncrememntId($conf['db_name'], $mg_tbl);
$m_max_id = $db->getAutoIncrememntId($conf['db_name'], $m_tbl);
$t_name_arr = array_column($t_data, 'name');

$pg_id = $db->fetchCol("select pg_id from $pg_tbl where lottery_id = $t_lottery_id");
$is_write_file = $conf['is_write_file'];
$sql_file = $conf['sql_file'];
if (!is_writable($sql_file)) {
    echo '文件不能写入';exit();
}
$is_write_file && file_put_contents($sql_file, '');

$i = $j = 0;
foreach ($s_data as $k => $v) {
    if (!in_array($v['name'], $t_name_arr)) {
        $mg_id = $mg_max_id + $i;
        $mg_sql = "insert into $mg_tbl (`mg_id`, `lottery_id`, `name`, `group_tag`, `is_merge`, `description`, `sort`, `status`, `ts`) values ($mg_id, $t_lottery_id, '{$v['name']}', '{$v['group_tag']}', '{$v['is_merge']}', '{$v['description']}', '{$v['sort']}', '{$v['status']}', '{$v['ts']}');";
        $is_write_file && file_put_contents($sql_file, $mg_sql ."\r\n\r\n", FILE_APPEND);
        echo $mg_sql .'<br>';
        /*if (!($mg_res = $db->exec($mg_sql))) {
            echo '出错了';break;
        }
        $mg_id = $db->getLastInsId();*/
        $sql = "select * from methods where lottery_id = {$v['lottery_id']} and mg_id = {$v['mg_id']}";
        $s_m_data = $db->fetchAll($sql);
        $m_sql_prefix = "insert into $m_tbl (`method_id`, `lottery_id`, `mg_id`, `name`, `cname`, `description`, `max_comb`, `max_money`, `levels`, `is_lock`, `expands`, `field_def`, `can_input`, `status`, `method_property`, `sort`, `ts`) values ";
        foreach ($s_m_data as $kk => $vv) {
            $m_id = $m_max_id + $j;
            $m_sql = "{$m_sql_prefix}($m_id, $t_lottery_id, $mg_id, '{$vv['name']}', '{$vv['cname']}', '{$vv['description']}', '{$vv['max_comb']}', '{$vv['max_money']}', '{$vv['levels']}', '{$vv['is_lock']}', '{$vv['expands']}', '{$vv['field_def']}', '{$vv['can_input']}', '{$vv['status']}', '{$vv['method_property']}', '{$vv['sort']}', '{$vv['ts']}');";
            $is_write_file && file_put_contents($sql_file, $m_sql ."\r\n\r\n", FILE_APPEND);
            echo $m_sql .'<br>';
            $p_sql = "insert into $p_tbl (`lottery_id`, `pg_id`, `method_id`, `level`, `prize`, `top_rebate`, `ts`) values ";
            $s_p_data = $db->fetchAll("select * from $p_tbl where lottery_id = {$v['lottery_id']} and method_id = {$vv['method_id']} and prize <> 0");
            foreach ($s_p_data as $kkk => $vvv) {
                $p_sql .= "($t_lottery_id, $pg_id, $m_id, {$vvv['level']}, {$vvv['prize']}, {$vvv['top_rebate']}, '{$vvv['ts']}'),";
            }
            $p_sql = rtrim($p_sql, ',') .';';
            $is_write_file && file_put_contents($sql_file, $p_sql ."\r\n\r\n", FILE_APPEND);
            echo $p_sql .'<br><br>';
            $j++;
        }
        /*if (!($m_res = $db->exec($m_sql))) {
            echo '又出错了';break;
        }*/
        $is_write_file && file_put_contents($sql_file, "\r\n\r\n", FILE_APPEND);
        echo '<br>';
        $i++;
    }
}

echo '完了。';