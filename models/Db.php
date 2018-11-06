<?php
namespace models;

/**
* 数据库操作类
*/
class Db
{
    public $dbh;

    public function __construct()
    {
        $conf = require CONF_PATH .'main'. EXT;
        try {
            // PDO连接
            $this->dbh = new \PDO("mysql:host={$conf['db_host']};dbname={$conf['db_name']};charset={$conf['db_charset']};port={$conf['db_port']}", $conf['db_user'], $conf['db_pass']);
        } catch (PDOException $e) {
            exit('error: '. $e->getMessage());
        }
    }

    /**
     * 获取一列数据
     * @param  string sql语句
     * @param  integer 获取第n列数据
     * @return array
     */
    public function queryCol($sql, $col = 0)
    {
        $query = $this->dbh->query($sql);
        $query->setFetchMode(\PDO::FETCH_NUM);
        // return $query->fetchColumn($col);
        $res = $query->fetchAll();
        $arr = [];
        foreach ($res as $v) {
            $arr[] = $v[$col];
        }
        return $arr;
    }

    /**
     * 执行sql语句
     * @param  string sql语句
     * @return int 受影响行数
     */
    public function execSql($sql)
    {
        $nums = $this->dbh->exec($sql);
        return $nums;
    }

    public function closeDb()
    {
        $this->dbh = null;
    }
}